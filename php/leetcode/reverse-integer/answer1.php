<?php

class Solution {

    /**
     * @param Integer $x
     * @return Integer
     */
    function reverse($x) {
        $positive = $x >= 0;
        $x = \abs($x);
        $digits = [];
        $r = 10;
        /*
         * 53212
         * 53212 - 53210 = 2
         * 53212 - 53200 = 12
         * 53212 - 53000 = 212
         * 53212 - 50000 = 3212
         * 53212 - 0     = 53212
         *
         * 53212 - 3212 = 50000
         * 3212 - 212 = 3000
         *
         * 21235
         *
         */
        while ($r < ($x + 1) * 10) {
            $digits[] = $x - (floor($x / $r) * $r);
            $r *= 10;
        }

        $sum = 0;

        $xlen = \count($digits);
        foreach ($digits as $key => $digit) {
            $digits[$key] = \floor($digit / \pow(10, $key)) * \pow(10, $xlen - $key - 1);
            $sum += $digits[$key];
        }

        $result = $positive ? $sum : -$sum;
        return $this->isOverflown($sum, $positive) ? 0 : (int)$result;
    }

    private function isOverflown($x, $positive)
    {
        if ($positive && (pow(2, 31) - 1) <= $x || !$positive && (pow(2, 31)) <= $x) {
            //the integer should be 32 bit
            return true;
        }

        return false;
    }
}
