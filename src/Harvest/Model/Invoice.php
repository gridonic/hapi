<?php


namespace Harvest\Model;

/**
 * Invoice
 *
 * This file contains the class Invoice
 *
 */

/**
 * Harvest Invoice Object
 *
 * <b>Properties</b>
 * <ul>
 *   <li>amount</li>
 *   <li>client-id</li>
 *   <li>client-key</li>
 *   <li>created-at</li>
 *   <li>currency</li>
 *   <li>discount</li>
 *   <li>discount-amount</li>
 *   <li>due-amount</li>
 *   <li>due-at</li>
 *   <li>due-at-human-format</li>
 *   <li>estimate-id</li>
 *   <li>id</li>
 *   <li>issued-at</li>
 *   <li>notes</li>
 *   <li>number</li>
 *   <li>period-end</li>
 *   <li>period-start</li>
 *   <li>purchase-order</li>
 *   <li>recurring-invoice-id</li>
 *   <li>state</li>
 *   <li>subject</li>
 *   <li>tax</li>
 *   <li>tax-amount</li>
 *   <li>tax2</li>
 *   <li>tax2-amount</li>
 *   <li>updated-at</li>
 *   <li>csv-line-items</li>
 * </ul>
 *
 */
class Invoice extends Harvest
{
    /**
     * @var string invoice
     */
    protected $_root = "invoice";

}
