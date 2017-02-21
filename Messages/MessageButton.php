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
     * Postback button type
     */
    const TYPE_SHARE = "element_share";
    
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
     * Webview height ratio ("compact", "tall" or "full")
     *
     * @var null|string
     */
    protected $webview_height_ratio = null;

    /**
     * Messenger extensions which enable your web page to integrate with Messenger using js
     *
     * @var boolean
     */
    protected $messenger_extensions = false;

    /**
     * Fallback url to use on clients that don't support Messenger Extensions
     *
     * @var null|string
     */
    protected $fallback_url = null;

    /**
     * MessageButton constructor.
     *
     * @param string $type
     * @param string $title
     * @param string $url url or postback
     */
    public function __construct($type, $title = '', $url = '', $webview_height_ratio = '', $messenger_extensions = false, $fallback_url = '')
    {
        $this->type = $type;
        $this->title = $title;
        
        $this->webview_height_ratio = $webview_height_ratio;
        $this->messenger_extensions = $messenger_extensions;
        $this->fallback_url = $fallback_url;

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
                
              if ($this->webview_height_ratio) {
                  $result['webview_height_ratio'] = $this->webview_height_ratio;
              }
              
              if ($this->messenger_extensions){
                  $result['messenger_extensions'] = $this->messenger_extensions;
                  $result['fallback_url'] = $this->fallback_url;
              }
            break;
          
            case self::TYPE_ACCOUNT_LINK:
                $result['url'] = $this->url;
            break;
           
            case self::TYPE_ACCOUNT_UNLINK:
              //only type needed
            break;
            
            case self::TYPE_SHARE:
              //only type needed  
            break;
        }

        return $result;
    }
}
