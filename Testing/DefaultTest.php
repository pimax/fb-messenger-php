<?php

namespace pimax\Testing;


use PHPUnit\Framework\TestCase;
use pimax\FbBotApp;

class DefaultTest extends TestCase
{

    private static function getTestData(): object {
        $data =  file_get_contents(__DIR__.'/../testdata.json');
        if (!$data)
            throw new TestException('Data expected at {PROJECT_ROOT}/testdata.json');
        $json = json_decode($data);
        if (!is_object($json))
            throw new TestException('Invalid JSOn at {PROJECT_ROOT}/testdata.json');
        return $json;
    }

    private static $botApp;
    protected static function makeBotApp(): FbBotApp {
        if (self::$botApp)
            return self::$botApp;
        $token = self::getTestData() -> token;
        if (!$token)
            throw new TestException('token field missing at {PROJECT_ROOT}/testdata.json');
        return self::$botApp = new FbBotApp($token);
    }

    protected static function getPSID(): string {
        $data = self::getTestData() -> PSID;
        if (!$data)
            throw new TestException('token field missing at {PROJECT_ROOT}/testdata.json');
        return (string) $data;
    }

    public function testFbBotAppNotFails() {
        self::makeBotApp();
        self::assertTrue(true);
    }

    public function testPSIDIsString() {
        self::assertIsString(self::getPSID());
    }
}
