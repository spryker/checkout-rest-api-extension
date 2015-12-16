<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\PriceCartConnector\Business;

use Generated\Shared\Transfer\ChangeTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method PriceCartConnectorDependencyContainer getDependencyContainer()
 */
class PriceCartConnectorFacade extends AbstractFacade
{

    /**
     * @param ChangeTransfer $change
     * @param null $grossPriceType
     *
     * @return ChangeTransfer
     */
    public function addGrossPriceToItems(ChangeTransfer $change, $grossPriceType = null)
    {
        return $this->getDependencyContainer()->createPriceManager($grossPriceType)->addGrossPriceToItems($change);
    }

}