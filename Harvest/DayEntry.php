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
 * DayEntry
 *
 * This file contains the class Harvest_DayEntry
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.harvest
 */

/**
 * Harvest DayEntry Object
 *
 * <b>Properties</b>
 * <ul>
 *   <li>created-at</li>
 *   <li>hours</li>
 *   <li>id</li>
 *   <li>is-billed</li>
 *   <li>is-closed</li>
 *   <li>notes</li>
 *   <li>project-id</li>
 *   <li>spent-at</li>
 *   <li>task-id</li>
 *   <li>timer-started-at</li>
 *   <li>user-id</li>
 * </ul>
 *
 * @package com.mdbitz.harvest
 */
class Harvest_DayEntry extends Harvest_Abstract {

    /**
     * @var string request
     */
    protected $_root = "request";
	
    /**
     * @var boolean convert underscore
     */
    protected $_convert = true;

}