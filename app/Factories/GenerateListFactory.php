<?php

namespace App\Factories;

use Exception;

class GenerateListFactory
{

    public static function generate(int $length): array
    {
        if ($length <= 0) {
            throw new Exception('invalid length');
        }

        $result = [];
        $i = 0;
        while ($i <= $length) {
            $result[] = rand(0, 999999999);
            $i++;
        }

        return $result;
    }
}
