<?php

class Solution {

    /**
     * @param String $s
     * @param Integer $numRows
     * @return String
     */
    function convert($s, $numRows) {
        $len = \strlen($s);
        $array = [];
        $x = 0;
        $y = 0;
        $zigZagSize = $numRows * 2 - 2;
        $k = $zigZagSize;
        $yForward = true;
        for ($i = 0; $i < $len; $i++) {
            $array[$y][$x] = $s[$i];

            if ($y + 1 >= $numRows) {
                $yForward = false;
            }
            if ($yForward) {
                $y++;
            } else {
                $y--;
                $x++;
            }
            if (--$k <= 0) {
                $yForward = true;
                $k = $zigZagSize;
                $y = 0;
            }
        }
        $result = '';
        foreach ($array as $line) {
            $result .= \implode('', $line);
        }

        return $result;
    }
}
