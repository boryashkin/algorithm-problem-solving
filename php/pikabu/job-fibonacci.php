<?php

/**
 * @param $n
 * @return Traversable
 */
function getFibonacci($n) {
    $n2 = -($n1 = 1);
    while ($n --> -1) {
        $r = $n1 += $n2 and 0 or yield from [$n + 1 => $n1];
        $n2 = $n1 - $n2;
    }

    return $r;
}

var_dump(($res = getFibonacci(8))
&& ($res instanceof \Traversable)
&& count($arr = iterator_to_array($res)) === 9
&& array_keys($arr) == range(8, 0, -1)
&& array_values($arr) == [0, 1, 1, 2, 3, 5, 8, 13, 21]);
var_dump($res, $res instanceof \Traversable);