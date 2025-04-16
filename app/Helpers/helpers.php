<?php


use App\Models\AeroflotRate;
use App\Models\TurkishRate;
use App\Models\VareshRate;
use App\Models\Waybill;
use Carbon\Carbon;
use Hekmatinasser\Jalali\Jalali;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Morilog\Jalali\Jalalian;
use App\Imports\DistanceImport;
use App\Models\AirArabiaRate;
use App\Models\Airline;
use App\Models\Countries;
use App\Models\Distance;
use App\Models\EmiratesRate;
use App\Models\FlyDubaiRate;
use App\Models\IranAirRate;
use App\Models\MahanAirRate;
use App\Models\QatarRate;
use App\Models\QeshmAirRate;
use App\Models\SaleComission;


if (!function_exists('timestamp_to_date_time')) {
    function timestamp_to_date_time(string $timestamp): string
    {
        return Carbon::createFromTimestamp($timestamp)->toDateTimeString();
    }
}

if (!function_exists('gregorian_date_to_shamsi_date')) {
    function gregorian_date_to_shamsi_date(string $gregorianDate, bool $hasTime = false): string
    {
        $gregorianDate = Carbon::parse($gregorianDate);
        $format = $hasTime ? 'Y/m/d H:i:s' : 'Y/m/d';

        return Jalalian::fromCarbon($gregorianDate)->format($format);
    }
}

if (!function_exists('timestamp_to_date')) {
    /**
     * Convert timestamp to a formatted date string.
     *
     * @param int $timestamp
     * @param string $format
     * @return string
     */
    function timestamp_to_date(int $timestamp, string $format = 'Y-m-d'): string
    {
        // Use Carbon to handle the conversion
        return Carbon::createFromTimestamp($timestamp)->format($format);
    }
}

if (!function_exists('isEqual')) {
    function isEqual($value1, $value2): bool
    {
        if ($value1 == $value2)
            return true;
        else
            return false;
    }
}

if (!function_exists('isActive')) {
    function isActive($targetPath): string
    {
        return request()->is($targetPath) ? 'active' : '';
    }
}

if (!function_exists('convertNumbersToPersian')) {
    function convertNumbersToPersian($number): string
    {
        $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];

        return strtr($number, array_combine($englishNumbers, $persianNumbers));
    }
}

if (!function_exists('generateCaseNumber')) {
    function generateCaseNumber(): string
    {
        $date = Jalali::now()->format('Y-m-d');
        $uniqueCode = strtoupper(uniqid());
        $caseNumber = $date . '-' . $uniqueCode;

        return $caseNumber;
    }
}

if (!function_exists('extractError')) {
    function extractError($e): string
    {
        return 'message : ' . $e->getMessage() . ' at line : ' . $e->getLine() . ' in : ' . $e->getFile();
    }
}

if (!function_exists('userIsAdmin')) {
    function userIsAdmin($user, $for = 'option'): string
    {
        switch ($for) {
            case 'option':
            default:
                return $user->id == \Illuminate\Support\Facades\Auth::id() ? 'مدیر' : $user->information;
        }
    }
}

if (!function_exists('calculatePercent')) {
    function calculatePercent($amount, $percent): float|int
    {
      return ($amount * $percent) / 100;
    }
}

if (!function_exists('clamp')) {
    function clamp($value, $min, $max) {
        return max($min, min($value, $max));
    }
}

if (!function_exists('findAirlineInformationByName')) {
    function findAirlineInformationByName($airlineName): array|null
    {
        $key = match ($airlineName) {
            'Qatar' => 'qatarInformation',
            'Fly Dubai' => 'flyDubaiInformation',
            'Air Arabia' => 'airArabiaInformation',
            'Emirates' => 'emiratesInformation',
            'Iran Air' => 'iranAirInformation',
            'Qeshm Air' => 'qeshmAirInformation',
            'Mahan Air' => 'mahanAirInformation',
            'Turkish' => 'turkishInformation',
            'Varesh' => 'vareshInformation',
            'Aeroflot' => 'aeroflotInformation',
            default => null,
        };

        return session($key . Auth::id());
    }
}

if (!function_exists('getCountryFromCode')) {
    function getCountryFromCode($code)
    {
        $airports = require_once public_path('airport_codes.php');

        return @$airports[$code] ?: null;
    }
}

if (!function_exists('convertToRial')) {
    function convertToRial($price)
    {
        return $price * 10;
    }
}

if (!function_exists('estimateQatar')) {
    function estimateQatar($destination, $weight)
    {

        $qatarAirline = QatarRate::query()->where('destination', $destination)->first();
        $qatarAirlineData = Airline::query()->where('name', 'Qatar')->first();
        $qatarCommissionRate = 0;

        if ($qatarAirline) {

            // Raw additional constants
            $INC = $qatarAirlineData->INC ?: 0.03;
            $SCC = $qatarAirlineData->SCC ?: 0.08;
            $MAA = $qatarAirlineData->MMA ?: 15;
            $CGC = $qatarAirlineData->CGC ?: 2.5;
            $AWC = $qatarAirlineData->AWC ?: 5;
            $SCC_MIN = $qatarAirlineData->SCC_min ?: 16;

            // On weight
            $incByKilogram = $weight * $INC;
            $sccByKilogram = $weight * $SCC;

            $qatarSaleCommission = SaleComission::query()->where('airline_id', $qatarAirlineData->id)->first();

            // Calculate qatar rate
            $breakPoint = breakPoint($qatarAirline, $weight);
            $chargeableWeight = $breakPoint['chargeableWeight'];
            $qatarRate = $breakPoint['rate'];

            // Determine commission rate based on weight
            if ($qatarSaleCommission)
                $qatarCommissionRate = saleComission($weight, $qatarSaleCommission);

            $sumRates = $qatarRate + ($qatarCommissionRate ?: 0) + $INC;

            // Calculate rate per kilogram
            $rateByKilogram = $weight * $sumRates;

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
              'commissionRate' => $qatarCommissionRate,
              'sumRates' => $sumRates,
              'tax' => $taxAmount,
              'INC' => $INC,
              'SCC' => $sccByKilogram,
              'MAA' => $MAA,
              'CGC' => $CGC,
              'AWC' => $AWC,
            ];
            session()->put('qatarInformation' . Auth::id(), $qatarInformation);


            $sumOfAgentVariables = $MAA;
            $agentVariables = [
                'MAA' => ' ' . $MAA . ' USD)'
            ];
            $carrierVariables = [
                'INC' => ' ' . $incByKilogram . ' ( ' . $INC .' USD/Kg)',
                'SCC' => ' ' . $sccByKilogram . ' ( ' . $SCC .' USD/Kg)',
                'AWC' => ' ' . $AWC . ' USD',
                'CGC' => ' ' . $CGC . ' USD',
            ];
            $sumOfCarrierVariables = $incByKilogram + $sccByKilogram + $AWC + $CGC;

            $qatarWaybill = [
                'sumOfAgentVariables' => $sumOfAgentVariables,
                'sumOfCarrierVariables' => $sumOfCarrierVariables,
                'agent_variables' => $agentVariables,
                'carrier_variables' => $carrierVariables,
                'rate' => $qatarRate,
                'chargeableWeight' => $chargeableWeight
            ];

            // Convert to IRR
            $qatarEstimate = changeAmountToIRR($totalAmount, "Qatar");

            return compact('qatarWaybill', 'qatarEstimate');

        }
        return false;
    }
}

