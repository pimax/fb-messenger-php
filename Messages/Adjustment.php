<?php

namespace hvointern\FbMessenger\Messages;

/**
 * Class Adjustment
 *
 * @package hvointern\FbMessenger\Messages
 */
class Adjustment
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * Adjustment constructor.
     *
     * @param array $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get Data
     * 
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}