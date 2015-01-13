<?php


namespace Harvest\Model;

/**
 * Filter
 *
 * This file contains the class TaskAssignment
 *
 */

/**
 * Harvest TaskAssignment Object
 *
 * <p>Properties</p>
 * <ul>
 *   <li>billable</li>
 *   <li>budget</li>
 *   <li>deactivated</li>
 *   <li>hourly-rate</li>
 *   <li>id</li>
 *   <li>project-id</li>
 *   <li>task-id</li>
 *   <li>estimate</li>
 * </ul>
 *
 */
class TaskAssignment extends Harvest
{
    /**
     * @var string task-assignment
     */
    protected $_root = "task-assignment";

}
