<?php

namespace Goqihoo\Aliyun\Ons;

class MessageGroup implements \Countable,\Iterator
{

    /**
     * Real data response from ONS
     *
     * @var array
     */
    private $data;

    /**
     * Pointer position
     *
     * @var int
     */
    private $position;

    /**
     * Constructor
     *
     * @param array $data
     */
    public function __construct($data)
    {
        $this->data = $data;
        if (!empty($this->data)) {
            foreach ($this->data as &$message) {
                $message = new Message($message);
            }
        } else {
            $this->data = array();
        }
    }

    /**
     * Implement Countable
     *
     * @return int
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * Implement Iterator
     *
     * @return mixed
     */
    public function current()
    {
        return $this->data[$this->position];
    }

    /**
     * Implement Iterator
     *
     * @return int
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Implement Iterator
     *
     * @return void
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Implement Iterator
     *
     * @return void
     */
    public function next()
    {
        $this->position++;
    }

    /**
     * Implement Iterator
     *
     * @return boolean
     */
    public function valid()
    {
        return isset($this->data[$this->position]);
    }

    /**
     * Check empty
     *
     * @return boolean
     */
    public function isEmpty()
    {
        return empty($this->data);
    }

    /**
     * Transform to array
     *
     * @return array
     */
    public function toArray()
    {
        $data = array();
        foreach ($this->data as $v) {
            $data[] = $v->toArray();
        }
        return $data;
    }
}