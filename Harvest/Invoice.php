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
 * Invoice
 *
 * This file contains the class Harvest_Invoice
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.harvest
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
 * @package com.mdbitz.harvest
 */
class Harvest_Invoice extends Harvest_Abstract {

    /**
     * @var string invoice
     */
    protected $_root = "invoice";

}