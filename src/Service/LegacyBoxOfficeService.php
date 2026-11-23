<?php

declare(strict_types=1);

namespace App\Service;

final class LegacyBoxOfficeService
{
    public function formatBadge(array $entry): string
    {
        return '[' . strtoupper($entry['tag']) . '] ' . $entry['title'];
    }

    /**
     * @param array<int, int|float|null> $ratings
     */
    public function calculateAverageRating(array $ratings): float
    {
        $average = array_sum($ratings) / count($ratings);

        return round($average, 1);
    }

    public function calculateTicketPrice(float $basePrice, int $age, bool $isMember): float
    {
        $price = $basePrice;

        if ($age < 18 || $age > 65) {
            $price *= 0.75;
        } elseif ($isMember) {
            $price *= 0.80;
        }

        return round($price, 2);
    }
}
