<?php

namespace pimax\Test\TestCase\Menu;

use pimax\Menu\MenuItem;
use pimax\Test\TestCase\AbstractTestCase;

/**
 * Class MenuItemTest.
 */
class MenuItemTest extends AbstractTestCase
{
    public function testItemPostback(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/Menu/MenuItem/postback.json');

        $menuItem = new MenuItem(MenuItem::TYPE_POSTBACK, 'title', 'PAYLOAD');

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($menuItem->getData()));
    }

    public function testItemWeb(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/Menu/MenuItem/web.json');

        $menuItem = new MenuItem(
            MenuItem::TYPE_WEB,
            'title',
            'https://github.com/pimax/fb-messenger-php/issues',
            'full',
            true,
            'https://github.com/pimax/fb-messenger-php',
            'hide'
        );

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($menuItem->getData()));
    }

    public function testItemNested(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/Menu/MenuItem/nested.json');

        $menuItem = new MenuItem(
            MenuItem::TYPE_NESTED, 
            'title',
            [
                new MenuItem(MenuItem::TYPE_POSTBACK, 'title_1', 'PAYLOAD_1'),
                new MenuItem(MenuItem::TYPE_POSTBACK, 'title_2', 'PAYLOAD_2'),
                new MenuItem(MenuItem::TYPE_POSTBACK, 'title_3', 'PAYLOAD_3'),
            ]
        );

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($menuItem->getData()));
    }
}
