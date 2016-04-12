<?php

namespace pimax;


/**
 * Class Message
 *
 * @package pimax
 */
class Message
{
    protected $recipient = null;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * Message constructor.
     *
     * @param $data Message data
     */
    public function __construct($recipient, $data)
    {
        $this->recipient = $recipient;
        $this->data = $data;
    }

    /**
     * Get message data
     *
     * @return array
     */
    public function getData()
    {
        return ['recipient' => ['id' => $this->recipient], 'message' => $this->data];
    }
}