<?php


namespace pimax\Broadcasts\Predicates;


use pimax\Broadcasts\BroadcastsException;
use pimax\Broadcasts\Predicate;

class TwoValuePredicate extends Predicate
{
    public function __construct (string $operator, array $values)
    {
        if (count($values) < 2)
            throw new BroadcastsException('This predicate requires 2 or more values');
        parent::__construct($operator, $values);
    }

}