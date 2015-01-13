<?php


namespace Harvest\Model;

/**
 * Project
 *
 * This file contains the class Project
 *
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
 */
class Project extends Harvest
{
    /**
     * @var string project
     */
    protected $_root = "project";

    /**
     * @var array Tasks
     */
    protected $_tasks = array();

    /**
     * get specifed property
     *
     * @param  mixed $property
     * @return mixed
     */
    public function get($property)
    {
        if ($property == "tasks") {
            return $this->_tasks;
        } elseif (array_key_exists($property, $this->_values)) {
            return $this->_values[$property];
        } else {
            return null;
        }

    }

    /**
     * set property to specified value
     *
     * @param  mixed $property
     * @param  mixed $value
     * @return void
     */
    public function set($property, $value)
    {
        if ($property == "tasks") {
            $this->_tasks = $value;
        } else {
            $this->_values[$property] = $value;
        }
    }

    /**
     * parse XML represenation into a Harvest Project object
     *
     * @param  XMLNode $node xml node to parse
     * @return void
     */
    public function parseXml($node)
    {
        foreach ($node->childNodes as $item) {
            switch ($item->nodeName) {
                case "tasks":
                    $this->_tasks = $this->parseItems( $item );
                break;
                default:
                    if ($item->nodeName != "#text") {
                        $this->set( $item->nodeName, $item->nodeValue);
                    }
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
            case "task":
                $item = new Task();
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
