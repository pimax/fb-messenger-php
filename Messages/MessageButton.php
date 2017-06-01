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
     * Call button type
     */
    const TYPE_CALL = "phone_number";

    /**
     * Share button type
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
     * Specify a different Message than the message the "Share" button is attached to
     *
     * @var null|array
     */
    protected $share_contents = null;

    /*
     * Set to hide to disable sharing in the webview (for sensitive info).
     * 
     * @var null|string
     */
    protected $webview_share_button = null;

    /**
     * MessageButton constructor.
     *
     * @param string $type
     * @param string $title
     * @param string $url url or postback
     * @param string $webview_height_ratio
     * @param boolean $messenger_extensions
     * @param string $fallback_url
     * @param string $share_contents
     * @param string $webview_share_button
     */
    public function __construct($type, $title = '', $url = '', $webview_height_ratio = '', $messenger_extensions = false, $fallback_url = '', $share_contents = null, $webview_share_button = null)
    {
        $this->type = $type;
        $this->title = $title;

        $this->webview_height_ratio = $webview_height_ratio;
        $this->messenger_extensions = $messenger_extensions;
        $this->fallback_url = $fallback_url;
        $this->share_contents = $share_contents;
        $this->webview_share_button = $webview_share_button;
        
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
                $result['title'] = $this->title;
                $result['payload'] = $this->url;
            break;

            case self::TYPE_CALL:
                $result['title'] = $this->title;
                $result['payload'] = $this->url;
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
              
              if($this->webview_share_button){
                  $result['webview_share_button'] = $this->webview_share_button ;
              }
            break;

            case self::TYPE_SHARE:
              //only share_contents needed
               if ($this->share_contents)
                $result['share_contents'] = $this->share_contents->getData();
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
