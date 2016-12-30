<?php

namespace pimax\Messages;


/**
 * Class Message
 *
 * @package pimax\Messages
 */
class Message
{
    /**
     * Push notification type: REGULAR
     */
    const NOTIFICATION_REGULAR = "REGULAR";

    /**
     * Push notification type: SILENT_PUSH
     */
    const NOTIFICATION_SILENT_PUSH = "SILENT_PUSH";

    /**
     * Push notification type: NO_PUSH
     */
    const NOTIFICATION_NO_PUSH = "NO_PUSH";
    
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
    protected $notification_type = null;

    /**
     * Message constructor.
     *
     * @param string $recipient
     * @param string $text
     * @param string $notification_type
     */
    public function __construct($recipient, $text, $notification_type = self::NOTIFICATION_REGULAR)
    {
        $this->recipient = $recipient;
        $this->text = $text;
        $this->notification_type = $notification_type;
    }

    /**
     * Get message data
     *
     * @return array
     */
    public function getData()
    {
        return [
            'recipient' =>  [
                'id' => $this->recipient
            ],
            'message' => [
                'text' => $this->text
            ],
            'notification_type' =>
                $this->notification_type

        ];
    }

    /**
     * @param string $filename
     * @param string $contentType
     * @param string $postname
     * @return \CURLFile|string
     */
    protected function getCurlValue($filename, $contentType, $postname)
    {
        // PHP 5.5 introduced a CurlFile object that deprecates the old @filename syntax
        // See: https://wiki.php.net/rfc/curl-file-upload
        if (function_exists('curl_file_create')) {
            return curl_file_create($filename, $contentType, $postname);
        }

        // Use the old style if using an older version of PHP
        $value = "@{$this->filename};filename=" . $postname;
        if ($contentType) {
            $value .= ';type=' . $contentType;
        }

        return $value;
    }
}
