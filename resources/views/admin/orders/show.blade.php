@extends('layouts.admin.master')

@section('title')
    <title>پنل مدیریت | پرونده مشتری</title>
@endsection

@section('styles')@endsection


@section('body-content')


    <div class="header-order d-flex flex-row justify-content-between p-5">
        <div class="col-10 col-lg-10 d-flex flex-column flex-md-row justify-content-start align-items-center">
            <h3 class="text-center fs-6 text-black m-0"> پرونده مشتری : <span class="text-theme-default">{{ $userFile?->user?->lastname ?: '-' }} </span></h3>
            <h3 class="text-center fs-6 text-black m-0 ms-3">  به پرونده : <span class="text-theme-default">{{ $userFile?->case_number ?: '-' }} </span></h3>
            <h3 class="text-center fs-6 text-black m-0 ms-3"> بازاریاب : <span class="text-theme-default">{{ $userFile?->partners ?: 'ندارد' }} </span></h3>
        </div>
        <div class="col-12 col-lg-2 d-flex justify-content-end align-items-center">
            <a href="#" data-bs-toggle="modal"
               data-bs-target="#reject-order-modal">
                <button type="button" class="btn btn-danger border-12 px-5 py-2">حذف پرونده</button>
            </a>

        </div>
    </div>
    <div class="progress-order px-5 px-3 mb-4">
        <div class="position-relative   ">
            <div class="progress">
                <div class="percent"></div>
            </div>
            <div class="steps">

                @foreach ($states as $stateKey => $stateLabel)
                    <div class="step selected {{ $userFile->checkLoadState($userFile->state, $stateKey) }}" id="{{ $loop->index }}">
                        <p><b>{{ $stateLabel }}</b></p>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

    <div class="body-order d-flex flex-row justify-content-between p-5">

        <div class="modal fade" id="reject-order-modal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenter" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center">آیا میخواهید سفارش را رد کنید؟</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="col-12 mb-3">
                            <label class="form-label" for="">دلیل رد کردن : <small>(لطفا دلیل رد کردن تخمین رو شرح دهید)</small></label>
                            <form id="reject-order-form" action="#" method="post">
                                <div>
                                    <label for="reason_select">انتخاب دلیل</label>
                                    <select class="form-control" name="reason_select" id="reason_select">
                                        <option value="custom">دلیل جدید</option>
                                        @foreach($messages as $message)
                                            <option value="{{ $message->message }}">{{ $message->title }}</option>
                                        @endforeach

                                    </select>
                                </div>

                                <div style="margin-top: 10px;">
                                    <label for="rejection_reason">دلیل شکست</label>
                                    <textarea class="form-control" name="rejection_reason" id="rejection_reason" rows="3"></textarea>
                                </div>
                            </form>

                        </div>

                        <button id="reject-order-submit" data-url="{{ route('orders.destroy', ['load_detail' => $userFile->id]) }}" class="btn btn-primary fw-bold text-white rounded-pill" type="button">ثبت درخواست</button>

                    </div>
                </div>
            </div>
        </div>



        <div class="body-order-content col-4">
            <div class="d-flex flex-row justify-content-between align-items-center p-3 py-4">
                <p class="d-flex flex-row justify-content-start align-items-center fs-5 fw-bold text-white m-0"><svg width="53" height="52" viewBox="0 0 53 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <i data-feather="user" class="me-3" style="width:40px;height: 40px;color: lightslategray"></i>
                        <defs>
                            <clipPath id="clip0_337_762">
                                <rect width="37" height="41" fill="white" transform="translate(8.5 6)" />
                            </clipPath>
                        </defs>
                    </svg>
                    اطلاعات مشتری</p>
                <button class="btn me-3 bg-white">
                    <svg width="15" height="9" viewBox="0 0 15 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.21713 8.21663C7.93588 8.49753 7.55463 8.65531 7.15713 8.65531C6.75963 8.65531 6.37838 8.49753 6.09713 8.21663L0.439127 2.56063C0.157865 2.27923 -9.37265e-05 1.89763 4.17235e-08 1.49977C9.38099e-05 1.10192 0.158232 0.72039 0.439627 0.439127C0.721021 0.157865 1.10262 -9.37265e-05 1.50048 4.17234e-08C1.89834 9.38099e-05 2.27986 0.158233 2.56113 0.439627L7.15713 5.03563L11.7531 0.439627C12.0359 0.166254 12.4147 0.0148813 12.808 0.0181122C13.2013 0.0213432 13.5776 0.178919 13.8559 0.456901C14.1341 0.734883 14.292 1.11103 14.2956 1.50432C14.2993 1.89762 14.1482 2.2766 13.8751 2.55963L8.21813 8.21763L8.21713 8.21663Z" fill="#26668B" />
                    </svg>
                </button>
            </div>
            <table class="body-order-table display dataTable no-footer m-0 p-0" role="grid" style="display: none;">
                <tbody>
                <tr role="row" class="odd">
                    <td class="text-center">نام</td>
                    <td class="text-center">{{ $userFile->user->name ?? '-' }}</td>
                </tr>
                <tr role="row" class="odd">
                    <td class="text-center">نام خانوادگی</td>
                    <td class="text-center">{{ $userFile->user->lastname ?? '-' }}</td>
                </tr>
                <tr role="row" class="odd">
                    <td class="text-center">شماره موبایل</td>
                    <td class="text-center">{{ $userFile->user->mobile ?? '-' }}</td>
                </tr>
                <tr role="row" class="odd">
                    <td class="text-center">نوع مشتری</td>
                    <td class="text-center">عادی</td>
                </tr>
                <tr role="row" class="odd">
                    <td class="text-center">بازاریاب</td>
                    <td class="text-center">{{ $userFile?->partners ?: 'بازاریاب ندارد' }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="body-order-content col-4">
            <div class="d-flex flex-row justify-content-between align-items-center p-3 py-4">
                <p class="d-flex flex-row justify-content-start align-items-center fs-5 fw-bold text-white m-0"><svg width="53" height="52" viewBox="0 0 53 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <i data-feather="file" class="me-3" style="width:40px;height: 40px;color: lightslategray"></i>
                        <defs>
                            <clipPath id="clip0_337_762">
                                <rect width="37" height="41" fill="white" transform="translate(8.5 6)" />
                            </clipPath>
                        </defs>
                    </svg>
                    اطلاعات جمع آوری بار</p>
                <button class="btn me-3 bg-white">
                    <svg width="15" height="9" viewBox="0 0 15 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.21713 8.21663C7.93588 8.49753 7.55463 8.65531 7.15713 8.65531C6.75963 8.65531 6.37838 8.49753 6.09713 8.21663L0.439127 2.56063C0.157865 2.27923 -9.37265e-05 1.89763 4.17235e-08 1.49977C9.38099e-05 1.10192 0.158232 0.72039 0.439627 0.439127C0.721021 0.157865 1.10262 -9.37265e-05 1.50048 4.17234e-08C1.89834 9.38099e-05 2.27986 0.158233 2.56113 0.439627L7.15713 5.03563L11.7531 0.439627C12.0359 0.166254 12.4147 0.0148813 12.808 0.0181122C13.2013 0.0213432 13.5776 0.178919 13.8559 0.456901C14.1341 0.734883 14.292 1.11103 14.2956 1.50432C14.2993 1.89762 14.1482 2.2766 13.8751 2.55963L8.21813 8.21763L8.21713 8.21663Z" fill="#26668B" />
                    </svg>
                </button>
            </div>
            <table class="body-order-table display dataTable no-footer m-0 p-0" role="grid" style="display: none;">
                <tbody>

                <tr role="row" class="odd">
                    <td class="text-center">وضعیت</td>
                    <td class="text-center">{{ $userFile?->state  ? \App\Models\LoadDetail::$stateTranslations[$userFile->state] : '-' }}</td>
                </tr>

                <tr role="row" class="odd">
                    <td class="text-center">توسط مامور جمع آوری</td>
                    <td class="text-center">{{ $userFile?->collectionAgent?->employee  ? $userFile?->collectionAgent?->employee?->name . ' ' . $userFile?->collectionAgent?->employee?->last_name : '-' }}</td>
                </tr>

                <tr role="row" class="odd">
                    <td class="text-center">نوع ماشین</td>
                    <td class="text-center">{{ $userFile?->vehicleType  ? $userFile?->vehicleType?->name : '-' }}</td>
                </tr>

                <tr role="row" class="odd">
                    <td class="text-center">تاریخ دریافت توسط تیم جمع آوری</td>
                    <td class="text-center">{{ $userFile->collection_date ? gregorian_date_to_shamsi_date($userFile->collection_date) : '-' }}</td>
                </tr>


                <tr role="row" class="odd">
                    <td class="text-center">بازه زمانی دریافت</td>
                    <td class="text-center">{{ $userFile->start_collection_time . ' تا ' .  $userFile->end_collection_time }}</td>
                </tr>
                <tr role="row" class="odd">
                    <td class="text-center">تاریخ ارسال</td>
                    <td class="text-center">{{ $userFile->delivery_date ? gregorian_date_to_shamsi_date($userFile->delivery_date) : 'ارسال فوری در سریع ترین زمان ممکن' }}</td>
                </tr>
                <tr role="row" class="odd">
                    <td class="text-center">شماره تماس منزل</td>
                    <td class="text-center">{{ $userFile->phone_number ?? '-' }}</td>
                </tr>
                <tr role="row" class="odd">
                    <td class="text-center">کد پستی</td>
                    <td class="text-center">{{ $userFile->postal_code ?? '-' }}</td>
                </tr>
                <tr role="row" class="odd">
                    <td class="text-center">آدرس منزل</td>
                    <td class="text-center">{{ $userFile->address ?? '-' }}</td>
                </tr>

                </tbody>
            </table>
        </div>

        <div class="body-order-content col-4">
            <div class="d-flex flex-row justify-content-between align-items-center p-3 py-4">
                <p class="d-flex flex-row justify-content-start align-items-center fs-5 fw-bold text-white m-0"><svg width="53" height="52" viewBox="0 0 53 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <i data-feather="package" class="me-3" style="width:40px;height: 40px;color: lightslategray"></i>
                        <defs>
                            <clipPath id="clip0_337_762">
                                <rect width="37" height="41" fill="white" transform="translate(8.5 6)" />
                            </clipPath>
                        </defs>
                    </svg>
                    اطلاعات کالا</p>
                <button class="btn me-3 bg-white">
                    <svg width="15" height="9" viewBox="0 0 15 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.21713 8.21663C7.93588 8.49753 7.55463 8.65531 7.15713 8.65531C6.75963 8.65531 6.37838 8.49753 6.09713 8.21663L0.439127 2.56063C0.157865 2.27923 -9.37265e-05 1.89763 4.17235e-08 1.49977C9.38099e-05 1.10192 0.158232 0.72039 0.439627 0.439127C0.721021 0.157865 1.10262 -9.37265e-05 1.50048 4.17234e-08C1.89834 9.38099e-05 2.27986 0.158233 2.56113 0.439627L7.15713 5.03563L11.7531 0.439627C12.0359 0.166254 12.4147 0.0148813 12.808 0.0181122C13.2013 0.0213432 13.5776 0.178919 13.8559 0.456901C14.1341 0.734883 14.292 1.11103 14.2956 1.50432C14.2993 1.89762 14.1482 2.2766 13.8751 2.55963L8.21813 8.21763L8.21713 8.21663Z" fill="#26668B" />
                    </svg>
                </button>
            </div>
            <table class="body-order-table display dataTable no-footer m-0 p-0" role="grid" style="display: none;">
                <tbody>

{{--                @if(isEqual($userFile->load_type, 'special'))--}}
{{--                    <tr role="row" class="odd">--}}
{{--                        <td class="text-center">توضیحات کالای خاص</td>--}}
{{--                        <td class="text-center">{{ $userFile->special_load_description }}</td>--}}
{{--                    </tr>--}}
{{--                @endif--}}

                <tr role="row" class="odd">
                    <td class="text-center">وزن بار</td>
                    <td class="text-center">{{ $userFile->weight }} کیلوگرم </td>
                </tr>

                <tr role="row" class="odd">
                    <td class="text-center">ماهیت کالا</td>
                    <td class="text-center">{{ $userFile?->nature ? $userFile->nature?->name : '-' }}</td>
                </tr>

                <tr role="row" class="odd">
                    <td class="text-center">تعداد بسته</td>
                    <td class="text-center">{{ $userFile?->package_count ?: '-' }} عدد </td>
                </tr>

{{--                @if ($userFile?->volume_weight != 0 && $userFile?->volume_weight != '-')--}}
{{--                    <tr role="row" class="odd">--}}
{{--                        <td class="text-center">وزن حجمی</td>--}}
{{--                        <td class="text-center">{{ $userFile->volume_weight }}</td>--}}
{{--                    </tr>--}}
{{--                @endif--}}

                </tbody>
            </table>
        </div>

        <div class="body-order-content col-4">
            <div class="d-flex flex-row justify-content-between align-items-center p-3 py-4">
                <p class="d-flex flex-row justify-content-start align-items-center fs-5 fw-bold text-white m-0"><svg width="53" height="52" viewBox="0 0 53 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <i data-feather="dollar-sign" class="me-3" style="width:40px;height: 40px;color: lightslategray"></i>
                        <defs>
                            <clipPath id="clip0_337_762">
                                <rect width="37" height="41" fill="white" transform="translate(8.5 6)" />
                            </clipPath>
                        </defs>
                    </svg>
                    اطلاعات قیمت</p>
                <button class="btn me-3 bg-white">
                    <svg width="15" height="9" viewBox="0 0 15 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.21713 8.21663C7.93588 8.49753 7.55463 8.65531 7.15713 8.65531C6.75963 8.65531 6.37838 8.49753 6.09713 8.21663L0.439127 2.56063C0.157865 2.27923 -9.37265e-05 1.89763 4.17235e-08 1.49977C9.38099e-05 1.10192 0.158232 0.72039 0.439627 0.439127C0.721021 0.157865 1.10262 -9.37265e-05 1.50048 4.17234e-08C1.89834 9.38099e-05 2.27986 0.158233 2.56113 0.439627L7.15713 5.03563L11.7531 0.439627C12.0359 0.166254 12.4147 0.0148813 12.808 0.0181122C13.2013 0.0213432 13.5776 0.178919 13.8559 0.456901C14.1341 0.734883 14.292 1.11103 14.2956 1.50432C14.2993 1.89762 14.1482 2.2766 13.8751 2.55963L8.21813 8.21763L8.21713 8.21663Z" fill="#26668B" />
                    </svg>
                </button>
            </div>
            <table class="body-order-table display dataTable no-footer m-0 p-0" role="grid" style="display: none;">
                <tbody>

                <tr role="row" class="odd">
                    <td class="text-center">مبدا</td>
                    <td class="text-center">{{ $userFile->origin }}</td>
                </tr>
                <tr role="row" class="odd">
                    <td class="text-center">مقصد</td>
                    <td class="text-center">{{ $userFile->destination }}</td>
                </tr>

                <tr role="row" class="odd">
                    <td class="text-center">ادمین فروش</td>
                    <td class="text-center">{{ $userFile?->admin_information_for_order ?? '-' }}</td>
                </tr>

                <tr role="row" class="odd">
                    <td class="text-center">قیمت نهایی</td>
                    <td class="text-center">{{ $userFile?->estimate?->estimate ? convertNumbersToPersian(number_format($userFile?->estimate->estimate)) . ' ریال ' : '-' }}</td>
                </tr>

                </tbody>
            </table>
        </div>


        <div class="body-order-content col-4">
            <div class="d-flex flex-row justify-content-between align-items-center p-3 py-4">
                <p class="d-flex flex-row justify-content-start align-items-center fs-5 fw-bold text-white m-0"><svg width="53" height="52" viewBox="0 0 53 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <i data-feather="check-square" class="me-3" style="width:40px;height: 40px;color: lightslategray"></i>
                        <defs>
                            <clipPath id="clip0_337_762">
                                <rect width="37" height="41" fill="white" transform="translate(8.5 6)" />
                            </clipPath>
                        </defs>
                    </svg>
                    وضعیت جمع آوری</p>
                <button class="btn me-3 bg-white">
                    <svg width="15" height="9" viewBox="0 0 15 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.21713 8.21663C7.93588 8.49753 7.55463 8.65531 7.15713 8.65531C6.75963 8.65531 6.37838 8.49753 6.09713 8.21663L0.439127 2.56063C0.157865 2.27923 -9.37265e-05 1.89763 4.17235e-08 1.49977C9.38099e-05 1.10192 0.158232 0.72039 0.439627 0.439127C0.721021 0.157865 1.10262 -9.37265e-05 1.50048 4.17234e-08C1.89834 9.38099e-05 2.27986 0.158233 2.56113 0.439627L7.15713 5.03563L11.7531 0.439627C12.0359 0.166254 12.4147 0.0148813 12.808 0.0181122C13.2013 0.0213432 13.5776 0.178919 13.8559 0.456901C14.1341 0.734883 14.292 1.11103 14.2956 1.50432C14.2993 1.89762 14.1482 2.2766 13.8751 2.55963L8.21813 8.21763L8.21713 8.21663Z" fill="#26668B" />
                    </svg>
                </button>
            </div>
            <table class="body-order-table display dataTable no-footer m-0 p-0" role="grid" style="display: none;">
                <tbody>
                    @if($loadDetail->collectionAgentRequest && $loadDetail->collectionAgentRequest->status != 'waiting')
                        <tr role="row" class="odd">
                            <td class="text-center">وضعیت جمع آوری</td>
                            <td class="text-center">{{ \App\Models\CollectionAgentRequest::STATES[$loadDetail->collectionAgentRequest->status] }}
                            </td>

                        </tr>
                        <tr role="row" class="odd">
                            <td class="text-center">مامور جمع آوری</td>
                            <td class="text-center">{{ $loadDetail->collectionAgentRequest->collectionAgent->employee->name.' '.$loadDetail->collectionAgentRequest->collectionAgent->employee->last_name }}</td>
                        </tr>

                        <tr role="row" class="odd">
                            <td class="text-center">تاریخ جمع آوری</td>
                            <td class="text-center">{{verta( $loadDetail->collection_date )->format('Y/m/d')}}</td>
                        </tr>

                        @if(($loadDetail->collectionAgentRequest->collectionAgentCustomerForm))
                            <tr role="row" class="odd">
                                <td class="text-center">زمان جمع آوری</td>
                                <td class="text-center">{{ verta($loadDetail->collectionAgentRequest->collectionAgentCustomerForm->created_at)->format('H:m Y/m/d ')}}</td>
                            </tr>
{{--                            <tr role="row" class="odd">--}}
{{--                                <td class="text-center">جعبه چوبی</td>--}}
{{--                                <td class="text-center">{{ ($loadDetail->collectionAgentRequest->collectionAgentCustomerForm->need_wooden_box)?'داشت' : 'نداشت' }}</td>--}}
{{--                            </tr>--}}
                            @foreach($loadDetail->collectionAgentRequest->collectionAgentCustomerForm->form_packages as $key=>$item)
                                <tr role="row" class="odd">
                                    <td class="text-center"> جعبه چوبی {{$key+1}}</td>
                                    <td class="text-center">{{ \App\Models\CollectionAgentCustomerFormPackages::BOX_TYPE[$item->box_type]}}</td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td class="text-center">قیمت جعبه چوبی {{$key+1}}</td>
                                    <td class="text-center">{{  number_format($item->box_price) }}</td>
                                </tr>
                            @endforeach
{{--                            @if($loadDetail->collectionAgentRequest->collectionAgentCustomerForm->need_wooden_box)--}}
{{--                                <tr role="row" class="odd">--}}
{{--                                    <td class="text-center"> {{$key+1}}نوع جعبه چوبی</td>--}}
{{--                                    <td class="text-center">{{ \App\Models\CollectionAgentCustomerFormPackages::BOX_TYPE[$loadDetail->collectionAgentRequest->collectionAgentCustomerForm->box_type]}}</td>--}}
{{--                                </tr>--}}
{{--                                <tr role="row" class="odd">--}}
{{--                                    <td class="text-center"> {{$key+1}}قیمت جعبه چوبی</td>--}}
{{--                                    <td class="text-center">{{  number_format($loadDetail->collectionAgentRequest->collectionAgentCustomerForm->box_price) }}</td>--}}
{{--                                </tr>--}}
{{--                            @endif--}}
                            <tr role="row" class="odd">
                                <td class="text-center">پالت</td>
                                <td class="text-center">{{ ($loadDetail->collectionAgentRequest->collectionAgentCustomerForm->need_pallet)?'داشت' : 'نداشت' }}</td>
                            </tr>
                            @foreach($consumables as $consumable)
                                <tr role="row" class="odd">
                                    <td class="text-center">{{$consumable['name']}}</td>
                                    <td class="text-center">{{$consumable['number_usage'].' '.$consumable['unit']}}</td>
                                </tr>
                            @endforeach
                        @endif
                    @endif
                </tbody>
            </table>
        </div>

        <div class="body-order-content col-4">
            <div class="d-flex flex-row justify-content-between align-items-center p-3 py-4">
                <p class="d-flex flex-row justify-content-start align-items-center fs-5 fw-bold text-white m-0"><svg width="53" height="52" viewBox="0 0 53 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <i data-feather="archive" class="me-3" style="width:40px;height: 40px;color: lightslategray"></i>
                        <defs>
                            <clipPath id="clip0_337_762">
                                <rect width="37" height="41" fill="white" transform="translate(8.5 6)" />
                            </clipPath>
                        </defs>
                    </svg>
                    انبارداری</p>
                <button class="btn me-3 bg-white">
                    <svg width="15" height="9" viewBox="0 0 15 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.21713 8.21663C7.93588 8.49753 7.55463 8.65531 7.15713 8.65531C6.75963 8.65531 6.37838 8.49753 6.09713 8.21663L0.439127 2.56063C0.157865 2.27923 -9.37265e-05 1.89763 4.17235e-08 1.49977C9.38099e-05 1.10192 0.158232 0.72039 0.439627 0.439127C0.721021 0.157865 1.10262 -9.37265e-05 1.50048 4.17234e-08C1.89834 9.38099e-05 2.27986 0.158233 2.56113 0.439627L7.15713 5.03563L11.7531 0.439627C12.0359 0.166254 12.4147 0.0148813 12.808 0.0181122C13.2013 0.0213432 13.5776 0.178919 13.8559 0.456901C14.1341 0.734883 14.292 1.11103 14.2956 1.50432C14.2993 1.89762 14.1482 2.2766 13.8751 2.55963L8.21813 8.21763L8.21713 8.21663Z" fill="#26668B" />
                    </svg>
                </button>
            </div>
            <table class="body-order-table display dataTable no-footer m-0 p-0" role="grid" style="display: none;">
                <tbody>
                <tr role="row" class="odd">
                    <td class="text-center">...</td>
                    <td class="text-center">...</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="body-order-content col-4">
            <div class="d-flex flex-row justify-content-between align-items-center p-3 py-4">
                <p class="d-flex flex-row justify-content-start align-items-center fs-5 fw-bold text-white m-0"><svg width="53" height="52" viewBox="0 0 53 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <i data-feather="flag" class="me-3" style="width:40px;height: 40px;color: lightslategray"></i>
                        <defs>
                            <clipPath id="clip0_337_762">
                                <rect width="37" height="41" fill="white" transform="translate(8.5 6)" />
                            </clipPath>
                        </defs>
                    </svg>
                    تشریفات گمرکی</p>
                <button class="btn me-3 bg-white">
                    <svg width="15" height="9" viewBox="0 0 15 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.21713 8.21663C7.93588 8.49753 7.55463 8.65531 7.15713 8.65531C6.75963 8.65531 6.37838 8.49753 6.09713 8.21663L0.439127 2.56063C0.157865 2.27923 -9.37265e-05 1.89763 4.17235e-08 1.49977C9.38099e-05 1.10192 0.158232 0.72039 0.439627 0.439127C0.721021 0.157865 1.10262 -9.37265e-05 1.50048 4.17234e-08C1.89834 9.38099e-05 2.27986 0.158233 2.56113 0.439627L7.15713 5.03563L11.7531 0.439627C12.0359 0.166254 12.4147 0.0148813 12.808 0.0181122C13.2013 0.0213432 13.5776 0.178919 13.8559 0.456901C14.1341 0.734883 14.292 1.11103 14.2956 1.50432C14.2993 1.89762 14.1482 2.2766 13.8751 2.55963L8.21813 8.21763L8.21713 8.21663Z" fill="#26668B" />
                    </svg>
                </button>
            </div>
            <table class="body-order-table display dataTable no-footer m-0 p-0" role="grid" style="display: none;">
                <tbody>
                <tr role="row" class="odd">
                    <td class="text-center">...</td>
                    <td class="text-center">...</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="body-order-content col-4">
            <div class="d-flex flex-row justify-content-between align-items-center p-3 py-4">
                <p class="d-flex flex-row justify-content-start align-items-center fs-5 fw-bold text-white m-0"><svg width="53" height="52" viewBox="0 0 53 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <i data-feather="truck" class="me-3" style="width:40px;height: 40px;color: lightslategray"></i>
                        <defs>
                            <clipPath id="clip0_337_762">
                                <rect width="37" height="41" fill="white" transform="translate(8.5 6)" />
                            </clipPath>
                        </defs>
                    </svg>
                    صدور بارنامه</p>
                <button class="btn me-3 bg-white">
                    <svg width="15" height="9" viewBox="0 0 15 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.21713 8.21663C7.93588 8.49753 7.55463 8.65531 7.15713 8.65531C6.75963 8.65531 6.37838 8.49753 6.09713 8.21663L0.439127 2.56063C0.157865 2.27923 -9.37265e-05 1.89763 4.17235e-08 1.49977C9.38099e-05 1.10192 0.158232 0.72039 0.439627 0.439127C0.721021 0.157865 1.10262 -9.37265e-05 1.50048 4.17234e-08C1.89834 9.38099e-05 2.27986 0.158233 2.56113 0.439627L7.15713 5.03563L11.7531 0.439627C12.0359 0.166254 12.4147 0.0148813 12.808 0.0181122C13.2013 0.0213432 13.5776 0.178919 13.8559 0.456901C14.1341 0.734883 14.292 1.11103 14.2956 1.50432C14.2993 1.89762 14.1482 2.2766 13.8751 2.55963L8.21813 8.21763L8.21713 8.21663Z" fill="#26668B" />
                    </svg>
                </button>
            </div>
            <table class="body-order-table display dataTable no-footer m-0 p-0" role="grid" style="display: none;">
                <tbody>
                <tr role="row" class="odd">

                    <td class="text-center">
                        @if ($userFile?->waybill)
                            <a href="{{ route('waybills.show', $userFile->waybill->id) }}" class="btn btn-warning">مشاهده بارنامه</a>
                        @else
                            ...
                        @endif
                    </td>
                    <td class="text-center">...</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="body-order-content col-4">
            <div class="d-flex flex-row justify-content-between align-items-center p-3 py-4">
                <p class="d-flex flex-row justify-content-start align-items-center fs-5 fw-bold text-white m-0"><svg width="53" height="52" viewBox="0 0 53 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <i data-feather="airplay" class="me-3" style="width:40px;height: 40px;color: lightslategray"></i>
                        <defs>
                            <clipPath id="clip0_337_762">
                                <rect width="37" height="41" fill="white" transform="translate(8.5 6)" />
                            </clipPath>
                        </defs>
                    </svg>
                    رزرو پرواز</p>
                <button class="btn me-3 bg-white">
                    <svg width="15" height="9" viewBox="0 0 15 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.21713 8.21663C7.93588 8.49753 7.55463 8.65531 7.15713 8.65531C6.75963 8.65531 6.37838 8.49753 6.09713 8.21663L0.439127 2.56063C0.157865 2.27923 -9.37265e-05 1.89763 4.17235e-08 1.49977C9.38099e-05 1.10192 0.158232 0.72039 0.439627 0.439127C0.721021 0.157865 1.10262 -9.37265e-05 1.50048 4.17234e-08C1.89834 9.38099e-05 2.27986 0.158233 2.56113 0.439627L7.15713 5.03563L11.7531 0.439627C12.0359 0.166254 12.4147 0.0148813 12.808 0.0181122C13.2013 0.0213432 13.5776 0.178919 13.8559 0.456901C14.1341 0.734883 14.292 1.11103 14.2956 1.50432C14.2993 1.89762 14.1482 2.2766 13.8751 2.55963L8.21813 8.21763L8.21713 8.21663Z" fill="#26668B" />
                    </svg>
                </button>
            </div>
            <table class="body-order-table display dataTable no-footer m-0 p-0" role="grid" style="display: none;">
                <tbody>
                <tr role="row" class="odd">
                    <td class="text-center">...</td>
                    <td class="text-center">...</td>
                </tr>
                </tbody>
            </table>
        </div>


        <div class="body-order-content col-4">
            <div class="d-flex flex-row justify-content-between align-items-center p-3 py-4">
                <p class="d-flex flex-row justify-content-start align-items-center fs-5 fw-bold text-white m-0"><svg width="53" height="52" viewBox="0 0 53 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <i data-feather="printer" class="me-3" style="width:40px;height: 40px;color: lightslategray"></i>
                        <defs>
                            <clipPath id="clip0_337_762">
                                <rect width="37" height="41" fill="white" transform="translate(8.5 6)" />
                            </clipPath>
                        </defs>
                    </svg>
                    وضعیت مالی</p>
                <button class="btn me-3 bg-white">
                    <svg width="15" height="9" viewBox="0 0 15 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.21713 8.21663C7.93588 8.49753 7.55463 8.65531 7.15713 8.65531C6.75963 8.65531 6.37838 8.49753 6.09713 8.21663L0.439127 2.56063C0.157865 2.27923 -9.37265e-05 1.89763 4.17235e-08 1.49977C9.38099e-05 1.10192 0.158232 0.72039 0.439627 0.439127C0.721021 0.157865 1.10262 -9.37265e-05 1.50048 4.17234e-08C1.89834 9.38099e-05 2.27986 0.158233 2.56113 0.439627L7.15713 5.03563L11.7531 0.439627C12.0359 0.166254 12.4147 0.0148813 12.808 0.0181122C13.2013 0.0213432 13.5776 0.178919 13.8559 0.456901C14.1341 0.734883 14.292 1.11103 14.2956 1.50432C14.2993 1.89762 14.1482 2.2766 13.8751 2.55963L8.21813 8.21763L8.21713 8.21663Z" fill="#26668B" />
                    </svg>
                </button>
            </div>
            <table class="body-order-table display dataTable no-footer m-0 p-0" role="grid" style="display: none;">
                <tbody>
                <tr role="row" class="odd">
                    <td class="text-center">...</td>
                    <td class="text-center">...</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="body-order-content col-4">
            <div class="d-flex flex-row justify-content-between align-items-center p-3 py-4">
                <p class="d-flex flex-row justify-content-start align-items-center fs-5 fw-bold text-white m-0"><svg width="53" height="52" viewBox="0 0 53 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <i data-feather="send" class="me-3" style="width:40px;height: 40px;color: lightslategray"></i>
                        <defs>
                            <clipPath id="clip0_337_762">
                                <rect width="37" height="41" fill="white" transform="translate(8.5 6)" />
                            </clipPath>
                        </defs>
                    </svg>
                    ارسال کالا</p>
                <button class="btn me-3 bg-white">
                    <svg width="15" height="9" viewBox="0 0 15 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.21713 8.21663C7.93588 8.49753 7.55463 8.65531 7.15713 8.65531C6.75963 8.65531 6.37838 8.49753 6.09713 8.21663L0.439127 2.56063C0.157865 2.27923 -9.37265e-05 1.89763 4.17235e-08 1.49977C9.38099e-05 1.10192 0.158232 0.72039 0.439627 0.439127C0.721021 0.157865 1.10262 -9.37265e-05 1.50048 4.17234e-08C1.89834 9.38099e-05 2.27986 0.158233 2.56113 0.439627L7.15713 5.03563L11.7531 0.439627C12.0359 0.166254 12.4147 0.0148813 12.808 0.0181122C13.2013 0.0213432 13.5776 0.178919 13.8559 0.456901C14.1341 0.734883 14.292 1.11103 14.2956 1.50432C14.2993 1.89762 14.1482 2.2766 13.8751 2.55963L8.21813 8.21763L8.21713 8.21663Z" fill="#26668B" />
                    </svg>
                </button>
            </div>
            <table class="body-order-table display dataTable no-footer m-0 p-0" role="grid" style="display: none;">
                <tbody>
                <tr role="row" class="odd">
                    <td class="text-center">...</td>
                    <td class="text-center">...</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="body-order-content col-4">
            <div class="d-flex flex-row justify-content-between align-items-center p-3 py-4">
                <p class="d-flex flex-row justify-content-start align-items-center fs-5 fw-bold text-white m-0"><svg width="53" height="52" viewBox="0 0 53 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <i data-feather="file" class="me-3" style="width:40px;height: 40px;color: lightslategray"></i>
                        <defs>
                            <clipPath id="clip0_337_762">
                                <rect width="37" height="41" fill="white" transform="translate(8.5 6)" />
                            </clipPath>
                        </defs>
                    </svg>
                    اطلاعات جمع آوری بار</p>
                <button class="btn me-3 bg-white">
                    <svg width="15" height="9" viewBox="0 0 15 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.21713 8.21663C7.93588 8.49753 7.55463 8.65531 7.15713 8.65531C6.75963 8.65531 6.37838 8.49753 6.09713 8.21663L0.439127 2.56063C0.157865 2.27923 -9.37265e-05 1.89763 4.17235e-08 1.49977C9.38099e-05 1.10192 0.158232 0.72039 0.439627 0.439127C0.721021 0.157865 1.10262 -9.37265e-05 1.50048 4.17234e-08C1.89834 9.38099e-05 2.27986 0.158233 2.56113 0.439627L7.15713 5.03563L11.7531 0.439627C12.0359 0.166254 12.4147 0.0148813 12.808 0.0181122C13.2013 0.0213432 13.5776 0.178919 13.8559 0.456901C14.1341 0.734883 14.292 1.11103 14.2956 1.50432C14.2993 1.89762 14.1482 2.2766 13.8751 2.55963L8.21813 8.21763L8.21713 8.21663Z" fill="#26668B" />
                    </svg>
                </button>
            </div>
            <table class="body-order-table display dataTable no-footer m-0 p-0" role="grid" style="display: none;">
                <tbody>

                <tr role="row" class="odd">
                </tr>

                </tbody>
            </table>
        </div>

    </div>


@endsection

@section('script')

    <script src="{{ asset('panel/assets/js/axios.min.js') }}"></script>

    <script>

        $(document).ready(function () {

            $('.btn.me-3').each(function () {
                const button = $(this);
                const parentDiv = button.closest('.body-order-content');
                const table = parentDiv.find('.body-order-table');
                const svg = button.find('svg');
                button.on('click', function () {
                    if (table.css('display') === 'none' || table.css('display') === '') {
                        table.css('display', 'table'); // Show the table
                    } else {
                        table.css('display', 'none'); // Hide the table
                    }
                    const currentRotation = svg.css('transform');
                    if (currentRotation === 'none' || currentRotation === 'matrix(1, 0, 0, 1, 0, 0)') {
                        svg.css('transform', 'rotate(180deg)');
                    } else {
                        svg.css('transform', 'rotate(0deg)');
                    }
                    svg.css('transition', 'transform 0.3s ease');
                });
            });

            setupValidation('#reject-order-form', {
                rejection_reason: {
                    required: true,
                    minlength: 10,
                },
            },{
                rejection_reason: {
                    required: 'لطفا دلیل رد کردن را وارد نمایید',
                    minlength: 'توضیحات باید حداقل 10 حرف باشد',
                }
            }, '#reject-order-submit', null, true);


            const $selectElement = $('#reason_select');
            const $textarea = $('#rejection_reason');

            $selectElement.on('change', function () {
                if ($(this).val() === 'custom') {
                    $textarea.val('').prop('readonly', false).focus();
                } else {
                    $textarea.val($(this).val()).prop('readonly', true);
                    $textarea.valid();
                }
            });

            $textarea.on('input', function () {
                if ($textarea.val() !== $selectElement.val()) {
                    $selectElement.val('custom');
                }
            });

            $(document).on('click', '#reject-order-modal', function (e) {

                e.preventDefault();

                $('#reject-order-submit').off('click').on('click', function (submitEvent) {

                    submitEvent.preventDefault();

                    let url = $(this).data('url');

                    if ($('#reject-order-form').valid()) {

                        let rejectionReason = $textarea.val();

                        axios.delete(url, {
                            params: {rejection_reason: rejectionReason }
                        })
                            .then(function (response) {
                                if (response.data.status === 200) {
                                    $('#reject-order-modal').modal('hide');
                                    showAlert('success', response.data.message, 'حذف موفق');
                                    setTimeout(() => {
                                        window.location.href = '{{route('orders.index')}}';
                                    }, 3000);
                                } else {
                                    $('#reject-order-modal').modal('hide');
                                    showAlert('failed', 'خطایی هنگام حذف پرونده رخ داد، لطفاً دوباره تلاش کنید', 'حذف ناموفق');
                                }
                            })
                            .catch(function () {
                                $('#reject-order-modal').modal('hide');
                                showAlert('failed', 'خطایی هنگام حذف پرونده رخ داد، لطفاً دوباره تلاش کنید', 'حذف ناموفق');
                            });

                    }

                });

                $('#reject-order-modal').on('hidden.bs.modal', function () {
                    $selectElement.val('custom');
                    $textarea.val('').prop('readonly', false);
                });

            });



        })
    </script>

@endsection

