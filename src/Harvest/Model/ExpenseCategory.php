<?php


namespace Harvest\Model;

/**
 * ExpenseCategory
 *
 * This file contains the class ExpenseCategory
 *
 */

/**
 * Harvest Expense Categroy Object
 *
 * <b>Properties</b>
 * <ul>
 *   <li>cache-version</li>
 *   <li>created-at</li>
 *   <li>deactivated</li>
 *   <li>id</li>
 *   <li>name</li>
 *   <li>unit-name</li>
 *   <li>unit-price</li>
 *   <li>updated-at</li>
 * </ul>
 *
 */
class ExpenseCategory extends Harvest
{
    /**
     * @var string expense-category
     */
    protected $_root = "expense-category";

}
