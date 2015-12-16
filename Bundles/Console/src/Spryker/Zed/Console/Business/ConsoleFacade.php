<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Console\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;
use Symfony\Component\Console\Command\Command;

/**
 * @method ConsoleDependencyContainer getDependencyContainer()
 */
class ConsoleFacade extends AbstractFacade
{

    /**
     * @return Command[]
     */
    public function getConsoleCommands()
    {
        return $this->getDependencyContainer()->getConsoleCommands();
    }

}