<?php

namespace App\Services;

use App\Models\Cost;

interface CostCalculatorInterface
{
    public function calculateTotalCost(Cost $cost): float;

    public function calculateDepositCost(float $totalCost, float $depositPercentage = 0.3): float;

    public function calculateRemainingCostAfterDeposit(float $totalCost, float $depositCost): float;
}
