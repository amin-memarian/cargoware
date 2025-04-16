<?php

namespace App\Repositories;

use App\Models\SaleComission;
use Hekmatinasser\Verta\Verta;

class SaleComissionRepository
{

    public function handleStoreAndUpdate($request, $newAirline): void
    {
        if ($request->M !== null && $request->N !== null) {

            $data = [
                'airline_id' => $newAirline->id,
                'm' => $request->M,
                'n' => $request->N,
                'c_45' => $request->{"45"},
                'c_100' => $request->{"100"},
                'c_300' => $request->{"300"},
                'c_500' => $request->{"500"},
                'c_1000' => $request->{"1000"},
                'created_at' => Verta::now(),
                'updated_at' => Verta::now(),
            ];

            $salesCommission = SaleComission::query()->where('airline_id', $newAirline->id)->first();

            if ($salesCommission)
                $salesCommission->update($data);
            else
                SaleComission::create($data);

        }
    }




}