if (!function_exists('estimateIranAir')) {
    function estimateIranAir($destination, $weight)
    {
        $iranAir = IranAirRate::query()->where('destination', $destination)->first();
        $iranAirAirlineData = Airline::query()->where('name', 'Iran Air')->first();

        if ($iranAir) {

            // The percentage the airline intended to add to the base rate
            $airlineIntendedPercentage = $iranAirAirlineData->sale_rate ?: 15;

            // Raw additional constants
            $AWC = $iranAirAirlineData->AWC ?: 3000000;
            $AWA = $iranAirAirlineData->AWA ?: 7000000;
            $AWB = $AWC + $AWA;
            $SCC = $iranAirAirlineData->SCC ?: 2000;
            $SCC_MIN = $iranAirAirlineData->SCC_min ?: 1000000;
            $TVC = 0;

            // On weight
            // Iran air constant values
            $sccByKilogram = $weight * $SCC;
            $sccByKilogram = max($sccByKilogram, $SCC_MIN);

            // Note: 15% should have been added to the base rate for this airline
            $breakPoint = breakPoint($iranAir, $weight);
            $chargeableWeight = $breakPoint['chargeableWeight'];
            $iranAirRate = $breakPoint['rate'];
            $baseIranAirRate = $iranAirRate;
            $newIranAirRate = calculatePercent($iranAirRate, $airlineIntendedPercentage);

            $iranAirRate += $newIranAirRate;

            // Rate by kilogram (step 1)
            $rateByKilogram = $weight * $iranAirRate;


            // Add additional constants (step 2,3)
            $rateByToman = $rateByKilogram + $AWB;
            $rateByToman += $sccByKilogram;

            // Calculate tax or tvc
            $taxAmount = calculatePercent($rateByToman, 10);

            // Apply tax
            $totalAmount = $rateByToman + $taxAmount; // Includes 10% tax directly


            // Prepare information for front
            $iranAirInformation = [
                'rate' => number_format(($iranAirRate - $newIranAirRate)),
                'commissionRate' => number_format($newIranAirRate),
                'sumRates' => number_format($iranAirRate),
                'tax' => number_format($taxAmount),
                'AWB' => number_format($AWB),
                'SCC' => number_format($sccByKilogram),
            ];
            session()->put('iranAirInformation' . Auth::id(), $iranAirInformation);


            $sumOfAgentVariables = $AWA;
            $agentVariables = [
                'AWA' => ' ' . $AWA . ' IRR'
            ];
            $carrierVariables = [
                'AWC' => ' ' . $AWC . ' IRR',
                'SCC' => ' ' . $sccByKilogram . ' ( ' . $SCC .' IRR/Kg)',
            ];
            $sumOfCarrierVariables = $AWC + $sccByKilogram;

            $iranAirWaybill = [
                'sumOfAgentVariables' => $sumOfAgentVariables,
                'sumOfCarrierVariables' => $sumOfCarrierVariables,
                'agent_variables' => $agentVariables,
                'carrier_variables' => $carrierVariables,
                'rate' => $baseIranAirRate,
                'chargeableWeight' => $chargeableWeight
            ];

            $iranAirEstimate = $totalAmount;

            return compact('iranAirWaybill', 'iranAirEstimate');
        }
        return false;
    }
}

