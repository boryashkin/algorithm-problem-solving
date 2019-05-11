<?php


$string = "This is some text written on 2010-07-18.";
preg_match('|(?<date>\d\d\d\d-\d\d-\d\d)|i',$string,$arr_result);
//var_dump($arr_result);exit;


/**
 * Возвращает список призывов вида @nick, найденных в тексте.
 * Ник можем содержать от 3 до 5 символов латинского алфавита, цифры и точку.
 * Точки могут быть только внутри ника (не крайними символами) и максимум 1 точка
 * между символами.
 */
function parseMentions(string $str): array
{
    if (preg_match_all('/(?<name>(?<![a-zA-Z0-9_])@([a-zA-Z0-9][\.]{0,1}){3,5}[[:>:]])/', $str, $m) === 0) {
        return [];
    }

    return $m['name'] ?? [];
}

$first = parseMentions("@a @ab @abc a@xyz !@ijmn,@123 0@321 @1a2b @qwerty");
var_dump($first
    === ["@abc", "@ijmn", "@123", "@1a2b"], $first);

$second = parseMentions("@abc.a @stu..test _@nmp @x.yz.@klm @.1a2b .@2c3d.");
var_dump($second
=== ["@abc.a", "@stu", "@x.yz", "@klm", "@2c3d"], $second);