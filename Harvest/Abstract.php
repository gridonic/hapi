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
 * Abstract
 *
 * This file contains the class Harvest_Abstract
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.harvest
 */

/**
 * Harvest_Abstract defines the base class utilized by all Harvest Objects
 *
 * @package com.mdbitz.harvest
 */
abstract class Harvest_Abstract {

    /**
     * @var string Document Element Name
     */
    protected $_root = "";

    /**
     * @var boolean Convert underscores
     */
    protected $_convert = true;
	
    /**
     * @var array Object Values
     */
    protected $_values = array();
	
	/**
     * magic method to return non public properties
     *
     * @see     get
     * @param   mixed $property
     * @return  mixed
     */
    public function __get( $property )
    {
        return $this->get( $property );
    }
	
	/**
	 * get specifed property
	 *
	 * @param mixed $property
     * @return mixed
	 */
	public function get( $property )
    {
        $value = null;

		if( $this->_convert ) {
			$property = str_replace( "_", "-", $property );
		} else {
			$property = str_replace( "-", "_", $property );
		}
		
        if (array_key_exists($property, $this->_values)) {
            return $this->_values[$property];
        } else {
			return null;
		}
		
	}
	
	/**
     * magic method to set non public properties
     *
     * @see    set
     * @param  mixed $property
     * @param  mixed $value
     * @return void
     */
    public function __set( $property, $value )
    {
        $this->set( $property, $value );
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
		if( $this->_convert ) {
			$property = str_replace( "_", "-", $property );
		} else {
			$property = str_replace( "-", "_", $property );
		}
		
		$this->_values[$property] = $value;
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
     * magic method used for method overloading
     *
     * @param XMLNode $node xml node to parse
     * @return void            
     */
	public function parseXML( $node ) {
		
		foreach ( $node->childNodes as $item ) {
			if( $item->nodeName != "#text" ){
				$this->set( $item->nodeName, $item->nodeValue);
			}
		}
		
	}

    /**
     * Convert Harvest Object to XML representation
     *
     * @return string
     */
    public function toXML( )
    {
        $xml = "<$this->_root>";
        foreach ( $this->_values as $key => $value ) {
            $xml .= "<$key>$value</$key>";
        }
        $xml .= "</$this->_root>";
        return $xml;
    }

}