if (!function_exists('estimateQeshmAir')) {
    function estimateQeshmAir($destination, $weight)
    {
        $qeshmAir = QeshmAirRate::where('destination', $destination)->first();
        $qeshmAirAirlineData = Airline::where('name', 'Qeshm Air')->first();

        if ($qeshmAir) {

            // For convert EK to IRT
            $ROE = getROE('Qeshm Air');

            // Raw additional constants
            $AWC = $qeshmAirAirlineData->AWC ?: 8000000;
            $SCC = $qeshmAirAirlineData->SCC ?: 0.11;
            $SCC_MIN = $qeshmAirAirlineData->SCC_min ?: 12;
            $HXC = $qeshmAirAirlineData->HXC ?: 30000000;

            // On weight
            $sccByKilogram = $weight * $SCC;

            // Calculate qeshm rate
            $breakPoint = breakPoint($qeshmAir, $weight, false, true);
            $chargeableWeight = $breakPoint['chargeableWeight'];
            $qeshmAirRate = $breakPoint['rate'];

            $sumRates = $qeshmAirRate;

            // Calculate rate per kilogram
            $rateByKilogram = $weight * $qeshmAirRate;

            // Qatar constant values
            $sccByKilogram = max($sccByKilogram, $SCC_MIN);

            // Convert to toman
            $sccByKilogram *= $ROE;

            // Calculate rate by USDT
            $rateByUsdt = $rateByKilogram + $sumRates;

            // Add additional constants
            $rateByUsdt += $AWC + $sccByKilogram + $HXC;

            // Calculate tax
            $taxAmount = calculatePercent($rateByUsdt, 10);

            // Apply tax
            $totalAmount = $rateByUsdt + $taxAmount; // Includes 10% tax directly

            // Prepare information for front
            $qeshmAirInformation = [
                'rate' => number_format($qeshmAirRate),
                'commissionRate' => 0,
                'sumRates' => number_format($sumRates),
                'tax' => number_format($taxAmount),
                'AWC' => number_format($AWC),
                'SCC' => $sccByKilogram / $ROE, // Convert to EK
                'HXC' => number_format($HXC),
            ];

            session()->put('qeshmAirInformation' . Auth::id(), $qeshmAirInformation);


            $sumOfAgentVariables = 0;
            $agentVariables = [];
            $carrierVariables = [
                'AWC' => ' ' . $AWC . ' IRR',
                'HXC' => ' ' . $HXC . ' IRR'
            ];
            $sumOfCarrierVariables = $AWC + $HXC;

            $qeshmAirWaybill = [
                'sumOfAgentVariables' => $sumOfAgentVariables,
                'sumOfCarrierVariables' => $sumOfCarrierVariables,
                'agent_variables' => $agentVariables,
                'carrier_variables' => $carrierVariables,
                'rate' => $qeshmAirRate,
                'chargeableWeight' => $chargeableWeight
            ];

            $qeshmAirEstimate = $totalAmount;

            return compact('qeshmAirWaybill', 'qeshmAirEstimate');

        }

        return false;
    }
}

if (!function_exists('estimateMahanAir')) {
    function estimateMahanAir($destination, $weight)
    {
        $mahanAir = MahanAirRate::query()->where('destination', $destination)->first();
        $mahanAirAirlineData = Airline::where('name', 'Mahan Air')->first();
        if ($mahanAir) {

            // Raw additional constants
            $AWC = $mahanAirAirlineData->AWC ?: 3000000;
            $SCC = $mahanAirAirlineData->SCC ?: 30000;
            $SCC_MIN = $mahanAirAirlineData->SCC_min ?: 6000000;
            $ATA = $mahanAirAirlineData->ATA ?: 9;
            $ATA_MIN = $mahanAirAirlineData->ATA_min ?: 4000000;
            $ATA_MAX = $mahanAirAirlineData->ATA_max ?: 50000000;
            $TDC = $mahanAirAirlineData->ATA_max ?: 10;

            // get rate from rate sheet or calculate breakpoint
            $breakPoint = breakPoint($mahanAir, $weight);
            $chargeableWeight = $breakPoint['chargeableWeight'];
            $mahanAirRate = $breakPoint['rate'];

            // Rate by kilogram (step 1)
            $rateByKilogram = $weight * $mahanAirRate;

            // On weight
            // Iran air constant values
            $sccByKilogram = $weight * $SCC;
            $sccByKilogram = max($sccByKilogram, $SCC_MIN);

            $ataByKilogram = calculatePercent($rateByKilogram, $ATA);
            $baseAtaByKilogram = $ataByKilogram;
            $ataByKilogram = clamp($ataByKilogram, $ATA_MIN, $ATA_MAX);

            // Add additional constants (step 2,3,4)
            $rateByToman = $rateByKilogram + $AWC;
            $rateByToman += $sccByKilogram;
            $rateByToman += $ataByKilogram;

            // Calculate tax
            $taxAmount = calculatePercent($rateByToman, 10);

            // Apply tax
            $totalAmount = $rateByToman + $taxAmount; // Includes 10% tax directly

            // Prepare information for front
            $mahanAirInformation = [
                'rate' => number_format($mahanAirRate),
                'commissionRate' => 0,
                'sumRates' => number_format($mahanAirRate),
                'tax' => number_format($taxAmount),
                'AWC' => number_format(convertToRial($AWC)),
                'SCC' => number_format(convertToRial($sccByKilogram)),
                'ATA' => number_format($ataByKilogram)
            ];
            session()->put('mahanAirInformation' . Auth::id(), $mahanAirInformation);

            $sumOfAgentVariables = $baseAtaByKilogram;
            $variables = [
                'ATA' => $ataByKilogram,
                'AWC' => $AWC,
                'SCC' => $sccByKilogram,
            ];
            $agentVariables = [
                'ATA' => ' ' . $baseAtaByKilogram . ' ( ' . $ATA . ' kg.rate )'
            ];
            $carrierVariables = [
                'AWC' => ' ' . $AWC . ' IRR',
                'SCC' => ' ' . $sccByKilogram . ' ( ' . $SCC . ' IRR/kg )'
            ];
            $sumOfCarrierVariables = $AWC + $sccByKilogram;

            $mahanAirWaybill = [
                'sumOfAgentVariables' => $sumOfAgentVariables,
                'sumOfCarrierVariables' => $sumOfCarrierVariables,
                'agent_variables' => $agentVariables,
                'carrier_variables' => $carrierVariables,
                'variables' => $variables,
                'rate' => $mahanAirRate,
                'chargeableWeight' => $chargeableWeight
            ];

            $mahanAirEstimate = $totalAmount;

            return compact('mahanAirWaybill', 'mahanAirEstimate');

        }
        return false;
    }
}

