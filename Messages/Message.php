<?php

namespace pimax\Messages;


/**
 * Class Message
 *
 * @package pimax\Messages
 */
class Message
{
    /**
     * @var null|string
     */
    protected $recipient = null;

    /**
     * @var null|string
     */
    protected $text = null;

    /**
     * Message constructor.
     *
     * @param string $recipient
     * @param string $text
     */
    public function __construct($recipient, $text)
    {
        $this->recipient = $recipient;
        $this->text = $text;

    }

    /**
     * Get message data
     *
     * @return array
     */
    public function getData()
    {
        return [
            'recipient' =>  [
                'id' => $this->recipient
            ],
            'message' => [
                'text' => $this->text
            ]
        ];
    }
}