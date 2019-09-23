<?php

function searchBm($p, $s)
{
    $M = \strlen($p);
    $N = \strlen($s);
    $count = 0;
    $d = [];
    for ($i = 0; $i < ($M - 2); $i++) {
        $d[ord($p[$i])] = $M - $i - 1;
    }

    $i = $M;
    $j = $M;
    $k = $i;
    while (true) {
        $count++;
        if ($j > 0 && $i <= $N && $s[$k - 1] === $p[$j - 1]) {
            $j--;
            $k--;
        } elseif ($j > 0 && $i <= $N) {
            $i += $d[ord($s[$i - 1])] ?? $M;
            $j = $M;
            $k = $i;
        } else {
            break;
        }
    }

    return ['found' => $j <= 0, $k, 'cnt' => $count];
}

$input = [
    //0 true
    [
        'abcdefghijklmnopqrstyvwxyz1234567890',
        '7890',
    ],
    //1 true
    [
        'aaaaa1',
        'a1',
    ],
    //2 false
    [
        'aaaaa1',
        'a2',
    ],
    //3 true
    [
        'aaaaaaaaaaaaaaaaaa1',
        'aaaa1',
    ],
    //4 true
    [
        'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa1',
        'aaaaaaaaaaa1',
    ],
    //5 true
    [
        'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaababaa1',
        'aaaaaaaaabab',
    ],
    //6 false
    [
        'abcdefgcabcdefgtabcdefgrabcdefglabcdefghabcdefguabcdefgpabcdefgkabcdefgvabcdefgxabcdefgm',
        'abcdefgq',
    ],
];

foreach ($input as $i => $item) {
    $res = searchBm($item[1], $item[0]);
    var_dump(['item' => $i, $res]);
}

