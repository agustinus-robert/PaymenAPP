<?php

use Modules\Account\Enums\MariageEnum;
use Modules\Account\Enums\SexEnum;
use Modules\Reference\Models\TaxTier;

if (!function_exists('getTERCategory')) {
    /**
     * Determine TER category based on marriage status and child count.
     *
     * @param string $marriageStatus Marriage status (int value).
     * @param int $childrenCount Number of children.
     * @return string|null TER category ('A', 'B', 'C', or null if not matched).
     */
    function getTERCategory($marriageStatus, $childrenCount, $sex)
    {
        // Normalize inputs
        $marriageStatus = strtoupper($marriageStatus);
        $childrenCount = intval($childrenCount);

        $ter = 'A';
        $status = 'TK/0';

        if ($sex == SexEnum::FEMALE->value) {
            $ter = 'A';
            $status = 'TK/0';
        } else {
            // TER A conditions
            if (
                ($marriageStatus == MariageEnum::SINGLE->value && $childrenCount == 0) ||
                ($marriageStatus == MariageEnum::SINGLE->value && $childrenCount == 1) ||
                ($marriageStatus == MariageEnum::MARRY->value && $childrenCount == 0)
            ) {
                $ter = 'A';
                $status = MariageEnum::tryFrom($marriageStatus)->code() . '/' . $childrenCount;
            }

            // TER B conditions
            if (
                ($marriageStatus == MariageEnum::SINGLE->value && $childrenCount == 2) ||
                ($marriageStatus == MariageEnum::SINGLE->value && $childrenCount == 3) ||
                ($marriageStatus == MariageEnum::MARRY->value && $childrenCount == 1) ||
                ($marriageStatus == MariageEnum::MARRY->value && $childrenCount == 2)
            ) {
                $ter = 'B';
                $status = MariageEnum::tryFrom($marriageStatus)->code() . '/' . $childrenCount;
            }

            // TER C conditions
            if ($marriageStatus == MariageEnum::MARRY->value && $childrenCount >= 3) {
                $ter = 'C';
                $status = MariageEnum::tryFrom($marriageStatus)->code() . '/' . $childrenCount >= 3 ? 3 : $childrenCount;
            }
        }

        return [
            'ter' => $ter,
            'status' => $status,
            'rate' => !empty($ter) ? TaxTier::where('category', $ter)->get()->map(fn($item) => [
                'ctg' => $item['category'],
                'lower' => $item['lower_bound'],
                'upper' => $item['upper_bound'],
                'percentage' => $item['rate'],
            ]) : [],
        ];
    }
}
