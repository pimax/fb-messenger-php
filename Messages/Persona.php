<?php

namespace pimax\Messages;
/**
 * Class QuickReply
 *
 * @package pimax\Messages
 */
class Persona extends Message{

    protected $name;
    protected $profile_picture_url;

    /**
     * Message constructor.
     *
     * @param $text - string
     * @param $profile_picture_url - string
     */
    public function __construct($name, $profile_picture_url)
    {
        $this->name = $name;
        $this->profile_picture_url = $profile_picture_url;
    }

    public function getData() {
        $result = [
            'name' =>  $this->name,
            'profile_picture_url' => $this->profile_picture_url
        ];

        return $result;
    }
}
