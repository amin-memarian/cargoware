<?php

namespace App\Services\Estimate;

use App\Models\SaleComission;
use Illuminate\Support\Facades\Auth;

class EstimateCostService
{
    protected object $airportRate;
    protected object $airport;
    protected int $airportComissionRate;
    protected int $userId;
    protected ?SaleComission $comissionTable;
    protected $weight;

    public function __construct(object $airportRate, object $airport, SaleComission $comissionTable = null, $weight)
    {
        $this->airport = $airport;
        $this->airportRate = $airportRate;
        $this->airportComissionRate = 0;
        $this->userId = Auth::id();
        $this->comissionTable = $comissionTable;
        $this->weight = $weight;
    }

    public function qatarRate()
    {

        if (!$this->airportRate)
            return false;

        // Raw additional constants
        $INC = $this->airport->INC ?: 0.03;
        $SCC = $this->airport->SCC ?: 0.08;
        $MAA = $this->airport->MMA ?: 15;
        $CGC = $this->airport->CGC ?: 2.5;
        $AWC = $this->airport->AWC ?: 5;
        $SCC_MIN = $this->airport->SCC_min ?: 16;

        // On weight
        $incByKilogram = $this->weight * $INC;
        $sccByKilogram = $this->weight * $SCC;


        // Calculate qatar rate
        $qatarRate = breakPoint($this->airportRate, $this->weight);

        // Determine commission rate based on weight
        if ($this->comissionTable)
            $this->airportComissionRate = saleComission($this->weight, $this->comissionTable);

        $sumRates = $qatarRate + ($this->airportComissionRate ?: 0) + $INC;

        // Calculate rate per kilogram
        $rateByKilogram = $this->weight * $sumRates;

        // Qatar constant values
        $sccByKilogram = max($sccByKilogram, $SCC_MIN);

        // Calculate rate by USDT
        $rateByUsdt = $rateByKilogram + $sccByKilogram;

        // Add additional constants
        $rateByUsdt += $MAA + $CGC + $AWC;

        // Calculate tax
        $taxAmount = calculatePercent($rateByUsdt, 10);

        // Apply tax
        $totalAmount = $rateByUsdt + $taxAmount; // Includes 10% tax directly

        // Prepare information for front
        $qatarInformation = [
            'rate' => $qatarRate,
            'commissionRate' => $this->airportComissionRate,
            'sumRates' => $sumRates,
            'tax' => $taxAmount,
            'INC' => $incByKilogram,
            'SCC' => $sccByKilogram,
            'MAA' => $MAA,
            'CGC' => $CGC,
            'AWC' => $AWC,
        ];
        $this->storeInSession($qatarInformation, 'qatarInformation' . $this->userId);

        // Convert to IRR
        return changeAmountToIRR($totalAmount, "Qatar");


    }

    private function storeInSession($array, $sessionKey): void
    {
        session()->put($sessionKey, $array);
    }

}