if (!function_exists('estimateAirArabia')) {

    function estimateAirArabia($destination, $weight)
    {
        $airArabiaAirline = AirArabiaRate::query()->where('destination', $destination)->first();
        $airArabiaAirlineData = Airline::query()->where('name', 'Air Arabia')->first();
        $airArabiaCommissionRate = 0;

        if ($airArabiaAirline) {

            // Raw additional constants
            $ATA = $airArabiaAirline->ATA ?: 10;
            $AWC = $airArabiaAirline->AWC ?: 20;

            // Calculate break point rate
            $breakPoint = breakPoint($airArabiaAirline, $weight);
            $chargeableWeight = $breakPoint['chargeableWeight'];
            $airArabiaRate = $breakPoint['rate'];


            // Determine commission rate based on weight
            $airArabiaSaleCommission = SaleComission::where('airline_id', $airArabiaAirlineData->id)->first();
            if ($airArabiaSaleCommission)
                $airArabiaCommissionRate = saleComission($weight, $airArabiaSaleCommission);

            $sumRates = $airArabiaRate + ($airArabiaCommissionRate ?: 0);

            // air arabia kg*rate step one
            $rateByKilogram = $weight * $sumRates;

            $rateByUsdt = $rateByKilogram;
            $test = $rateByUsdt;
            // step 3 & 4
            $rateByUsdt = $rateByUsdt + $AWC + $ATA;

            $taxAmount = calculatePercent($rateByUsdt, 10);

            // Apply tax
            $totalAmount = $rateByUsdt + $taxAmount; // Includes 10% tax directly

            // Prepare information for front
            $airArabiaInformation = [
                'rate' => $airArabiaRate,
                'commissionRate' => $airArabiaCommissionRate,
                'sumRates' => $sumRates,
                'tax' => $taxAmount,
                'AWC' => $AWC,
                'ATA' => $ATA
            ];
            session()->put('airArabiaInformation' . Auth::id(), $airArabiaInformation);


            $sumOfAgentVariables = $ATA;
            $agentVariables = [
                'ATA' => ' ' . $ATA . ' USD'
            ];
            $carrierVariables = [
                'AWC' => ' ' . $AWC . ' USD'
            ];
            $sumOfCarrierVariables = $AWC;

            $airArabiaWaybill = [
                'sumOfAgentVariables' => $sumOfAgentVariables,
                'sumOfCarrierVariables' => $sumOfCarrierVariables,
                'agent_variables' => $agentVariables,
                'carrier_variables' => $carrierVariables,
                'rate' => $airArabiaRate,
                'chargeableWeight' => $chargeableWeight
            ];

            $airArabiaEstimate = changeAmountToIRR($totalAmount, 'Air Arabia');

            return compact('airArabiaWaybill', 'airArabiaEstimate');

        }
        return false;
    }
}

if (!function_exists('estimateFlyDubai')) {
    function estimateFlyDubai($destination, $weight)
    {
        $flyDubaiAirline = FlyDubaiRate::query()->where('destination', $destination)->first();
        $flyDubaiAirlineData = Airline::query()->where('name', 'Fly Dubai')->first();
        $flyDubaiSaleCommissionRate = 0;

        if ($flyDubaiAirline) {

            // Raw additional constants
            $SCC = $flyDubaiAirlineData->SCC ?: 0.05;
            $MAA = $flyDubaiAirlineData->MAA ?: 20;
            $AWC = $flyDubaiAirlineData->AWC ?: 8.5;

            // On weight
            $sccByKilogram = $weight * $SCC;

            $flyDubaiSaleCommission = SaleComission::query()->where('airline_id', $flyDubaiAirlineData->id)->first();

            // Calculate fly dubai rate
            $breakPoint = breakPoint($flyDubaiAirline, $weight);
            $chargeableWeight = $breakPoint['chargeableWeight'];
            $flyDubaiRate = $breakPoint['rate'];

            // Determine commission rate based on weight
            if ($flyDubaiSaleCommission) {
                $flyDubaiSaleCommissionRate = saleComission($weight, $flyDubaiSaleCommission);
            }
            $sumRates = $flyDubaiRate + ($flyDubaiSaleCommissionRate ?: 0);

            // Calculate rate per kilogram (step 1)
            $rateByKilogram = $weight * ($sumRates + $SCC);


            // Calculate rate by USDT
            $rateByUsdt = $rateByKilogram;

            // Add additional constants
            $rateByUsdt += $MAA + $AWC;

            $taxAmount = calculatePercent($rateByUsdt, 10);

            // Apply tax
            $totalAmount = $rateByUsdt + $taxAmount; // Includes 10% tax directly

            // Prepare information for front
            $flyDubaiInformation = [
                'rate' => $flyDubaiRate,
                'commissionRate' => $flyDubaiSaleCommissionRate,
                'sumRates' => $sumRates,
                'tax' => $taxAmount,
                'SCC' => $SCC,
                'MAA' => $MAA,
                'AWC' => $AWC,
            ];
            session()->put('flyDubaiInformation' . Auth::id(), $flyDubaiInformation);

            $sumOfAgentVariables = $MAA;
            $agentVariables = [
                'MAA' => ' ' . $MAA . ' USD'
            ];
            $carrierVariables = [
                'SCC' => ' ' . $sccByKilogram . ' ( ' . $SCC . ' USD/kg )',
                'AWC' => ' ' . $AWC . ' USD'
            ];
            $sumOfCarrierVariables = $sccByKilogram + $AWC;

            $flyDubaiWaybill = [
                'sumOfAgentVariables' => $sumOfAgentVariables,
                'sumOfCarrierVariables' => $sumOfCarrierVariables,
                'agent_variables' => $agentVariables,
                'carrier_variables' => $carrierVariables,
                'rate' => $flyDubaiRate,
                'chargeableWeight' => $chargeableWeight
            ];

            $flyDubaiEstimate = changeAmountToIRR($totalAmount, 'Fly Dubai');

            return compact('flyDubaiWaybill', 'flyDubaiEstimate');


        }
        return false;
    }
}

