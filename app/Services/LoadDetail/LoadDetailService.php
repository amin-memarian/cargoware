<?php

namespace App\Services\LoadDetail;

use App\Events\Orders\LoadDetails\LoadDetailCreatedEvent;
use App\Models\Estimate;
use App\Models\LoadDetail;
use App\Models\PackingList;
use App\Models\ReservationLog;
use App\Repositories\LoadDetailRepository;
use App\Services\AirlineSales\AirlineSalesService;
use App\Services\Waybill\WaybillService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoadDetailService
{

    public function __construct(
        private readonly LoadDetailRepository $repository,
    )
    { }


    /**
     * Handles the store process and triggers the necessary events.
     *
     * This method performs the following actions:
     * - Stores the order.
     * - Triggers the LoadDetailCreatedEvent.
     * - Executes three listeners:
     *   1. StoreAirlineSaleFromLoadDetailListener
     *   2. StoreRequiredLoadDetailsListener
     *   3. UpdateEstimateStatusToApprovedListener
     *
     */
    public function handleStore($request): bool
    {

        try {

            $order = $this->repository->handleStore($request);

            $packingList = PackingList::query()->where('load_id', $order->estimate->loads->id)->first();

            $packingList?->update([
                'packages' => [[$order->package_count]]
            ]);
            

            ReservationLog::query()->create([
                'user_id' => $order->user_id,
                'agent_id' => $order->collection_agent_id,
                'load_detail_id' => $order->id,
                'vehicle_type_id' => $order->vehicle_type_id,
                'selected_from' => $order->start_collection_time,
                'selected_until' => $order->end_collection_time,
                'send_at' => $order->delivery_date,
                'received_by_agent_at' => $order->collection_date
            ]);

            $data = [
                'declaredValue' => $request->declared_value,
                'senderName' => $request->name,
                'senderAddress' => $request->address,
                'receiverName' => $request->receiver_name,
                'receiverAddress' => $request->receiver_address,
                'loadDetailId' => $order->id,
                'packageCount' => $request->package_count
            ];


            event( new LoadDetailCreatedEvent(
               $data
            ));

            $order->collectionAgentRequest()->create([]);

            return false;


        } catch (\Exception $e) {

            report( extractError($e) );

            return true;

        }

    }


}
