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
 * Timer
 *
 * This file contains the class Harvest_Timer
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.harvest
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
 * @package com.mdbitz.harvest
 */
class Harvest_Timer extends Harvest_Abstract
{
    /**
     * @var Harvest_DayEntry object of the timer
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
    public function get( $property )
    {
        switch( $property ) {
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
    public function set( $property, $value )
    {
        switch( $property ) {
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
     * @param XMLNode $node        xml node to parse
     * @return void            
     */
    public function parseXML( $node )
    {    
        foreach ( $node->childNodes as $item ) {
            switch( $item->nodeName ) {
                case "day_entry":
                    $this->_dayEntry = new Harvest_DayEntry();
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