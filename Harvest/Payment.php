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
 * Payment
 *
 * This file contains the class Harvest_Payment
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.harvest
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
 * @package com.mdbitz.harvest
 */
class Harvest_Payment extends Harvest_Abstract {

    /**
     * @var string payment
     */
    protected $_root = "payment";

}