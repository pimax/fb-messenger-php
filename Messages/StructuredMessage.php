<?php

namespace pimax\Messages;

/**
 * Class StructuredMessage
 * @package pimax\Messages
 */
class StructuredMessage extends Message
{
    const TYPE_BUTTON = "button";

    const TYPE_GENERIC = "generic";

    const TYPE_RECEIPT = "receipt";

    protected $type = null;

    protected $title = null;

    protected $subtitle = null;

    protected $elements = [];

    protected $buttons = [];

    protected $recipient_name = null;

    protected $order_number = null;

    protected $currency = "USD";

    protected $payment_method = null;

    protected $order_url = null;

    protected $timestamp = null;

    protected $address = [];

    protected $summary = [];

    protected $adjustments = [];

    public function __construct($recipient, $type, $data)
    {
        $this->recipient = $recipient;
        $this->type = $type;

        switch ($type)
        {
            case self::TYPE_BUTTON:
                $this->title = $data['text'];
                $this->buttons = $data['buttons'];
            break;

            case self::TYPE_GENERIC:
                $this->elements = $data['elements'];
            break;

            case self::TYPE_RECEIPT:
                $this->recipient_name = $data['recipient_name'];
                $this->order_number = $data['order_number'];
                $this->currency = $data['currency'];
                $this->payment_method = $data['payment_method'];
                $this->order_url = $data['order_url'];
                $this->timestamp = $data['timestamp'];
                $this->elements = $data['elements'];
                $this->address = $data['address'];
                $this->summary = $data['summary'];
                $this->adjustments = $data['adjustments'];
            break;
        }
    }

    public function getData()
    {
        $result = [
            'attachment' => [
                'type' => 'template',
                'payload' => [
                    'template_type' => $this->type
                ]
            ]
        ];

        switch ($this->type)
        {
            case self::TYPE_BUTTON:
                $result['attachment']['payload']['text'] = $this->title;
                $result['attachment']['payload']['buttons'] = [];

                foreach ($this->buttons as $btn) {
                    $result['attachment']['payload']['buttons'][] = $btn->getData();
                }

            break;

            case self::TYPE_GENERIC:
                $result['attachment']['payload']['elements'] = [];

                foreach ($this->elements as $btn) {
                    $result['attachment']['payload']['elements'][] = $btn->getData();
                }
            break;

            case self::TYPE_RECEIPT:
                $result['attachment']['payload']['recipient_name'] = $this->recipient_name;
                $result['attachment']['payload']['order_number'] = $this->order_number;
                $result['attachment']['payload']['currency'] = $this->currency;
                $result['attachment']['payload']['payment_method'] = $this->payment_method;
                $result['attachment']['payload']['order_url'] = $this->order_url;
                $result['attachment']['payload']['timestamp'] = $this->timestamp;
                $result['attachment']['payload']['elements'] = [];

                foreach ($this->elements as $btn) {
                    $result['attachment']['payload']['elements'][] = $btn->getData();
                }

                $result['attachment']['payload']['address'] = $this->address->getData();
                $result['attachment']['payload']['summary'] = $this->summary->getData();
                $result['attachment']['payload']['adjustments'] = [];

                foreach ($this->adjustments as $btn) {
                    $result['attachment']['payload']['adjustments'][] = $btn->getData();
                }
            break;
        }

        return [
            'recipient' =>  [
                'id' => $this->recipient
            ],
            'message' => $result
        ];
    }
}