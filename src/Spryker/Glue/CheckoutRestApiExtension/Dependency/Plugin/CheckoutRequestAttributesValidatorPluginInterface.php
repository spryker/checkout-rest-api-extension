<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\CheckoutRestApiExtension\Dependency\Plugin;

use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;
use Generated\Shared\Transfer\RestErrorCollectionTransfer;

/**
 * Plugin allows validating RestCheckoutRequestAttributesTransfer's.
 *
 * Validation of `checkout-data`, `checkout` REST api requests.
 */
interface CheckoutRequestAttributesValidatorPluginInterface
{
    /**
     * Specification:
     * - Validates checkout-data, checkout Rest API requests attributes.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer $restCheckoutRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestErrorCollectionTransfer
     */
    public function validateAttributes(
        RestCheckoutRequestAttributesTransfer $restCheckoutRequestAttributesTransfer
    ): RestErrorCollectionTransfer;
}
