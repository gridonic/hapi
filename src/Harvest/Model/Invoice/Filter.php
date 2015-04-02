<?php


namespace Harvest\Model\Invoice;

use Harvest\Exception\HarvestException;

/**
 * Filter
 *
 * This file contains the class Filter
 *
 */

/**
 * Harvest Invoice Filter Object
 *
 * <b>Properties</b>
 * <ul>
 *   <li>range - Range</li>
 *   <li>status</li>
 *   <li>client</li>
 *   <li>page</li>
 * </ul>
 *
 */
class Filter
{
    /**
     * Status : "open"
     */
    const OPEN = "open";

    /**
     * Status : "partial"
     */
    const PARTIAL = "partial";

    /**
     * Status : "draft"
     */
    const DRAFT = "draft";

    /**
     * Status : "paid"
     */
    const PAID = "paid";

    /**
     * Status : "unpaid"
     */
    const UNPAID = "unpaid";

    /**
     * Status : "pastdue"
     */
    const PASTDUE = "pastdue";

    /**
     * @var Range Time Range
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
     * @see    get
     * @param  mixed $property
     * @return mixed
     */
    public function __get($property)
    {
        return $this->get($property);
    }

    /**
     * get specified property
     *
     * @param $property
     * @return mixed
     * @throws HarvestException
     * @internal param $mixed $property
     */
    public function get($property)
    {
        switch ($property) {
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
                throw new HarvestException(sprintf('Unknown method %s::%s', get_class($this), $method));
            break;
        }
    }

    /**
     * magic method to set non public properties
     *
     * @see    set
     * @param mixed $property
     * @param mixed $value
     */
    public function __set($property, $value)
    {
        $this->set($property, $value);
    }

    /**
     * set property to specified value
     *
     * @param mixed $property
     * @param mixed $value
     * @throws HarvestException
     */
    public function set($property, $value)
    {
        switch ($property) {
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
                throw new HarvestException(sprintf('Unknown method %s::%s', get_class($this), $method));
            break;
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
        if(count($arguments) === 0) {
            return $this->get($method);
        } elseif(count($arguments) === 1) {
            return $this->set($method, $arguments[0]);
        }

        throw new HarvestException(sprintf('Unknown method %s::%s', get_class($this), $method));
    }

    /**
     * returns generated url for use in api call
     *
     * @return String query uri
     */
    public function toURL()
    {
        $query = "";
        if(!is_null($this->_page)) {
            $query .= "&page=" . $this->_page;
        }
        if(!is_null($this->_client)) {
            $query .= "&client=" . $this->_client;
        }
        if(!is_null($this->_status)) {
            $query .= "&status=". $this->_status;
        }
        if(!is_null($this->_range)) {
            $query .= "&from=" . $this->_range->from() . "&to=" . $this->_range->to();
        }
        if(!is_null($this->_updated_since)) {
            $query .= '&updated_since=';
            if($this->_updated_since instanceOf DateTime) {
                $query .= urlencode($this->_updated_since->format("Y-m-d G:i"));
            } else {
                $query .= urlencode($this->_updated_since);
            }
        }
        $query = "?" . substr($query, 1);

        return $query;
    }

}
