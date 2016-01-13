<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\ShipmentCheckoutConnector\Business;

use Spryker\Zed\ShipmentCheckoutConnector\Business\Model\ShipmentOrderSaver;
use Spryker\Zed\ShipmentCheckoutConnector\Business\Model\ShipmentOrderHydrator;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\ShipmentCheckoutConnector\Business\Model\ShipmentOrderHydratorInterface;
use Spryker\Zed\ShipmentCheckoutConnector\Business\Model\ShipmentOrderSaverInterface;
use Spryker\Zed\ShipmentCheckoutConnector\ShipmentCheckoutConnectorConfig;
use Spryker\Zed\ShipmentCheckoutConnector\Persistence\ShipmentCheckoutConnectorQueryContainer;

/**
 * @method ShipmentCheckoutConnectorConfig getConfig()
 * @method ShipmentCheckoutConnectorQueryContainer getQueryContainer()
 */
class ShipmentCheckoutConnectorBusinessFactory extends AbstractBusinessFactory
{

    /**
     * @return ShipmentOrderHydratorInterface
     */
    public function createShipmentOrderHydrator()
    {
        $queryContainer = $this->getQueryContainer();

        return new ShipmentOrderHydrator($queryContainer);
    }

    /**
     * @return ShipmentOrderSaverInterface
     */
    public function createShipmentOrderSaver()
    {
        $queryContainer = $this->getQueryContainer();

        return new ShipmentOrderSaver($queryContainer);
    }

}