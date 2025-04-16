<?php

namespace App\Services\Estimate;

use App\Models\Estimate;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class TimeEstimationService
{
    private int $floorTimePercentage;
    private int $normalLoadTime;
    private int $specificLoadTime;
    private int $formReviewTime;
    private int $averageAgentArrivalTimeAtUserHome;
    private string $customMessage;

    public function __construct()
    {
        $this->floorTimePercentage = config('time_estimation.floor_time_percentage');
        $this->normalLoadTime = config('time_estimation.normal_load_time');
        $this->specificLoadTime = config('time_estimation.specific_load_time');
        $this->formReviewTime = config('time_estimation.form_review_time');
        $this->averageAgentArrivalTimeAtUserHome = config('time_estimation.average_agent_arrival_time_at_user_home');
        $this->customMessage = config('time_estimation.custom_message');
    }

    public function prepareBasicInformation($request): array
    {
        $estimate = Estimate::query()->find($request->estimate_id);
        $weight = $estimate->loads->weight;
        $baseWeight = $estimate->loads->weight;
        $volumeWeight = $estimate->loads->volume_weight;
        $loadWidth = $estimate?->loads?->size_width;
        $loadHeight = $estimate?->loads?->size_height;
        $loadLength = $estimate?->loads?->size_length;
        $isSpecific = $request->load_type;
        $isUrgent = $request->urgent;
        $isBulk = $request->bulky_load;
        $packaging = $request->packaging;
        $hasFloor = $request->has_floor;
        $floorsCount = $request->floors_count;

        return compact('estimate', 'weight', 'baseWeight', 'volumeWeight',
            'loadWidth', 'loadHeight', 'loadLength', 'isSpecific', 'isUrgent', 'isBulk', 'packaging', 'hasFloor', 'floorsCount');
    }

    public function validateWeightAndDimensions($weight, $loadWidth, $loadHeight, $loadLength): bool|string
    {
        if ($weight >= 300 && $weight <= 500) {
            if ($loadWidth == 0 || $loadHeight == 0 || $loadLength == 0)
                return $this->customMessage;
        }

        return false;
    }

    public function determineTimeMetric($isSpecific, $hasFloor = false, $floorsCount = 0, $packaging = 1): float|int
    {

        if ($packaging == 1) {

            $timeMetric = match ($isSpecific) {
                'normal' => $this->normalLoadTime,
                'special' => $this->specificLoadTime,
                default => 1
            };

            if ($hasFloor)
                $timeMetric += ($floorsCount * calculatePercent($timeMetric, $this->floorTimePercentage)); /* By default: 20% */

        } else {

            $timeMetric = 1;

        }

        return $timeMetric;
    }

    public function calculateVolumetricWeight($loadWidth, $loadHeight, $loadLength, $estimate): array
    {
        if ($loadWidth && $loadHeight && $loadLength) {

            $volumeWeight = round(($loadWidth * $loadHeight * $loadLength) / 6000, 2);

            if ($volumeWeight > 0)
                $weight = max($volumeWeight, $estimate->loads->weight);
            else
                $weight = $estimate->loads->weight;

        } else {

            $weight = $estimate->loads->weight;
            $volumeWeight = 0;

        }

        return compact('weight', 'volumeWeight');
    }

    public function checkAndSetBulkStatus($weight, $isBulk) {
        if ($weight > 500)
            return 1;
        else
            return $isBulk;
    }

    public function updateBulkStatus($estimate, $isBulk): void
    {
        $estimate->update([
            'isBulk' => $isBulk
        ]);
    }

    public function estimateTimeBasedOnWeight($weight, $timeMetric): float|int
    {
        $weightFactor =  $weight / 100;
        $estimatedTime = $timeMetric * $weightFactor;
        return $estimatedTime + $this->averageAgentArrivalTimeAtUserHome + $this->formReviewTime;
    }

}
