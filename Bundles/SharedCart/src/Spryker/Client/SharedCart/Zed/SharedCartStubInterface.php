<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\SharedCart\Zed;

use Generated\Shared\Transfer\QuotePermissionGroupCriteriaFilterTransfer;
use Generated\Shared\Transfer\QuotePermissionGroupResponseTransfer;

interface SharedCartStubInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuotePermissionGroupCriteriaFilterTransfer $criteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\QuotePermissionGroupResponseTransfer
     */
    public function getQuotePermissionGroupList(QuotePermissionGroupCriteriaFilterTransfer $criteriaFilterTransfer): QuotePermissionGroupResponseTransfer;
}
