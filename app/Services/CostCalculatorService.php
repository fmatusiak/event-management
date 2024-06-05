<?php

namespace App\Services;

use App\Models\Cost;
use InvalidArgumentException;

class CostCalculatorService
{
    public function calculateCost(Cost $cost): float
    {
        $totalPackagePrice = $cost->package->price;
        $totalTransportPrice = $cost->getTransportPrice();
        $totalAddonsPrice = $cost->getAddonsPrice();

        if ($totalPackagePrice < 0 || $totalTransportPrice < 0 || $totalAddonsPrice < 0) {
            throw new InvalidArgumentException(__('error_negative_cost'));
        }

        $totalCost = $totalPackagePrice + $totalTransportPrice + $totalAddonsPrice;

        return (float)sprintf('%.2f', $totalCost);
    }
}
