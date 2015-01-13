<?php


namespace Harvest\Model;

/**
 * DayEntry
 *
 * This file contains the class DayEntry
 *
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
 */
class DayEntry extends Harvest
{
    /**
     * @var string request
     */
    protected $_root = "request";

    /**
     * @var boolean convert underscore
     */
    protected $_convert = true;

}
