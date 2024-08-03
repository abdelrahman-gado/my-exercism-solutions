<?php

/*
 * By adding type hints and enabling strict type checking, code can become
 * easier to read, self-documenting and reduce the number of potential bugs.
 * By default, type declarations are non-strict, which means they will attempt
 * to change the original type to match the type specified by the
 * type-declaration.
 *
 * In other words, if you pass a string to a function requiring a float,
 * it will attempt to convert the string value to a float.
 *
 * To enable strict mode, a single declare directive must be placed at the top
 * of the file.
 * This means that the strictness of typing is configured on a per-file basis.
 * This directive not only affects the type declarations of parameters, but also
 * a function's return type.
 *
 * For more info review the Concept on strict type checking in the PHP track
 * <link>.
 *
 * To disable strict typing, comment out the directive below.
 */

declare(strict_types=1);

function rebase(int $fromBase, array $digits, int $toBase): array
{
    if ($fromBase < 2) {
        throw new InvalidArgumentException('input base must be >= 2');
    }

    if ($toBase < 2) {
        throw new InvalidArgumentException('output base must be >= 2');
    }

    $digitsLength = count($digits); 
    if ($digitsLength < 1) {
        return [0];
    }

    $decimalNumberResult = convertToBaseTen($fromBase, $digits, $digitsLength);
    return convertToSpecificBase($decimalNumberResult, $toBase);
}

function convertToBaseTen(int $fromBase, array $digits, int $length): int
{
    $decimalNumber = 0;
    for ($i = $length - 1; $i >= 0; $i--) {
        if ($digits[$i] >= $fromBase || $digits[$i] < 0) {
            throw new InvalidArgumentException('all digits must satisfy 0 <= d < input base');
        }

        $decimalNumber += $digits[$i] * ($fromBase ** ($length - $i - 1));
    }

    return $decimalNumber;
}

function convertToSpecificBase(int $decimalNumber, int $base): array
{
    if ($decimalNumber === 0) {
        return [0];
    }

    $digits = [];
    while ($decimalNumber >= 1) {
        array_unshift($digits, $decimalNumber % $base);
        $decimalNumber = intdiv($decimalNumber, $base);
    }

    return $digits;
}

