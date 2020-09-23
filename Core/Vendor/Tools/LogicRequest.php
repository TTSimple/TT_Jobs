<?php
/**
 * Created by PhpStorm.
 * User: safer
 * Date: 2018/6/6
 * Time: 0:11
 */

namespace Core\Vendor\Tools;


class LogicRequest
{
    const PAGE_DEFAULT = [
        'page'     => 1,
        'limit'    => 10,
        'start'    => 0,
        'total'    => 0,
        'is_first' => 0,
    ];

    protected $id;
    protected $data;
    protected $where;
    protected $field;
    protected $order;
    protected $extend;
    protected $page;

    private static $instance;

    static function getInstance()
    {
        // if (!self::$instance) {
        //     self::$instance = new self();
        // }
        // return self::$instance;
        return new self();
    }

    /**
     * @param null $key
     *
     * @return array|bool
     */
    public function getId($key = null)
    {
        return $this->_resolveData($this->id, $key);
    }

    /**
     * @param mixed $id
     *
     * @return LogicRequest
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param null $key
     *
     * @return array|bool
     */
    public function getData($key = null)
    {
        return $this->_resolveData($this->data, $key);
    }

    /**
     * @param array $data
     *
     * @return LogicRequest
     */
    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @param string $key
     *
     * @return array|bool
     */
    public function getWhere($key = null)
    {
        return $this->_resolveData($this->where, $key);
    }

    /**
     * @param array $where
     *
     * @return LogicRequest
     */
    public function setWhere(array $where)
    {
        $this->where = $where;
        return $this;
    }

    /**
     * @param string $key
     *
     * @return string
     */
    public function getField($key = null)
    {
        if (! $data = $this->field) {
            return false;
        }
        if ($key === null) {
            return ! empty($data)
                ? \join(',', $data)
                : false;
        }
        return isset($data[$key])
            ? \join(',', $data[$key])
            : false;
    }

    /**
     * @param array $field
     *
     * @return LogicRequest
     */
    public function setField(array $field)
    {
        $this->field = $field;
        return $this;
    }

    /**
     * @param string $key
     *
     * @return string
     */
    public function getOrder($key = null)
    {
        if (! $data = $this->order) {
            return false;
        }
        if ($key === null) {
            return ! empty($data)
                ? \join(',', $data)
                : false;
        }
        return isset($data[$key])
            ? \join(',', $data[$key])
            : false;
    }

    /**
     * @param array $order
     *
     * @return LogicRequest
     */
    public function setOrder(array $order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @param null $key
     *
     * @return array|bool
     */
    public function getExtend($key = null)
    {
        return $this->_resolveData($this->extend, $key);
    }

    /**
     * @param array $extend
     *
     * @return LogicRequest
     */
    public function setExtend(array $extend)
    {
        $this->extend = $extend;
        return $this;
    }

    /**
     * @param null $key
     *
     * @return array|bool
     */
    public function getPage($key = null)
    {
        return $this->_resolveData($this->page, $key);
    }

    /**
     * @param array $page
     *
     * @return LogicRequest
     */
    public function setPage(array $page)
    {
        if ($page['limit'] > 50) {
            $page['limit'] = 50;
        }
        $page['current'] = $page['page'];
        $this->page      = \array_merge(self::PAGE_DEFAULT, $page);
        return $this;
    }

    /**
     * @param $data
     * @param $key
     *
     * @return bool|array
     */
    private function _resolveData($data, $key)
    {
        if (null === $data) {
            return false;
        }
        if ($key === null) {
            return ! empty($data)
                ? $data
                : false;
        }
        return isset($data[$key])
            ? $data[$key]
            : false;
    }
}