if (!function_exists('estimateEmirates')) {
    function estimateEmirates($destination, $weight)
    {
        $emiratesAirline = EmiratesRate::query()->where('destination', $destination)->first();
        $emiratesAirlineData = Airline::query()->where('name', 'Emirates')->first();
        $emiratesCommissionRate = 0;

        if ($emiratesAirline) {


            // calculate MYC for emirates
            $enTitle = Countries::query()->where('en_title', $destination)->pluck('en_title')->first();
            $countryName = getCountryFromCode($enTitle);
            $emiratesDistance = Distance::query()->where('name', $countryName)->pluck('distance')->first();
            $MYC = match ($emiratesDistance) {
                'Short' => 0.18,
                'Medium' => 0.30,
                'Long' => 0.42,
                default => 0.42,
            };

            if ($MYC == 0)
                return false;

            // Raw additional constants
            $FEC = $emiratesAirlineData->FEC ?: 0.07;
            $XDC = $emiratesAirlineData->XDC ?: 0.05;
            $AWC = $emiratesAirlineData->AWC ?: 5;
            $CGC = $emiratesAirlineData->CGC ?: 2.5;
            $MCC = $emiratesAirlineData->MCC ?: 1;

            // On weight
            $fecByKilogram = $weight * $FEC;
            $xdcByKilogram = $weight * $XDC;

            // Calculate break point rate
            $breakPoint = breakPoint($emiratesAirline, $weight);
            $chargeableWeight = $breakPoint['chargeableWeight'];
            $emiratesRate = $breakPoint['rate'];

            // emirates sales comission
            $emiratesSaleComission = SaleComission::query()->where('airline_id', $emiratesAirlineData->id)->first();

            // check sale comission rate airline
            if ($emiratesSaleComission)
                $emiratesCommissionRate = saleComission($weight, $emiratesSaleComission);

            $sumRates = $emiratesRate + ($emiratesCommissionRate ?: 0);


            // Calculate rate by USDT (step 1,2)
            $rateByUsdt = $weight * ($sumRates + $MYC + $FEC + $XDC);

            // Add additional constants (step 3)
            $rateByUsdt += $AWC + $CGC + $MCC;

            // Calculate tax
            $taxAmount = calculatePercent($rateByUsdt, 10);

            // Apply tax
            $totalAmount = $rateByUsdt + $taxAmount; // Includes 10% tax directly

            // Prepare information for front
            $emiratesInformation = [
                'rate' => $emiratesRate,
                'commissionRate' => $emiratesCommissionRate,
                'sumRates' => $sumRates + $MYC + $FEC + $XDC,
                'tax' => $taxAmount,
                'FEC' => $FEC,
                'XDC' => $XDC,
                'MYC' => $MYC,
                'AWC' => $AWC,
                'CGC' => $CGC,
                'MCC' => $MCC,
            ];
            session()->put('emiratesInformation' . Auth::id(), $emiratesInformation);

            $sumOfAgentVariables = 0;
            $agentVariables = [];
            $carrierVariables = [
              'AWC' => $AWC . ' USD',
              'MCC' => $MCC . ' USD',
              'CGC' => $CGC . ' USD',
              'MYC' => $MYC . ' ( 0.42 USD/Kg)',
              'FEC' => $FEC . ' ( 0.07 USD/Kg)',
              'XDC' => $XDC . ' ( 0.05 USD/Kg)',
            ];
            $sumOfCarrierVariables = $AWC + $MCC + $CGC + $MYC + $FEC + $XDC;

            $emiratesWaybill = [
                'sumOfAgentVariables' => $sumOfAgentVariables,
                'sumOfCarrierVariables' => $sumOfCarrierVariables,
                'agent_variables' => $agentVariables,
                'carrier_variables' => $carrierVariables,
                'rate' => $emiratesRate,
                'chargeableWeight' => $chargeableWeight
            ];

            // change to IRR
            $emiratesEstimate = changeAmountToIRR($totalAmount, 'Emirates');


            return compact('emiratesWaybill', 'emiratesEstimate');

        }
        return false;
    }
}

if (!function_exists('estimateTurkish')) {
    function estimateTurkish($destination, $weight)
    {
        $turkishSheetRate = TurkishRate::query()->where('destination', $destination)->first();
        $turkishData = Airline::query()->where('name', 'Turkish')->first();
        $turkishCommissionRate = 0;

        if ($turkishSheetRate) {

            // Raw additional constants
            $AWC = $turkishData->AWC ?: 15;
            $CGC = $turkishData->CGC ?: 10;

            // Calculate break point rate
            $breakPoint = breakPoint($turkishSheetRate, $weight);
            $chargeableWeight = $breakPoint['chargeableWeight'];
            $turkishRate = $breakPoint['rate'];

            // emirates sales comission
            $turkishSalesCommission = SaleComission::query()->where('airline_id', 4)->first();

            // check sale comission rate airline
            if ($turkishSalesCommission)
                $turkishCommissionRate = saleComission($weight, $turkishSalesCommission);

            $sumRates = $turkishRate + ($turkishCommissionRate ?: 0);

            // Calculate rate by USDT (step 1,2)
            $rateByUsdt = $weight * $sumRates;

            // Add additional constants (step 3)
            $rateByUsdt += $AWC + $CGC;

            // Calculate tax
            $taxAmount = calculatePercent($rateByUsdt, 10);

            // Apply tax
            $totalAmount = $rateByUsdt + $taxAmount; // Includes 10% tax directly

            // Prepare information for front
            $turkishInformation = [
                'rate' => $turkishRate,
                'commissionRate' => $turkishCommissionRate,
                'sumRates' => $sumRates,
                'tax' => $taxAmount,
                'AWC' => $AWC,
                'CGC' => $CGC,
            ];
            session()->put('turkishInformation' . Auth::id(), $turkishInformation);


            $sumOfAgentVariables = 0;
            $agentVariables = [];
            $carrierVariables = [
                'AWC' => ' ' . $AWC . ' USD',
                'CGC' => ' ' . $CGC . ' USD',
            ];
            $sumOfCarrierVariables = $AWC + $CGC;

            $turkishWaybill = [
                'sumOfAgentVariables' => $sumOfAgentVariables,
                'sumOfCarrierVariables' => $sumOfCarrierVariables,
                'agent_variables' => $agentVariables,
                'carrier_variables' => $carrierVariables,
                'rate' => $turkishRate,
                'chargeableWeight' => $chargeableWeight
            ];

            // change to IRR
            $turkishEstimate = changeAmountToIRR($totalAmount, 'Turkish');

            return compact('turkishWaybill', 'turkishEstimate');


        }
        return false;
    }
}

