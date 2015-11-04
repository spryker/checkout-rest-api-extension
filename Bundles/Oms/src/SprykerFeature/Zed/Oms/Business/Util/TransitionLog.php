<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace SprykerFeature\Zed\Oms\Business\Util;

use SprykerEngine\Zed\Kernel\Locator;
use SprykerFeature\Shared\Library\System;
use SprykerFeature\Zed\Oms\Business\Process\EventInterface;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Orm\Zed\Sales\Persistence\SpySalesOrderItem;
use Orm\Zed\Oms\Persistence\SpyOmsTransitionLog;
use SprykerFeature\Zed\Oms\Communication\Plugin\Oms\Command\CommandInterface;
use SprykerFeature\Zed\Oms\Communication\Plugin\Oms\Condition\ConditionInterface;
use SprykerFeature\Zed\Oms\Persistence\OmsQueryContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class TransitionLog implements TransitionLogInterface
{

    /**
     * @var OmsQueryContainerInterface
     */
    protected $queryContainer;

    /**
     * @var array
     */
    protected $logContext;

    /**
     * @var SpyOmsTransitionLog[]
     */
    protected $logEntities;

    /**
     * @param OmsQueryContainerInterface $queryContainer
     * @param array $logContext
     */
    public function __construct(OmsQueryContainerInterface $queryContainer, array $logContext)
    {
        $this->queryContainer = $queryContainer;
        $this->logContext = $logContext;
    }

    /**
     * @param EventInterface $event
     *
     * @return void
     */
    public function setEvent(EventInterface $event)
    {
        $nameEvent = $event->getName();

        if ($event->isOnEnter()) {
            $nameEvent .= ' (on enter)';
        }

        foreach ($this->logEntities as $logEntity) {
            $logEntity->setEvent($nameEvent);
        }
    }

    /***
     * @param SpySalesOrderItem[] $salesOrderItems
     *
     * @return void
     */
    public function init(array $salesOrderItems)
    {
        $this->logEntities = [];

        foreach ($salesOrderItems as $salesOrderItem) {
            $logEntity = $this->initEntity($salesOrderItem);
            $this->logEntities[$salesOrderItem->getIdSalesOrderItem()] = $logEntity;
        }
    }

    /**
     * @param SpySalesOrderItem $item
     * @param CommandInterface $command
     *
     * @return void
     */
    public function addCommand(SpySalesOrderItem $item, CommandInterface $command)
    {
        $this->logEntities[$item->getIdSalesOrderItem()]->setCommand(get_class($command));
    }

    /**
     * @param SpySalesOrderItem $item
     * @param ConditionInterface $condition
     *
     * @return void
     */
    public function addCondition(SpySalesOrderItem $item, ConditionInterface $condition)
    {
        $this->logEntities[$item->getIdSalesOrderItem()]->setCondition(get_class($condition));
    }

    /**
     * @param SpySalesOrderItem $item
     * @param string $stateName
     *
     * @return void
     */
    public function addSourceState(SpySalesOrderItem $item, $stateName)
    {
        $this->logEntities[$item->getIdSalesOrderItem()]->setSourceState($stateName);
    }

    /**
     * @param SpySalesOrderItem $item
     * @param string $stateName
     *
     * @return void
     */
    public function addTargetState(SpySalesOrderItem $item, $stateName)
    {
        $this->logEntities[$item->getIdSalesOrderItem()]->setTargetState($stateName);
    }

    /**
     * @param bool $error
     *
     * @return void
     */
    public function setIsError($error)
    {
        foreach ($this->logEntities as $logEntity) {
            $logEntity->setIsError($error);
        }
    }

    /**
     * @param string $errorMessage
     *
     * @return void
     */
    public function setErrorMessage($errorMessage)
    {
        foreach ($this->logEntities as $logEntity) {
            $logEntity->setErrorMessage($errorMessage);
        }
    }

    /**
     * @param SpySalesOrderItem $salesOrderItem
     *
     * @return SpyOmsTransitionLog
     */
    protected function initEntity(SpySalesOrderItem $salesOrderItem)
    {
        $logEntity = $this->getEntity();
        $logEntity->setOrderItem($salesOrderItem);
        $logEntity->setQuantity($salesOrderItem->getQuantity());
        $logEntity->setFkSalesOrder($salesOrderItem->getFkSalesOrder());
        $logEntity->setFkOmsOrderProcess($salesOrderItem->getFkOmsOrderProcess());

        $logEntity->setHostname(System::getHostname());

        $path = 'cli';
        $request = $this->getRequest();
        if (isset($request)) {
            $path = $request->getPathInfo();
        } else {
            if (isset($_SERVER['argv']) && is_array($_SERVER['argv'])) {
                $path = implode(' ', $_SERVER['argv']);
            }
        }
        $logEntity->setPath($path);

        //FIXME: get/post params
        $logEntity->setParams(['a' => 'todo']);

        return $logEntity;
    }

    /**
     * TODO Refactor: dependency
     *
     * @return Request
     */
    protected function getRequest()
    {
        return Locator::getInstance()->application()->pluginPimple()->getApplication()['request'];
    }

    /**
     * @param SpySalesOrderItem $salesOrderItem
     *
     * @return void
     */
    public function save(SpySalesOrderItem $salesOrderItem)
    {
        $this->logEntities[$salesOrderItem->getIdSalesOrderItem()]->save();
    }

    /**
     * @return void
     */
    public function saveAll()
    {
        foreach ($this->logEntities as $logEntity) {
            if ($logEntity->isModified()) {
                $logEntity->save();
            }
        }
    }

    /**
     * @param array $params
     * @param array &$result
     *
     * @return void
     */
    protected function getOutputParams(array $params, array &$result)
    {
        foreach ($params as $key => $value) {
            if (is_array($value)) {
                $this->getOutputParams($value, $result);
            } else {
                $result[] = $key . '=' . $value;
            }
        }
    }

    /**
     * @return SpyOmsTransitionLog
     */
    protected function getEntity()
    {
        return new SpyOmsTransitionLog();
    }

    /**
     * @param SpySalesOrder $order
     *
     * @return SpyOmsTransitionLog[]
     */
    public function getLogForOrder(SpySalesOrder $order)
    {
        return $this->queryContainer->queryLogForOrder($order)->find();
    }

}
