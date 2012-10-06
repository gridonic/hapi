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
 * Project
 *
 * This file contains the class Harvest_Project
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.harvest
 */

/**
 * Harvest Project Object
 *
 * <b>Properties</b>
 * <ul>
 *  <li>active</li>
 *  <li>active-task-assignments-count</li>
 *  <li>active-user-assignments-count</li>
 *  <li>basecamp-id</li>
 *  <li>bill-by</li>
 *  <li>billable</li>
 *  <li>budget</li>
 *  <li>budget-by</li>
 *  <li>cache-version</li>
 *  <li>client-id</li>
 *  <li>code</li>
 *  <li>cost-budget</li>
 *  <li>cost-budget-include-expenses</li>
 *  <li>created-at</li>
 *  <li>fees</li>
 *  <li>highrise-deal-id</li>
 *  <li>hourly-rate</li>
 *  <li>id</li>
 *  <li>name</li>
 *  <li>notify-when-over-budget</li>
 *  <li>over-budget-notification-percentage</li>
 *  <li>over-budget-notified-at</li>
 *  <li>show-budget-to-all</li>
 *  <li>estimate</li>
 *  <li>estimate-by</li>
 *  <li>notes</li>
 * </ul>
 *
 * @package com.mdbitz.harvest
 */
class Harvest_Project extends Harvest_Abstract {

    /**
     * @var string project
     */
    protected $_root = "project";

    /**
     * @var array Harvest_Tasks
     */
    protected $_tasks = array();

	/**
	 * get specifed property
	 *
	 * @param mixed $property
     * @return mixed
	 */
	public function get( $property )
    {
        if( $property == "tasks" ) {
	        return $this->_tasks;
		} else if (array_key_exists($property, $this->_values)) {
            return $this->_values[$property];
        } else {
			return null;
		}
		
	}
	
	/**
	 * set property to specified value
	 *
	 * @param mixed $property
	 * @param mixed $value
     * @return void
	 */
	public function set($property, $value)
    {
		if( $property == "tasks" ) {
			$this->_tasks = $value;
		} else {
			$this->_values[$property] = $value;
		}
	}
	
	/**
     * parse XML represenation into a Harvest Project object
     *
     * @param XMLNode $node xml node to parse
     * @return void            
     */
	public function parseXML( $node ) {
		
		foreach ( $node->childNodes as $item ) {
			switch( $item->nodeName ) 
			{	
				case "tasks":
					$this->_tasks = $this->parseItems( $item );
				break;
				default:
					if( $item->nodeName != "#text" ){
						$this->set( $item->nodeName, $item->nodeValue);
					}
				break;
			}
		}
		
	}
	
	/**
	 * parse xml list
	 * @param string $xml
	 * @return array
	 */
	private function parseItems( $xml ) {
		$items = array();
		
		foreach ($xml->childNodes AS $item)
		{
			$item = $this->parseNode( $item );
			if( ! is_null( $item ) ) 
			{
				$items[$item->id()] = $item;
			}
		}
		
		return $items;
		
	}
	
	/**
	 * parse xml node
	 * @param XMLNode $node
	 * @return mixed
	 */
	private function parseNode( $node ) {
		$item = null;
		
		switch( $node->nodeName ) 
		{	
			case "task":
				$item = new Harvest_Task();
			break;
			default:
			break;
		}
		if( ! is_null( $item ) ) {
			$item->parseXML( $node );
		}
		
		return $item;
		
	}
	
}