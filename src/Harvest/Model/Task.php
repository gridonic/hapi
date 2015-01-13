<?php


namespace Harvest\Model;

/**
 * Task
 *
 * This file contains the class Task
 *
 */

/**
 * Harvest Task Object
 *
 * <b>Properties</b>
 * <ul>
 *   <li>billable-by-default</li>
 *   <li>cache-version</li>
 *   <li>created-at</li>
 *   <li>deactivated</li>
 *   <li>default-hourly-rate</li>
 *   <li>id</li>
 *   <li>is-default</li>
 *   <li>name</li>
 *   <li>updated-at</li>
 * </ul>
 *
 */
class Task extends Harvest
{
    /**
     * @var string task
     */
    protected $_root = "task";

}
