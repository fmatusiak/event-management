<?php

namespace App\Services;

use App\Models\Cost;
use InvalidArgumentException;

class CostCalculatorService implements CostCalculatorInterface
{
    public function calculateTotalCost(Cost $cost): float
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

    public function calculateDepositCost(float $totalCost, float $depositPercentage = 0.3): float
    {
        $depositCost = $totalCost * $depositPercentage;

        return (float)sprintf('%.2f', $depositCost);
    }

    public function calculateRemainingCostAfterDeposit(float $totalCost, float $depositCost): float
    {
        $remainingCost = $totalCost - $depositCost;

        return (float)sprintf('%.2f', $remainingCost);
    }
}
