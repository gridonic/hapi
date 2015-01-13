<?php


namespace Harvest\Model;

/**
 * InvoiceMessage
 *
 * This file contains the class InvoiceMessage
 *
 */

/**
 * Harvest InvoiceMessage Object
 *
 * <b>Properties</b>
 * <ul>
 *   <li>body</li>
 *   <li>created-at</li>
 *   <li>id</li>
 *   <li>include-pay-pal-link</li>
 *   <li>invoice-id</li>
 *   <li>send-me-a-copy</li>
 *   <li>sent-by</li>
 *   <li>sent-by-email</li>
 *   <li>subject</li>
 *   <li>thank-you</li>
 *   <li>full-recipient-list</li>
 * </ul>
 *
 */
class InvoiceMessage extends Harvest
{
    /**
     * @var string invoice-message
     */
    protected $_root = "invoice-message";

}
