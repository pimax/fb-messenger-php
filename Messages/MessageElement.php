<?php

namespace pimax\Messages;


class MessageElement
{
    protected $title = null;

    protected $image_url = null;

    protected $subtitle = null;

    protected $buttons = [];

    public function __construct($title, $subtitle, $image_url = '', $buttons = [])
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->image_url = $image_url;
        $this->buttons = $buttons;
    }

    public function getData()
    {
        $result = [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'image_url' => $this->image_url,
        ];

        if (!empty($this->buttons)) {
            $result['buttons'] = [];

            foreach ($this->buttons as $btn) {
                $result['buttons'][] = $btn->getData();
            }
        }

        return $result;
    }
}