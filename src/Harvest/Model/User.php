<?php


namespace Harvest\Model;

/**
 * User
 *
 * This file contains the class User
 *
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
 */
class User extends Harvest
{
    /**
     * @var string user
     */
    protected $_root = "user";

}
