<?php

namespace pimax\Test\TestCase;

use pimax\FbBotApp;
use pimax\Test\TestCase\AbstractTestCase;

/**
 * Class MessengerTest.
 */
class MessengerTest extends AbstractTestCase
{
    /**
     * @var FbBotApp
     */
    protected $bot;

    public function setUp(): void
    {
        $this->bot = new FbBotApp('1234567890');
    }

    public function tearDown(): void
    {
        unset($this->bot);
    }
}
