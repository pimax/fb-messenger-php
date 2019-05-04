<?php

namespace pimax\Test\TestCase\UserProfile;

use pimax\UserProfile;
use pimax\Test\TestCase\AbstractTestCase;

/**
 * Class UserProfileTest.
 */
class UserProfileTest extends AbstractTestCase
{
    /**
     * UserProfile class instance
     *
     * @var pimax\UserProfile
     */
    protected $userProfile;

    public function setUp(): void
    {
        $string = file_get_contents(__DIR__ . '/../Mocks/Response/User/user.json');

        $this->userProfile = new UserProfile(json_decode($string, true));
    }

    public function testGetProfile(): void
    {
        $this->assertSame('Peter', $this->userProfile.getFirstName());
        $this->assertSame('Chang', $this->userProfile.getLastName());
        $this->assertSame('https://placeimg.com/200/200/nature', $this->userProfile.getProfilePic());
        $this->assertSame('en_US', $this->userProfile.getLocale());
        $this->assertSame(-7., $this->userProfile.getTimezone());
        $this->assertSame('male', $this->userProfile.getGender());
    }

    public function testGetProfileData(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../Mocks/Response/User/user.json');

        $profileData = $this->userProfile->getData();

        $this->assertSame(json_decode($expectedJson, true), $profileData);
    }
}