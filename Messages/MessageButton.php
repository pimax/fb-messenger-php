<?php

namespace pimax\Messages;

/**
 * Class MessageButton
 * @package pimax\Messages
 */
class MessageButton
{
    /**
     * Web url button type
     */
    const TYPE_WEB = "web_url";

    /**
     * Postback button type
     */
    const TYPE_POSTBACK = "postback";

    /**
     * Button type
     *
     * @var string|null
     */
    protected $type = null;

    /**
     * Button title
     *
     * @var string|null
     */
    protected $title = null;

    /**
     * Button url
     *
     * @var null|string
     */
    protected $url = null;

    /**
     * MessageButton constructor.
     *
     * @param $type Type
     * @param $title Title
     * @param string $url Url or postback
     */
    public function __construct($type, $title, $url = '')
    {
        $this->type = $type;
        $this->title = $title;

        if (!$url) {
            $url = $title;
        }

        $this->url = $url;
    }

    /**
     * Get Button data
     * 
     * @return array
     */
    public function getData()
    {
        $result = [
            'type' => $this->type,
            'title' => $this->title,
        ];

        switch($this->type)
        {
            case self::TYPE_POSTBACK:
                $result['payload'] = $this->url;
            break;

            case self::TYPE_WEB:
                $result['url'] = $this->url;
            break;
        }

        return $result;
    }
}