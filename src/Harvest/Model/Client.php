<?php


namespace Harvest\Model;

/**
 * Client
 *
 * This file contains the class Client
 *
 */

/**
 * Harvest Client Object
 *
 * <b>Properties</b>
 * <ul>
 *  <li>active</li>
 *  <li>cache-version</li>
 *  <li>currency</li>
 *  <li>default-invoice-timeframe</li>
 *  <li>details</li>
 *  <li>highrise-id</li>
 *  <li>id</li>
 *  <li>name</li>
 * </ul>
 *
 */
class Client extends Harvest
{
    /**
     * @var string client
     */
    protected $_root = "client";

}
