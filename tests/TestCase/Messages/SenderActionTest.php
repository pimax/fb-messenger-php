<?php

namespace pimax\Test\TestCase\Messages;

use pimax\Messages\SenderAction;
use pimax\Test\TestCase\AbstractTestCase;

/**
 * Class SenderActionTest.
 */
class SenderActionTest extends AbstractTestCase
{
    public function testMarkSeen(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/Messages/SenderAction/mark_seen.json');

        $markSeen = new SenderAction('1234567890', SenderAction::ACTION_MARK_SEEN);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($markSeen->getData()));
    }

    public function testTypingOn(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/Messages/SenderAction/typing_on.json');

        $typingOn = new SenderAction('1234567890', SenderAction::ACTION_TYPING_ON);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($typingOn->getData()));
    }

    public function testTypingOff(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/Messages/SenderAction/typing_off.json');

        $typingOff = new SenderAction('1234567890', SenderAction::ACTION_TYPING_OFF);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($typingOff->getData()));
    }
}
