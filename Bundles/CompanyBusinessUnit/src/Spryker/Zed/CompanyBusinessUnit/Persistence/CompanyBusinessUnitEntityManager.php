<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CompanyBusinessUnit\Persistence;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\SpyCompanyBusinessUnitEntityTransfer;
use Orm\Zed\CompanyBusinessUnit\Persistence\SpyCompanyBusinessUnit;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \Spryker\Zed\CompanyBusinessUnit\Persistence\CompanyBusinessUnitPersistenceFactory getFactory()
 */
class CompanyBusinessUnitEntityManager extends AbstractEntityManager implements CompanyBusinessUnitEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    public function saveCompanyBusinessUnit(
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
    ): CompanyBusinessUnitTransfer {
        $entityTransfer = $this->getFactory()
            ->createCompanyBusinessUnitMapper()
            ->mapBusinessUnitTransferToEntityTransfer(
                $companyBusinessUnitTransfer,
                new SpyCompanyBusinessUnitEntityTransfer()
            );
        $entityTransfer = $this->saveBusinessUnit($entityTransfer);

        return $this->getFactory()
            ->createCompanyBusinessUnitMapper()
            ->mapEntityTransferToBusinessUnitTransfer(
                $entityTransfer,
                $companyBusinessUnitTransfer
            );
    }

    /**
     * @param int $idCompanyBusinessUnit
     *
     * @return void
     */
    public function deleteCompanyBusinessUnitById(int $idCompanyBusinessUnit): void
    {
        $this->getFactory()
            ->createCompanyBusinessUnitQuery()
            ->filterByIdCompanyBusinessUnit($idCompanyBusinessUnit)
            ->delete();
    }

    /**
     * @param int $idCompanyBusinessUnit
     *
     * @return void
     */
    public function clearParentBusinessUnit(int $idCompanyBusinessUnit): void
    {
        $this->getFactory()
            ->createCompanyBusinessUnitQuery()
            ->filterByFkParentCompanyBusinessUnit($idCompanyBusinessUnit)
            ->update(['FkParentCompanyBusinessUnit' => null]);
    }

    /**
     * This method is needed, because persistence mapper has problems mapping circular dependency
     *
     * @param \Generated\Shared\Transfer\SpyCompanyBusinessUnitEntityTransfer $businessUnitEntityTransfer
     *
     * @return \Generated\Shared\Transfer\SpyCompanyBusinessUnitEntityTransfer
     */
    protected function saveBusinessUnit(
        SpyCompanyBusinessUnitEntityTransfer $businessUnitEntityTransfer
    ): SpyCompanyBusinessUnitEntityTransfer {
        $spyBusinessUnit = new SpyCompanyBusinessUnit();
        $spyBusinessUnit->fromArray($businessUnitEntityTransfer->toArray());
        if ($businessUnitEntityTransfer->getIdCompanyBusinessUnit()) {
            $spyBusinessUnit->setNew(false);
        }

        $spyBusinessUnit->save();

        $savedBusinessUnitEntityTransfer = new SpyCompanyBusinessUnitEntityTransfer();
        $savedBusinessUnitEntityTransfer->fromArray($spyBusinessUnit->toArray());

        return $savedBusinessUnitEntityTransfer;
    }
}
