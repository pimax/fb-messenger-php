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
     * @var string|null
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
     * Buttons
     *
     * @var array
     */
    protected $buttons = [];

    /**
     * MessageElement constructor.
     *
     * @param $title
     * @param $subtitle
     * @param string $image_url
     * @param array $buttons
     */
    public function __construct($title, $subtitle, $image_url = '', $buttons = [])
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->image_url = $image_url;
        $this->buttons = $buttons;
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