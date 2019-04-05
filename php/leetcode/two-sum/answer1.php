<?php

class Solution {

    /**
     * @param Integer[] $nums
     * @param Integer $target
     * @return Integer[]
     */
    function twoSum($nums, $target) {
        $toFind = [];
        $resolution = [];
        //[0=>2, 1=>7, 2=>11]
        foreach ($nums as $key => $num) {
            //[7]
            if (isset($toFind[$num])) {
                $resolution = [$toFind[$num], $key];
                break;
            }
            //[7 => 0]
            $toFind[$target - $num] = $key;
        }

        return $resolution;
    }
}
