<?php

function columnSorting(array $arr)
{
    sort($arr);
    $arr = array_reverse($arr);
    $l = count($arr);
    $res = [];
    while ($l > 0) {
        for ($i = 0, $last = null; $i < $l; $i++) {
            if ($last !== $arr[$i]) {
                $last = $arr[$i];
                array_unshift($res, $arr[$i]);
                array_splice($arr, $i--, 1);
                $l--;
            }
            echo "$last";
        }
    }
    return $res;
}
//1,1,1,1,1,2,2,3,3,3,3,4,4,4,5,5
//1,1,3,1,3,4,1,2,3,4,5,1,2,3,4,5
$a = $arr = [
    1,
    1,    3,
    1,    3, 4,
    1, 2, 3, 4, 5,
    1, 2, 3, 4, 5,
];
shuffle($a);
$r = columnSorting($a);
var_dump($r === $arr, implode('', $r), implode('', $arr));