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
 * InvoiceMessage
 *
 * This file contains the class Harvest_InvoiceMessage
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.harvest
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
 * @package com.mdbitz.harvest
 */
class Harvest_InvoiceMessage extends Harvest_Abstract {

    /**
     * @var string invoice-message
     */
    protected $_root = "invoice-message";

}