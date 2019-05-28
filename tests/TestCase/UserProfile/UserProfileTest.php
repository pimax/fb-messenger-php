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
        $this->data = file_get_contents(__DIR__ . '/../../Mocks/Response/User/user.json');

        $this->userProfile = new UserProfile(json_decode($this->data, true));
    }

    public function testUserProfile(): void
    {
        $this->assertSame('Peter', $this->userProfile->getFirstName());
        $this->assertSame('Chang', $this->userProfile->getLastName());
        $this->assertSame('https://placeimg.com/200/200/nature', $this->userProfile->getPicture());
        $this->assertSame('en_US', $this->userProfile->getLocale());
        $this->assertSame(-7, $this->userProfile->getTimezone());
        $this->assertSame('male', $this->userProfile->getGender());
    }

    public function testUserProfileData(): void
    {
        $this->assertJsonStringEqualsJsonString($this->data, json_encode($this->userProfile->getData()));
    }
}
