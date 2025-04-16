<?php

namespace App\Repositories;

use App\Models\LoadDetail;
use Illuminate\Support\Facades\Auth;

class LoadDetailRepository
{
    private \Illuminate\Database\Eloquent\Builder $model;
    private int|null $userId;

    public function __construct()
    {
        $this->model = LoadDetail::query();
    }

    private function prepareLoadDetailData ($request): array
    {
        $convertToBoolean = fn($value) => $value === 'yes' ? '1' : '0';

        return [
            LoadDetail::CASE_NUMBER => generateCaseNumber(),
            LoadDetail::ADMIN_ID => Auth::id(),
            LoadDetail::USER_ID => $request->user_id,
            LoadDetail::ESTIMATE_ID => $request->estimate_id,
            LoadDetail::LOAD_TYPE => $request->load_type == 'on' ? 'normal' : 'special',
            LoadDetail::SPECIAL_LOAD_DESCRIPTION => $request->special_load_description,
            LoadDetail::POSTAL_CODE => $request->postal_code ?: null,
            LoadDetail::ADDRESS => $request->address,
            LoadDetail::PHONE_NUMBER => $request->phone_number,
            LoadDetail::IS_BULK => $request->bulky_load,
            LoadDetail::IS_URGENT => $request->is_urgent,
            LoadDetail::COLLECTION_DATE => timestamp_to_date_time($request->new_collection_date),
            LoadDetail::START_COLLECTION_TIME => $request->start_collection_time,
            LoadDetail::END_COLLECTION_TIME => $request->end_collection_time,
            LoadDetail::DELIVERY_DATE => $request?->fast_shipping == 'yes' ? null : timestamp_to_date_time($request->delivery_date),
            LoadDetail::FLOORS_COUNT => $request?->floors_count ?: null,
            LoadDetail::ELEVATOR => $request->elevator == 'on' ? '1' : '0',
            LoadDetail::PACKING => $request->packing,
            LoadDetail::FAST_SHIPPING => $convertToBoolean($request?->fast_shipping),
         /*   LoadDetail::USER_REGION => $request?->user_region ?: null,*/
            'package_count' => $request->package_count ?: 1,
            'collection_agent_type_id' => $request?->collection_agent_type_id ?: null,
            'name' => $request->name,
            'national_id' => $request->national_id,
            'receiver_name' => $request->receiver_name,
            'receiver_address' => $request->receiver_address,
            'receiver_phone' => $request->receiver_phone,
            'receiver_postal_code' => $request->receiver_postal_code ?: null,
            'receiver_email' => $request->receiver_email ?: null,
            'declared_value' => $request->declared_value ?: null,
            'collection_address' => $request->collection_address,
            'collection_postal_code' => $request->collection_postal_code,
            'handling_information' => $request->handling_information,
            'main_box' => $request->main_box,
            'declared_value_for_destination' => $request->declared_value_for_destination,
            'nature_id' => $request->nature_id,
            'vehicle_type_id' => $request->vehicle_type_id,
            'collection_agent_id' => $request->collection_agent_id,
        ];

    }

    public function handleStore($request)
    {
        try {

            $newLoadDetail = $this->prepareLoadDetailData($request);

            return $this->model->create($newLoadDetail);

        } catch (\exception $e) {

            // Send the exception details to Laravel Telescope for monitoring and debugging purposes
            report( extractError($e) );

        }
    }
}