if (!function_exists('estimateVaresh')) {
    function estimateVaresh($destination, $weight)
    {

        $vareshSheetRate = VareshRate::query()->where('destination', $destination)->first();
        $vareshData = Airline::query()->where('name', 'Varesh')->first();
        $vareshCommissionRate = 0;

        if ($vareshSheetRate) {

            // The percentage the airline intended to add to the base rate
            $airlineIntendedPercentage = $vareshData->sale_rate ?: 30;

            // Raw additional constants
            $AWA = $vareshData->AWA ?: 10000000;

            // Calculate break point rate
            $breakPoint = breakPoint($vareshSheetRate, $weight, true);
            $chargeableWeight = $breakPoint['chargeableWeight'];
            $vareshRate = $breakPoint['rate'];
            $vareshCommissionRate = calculatePercent($vareshRate, $airlineIntendedPercentage);

            $sumRates = $vareshRate + $vareshCommissionRate;

            // Calculate rate by USDT (step 1,2)
            $rateByUsdt = $weight * $sumRates;

            // Add additional constants (step 3)
            $rateByUsdt += $AWA;

            // Calculate tax
            $taxAmount = calculatePercent($rateByUsdt, 10);

            // Apply tax
            $totalAmount = $rateByUsdt + $taxAmount; // Includes 10% tax directly

            // Prepare information for front
            $vareshInformation = [
                'rate' => number_format($vareshRate),
                'commissionRate' => number_format($vareshCommissionRate),
                'sumRates' => number_format($sumRates),
                'tax' => number_format($taxAmount),
                'AWA' => number_format($AWA)
            ];
            session()->put('vareshInformation' . Auth::id(), $vareshInformation);


            $sumOfAgentVariables = $AWA;
            $agentVariables = [
                'AWA' => ' ' . $AWA . ' USD',
            ];
            $carrierVariables = [];
            $sumOfCarrierVariables = 0;

            $vareshWaybill = [
                'sumOfAgentVariables' => $sumOfAgentVariables,
                'sumOfCarrierVariables' => $sumOfCarrierVariables,
                'agent_variables' => $agentVariables,
                'carrier_variables' => $carrierVariables,
                'rate' => $vareshRate,
                'chargeableWeight' => $chargeableWeight
            ];

            // change to IRR
            $vareshEstimate = changeAmountToIRR($totalAmount, 'Varesh');

            return compact('vareshWaybill', 'vareshEstimate');

        }
        return false;
    }
}

if (!function_exists('estimateAeroflot')) {
    function estimateAeroflot($destination, $weight)
    {

        $aeroflotSheetRate = AeroflotRate::query()->where('destination', $destination)->first();
        $aeroflotData = Airline::query()->where('name', 'Aeroflot')->first();
        $aeroflotCommissionRate = 0;

        if ($aeroflotSheetRate) {

            // Raw additional constants
            $AWC = $aeroflotData->AWC ?: 13;
            $BFC = $aeroflotData->BFC ?: 1.35;
            $MAC = $aeroflotData->MAC ?: 23.65;

            // Calculate break point rate
            $breakPoint = breakPoint($aeroflotSheetRate, $weight);
            $chargeableWeight = $breakPoint['chargeableWeight'];
            $aeroflotRate = $breakPoint['rate'];

            // emirates sales comission
            $aeroflotSalesCommission = SaleComission::query()->where('airline_id', 4)->first();

            // check sale comission rate airline
            if ($aeroflotSalesCommission)
                $aeroflotCommissionRate = saleComission($weight, $aeroflotSalesCommission);


            $sumRates = $aeroflotRate + ($aeroflotCommissionRate ?: 0);

            // Calculate rate by USDT (step 1,2)
            $rateByUsdt = $weight * $sumRates;

            // Add additional constants (step 3)
            $rateByUsdt += $AWC + $BFC + $MAC;

            // Calculate tax
            $taxAmount = calculatePercent($rateByUsdt, 10);

            // Apply tax
            $totalAmount = $rateByUsdt + $taxAmount; // Includes 10% tax directly

            // Prepare information for front
            $aeroflotInformation = [
                'rate' => $aeroflotRate,
                'commissionRate' => $aeroflotCommissionRate,
                'sumRates' => $sumRates,
                'tax' => $taxAmount,
                'AWC' => $AWC,
                'BFC' => $BFC,
                'MAC' => $MAC
            ];
            session()->put('aeroflotInformation' . Auth::id(), $aeroflotInformation);


            $sumOfAgentVariables = 0;
            $agentVariables = [];
            $carrierVariables = [
                'AWC' => ' ' . $AWC . ' USD',
                'BFC' => ' ' . $BFC . ' USD',
                'MAC' => ' ' . $MAC . ' USD'
            ];
            $sumOfCarrierVariables = $AWC + $BFC + $MAC;

            $aeroflotWaybill = [
                'sumOfAgentVariables' => $sumOfAgentVariables,
                'sumOfCarrierVariables' => $sumOfCarrierVariables,
                'agent_variables' => $agentVariables,
                'carrier_variables' => $carrierVariables,
                'rate' => $aeroflotRate,
                'chargeableWeight' => $chargeableWeight
            ];

            // change to IRR
            $aeroflotEstimate = changeAmountToIRR($totalAmount, 'Aeroflot');

            return compact('aeroflotWaybill', 'aeroflotEstimate');

        }
        return false;
    }
}

