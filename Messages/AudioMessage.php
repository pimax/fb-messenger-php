<?php

namespace pimax\Messages;


/**
 * Class AudioMessage
 *
 * @package pimax\Messages
 */
class AudioMessage extends Message
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
     * @var null|string
     */
    protected $type = null;

    /**
     * Message constructor.
     *
     * @param string $recipient
     * @param string $file Web Url or local file with @ prefix
     */
    public function __construct($recipient, $file)
    {
        $this->recipient = $recipient;
        $this->text = $file;
        $this->type = Attachment::TYPE_AUDIO;
    }
}
