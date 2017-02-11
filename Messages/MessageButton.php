<?php

namespace pimax\Messages;

/**
 * Class MessageButton
 * @package pimax\Messages
 */
class MessageButton
{
    /**
     * Web url button type
     */
    const TYPE_WEB = "web_url";

    /**
     * Postback button type
     */
    const TYPE_POSTBACK = "postback";
    
    /**
     * Account link type
     */
    const TYPE_ACCOUNT_LINK = "account_link";
  
    /**
     * Account unlink type
     */
    const TYPE_ACCOUNT_UNLINK = "account_unlink";

    /**
     * Button type
     *
     * @var null|string
     */
    protected $type = null;

    /**
     * Button title
     *
     * @var null|string
     */
    protected $title = null;

    /**
     * Button url
     *
     * @var null|string
     */
    protected $url = null;

    /**
     * MessageButton constructor.
     *
     * @param string $type
     * @param string $title
     * @param string $url url or postback
     */
    public function __construct($type, $title, $url = '')
    {
        $this->type = $type;
        $this->title = $title;

        if (!$url) {
            $url = $title;
        }

        $this->url = $url;
    }

    /**
     * Get Button data
     * 
     * @return array
     */
    public function getData()
    {
        $result = [
            'type' => $this->type
        ];

        switch($this->type)
        {
            case self::TYPE_POSTBACK:
                $result['payload'] = $this->url;
                $result['title'] = $this->title;
            break;

            case self::TYPE_WEB:
              $result['title'] = $this->title;
              $result['url'] = $this->url;
            break;
          
            case self::TYPE_ACCOUNT_LINK:
                $result['url'] = $this->url;
            break;
           
            case self::TYPE_ACCOUNT_UNLINK:
              //only type needed
            break;
        }

        return $result;
    }
}