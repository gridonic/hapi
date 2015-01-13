<?php


namespace Harvest\Model;

/**
 * Throttle
 *
 * This file contains the class Throttle
 *
 */

/**
 * Harvest Throttle Object
 *
 * <b>Properties</b>
 * <ul>
 *   <li>timeframe_limit</li>
 *   <li>count</li>
 *   <li>max_calls</li>
 *   <li>lockout_seconds</li>
 *   <li>last_access_at</li>
 * </ul>
 *
 */
class Throttle extends Harvest
{
    /**
     * @var string hash
     */
    protected $_root = "hash";

}
