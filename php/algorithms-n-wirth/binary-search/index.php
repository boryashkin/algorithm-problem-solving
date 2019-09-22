<?php

function binSearch(int $needle, array $haystack)
{
    $i = 0;
    $j = \count($haystack) - 1;
    while ($i < $j) {
        $key = (int)(($i + $j) / 2);
        if ($haystack[$key] < $needle) {
            $i = $key + 1;
        } else {
            $j = $key;
        }
    }

    return [$i, $j, $haystack[$j]];
}

var_dump(binSearch(9, [0,1,2,3,4,5,6,7,8,9]));