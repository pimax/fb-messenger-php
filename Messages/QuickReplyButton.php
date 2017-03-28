<?php

namespace pimax\Messages;

/**
 * Class MessageButton
 * @package pimax\Messages
 */
class QuickReplyButton
{
    /**
     * Text quick reply
     */
    const TYPE_TEXT = "text";

    /**
     * Location quick reply
     */
    const TYPE_LOCATION = "location";

    /**
     * Button type
     *
     * @var null|string
     */
    protected $type = null;

    /**
     * Button title
     *
     * @var null|string
     */
    protected $title = null;

    /**
     * Button payload
     *
     * @var null|string
     */
    protected $payload = null;

    /**
     * Image url of quick reply icon
     *
     * @var boolean
     */
    protected $image_url = false;

    /**
     * MessageButton constructor.
     *
     * @param string $type
     * @param string $title
     * @param string $url url or postback
     */
    public function __construct($type, $title = '', $payload = null, $image_url = null)
    {
        $this->type = $type;
        $this->title = $title;
        $this->payload = $payload;
        $this->image_url = $image_url;

    }

    /**
     * Get Button data
     *
     * @return array
     */
    public function getData()
    {
        $result = [
            'content_type' => $this->type
        ];

        switch($this->type)
        {
            case self::TYPE_LOCATION:
                $result['image_url'] = $this->image_url;
            break;

            case self::TYPE_TEXT:
                $result['payload'] = $this->payload;
                $result['title'] = $this->title;
                $result['image_url'] = $this->image_url;
            break;
        }

        return $result;
    }
}
