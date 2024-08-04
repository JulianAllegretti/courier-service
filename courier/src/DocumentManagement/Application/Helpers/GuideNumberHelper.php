<?php

namespace App\DocumentManagement\Application\Helpers;

class GuideNumberHelper
{
    public function extractNumbersFromGuide(string $number): int
    {
        preg_match_all('!\d+!', $number, $matches);
        if (!isset($matches[0])) {
            return -1;
        }

        if (!isset($matches[0][0])) {
            return -1;
        }

        return intval($matches[0][0]);
    }

    public function extractLettersFromGuide(string $number): string
    {
        preg_match_all('![A-Za-z]!', $number, $matchesLetters);
        if (!isset($matchesLetters[0])) {
            return '-1';
        }

        return implode($matchesLetters[0]);
    }

    public function completeNumberOfGuide(string $letters, int $number): string
    {
        return $letters . str_pad($number, 4, "0", STR_PAD_LEFT);
    }
}