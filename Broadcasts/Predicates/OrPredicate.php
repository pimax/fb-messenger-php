<?php


namespace pimax\Broadcasts\Predicates;


use pimax\Broadcasts\Predicate;

class OrPredicate extends TwoValuePredicate
{
    public function __construct (...$values)
    {
        parent::__construct(self::OR, $values);
    }

}