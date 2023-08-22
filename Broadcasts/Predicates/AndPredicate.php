<?php


namespace pimax\Broadcasts\Predicates;


use pimax\Broadcasts\Predicate;

class AndPredicate extends TwoValuePredicate
{
    public function __construct (...$values)
    {
        parent::__construct(self::AND, $values);
    }

}