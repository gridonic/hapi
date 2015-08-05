<?php


namespace Harvest\Model;

/**
 * Range
 *
 * This file contains the class Range
 *
 */

/**
 * Harvest Range Object
 *
 */
class Range
{
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
    public function __construct($from, $to)
    {
        $this->_from = $from;
        $this->_to = $to;
    }

    /**
     * @return string
     */
    public function to()
    {
        if ($this->_to instanceof \DateTime) {
            return $this->_to->format( "Ymd" );
        } else {
            return $this->_to;
        }
    }

    /**
     * @return string
     */
    public function from()
    {
        if ($this->_from instanceof \DateTime) {
            return $this->_from->format( "Ymd" );
        } else {
            return $this->_from;
        }
    }

    /**
     * return Range object set to today
     *
     * <code>
     * $range = Range::today( "EST" );
     * </code>
     *
     * @param  string $timeZone User Time Zone
     * @return Range
     */
    public static function today($timeZone = null)
    {
        $now = null;
        $before = null;
        if ( is_null($timeZone) ) {
            $now = new \DateTime();
            $before = new \DateTime();
        } else {
            $now = new \DateTime( "now", new \DateTimeZone( $timeZone ) );
            $before = new \DateTime( "now", new \DateTimeZone( $timeZone ) );
        }
        $range = new Range( $before, $now );

        return $range;
    }

    /**
     * return Range object set to this week
     *
     * <code>
     * $range = Range::thisWeek( "EST", Range::SUNDAY );
     * </code>
     *
     * @param  string $timeZone    User Time Zone
     * @param  int    $startOfWeek Starting day of the week
     * @return Range
     */
    public static function thisWeek($timeZone = null, $startOfWeek = 0)
    {
        $now = null;
        $before = null;
        if ( is_null($timeZone) ) {
            $now = new \DateTime();
            $before = new \DateTime();
        } else {
            $now = new \DateTime( "now", new \DateTimeZone( $timeZone ) );
            $before = new \DateTime( "now", new \DateTimeZone( $timeZone ) );
        }
        $dayOfWeek = (int) $now->format( "w" );
        $offset = (($dayOfWeek - $startOfWeek ) + 7 ) % 7;
        $before->modify( "-$offset day" );
        $range = new Range( $before, $now );

        return $range;
    }

    /**
     * return Range object set to last week
     *
     * <code>
     * $range = Range::lastWeek( "EST", Range::MONDAY );
     * </code>
     *
     * @param  string $timeZone    User Time Zone
     * @param  int    $startOfWeek Starting day of the week
     * @return Range
     */
    public static function lastWeek($timeZone = null, $startOfWeek = 0)
    {
        $now = null;
        $before = null;
        if ( is_null($timeZone) ) {
            $now = new \DateTime();
            $before = new \DateTime();
        } else {
            $now = new \DateTime( "now", new \DateTimeZone( $timeZone ) );
            $before = new \DateTime( "now", new \DateTimeZone( $timeZone ) );
        }
        $dayOfWeek = (int) $now->format( "w" );
        $offset = (($dayOfWeek - $startOfWeek ) + 7 ) % 7;
        $beginOffset = $offset + 7;
        $endOffset = $offset + 1;
        $before->modify( "-$beginOffset day" );
        $now->modify( "-$endOffset day" );
        $range = new Range( $before, $now );

        return $range;
    }

    /**
     * return Range object set to this month
     *
     * <code>
     * $range = Range::thisMonth( "EST" );
     * </code>
     *
     * @param  string $timeZone User Time Zone
     * @return Range
     */
    public static function thisMonth($timeZone = null)
    {
        $now = null;
        $before = null;
        if ( is_null($timeZone) ) {
            $now = new \DateTime();
            $before = new \DateTime();
        } else {
            $now = new \DateTime( "now", new \DateTimeZone( $timeZone ) );
            $before = new \DateTime( "now", new \DateTimeZone( $timeZone ) );
        }
        $dayOfMonth = $now->format( "j" );
        $offset = $dayOfMonth - 1;
        $before->modify( "-$offset day" );
        $range = new Range( $before, $now );

        return $range;
    }

    /**
     * return Range object set to last month
     *
     * <code>
     * $range = Range::lastMonth( "EST" );
     * </code>
     *
     * @param  string $timeZone User Time Zone
     * @return Range
     */
    public static function lastMonth($timeZone = null)
    {
        $now = null;
        $before = null;
        if ( is_null($timeZone) ) {
            $now = new \DateTime();
            $before = new \DateTime();
        } else {
            $now = new \DateTime( "now", new \DateTimeZone( $timeZone ) );
            $before = new \DateTime( "now", new \DateTimeZone( $timeZone ) );
        }
        $dayOfMonth = $now->format( "j" );
        $offset = $dayOfMonth - 1;
        $now->modify( "-$dayOfMonth day" );
        $before->modify( "-$offset day" );
        $before->modify( "-1 month" );
        $range = new Range( $before, $now );

        return $range;
    }

}
