<?php

/**
 * 10, 20, 15, 30 => [15, 20]
 * @param $a
 * @param $b
 * @param $c
 * @param $d
 *
 * @return array|false
 */
function intersection($a, $b, $c, $d)
{
    $isBetween = function ($target, $left, $right) {
        return $target >= $left && $target <= $right;
    };

    if ($isBetween($c, $a, $b) && $isBetween($d, $a, $b)) {
        return [$c, $d];
    } elseif ($isBetween($c, $a, $b)) {
        return [$c, $b];
    } elseif ($isBetween($d, $a, $b)) {
        return [$a, $d];
    } elseif ($isBetween($a, $c, $d) && $isBetween($b, $c, $d)) {
        return [$a, $b];
    }

    return false;
}


assert(false === intersection(5, 10, 20, 30));//a and b are not intersecting being lefthand
assert(false === intersection(20, 30, 5, 10));//a and b are not intersecting being righthand
assert([9, 10] === intersection(5, 10, 9, 20));//c is between a and b
assert([5, 6] === intersection(5, 10, 1, 6));//d is between a and b
assert([6, 7] === intersection(5, 10, 6, 7));//c and d are between a and b
assert([5, 10] === intersection(5, 10, 4, 11));//a and b are between c and d