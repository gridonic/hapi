<?php
/*
 * copyright (c) 2009 MDBitz - Matthew John Denton - mdbitz.com
 *
 * This file is part of HarvestAPI.
 *
 * HarvestAPI is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * HarvestAPI is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with HarvestAPI. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Expense
 *
 * This file contains the class Harvest_Expense
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.harvest
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
 * @package com.mdbitz.harvest
 */
class Harvest_Expense extends Harvest_Abstract {

    /**
     * @var string expense
     */
    protected $_root = "expense";

}