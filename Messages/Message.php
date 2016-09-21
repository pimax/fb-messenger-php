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
    protected $type = null;

    /**
     * Message constructor.
     *
     * @param string $recipient
     * @param string $text
     */
    public function __construct($recipient, $text)
    {
        $this->recipient = $recipient;
        $this->text = $text;

    }

    /**
     * Get message data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->type)) {
            $res = [
                'recipient' =>  [
                    'id' => $this->recipient
                ]
            ];

            $attachment = new Attachment($this->type);

            if (preg_match("/^http[s]{0,1}\:\/\//", $this->text)) {
                $attachment->setPayload(['url' => $this->text]);
                $res['message'] = $attachment->getData();
            } else {
                $attachment->setFileData($this->getCurlValue($this->text, mime_content_type($this->text), basename($this->text)));
                $res['message'] = $attachment->getData();
                $res['filedata'] = $res['message']['filedata'];
                unset($res['message']['filedata']);
            }

            foreach ($res as $key => $value) {
                $res[$key] = is_array($value) ? json_encode($value) : $value;
            }

            return $res;
        } else {
            return [
                'recipient' =>  [
                    'id' => $this->recipient
                ],
                'message' => [
                    'text' => $this->text
                ]
            ];
        }
    }

    /**
     * @param string $filename
     * @param string $contentType
     * @param string $postname
     * @return \CURLFile|string
     */
    protected function getCurlValue($filename, $contentType = "", $postname = "")
    {
        $filename = realpath($filename);

        // PHP 5.5 introduced a CurlFile object that deprecates the old @filename syntax
        // See: https://wiki.php.net/rfc/curl-file-upload
        if (function_exists('curl_file_create')) {
            return curl_file_create($filename, $contentType, $postname);
        }

        // Use the old style if using an older version of PHP
        $value = "@{$filename}" . $postname ?: ";filename={$postname}" . $contentType ?: ";type={$contentType}";

        return $value;
    }
}
