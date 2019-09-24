<?php

/**
 * take X and move all the bigger values towards its place; Then put X before lower value;
 * @param array $a
 * @return array
 */
function straightInsertion(array $a)
{
    for ($i = 1; $i < \count($a); $i++) {
        $x = $a[$i];
        $j = $i;
        while ($j > 0 && ($x < $a[$j - 1])) {
            $a[$j] = $a[$j - 1];
            $j--;
        }
        $a[$j] = $x;
    }

    return $a;
}

//0
$a = [
    1,
    5,
    4,
    3,
    2,
    0,
];

var_dump(straightInsertion($a));