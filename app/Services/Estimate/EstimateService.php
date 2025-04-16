<?php

namespace App\Services\Estimate;

use App\Factories\EstimateCostServiceFactory;
use App\Models\Airline;
use App\Models\Estimate;
use App\Models\Load;
use App\Models\LoadDetail;
use App\Models\QatarRate;
use App\Models\SaleComission;
use App\Models\User;
use App\Models\Waybill;
use App\Services\Waybill\WaybillService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstimateService
{


    protected WaybillService $waybillService;

    public function __construct(
        WaybillService $waybillService
    )
    {
        $this->waybillService = $waybillService;
    }

    public function prepareRequestData(Request $request): array
    {
        $weights = [];
        $numbers = [];
        $loads = [];
        $estimateIds = [];
        $count = $request->count ?: 0;
        $type = $request->type ?: 0;
        $volumetric_weight = null;
        $user_id = $request->user_id ?: null;
        $origin = $request->store[0] ?: null;
        $destination = $request->destination[0] ?: null;
        $size_width = $request->size_width ?: 0;
        $size_height = $request->size_height ?: 0;
        $size_length = $request->size_length ?: 0;
        $weight = $request->weight ?: 0;
        $number = $request->user_id . time();
        $loadType = $request->load_type;

        return compact(
            'weights',
            'numbers',
            'loads',
            'estimateIds',
            'count',
            'type',
            'volumetric_weight',
            'user_id',
            'origin',
            'destination',
            'size_width',
            'size_height',
            'size_length',
            'weight',
            'number',
            'loadType'
        );
    }

    public function handleWeights(array $size_widths, array $size_heights, array $size_lengths, float $weight, $count): array
    {
        $volumetric_weight = 0;
        $dimensionsDetail = [];
        $packages = [];

        foreach ($size_widths as $index => $size_width) {

            for ($i = 0; $i < $count[$index]; $i++) {

                $size_height = $size_heights[$index] ?? 0;
                $size_length = $size_lengths[$index] ?? 0;

                if ($size_width > 0 && $size_height > 0 && $size_length > 0) {

                    $volumetric_weight += round(($size_width * $size_height * $size_length) / 6000, 2);
                    $dimensionsDetail[] = [
                        'count' => $count[$index],
                        'length' => $size_length,
                        'width' => $size_width,
                        'height' => $size_height,
                    ];

                }

            }

        }

        $weight = max($volumetric_weight, $weight);

        if ($count != 0)
            $packages[] = $count;

        return compact('weight', 'volumetric_weight', 'dimensionsDetail', 'packages');
    }

    public function allEstimatesAreFalse(array $estimates): bool
    {
        return collect($estimates)->every(fn($estimate) => $estimate === false);
    }

    public function getAllSessions()
    {
        $userId = Auth::id();

        $weights = session('weights' . $userId);
        $weight = session('weight' . $userId);
        $numbers = session('numbers' . $userId);
        $loads = session('loads' . $userId);
        $users = session('users' . $userId);
        $partners = session('partners' . $userId);
        $estimateIds = session('estimateIds' . $userId);
        $origin = session('origin' . $userId);
        $destination = session('destination' . $userId);
        $qatarInformation = session('qatarInformation' . $userId);
        $flyDubaiInformation = session('flyDubaiInformation' . $userId);
        $airArabiaInformation = session('airArabiaInformation' . $userId);
        $iranAirInformation = session('iranAirInformation' . $userId);
        $mahanAirInformation = session('mahanAirInformation' . $userId);
        $turkishInformation = session('turkishInformation' . $userId);
        $vareshInformation = session('vareshInformation' . $userId);
        $aeroflotInformation = session('aeroflotInformation' . $userId);
        $user_id = session('user_id' . $userId);

        if ($user_id)
            $user = User::query()->find($user_id);
        else
            $user = null;

        return compact(
            'weights', 'weight', 'numbers', 'loads', 'users', 'partners',
            'estimateIds', 'origin', 'destination', 'qatarInformation',
            'flyDubaiInformation', 'airArabiaInformation', 'iranAirInformation',
            'mahanAirInformation', 'turkishInformation', 'vareshInformation',
            'aeroflotInformation', 'user_id', 'user'
        );

    }

    private function isValidSessionData($weights, $numbers, $loads, $users, $estimateIds)
    {
        return $weights && $numbers && $loads && $users && $estimateIds;
    }

    public function handleValidSessionData($weights, $numbers, $loads, $users, $estimateIds, $qatarInformation, $flyDubaiInformation, $airArabiaInformation, $iranAirInformation, $mahanAirInformation, $turkishInformation, $vareshInformation, $aeroflotInformation, $user_id, $user, $origin, $destination, $partners, $weight)
    {

        if ($this->isValidSessionData($weights, $numbers, $loads, $users, $estimateIds)) {

            $estimates = Estimate::query()->whereIn('id', $estimateIds)->with('airlines')->get();

            return view('admin.estimate.create', compact([
                'weights', 'numbers', 'loads', 'users', 'estimateIds',
                'origin', 'destination', 'estimates', 'qatarInformation',
                'flyDubaiInformation', 'airArabiaInformation', 'iranAirInformation',
                'mahanAirInformation', 'turkishInformation', 'vareshInformation',
                'aeroflotInformation', 'user_id', 'user', 'weight', 'partners'
            ]));

        } else {

            return redirect()->back();

        }

    }

    public function storeLoad($request, $key, $volumetric_weight, $count, $type, $number, $loadType)
    {
        //TODO: must remove extra fields: size_width size_height size_length count
        return Load::query()->create([
            'number' => $number,
            'user_id' => $request->user_id,
            'store' => $request->store[$key],
            'address' => $request->destination[$key],
            'weight' => $request->weight,
            'size_width' => 0,
            'size_height' => 0,
            'size_length' => 0,
            'volume_weight' => @$volumetric_weight ?: 0,
            'pic' => null,
            'count' => 0,
            'type' => $type,
            'load_type' => $loadType,
        ]);
    }

    public function storeEstimates($request, $load, $airlines)
    {
        $estimateIds = [];
        foreach ($airlines as $airline_id => $estimate) {
            if ($estimate) {

                $airline = Airline::query()
                    ->find( $airline_id);

                $save_estimate = Estimate::query()->create([
                    'user_id' => $request->user_id,
                    'load_id' => $load->id,
                    'airline_id' => $airline_id,
                    'ROE' => $airline->ROE,
                    'estimate' => $estimate,
                ]);
                $estimateIds[] = $save_estimate->id;

                $relatedIdsForWaybill[$airline->name] = [
                        'user_id' => $request->user_id,
                        'load_id' => $load->id,
                        'airline_id' => $airline_id,
                        'estimate_id' => $save_estimate->id
                    ];

            }
        }

        return compact('relatedIdsForWaybill', 'estimateIds');

    }

    public function prepareAirportsEstimateAndWaybills($destination, $weight)
    {
        $airports = ['emirates','qatar', 'flyDubai', 'airArabia', 'mahanAir', 'qeshmAir', 'iranAir', 'turkish', 'varesh', 'aeroflot'];

        $estimates = [];
        $waybills = [];

        foreach ($airports as $airport) {
            $estimateFunction = "estimate" . ucfirst($airport);
            $estimate = $estimateFunction($destination, $weight);

            if ($estimate) {

                $estimates[$airport . 'Estimate'] = $estimate[$airport . 'Estimate'];
                $waybills[$airport . 'Waybill'] = $estimate[$airport . 'Waybill'];

            } else {

                $estimates[$airport . 'Estimate'] = false;
                $waybills[$airport . 'Waybill'] = null;
            }

        }

        foreach ($estimates as $key => $value) {
            ${$key} = $value;
        }

        foreach ($waybills as $key => $value) {
            ${$key} = $value;
        }


        return compact(
            'qatarEstimate', 'qatarWaybill',
            'emiratesEstimate', 'emiratesWaybill',
            'flyDubaiEstimate', 'flyDubaiWaybill',
            'airArabiaEstimate', 'airArabiaWaybill',
            'mahanAirEstimate', 'mahanAirWaybill',
            'qeshmAirEstimate', 'qeshmAirWaybill',
            'iranAirEstimate', 'iranAirWaybill',
            'turkishEstimate', 'turkishWaybill',
            'vareshEstimate', 'vareshWaybill',
            'aeroflotEstimate', 'aeroflotWaybill'
        );

    }

    public function updateStatusToApproved($loadDetailId): void
    {
        $order = LoadDetail::query()->find($loadDetailId);
        if ($order->estimate) {
            $order->estimate->restore();
            $order->estimate->update([Estimate::STATUS => '1']);
        }
    }


}
