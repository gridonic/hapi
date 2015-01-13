<?php


namespace Harvest\Model;

/**
 * Payment
 *
 * This file contains the class Payment
 *
 */

/**
 * Harvest Payment Object
 *
 * <b>Properties</b>
 * <ul>
 *   <li>amount</li>
 *   <li>created-at</li>
 *   <li>id</li>
 *   <li>invoice-id</li>
 *   <li>notes</li>
 *   <li>paid-at</li>
 *   <li>pay-pal-transaction-id</li>
 *   <li>recorded-by</li>
 *   <li>recorded-by-email</li>
 * </ul>
 *
 */
class Payment extends Harvest
{
    /**
     * @var string payment
     */
    protected $_root = "payment";

}
