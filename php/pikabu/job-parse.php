<?php

/**
b	The argument is treated as an integer and presented as a binary number.
c	The argument is treated as an integer and presented as the character with that ASCII.
d	The argument is treated as an integer and presented as a (signed) decimal number.
e	The argument is treated as scientific notation (e.g. 1.2e+2). The precision specifier stands for the number of digits after the decimal point since PHP 5.2.1. In earlier versions, it was taken as number of significant digits (one less).
E	Like the e specifier but uses uppercase letter (e.g. 1.2E+2).
f	The argument is treated as a float and presented as a floating-point number (locale aware).
F	The argument is treated as a float and presented as a floating-point number (non-locale aware). Available as of PHP 5.0.3.
g
General format.

Let P equal the precision if nonzero, 6 if the precision is omitted, or 1 if the precision is zero. Then, if a conversion with style E would have an exponent of X:

If P > X ≥ −4, the conversion is with style f and precision P − (X + 1). Otherwise, the conversion is with style e and precision P − 1.

G	Like the g specifier but uses E and F.
o	The argument is treated as an integer and presented as an octal number.
s	The argument is treated and presented as a string.
u	The argument is treated as an integer and presented as an unsigned decimal number.
x	The argument is treated as an integer and presented as a hexadecimal number (with lowercase letters).
X	The argument is treated as an integer and presented as a hexadecimal number (with uppercase letters).
 */
function tabulateData(string $str): string
{
    $out = '';
    foreach (explode("\n", $str) as $line) {
        $out .= sprintf(
            "%2\$' -3d %1\$'.-9s %3\$' 8.1f %5\$' 3d\n",
            ...(sscanf($line, "%[^-]-%d.%6s%[^1234567890]%i") ?: ['', 0, .0, '', 0])
        );
    }
    return rtrim($out);
}
$in = "Moderator-67.5166.3/ADm/Skf32
Admin-1.456.12mrlpWvaL/5
Support-27.96271AcsmKSdq632";
$out = <<<OUT
67  Moderator   5166.3  32
1   Admin....    456.1   5
27  Support..  96271.0 632
OUT;

var_dump(time(), tabulateData($in), $out, tabulateData($in) === $out);