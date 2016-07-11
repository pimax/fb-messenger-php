<?php

namespace pimax\Messages;

/**
 * Class ImageMessage
 *
 * @package pimax\Messages
 */
class ImageMessage extends Message
{
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

        $attachment = new Attachment(Attachment::TYPE_IMAGE);

        if (strpos($this->text, 'http://') === 0 || strpos($this->text, 'https://') === 0) {
            $attachment->setPayload(array('url' => $this->text));
        } else {
            $attachment->setFileData($this->getCurlValue($this->text, mime_content_type($this->text), basename($this->text)));
        }

        $res['message'] = $attachment->getData();

        return $res;
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