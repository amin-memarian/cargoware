<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Loads\LoadsStoreRequest;
use App\Models\Load;
use App\Models\User;
use App\Services\Estimate\EstimateService;
use App\Services\Load\LoadService;
use App\Services\PackingList\PackingListService;
use App\Services\Waybill\WaybillService;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LoadsController extends Controller
{


    public function __construct(
        private readonly EstimateService $service,
        private readonly WaybillService $waybillService,
        private readonly LoadService $loadService,
        private readonly PackingListService $packingListService,
    ){

    }

    public function destroy($number)
    {
        $delete = Load::query()->where('number', $number)->delete();

        return response()->json([
            'status' => 'ok',
            'delete' => $delete
        ]);
    }


    public function store(LoadsStoreRequest $request)
    {

        try {

            // Variables: weights, numbers, loads, estimateIds, count, type, volumetric_weight, weight, user_id, origin, destination
            extract($this->service->prepareRequestData($request));

            foreach ($request->store as $key => $item) {

                // Variables: weight, volumetric_weight, dimensionsDetail, packages
                extract($this->service->handleWeights($size_width, $size_height, $size_length, $weight, $count));

                // Variables : emiratesEstimate, flyDubaiEstimate, airArabiaEstimate, mahanAirEstimate, qeshmAirEstimate, iranAirEstimate, qatarEstimate, turkishEstimate, vareshEstimate, aeroflotEstimate
                extract($this->service->prepareAirportsEstimateAndWaybills($destination, $weight));


                // check all estimates
                $estimates = [
                    $emiratesEstimate,
                    $flyDubaiEstimate,
                    $airArabiaEstimate,
                    $mahanAirEstimate,
                    $qeshmAirEstimate,
                    $iranAirEstimate,
                    $qatarEstimate,
                    $turkishEstimate,
                    $vareshEstimate,
                    $aeroflotEstimate,
                ];
                if ($this->service->allEstimatesAreFalse($estimates)) {
                    return redirect()->back()->with(['failed' => 'برای این مقصد فرودگاهی وجود ندارد، لطفا مقصدی دیگر انتخاب کنید']);
                }

                // store load section
                $load = $this->service->storeLoad($request, $key, $volumetric_weight, $count, $type, $number, $loadType);

                if ($dimensionsDetail)
                    $this->loadService->storeDimensionsDetail($load->id, $dimensionsDetail);

                if ($packages)
                    $this->packingListService->StorePackingList($load->id, $packages);

                // store estimates section
                $airlines = [
                    1 => $iranAirEstimate,
                    2 => $qeshmAirEstimate,
                    3 => $mahanAirEstimate,
                    4 => $emiratesEstimate,
                    5 => $qatarEstimate,
                    6 => $flyDubaiEstimate,
                    7 => $airArabiaEstimate,
                    8 => $vareshEstimate,
                    9 => $turkishEstimate,
                    10 => $aeroflotEstimate
                ];
                // Variable: $estimateIds, $relatedIdsForWaybill
                extract($this->service->storeEstimates($request, $load, $airlines));

                // waybills information
                $waybillsInformation = [
                    'Emirates' => $emiratesWaybill,
                    'Fly Dubai' => $flyDubaiWaybill,
                    'Air Arabia' => $airArabiaWaybill,
                    'Mahan Air' => $mahanAirWaybill,
                    'Qeshm Air' => $qeshmAirWaybill,
                    'Iran Air' => $iranAirWaybill,
                    'Qatar' => $qatarWaybill,
                    'Turkish' => $turkishWaybill,
                    'Varesh' => $vareshWaybill,
                    'Aeroflot' => $aeroflotWaybill,
                ];
                $this->waybillService->storeWaybills(
                    waybillsInformation: $waybillsInformation,
                    relatedIdsForWaybill: $relatedIdsForWaybill,
                    grossWeight: $request->weight,
                    destinationCode: $destination
                );


                $weights[] = $weight;
                $numbers[] = $number;
                $loads[] = $load->id;

            }

            $sessionData = [
                'weights' => $weights,
                'weight' => $weight,
                'numbers' => $numbers,
                'loads' => $loads,
                'users' => User::allUsers(),
                'partners' => User::getPartners(),
                'estimateIds' => $estimateIds,
                'origin' => $origin,
                'destination' => $destination,
                'user_id' => $user_id,
            ];

            foreach ($sessionData as $key => $value) {
                session()->put($key . Auth::id(), $value);
            }

            return redirect(route('loads.index'));

        } catch (\Exception $e) {

            // Send the exception details to Laravel Telescope for monitoring and debugging purposes
            report( extractError($e) );

            return redirect()->back()->with(['failed' => 'محاسبه تخمین سریع به درستی صورت نگرفت، لطفا مجددا تلاش نمایید']);

        }
    }

    public function index()
    {
        // Variables: $weights, $weight, $numbers, $loads, $users, $partners, $estimateIds, $origin, $destination, $qatarInformation, $flyDubaiInformation, $airArabiaInformation, $iranAirInformation, $mahanAirInformation, $turkishInformation, $vareshInformation, $aeroflotInformation, $user_id
        extract($this->service->getAllSessions());

        return $this->service->handleValidSessionData(
            $weights, $numbers, $loads, $users, $estimateIds, $qatarInformation,
            $flyDubaiInformation, $airArabiaInformation, $iranAirInformation, $mahanAirInformation,
            $turkishInformation, $vareshInformation, $aeroflotInformation, $user_id, $user, $origin, $destination,
            $partners, $weight);

    }

}
