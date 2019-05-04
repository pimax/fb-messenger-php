<?php

use PHPUnit\Framework\TestCase;
use pimax\FbBotApp;

/**
 * Class FbBotAppTest.
 */
final class FbBotAppTest extends TestCase
{
    /**
     * FbBotApp class instance
     *
     * @var pimax\FbBotApp
     */
    private $bot;

    public function __construct()
    {
        $this->bot = new FbBotApp('1234567890');
        parent::__construct();
    }

    public function testInstanceFbBotApp(): void
    {
        $this->assertInstanceOf(FbBotApp::class, $this->bot);
    }
}