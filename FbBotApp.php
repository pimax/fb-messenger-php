<?php

namespace pimax;

use pimax\Messages\Message;
use pimax\Messages\MessageButton;

class FbBotApp
{
    /**
     * Request type GET
     */
    const TYPE_GET = "get";
    
    /**
     * Request type POST
     */
    const TYPE_POST = "post";

    /**
     * Request type DELETE
     */
    const TYPE_DELETE = "delete";
    
    /**
     * FB Messenger API Url
     *
     * @var string
     */
    protected $apiUrl = 'https://graph.facebook.com/v2.6/';
    
    /**
     * @var null|string
     */
    protected $token = null;

    /**
     * FbBotApp constructor.
     * @param string $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Send Message
     *
     * @param Message $message
     * @return array
     */
    public function send($message)
    {
        return $this->call('me/messages', $message->getData());
    }

    /**
     * Get User Profile Info
     *
     * @param int    $id
     * @param string $fields
     * @return UserProfile
     */
    public function userProfile($id, $fields = 'first_name,last_name,profile_pic,locale,timezone,gender')
    {
        return new UserProfile($this->call($id, [
            'fields' => $fields
        ], self::TYPE_GET));
    }

    /**
     * Set Get Started Button
     *
     * @see https://developers.facebook.com/docs/messenger-platform/thread-settings/get-started-button
     * @param string $payload
     * @return array
     */
    public function setGetStartedButton($payload)
    {
        return $this->call('me/messenger_profile', [
            'get_started' => ['payload' => $payload]
        ], self::TYPE_POST);
    }
    
    /**
     * Delete Get Started Button
     *
     * @see https://developers.facebook.com/docs/messenger-platform/thread-settings/get-started-button
     * @return array
     */
    public function deleteGetStartedButton()
    {
        return $this->call('me/messenger_profile', [
            'fields' => ['get_started'],
        ], self::TYPE_DELETE); 
    }
    
    
    /**
     * Set Greeting Message
     *
     * @see https://developers.facebook.com/docs/messenger-platform/thread-settings/greeting-text
     * @param string $greetingText
     * @return array
     */
    public function setGreetingText($greetingText){
        return $this->call('me/thread_settings', [
            'setting_type' => 'greeting',
            'greeting' => ['text' => $greetingText]
        ], self::TYPE_POST);
    }
    
    
    /**
     * Delete Greeting Text
     *
     * @see https://developers.facebook.com/docs/messenger-platform/thread-settings/greeting-text
     * @return array
     */
    public function deleteGreetingText()
    {
        return $this->call('me/thread_settings', [
            'setting_type' => 'greeting'
        ], self::TYPE_DELETE);
    }
    
    
    /**
     * Set Nested Menu
     *
     * @see https://developers.facebook.com/docs/messenger-platform/messenger-profile/persistent-menu
     * @param Menu\LocalizedMenu[] $localizedMenu
     * @return array
     */
    public function setPersistentMenu($localizedMenu)
    {
        $elements = [];

        foreach ($localizedMenu as $menu) {
            $elements[] = $menu->getData();
        }
        
        return $this->call('me/messenger_profile', [
            'persistent_menu' => $elements
        ], self::TYPE_POST);
    }
    
    /**
     * Remove Persistent Menu
     *
     * @see https://developers.facebook.com/docs/messenger-platform/messenger-profile/persistent-menu
     * @return array
     */
    public function deletePersistentMenu()
    {
        return $this->call('me/messenger_profile', [
            'fields' => ['persistent_menu'],
        ], self::TYPE_DELETE);
    }

    /**
     * Request to API
     *
     * @access public
     * @param string $url
     * @param array  $data
     * @param string $type Type of request (GET|POST|DELETE)
     * @return array
     */
    public function call($url, $data, $type = self::TYPE_POST)
    {
        $data['access_token'] = $this->token;

        $headers = [
            'Content-Type: application/json',
        ];

        if ($type == self::TYPE_GET) {
            $url .= '?'.http_build_query($data);
        }

        $process = curl_init($this->apiUrl.$url);
        curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($process, CURLOPT_HEADER, false);
        curl_setopt($process, CURLOPT_TIMEOUT, 30);
        
        if($type == self::TYPE_POST || $type == self::TYPE_DELETE) {
            curl_setopt($process, CURLOPT_POST, 1);
            curl_setopt($process, CURLOPT_POSTFIELDS, http_build_query($data));
        }

        if ($type == self::TYPE_DELETE) {
            curl_setopt($process, CURLOPT_CUSTOMREQUEST, "DELETE");
        }

        curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
        $return = curl_exec($process);
        curl_close($process);

        return json_decode($return, true);
    }
}
