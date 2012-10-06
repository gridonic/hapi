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
 * DailyActivity
 *
 * This file contains the class Harvest_DailyActivity
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.harvest
 */

/**
 * Harvest DailyActivity Object
 *
 * <b>Properties</b>
 * <ul>
 *   <li>forDay</li>
 *   <li>dayEntries</li>
 *   <li>projects</li>
 * </ul>
 *
 * @package com.mdbitz.harvest
 */
class Harvest_DailyActivity extends Harvest_Abstract {

    /**
     * @var string daily
     */
    protected $_root = "daily";
	
	/**
     * @var string for day, of Daily Activity
     */
    protected $_forDay = null;
	
	/**
     * @var array Harvest_DayEntry objects of the Daily Activity
     */
    protected $_dayEntries = null;
	
	/**
     * @var array Harvest_Project objects of the Daily Activity
     */
    protected $_projects = null;
	/**
	 * get specifed property
	 *
	 * @param mixed $property
     * @return mixed
	 */
	public function get( $property )
    {
       	if( $property == "for_day" || $property == "forDay") {
			return $this->_forDay;
		} else if( $property == "day_entries" || $property == "dayEntries") {
			return $this->_dayEntries;
		} else if( $property == "projects" || $property == "projects") {
			return $this->_projects;
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
		if( $property == "for_day" || $property == "forDay") {
			$this->_forDay = $value;
		} else if( $property == "day_entries" || $property == "dayEntries") {
			$this->_dayEntries = $value;
		} else if( $property == "projects" || $property == "projects") {
			$this->_projects = $value;
		} else {
			throw new Harvest_Exception( sprintf('Unknown property %s::%s', get_class($this), $property));
		}
	}
	
	/**
     * magic method used for method overloading
     *
     * @param string $method        name of the method
     * @param array $args           method arguments
     * @return mixed                the return value of the given method
     */
    public function __call($method, $arguments)
    {
    	if( count($arguments) == 0 ) {
			return $this->get( $method );
		} else if( count( $arguments ) == 1 ) {
			return $this->set( $method, $arguments[0] );
		}
		
		throw new Harvest_Exception( sprintf('Unknown method %s::%s', get_class($this), $method));
    }

	/**
     * parse XML represenation into a Harvest DailyActivity object
     *
     * @param XMLNode $node xml node to parse
     * @return void            
     */
	public function parseXML( $node ) {
		
		foreach ( $node->childNodes as $item ) {
			switch( $item->nodeName ) 
			{	
				case "for_day":
					$this->_forDay = $item->nodeValue;
				break;
				case "day_entries":
					$this->_dayEntries = $this->parseItems( $item );
				break;
				case "projects":
					$this->_projects = $this->parseItems( $item );
				break;
				default:
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
			case "day_entry":
				$item = new Harvest_DayEntry();
			break;
			case "project":
				$item = new Harvest_Project();
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