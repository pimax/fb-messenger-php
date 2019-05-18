<?php

namespace pimax\Messages;

/**
 * Class Attachment
 */
class Attachment
{
    const TYPE_IMAGE = 'image';
    const TYPE_AUDIO = 'audio';
    const TYPE_VIDEO = 'video';
    const TYPE_FILE = 'file';
    const TYPE_LOCATION = 'location';

    /**
     * @var string
     */
    private $type;

    /**
     * @var array
     */
    private $payload = array();

    /**
     * @var string
     */
    private $fileData;

    /**
     * @var array
     */
    private $quick_replies = array();

    /**
     * Attachment constructor.
     * @param string $type
     * @param array  $payload
     */
    public function __construct($type, $payload = array(), $quick_replies = array())
    {
        $this->type = $type;
        $this->payload = $payload;
        $this->quick_replies = $quick_replies;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param array $payload
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;
    }

    /**
     * @return string
     */
    public function getFileData()
    {
        return $this->fileData;
    }

    /**
     * @param string $fileData
     */
    public function setFileData($fileData)
    {
        $this->fileData = $fileData;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $data = [
            'attachment' => [
                'type' => $this->type,
                'payload' => $this->payload
            ]
        ];

        foreach ($this->quick_replies as $qr) {
            $data['quick_replies'][] = $qr->getData();
        }

        if (!empty($this->fileData)) {
            $data['filedata'] = $this->fileData;
        }
        return $data;
    }
}
