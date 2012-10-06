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
 * InvoiceItemCategory
 *
 * This file contains the class Harvest_InvoiceItemCategory
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.harvest
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
 * @package com.mdbitz.harvest
 */
class Harvest_InvoiceItemCategory extends Harvest_Abstract {

    /**
     * @var string invoice-item-category
     */
    protected $_root = "invoice-item-category";

}