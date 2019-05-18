<?php

namespace pimax\Test\TestCase\Messages;

use pimax\Messages\AccountLink;
use pimax\Test\TestCase\AbstractTestCase;

/**
 * Class AccountLinkTest.
 */
class AccountLinkTest extends AbstractTestCase
{
    public function testAccountLink(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/Messages/AccountLink/link.json');

        $accountLink = new AccountLink(
            $title='title', 
            $subtitle='subtitle', 
            $url='https://www.example.com/oauth/authorize',
            $image_url='https://www.facebook.com/images/fb_icon_325x325.png', 
            $logout=false
        );

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($accountLink->getData()));
    }

    public function testAccountUnlink(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/Messages/AccountLink/unlink.json');

        $accountUnlink = new AccountLink(
            $title='title', 
            $subtitle='subtitle', 
            $url='',
            $image_url='https://www.facebook.com/images/fb_icon_325x325.png', 
            $logout=true
        );

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($accountUnlink->getData()));
    }
}
