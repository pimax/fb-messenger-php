<?php

namespace pimax\Messages;


/**
 * Class SenderAction
 *
 * @package pimax\Messages
 */
class SenderAction
{
    /* sender_action possible values */
    
    const ACTION_MARK_SEEN = "mark_seen";
    
    const ACTION_TYPING_ON = "typing_on";
    
    const ACTION_TYPING_OFF = "typing_off";

    /**
     * @var null|string
     */
    protected $recipient = null;

    /**
     * @var null|string
     */
    protected $action = null;

    /**
     * Message constructor.
     *
     * @param string $recipient
     * @param string $action
     */
    public function __construct($recipient, $action)
    {
        $this->recipient = $recipient;
        $this->action = $action;

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
            'sender_action' => $this->action
        ];
    }
}