// calculate sales comission for airlines
if (!function_exists('saleComission')) {
    function saleComission($weight, $sale_comission)
    {

        switch (true) {

            case ($weight < 45):
                $break_point = $sale_comission['m'] / $sale_comission['n'];
                $sale_comission_rate = ($weight > $break_point) ? $sale_comission["n"] : $sale_comission["m"];
                break;

            case ($weight >= 45 && $weight < 100):
                $comission_break_point = (100 * $sale_comission['c_100']) / $sale_comission['c_45'];
                $sale_comission_rate = ($weight > $comission_break_point) ? $sale_comission['c_100'] : $sale_comission['c_45'];
                break;

            case ($weight >= 100 && $weight < 300):
                if (isset($sale_comission['c_250'])) {
                    $comission_break_point = (250 * $sale_comission['c_250']) / $sale_comission['c_100'];
                    $sale_comission_rate = ($weight > $comission_break_point) ? $sale_comission['c_250'] : $sale_comission['c_100'];
                }

                if (isset($sale_comission['c_300'])) {
                    $comission_break_point = (300 * $sale_comission['c_300']) / $sale_comission['c_100'];
                    $sale_comission_rate = ($weight > $comission_break_point) ? $sale_comission['c_300'] : $sale_comission['c_100'];
                }
                break;

            case ($weight >= 300 && $weight < 500):
                $comission_break_point = (500 * $sale_comission['c_500']) / $sale_comission['c_300'];
                $sale_comission_rate = ($weight > $comission_break_point) ? $sale_comission['c_500'] : $sale_comission['c_300'];
                break;

            case ($weight >= 500):
                $comission_break_point = (1000 * $sale_comission['c_1000']) / $sale_comission['c_500'];
                $sale_comission_rate = ($weight > $comission_break_point) ? $sale_comission['c_1000'] : $sale_comission['c_500'];
                break;

            default:
                $sale_comission_rate = 0;
        }

        return $sale_comission_rate;
    }
}

// calculate breakpoint for rate
if (!function_exists('breakPoint')) {
    function breakPoint($airline, $weight, $isVaresh = false, $isQeshm = false)
    {
        $chargeableWeight = 0;/* waybill section */
        $rate = 0;
        $break_point = 0;
        $validWeights = [45, 100, 250, 300, 500, 1000];

        if ($isVaresh) {
            $chargeableWeight = $weight;/* waybill section */
            $break_point = $airline['minimum'] / $airline['normal'];
            $rate = ($weight > $break_point) ? $airline["normal"] : $airline["minimum"];
            return compact('rate', 'chargeableWeight');
        }

        if ($isQeshm) {

            $validWeightsAboutQeshm = [45, 100, 250, 300, 500];

            if (in_array($weight, $validWeightsAboutQeshm) && isset($airline["$weight"])) {

                $chargeableWeight = $airline["$weight"];/* waybill section */
                $rate = $airline["$weight"];

            } else {

                switch (true) {

                    case ($weight < 45):
                        if (isset($airline['minimum'], $airline['normal']) && $airline['minimum'] != 0 && $airline['normal'] != 0) {

                            $break_point = $airline['minimum'] / $airline['normal'];
                            $chargeableWeight = $weight;/* waybill section */
                            $rate = ($weight > $break_point) ? $airline["normal"] : $airline["minimum"];

                        }
                        break;

                    case ($weight < 100):
                        if (isset($airline['45'], $airline['100']) && $airline['45'] != 0 && $airline['100'] != 0) {

                            $break_point = (100 * $airline['100']) / $airline['45'];
                            $rate = ($weight > $break_point) ? $airline["100"] : $airline["45"];
                            $chargeableWeight = max($weight, $break_point);/* waybill section */

                        }
                        break;

                    case ($weight < 250):
                        if (isset($airline['250'], $airline['100']) && $airline['250'] != 0 && $airline['100'] != 0) {

                            $break_point = (250 * $airline['250']) / $airline['100'];
                            $rate = ($weight > $break_point) ? $airline["250"] : $airline["100"];
                            $chargeableWeight = max($weight, $break_point);/* waybill section */

                        }
                        break;


                    case ($weight < 500):
                    case ($weight >= 500):
                        if (isset($airline['250'], $airline['500']) && $airline['250'] != 0 && $airline['500'] != 0) {

                            $break_point = (500 * $airline['500']) / $airline['250'];
                            $rate = ($weight > $break_point) ? $airline["500"] : $airline["250"];
                            $chargeableWeight = max($weight, $break_point);/* waybill section */
                            break;
                        }

                        if (isset($airline['250'], $airline['100']) && $airline['250'] != 0 && $airline['100'] != 0) {

                            $break_point = (250 * $airline['250']) / $airline['100'];
                            $rate = ($weight > $break_point) ? $airline["250"] : $airline["100"];
                            $chargeableWeight = max($weight, $break_point);/* waybill section */

                        }
                        break;

                    default:
                        $rate = $airline["normal"] ?? 0;
                }

            }

            return compact('rate', 'chargeableWeight');

        }

        if (in_array($weight, $validWeights) && isset($airline["$weight"])) {

            $chargeableWeight = $airline["$weight"];/* waybill section */
            $rate = $airline["$weight"];

        } else {

            switch (true) {

                case ($weight < 45):
                    if (isset($airline['minimum'], $airline['normal']) && $airline['minimum'] != 0 && $airline['normal'] != 0) {
                        $break_point = $airline['minimum'] / $airline['normal'];
                        $rate = ($weight > $break_point) ? $airline["normal"] : $airline["minimum"];
                        $chargeableWeight = max($weight, $break_point);/* waybill section */
                    }
                    break;

                case ($weight < 100):
                    if (isset($airline['45'], $airline['100']) && $airline['45'] != 0 && $airline['100'] != 0) {
                        $break_point = (100 * $airline['100']) / $airline['45'];
                        $rate = ($weight > $break_point) ? $airline["100"] : $airline["45"];
                        $chargeableWeight = max($weight, $break_point);/* waybill section */
                    }
                    break;

                case ($weight < 250):

                    if (isset($airline['250'], $airline['100']) && $airline['250'] != 0 && $airline['100'] != 0) {
                        $break_point = (250 * $airline['250']) / $airline['100'];
                        $rate = ($weight > $break_point) ? $airline["250"] : $airline["100"];
                        $chargeableWeight = max($weight, $break_point);/* waybill section */
                        break;
                    }

                    if (isset($airline['300'], $airline['100']) && $airline['300'] != 0 && $airline['100'] != 0) {
                        $break_point = (300 * $airline['300']) / $airline['100'];
                        $rate = ($weight > $break_point) ? $airline["300"] : $airline["100"];
                        $chargeableWeight = max($weight, $break_point);/* waybill section */
                    }

                    break;

                case ($weight < 300):
                    if (isset($airline['300'], $airline['100']) && $airline['300'] != 0 && $airline['100'] != 0) {
                        $break_point = (300 * $airline['300']) / $airline['100'];
                        $rate = ($weight > $break_point) ? $airline["300"] : $airline["100"];
                        $chargeableWeight = max($weight, $break_point);/* waybill section */
                    }
                    break;

                case ($weight < 500):

                    if (isset($airline['250'], $airline['500']) && $airline['250'] != 0 && $airline['500'] != 0) {

                        $break_point = (500 * $airline['500']) / $airline['250'];
                        $rate = ($weight > $break_point) ? $airline["500"] : $airline["250"];
                        $chargeableWeight = max($weight, $break_point);/* waybill section */
                        break;
                    }

                    if (isset($airline['300'], $airline['500']) && $airline['300'] != 0 && $airline['500'] != 0) {

                        $break_point = (500 * $airline['500']) / $airline['300'];
                        $rate = ($weight > $break_point) ? $airline["500"] : $airline["300"];
                        $chargeableWeight = max($weight, $break_point);/* waybill section */
                    }
                    break;

                case ($weight >= 500):

                    if (isset($airline['1000'], $airline['500']) && $airline['1000'] != 0 && $airline['500'] != 0) {
                        $break_point = (1000 * $airline['1000']) / $airline['500'];
                        $rate = ($weight > $break_point) ? $airline["1000"] : $airline["500"];
                        $chargeableWeight = max($weight, $break_point);/* waybill section */
                    }
                    break;

                default:
                    $rate = $airline["normal"] ?? 0;
            }

        }

        return compact('rate', 'chargeableWeight');

    }
}

