<?php

namespace App\Repositories;

use App\Models\AirArabiaRate;
use App\Models\Airline;
use App\Models\EmiratesRate;
use App\Models\FlyDubaiRate;
use App\Models\IranAirRate;
use App\Models\MahanAirRate;
use App\Models\QatarRate;
use App\Models\QeshmAirRate;
use Hekmatinasser\Verta\Verta;

class AirlinesRepository
{

    public function __construct(
        private readonly Airline $model,
        private readonly MediaFileRepository $mediaFileRepository,
        private readonly SaleComissionRepository $commissions
    ) {
    }

    public function handleUpdateAirlineData($request, $airline): bool
    {

        try {

            $airlineData = array_merge($request->all(), [
                'related_id' => $request->media_file_id
            ]) ;

            $airline->fill($airlineData);
            $airline->save();
            $newAirline = $airline->fresh();

            $this->mediaFileRepository->updateRelatedID($request?->media_file_id, $newAirline->id);

            $this->commissions->handleStoreAndUpdate($request, $newAirline);

            return false;

        } catch (\exception $e) {

            // Send the exception details to Laravel Telescope for monitoring and debugging purposes
            report( extractError($e) );

            return true;
        }


    }

    public function handleStoreAirlineData($request): bool
    {

        try {

            $airlineData = $this->prepareAirlineData($request);

            $newAirline = $this->store($airlineData);

            if (isset($request['media_file_id']) && $request['media_file_id'] != null)
                $this->mediaFileRepository->updateRelatedID($request['media_file_id'], $newAirline->id);

            $this->commissions->handleStoreAndUpdate($request, $newAirline);

            return false;

        } catch (\exception $e) {

            // Send the exception details to Laravel Telescope for monitoring and debugging purposes
            report( extractError($e) );

            return true;
        }
    }

    private function prepareAirlineData($request): array
    {
        return [
            'name' => $request['name'],
            'ROE' => $request['roe'],
            'Sale_rate' => $request['sale_rate'],
            'logo' => 'test',
            'AWA' => $request['awa'],
            'AWB' => $request['awb'],
            'AWC' => $request['awc'],
            'SCC' => $request['scc'],
            'SCC_min' => $request['min_scc'],
            'TVC' => $request['tvc'],
            'HXC' => $request['hxc'],
            'ATA' => $request['ata'],
            'ATA_min' => $request['min_ata'],
            'ATA_max' => $request['max_ata'],
            'TDC' => $request['tdc'],
            'CGC' => $request['cgc'],
            'MCC' => $request['mcc'],
            'INC' => $request['inc'],
            'MMA' => $request['mma'],
            'MYC' => $request['myc'],
            'FEC' => $request['fec'],
            'XDC' => $request['xdc'],
            'BFC' => $request['bfc'],
            'MAC' => $request['mac'],
            'related_type' => Airline::class,
            'related_id' => $request['media_file_id'] ?: null,
        ];
    }



    private function store(array $data)
    {
        return $this->model->create($data);
    }

}
