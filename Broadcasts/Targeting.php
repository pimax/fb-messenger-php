<?php


namespace pimax\Broadcasts;


class Targeting
{
    private $labels;

    public function __construct (Predicate $parentPredicate)
    {
        $this -> labels = $parentPredicate;
    }

    public function getData(): array {
        return [
            'labels' => $this -> labels -> getData()
        ];
    }

    /**
     * TODO
     * @param string $query group_1 AND group3 AND (group2 OR group4)
     */
    public static function fromQueryString(string $query) {
        // TODO
    }
}