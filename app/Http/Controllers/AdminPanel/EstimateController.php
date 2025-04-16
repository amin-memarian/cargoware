<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Estimate\StoreEstimateRequest;
use App\Models\Estimate;

use App\Models\Partner;
use App\Models\RejectionMessage;
use App\Models\User;
use App\Services\Waybill\WaybillService;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class EstimateController extends Controller
{

    public function __construct(private readonly WaybillService $waybillService)
    {

    }

    public function store(StoreEstimateRequest $request)
    {

        try {

            session()->forget([
                'weights' . Auth::id(),
                'weight' . Auth::id(),
                'numbers' . Auth::id(),
                'loads' . Auth::id(),
                'users' . Auth::id(),
                'estimateIds' . Auth::id(),
                'qatarInformation' . Auth::id(),
                'flyDubaiInformation' . Auth::id(),
                'airArabiaInformation' . Auth::id(),
                'emiratesInformation' . Auth::id(),
                'iranAirInformation' . Auth::id(),
                'mahanAirInformation' . Auth::id(),
                'turkishInformation' . Auth::id(),
                'vareshInformation' . Auth::id(),
                'aeroflotInformation' . Auth::id()
            ]);


        } catch (ValidationException $e) {

            $weights = session('weights' . Auth::id());
            $weight = session('weight' . Auth::id());
            $numbers = session('numbers' . Auth::id());
            $loads = session('loads' . Auth::id());
            $users = session('users' . Auth::id());
            $estimateIds = session('estimateIds' . Auth::id());
            $qatarInformation = session('qatarInformation' . Auth::id());
            $flyDubaiInformation = session('flyDubaiInformation' . Auth::id());
            $airArabiaInformation = session('airArabiaInformation' . Auth::id());
            $emiratesInformation = session('emiratesInformation' . Auth::id());
            $iranAirInformation = session('iranAirInformation' . Auth::id());
            $mahanAirInformation = session('mahanAirInformation' . Auth::id());
            $turkishInformation = session('turkishInformation' . Auth::id());
            $vareshInformation = session('vareshInformation' . Auth::id());
            $aeroflotInformation = session('aeroflotInformation' . Auth::id());

            return redirect(route('loads.index'), compact(
                [
                    'weights',
                    'weight',
                    'numbers',
                    'loads',
                    'users',
                    'estimateIds',
                    'qatarInformation',
                    'flyDubaiInformation',
                    'airArabiaInformation',
                    'emiratesInformation',
                    'iranAirInformation',
                    'mahanAirInformation',
                    'turkishInformation',
                    'vareshInformation',
                    'aeroflotInformation'
                ]
            ))->withErrors($e->validator->errors());

        }


        try {

            // Receives all estimates that have been created
            $estimate_ids = json_decode($request->estimate_ids);

            // Store user and partner
            $userId = $this->handleUserAndPartnersStore($request);

            // Detect extra estimates
            $estimateIdsToDelete = array_diff($estimate_ids, [$request->estimate_id_selected]);

            // Destroy non selected estimates
            $this->deleteExtraEstimates($estimateIdsToDelete);

            // Destroy non selected estimates
            $this->waybillService
                ->deleteExtraWaybills($estimateIdsToDelete);

            // Assign user id to estimate
            $this->updateEstimateAndLoadUserID($request->estimate_id_selected, $userId);

            // Assign user id to waybill
            $this->waybillService
                ->updateUserID($request->estimate_id_selected, $userId);

            session()->forget(['weights', 'numbers', 'loads', 'users', 'estimateIds']);


            return redirect(route('estimate.index'))->with(['success' => 'تخمین با موفقیت ایحاد شد']);

        } catch (\Exception $e) {

            // Send the exception details to Laravel Telescope for monitoring and debugging purposes
            report( extractError($e) );

            return redirect(route('estimate.index'))->with(['success' => 'تخمین با موفقیت ایحاد نشد']);

        }
    }

    public function estimate()
    {
        return view('admin.estimate.estimate');
    }

    public function show(Estimate $estimate)
    {
        return view('admin.estimate.show', compact('estimate'));
    }

    public function index()
    {
        return view('admin.estimate.index');
    }

    public function getData(Request $request)
    {
        $query = Estimate::query()->where('publish_status', '1')->with(['user', 'airline', 'loadDetail'])->orderByDesc('id')->withTrashed();
        $counter = 1;

        return DataTables::of($query)
            ->addColumn('id', function ($estimate) use (&$counter) {
                return $counter++;
            })
            ->addColumn('user_info', function ($estimate) {
                return $estimate->user_information ?: '-';
            })
            ->addColumn('airline_name', function ($estimate) {
                return $estimate->airline->name;
            })
            ->addColumn('origin', function ($estimate) {
                return $estimate->load_origin ?: '-';
            })
            ->addColumn('destination', function ($estimate) {
                return $estimate->load_destination ?: '-';
            })
            ->addColumn('weight', function ($estimate) {
                return $estimate?->loads?->weight ?: '0';
            })

            ->addColumn('formatted_estimate', function ($estimate) {
                return convertNumbersToPersian(number_format($estimate->estimate));
            })
            ->addColumn('size_width', function ($estimate) {
                $widths = is_string($estimate?->loads?->size_width) ? json_decode($estimate?->loads?->size_width, true) : $estimate?->loads?->size_width;
                if (is_array($widths)) {
                    return implode(', ', $widths);
                }
                return $widths ?: '-';
            })
            ->addColumn('size_height', function ($estimate) {
                $heights = is_string($estimate?->loads?->size_height) ? json_decode($estimate?->loads?->size_height, true) : $estimate?->loads?->size_height;
                if (is_array($heights)) {
                    return implode(', ', $heights);
                }
                return $heights ?: '-';
            })
            ->addColumn('size_length', function ($estimate) {
                $lengths = is_string($estimate?->loads?->size_length) ? json_decode($estimate?->loads?->size_length, true) : $estimate?->loads?->size_length;
                if (is_array($lengths)) {
                    return implode(', ', $lengths);
                }
                return $lengths ?: '-';
            })

            ->addColumn('volume_weight', function ($estimate) {

                if ($estimate?->loads?->size_width && $estimate?->loads?->size_height && $estimate?->loads?->size_length)
                    return json_decode($estimate?->loads?->volume_weight);
                else
                    return 0;

            })
            ->addColumn('created_at', function ($estimate) {
                return $estimate->created_at ? gregorian_date_to_shamsi_date($estimate->created_at, true) : '-';
            })
            ->addColumn('actions', function ($estimate) {
                $url = route('estimate.reject', ['estimate' => $estimate->id]);
                if ($estimate->trashed()) {
                    return '<a href="' . route('approve-order-page', ['estimate' => $estimate->id]) . '" class="btn btn-warning">
                            تایید سفارش
                        </a>';
                } elseif ($estimate->status == 1 && $estimate->loadDetail) {
                    return '<a href="' . route('orders.show', ['load_detail' => $estimate->loadDetail->id]) . '">
                            <button class="btn btn-primary btn-sm">نمایش پرونده</button>
                        </a>';
                } else {
                    return '<div class="d-flex gap-2">
                            <a href="' . route('approve-order-page', ['estimate' => $estimate->id]) . '" class="btn btn-warning">
                                                تایید سفارش
                                                    </a>
                            <button class="btn btn-danger btn-sm reject-order-btn"
                                    data-url="'. $url .'"
                                    data-bs-toggle="modal"
                                    data-bs-target="#reject-order-modal">
                                رد کردن سفارش
                            </button>
                        </div>
                    ';
                }

            })
            ->rawColumns(['actions'])
            ->make(true);
    }


    public function reject(Request $request, Estimate $estimate)
    {

        $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $estimate->update([
            Estimate::REJECTION_REASON => $request->rejection_reason
        ]);

        $estimate->delete();

        return Response::success('تخمین مورد نظر با موفقیت رد شد.', null, 200);
    }

    private function handleUserAndPartnersStore(Request $request)
    {
        $userId = $this->createOrRetrieveUser($request);

        if ($request->partner_exist == 'yes')
            $this->createPartners($userId, $request->partners);

        return $userId;
    }

    private function createOrRetrieveUser($request)
    {
        if ($request->user_exist != 'yes') {

            $user = User::create([
                'name' => $request->name,
                'lastname' => $request->lastname,
                'mobile' => $request->mobile,
                'password' => Hash::make($request->password),
                'is_partner' => $request->partner_exist == 'yes' ? '1' : '0'
            ]);

            return $user->id;
        }

        return $request->user_id;
    }

    private function createPartners($userId, array $partners)
    {
        foreach ($partners as $partnerId) {
            Partner::create([
                'partner_id' => $partnerId,
                'user_id' => $userId
            ]);
        }
    }

    private function updateEstimateAndLoadUserID($estimateID, $userID)
    {
        $estimate = Estimate::query()->find($estimateID);

        if ($estimate->loads)
            $estimate->loads->update([
                'user_id' => $userID
            ]);

        $estimate->update([
            'user_id' => $userID,
            'publish_status' => '1'
        ]);
    }

    private function deleteExtraEstimates($estimateIDs)
    {
        Estimate::query()->whereIn('id', $estimateIDs)->forceDelete();
    }

    private function datatableSearch(&$query, $searchValue, $columns)
    {
        $query->where(function ($q) use ($searchValue, $columns) {
            foreach ($columns as $column) {
                switch ($column) {
                    case 'name':
                    case 'lastname':
                    case 'mobile':

                        $q->orWhereHas('user', function ($subQuery) use ($searchValue) {
                            $subQuery->where('name', 'like', '%' . $searchValue . '%')
                                ->orWhere('lastname', 'like', '%' . $searchValue . '%')
                                ->orWhere('mobile', 'like', '%' . $searchValue . '%');
                        });
                        break;

                    default:

                        $q->orWhere($column, 'like', '%' . $searchValue . '%');
                        break;
                }
            }
        });
    }

}
