<?php

/**
 * Шифрует строку используя сдвиг Цезаря.
 * Результат - HEX представление зашифрованной строки.
 */
function encrypt(string $str, int $shift, $base = null): string {
    $ascii = unpack('c*', $str);
    foreach ($ascii as &$code) {
        $code = ($code + $shift) % 0216;

    }
    return bin2hex(pack('c*', ...$ascii));
}


$base = 0216;

do {
    $ex1 = encrypt("foo", 325, $base) === "010a0a";
    $ex2 = encrypt("bar", 9, $base) === "6b6a7b";
    $ex3 = encrypt("car", 2047, $base) === "100e1f";
    echo $base . PHP_EOL;
    $base++;
} while (!($ex1 && $ex2 && $ex3));

var_dump(encrypt("foo", 325, $base), encrypt("bar", 9, $base), encrypt("car", 2047, $base)  );

