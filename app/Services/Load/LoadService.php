<?php

namespace App\Services\Load;

use App\Models\Load;
use App\Repositories\BaseRepository;

class LoadService extends BaseRepository
{
    public function __construct()
    {
        $this->model = new Load();
    }

    public function storeDimensionsDetail($loadId, $dimensionsDetail): void
    {
        $load = Load::query()->find($loadId);
        $load->update([
            'dimensions_detail' => $dimensionsDetail
        ]);
    }

}
