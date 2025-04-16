<?php

namespace App\Repositories;

use App\Models\SalesTeam;
use Illuminate\Support\Facades\Auth;

class SalesTeamRepository
{
    public function __construct(private readonly SalesTeam $model)
    {
    }

    // Handles the process of storing a new sales team by preparing the data and saving it to the database.
    public function handleStoreSalesTeam($request)
    {
        if ($this->isManagerInSalesStaff($request->manager_id, $request->sales_staff))
            return true;

        $newSalesTeamData = $this->prepareSalesTeamData($request);
        $this->store($newSalesTeamData);

        return false;
    }

    // Prepares the sales team data from the request, including encoding sales staff as JSON.
    private function prepareSalesTeamData($request): array
    {
        return [
            SalesTeam::ADMIN_ID => Auth::id(),
            SalesTeam::TEAM_NAME => $request->team_name,
            SalesTeam::MANAGER_ID => $request->manager_id,
            SalesTeam::SALES_STAFF => json_encode($request->sales_staff),
        ];
    }

    // Stores the prepared sales team data in the database using the model's create method.
    private function store(array $data)
    {
        return $this->model->create($data);
    }

    // Check if the manager ID exists in the list of sales staff
    private function isManagerInSalesStaff(int $managerId, array $salesStaff): bool
    {
        return in_array($managerId, $salesStaff);
    }


}
