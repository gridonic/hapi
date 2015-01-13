<?php


namespace Harvest\Model;

/**
 * InvoiceItemCategory
 *
 * This file contains the class InvoiceItemCategory
 *
 */

/**
 * Harvest InvoiceItemCategory Object
 *
 * <b>Properties</b>
 * <ul>
 *   <li>created-at</li>
 *   <li>id</li>
 *   <li>name</li>
 *   <li>updated-at</li>
 *   <li>use-as-expense</li>
 *   <li>use-as-service</li>
 * </ul>
 *
 */
class InvoiceItemCategory extends Harvest
{
    /**
     * @var string invoice-item-category
     */
    protected $_root = "invoice-item-category";

}
