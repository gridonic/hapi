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
 * Range
 *
 * This file contains the class Harvest_Range
 *
 * @author Matthew John Denton <matt@mdbitz.com>
 * @package com.mdbitz.harvest
 */

/**
 * Harvest Range Object
 *
 * @package com.mdbitz.harvest
 */
class Harvest_Range {

	/**
     *  MONDAY
     */
    const MONDAY = 1;

	/**
     *  SUNDAY
     */
    const SUNDAY = 0;

    /**
     * @var string from date
     */
    protected $_from = null;
	
    /**
     * @var string to date
     */
    protected $_to = null;

    /**
     * Constructor
     *
     * @param String $from
     * @param String $to
     */
	public function Harvest_Range( $from, $to )
	{
		$this->_from = $from;
		$this->_to = $to;
	}

    /**
     * @return _to
     */
	public function to( ) 
	{
		if( $this->_to instanceof DateTime ) {
			return $this->_to->format( "Ymd" );
		} else {
			return $this->_to;
		}
	}
	
	/**
	 * @return _from
	 */
	public function from()
    {
		if( $this->_from instanceof DateTime ) {
			return $this->_from->format( "Ymd" );
		} else {
			return $this->_from;
		}
	}
	
	/**
     * return Harvest_Range object set to today
     *
     * <code>
	 * $range = Harvest_Range:today( "EST" );
     * </code>
     *
     * @param string $timeZone User Time Zone
     * @return Harvest_Range
     */
	public static function today( $timeZone = null )
	{
		$now = null;
		$before = null;
		if( is_null($timeZone) ) {
			$now = new DateTime();
			$before = new DateTime();
		} else {
			$now = new DateTime( "now", new DateTimeZone( $timeZone ) );
			$before = new DateTime( "now", new DateTimeZone( $timeZone ) );
		}
		$range = new Harvest_Range( $before, $now );
		return $range;
	}
	
	/**
     * return Harvest_Range object set to this week
     *
     * <code>
	 * $range = Harvest_Range:thisWeek( "EST", Harvest_Range::SUNDAY );
     * </code>
     *
     * @param string $timeZone User Time Zone
	 * @param int $startOfWeek Starting day of the week
     * @return Harvest_Range
     */
	public static function thisWeek( $timeZone = null, $startOfWeek = 0 )
	{
		$now = null;
		$before = null;
		if( is_null($timeZone) ) {
			$now = new DateTime();
			$before = new DateTime();
		} else {
			$now = new DateTime( "now", new DateTimeZone( $timeZone ) );
			$before = new DateTime( "now", new DateTimeZone( $timeZone ) );
		}
		$dayOfWeek = $now->format( "w" );
		$offset = (($dayOfWeek - $startOfWeek ) + 7 ) % 7;
		$before->modify( "-$offset day" );
		$range = new Harvest_Range( $before, $now );
		return $range;
	}
	
	/**
     * return Harvest_Range object set to last week
     *
     * <code>
	 * $range = Harvest_Range:lastWeek( "EST", Harvest_Range::MONDAY );
     * </code>
     *
     * @param string $timeZone User Time Zone
	 * @param int $startOfWeek Starting day of the week
     * @return Harvest_Range
     */
	public static function lastWeek( $timeZone = null, $startOfWeek = 0 )
	{
		$now = null;
		$before = null;
		if( is_null($timeZone) ) {
			$now = new DateTime();
			$before = new DateTime();
		} else {
			$now = new DateTime( "now", new DateTimeZone( $timeZone ) );
			$before = new DateTime( "now", new DateTimeZone( $timeZone ) );
		}
		$dayOfWeek = $now->format( "w" );
		$offset = (($dayOfWeek - $startOfWeek ) + 7 ) % 7;
		$beginOffset = $offset + 7;
		$endOffset = $offset + 1;
		$before->modify( "-$beginOffset day" );
		$now->modify( "-$endOffset day" );
		$range = new Harvest_Range( $before, $now );
		return $range;
	}
	
	/**
     * return Harvest_Range object set to this month
     *
     * <code>
	 * $range = Harvest_Range:thisMonth( "EST" );
     * </code>
     *
     * @param string $timeZone User Time Zone
     * @return Harvest_Range
     */
	public static function thisMonth( $timeZone = null )
	{
		$now = null;
		$before = null;
		if( is_null($timeZone) ) {
			$now = new DateTime();
			$before = new DateTime();
		} else {
			$now = new DateTime( "now", new DateTimeZone( $timeZone ) );
			$before = new DateTime( "now", new DateTimeZone( $timeZone ) );
		}
		$dayOfMonth = $now->format( "j" );
		$offset = $dayOfMonth - 1;
		$before->modify( "-$offset day" );
		$range = new Harvest_Range( $before, $now );
		return $range;
	}
	
	/**
     * return Harvest_Range object set to last month
     *
     * <code>
	 * $range = Harvest_Range:lastMonth( "EST" );
     * </code>
     *
     * @param string $timeZone User Time Zone
     * @return Harvest_Range
     */
	public static function lastMonth( $timeZone = null )
	{
		$now = null;
		$before = null;
		if( is_null($timeZone) ) {
			$now = new DateTime();
			$before = new DateTime();
		} else {
			$now = new DateTime( "now", new DateTimeZone( $timeZone ) );
			$before = new DateTime( "now", new DateTimeZone( $timeZone ) );
		}
		$dayOfMonth = $now->format( "j" );
		$offset = $dayOfMonth - 1;
		$now->modify( "-$dayOfMonth day" );
		$before->modify( "-$offset day" );
		$before->modify( "-1 month" );
		$range = new Harvest_Range( $before, $now );
		return $range;
	}
	
}