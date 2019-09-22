<?php

/**
 * algorithm from the book
 *
 * @param string $p substring
 * @param string $s string
 * @param int $M len of p
 * @param int $N len of s
 *
 * @return int -1: not found, otherwise - position of substring in a string
 */
function search(string $p, string $s, int $M, int $N): int
{
    $d = new SplFixedArray(\strlen($p));

    //???
    $d[0] = -1;
    if ($p[0] !== $p[1]) {
        $d[1] = 0;
    } else {
        $d[1] = -1;
    }
    $j = 1;
    $k = 0;

    while ($j < $M - 1) {
        $j++;
        $k++;
        if ($p[$j] !== $p[$k]) {
            $d[$j] = $k;
        } else {
            $d[$j] = $d[$k];
        }
    }
    var_dump($d);

    $i = 0;
    $j = 0;
    while (true) {
        if ($j < $M && $i < $N && $j >= 0 && $s[$i] !== $p[$j]) {
            $j = $d[$j];
        } elseif ($j < $M && $i < $N) {
            $i++;
            $j++;
        } else {
            break;
        }
    }
    if ($j === $M) {
        $r = $i - $M;
    } else {
        $r = -1;
    }

    return $r;
}
$string = 'ab5cd1efg1haaaagk5labc1defgh4ijklabcdefghijklabcdefghijklabcdefghijklabcaefghijkl';
$substring = 'ababababg';

var_dump(search($substring, $string, \strlen($substring), \strlen($string)));

