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
        return isset($this->data['first_name']) ? $this->data['first_name'] : null;
    }

    public function getLastName()
    {
        return isset($this->data['last_name']) ? $this->data['last_name'] : null;
    }

    public function getPicture()
    {
        return isset($this->data['profile_pic']) ? $this->data['profile_pic'] : null;
    }

    public function getLocale()
    {
        return isset($this->data['locale']) ? $this->data['locale'] : null;
    }

    public function getTimezone()
    {
        return isset($this->data['timezone']) ? $this->data['timezone'] : null;
    }

    public function getGender()
    {
        return isset($this->data['gender']) ? $this->data['gender'] : null;
    }

    /**
     * Get Data
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
