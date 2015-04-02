<?php


namespace Harvest\Model;

use Harvest\Exception\HarvestException;
use Harvest\Model\DayEntry;

/**
 * DailyActivity
 *
 * This file contains the class DailyActivity
 *
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
 */
class DailyActivity extends Harvest
{
    /**
     * @var string daily
     */
    protected $_root = "daily";

    /**
     * @var string for day, of Daily Activity
     */
    protected $_forDay = null;

    /**
     * @var array DayEntry objects of the Daily Activity
     */
    protected $_dayEntries = null;

    /**
     * @var array Project objects of the Daily Activity
     */
    protected $_projects = null;
    /**
     * get specifed property
     *
     * @param  mixed $property
     * @return mixed
     */
    public function get($property)
    {
           if ($property == "for_day" || $property == "forDay") {
            return $this->_forDay;
        } elseif ($property == "day_entries" || $property == "dayEntries") {
            return $this->_dayEntries;
        } elseif ($property == "projects" || $property == "projects") {
            return $this->_projects;
        } else {
            return null;
        }

    }

    /**
     * set property to specified value
     *
     * @param  mixed $property
     * @param  mixed $value
     * @throws HarvestException
     */
    public function set($property, $value)
    {
        if ($property == "for_day" || $property == "forDay") {
            $this->_forDay = $value;
        } elseif ($property == "day_entries" || $property == "dayEntries") {
            $this->_dayEntries = $value;
        } elseif ($property == "projects" || $property == "projects") {
            $this->_projects = $value;
        } else {
            throw new HarvestException( sprintf('Unknown property %s::%s', get_class($this), $property));
        }
    }

    /**
     * magic method used for method overloading
     *
     * @param  string $method name of the method
     * @param $arguments
     * @return mixed the return value of the given method
     * @throws HarvestException
     * @internal param array $args method arguments
     */
    public function __call($method, $arguments)
    {
        if ( count($arguments) == 0 ) {
            return $this->get( $method );
        } elseif ( count( $arguments ) == 1 ) {
            return $this->set( $method, $arguments[0] );
        }

        throw new HarvestException( sprintf('Unknown method %s::%s', get_class($this), $method));
    }

    /**
     * parse XML represenation into a Harvest DailyActivity object
     *
     * @param  XMLNode $node xml node to parse
     * @return void
     */
    public function parseXml($node)
    {
        foreach ($node->childNodes as $item) {
            switch ($item->nodeName) {
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
     * @param  string $xml
     * @return array
     */
    private function parseItems($xml)
    {
        $items = array();

        foreach ($xml->childNodes AS $item) {
            $item = $this->parseNode( $item );
            if ( ! is_null( $item ) ) {
                $items[$item->id()] = $item;
            }
        }

        return $items;

    }

    /**
     * parse xml node
     * @param  XMLNode $node
     * @return mixed
     */
    private function parseNode($node)
    {
        $item = null;

        switch ($node->nodeName) {
            case "day_entry":
                $item = new DayEntry();
            break;
            case "project":
                $item = new Project();
            break;
            default:
            break;
        }
        if ( ! is_null( $item ) ) {
            $item->parseXml( $node );
        }

        return $item;

    }

}
