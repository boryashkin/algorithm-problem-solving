<?php

class Solution {

    /**
     * @param Integer[] $nums1
     * @param Integer[] $nums2
     * @return Float
     */
    function findMedianSortedArrays($nums1, $nums2) {
        $array = \array_merge($nums1, $nums2);
        sort($array);
        $cty = \count($array);

        if ($cty % 2) {//even
            $middle[] = floor($cty / 2);
        } else {
            $middle[] = $cty / 2;
            $middle[] = $cty / 2 + 1;
        }
        $a = 0;
        if (\count($middle) === 1) {
            $a  = $array[\array_pop($middle)];
        } else {
            foreach ($middle as $key) {
                $a += $array[$key - 1];
            }
            $a = $a / 2;
        }

        return $a;
    }
}