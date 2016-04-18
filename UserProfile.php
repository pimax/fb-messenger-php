<?php

namespace pimax;

class UserProfile
{
    protected $data = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getFirstName()
    {
        return $this->data['first_name'];
    }

    public function getLastName()
    {
        return $this->data['last_name'];
    }

    public function getPicture()
    {
        return $this->data['profile_pic'];
    }
}