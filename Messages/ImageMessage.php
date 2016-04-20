<?php

namespace pimax\Messages;


/**
 * Class ImageMessage
 *
 * @package pimax\Messages
 */
class ImageMessage
{
    /**
     * @var integer|null
     */
    protected $recipient = null;

    /**
     * @var string
     */
    protected $text = null;

    /**
     * Message constructor.
     *
     * @param $recipient
     * @param $file Web Url or local file with @ prefix
     */
    public function __construct($recipient, $file)
    {
        $this->recipient = $recipient;
        $this->text = $file;

    }

    /**
     * Get message data
     *
     * @return array
     */
    public function getData()
    {
        $res = [
            'recipient' =>  [
                'id' => $this->recipient
            ]
        ];

        if (strpos($this->text, '@') === 0) {
            // Local file

            $res['message'] = [
                'attachment' => [
                    'type' => 'image',
                    'payload' => []
                ]

            ];

            $res['filedata'] = $this->text;

        } else {
            // Url

            $res['message'] = [
                'attachment' => [
                    'type' => 'image',
                    'payload' => [
                        'url' => $this->text
                    ]
                ]
            ];
        }


        return $res;
    }
}