// change dollar to IRR value
if (!function_exists('changeAmountToIRR')) {
    function changeAmountToIRR($amount, $airline_name)
    {
        $ROE = Airline::where('name', $airline_name)->pluck('ROE')->first();
        return $amount * $ROE;
    }
}

if (!function_exists('getROE')) {
    function getROE($airlineName)
    {
        return Airline::query()->where('name', $airlineName)->pluck('ROE')->first();
    }
}

if (!function_exists('generateNumber')) {
    function generateNumber()
    {
        $timestamp = now()->format('YmdHis');
        $random = strtoupper(Str::random(4));

        return $timestamp . $random;
    }
}

function shortenTitles($field): string
{

    $field = str_replace('هزینه بسته بندی ', '', $field);

    $field = substr($field, 0, 25) . '...';

    return mb_convert_encoding($field, 'UTF-8', 'auto');

}


if (!function_exists('persianNumbers')) {
    function persianNumbers($number)
    {
        $english_numbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $persian_numbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];

        return str_replace($english_numbers, $persian_numbers, $number);
    }
}

function removeNumberFormat($value): array|string
{
    return str_replace(',', '', $value);
}


function renderUsdCurrency(): string
{
    return '<small> $ </small>';
}

function renderIrrCurrency(): string
{
    return '<small> ریال </small>';
}


if (!function_exists('number_to_words')) {
    function number_to_words($number): string
    {
        if ($number == 0) {
            return "صفر";
        }

        $ones = ["", "یک", "دو", "سه", "چهار", "پنج", "شش", "هفت", "هشت", "نه"];
        $tens = ["", "ده", "بیست", "سی", "چهل", "پنجاه", "شصت", "هفتاد", "هشتاد", "نود"];
        $teens = ["ده", "یازده", "دوازده", "سیزده", "چهارده", "پانزده", "شانزده", "هفده", "هجده", "نوزده"];
        $hundreds = ["", "صد", "دویست", "سیصد", "چهارصد", "پانصد", "ششصد", "هفتصد", "هشتصد", "نهصد"];
        $thousands = ["", "هزار", "میلیون", "میلیارد", "تریلیون"];

        $number = abs($number);
        $parts = [];
        $groupIndex = 0;

        while ($number > 0) {
            $chunk = $number % 1000;
            if ($chunk > 0) {
                $parts[] = convert_three_digits($chunk, $ones, $tens, $teens, $hundreds) . " " . $thousands[$groupIndex];
            }
            $number = floor($number / 1000);
            $groupIndex++;
        }

        return implode(" و ", array_reverse($parts));
    }

    function convert_three_digits($number, $ones, $tens, $teens, $hundreds): string
    {
        $words = [];

        if ($number >= 100) {
            $words[] = $hundreds[floor($number / 100)];
            $number %= 100;
        }

        if ($number >= 10 && $number < 20) {
            $words[] = $teens[$number - 10];
        } else {
            if ($number >= 20) {
                $words[] = $tens[floor($number / 10)];
                $number %= 10;
            }

            if ($number > 0) {
                $words[] = $ones[$number];
            }
        }

        return implode(" و ", array_filter($words));
    }
    }

if (!function_exists('formatIranianAirlinePrice')) {
    function formatIranianAirlinePrice($airlineName, $price): string
    {
        return match ($airlineName) {
            'Mahan Air', 'Varesh', 'Iran Air' => number_format($price),
            default => $price,
        };
    }
}

if (!function_exists('detectAirlineCurrency')) {
    function detectAirlineCurrency($airlineName): string
    {
        return match ($airlineName) {
            'Mahan Air', 'Varesh', 'Iran Air' => 'IRR',
            default => 'USD',
        };
    }
}


if (!function_exists('formatCurrency')) {
    function formatCurrency($amount): string
    {
        $amount = (string) $amount;

        if (str_contains($amount, 'IRR')) {
            return preg_replace_callback('/\d+/', function ($matches) {
                return number_format($matches[0]);
            }, $amount);
        }

        return $amount;
    }
}


if (!function_exists('formatCurrencyWithROE')) {
    function formatCurrencyWithROE($amount, $roe = 500000): string
    {
        $amount = (string) $amount;

        if (str_ends_with($amount, 'IRR')) {
            $number = (int) str_replace(' IRR', '', $amount);
            return number_format($number) . ' IRR';
        }

        if (str_ends_with($amount, 'USD')) {
            $number = (float) str_replace(' USD', '', $amount);
            $converted = $number * $roe;
            return number_format($converted) . ' IRR';
        }

        return $amount;
    }
}
