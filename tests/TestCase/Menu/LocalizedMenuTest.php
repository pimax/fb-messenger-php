<?php

namespace pimax\Test\TestCase\Menu;

use pimax\Menu\MenuItem;
use pimax\Menu\LocalizedMenu;
use pimax\Test\TestCase\AbstractTestCase;

/**
 * Class LocalizedMenuTest.
 */
class LocalizedMenuTest extends AbstractTestCase
{
    public function testLocalizedMenuDefault(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/Menu/LocalizedMenu/default.json');

        $localizedMenu = new LocalizedMenu(
            'default', 
            false,
            [
                new MenuItem(MenuItem::TYPE_POSTBACK, 'title_1', 'PAYLOAD_1'),
                new MenuItem(MenuItem::TYPE_POSTBACK, 'title_2', 'PAYLOAD_2'),
                new MenuItem(MenuItem::TYPE_POSTBACK, 'title_3', 'PAYLOAD_3'),
            ]
        );

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($localizedMenu->getData()));
    }

    public function testLocalizedMenuWithoutItems(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../Mocks/Menu/LocalizedMenu/default_no_items.json');

        $localizedMenu = new LocalizedMenu('default', false);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($localizedMenu->getData()));
    }
}
