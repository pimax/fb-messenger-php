<?php


namespace pimax\Broadcasts\Predicates;


use pimax\Broadcasts\BroadcastsException;
use pimax\Broadcasts\Predicate;

class NotPredicate extends Predicate
{
    public function __construct (...$values)
    {
        /**
         * @see https://developers.facebook.com/docs/messenger-platform/send-messages/broadcast-messages/target-broadcasts#operators
         */
        if (count($values) > 1)
            throw new BroadcastsException('Not operator only supports one value, either string or another predicate');
        parent::__construct(self::NOT, $values);
    }

}