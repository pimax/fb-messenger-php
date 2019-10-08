<?php

namespace Broadcasts;

use PHPUnit\Framework\TestCase;
use pimax\Broadcasts\Predicate;
use pimax\Broadcasts\Predicates\AndPredicate;
use pimax\Broadcasts\Predicates\NotPredicate;
use pimax\Broadcasts\Predicates\OrPredicate;

class PredicateTest extends TestCase
{

    public function getPredicates ()
    {
        return [
            [new AndPredicate('user', 'lead')],
            [new NotPredicate(new OrPredicate(new AndPredicate('user', 'lead'), 'novice'))],
            [new OrPredicate(new AndPredicate('western', 'student'), 'eastern')]
        ];
    }

    /**
     * @dataProvider getPredicates
     * @param Predicate $p
     */
    public function testGetData (Predicate $p)
    {
        $data = $p -> getData();
        self::assertIsArray($data);
    }
}
