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
 * Filter
 *
 * This file contains the class Harvest_Invoice_Filter
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.harvest
 */

/**
 * Harvest Invoice Filter Object
 *
 * <b>Properties</b>
 * <ul>
 *   <li>range - Harvest_Range</li>
 *   <li>status</li>
 *   <li>client</li>
 *   <li>page</li>
 * </ul>
 *
 * @package com.mdbitz.harvest
 */
class Harvest_Invoice_Filter {

	/**
	 * Status : "open"
	 */
	const OPEN                       = "open";

    /**
	 * Status : "partial"
	 */
	const PARTIAL                    = "partial";

    /**
	 * Status : "draft"
	 */
	const DRAFT                      = "draft";

    /**
	 * Status : "paid"
	 */
	const PAID                       = "paid";

    /**
	 * Status : "unpaid"
	 */
	const UNPAID                     = "unpaid";

    /**
	 * Status : "pastdue"
	 */
	const PASTDUE                    = "pastdue";

    /**
     * @var Harvest_Range Time Range
     */
    protected $_range = null;

	/**
     * @var int page of results to return
     */
    protected $_page = null;

	/**
     * @var string
     */
    protected $_status = null;

	/**
     * @var int client identifier
     */
    protected $_client = null;

	/**
     * @var mixed DateTime
     */
    protected $_updated_since = null;

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
	 * @param $mixed $property
     * @return mixed
	 */
	public function get( $property )
    {
        switch( $property ) {
			case 'range':
				return $this->_range;
			break;
			case 'page':
				return $this->_page;
			break;
			case 'status':
				return $this->_status;
			break;
			case 'client':
				return $this->_client;
			break;
			case 'updated_since':
				return $this->_updated_since;
			break;
			default:
				throw new Harvest_Exception( sprintf('Unknown method %s::%s', get_class($this), $method));
			break;
        }
    }

    /**
     * magic method to set non public properties
     *
     * @see    set
     * @param  mixed $property
     * @param  mixed $value
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
	 */
	public function set( $property, $value ) 
	{
		switch( $property ) {
			case 'range':
				$this->_range = $value;
			break;
			case 'page':
				$this->_page = $value;
			break;
			case 'status':
				$this->_status = $value;
			break;
			case 'client':
				$this->_client = $value;
			break;
			case 'updated_since':
				$this->_updated_since = $value;
			break;
			default:
				throw new Harvest_Exception( sprintf('Unknown method %s::%s', get_class($this), $method));
			break;
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
     * returns generated url for use in api call
     *
     * @return String query uri
     */
    public function toURL()
	{
		$query = "";
		if( ! is_null( $this->_page ) ){
			$query .= "&page=" . $this->_page;
		} 
		if( ! is_null( $this->_client ) ) {
			$query .= "&client=" . $this->_client;
		}
		if( ! is_null( $this->_status ) ) {
			$query .= "&status=". $this->_status;
		}
		if( ! is_null( $this->_range ) ) {
			$query .= "&from=" . $this->_range->from() . "&to=" . $this->_range->to();
		}
		if( ! is_null( $this->_updated_since ) ) {
			$query .= '&updated_since=';
			if( $this->_updated_since instanceOf DateTime ) {
				$query .= urlencode($this->_updated_since->format("Y-m-d G:i"));
			} else {
				$query .= urlencode($this->_updated_since);
			}
		}
		$query = "?" . substr( $query, 1 );
		return $query;
	}
	
}