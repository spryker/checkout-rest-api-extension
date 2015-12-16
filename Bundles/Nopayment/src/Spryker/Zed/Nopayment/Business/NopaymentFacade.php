<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Nopayment\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;
use Orm\Zed\Sales\Persistence\SpySalesOrderItem;

/**
 * @method NopaymentDependencyContainer getDependencyContainer()
 */
class NopaymentFacade extends AbstractFacade
{

    /**
     * @param SpySalesOrderItem[] $orderItems
     *
     * @return array
     */
    public function setAsPaid(array $orderItems)
    {
        return $this->getDependencyContainer()->createNopaymentPaid()->setAsPaid($orderItems);
    }

    /**
     * @param SpySalesOrderItem $orderItem
     *
     * @return array
     */
    public function isPaid(SpySalesOrderItem $orderItem)
    {
        return $this->getDependencyContainer()->createNopaymentPaid()->isPaid($orderItem);
    }

}