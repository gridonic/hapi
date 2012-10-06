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
 * User
 *
 * This file contains the class Harvest_User
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.harvest
 */

/**
 * Harvest User Object
 *
 * <b>Properties</b>
 * <ul>
 *   <li>cache-version</li>
 *   <li>created-at</li>
 *   <li>default-expense-category-id</li>
 *   <li>default-expense-project-id</li>
 *   <li>default-hourly-rate</li>
 *   <li>default-task-id</li>
 *   <li>default-time-project-id</li>
 *   <li>department</li>
 *   <li>duplicate-timesheet-wants-notes</li>
 *   <li>email</li>
 *   <li>email-after-submit</li>
 *   <li>first-name</li>
 *   <li>has-access-to-all-future-projects</li>
 *   <li>id</li>
 *   <li>identitity-url</li>
 *   <li>is-active</li>
 *   <li>is-admin</li>
 *   <li>is-contractor</li>
 *   <li>last-name</li>
 *   <li>preferred-approval-screen</li>
 *   <li>preferred-entry-method</li>
 *   <li>preferred-project-status-reports-screen</li>
 *   <li>telephone</li>
 *   <li>timesheet-duplicated-at</li>
 *   <li>timezone</li>
 *   <li>twitter-username</li>
 *   <li>wants-newsletter</li>
 * </ul>
 * 
 * @package com.mdbitz.harvest
 */
class Harvest_User extends Harvest_Abstract {

    /**
     * @var string user
     */
    protected $_root = "user";

}