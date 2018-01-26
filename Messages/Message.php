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
     * Messaging types //https://developers.facebook.com/docs/messenger-platform/send-messages#messaging_types
     */
    const TYPE_RESPONSE = "RESPONSE";
    const TYPE_UPDATE = "UPDATE";
    const TYPE_MESSAGE_TAG = "MESSAGE_TAG";
    const TYPE_NON_PROMOTIONAL_SUBSCRIPTION = "NON_PROMOTIONAL_SUBSCRIPTION";

    /**
     * Tag types // https://developers.facebook.com/docs/messenger-platform/send-messages/message-tags
     */
    const TAG_SHIPPING_UPDATE = "SHIPPING_UPDATE";
    const TAG_RESERVATION_UPDATE = "RESERVATION_UPDATE";
    const TAG_ISSUE_RESOLUTION = "ISSUE_RESOLUTION";
    const TAG_ACCOUNT_UPDATE = "ACCOUNT_UPDATE";
    const TAG_PAYMENT_UPDATE = "PAYMENT_UPDATE";
    const TAG_PERSONAL_FINANCE_UPDATE = "PERSONAL_FINANCE_UPDATE";
    const TAG_PAIRING_UPDATE = "PAIRING_UPDATE";
    const TAG_APPLICATION_UPDATE = "APPLICATION_UPDATE";
    const TAG_APPOINTMENT_UPDATE = "APPOINTMENT_UPDATE";
    const TAG_FEATURE_FUNCTIONALITY_UPDATE = "FEATURE_FUNCTIONALITY_UPDATE";
    const TAG_GAME_EVENT = "GAME_EVENT";
    const TAG_TRANSPORTATION_UPDATE = "TRANSPORTATION_UPDATE";
    const TAG_TICKET_UPDATE = "TICKET_UPDATE";

    /**
     * Notification types
     */
    const NOTIFY_REGULAR = "REGULAR";
    const NOTIFY_SILENT_PUSH = "SILENT_PUSH";
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
     * @var null|string
     */
    protected $messaging_type = null;

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
    public function __construct($recipient, $text, $user_ref = false, $tag = null, $notification_type = self::NOTIFY_REGULAR, $messaging_type = self::TYPE_RESPONSE)
    {
        $this->recipient = $recipient;
        $this->text = $text;
        $this->user_ref = $user_ref;
        $this->tag = $tag;
        $this->notification_type = $notification_type;
        $this->messaging_type = $messaging_type;
        $this->messaging_type = $messaging_type;
    }

    public function setTag($tag) {
        $this->tag = $tag;
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
            'notification_type'=> $this->notification_type,
            'messaging_type' => $this->messaging_type
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
