<?php

namespace pimax;

use pimax\Messages\Message;

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
     * Upload File (image, audio, video, file)
     *
     * @see Attachment Reuse on https://developers.facebook.com/docs/messenger-platform/send-api-reference
     * @param Messages\Attachment $attachment
     * @return array contains attachment_id (if successfully uploaded).
     */
    public function upload($attachment)
    {
        $data = $attachment->getData();
        $data['attachment']['payload']['is_reusable'] = true;
        return $this->call('me/message_attachments',[
            'message' => $data
        ], self::TYPE_POST);
    }

    /**
     * Get User Profile Info
     *
     * @param int    $id
     * @param string $fields
     * @return UserProfile
     */
    public function userProfile($id, $fields = 'first_name,last_name,profile_pic,locale,timezone,gender,is_payment_enabled,last_ad_referral')
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
     * @see https://developers.facebook.com/docs/messenger-platform/messenger-profile/greeting-text
     * @param array $localizedGreetings
     * @return array
     */
    public function setGreetingText($localizedGreetings){
        return $this->call('me/messenger_profile', [
            'greeting' => $localizedGreetings
        ], self::TYPE_POST);
    }


    /**
     * Delete Greeting Text
     *
     * @see https://developers.facebook.com/docs/messenger-platform/messenger-profile/greeting-text
     * @return array
     */
    public function deleteGreetingText()
    {
        return $this->call('me/messenger_profile', [
            'fields' => ['greeting'],
        ], self::TYPE_DELETE);
    }

    /**
     * Get Greeting Text
     *
     * @see https://developers.facebook.com/docs/messenger-platform/messenger-profile/greeting-text
     * @return array
     */
    public function getGreetingText(){
        return $this->call('me/messenger_profile', [
            'fields' => 'greeting',
        ], self::TYPE_GET);
    }

    /**
     * Set Target Audience
     *
     * @see https://developers.facebook.com/docs/messenger-platform/messenger-profile/target-audience
     * @param string $audience_type ("all", "custom", "none")
     * @param string $list_type ("whitelist", "blacklist")
     * @param array $countries_array
     * @return array
     */
    public function setTargetAudience($audience_type, $list_type=null, $countries_array=null){

        if ($audience_type === "custom") {
            return $this->call('me/messenger_profile', [
                'target_audience' => [
                   'audience_type' => $audience_type,
                   $list_type => $countries_array
               ]
            ], self::TYPE_POST);
        } else {
            return $this->call('me/messenger_profile', [
                'target_audience' => [
                   'audience_type' => $audience_type
               ]
            ], self::TYPE_POST);
        }
    }

    /**
     * Delete Target Audience
     *
     * @see https://developers.facebook.com/docs/messenger-platform/messenger-profile/target-audience
     * @return array
     */
    public function deleteTargetAudience()
    {
        return $this->call('me/messenger_profile', [
            'fields' => ['target_audience'],
        ], self::TYPE_DELETE);
    }

    /**
     * Get Target Audience
     *
     * @see https://developers.facebook.com/docs/messenger-platform/messenger-profile/target-audience
     * @return array
     */
    public function getTargetAudience(){
        return $this->call('me/messenger_profile', [
            'fields' => 'target_audience',
        ], self::TYPE_GET);
    }

    /**
     * Set Domain Whitelisting
     *
     * @see https://developers.facebook.com/docs/messenger-platform/messenger-profile/domain-whitelisting
     * @param array|string $domains
     * @return array
     */
    public function setDomainWhitelist($domains){

        if(!is_array($domains))
            $domains = array($domains);

        return $this->call('me/messenger_profile', [
            'whitelisted_domains' => $domains
        ], self::TYPE_POST);
    }

    /**
     * Delete Domain Whitelisting
     *
     * @see https://developers.facebook.com/docs/messenger-platform/messenger-profile/domain-whitelisting
     * @return array
     */
    public function deleteDomainWhitelist()
    {
        return $this->call('me/messenger_profile', [
            'fields' => ['whitelisted_domains'],
        ], self::TYPE_DELETE);
    }

    /**
     * Get Domain Whitelisting
     *
     * @see https://developers.facebook.com/docs/messenger-platform/messenger-profile/domain-whitelisting
     * @return array
     */
    public function getDomainWhitelist(){
        return $this->call('me/messenger_profile', [
            'fields' => 'whitelisted_domains',
        ], self::TYPE_GET);
    }

    /**
     * Set Chat Extension Home URL
     *
     * @see https://developers.facebook.com/docs/messenger-platform/messenger-profile/home-url/
     * @param string  $url
     * @param string  $webview_height_ratio
     * @param string  $webview_share_button
     * @param boolean $in_test
     * @return array
     */
    public function setHomeUrl($url, $webview_height_ratio = 'tall', $webview_share_button = 'hide', $in_test = false){
        return $this->call('me/messenger_profile', [
            'home_url' => [
                'url' => $url,
                'webview_height_ratio' => $webview_height_ratio,
                'webview_share_button' => $webview_share_button,
                'in_test' => $in_test
            ]
        ], self::TYPE_POST);
    }

    /**
     * Delete Chat Extension Home Url
     *
     * @see https://developers.facebook.com/docs/messenger-platform/messenger-profile/home-url/
     * @return array
     */
    public function deleteHomeUrl()
    {
        return $this->call('me/messenger_profile', [
            'fields' => ['home_url'],
        ], self::TYPE_DELETE);
    }

    /**
     * Get Chat Extension Home Url
     *
     * @see https://developers.facebook.com/docs/messenger-platform/messenger-profile/home-url/
     * @return array
     */
    public function getHomeUrl(){
        return $this->call('me/messenger_profile', [
            'fields' => 'home_url',
        ], self::TYPE_GET);
    }

    /**
     * Set Nested Menu
     *
     * @see https://developers.facebook.com/docs/messenger-platform/messenger-profile/persistent-menu
     * @params $localizedMenu
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
