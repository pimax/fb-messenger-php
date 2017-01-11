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
     * account_link button type
     */
    const TYPE_ACCOUNT_LINK = "account_link";

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
     * Button webview_height_ratio
     *
     * @var null|string
     */
    protected $webview_height_ratio = null;
    
    /**
     * Button messenger_extensions
     *
     * @var null|boolean
     */
    protected $messenger_extensions = null;    

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
     * @param string $webview_height_ratio
     * @param string $url url or postback
     */
    public function __construct($type, $title, $url = '', $webview_height_ratio = 'full', $messenger_extensions = false) 
    {
        $this->type = $type;
        $this->title = $title;
        $this->webview_height_ratio = $webview_height_ratio;	
        $this->messenger_extensions = $messenger_extensions;
	
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
            'type' => $this->type,
            'title' => $this->title,
            'webview_height_ratio' => $this->webview_height_ratio
        ];
	
	if ($this->messenger_extensions == true) {
    	     $result['messenger_extensions'] = $this->messenger_extensions;
	}

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

            case self::TYPE_ACCOUNT_LINK:
                $result['url'] = $this->url;
            break;
        }

        return $result;
    }
}
