<?php

/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */
class Solution {

    /**
     * @param ListNode $l1
     * @param ListNode $l2
     * @return ListNode
     */
    function addTwoNumbers($l1, $l2)
    {
        $firstNumber = self::resolveList($l1);
        $secondNumber = self::resolveList($l2);
        $sum = $this->sumNumbers($firstNumber, $secondNumber);

        return self::makeList($sum);
    }

    private static function resolveList($list)
    {
        $number = '';
        while ($list !== null) {
            $number .= self::resolveList($list->next);
            $number .= $list->val;
            break;
        }

        return $number;
    }

    private static function makeList($number)
    {
        $prevItem = null;
        $str = $number;
        $cnt = strlen($str);
        for ($i = 0; $i < $cnt; $i++) {
            $item = new ListNode((int)$str[$i]);
            $item->next = $prevItem;
            $prevItem = $item;
        }

        return $prevItem;
    }

    private function sumNumbers($n1, $n2)
    {
        $n1Arr = $this->turnNumberIntoArray($n1);
        $n2Arr = $this->turnNumberIntoArray($n2);
        $bigArr = null;
        $lessArr = null;
        if (\count($n1Arr) >= \count($n2Arr)) {
            $bigArr = $n1Arr;
            $lessArr = $n2Arr;
        } else {
            $bigArr = $n2Arr;
            $lessArr = $n1Arr;
        }

        $carrier = 0;
        $d1 = \array_pop($bigArr);
        $d2 = \array_pop($lessArr);
        $result = [];
        while ($d1 !== null) {
            if ($d2 === null) {
                $d2 = 0;
            }
            $sum = $d1 + $d2 + $carrier;
            if ($sum >= 10) {
                $carrier = 1;
                $sum -= 10;
            } else {
                $carrier = 0;
            }
            $result[] = $sum;
            $d1 = \array_pop($bigArr);
            $d2 = \array_pop($lessArr);
        }
        if ($carrier) {
            $result[] = $carrier;
        }

        return implode('', \array_reverse($result));
    }

    /**
     * turn the second number into array (807 = [7,0,8])
     * @param int|string $n
     */
    private function turnNumberIntoArray($n)
    {
        $cnt = strlen($n);
        $nArr = [];
        for ($i = 0; $i < $cnt; $i++) {
            $nArr[] = $n[$i];
        }

        return $nArr;
    }
}