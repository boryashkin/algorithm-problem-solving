<?php

class Solution {

    /**
     * @param String $s
     * @return Integer
     */
    function lengthOfLongestSubstring($s) {
        $strLen = \strlen($s);
        $currentIdxSymbols = [];
        $longest = 0;
        $lastIdx = 0;
        for ($i = 0; $i < $strLen; $i++) {
            $currentSymbol = $s[$i];
            if (isset($currentIdxSymbols[$currentSymbol])) {
                $len = \count($currentIdxSymbols);
                $longest = $len > $longest ? $len : $longest;
                $i = $lastIdx + 1;
                $currentSymbol = $s[$i];
                $lastIdx = $i;
                $currentIdxSymbols = [];
            }
            $currentIdxSymbols[$currentSymbol] = $currentSymbol;
        }
        $len = \count($currentIdxSymbols);
        $longest = $len > $longest ? $len : $longest;

        return $longest;
    }
}