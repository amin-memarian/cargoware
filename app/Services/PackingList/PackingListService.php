<?php

namespace App\Services\PackingList;

use App\Models\Nature;
use App\Models\PackingList;
use App\Models\Waybill;

class PackingListService
{
    public function __construct()
    {
    }

    public function storePackingList($loadId, $packages)
    {
        return PackingList::query()->create([
            'load_id' => $loadId,
            'packages' => $packages,
        ]);
    }

    public function prepareGroupedPackages($request)
    {
        try {

            $data = $this->prepareData($request);

            $groupedPackages = [
                "hs_codes" => []
            ];
            $totalNetWeight = 0;
            $totalGrossWeight = 0;

            foreach ($data["hs_code"] as $index => $hsCode) {

                if (!isset($groupedPackages["hs_codes"][$hsCode])) {
                    $groupedPackages["hs_codes"][$hsCode] = [
                        "boxes" => 0,
                        "items" => []
                    ];
                }

                $nature_description = Nature::query()->where('code', $hsCode)->pluck('en_name')->first();
                $groupedPackages["hs_codes"][$hsCode]["description"] = $nature_description;

                $groupedPackages["hs_codes"][$hsCode]["items"][] = [
                    "fa_name" => $data["fa_name"][$index],
                    "en_name" => $data["en_name"][$index],
                    "gross_weight" => $data["gross_weight"][$index],
                    "net_weight" => $data["net_weight"][$index],
                    "hs_code_remark" => $data["hs_code_remark"][$index],
                ];

                $groupedPackages["hs_codes"][$hsCode]["boxes"] += 1;
                $totalNetWeight += $data["net_weight"][$index] ?: 0;
                $totalGrossWeight += $data["gross_weight"][$index] ?: 0;
            }

            $groupedPackages["sum_of_net_weight"] = $totalNetWeight;
            $groupedPackages["sum_of_gross_weight"] = $totalGrossWeight;
            $groupedPackages["pcs"] = count($groupedPackages["hs_codes"]);
            $groupedPackages['remark'] = $request?->remark ?: null;

            return $groupedPackages;

        } catch (\Exception $e) {
            dd(extractError($e));
        }
    }

    public function updateWaybill($loadId, $pcs)
    {
        $waybill = Waybill::query()->where('load_id', $loadId)->first();
        $waybill->update([
            'package_count' => $pcs
        ]);
    }

    private function prepareData($request)
    {
        return [
            'fa_name' => $request->fa_name,
            'en_name' => $request->en_name,
            'gross_weight' => $request->gross_weight,
            'net_weight' => $request->net_weight,
            'hs_code' => $request->hs_code,
            'hs_code_remark' => $request->hs_code_remark
        ];
    }

}
