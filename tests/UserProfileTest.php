<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use pimax\UserProfile;

/**
 * Class UserProfileTest.
 */
final class UserProfileTest extends TestCase
{
    /**
     * UserProfile class instance
     *
     * @var pimax\UserProfile
     */
    private $user_profile;

    public function __construct()
    {
        $data = array(
            "first_name" => "UserFirstName",
            "last_name" => "UserLastName",
            "profile_pic" => "UserPicture",
            "locale" => "UserLocale",
            "timezone" => "UserTimezone",
            "gender" => "UserGender",
        );
        $this->user_profile = new UserProfile($data);
        parent::__construct();
    }

    public function testInstanceUserProfile(): void
    {
        $this->assertInstanceOf(UserProfile::class, $this->user_profile);
    }

    public function testFirstName(): viod
    {
        $this->assertEquals('UserFirstName', $this->user_profile.getFirstName());
    }

    public function testLastName(): viod
    {
        $this->assertEquals('UserLastName', $this->user_profile.getLastName());
    }

    public function testPicture(): viod
    {
        $this->assertEquals('UserPicture', $this->user_profile.getPicture());
    }

    public function testLocale(): viod
    {
        $this->assertEquals('UserLocale', $this->user_profile.getLocale());
    }

    public function testTimezone(): viod
    {
        $this->assertEquals('UserTimezone', $this->user_profile.getTimezone());
    }

    public function testGender(): viod
    {
        $this->assertEquals('UserGender', $this->user_profile.getGender());
    }

    public function testGetData(): viod
    {
        $data = array(
            "first_name" => "UserFirstName",
            "last_name" => "UserLastName",
            "profile_pic" => "UserPicture",
            "locale" => "UserLocale",
            "timezone" => "UserTimezone",
            "gender" => "UserGender",
        );
        $this->assertEquals($data, $this->user_profile.getData());
    }
}