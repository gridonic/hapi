<?php


namespace Harvest\Model;

/**
 * Expense
 *
 * This file contains the class Expense
 *
 */

/**
 * Harvest Expense Object
 *
 * <b>Properties</b>
 * <ul>
 *   <li>created-at</li>
 *   <li>expense-category-id</li>
 *   <li>id</li>
 *   <li>is-billed</li>
 *   <li>is-closed</li>
 *   <li>notes</li>
 *   <li>project-id</li>
 *   <li>spent-at</li>
 *   <li>total-cost</li>
 *   <li>units</li>
 *   <li>updated-at</li>
 *   <li>user-id</li>
 *   <li>has-receipt</li>
 *   <li>receipt-url</li>
 * </ul>
 *
 */
class Expense extends Harvest
{
    /**
     * @var string expense
     */
    protected $_root = "expense";

}
