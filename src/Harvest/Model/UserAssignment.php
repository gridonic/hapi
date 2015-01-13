<?php


namespace Harvest\Model;

/**
 * UserAssignment
 *
 * This file contains the class UserAssignment
 *
 */

/**
 * Harvest UserAssignment Object
 *
 * <b>Properties</b>
 * <ul>
 *   <li>budget</li>
 *   <li>deactivated</li>
 *   <li>hourly-rate</li>
 *   <li>id</li>
 *   <li>is-project-manager</li>
 *   <li>project-id</li>
 *   <li>user-id</li>
 *   <li>estimate</li>
 * </ul>
 *
 */
class UserAssignment extends Harvest
{
    /**
     * @var string user-assignment
     */
    protected $_root = "user-assignment";

}
