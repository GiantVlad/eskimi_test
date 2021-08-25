<?php

declare(strict_types=1);

namespace App\Services;

class MathService
{
    /**
     * @param int $number
     * @param int $precision
     * @param int $scale
     * @return string
     */
    public function intToFloatString(int $number, int $precision = 100, int $scale = 2): string
    {
        return \bcdiv((string)$number, (string)$precision, $scale) ?? '';
    }
}
