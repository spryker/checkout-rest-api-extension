<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Availability\Dependency\Facade;

interface AvailabilityToOmsFacadeInterface
{

    /**
     * @param string $sku
     *
     * @return \Orm\Zed\Sales\Persistence\SpySalesOrderItem
     */
    public function countReservedOrderItemsForSku($sku);

}