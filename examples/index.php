<?php

$verify_token = ""; // Verify token
$token = ""; // Page token

require_once(dirname(__FILE__).'/vendor/autoload.php');

use pimax\FbBotApp;
use pimax\Messages\Message;
use pimax\Messages\MessageButton;
use pimax\Messages\StructuredMessage;


$bot = new FbBotApp($token);


// Webhook setup request
if (!empty($_REQUEST['hub_mode']) && $_REQUEST['hub_mode'] == 'subscribe' && $_REQUEST['hub_verify_token'] == $verify_token) {
    echo $_REQUEST['hub_challenge'];

// Receive message
} else {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!empty($data['entry'][0])) {

        if (!empty($data['entry'][0]['messaging']))
        {
            foreach ($data['entry'][0]['messaging'] as $message)
            {
                if (!empty($message['delivery'])) {
                    continue;
                }

                $command = "";

                if (!empty($message['message'])) {
                    $command = $message['message']['text'];

                } else if (!empty($message['postback']))
                {
                    $command = $message['postback']['payload'];
                }


                // Send simple text message
                $bot->send(new Message($message['sender']['id'], 'Not found a new projects in this section.'));


                // Switch by receiving message text
                switch ($command)
                {
                    case 'All jobs':

                        // Send Structured message

                        $bot->send(new StructuredMessage($message['sender']['id'],
                            StructuredMessage::TYPE_BUTTON,
                            [
                                'title' => 'Choose category',
                                'buttons' => [
                                    new MessageButton(MessageButton::TYPE_POSTBACK, 'All jobs'),
                                    new MessageButton(MessageButton::TYPE_POSTBACK, 'Web Development'),
                                    new MessageButton(MessageButton::TYPE_POSTBACK, 'Software Development & IT')
                                ]
                            ]
                        ));

                    break;

                }
            }
        }
    }
}
