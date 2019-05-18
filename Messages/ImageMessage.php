<?php

namespace pimax\Messages;


/**
 * Class ImageMessage
 *
 * @package pimax\Messages
 */
class ImageMessage extends Message
{
    // /**
    //  * @var null|string
    //  */
    // protected $recipient = null;
    //
    // /**
    //  * @var null|string
    //  */
    // protected $text = null;

    // /**
    //  * @var null|array
    //  */
    // protected $quick_replies = null;

    /**
     * Message constructor.
     *
     * @param string $recipient
     * @param string $file Web Url, local file with @ prefix, attachment_id
     * @param array $quick_replies array of array to be added after attachment
     * @param string $notification_type - REGULAR, SILENT_PUSH, or NO_PUSH
     * https://developers.facebook.com/docs/messenger-platform/send-api-reference
     */

    public function __construct($recipient, $file, $quick_replies = array(), $notification_type = parent::NOTIFY_REGULAR, $messaging_type = parent::TYPE_RESPONSE)
    {
        $this->recipient = $recipient;
        $this->text = $file;
        $this->quick_replies = $quick_replies;
        $this->notification_type = $notification_type;
        $this->messaging_type = $messaging_type;
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
            ],
            'notification_type'=> $this->notification_type,
            'messaging_type' => $this->messaging_type
        ];

        $attachment = new Attachment(Attachment::TYPE_IMAGE, [], $this->quick_replies);

        if (strcmp(intval($this->text), $this->text) === 0) {
            $attachment->setPayload(array('attachment_id' => $this->text));
            $res['message'] = $attachment->getData();
        } elseif (strpos($this->text, 'http://') === 0 || strpos($this->text, 'https://') === 0) {
            $attachment->setPayload(array('url' => $this->text));
            $res['message'] = $attachment->getData();
        } else {
            $attachment->setPayload(array('url' => basename($this->text)));
            $attachment->setFileData($this->getCurlValue($this->text, mime_content_type($this->text), basename($this->text)));
            $res['message'] = $attachment->getData();
            $res['filedata'] = $res['message']['filedata'];
            unset($res['message']['filedata']);
        }

        return $res;
    }
}
