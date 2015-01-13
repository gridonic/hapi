<?php


namespace Harvest\Model;

use Harvest\Model\DayEntry;

/**
 * Timer
 *
 * This file contains the class Timer
 *
 */

/**
 * Harvest Timer Object
 *
 * <b>Properties</b>
 * <ul>
 *   <li>day_entry</li>
 *   <li>hours_for_previously_running_entry</li>
 * </ul>
 *
 */
class Timer extends Harvest
{
    /**
     * @var DayEntry object of the timer
     */
    protected $_dayEntry = null;

    /**
     * @var Float Hours for previously running timer
     */
    protected $_hoursForPrevious = null;

    /**
     * get specifed property
     *
     * @param $mixed $property
     * @param mixed
     */
    public function get($property)
    {
        switch ($property) {
            case "day_entry":
                return $this->_dayEntry;
            break;
            case "hours_for_previously_running_timer":
                return $this->_hoursForPrevious;
            break;
            default:
                return null;
            break;
        }
    }

    /**
     * set property to specified value
     *
     * @param $mixed $property
     * @return void
     */
    public function set($property, $value)
    {
        switch ($property) {
            case "day_entry":
                $this->_dayEntry = $value;
            break;
            case "hours_for_previously_running_timer":
                $this->_hoursForPrevious = $value;
            break;
            default:
                return null;
            break;
        }
    }

    /**
     * parse XML represenation into a Harvest Timer object
     *
     * @param  XMLNode $node xml node to parse
     * @return void
     */
    public function parseXML($node)
    {
        foreach ($node->childNodes as $item) {
            switch ($item->nodeName) {
                case "day_entry":
                    $this->_dayEntry = new DayEntry();
                    $this->_dayEntry->parseXML( $node );
                break;
                case "hours_for_previously_running_timer":
                    $this->_hoursForPrevious = $item->nodeValue;
                break;
                default:
                break;
            }
        }
    }

}
