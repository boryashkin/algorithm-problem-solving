<?php

/**
 * @param string $p substring
 * @param string $s string
 * @param callable $computeSubstringShifts
 *
 * @return array
 */
function searchKmp(string $p, string $s, callable $computeSubstringShifts)
{
    $M = \strlen($p);
    $N = \strlen($s);
    $j = 0;

    $d = $computeSubstringShifts($p);

    $i = 0;
    $counter = 0;

    while (true) {
        $counter++;
        if ($i < $N && $j < $M && ($j < 0 || $p[$j] == $s[$i])) {
            $i++;
            $j++;
        } elseif ($i < $N && $j < $M) {
            $j = $d[$j];
        } else {
            break;
        }
    }

    return [
        'pos' => $i - $M,
        'found' => $j >= $M,
        'iterations' => $counter,
    ];
}
function dummySubstringComputation($p)
{
    $M = \strlen($p);
    $d = new \SplFixedArray($M);

    for ($i = 0; $i < $M; $i++) {
        $d[$i] = $i - 1;
    }

    return $d;
}
function realSubstringComputation($p)
{
    $M = \strlen($p);
    $d = new \SplFixedArray($M);
    $index = 0;

    $d[0] = -1;
    for ($i = 1; $i < $M; $i++) {
        if ($p[$index] === $p[$i]) {
            $d[$i] = $index;
            $index++;
        } elseif ($index !== 0) {
            $d[$i] = $d[$i - 1];
        } else {
            $d[$i] = 0;
        }
    }

    return $d;
}
$input = [
    [
        'abcdefghijklmnopqrstyvwxyz1234567890',
        '7890',
    ],
    [
        'aaaaa1',
        'a1',
    ],
    [
        'aaaaa1',
        'a2',
    ],
    [
        'aaaaaaaaaaaaaaaaaa1',
        'aaaa1',
    ],
    [
        'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa1',
        'aaaaaaaaaaa1',
    ],
    [
        'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaababaa1',
        'aaaaaaaaabab',
    ],
    [
        'abcdefgcabcdefgtabcdefgrabcdefglabcdefghabcdefguabcdefgpabcdefgkabcdefgvabcdefgxabcdefgm',
        'abcdefgq',
    ],
];

foreach ($input as $i => $item) {
    $sRes = searchKmp($item[1], $item[0], 'dummySubstringComputation');
    $rRes = searchKmp($item[1], $item[0], 'realSubstringComputation');
    if ($sRes !== $rRes) {
        var_dump(['item' => $i, $sRes, $rRes]);
    }
}

