<?php


namespace pimax\Broadcasts;


use pimax\Messages\Message;

trait Broadcasts
{
    /**
     * Broadcast API
     * Send messages to groups of users marked by tags or all users
     *
     * @see https://developers.facebook.com/docs/messenger-platform/reference/broadcast-api/
     * @see https://developers.facebook.com/docs/messenger-platform/send-messages/broadcast-messages/target-broadcasts
     *
     * TODO estimate broadcast reach
     * TODO @see https://developers.facebook.com/docs/messenger-platform/send-messages/broadcast-messages/estimate-reach
     *
     * TODO broadcast metrics
     * TODO @see https://developers.facebook.com/docs/messenger-platform/send-messages/broadcast-messages#metrics
     *
     * TODO Cancelling a Scheduled Broadcast etc
     */

    /**
     * LABELS are created to be bound to users. Broadcasts may be further filtered by labels or label predicates
     */

    /**
     * Create a label to be added to
     * @param string $name
     * @return array {"id":"1001200005002"}
     */
    public function createLabel(string $name): array {
        $label = $this -> call('me/custom_labels', compact('name'), self::TYPE_POST);
        if (!empty($label['error'])) {
            // Label with this name already exists
            if ($label['error']['error_subcode'] == 2018210) {
                // Is not supposed to fail. Not at all.
                return $this -> getLabelByName($name);
            } else throw new APIException($label['error']);
        }
        return $label;
    }

    /**
     * Get label details (useless)
     * @param string $id
     * @return array Label {"name":"myLabel","id":"1001200005002"}
     */
    public function getLabel(string $id): array {
        return $this -> call($id, [
            'fields' => 'name'
        ], self::TYPE_GET);
    }

    /**
     * Returns the first label with the given name (Names are unique)
     * @param string $name
     * @return array Label {"name":"myLabel","id":"1001200005002"}
     */
    public function getLabelByName(string $name): array {
        $found = array_filter($this -> getAllLabels()['data'], function($label) use ($name) {
            return $label['name'] == $name;
        });
        if (($c = count($found)) != 1)
            throw new BroadcastsException("Found $c labels with a given name: $name");
        $f = array_shift($found);
        return [
            'name' => $name,
            'id' => (string) $f['id']
        ];
    }

    /**
     * Get all labels
     * @return array {"data": [Label]}
     * TODO pagination. This doesn't include pagination and this worries me o_O Don't ask for dozens of labels with this
     */
    public function getAllLabels(): array {
        return $this -> call('me/custom_labels', [
            'fields' => 'name'
        ], self::TYPE_GET);
    }


    /**
     * Deletes a label and all bindings
     * @param string $id
     * @return array {"success": true}
     */
    public function deleteLabel(string $id): array {
        return $this -> call($id, [], self::TYPE_DELETE);
    }

    /**
     * Binds the given user with the given label
     * Binding a label to a user which is already bound to this level will NOT cause an error <3
     * @param int|string $labelID
     * @param int|string $PSID User ID
     * @return array {"success": true}
     */
    public function bindLabel($labelID, $PSID): array {
        return $this -> call("$labelID/label", [
            'user' => $PSID
        ], self::TYPE_POST);
    }

    /**
     * Removes the binding of the given user to the given label
     * @param int|string $labelID
     * @param int|string $PSID User ID
     * @return array {"success": true}
     */
    public function unbindLabel($labelID, $PSID): array {
        return $this -> call("$labelID/label", [
            'user' => $PSID
        ], self::TYPE_DELETE);
    }


    /**
     * Get all labels with a given bound PSID
     * @param int|string $PSID
     * @return array {"data": [Label]}
     * TODO pagination. This doesn't include pagination and this worries me o_O Don't ask for dozens of labels with this
     */
    public function getLabelsByPSID(string $PSID): array {
        return $this -> call("$PSID/custom_labels", [
            'fields' => 'name'
        ], self::TYPE_GET);
    }


    /**
     * Message creatives are created and supplied into broadcasts.
     * Message creative is like a draft for broadcasts
     */

    /**
     * Create message creative.
     * For whatever reason the API requires a message array,
     * but it's stated that no more than one message might be included
     * @see https://developers.facebook.com/docs/messenger-platform/send-messages/broadcast-messages#creating
     * @param Message $message
     *
     * <b>Please note. Unsupported templates:</b>
     *
     * Airline boarding pass template
     * Airline check-in template
     * Airline itinerary template
     * Airline flight update template
     * Receipt template
     * Open graph template
     *
     * It isn't as if this lib supports them anyway...
     *
     * @return array
     */
    public function createMessageCreative(Message $message): array {
        return $this -> call('me/message_creatives', [
            'messages' => [
                $message -> getData()['message']
            ]
        ], self::TYPE_POST);
    }


    /**
     * This sends a distribution over all users of the page
     *
     * Broadcast API reach is limited to 10,000 recipients per message.
     * @see https://developers.facebook.com/docs/messenger-platform/reference/broadcast-api/#limits
     *
     * @param int|string $messageCreativeID
     * @param string $notificationType
     * @param int|string|null $customLabelID
     * @param int|null $scheduleTimestamp seconds Unix Epoch
     * @param array|null $targeting Targeting predicates
     * @return array
     */
    public function broadcast(
        $messageCreativeID,
        string $notificationType,
        $customLabelID = NULL,
        int $scheduleTimestamp = NULL,
        array $targeting = NULL
    ): array {
        $data = [
            "message_creative_id" => $messageCreativeID,
            "notification_type" =>  $notificationType,
            "messaging_type" => "MESSAGE_TAG",
            "tag" => "NON_PROMOTIONAL_SUBSCRIPTION" // They seriously had to include this. Always this value. Come on.
        ];
        if ($scheduleTimestamp)
            $data['scheduled_time'] = $scheduleTimestamp;
        if ($customLabelID)
            $data['custom_label_id'] = $customLabelID;
        if ($targeting)
            $data['targeting'] = $targeting;

        return $this -> call('me/broadcast_messages', $data, self::TYPE_POST);
    }


    /**
     * One-time message broadcast
     *
     * @param Message $message
     * @param Targeting $predicates All Label IDs must be valid!
     * @param int|NULL $scheduleTimestamp
     * @param string $notificationType
     * @return array
     */
    public function broadcastMessage(
        Message $message,
        Targeting $predicates,
        int $scheduleTimestamp = NULL,
        string $notificationType = Message::NOTIFY_SILENT_PUSH
    ): array {
        $messageCreativeID = $this -> createMessageCreative($message);
        if (!$mID = $messageCreativeID['message_creative_id'])
            throw new APIException($messageCreativeID);
        return $this -> broadcast($mID, $notificationType, NULL, $scheduleTimestamp, $predicates -> getData());
    }


}