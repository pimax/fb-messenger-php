<?php
/**
 * Created by PhpStorm.
 * User: pimax
 * Date: 13.04.16
 * Time: 2:45
 */

namespace pimax\Messages;


class Summary
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