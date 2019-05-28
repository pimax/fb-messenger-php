<?php

namespace pimax\Testing\Broadcasts;



use pimax\Broadcasts\Predicate;
use pimax\Broadcasts\Predicates\AndPredicate;
use pimax\Broadcasts\Predicates\OrPredicate;
use pimax\Broadcasts\Targeting;
use pimax\Messages\Message;
use pimax\Testing\DefaultTest;


/**
 * Upon running the test, if you put a correct token and user ID, and assuming your app is approved for broadcasts
 * or you're an app developer, you should receive a message with the following text (most likely several times):
 *
 * 💃💃💃 TEST_BROADCAST 04:20:00 💃💃💃
 *
 * Class APITest
 * @package pimax\Testing\Broadcasts
 */
class APITest extends DefaultTest
{
    private static $label = NULL;
    private static function getTestLabel() {
        // The label is created by default. If it already exists, an existing ID will be returned
        return self::$label ?? self::$label = self::makeBotApp() -> createLabel('TEST_LABEL');
    }

    private static function getTestMessage() {
        return new Message('none', sprintf('💃💃💃 TEST_BROADCAST %s 💃💃💃', date('H:i:s')));
    }

    private static $messageCreative = NULL;
    private static function getTestMessageCreative() {
        return self::$messageCreative ?? self::$messageCreative =
                self::makeBotApp() -> createMessageCreative(self::getTestMessage());
    }

    public function testCreateLabelReturnsArrayAndContainsID() {
        $label = self::getTestLabel();
        self::assertIsArray($label);
        self::assertNotEmpty($label['id']);
    }

    public function testGetLabelByNameReturnsLabel() {
        $label = self::getTestLabel();
        $sameLabel = self::makeBotApp() -> getLabelByName('TEST_LABEL');
        self::assertNotEmpty($label['id']);
        self::assertNotEmpty($sameLabel['id']);
        self::assertEquals($label['id'], $sameLabel['id']);
    }

    public function testGetLabelReturnsCorrectFields() {
        $label = self::getTestLabel();
        self::assertIsArray($label);
        self::assertNotEmpty($label['id']);
        self::assertNotEmpty($label['name']);
    }

    public function testGetAllLabelsReturnsCorrectStructure() {
        $labels = self::makeBotApp() -> getAllLabels();
        self::assertIsArray($labels);
        self::assertNotEmpty($labels['data']);
    }

    public function testDeleteLabelDeletesLabel() {
        $label = self::getTestLabel();
        $response = self::makeBotApp() -> deleteLabel($label['id']);
        self::assertNotEmpty($response['success']);
        self::assertTrue($response['success']);
        self::$label = NULL;
    }


    public function testBindLabelBindsLabel() {
        $label = self::getTestLabel();
        $response = self::makeBotApp() -> bindLabel($label['id'], self::getPSID());
        self::assertNotEmpty($response['success']);
        self::assertTrue($response['success']);
    }

    public function testPossibleToBingTwoLabels() {
        $label = self::getTestLabel();
        $label2 = self::makeBotApp() -> createLabel('TEST_LABEL_2');
        self::makeBotApp() -> bindLabel($label['id'], self::getPSID());

        $response = self::makeBotApp() -> bindLabel($label2['id'], self::getPSID());
        self::assertNotEmpty($response['success']);
        self::assertTrue($response['success']);
        self::makeBotApp() -> deleteLabel($label2['id']);
        self::$label = NULL;
    }

    public function testUnbindLabelUnbindsLabel() {
        $label = self::getTestLabel();
        // If not bound yet for whatever reason
        self::makeBotApp() -> bindLabel($label['id'], self::getPSID());

        $response = self::makeBotApp() -> unbindLabel($label['id'], self::getPSID());
        self::assertNotEmpty($response['success']);
        self::assertTrue($response['success']);
        self::$label = NULL;
    }

    public function testUnbindWorksIfNotExists() {
        $label2 = self::makeBotApp() -> createLabel('TEST_LABEL_X');
        $response = self::makeBotApp() -> unbindLabel($label2['id'], self::getPSID());

        self::assertNotEmpty($response['success']);
        self::assertTrue($response['success']);

        self::makeBotApp() -> deleteLabel($label2['id']);
    }

    public function testGetLabelsByPSIDReturnsCorrectLabels() {
        $label = self::getTestLabel();
        $lID = $label['id'];
        // If not bound yet for whatever reason
        self::makeBotApp() -> bindLabel($label['id'], self::getPSID());

        $labels = self::makeBotApp() -> getLabelsByPSID(self::getPSID());
        self::assertIsArray($labels);
        self::assertNotEmpty($labels['data']);

        $found = array_filter($labels['data'], function($l) use ($lID) {
            return $l['id'] == $lID;
        });
        self::assertTrue(count($found) == 1);
    }

    public function testMessageCreativeCreatesMessage() {
        $response = self::getTestMessageCreative();
        self::assertIsArray($response);
        self::assertNotEmpty($response['message_creative_id']);
    }

    public function testBroadcastWorks() {
        $messageCreative = self::getTestMessageCreative();
        $response = self::makeBotApp() -> broadcast(
            $messageCreative['message_creative_id'],
            Message::NOTIFY_SILENT_PUSH
        );
        self::assertIsArray($response);
        self::assertNotEmpty($response['broadcast_id']);
        self::$messageCreative = NULL;
    }

    // This is supposed to come in 30 seconds
    public function testDelayedBroadcastWorks() {
        $messageCreative = self::getTestMessageCreative();
        $response = self::makeBotApp() -> broadcast(
            $messageCreative['message_creative_id'],
            Message::NOTIFY_SILENT_PUSH,
            NULL,
            time() + 30
        );
        self::assertIsArray($response);
        self::assertNotEmpty($response['broadcast_id']);
        self::$messageCreative = NULL;
    }

    public function testBroadcastToCustomLabelWorks() {
        $label = self::getTestLabel();
        self::makeBotApp() -> bindLabel($label['id'], self::getPSID());
        $messageCreative = self::getTestMessageCreative();

        $response = self::makeBotApp() -> broadcast(
            $messageCreative['message_creative_id'],
            Message::NOTIFY_SILENT_PUSH,
            $label['id']
        );
        self::assertIsArray($response);
        self::assertNotEmpty($response['broadcast_id']);
        self::$messageCreative = NULL;
    }

    public function testWillSendToPredicates() {
        $label = self::getTestLabel();
        $label2 = self::makeBotApp() -> createLabel('TEST_LABEL_2');
        $label3 = self::makeBotApp() -> createLabel('TEST_LABEL_3');
        self::makeBotApp() -> bindLabel($label['id'], self::getPSID());
        self::makeBotApp() -> bindLabel($label2['id'], self::getPSID());
        self::makeBotApp() -> bindLabel($label3['id'], self::getPSID());

        $response = self::makeBotApp() -> broadcastMessage(
            self::getTestMessage(),
            new Targeting(
                new AndPredicate(
                    $lid = $label['id'],
                    new OrPredicate(
                        $label2['id'],
                        $label3['id']
                    )
                )
            )
        );

        self::assertIsArray($response);
        self::assertNotEmpty($response['broadcast_id']);

        self::makeBotApp() -> deleteLabel($label2['id']);
        self::makeBotApp() -> deleteLabel($label3['id']);
    }












}
