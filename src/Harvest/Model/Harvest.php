<?php


namespace Harvest\Model;

use Harvest\Exception\HarvestException;

/**
 * Abstract
 *
 * This file contains the class Harvest
 *
 */

/**
 * Harvest defines the base class utilized by all Harvest Objects
 *
 * @property mixed id
 */
abstract class Harvest
{
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
     * @param  mixed $property
     * @return mixed
     */
    public function __get($property)
    {
        return $this->get( $property );
    }

    /**
     * get specified property
     *
     * @param  mixed $property
     * @return mixed
     */
    public function get($property)
    {
        $value = null;

        if ($this->_convert) {
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
    public function __set($property, $value)
    {
        $this->set( $property, $value );
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
        if ($this->_convert) {
            $property = str_replace( "_", "-", $property );
        } else {
            $property = str_replace( "-", "_", $property );
        }

        $this->_values[$property] = $value;
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
            $this->set( $method, $arguments[0] );
        }

        throw new HarvestException( sprintf('Unknown method %s::%s', get_class($this), $method));
    }

    /**
     * magic method used for method overloading
     *
     * @param  \DOMNode $node xml node to parse
     * @return void
     */
    public function parseXml($node)
    {
        foreach ($node->childNodes as $item) {
            if ($item->nodeName != "#text") {
                $this->set( $item->nodeName, $item->nodeValue);
            }
        }

    }

    /**
     * Convert Harvest Object to XML representation
     *
     * @return string
     */
    public function toXML()
    {
        $xml = "<$this->_root>";
        $xml .= $this->_xmlTags($this->_values);
        $xml .= "</$this->_root>";

        return $xml;
    }

    protected function _xmlTags($tags)
    {
        $xml = '';
        foreach($tags as $key => $value) {
            $xml .= "<$key>";
            if (is_array($value)) {
                $xml .= $this->_xmlTags($value);
            } else {
                $xml .= htmlspecialchars($value, ENT_XML1);
            }
            $xml .= "</$key>";
        }
        return $xml;
    }

    public function __toString(){
        return (string)$this->id;
    }
}
