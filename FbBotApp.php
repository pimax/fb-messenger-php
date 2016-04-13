<?php

namespace pimax;


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
     * FB Messenger API Url
     *
     * @var string
     */
    protected $apiUrl = 'https://graph.facebook.com/v2.6/me/';
    
    /**
     * BOT username
     *
     * @var string|null
     */
    protected $token = null;
    
    public function __construct($token)
    {
        $this->token = $token;
    }
    /**
     * Send Message
     *
     * @param Message $message
     * @return mixed
     */
    public function send($message)
    {
        return $this->call('messages', $message->getData());
    }

    /**
     * Request to API
     *
     * @param $url Url
     * @param $data Data
     * @param string $type Type of request (GET|POST)
     * @return array
     */
    protected function call($url, $data, $type = self::TYPE_POST)
    {
        $data['access_token'] = $this->token;

        $headers = [
            'Content-Type: application/json',
        ];

        $process = curl_init($this->apiUrl.$url);
        curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($process, CURLOPT_HEADER, 1);
        curl_setopt($process, CURLOPT_TIMEOUT, 30);
        if($type == self::TYPE_POST) {
            curl_setopt($process, CURLOPT_POST, 1);
        }
        curl_setopt($process, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
        $return = curl_exec($process);
        curl_close($process);

        return json_decode($return, true);
    }
}