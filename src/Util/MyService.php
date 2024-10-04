<?php
namespace App\Util;
class MyService
{
    public function reduce(string $text, int $lengthMax = 10): string
    {
        if (mb_strlen($text) > $lengthMax) {
            $text = mb_substr($text,0, $lengthMax - 3) . '...';
        }
        return $text;
    }
}