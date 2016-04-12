<?php
/**
 * Created by PhpStorm.
 * User: pimax
 * Date: 13.04.16
 * Time: 2:43
 */

namespace pimax\Messages;


class Address
{
    protected $data = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }
}