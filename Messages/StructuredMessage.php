<?php

namespace pimax\Messages;

/**
 * Class StructuredMessage
 *
 * @package pimax\Messages
 */
class StructuredMessage extends Message
{
    /**
     * Structured message button type
     */
    const TYPE_BUTTON = "button";

    /**
     * Structured message generic type
     */
    const TYPE_GENERIC = "generic";
    
    /**
     * Structured message list type
     */
    const TYPE_LIST = "list";

    /**
     * Structured message receipt type
     */
    const TYPE_RECEIPT = "receipt";

    /**
     * @var null|string
     */
    protected $type = null;

    /**
     * @var null|string
     */
    protected $title = null;

    /**
     * @var null|string
     */
    protected $subtitle = null;

    /**
     * @var array
     */
    protected $elements = [];

    /**
     * @var array
     */
    protected $buttons = [];

    /**
     * @var null|string
     */
    protected $recipient_name = null;

    /**
     * @var null|integer
     */
    protected $order_number = null;

    /**
     * @var string
     */
    protected $currency = "USD";

    /**
     * @var null|string
     */
    protected $payment_method = null;

    /**
     * @var null|string
     */
    protected $order_url = null;

    /**
     * @var null|integer
     */
    protected $timestamp = null;

    /**
     * @var array
     */
    protected $address = [];

    /**
     * @var array
     */
    protected $summary = [];

    /**
     * @var array
     */
    protected $adjustments = [];
    
    /**
     * @var string
     */
    protected $top_element_style = 'large';
    

    /**
     * StructuredMessage constructor.
     *
     * @param string $recipient
     * @param string $type
     * @param array  $data
     */
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
        
            case self::TYPE_LIST:
                $this->elements = $data['elements'];
                //allowed is a sinle button for the whole list
                if(isset($data['buttons'])){
                    $this->buttons = $data['buttons'];
                }
                //the top_element_style indicate if the first item is featured or not.
                //default is large
                if(isset($data['top_element_style'])){
                    $this->top_element_style = $data['top_element_style'];
                }
                //if the top_element_style is large the first element image_url MUST be set.
                if($this->top_element_style == 'large' && (!isset($data['elements'][0]->getData()['image_url']) || $data['elements'][0]->getData()['image_url'] == '')){
                    $message = 'Facbook require the image_url to be set for the first element if the top_element_style is large. set the image_url or change the top_element_style to compact.';
                    throw new \Exception($message);
                }
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

    /**
     * Get Data
     *
     * @return array
     */
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
            
            case self::TYPE_LIST:
                $result['attachment']['payload']['elements'] = [];
                $result['attachment']['payload']['top_element_style'] = $this->top_element_style;
                //list items button
                foreach ($this->elements as $btn) {
                    $result['attachment']['payload']['elements'][] = $btn->getData();
                }
                //the whole list button
                foreach ($this->buttons as $btn) {
                    $result['attachment']['payload']['buttons'][] = $btn->getData();
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