<?php

namespace pimax\Messages;


/**
 * Class MessageElement
 *
 * @package pimax\Messages
 */
class MessageElement
{
    /**
     * Title
     *
     * @var null|string
     */
    protected $title = null;

    /**
     * Image url
     *
     * @var null|string
     */
    protected $image_url = null;

    /**
     * Subtitle
     *
     * @var null|string
     */
    protected $subtitle = null;

    /**
     * Url
     *
     * @var null|string
     */
    protected $url = null;

    /**
     * Buttons
     *
     * @var array
     */
    protected $buttons = [];

    /**
     * Default Action
     *
     * @var array
     */
    protected $default_action = [];

    /**
     * MessageElement constructor.
     *
     * @param string $title
     * @param string $subtitle
     * @param string $image_url
     * @param array  $buttons
     */
    public function __construct($title, $subtitle, $image_url = '', $buttons = [], $url = '', $default_action = [])
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->url = $url;
        $this->image_url = $image_url;
        $this->buttons = $buttons;
        $this->default_action = $default_action;
    }

    /**
     * Get Element data
     *
     * @return array
     */
    public function getData()
    {
        $result = [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'item_url' => $this->url,
            'image_url' => $this->image_url,
            'default_action' => $this->default_action
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
