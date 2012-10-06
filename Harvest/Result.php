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
 * Result
 *
 * This file contains the class Harvest_Result
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.harvest
 */

/**
 * Harvest Result Object
 *
 * <b>Properties</b>
 * <ul>
 *   <li>code</li>
 *   <li>data</li>
 *   <li>Server</li>
 *   <li>Date</li>
 *   <li>Content-Type</li>
 *   <li>Connection</li>
 *   <li>Status</li>
 *   <li>X-Powered-By</li>
 *   <li>ETag</li>
 *   <li>X-Served-From</li>
 *   <li>X-Runtime</li>
 *   <li>Content-Length</li>
 *   <li>Location</li>
 *   <li>Hint</li>
 * </ul>
 *
 * @package com.mdbitz.harvest
 */
class Harvest_Result
{

    /**
     * @var string response code
     */
    protected $_code = null;

    /**
     * @var array response data
     */
    protected $_data = null;

    /**
     * @var string response headers
     */
    protected $_headers = null;

    /**
     * Constructor initializes {@link $_code} {@link $_data}
     *
     * @param string $code response code
     * @param array $data array of Quote Objects
     * @param array $headers array of Header Response values
     */
    public function __construct( $code = null, $data = null, $headers = null)
    {
        $this->_code = $code;
        $this->_data = $data;
        $this->_headers = $headers;
    }

    /**
     * magic method to return non public properties
     *
     * @see     get
     * @param   mixed $property
     * @return  mixed
     */
    public function __get( $property )
    {
        return $this->get( $property);
    }

    /**
     * Return the specified property
     *
     * @param mixed $property     The property to return
     * @return mixed
     */
    public function get( $property )
    {
        switch( $property ){
            case 'code':
                return $this->_code;
            break;
            case 'data':
                return $this->_data;
            break;
			case 'headers':
				return $this->_headers;
			break;
            default:
                if( $this->_headers != null && array_key_exists($property, $this->_headers) ) {
                    return $this->_headers[$property];
                } else {
                    throw new Harvest_Exception(sprintf('Unknown property %s::%s', get_class($this), $property));
                }
            break;
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
     * sets the specified property
     *
     * @param mixed $property The property to set
     * @param mixed $value value of property
     * @return void
     */
    public function set( $property, $value )
    {
        switch( $property ){
            case 'code':
                $this->_code = $value;
            break;
            case 'data':
                $this->_data = $value;
            break;
            case 'headers':
                $this->_headers = $value;
            break;
            default:
                throw new Harvest_Exception(sprintf('Unknown property %s::%s', get_class($this), $property));
            break;
        }
    }

    /**
     * is request successfull
     * @return boolean
     */
    public function isSuccess() 
    {
        if( "2" == substr( $this->_code, 0, 1 ) ) {
            return true;
        } else {
            return false;
        }
    }

}