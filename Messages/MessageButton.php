<?php

namespace pimax\Messages;


class MessageButton
{
    const TYPE_WEB = "web_url";

    const TYPE_POSTBACK = "postback";

    protected $type = null;

    protected $title = null;

    protected $url = null;

    public function __construct($type, $title, $url = '')
    {
        $this->type = $type;
        $this->title = $title;

        if (!$url) {
            $url = $title;
        }

        $this->url = $url;
    }

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