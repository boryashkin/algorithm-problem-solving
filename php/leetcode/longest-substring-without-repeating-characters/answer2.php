<?php

/**
 * A bit faster solution
 */
class Solution {

    /**
     * @param String $s
     * @return Integer
     */
    function lengthOfLongestSubstring($s) {
        $strLen = \strlen($s);
        //persisting results in case of requirements changes
        $currentIdxSymbols = [];
        $resultsLen = [];
        $lastIdx = 0;
        for ($i = 0; $i < $strLen; $i++) {
            $currentSymbol = $s[$i];
            if (isset($currentIdxSymbols[$currentSymbol])) {
                $curIdxLen = \count($currentIdxSymbols);
                $resultsLen[\substr($s, $lastIdx, $curIdxLen)] = $curIdxLen;
                $i = $lastIdx + 1;
                $currentSymbol = $s[$i];
                $lastIdx = $i;
                $currentIdxSymbols = [];
            }
            $currentIdxSymbols[$currentSymbol] = $currentSymbol;
        }
        $curIdxLen = \count($currentIdxSymbols);
        $resultsLen[\substr($s, $lastIdx, $curIdxLen)] = $curIdxLen;
        \arsort($resultsLen);
        $longest = \array_shift($resultsLen);

        return $longest;
    }
}