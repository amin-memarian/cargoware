@extends('layouts.admin.master')

@section('title')
    <title>پنل مدیریت | ثبت کالا جدید</title>
@endsection

@section('styles')

    <style>

        .accordion-placeholder {
            width: 24px;
            height: 24px;
            visibility: hidden;
        }

        .fs-custom {
            font-size: 19px!important;
        }

        .custom-accordion-container,
        .table-content {
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .fast-estimate-radio-box,
        .custom-first-grade-accordion {
            cursor: pointer;
        }

        .custom-accordion-container {
            display: flex;
            flex-direction: column;
            align-content: center;
            justify-content: flex-start;
            align-items: center;
            border: 2px solid #efefef;
            box-shadow: 0px 3px 20px 0px #0000000a;
            border-radius: 0px 0px 20px 20px !important;
            background: #f5f5f5;
        }

        .custom-first-grade-accordion {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            align-content: center;
            padding: 10px 65px;
        }

        .custom-accordion-parents-container table tr:last-child td {
            background: #f5f5f5 !important;
        }

        .custom-accordion-parents-container table tr:last-child td {
            background: #ffffff !important;
        }

        .custom-accordion-parents-container table tr td {
            border: white !important;
        }

        .table-content {
            table-layout: fixed;
            border-collapse: collapse;
        }

        .table-content td {
            width: 50%;
            text-align: center;
            padding: 8px;
            background-color: white;
            font-size: 1rem;
        }

        .custom-accordion-parents-container table tr {
            border-bottom: 1px solid #0472b333;
        }

        .custom-accordion-parents-container table tr:last-child {
            border-bottom: 1px solid rgba(255, 255, 255, 0.2) !important;
        }

        .accordion-icon {
            transition: transform 0.3s ease;
        }

        .accordion-icon.open {
            transform: rotate(180deg);
        }

        .fast-estimate-radio-box {
            border-radius: 20px;
            transition: border-radius 0.3s ease;
        }
    </style>

@endsection

@section('breadcrumb')
    <div class="row">
        <div class="col-12 col-sm-6">
            <h3>تخمین های معلق</h3>
        </div>
        <div class="col-12 col-sm-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <i data-feather="home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item">پنل مدیریت</li>
                <li class="breadcrumb-item active">تخمین های معلق</li>
            </ol>
        </div>
    </div>
@endsection


@section('body-content')

    <div class="container px-4">
        <form id="storeEstimate" class="container-fluid bg-white p-5 rounded" method="post" action="{{ route('estimate.store') }}">
            @csrf

            @foreach($numbers as $key => $number)


                <div class="row">
                    <div class="col-12">

                            <div class="fast-estimate-heading">
                                <h3 class="text-center fs-4 text-black">
                                    برای بار به شماره <span class="text-theme-default">{{ $number }}</span>
                                    با وزن <span class="text-theme-default">{{ $weight }} کیلوگرم</span>،
                                    تعداد <span class="text-theme-default">{{ count($estimates) }} ایرلاین</span>
                                    محاسبه شده است
                                </h3>
                                <div class="d-flex flex-row justify-content-center align-items-center mt-4">
                                    <h5 class="fs-5 fw-bold text-theme-secondary m-0">{{ $origin }}</h5>
                                    <svg class="mx-4" width="96" height="44" viewBox="0 0 96 44" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M35.3267 5.03125H37.5624C37.787 5.03133 38.0081 5.08772 38.2053 5.19526C38.4025 5.30281 38.5696 5.45809 38.6913 5.64689C38.8131 5.8357 38.8855 6.052 38.902 6.27603C38.9186 6.50006 38.8787 6.72466 38.786 6.9293L33.3724 18.8761L41.5013 19.0566L44.4659 15.4646C45.0311 14.7541 45.4821 14.4375 46.6327 14.4375H48.1377C48.376 14.4298 48.6126 14.4797 48.8275 14.5829C49.0424 14.6861 49.2293 14.8396 49.3723 15.0304C49.5722 15.3 49.7687 15.7569 49.5772 16.4086L47.9126 22.3715C47.9 22.416 47.8849 22.4605 47.8681 22.5042C47.8673 22.5084 47.8673 22.5126 47.8681 22.5168C47.8854 22.5604 47.9003 22.605 47.9126 22.6503L49.5789 28.651C49.7594 29.2901 49.5621 29.7369 49.3639 29.9998C49.2308 30.1764 49.0581 30.3193 48.8597 30.417C48.6614 30.5148 48.4428 30.5646 48.2217 30.5625H46.6327C45.7735 30.5625 44.9396 30.177 44.4491 29.5547L41.5458 26.0231L33.3724 26.1441L38.7844 38.0699C38.8772 38.2744 38.9172 38.4989 38.9008 38.723C38.8844 38.947 38.8122 39.1633 38.6906 39.3522C38.5691 39.5411 38.4021 39.6964 38.205 39.8042C38.0079 39.9119 37.787 39.9685 37.5624 39.9688H35.3024C34.9871 39.9624 34.6772 39.8851 34.3959 39.7426C34.1146 39.6002 33.8689 39.3961 33.6773 39.1457L23.175 26.3801L18.3232 26.5077C17.968 26.5271 16.9837 26.5338 16.7561 26.5338C12.1151 26.5312 9.34364 25.0246 9.34364 22.5C9.34364 21.7055 9.6611 20.2324 11.7851 19.2952C13.039 18.7409 14.7119 18.4604 16.7578 18.4604C16.9829 18.4604 17.9646 18.4671 18.3249 18.4864L23.1759 18.6157L33.7041 5.8501C33.896 5.60077 34.1414 5.39774 34.4222 5.25601C34.7031 5.11427 35.0122 5.03746 35.3267 5.03125Z"
                                            fill="#0472B3"/>
                                        <circle cx="59.5" cy="22.5" r="2.5" fill="#0472B3"/>
                                        <circle cx="67" cy="22.5" r="2" fill="#0472B3" fill-opacity="0.66"/>
                                        <circle cx="74.5" cy="22.5" r="1.5" fill="#147EBD" fill-opacity="0.36"/>
                                        <circle cx="81" cy="22.5" r="1" fill="#147EBD" fill-opacity="0.17"/>
                                    </svg>
                                    <h5 class="fs-5 fw-bold text-theme-secondary m-0">{{ $destination }}</h5>
                                </div>
                            </div>

                                <input type="hidden" name="estimate_ids" value="{{ json_encode($estimateIds) }}">
                                <input type="hidden" name="weights" value="{{ json_encode($weights) }}">
                                <input type="hidden" name="numbers" value="{{ json_encode($numbers) }}">
                                <input type="hidden" name="loads" value="{{ json_encode($loads) }}">
                                <input type="hidden" name="users" value="{{ json_encode($users) }}">


                                <div class="fast-estimate-content">
                                    @foreach($estimates as $key => $estimate)

                                        <div class="fast-estimate-radio-box-container custom-accordion-parents-container">
                                            <!-- Main Accordion Trigger -->
                                            <label class="fast-estimate-radio-box">

                                                <input id="radio{{$estimate->id}}" type="radio" name="estimate_id_selected" value="{{ $estimate->id }}"  onclick="return enableButton()" <?php if ($key == 0) { echo 'checked'; } ?>>

                                                <div class="d-flex flex-column flex-md-row gap-4">

                                                    <img src="{{ asset($estimate->airline_image_path ) }}" alt="{{ $estimate->airline ? 'لوگو ' . $estimate->airline->name : '' }}"
                                                         width="130px" height="auto">

                                                    <div>

                                                        <h6 class="mt-0 mega-title-badge d-flex justify-content-between align-items-end mb-2 mt-1">
                                                            @if ($estimate->airline->name != 'Mahan Air' && $estimate->airline->name != 'Iran Air')
                                                                <span class="badge badge-primary pull-right digits">ROE : {{ number_format($estimate->ROE) }}</span>
                                                            @else
                                                                <span class="" >&nbsp;</span>
                                                            @endif
                                                        </h6>

                                                        <p class="m-0 fs-5 d-flex align-self-center">مبلغ تخمین {{ convertNumbersToPersian(number_format($estimate->estimate)) }} ریال</p>
                                                    </div>
                                                </div>



                                                <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg" class="accordion-icon">
                                                    <path d="M30 21.25V36.25" stroke="#EB993B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M22.5 31.25L30 38.75L37.5 31.25" stroke="#EB993B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M10 15C6.875 19.175 5 24.375 5 30C5 43.8 16.2 55 30 55C43.8 55 55 43.8 55 30C55 16.2 43.8 5 30 5C26.425 5 23 5.75 19.925 7.125" stroke="#EB993B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>

                                            </label>

                                            <!-- Sub-Accordion Content (Initially Hidden) -->
                                            <div class="custom-accordion-container" style="display: none;">

                                                <?php
                                                    $airlineInformation = findAirlineInformationByName($estimate->airline->name);
                                                ?>
                                                @if(!empty($airlineInformation))

                                                    @switch($estimate->airline->name)
                                                        @case('Qatar')

                                                            <!-- Sub-Accordion -->
                                                            <div class="custom-first-grade-accordion">
                                                                <div class="d-flex flex-column flex-md-row">
                                                                    <p class="m-0 fs-custom d-flex align-self-center">نرخ</p>
                                                                </div>
                                                            <span class="justify-content-center align-content-center">
                                                                <span class="mb-2 fs-custom me-5">{{ $airlineInformation['sumRates'] }}{!! renderUsdCurrency() !!}</span>
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="accordion-icon">
                                                                    <path d="M12 8.5V14.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                    <path d="M9 12.5L12 15.5L15 12.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                    <path d="M4 6C2.75 7.67 2 9.75 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2C10.57 2 9.2 2.3 7.97 2.85" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                </svg>
                                                            </span>
                                                            </div>



                                                            <table class="table-content" style="display: none; width: 100%;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="text-center"><strong>نرخ</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['rate'] }}{!! renderUsdCurrency() !!}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-center"><strong>sales commission</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['commissionRate'] }}{!! renderUsdCurrency() !!}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-center"><strong>INC</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['INC'] }}{!! renderUsdCurrency() !!}</td>
                                                                    </tr>

                                                                </tbody>
                                                            </table>


                                                            <!-- Sub-Accordion -->
                                                            <div class="custom-first-grade-accordion">
                                                                <div class="d-flex flex-column flex-md-row">
                                                                    <p class="m-0 fs-custom d-flex align-self-center">Other charges</p>
                                                                </div>
                                                                <span class="justify-content-center align-content-center">
                                                                    <span class="mb-2 fs-custom me-5">{{ $airlineInformation['SCC'] + $airlineInformation['MAA'] + $airlineInformation['CGC'] + $airlineInformation['AWC'] }}{!! renderUsdCurrency() !!}</span>
                                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="accordion-icon">
                                                                        <path d="M12 8.5V14.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                        <path d="M9 12.5L12 15.5L15 12.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                        <path d="M4 6C2.75 7.67 2 9.75 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2C10.57 2 9.2 2.3 7.97 2.85" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                    </svg>
                                                                </span>
                                                            </div>

                                                            <table class="table-content" style="display: none; width: 100%;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="text-center"><strong>SCC</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['SCC'] }}{!! renderUsdCurrency() !!}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-center"><strong>MAA</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['MAA'] }}{!! renderUsdCurrency() !!}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-center"><strong>CGC</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['CGC'] }}{!! renderUsdCurrency() !!}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-center"><strong>AWC</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['AWC'] }}{!! renderUsdCurrency() !!}</td>
                                                                    </tr>

                                                                </tbody>
                                                            </table>


                                                            <!-- Sub-Accordion -->
                                                            <div class="custom-first-grade-accordion">
                                                                <div class="d-flex flex-column flex-md-row">
                                                                    <p class="m-0 fs-custom d-flex align-self-center">مالیات</p>
                                                                </div>
                                                                <span class="justify-content-center align-content-center">
                                                                    <span class="mb-2 fs-custom me-5">{{ $airlineInformation['tax'] }}{!! renderUsdCurrency() !!}</span>
                                                                    <span style="display: inline-block; width: 24px; height: 24px;"></span>
                                                                </span>
                                                            </div>



                                                            @break

                                                        @case('Fly Dubai')

                                                            <!-- Sub-Accordion -->
                                                            <div class="custom-first-grade-accordion">
                                                                <div class="d-flex flex-column flex-md-row">
                                                                    <p class="m-0 fs-custom d-flex align-self-center">نرخ</p>
                                                                </div>
                                                                <span class="justify-content-center align-content-center">
                                                                <span class="mb-2 fs-custom me-5">{{ $airlineInformation['sumRates'] }}{!! renderUsdCurrency() !!}</span>
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="accordion-icon">
                                                                    <path d="M12 8.5V14.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                    <path d="M9 12.5L12 15.5L15 12.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                    <path d="M4 6C2.75 7.67 2 9.75 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2C10.57 2 9.2 2.3 7.97 2.85" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                </svg>
                                                            </span>
                                                            </div>

                                                            <table class="table-content" style="display: none; width: 100%;">
                                                                <tbody>

                                                                    <tr>
                                                                        <td class="text-center"><strong>نرخ</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['rate'] }}{!! renderUsdCurrency() !!}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class="text-center"><strong>sales commission</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['commissionRate'] }}{!! renderUsdCurrency() !!}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class="text-center"><strong>SCC</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['SCC'] }}{!! renderUsdCurrency() !!}</td>
                                                                    </tr>

                                                                </tbody>
                                                            </table>

                                                            <!-- Sub-Accordion -->
                                                            <div class="custom-first-grade-accordion">
                                                                <div class="d-flex flex-column flex-md-row">
                                                                    <p class="m-0 fs-custom d-flex align-self-center">Other charges</p>
                                                                </div>
                                                                <span class="justify-content-center align-content-center">
                                                                    <span class="mb-2 fs-custom me-5">{{ $airlineInformation['MAA'] + $airlineInformation['AWC'] }}{!! renderUsdCurrency() !!}</span>
                                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="accordion-icon">
                                                                        <path d="M12 8.5V14.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                        <path d="M9 12.5L12 15.5L15 12.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                        <path d="M4 6C2.75 7.67 2 9.75 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2C10.57 2 9.2 2.3 7.97 2.85" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                    </svg>
                                                                </span>
                                                            </div>

                                                            <table class="table-content" style="display: none; width: 100%;">
                                                                <tbody>

                                                                    <tr>

                                                                        <td class="text-center"><strong>MAA</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['MAA'] }}{!! renderUsdCurrency() !!}</td>

                                                                    </tr>

                                                                    <tr>

                                                                        <td class="text-center"><strong>AWC</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['AWC'] }}{!! renderUsdCurrency() !!}</td>

                                                                    </tr>

                                                                </tbody>
                                                            </table>


                                                            <!-- Sub-Accordion -->
                                                            <div class="custom-first-grade-accordion">
                                                                <div class="d-flex flex-column flex-md-row">
                                                                    <p class="m-0 fs-custom d-flex align-self-center">مالیات</p>
                                                                </div>
                                                                <span class="justify-content-center align-content-center">
                                                                    <span class="mb-2 fs-custom me-5">{{ $airlineInformation['tax'] }}{!! renderUsdCurrency() !!}</span>
                                                                    <span style="display: inline-block; width: 24px; height: 24px;"></span>
                                                                </span>
                                                            </div>


                                                            @break

                                                        @case('Air Arabia')

                                                            <!-- Sub-Accordion -->
                                                            <div class="custom-first-grade-accordion">
                                                                <div class="d-flex flex-column flex-md-row">
                                                                    <p class="m-0 fs-custom d-flex align-self-center">نرخ</p>
                                                                </div>
                                                                <span class="justify-content-center align-content-center">
                                                                <span class="mb-2 fs-custom me-5">{{ $airlineInformation['sumRates'] }}{!! renderUsdCurrency() !!}</span>
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="accordion-icon">
                                                                    <path d="M12 8.5V14.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                    <path d="M9 12.5L12 15.5L15 12.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                    <path d="M4 6C2.75 7.67 2 9.75 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2C10.57 2 9.2 2.3 7.97 2.85" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                </svg>
                                                            </span>
                                                            </div>

                                                            <table class="table-content" style="display: none; width: 100%;">
                                                                <tbody>

                                                                    <tr>
                                                                        <td class="text-center"><strong>نرخ</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['rate'] }}{!! renderUsdCurrency() !!}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class="text-center"><strong>sales commission</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['commissionRate'] }}{!! renderUsdCurrency() !!}</td>
                                                                    </tr>

                                                                </tbody>
                                                            </table>

                                                            <!-- Sub-Accordion -->
                                                            <div class="custom-first-grade-accordion">
                                                                <div class="d-flex flex-column flex-md-row">
                                                                    <p class="m-0 fs-custom d-flex align-self-center">Other charges</p>
                                                                </div>
                                                                <span class="justify-content-center align-content-center">
                                                                    <span class="mb-2 fs-custom me-5">{{ $airlineInformation['AWC'] + $airlineInformation['ATA'] }}{!! renderUsdCurrency() !!}</span>
                                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="accordion-icon">
                                                                        <path d="M12 8.5V14.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                        <path d="M9 12.5L12 15.5L15 12.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                        <path d="M4 6C2.75 7.67 2 9.75 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2C10.57 2 9.2 2.3 7.97 2.85" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                    </svg>
                                                                </span>
                                                            </div>

                                                            <table class="table-content" style="display: none; width: 100%;">
                                                                <tbody>

                                                                    <tr>

                                                                        <td class="text-center"><strong>AWC</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['AWC'] }}{!! renderUsdCurrency() !!}</td>

                                                                    </tr>
                                                                    <tr>

                                                                        <td class="text-center"><strong>ATA</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['ATA'] }}{!! renderUsdCurrency() !!}</td>

                                                                    </tr>

                                                                </tbody>
                                                            </table>



                                                            <!-- Sub-Accordion -->
                                                            <div class="custom-first-grade-accordion">
                                                                <div class="d-flex flex-column flex-md-row">
                                                                    <p class="m-0 fs-custom d-flex align-self-center">مالیات</p>
                                                                </div>
                                                                <span class="justify-content-center align-content-center">
                                                                    <span class="mb-2 fs-custom me-5">{{ $airlineInformation['tax'] }}{!! renderUsdCurrency() !!}</span>
                                                                    <span style="display: inline-block; width: 24px; height: 24px;"></span>
                                                                </span>
                                                            </div>


                                                            @break

                                                        @case('Emirates')

                                                            <!-- Sub-Accordion -->
                                                            <div class="custom-first-grade-accordion">
                                                                <div class="d-flex flex-column flex-md-row">
                                                                    <p class="m-0 fs-custom d-flex align-self-center">نرخ</p>
                                                                </div>
                                                                <span class="justify-content-center align-content-center">
                                                                <span class="mb-2 fs-custom me-5">{{ $airlineInformation['sumRates'] }}{!! renderUsdCurrency() !!}</span>
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="accordion-icon">
                                                                    <path d="M12 8.5V14.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                    <path d="M9 12.5L12 15.5L15 12.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                    <path d="M4 6C2.75 7.67 2 9.75 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2C10.57 2 9.2 2.3 7.97 2.85" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                </svg>
                                                            </span>
                                                            </div>


                                                            <table class="table-content" style="display: none; width: 100%;">
                                                                <tbody>

                                                                    <tr>
                                                                        <td class="text-center"><strong>نرخ</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['rate'] }}{!! renderUsdCurrency() !!}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class="text-center"><strong>sales commission</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['commissionRate'] }}{!! renderUsdCurrency() !!}</td>
                                                                    </tr>


                                                                    <tr>
                                                                        <td class="text-center"><strong>MYC</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['MYC'] }}{!! renderUsdCurrency() !!}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class="text-center"><strong>FEC</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['FEC'] }}{!! renderUsdCurrency() !!}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class="text-center"><strong>XDC</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['XDC'] }}{!! renderUsdCurrency() !!}</td>
                                                                    </tr>

                                                                </tbody>
                                                            </table>


                                                            <!-- Sub-Accordion -->
                                                            <div class="custom-first-grade-accordion">
                                                                <div class="d-flex flex-column flex-md-row">
                                                                    <p class="m-0 fs-custom d-flex align-self-center">Other charges</p>
                                                                </div>
                                                                <span class="justify-content-center align-content-center">
                                                                    <span class="mb-2 fs-custom me-5">{{ $airlineInformation['AWC'] + $airlineInformation['CGC'] + $airlineInformation['MCC'] }}{!! renderUsdCurrency() !!}</span>
                                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="accordion-icon">
                                                                        <path d="M12 8.5V14.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                        <path d="M9 12.5L12 15.5L15 12.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                        <path d="M4 6C2.75 7.67 2 9.75 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2C10.57 2 9.2 2.3 7.97 2.85" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                    </svg>
                                                                </span>
                                                            </div>

                                                            <table class="table-content" style="display: none; width: 100%;">
                                                                <tbody>

                                                                    <tr>

                                                                        <td class="text-center"><strong>AWC :</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['AWC'] }}{!! renderUsdCurrency() !!}</td>

                                                                    </tr>
                                                                    <tr>

                                                                        <td class="text-center"><strong>CGC :</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['CGC'] }}{!! renderUsdCurrency() !!}</td>

                                                                    </tr>
                                                                    <tr>

                                                                        <td class="text-center"><strong>MCC :</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['MCC'] }}{!! renderUsdCurrency() !!}</td>

                                                                    </tr>

                                                                </tbody>
                                                            </table>


                                                            <!-- Sub-Accordion -->
                                                            <div class="custom-first-grade-accordion">
                                                                <div class="d-flex flex-column flex-md-row">
                                                                    <p class="m-0 fs-custom d-flex align-self-center">مالیات</p>
                                                                </div>
                                                                <span class="justify-content-center align-content-center">
                                                                    <span class="mb-2 fs-custom me-5">{{ $airlineInformation['tax'] }}{!! renderUsdCurrency() !!}</span>
                                                                    <span style="display: inline-block; width: 24px; height: 24px;"></span>
                                                                </span>
                                                            </div>


                                                            @break

                                                        @case('Iran Air')

                                                            <!-- Sub-Accordion -->
                                                            <div class="custom-first-grade-accordion">
                                                                <div class="d-flex flex-column flex-md-row">
                                                                    <p class="m-0 fs-custom d-flex align-self-center">نرخ</p>
                                                                </div>
                                                                <span class="justify-content-center align-content-center">
                                                                <span class="mb-2 fs-custom me-5">{{ $airlineInformation['sumRates'] }}{!! renderIrrCurrency() !!}</span>
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="accordion-icon">
                                                                    <path d="M12 8.5V14.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                    <path d="M9 12.5L12 15.5L15 12.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                    <path d="M4 6C2.75 7.67 2 9.75 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2C10.57 2 9.2 2.3 7.97 2.85" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                </svg>
                                                            </span>
                                                            </div>


                                                            <table class="table-content" style="display: none; width: 100%;">
                                                                <tbody>

                                                                    <tr>
                                                                        <td class="text-center"><strong>نرخ</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['rate'] }}{!! renderIrrCurrency() !!}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class="text-center"><strong>sales commission</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['commissionRate'] }}{!! renderIrrCurrency() !!}</td>
                                                                    </tr>


                                                                </tbody>
                                                            </table>


                                                            <!-- Sub-Accordion -->
                                                            <div class="custom-first-grade-accordion">
                                                                <div class="d-flex flex-column flex-md-row">
                                                                    <p class="m-0 fs-custom d-flex align-self-center">Other charges</p>
                                                                </div>
                                                                <span class="justify-content-center align-content-center">
                                                                    <span class="mb-2 fs-custom me-5">{{ number_format( removeNumberFormat($airlineInformation['AWB']) + removeNumberFormat($airlineInformation['SCC']) ) }}{!! renderIrrCurrency() !!}</span>
                                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="accordion-icon">
                                                                        <path d="M12 8.5V14.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                        <path d="M9 12.5L12 15.5L15 12.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                        <path d="M4 6C2.75 7.67 2 9.75 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2C10.57 2 9.2 2.3 7.97 2.85" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                    </svg>
                                                                </span>
                                                            </div>

                                                            <table class="table-content" style="display: none; width: 100%;">
                                                                <tbody>

                                                                    <tr>

                                                                        <td class="text-center"><strong>AWB</strong></td>
                                                                        <td class="text-center">{{ 'AWC + AWA = '. $airlineInformation['AWB'] }}{!! renderIrrCurrency() !!}</td>

                                                                    </tr>
                                                                    <tr>

                                                                        <td class="text-center"><strong>SCC</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['SCC'] }}{!! renderIrrCurrency() !!}</td>

                                                                    </tr>


                                                                </tbody>
                                                            </table>


                                                            <!-- Sub-Accordion -->
                                                            <div class="custom-first-grade-accordion">
                                                                <div class="d-flex flex-column flex-md-row">
                                                                    <p class="m-0 fs-custom d-flex align-self-center">مالیات</p>
                                                                </div>
                                                                <span class="justify-content-center align-content-center">
                                                                    <span class="mb-2 fs-custom me-5">{{ $airlineInformation['tax'] }}{!! renderIrrCurrency() !!}</span>
                                                                    <span style="display: inline-block; width: 24px; height: 24px;"></span>
                                                                </span>
                                                            </div>


                                                            @break


                                                        @case('Qeshm Air')

                                                            <!-- Sub-Accordion -->
                                                            <div class="custom-first-grade-accordion">
                                                                <div class="d-flex flex-column flex-md-row">
                                                                    <p class="m-0 fs-custom d-flex align-self-center">نرخ</p>
                                                                </div>
                                                                <span class="justify-content-center align-content-center">
                                                                <span class="mb-2 fs-custom me-5">{{ $airlineInformation['sumRates'] }}{!! renderIrrCurrency() !!}</span>
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="accordion-icon">
                                                                    <path d="M12 8.5V14.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                    <path d="M9 12.5L12 15.5L15 12.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                    <path d="M4 6C2.75 7.67 2 9.75 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2C10.57 2 9.2 2.3 7.97 2.85" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                </svg>
                                                            </span>
                                                            </div>


                                                            <table class="table-content" style="display: none; width: 100%;">
                                                                <tbody>

                                                                    <tr>
                                                                        <td class="text-center"><strong>نرخ</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['rate'] }}{!! renderIrrCurrency() !!}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class="text-center"><strong>sales commission</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['commissionRate'] }}{!! renderIrrCurrency() !!}</td>
                                                                    </tr>

                                                                </tbody>
                                                            </table>

                                                            <!-- Sub-Accordion -->
                                                            <div class="custom-first-grade-accordion">
                                                                <div class="d-flex flex-column flex-md-row">
                                                                    <p class="m-0 fs-custom d-flex align-self-center">Other charges</p>
                                                                </div>
                                                                <span class="justify-content-center align-content-center">
                                                                    <span class="mb-2 fs-custom me-5">{{ number_format( removeNumberFormat($airlineInformation['AWC']) + removeNumberFormat($airlineInformation['SCC'] * $estimate->ROE ) + removeNumberFormat($airlineInformation['HXC'])) }}{!! renderIrrCurrency() !!}</span>
                                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="accordion-icon">
                                                                        <path d="M12 8.5V14.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                        <path d="M9 12.5L12 15.5L15 12.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                        <path d="M4 6C2.75 7.67 2 9.75 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2C10.57 2 9.2 2.3 7.97 2.85" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                    </svg>
                                                                </span>
                                                            </div>

                                                            <table class="table-content" style="display: none; width: 100%;">
                                                                <tbody>

                                                                    <tr>

                                                                        <td class="text-center"><strong>AWC</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['AWC'] }}{!! renderIrrCurrency() !!}</td>

                                                                    </tr>
                                                                    <tr>

                                                                        <td class="text-center"><strong>SCC</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['SCC'] }}{!! renderUsdCurrency() !!}</td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-center"><strong>HXC</strong></td>

                                                                        <td class="text-center">{{ $airlineInformation['HXC'] }}{!! renderIrrCurrency() !!}</td>
                                                                    </tr>

                                                                </tbody>
                                                            </table>

                                                            <!-- Sub-Accordion -->
                                                            <div class="custom-first-grade-accordion">
                                                                <div class="d-flex flex-column flex-md-row">
                                                                    <p class="m-0 fs-custom d-flex align-self-center">مالیات</p>
                                                                </div>
                                                                <span class="justify-content-center align-content-center">
                                                                    <span class="mb-2 fs-custom me-5">{{ $airlineInformation['tax'] }}{!! renderIrrCurrency() !!}</span>
                                                                    <span style="display: inline-block; width: 24px; height: 24px;"></span>
                                                                </span>
                                                            </div>


                                                            @break

                                                        @case('Mahan Air')

                                                            <!-- Sub-Accordion -->
                                                            <div class="custom-first-grade-accordion">
                                                                <div class="d-flex flex-column flex-md-row">
                                                                    <p class="m-0 fs-custom d-flex align-self-center">نرخ</p>
                                                                </div>
                                                                <span class="justify-content-center align-content-center">
                                                                <span class="mb-2 fs-custom me-5">{{ $airlineInformation['sumRates'] }}{!! renderIrrCurrency() !!}</span>
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="accordion-icon">
                                                                    <path d="M12 8.5V14.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                    <path d="M9 12.5L12 15.5L15 12.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                    <path d="M4 6C2.75 7.67 2 9.75 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2C10.57 2 9.2 2.3 7.97 2.85" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                </svg>
                                                            </span>
                                                            </div>


                                                            <table class="table-content" style="display: none; width: 100%;">
                                                                <tbody>

                                                                <tr>
                                                                    <td class="text-center"><strong>نرخ</strong></td>
                                                                    <td class="text-center">{{ $airlineInformation['rate'] }}{!! renderIrrCurrency() !!}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="text-center"><strong>sales commission</strong></td>
                                                                    <td class="text-center">{{ $airlineInformation['commissionRate'] }}{!! renderIrrCurrency() !!}</td>
                                                                </tr>


                                                                </tbody>
                                                            </table>


                                                            <!-- Sub-Accordion -->
                                                            <div class="custom-first-grade-accordion">
                                                                <div class="d-flex flex-column flex-md-row">
                                                                    <p class="m-0 fs-custom d-flex align-self-center">Other charges</p>
                                                                </div>
                                                                <span class="justify-content-center align-content-center">
                                                                    <span class="mb-2 fs-custom me-5">{{ number_format( removeNumberFormat($airlineInformation['AWC']) + removeNumberFormat($airlineInformation['SCC']) + removeNumberFormat($airlineInformation['ATA']) ) }}{!! renderIrrCurrency() !!}</span>
                                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="accordion-icon">
                                                                        <path d="M12 8.5V14.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                        <path d="M9 12.5L12 15.5L15 12.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                        <path d="M4 6C2.75 7.67 2 9.75 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2C10.57 2 9.2 2.3 7.97 2.85" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                    </svg>
                                                                </span>
                                                            </div>

                                                            <table class="table-content" style="display: none; width: 100%;">
                                                                <tbody>

                                                                    <tr>

                                                                        <td class="text-center"><strong>AWC</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['AWC'] }}{!! renderIrrCurrency() !!}</td>

                                                                    </tr>
                                                                    <tr>

                                                                        <td class="text-center"><strong>SCC</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['SCC'] }}{!! renderIrrCurrency() !!}</td>

                                                                    </tr>
                                                                    <tr>

                                                                        <td class="text-center"><strong>ATA</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['ATA'] }}{!! renderIrrCurrency() !!}</td>

                                                                    </tr>

                                                                </tbody>
                                                            </table>

                                                            <!-- Sub-Accordion -->
                                                            <div class="custom-first-grade-accordion">
                                                                <div class="d-flex flex-column flex-md-row">
                                                                    <p class="m-0 fs-custom d-flex align-self-center">مالیات</p>
                                                                </div>
                                                                <span class="justify-content-center align-content-center">
                                                                    <span class="mb-2 fs-custom me-5">{{ $airlineInformation['tax'] }}{!! renderIrrCurrency() !!}</span>
                                                                    <span style="display: inline-block; width: 24px; height: 24px;"></span>
                                                                </span>
                                                            </div>

                                                            @break


                                                        @case('Turkish')

                                                            <!-- Sub-Accordion -->
                                                            <div class="custom-first-grade-accordion">
                                                                <div class="d-flex flex-column flex-md-row">
                                                                    <p class="m-0 fs-custom d-flex align-self-center">نرخ</p>
                                                                </div>
                                                                <span class="justify-content-center align-content-center">
                                                                <span class="mb-2 fs-custom me-5">{{ $airlineInformation['sumRates'] }}{!! renderUsdCurrency() !!}</span>
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="accordion-icon">
                                                                    <path d="M12 8.5V14.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                    <path d="M9 12.5L12 15.5L15 12.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                    <path d="M4 6C2.75 7.67 2 9.75 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2C10.57 2 9.2 2.3 7.97 2.85" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                </svg>
                                                            </span>
                                                            </div>


                                                            <table class="table-content" style="display: none; width: 100%;">
                                                                <tbody>

                                                                    <tr>
                                                                        <td class="text-center"><strong>نرخ</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['rate'] }}{!! renderUsdCurrency() !!}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class="text-center"><strong>sales commission</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['commissionRate'] }}{!! renderUsdCurrency() !!}</td>
                                                                    </tr>

                                                                </tbody>
                                                            </table>


                                                            <!-- Sub-Accordion -->
                                                            <div class="custom-first-grade-accordion">
                                                                <div class="d-flex flex-column flex-md-row">
                                                                    <p class="m-0 fs-custom d-flex align-self-center">Other charges</p>
                                                                </div>
                                                                <span class="justify-content-center align-content-center">
                                                                    <span class="mb-2 fs-custom me-5">{{ $airlineInformation['AWC'] + $airlineInformation['CGC'] }}{!! renderUsdCurrency() !!}</span>
                                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="accordion-icon">
                                                                        <path d="M12 8.5V14.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                        <path d="M9 12.5L12 15.5L15 12.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                        <path d="M4 6C2.75 7.67 2 9.75 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2C10.57 2 9.2 2.3 7.97 2.85" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                    </svg>
                                                                </span>
                                                            </div>

                                                            <table class="table-content" style="display: none; width: 100%;">
                                                                <tbody>

                                                                    <tr>

                                                                        <td class="text-center"><strong>AWC :</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['AWC'] }}{!! renderUsdCurrency() !!}</td>

                                                                    </tr>
                                                                    <tr>

                                                                        <td class="text-center"><strong>CGC :</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['CGC'] }}{!! renderUsdCurrency() !!}</td>

                                                                    </tr>


                                                                </tbody>
                                                            </table>


                                                            <!-- Sub-Accordion -->
                                                            <div class="custom-first-grade-accordion">
                                                                <div class="d-flex flex-column flex-md-row">
                                                                    <p class="m-0 fs-custom d-flex align-self-center">مالیات</p>
                                                                </div>
                                                                <span class="justify-content-center align-content-center">
                                                                    <span class="mb-2 fs-custom me-5">{{ $airlineInformation['tax'] }}{!! renderUsdCurrency() !!}</span>
                                                                    <span style="display: inline-block; width: 24px; height: 24px;"></span>
                                                                </span>
                                                            </div>

                                                            @break


                                                        @case('Varesh')

                                                            <!-- Sub-Accordion -->
                                                            <div class="custom-first-grade-accordion">
                                                                <div class="d-flex flex-column flex-md-row">
                                                                    <p class="m-0 fs-custom d-flex align-self-center">نرخ</p>
                                                                </div>
                                                                <span class="justify-content-center align-content-center">
                                                                <span class="mb-2 fs-custom me-5">{{ $airlineInformation['sumRates'] }}{!! renderIrrCurrency() !!}</span>
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="accordion-icon">
                                                                    <path d="M12 8.5V14.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                    <path d="M9 12.5L12 15.5L15 12.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                    <path d="M4 6C2.75 7.67 2 9.75 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2C10.57 2 9.2 2.3 7.97 2.85" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                </svg>
                                                            </span>
                                                            </div>


                                                            <table class="table-content" style="display: none; width: 100%;">
                                                                <tbody>

                                                                    <tr>
                                                                        <td class="text-center"><strong>نرخ</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['rate'] }}{!! renderIrrCurrency() !!}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class="text-center"><strong>sales commission</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['commissionRate'] }}{!! renderIrrCurrency() !!}</td>
                                                                    </tr>


                                                                </tbody>
                                                            </table>


                                                            <!-- Sub-Accordion -->
                                                            <div class="custom-first-grade-accordion">
                                                                <div class="d-flex flex-column flex-md-row">
                                                                    <p class="m-0 fs-custom d-flex align-self-center">Other charges</p>
                                                                </div>
                                                                <span class="justify-content-center align-content-center">
                                                                    <span class="mb-2 fs-custom me-5">{{ $airlineInformation['AWA'] }}{!! renderIrrCurrency() !!}</span>
                                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="accordion-icon">
                                                                        <path d="M12 8.5V14.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                        <path d="M9 12.5L12 15.5L15 12.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                        <path d="M4 6C2.75 7.67 2 9.75 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2C10.57 2 9.2 2.3 7.97 2.85" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                    </svg>
                                                                </span>
                                                            </div>

                                                            <table class="table-content" style="display: none; width: 100%;">
                                                                <tbody>

                                                                    <tr>

                                                                        <td class="text-center"><strong>AWA :</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['AWA'] }}{!! renderIrrCurrency() !!}</td>

                                                                    </tr>

                                                                </tbody>
                                                            </table>


                                                            <!-- Sub-Accordion -->
                                                            <div class="custom-first-grade-accordion">
                                                                <div class="d-flex flex-column flex-md-row">
                                                                    <p class="m-0 fs-custom d-flex align-self-center">مالیات</p>
                                                                </div>
                                                                <span class="justify-content-center align-content-center">
                                                                    <span class="mb-2 fs-custom me-5">{{ $airlineInformation['tax'] }}{!! renderIrrCurrency() !!}</span>
                                                                    <span style="display: inline-block; width: 24px; height: 24px;"></span>
                                                                </span>
                                                            </div>


                                                            @break

                                                        @case('Aeroflot')

                                                            <!-- Sub-Accordion -->
                                                            <div class="custom-first-grade-accordion">
                                                                <div class="d-flex flex-column flex-md-row">
                                                                    <p class="m-0 fs-custom d-flex align-self-center">نرخ</p>
                                                                </div>
                                                                <span class="justify-content-center align-content-center">
                                                                <span class="mb-2 fs-custom me-5">{{ $airlineInformation['sumRates'] }}{!! renderUsdCurrency() !!}</span>
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="accordion-icon">
                                                                    <path d="M12 8.5V14.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                    <path d="M9 12.5L12 15.5L15 12.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                    <path d="M4 6C2.75 7.67 2 9.75 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2C10.57 2 9.2 2.3 7.97 2.85" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                </svg>
                                                            </span>
                                                            </div>


                                                            <table class="table-content" style="display: none; width: 100%;">
                                                                <tbody>

                                                                    <tr>
                                                                        <td class="text-center"><strong>نرخ</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['rate'] }}{!! renderUsdCurrency() !!}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class="text-center"><strong>sales commission</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['commissionRate'] }}{!! renderUsdCurrency() !!}</td>
                                                                    </tr>

                                                                </tbody>
                                                            </table>


                                                            <!-- Sub-Accordion -->
                                                            <div class="custom-first-grade-accordion">
                                                                <div class="d-flex flex-column flex-md-row">
                                                                    <p class="m-0 fs-custom d-flex align-self-center">Other charges</p>
                                                                </div>
                                                                <span class="justify-content-center align-content-center">
                                                                    <span class="mb-2 fs-custom me-5">{{ $airlineInformation['AWC'] + $airlineInformation['BFC'] + $airlineInformation['MAC'] }}{!! renderUsdCurrency() !!}</span>
                                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="accordion-icon">
                                                                        <path d="M12 8.5V14.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                        <path d="M9 12.5L12 15.5L15 12.5" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                        <path d="M4 6C2.75 7.67 2 9.75 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2C10.57 2 9.2 2.3 7.97 2.85" stroke="#0571B3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                    </svg>
                                                                </span>
                                                            </div>

                                                            <table class="table-content" style="display: none; width: 100%;">
                                                                <tbody>

                                                                    <tr>

                                                                        <td class="text-center"><strong>AWC :</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['AWC'] }}{!! renderUsdCurrency() !!}</td>

                                                                    </tr>
                                                                    <tr>

                                                                        <td class="text-center"><strong>BFC :</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['BFC'] }}{!! renderUsdCurrency() !!}</td>

                                                                    </tr>
                                                                    <tr>

                                                                        <td class="text-center"><strong>MAC :</strong></td>
                                                                        <td class="text-center">{{ $airlineInformation['MAC'] }}{!! renderUsdCurrency() !!}</td>

                                                                    </tr>

                                                                </tbody>
                                                            </table>



                                                            <!-- Sub-Accordion -->
                                                            <div class="custom-first-grade-accordion">
                                                                <div class="d-flex flex-column flex-md-row">
                                                                    <p class="m-0 fs-custom d-flex align-self-center">مالیات</p>
                                                                </div>
                                                                <span class="justify-content-center align-content-center">
                                                                    <span class="mb-2 fs-custom me-5">{{ $airlineInformation['tax'] }}{!! renderUsdCurrency() !!}</span>
                                                                    <span style="display: inline-block; width: 24px; height: 24px;"></span>
                                                                </span>
                                                            </div>


                                                            @break

                                                        @endswitch


                                                @endif

                                            </div>

                                        </div>

                                    @endforeach
                                </div>

                        </div>
                </div>

                <span class="text-theme-default fs-4 fw-bold pb-4">مشتری مدنظر خود را انتخاب و یا وارد کنید</span>

                <div class="pt-4">
                  <hr class="hr">
                </div>

                <div class="col-6 row">

                    <!-- User Exist -->
                    <div id="user-exist" class="col-12 mb-4 mt-4" style="{{ @$user_id ? 'display: none;' : '' }}">
                        <h6 class="mb-4"><b>مشتری موجود است :</b></h6>
                        <div class="m-t-15 m-checkbox-inline custom-radio-ml">
                            <div class="form-check form-check-inline radio radio-primary">
                                <input id="user-yes" class="form-check-input" type="radio" name="user_exist" value="yes" {{ old('user_exist', 'yes') == 'yes' ? 'checked' : '' }}>
                                <label class="form-check-label mb-0" for="user-yes"><span class="digits">بله</span></label>
                            </div>
                            <div class="form-check form-check-inline radio radio-primary">
                                <input id="user-no" class="form-check-input" type="radio" name="user_exist" value="no" {{ old('user_exist') == 'no' ? 'checked' : '' }}>
                                <label class="form-check-label mb-0" for="user-no"><span class="digits">خیر</span></label>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-6 row">

                    <!-- User List -->
                    <div id="users-list"  class="col-12" style="display: block">
                        <h6 class="mb-4"><b>برای مشتری :</b></h6>
                            @if (@$user_id)
                            <select class="js-example-basic-single col-sm-12" name="user_id" data-placeholder="مشتری">

                                <option value="{{ $user->id }}" selected>
                                {{ $user?->lastname . ' ' . $user?->mobile ?? '-' }}
                                </option>
                            </select>
                            @else
                            <select class="js-example-basic-single col-sm-12" name="user_id" data-placeholder="مشتری">

                                <option value="" {{ old('user_id') == '' ? 'selected' : '' }}>یک گزینه انتخاب کنید</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user?->lastname . ' ' . $user?->mobile ?? '-' }}
                                    </option>
                                @endforeach
                            </select>

                        @endif

                        @error('user_id')
                        <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror

                    </div>

                </div>

                <div class="col-6 row">
                    <!-- Create User -->
                    <div id="create-user" class="col-12 mb-3 mt-3" style="display: none">
                        <div class="row">
                            <div class="col-6 mt-3">
                                <h6 class="mb-4"><b>نام :</b></h6>
                                <input class="form-control" name="name" type="text" placeholder="..." value="{{ old('name') }}">
                                @error('name')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-6 mt-3">
                                <h6 class="mb-4"><b>نام خانوادگی :</b></h6>
                                <input class="form-control" name="lastname" type="text" placeholder="..." value="{{ old('lastname') }}">
                                @error('lastname')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-6 mt-3">
                                <h6 class="mb-4"><b>شماره موبایل :</b></h6>
                                <input class="form-control" name="mobile" type="text" placeholder="..." value="{{ old('mobile') }}">
                                @error('mobile')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-6 row">

                    <!-- Partner Exist -->
                    <div id="partners-exist" class="col-12 mb-4 mt-4">
                        <h6 class="mb-4"><b>بازاریاب دارد :</b></h6>
                        <div class="m-t-15 m-checkbox-inline custom-radio-ml">
                            <div class="form-check form-check-inline radio radio-primary">
                                <input id="partner-yes" class="form-check-input" type="radio" name="partner_exist" value="yes" {{ old('partner_exist') == 'yes' ? 'checked' : '' }}>
                                <label class="form-check-label mb-0" for="partner-yes"><span class="digits">بله</span></label>
                            </div>
                            <div class="form-check form-check-inline radio radio-primary">
                                <input id="partner-no" class="form-check-input" type="radio" name="partner_exist" value="no" {{ old('partner_exist', 'no') == 'no' ? 'checked' : '' }}>
                                <label class="form-check-label mb-0" for="partner-no"><span class="digits">خیر</span></label>
                            </div>
                        </div>
                    </div>

                    <!-- Partner List -->
                    <div  id="partners-list" class="col-12 mb-3 mt-3" style="display: none">
                        <select class="js-example-basic-single col-sm-12" name="partners[]" data-placeholder="مشتری">

                                <option value="" selected>یک گزینه انتخاب کنید</option>
                                @foreach($partners as $user)
                                    <option value="{{ $user->id }}" {{ (is_array(old('partners')) && in_array($user->id, old('partners'))) ? 'selected' : '' }}>
                                        {{ $user?->lastname . ' ' . $user?->mobile ?? '-' }}
                                    </option>
                                @endforeach
                        </select>

                    </div>


                    <div class="col-12">
                        <div class="fast-estimate-btn d-flex justify-content-start">
                            <button class="btn header-btn-user" type="submit">ثبت نهایی تخمین
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M12 21C13.1819 21 14.3522 20.7672 15.4442 20.3149C16.5361 19.8626 17.5282 19.1997 18.364 18.364C19.1997 17.5282 19.8626 16.5361 20.3149 15.4442C20.7672 14.3522 21 13.1819 21 12C21 10.8181 20.7672 9.64778 20.3149 8.55585C19.8626 7.46392 19.1997 6.47177 18.364 5.63604C17.5282 4.80031 16.5361 4.13738 15.4442 3.68508C14.3522 3.23279 13.1819 3 12 3C9.61305 3 7.32387 3.94821 5.63604 5.63604C3.94821 7.32387 3 9.61305 3 12C3 14.3869 3.94821 16.6761 5.63604 18.364C7.32387 20.0518 9.61305 21 12 21ZM11.768 15.64L16.768 9.64L15.232 8.36L10.932 13.519L8.707 11.293L7.293 12.707L10.293 15.707L11.067 16.481L11.768 15.64Z"
                                          fill="white"/>
                                </svg>

                            </button>
                            <button class="btn header-btn-price" type="button" >لغو</button>
                        </div>
                    </div>
                </div>
        @endforeach

    </form>
