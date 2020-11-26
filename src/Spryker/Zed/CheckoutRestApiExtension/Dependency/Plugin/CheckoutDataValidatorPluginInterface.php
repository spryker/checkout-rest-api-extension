<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CheckoutRestApiExtension\Dependency\Plugin;

use Generated\Shared\Transfer\CheckoutDataTransfer;
use Generated\Shared\Transfer\CheckoutResponseTransfer;

/**
 * Plugin allows validating CheckoutDataTransfer's.
 *
 * Validation of `checkout` REST api request.
 */
interface CheckoutDataValidatorPluginInterface
{
    /**
     * Specification:
     * - Validates checkout.
     * - Returns CheckoutResponseTransfer if there is invalid data in RestCheckoutRequestAttributesTransfer.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CheckoutDataTransfer $checkoutDataTransfer
     *
     * @return \Generated\Shared\Transfer\CheckoutResponseTransfer
     */
    public function validateCheckoutData(CheckoutDataTransfer $checkoutDataTransfer): CheckoutResponseTransfer;
}
