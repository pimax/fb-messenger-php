<?php

namespace pimax\Messages;
/**
 * Class QuickReply
 *
 * @package pimax\Messages
 */
class QuickReply extends Message{
    /**
     * @var array
     */
    protected $quick_replies = null;

    /**
     * Message constructor.
     *
     * @param $recipient
     * @param $text - string
     * @param $quick_replies - array of array("content_type","title","payload"),..,..
     */
    public function __construct($recipient, $text, $quick_replies)
    {
        $this->quick_replies = $quick_replies;
        parent::__construct($recipient,$text);
    }
    public function getData() {
        return [
            'recipient' =>  [
                'id' => $this->recipient
            ],
            'message' => [
                'text' => $this->text,
                'quick_replies'=>$this->quick_replies
            ]
        ];

        
    }
}

