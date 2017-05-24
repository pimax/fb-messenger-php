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
     * Tag type
     */
    const TAG_SHIPPING_UPDATE = "SHIPPING_UPDATE";

    /**
     * Tag type
     */
    const TAG_RESERVATION_UPDATE = "RESERVATION_UPDATE";

    /**
     * Tag type
     */
    const TAG_ISSUE_RESOLUTION = "ISSUE_RESOLUTION";

    /**
     * Notification type
     */
    const NOTIFY_REGULAR = "REGULAR";

    /**
     * Notification type
     */
    const NOTIFY_SILENT_PUSH = "SILENT_PUSH";

    /**
     * Notification type
     */
    const NOTIFY_NO_PUSH = "NO_PUSH";

    /**
     * @var null|string
     */
    protected $recipient = null;

    /**
     * @var null|string
     */
    protected $text = null;

    /**
     * @var bool
     */
    protected $user_ref = false;

    /**
     * @var null|string
     */
    protected $tag = null;

    /**
     * @var null|string
     */
    protected $notification_type = null;

    /**
     * @var null|array
     */
    protected $quick_replies = null;
    
    /**
     * Message constructor.
     *
     * @param string $recipient
     * @param string $text
     * @param string $tag - SHIPPING_UPDATE, RESERVATION_UPDATE, ISSUE_RESOLUTION
     * https://developers.facebook.com/docs/messenger-platform/send-api-reference/tags
     * @param string $notification_type - REGULAR, SILENT_PUSH, or NO_PUSH
     * https://developers.facebook.com/docs/messenger-platform/send-api-reference
     */
    public function __construct($recipient, $text, $user_ref = false, $tag = null, $notification_type = self::NOTIFY_REGULAR)
    {
        $this->recipient = $recipient;
        $this->text = $text;
        $this->user_ref = $user_ref;
        $this->tag = $tag;
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
            'recipient' => $this->user_ref ? ['user_ref' => $this->recipient] : ['id' => $this->recipient],
            'message' => [
                'text' => $this->text
            ],
            'tag'=> $this->tag,
            'notification_type'=> $this->notification_type
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
