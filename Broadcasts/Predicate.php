<?php


namespace pimax\Broadcasts;


class Predicate
{
    const AND = 'AND';
    const OR = 'OR';
    const NOT = 'NOT';

    private $operator;
    private $values;

    public function __construct (string $operator, array $values)
    {
        $this -> operator = $operator;
        $this -> values = $values;
    }

    public function getData() {
        return [
            'operator' => $this -> operator,
            'values' => array_map(function($x) {
                if (is_object($x) && $x instanceof self)
                    return $x -> getData();
                elseif (is_string($x))
                    return $x;
                else throw new BroadcastsException('Invalid type of predicate: '.gettype($x));
            }, $this -> values)
        ];
    }
}