</div>

@endsection

@section('script')

    <script>

        let userID = @json(@$user_id);
        let partnerExist = @json(old('partner_exist'));
        let userExist = @json(old('user_exist'));

        $(document).ready(function () {

            $('#partner-list').show();

            $('#user-exist' + ' input[name="user_exist"]').on('change', function () {
                if ($(this).val() === 'yes') {
                    $('#create-user').hide();
                    $('#users-list').show();
                } else {
                    $('#create-user').show();
                    $('#users-list').hide();
                }
            });

            if (userExist === 'no') {
                $('#create-user').show();
                $('#users-list').hide();
            }


            $('#partners-exist' + ' input[name="partner_exist"]').on('change', function () {

                let status = $(this).val();
                if (status === 'yes') {

                    $('#partners-list').show();

                } else {
                    $('#partners-list').hide();

                }
            });

            if (partnerExist === 'yes')
                $('#partners-list').show();

            if (userID) {
                $('#create-user').hide();
                $('#users-list').show();
            }


            $('.fast-estimate-radio-box svg, .custom-first-grade-accordion svg').on('click', function(e) {
                e.preventDefault();
                const $parentElement = $(this).closest('.fast-estimate-radio-box, .custom-first-grade-accordion');
                const $targetContent = $parentElement.next();

                if ($targetContent.length) {
                    const isVisible = $targetContent.css('display') === 'table';
                    const $siblings = $parentElement.parent().find('.custom-accordion-container, .table-content');
                    $siblings.each(function() {
                        $(this).css('display', 'none');
                        const $siblingSvg = $(this).prev().find('.accordion-icon');
                        if ($siblingSvg.length) $siblingSvg.removeClass('open');
                        if ($(this).prev().hasClass('fast-estimate-radio-box')) {
                            $(this).prev().css('border-radius', '20px');
                        }
                    });
                    $targetContent.css('display', isVisible ? 'none' : 'table');
                    $(this).toggleClass('open', !isVisible);
                    if ($parentElement.hasClass('fast-estimate-radio-box')) {
                        $parentElement.css('border-radius', isVisible ? '20px' : '20px 20px 0px 0px');
                    }
                }
            });


        });



    </script>

@endsection



