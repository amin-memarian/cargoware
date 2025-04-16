<?php

namespace App\Services\Waybill;

use App\Models\Airline;
use App\Models\LoadDetail;
use App\Models\Waybill;
use Illuminate\Support\Facades\Log;

class WaybillService
{

    public function storeRequiredLoadDetails($declaredValue, $senderName, $senderAddress, $receiverName, $receiverAddress, $loadDetailId, $packageCount): void
    {

        $loadDetail = LoadDetail::query()->find($loadDetailId);
        $estimateId = $loadDetail->estimate_id;

        $waybill = Waybill::query()
            ->where('estimate_id', $estimateId)
            ->first();

        $waybill->update([
            'declared_value' => $declaredValue,
            'sender_name' => $senderName,
            'sender_address' => $senderAddress,
            'receiver_name' => $receiverName,
            'receiver_address' => $receiverAddress,
            'load_detail_id' => $loadDetailId,
            'package_count' => $packageCount
        ]);

    }

    public function storeWaybills(
        $waybillsInformation,
        $relatedIdsForWaybill,
        $grossWeight,
        $destinationCode
    ): void
    {

        try {


            foreach ($waybillsInformation as $airlineName => $wayBillInformation) {

                if ($wayBillInformation) {

                    /* List of keys: user_id, load_id, airline_id, estimate_id */
                    $relatedIds = $relatedIdsForWaybill[$airlineName];

                    $waybillData = $this->prepareData($wayBillInformation, $relatedIds, $grossWeight, $destinationCode);
                    Waybill::query()->create($waybillData);

                }
            }

        } catch (\Exception $e) {

            // Send the exception details to Laravel Telescope for monitoring and debugging purposes
            report( extractError($e) );

        }

    }

    public function updateUserID($estimateID, $userID)
    {
        $waybill = Waybill::query()
            ->where('estimate_id', $estimateID)
            ->first();


        $waybill->update([
            'user_id' => $userID,
            'publish_status' => '1'
        ]);

    }

    public function deleteExtraWaybills($estimateIDs)
    {
        Waybill::query()->where('publish_status', '0')
            ->whereIn('estimate_id', $estimateIDs)
            ->delete();
    }

    public function prepareData(
        $wayBillInformation,
        $relatedIds,/* List of keys: user_id, load_id, airline_id, estimate_id */
        $grossWeight,
        $destinationCode
    ) {

        try {

            $airline = Airline::query()
                ->find($relatedIds['airline_id']);

            // Variable: $totalAmount
            extract($this->calculateTotalAmount(
                    chargeableWeight: $wayBillInformation['chargeableWeight'],
                    rate: $wayBillInformation['rate']
                ));

            // Variable: $tax
            extract($this->calculateTax(
                totalAmount: $totalAmount,
                sumOfAgentVariables: $wayBillInformation['sumOfAgentVariables'],
                sumOfCarrierVariables: $wayBillInformation['sumOfCarrierVariables']
            ));

            // Variable: $totalPrepaid
            extract( $this->calculateTotalPrepaid(
                totalAmount: $totalAmount,
                sumOfAgentVariables: $wayBillInformation['sumOfAgentVariables'],
                sumOfCarrierVariables: $wayBillInformation['sumOfCarrierVariables'],
                tax: $tax,
                airlineName: $airline->name
            ));


            return [
                'user_id' => $relatedIds['user_id'],
                'load_id' => $relatedIds['load_id'],
                'estimate_id' => $relatedIds['estimate_id'],
                'airline_id' => $airline->id,
                'airline_name' => $airline->name,
                'airline_logo' => $airline?->mediaFile?->path,
                'destination' => getCountryFromCode($destinationCode) ?: $destinationCode,
                'gross_weight' => $grossWeight,
                'chargeable_weight' => $wayBillInformation['chargeableWeight'],
                'total_amount' => $totalAmount,
                'total_prepaid' => $totalPrepaid,
                'tax' => $tax,
                'variables' => @$wayBillInformation['variables'],
                'agent_variables' => $wayBillInformation['agent_variables'],
                'carrier_variables' => $wayBillInformation['carrier_variables'],
                'sum_of_agent_variables' => $wayBillInformation['sumOfAgentVariables'],
                'sum_of_carrier_variables' => $wayBillInformation['sumOfCarrierVariables'],
                'rate' => $wayBillInformation['rate'],
                'roe' => $airline->ROE,
            ];

        } catch (\Exception $e) {

            // Send the exception details to Laravel Telescope for monitoring and debugging purposes
            report( extractError($e) );

        }

    }

    private function calculateTotalAmount($chargeableWeight, $rate)
    {
        $totalAmount = $chargeableWeight * $rate;

        return compact('totalAmount');
    }

    private function calculateTax($totalAmount, $sumOfAgentVariables, $sumOfCarrierVariables)
    {
        $totalAmount += $sumOfAgentVariables + $sumOfCarrierVariables;
        $tax = calculatePercent($totalAmount, 10);

        return compact('tax');
    }

    private function calculateTotalPrepaid($totalAmount, $sumOfAgentVariables, $sumOfCarrierVariables, $tax, $airlineName)
    {
        $totalPrepaid = $totalAmount + $sumOfAgentVariables + $sumOfCarrierVariables + $tax;

        // Define airlines currency and assign
        $currency = $this->detectAirlinesCurrency($airlineName);
        $totalPrepaid .= ' ' . $currency;

        return compact('totalPrepaid');
    }

    private function detectAirlinesCurrency($airlineName): string
    {
        $airlines = [
            'Iran Air' => 'IRR',
            'Qeshm Air' => 'IRR',
            'Mahan Air' => 'IRR',
            'Varesh' => 'IRR',
            'Emirates' => 'USD',
            'Qatar' => 'USD',
            'Fly Dubai' => 'USD',
            'Air Arabia' => 'USD',
            'Turkish' => 'USDT',
            'Aeroflot' => 'USD'
        ];

        if (array_key_exists($airlineName, $airlines)) {
            return $airlines[$airlineName];
        }

        return 'USD';
    }


}
