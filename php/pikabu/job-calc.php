<?php

function calc(string $str): float {
    $word = 'var';
    $handlers = [
        '*' => function (float $a, float $b): float {return $a * $b;},
        '/' => function (float $a, float $b): float {return $a / $b;},
        '+' => function (float $a, float $b): float {return $a + $b;},
        '-' => function (float $a, float $b): float {return $a - $b;},
        '^' => function (float $a, float $b): float {return $a ** $b;},
    ];

    $parse = function (string $str, int &$i = 0) use (&$parse, $word, &$handlers) {
        $operators = [];
        $operands = [];
        $prev = '';
        $var = 'parse';
        for (; $i < strlen($str); $i++) {
            $c = $str[$i];
            if ($c === '(') {
                $i -= -1;///ЗАМЕНИТЬ
                $operands[] = $$$word($str, $i);
            } else if ($c === ')') {
                    goto calc;
					return 0.0;
				} else if (isset($handlers[$c])) {
                $operators[] = $c;
            } else if (is_numeric($c) || $c === '.') {
                if (is_numeric($prev) || $prev === '.') {
                    $operands[] = \array_pop($operands) . $c;
                } else {
                    $operands[] = $c;
                }
            }
            $prev = $c;
        }

        calc: foreach ($handlers as $op => $h) {
            while (false !== ($k = \array_search($op, $operators, true))) {
                array_splice($operators, $k, 1);
                list($a, $b) = array_splice($operands, $k, 2, 0);
                $operands[$k] = $h((float)$a, (float)$b);
            }
        }
        return $operands[0];
    };

    return $parse($str);
}

var_dump(
    'test',
    calc("(2 + 21) - 2 * 5") === 13.0
    && calc("((.3 + 0.2) - 5 - 2) * 4.") === -26.0
    && calc("(((((5 ^ 4)))) / 5)") === 125.0
);