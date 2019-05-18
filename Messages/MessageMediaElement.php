<?php

namespace pimax\Messages;


/**
 * Class MessageElement
 *
 * @package pimax\Messages
 */
class MessageMediaElement
{
    /**
     * Type
     *
     * @var null|string
     */
    protected $type = null;

    /**
     * Image url
     *
     * @var null|string
     */
    protected $url = null;

    /**
     * Attachment id
     *
     * @var null|string
     */
    protected $attachment_id = null;


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
    public function __construct($type, $url = '', $attachment_id = '', $buttons = [])
    {
        $this->type = $type;
        $this->url = $url;
        $this->attachment_id = $attachment_id;
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
            'type' => $this->type,
        ];

        if (!empty($this->url)) {
            $result['url'] = $this->url;
        }

        if (!empty($this->attachment_id)) {
            $result['attachment_id'] = $this->attachment_id;
        }

        if (!empty($this->buttons)) {
            $result['buttons'] = [];

            foreach ($this->buttons as $btn) {
                $result['buttons'][] = $btn->getData();
            }
        }

        return $result;
    }
}
