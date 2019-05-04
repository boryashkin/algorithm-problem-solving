<?php

/*
 * I'm still have ways to optimize it even in this implementation
 */
function longestDynamic($s) {
    $maxLen = 0;
    $rangeValuesHash = [];
    $maxI = 0;
    $maxJ = 0;
    $lengthCache = [];
    $strlen = \strlen($s);

    $range = 0;
    /*
     * babadada
     * 01234567
     *
     */
    while ($range < $strlen) {
        for ($i = 0; $i < $strlen; $i++) {
            $j = $i + $range;
            if ($j > $strlen - 1) {
                //dirty hack to optimize for all equal letters case
                if ($range === 2 && \count($rangeValuesHash) === 1) {
                    $maxI = 0;
                    $maxJ = $strlen - 1;
                    break 2;
                } elseif ($range === 2) {
                    unset($rangeValuesHash);
                }
                break;
            }
            $prevI = $i + 1;
            $prevJ = $j - 1;

            if ($range === 0) {
                $length = 1;
                $rangeValuesHash[$s[$i]] = isset($rangeValuesHash[$s[$i]]) ? $rangeValuesHash[$s[$i]] + 1 : 1;
            } elseif ($prevJ < $prevI) {//$range < 2
                if ($s[$i] === $s[$j]) {
                    $length = 2;
                } else {
                    $length = 1;
                }
            } else {
                if ($s[$i] === $s[$j]) {
                    if ($lengthCache[$prevI][$prevJ] === $prevJ - $prevI + 1) {
                        //so this is palindrome
                        $length = $lengthCache[$prevI][$prevJ] + 2;
                        /*
                         * abacaba
                         * 0123456
                         * $i = 0;
                         * $j = 5;
                         */
                    } else {
                        $length = $lengthCache[$prevI][$prevJ];
                    }
                } else {
                    $length = $lengthCache[$prevI][$prevJ];
                }
            }
            $lengthCache[$i][$j] = $length;
            if ($maxLen < $length) {
                $maxLen = $length;
                $maxI = $i;
                $maxJ = $j;
            }
        }
        $range++;
    }

    return \substr($s, $maxI, $maxJ - $maxI + 1);
}