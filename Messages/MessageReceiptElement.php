<?php

namespace pimax\Messages;


/**
 * Class MessageReceiptElement
 *
 * @package pimax\Messages
 */
class MessageReceiptElement extends MessageElement
{
    /**
     * @var int
     */
    protected $quantity = 1;

    /**
     * @var int
     */
    protected $price = 0;

    /**
     * @var string
     */
    protected $currency = "USD";

    /**
     * MessageReceiptElement constructor.
     *
     * @param string $title
     * @param string $subtitle
     * @param string $image_url
     * @param int    $quantity
     * @param int    $price
     * @param string $currency
     */
    public function __construct($title, $subtitle, $image_url = '', $quantity = 1, $price = 0, $currency = "USD")
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->image_url = $image_url;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->currency = $currency;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'image_url' => $this->image_url,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'currency' => $this->currency
        ];
    }
}