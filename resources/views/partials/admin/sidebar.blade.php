
<!-- Page Sidebar Start-->
<div class="sidebar-wrapper">
    <div>

        <div class="logo-wrapper">
            <a class="w-100 h-auto" href="{{ route('admin.dashboard') }}">
                <img class="w-100 h-auto px-2" src="{{ asset('panel/assets/images/logo/logo.webp') }}" alt=""
                     width="100%" height="100%">
            </a>
            <div class="back-btn"><i class="fa fa-angle-right"></i></div>
        </div>

        <div class="logo-icon-wrapper">
            <a href="{{ route('admin.dashboard') }}">
                <img class="img-fluid" src="" alt="">
            </a>
        </div>

        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>

            <div id="sidebar-menu">

                <ul class="sidebar-links" id="simple-bar">

                    <li class="back-btn">
                        <a href="{{ route('admin.dashboard') }}">
                            <img class="img-fluid" src="#" alt=""></a>
                        <div class="mobile-back text-end"><span>بازگشت</span>
                            <i class="fa fa-angle-left ps-2" aria-hidden="true">

                            </i>
                        </div>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav {{ isActive('admin/dashboard') }}"
                           href="{{ route('admin.dashboard') }}">
                            <i data-feather="home"></i>
                            <span>صفحه اصلی </span>
                        </a>
                    </li>

                    @permission('orders')
                    <li class="sidebar-list">
                        <a class="nav-link {{isActive('admin/orders')}}" href="{{ route('orders.index') }}">
                          لیست سفارش ها
                        </a>
                    </li>
                    @endpermission


                    @permission('estimates')
                    <li class="sidebar-list">
                        <a class="nav-link {{ isActive('admin/estimate/index') }}" href="{{ route('estimate.index') }}">لیست تخمین ها</a>
                    </li>
                    @endpermission


                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <span>مدیریت واحد ها</span>
                        </a>
                        <ul class="sidebar-submenu">

                            <li>
                                <a class="nav-link" href="{{ route('units.create') }}">افزودن واحد</a>
                            </li>
                            <li>
                                <a class="nav-link" href="{{ route('units.index') }}">لیست واحد ها</a>
                            </li>
                        </ul>
                    </li>


                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <span>مدیریت کارمندان</span>
                        </a>
                        <ul class="sidebar-submenu">
                            @permission('permissions')
                            <li>
                                <a class="submenu-title" href="#">
                                    <span>مدیریت دسترسی ها</span>
                                    <span class="sub-arrow"><i class="fa fa-angle-left"></i></span>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    <li>
                                        <a class="nav-link" href="{{ route('permissions.index') }}">مجوز ها</a>
                                    </li>
                                    @permission('add permission')
                                    <li>
                                        <a class="nav-link" href="{{ route('permissions.create') }}">مجوز جدید</a>
                                    </li>
                                    @endpermission

                                    @permission('roles')
                                    <li>
                                        <a class="nav-link" href="{{ route('roles.index') }}">نقش ها</a>
                                    </li>
                                    @endpermission

                                    @permission('add role')
                                    <li>
                                        <a class="nav-link" href="{{ route('roles.create') }}">نفش جدید</a>
                                    </li>
                                    @endpermission
                                </ul>
                            </li>
                            @endpermission

                            <li>
                                <a class="submenu-title" href="#">
                                    <span>مدیریت کارمندان</span>
                                    <span class="sub-arrow"><i class="fa fa-angle-left"></i></span>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    <li>
                                        <a class="nav-link" href="{{ route('employees.create') }}">افزودن کارمند جدید</a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="{{ route('employees.index') }}">لیست کارمندان</a>
                                    </li>
                                </ul>
                            </li>

                            @permission('request-managements')
                            <li>
                                <a class="submenu-title" href="#">
                                    <span>مدیریت درخواست ها</span>
                                    <span class="sub-arrow"><i class="fa fa-angle-left"></i></span>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    @permission('add request-management')
                                    <li><a class="nav-link disabled" href="{{ route('request-management.create') }}">افزودن
                                            درخواست</a></li>
                                    @endpermission
                                    <li>
                                        <a class="nav-link" href="{{ route('request-management.index') }}">لیست درخواست های مشتری</a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="{{ route('request-management.admin-requests-index') }}">لیست درخواست های مدیر</a>
                                    </li>
                                </ul>
                            </li>
                            @endpermission

                            @permission('text-templates')
                            <li>
                                <a class="submenu-title" href="#">
                                    <span> پیام های درون سیستمی</span>
                                    <span class="sub-arrow"><i class="fa fa-angle-left"></i></span>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    @permission('add text-templates')
                                    <li>
                                        <a class="nav-link" href="{{ route('text-templates.create') }}">افزودن الگو متنی</a>
                                    </li>
                                    @endpermission
                                    <li>
                                        <a class="nav-link" href="{{ route('text-templates.index') }}">لیست الگوهای متنی</a>
                                    </li>

                                    <li>
                                        <a class="nav-link disabled" href="#">ارسال پیام</a>
                                    </li>

                                    <li>
                                        <a class="nav-link disabled" href="#" disabled>لیست پیام های ارسالی</a>
                                    </li>
                                </ul>
                            </li>
                            @endpermission
                        </ul>
                    </li>




                    {{--                    --}}
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <span>مدیریت فروش</span>
                        </a>
                        <ul class="sidebar-submenu">

                            @permission('sales-teams')
                            <li>
                                <a class="submenu-title" href="#">
                                    <span>مدیریت تیم فروش</span>
                                    <span class="sub-arrow"><i class="fa fa-angle-left"></i></span>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    @permission('add sales-team')
                                    <li>
                                        <a class="nav-link" href="{{ route('sales-team.create') }}">افزودن تیم فروش</a>
                                    </li>
                                    @endpermission
                                    <li>
                                        <a class="nav-link" href="{{ route('sales-team.index') }}">لیست تیم های فروش</a>
                                    </li>
                                </ul>
                            </li>
                            @endpermission

                            @permission('airlines')
                            <li>
                                <a class="submenu-title" href="#">
                                    <span>مدیریت ایرلاین ها</span>
                                    <span class="sub-arrow"><i class="fa fa-angle-left"></i></span>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    @permission('add airline')
                                    <li><a class="nav-link" href="{{ route('airlines.create') }}">افزودن ایرلاین</a></li>
                                    @endpermission
                                    <li>
                                        <a class="nav-link" href="{{ route('airlines.index') }}">لیست ایرلاین ها</a>
                                    </li>
                                </ul>
                            </li>
                            @endpermission

                            @permission('rejection-messages')
                            <li>
                                <a class="submenu-title" href="#">
                                    <span>مدیریت دلایل شکست</span>
                                    <span class="sub-arrow"><i class="fa fa-angle-left"></i></span>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    @permission('add rejection-messages')
                                    <li><a class="nav-link" href="{{ route('rejection-messages.create') }}">افزودن دلیل شکست</a></li>
                                    @endpermission
                                    <li>
                                        <a class="nav-link" href="{{ route('rejection-messages.index') }}">لیست دلایل شکست</a>
                                    </li>
                                </ul>
                            </li>
                            @endpermission
                        </ul>
                    </li>


                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <span>گمرک</span>
                        </a>
                        <ul class="sidebar-submenu">

                            <li class="sidebar-list">
                                <a class="nav-link active text-dark" href="{{ route('customs_costs.index') }}">
                                    ثبت هزینه های گمرکی
                                </a>
                            </li>

                        </ul>
                    </li>


                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <span>انبارداری</span>
                        </a>
                        <ul class="sidebar-submenu">

                            <li class="sidebar-list">
                                <a class="nav-link active text-dark" href="{{ route('warehouse_costs.index') }}">
                                    ثبت هزینه های انبار
                                </a>
                            </li>


                            @permission('consumables')
                            <li>
                                <a class="submenu-title" href="#">
                                    <span>مدیریت ادوات مصرفی</span>
                                    <span class="sub-arrow"><i class="fa fa-angle-left"></i></span>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    @permission('add consumables')
                                    <li><a class="nav-link" href="{{ route('consumables.create') }}">افزودن ادوات مصرفی</a></li>
                                    @endpermission
                                    <li>
                                        <a class="nav-link" href="{{ route('consumables.index') }}">لیست ادوات مصرفی</a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="{{ route('consumables.consumables_number_limit') }}">لیست محدودیت ادوات مصرفی</a>
                                    </li>
                                </ul>
                            </li>
                            @endpermission

                            <li>
                                <a class="submenu-title" href="#">
                                    <span>مدیریت انبار ها</span>
                                    <span class="sub-arrow"><i class="fa fa-angle-left"></i></span>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    @if(Auth::user()->hasPermission('add warehouse'))
                                        <li>
                                            <a class="nav-link" href="{{ route('warehousing.create') }}">افزودن انبار جدید</a>
                                        </li>
                                    @endif
                                    <li>
                                        <a class="nav-link" href="{{ route('warehousing.index') }}">لیست انبارها</a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a class="submenu-title" href="#">
                                    <span>مدیریت ناحیه ها</span>
                                    <span class="sub-arrow"><i class="fa fa-angle-left"></i></span>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    <li>
                                        <a class="nav-link" href="{{ route('regions.create') }}">افزودن ناحیه</a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="{{ route('regions.index') }}">لیست ناحیه ها</a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a class="submenu-title" href="#">
                                    <span>مدیریت نوع ناحیه</span>
                                    <span class="sub-arrow"><i class="fa fa-angle-left"></i></span>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    <li>
                                        <a class="nav-link" href="{{ route('region-types.create') }}">افزودن نوع ناحیه</a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="{{ route('region-types.index') }}">لیست نوع های ناحیه</a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a class="submenu-title" href="#">
                                    <span>مدیریت واحد نجاری</span>
                                    <span class="sub-arrow"><i class="fa fa-angle-left"></i></span>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    @if(Auth::user()->hasPermission('box price calculation'))
                                        <li>
                                            <a class="nav-link" href="{{ route('box.price_calculation') }}"> محاسبه قیمت جعبه چوب</a>
                                        </li>
                                    @endif

                                    @if(Auth::user()->hasPermission('box price calculation value management'))
                                        <li>
                                            <a class="nav-link" href="{{ route('box.value_management') }}"> مدیریت مقادیر </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        </ul>
                    </li>




                    {{--                    --}}
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <span> مدیریت تیم جمع آوری</span>
                        </a>

                        <ul class="sidebar-submenu">

                            <li class="sidebar-list">
                                <a class="nav-link active text-dark" href="{{ route('collection_costs.index') }}">
                                    ثبت هزینه های جمع آوری
                                </a>
                            </li>

                            <li>
                                <a class="submenu-title" href="#">
                                    <span>مدیریت تایم ماموران جمع آوری</span>
                                    <span class="sub-arrow"><i class="fa fa-angle-left"></i></span>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    <li><a class="nav-link" href="{{ route('collection-agent-timelines.create') }}">افزودن</a></li>
                                    <li><a class="nav-link" href="{{ route('collection-agent-timelines.index') }}">لیست</a></li>
                                </ul>
                            </li>

                            <li class="sidebar-list">
                                <a class="sidebar-link sidebar-title link-nav {{ isActive('admin/dashboard') }}"
                                   href="{{ route('collection_agents_dashboard.dashboard') }}">
                                    <span>پنل تیم جمع آوری</span>
                                </a>
                            </li>

                            <li>
                                <a class="submenu-title" href="#">
                                    <span>درخواست های جمع آوری</span>
                                    <span class="sub-arrow"><i class="fa fa-angle-left"></i></span>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    <li><a class="nav-link" href="{{ route('collection-agent-requests.index') }}">لیست درخواست ها</a></li>
                                </ul>
                            </li>

                            <li>
                                <a class="submenu-title" href="#">
                                    <span>مدیریت ماموران جمع آوری</span>
                                    <span class="sub-arrow"><i class="fa fa-angle-left"></i></span>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    <li><a class="nav-link" href="{{ route('collection-agents.index') }}">لیست مامور ها</a></li>

                                    <li><a class="nav-link" href="{{ route('collection-agent-types.create') }}">افزودن نوع</a></li>
                                    <li><a class="nav-link" href="{{ route('collection-agent-types.index') }}">لیست نوع ها</a></li>
                                </ul>
                            </li>


                            <li>
                                <a class="submenu-title" href="#">
                                    <span>مدیریت ماشین ها</span>
                                    <span class="sub-arrow"><i class="fa fa-angle-left"></i></span>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    <li><a class="nav-link" href="{{ route('vehicles.create') }}">افزودن ماشین</a></li>
                                    <li><a class="nav-link" href="{{ route('vehicles.index') }}">لیست ماشین ها</a></li>
                                </ul>
                            </li>
                            <li>
                                <a class="submenu-title" href="#">
                                    <span>مدیریت نوع ماشین ها</span>
                                    <span class="sub-arrow"><i class="fa fa-angle-left"></i></span>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    <li><a class="nav-link" href="{{ route('vehicle-types.create') }}">افزودن نوع</a></li>
                                    <li><a class="nav-link" href="{{ route('vehicle-types.index') }}">لیست نوع ها</a></li>
                                </ul>
                            </li>

                        </ul>
                    </li>






                    {{--                    --}}
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <span> مدیریت مشتریان</span>
                        </a>
                        <ul class="sidebar-submenu">
                            @permission('user-credits')
                            <li>
                                <a class="submenu-title" href="#">
                                    <span>مدیریت اعتبار مشتری</span>
                                    <span class="sub-arrow"><i class="fa fa-angle-left"></i></span>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    @permission('add user-credit')
                                    <li>
                                        <a class="nav-link" href="{{ route('user-credits.create') }}">افزودن اعتبار</a>
                                    </li>
                                    @endpermission
                                    <li>
                                        <a class="nav-link" href="{{ route('user-credits.index') }}">لیست اعتبارها</a>
                                    </li>
                                </ul>
                            </li>
                            @endpermission

                            @permission('users')
                            <li>
                                <a class="submenu-title" href="#">
                                    <span>مدیریت مشتریان</span>
                                    <span class="sub-arrow"><i class="fa fa-angle-left"></i></span>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    <li><a class="nav-link" href="{{ route('users.index') }}">لیست مشتریان</a></li>
                                </ul>
                            </li>
                            @endpermission
                        </ul>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <span>مدیریت مالی</span>
                        </a>

                        <ul class="sidebar-submenu">

                            <li>
                                <a class="submenu-title" href="#">
                                    <span>مدیریت فاکتور مشتریان</span>
                                    <span class="sub-arrow"><i class="fa fa-angle-left"></i></span>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    <li>
                                        <a class="nav-link" href="{{ route('customer-invoices.create') }}">افزودن</a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="{{ route('customer-invoices.index') }}">لیست</a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a class="submenu-title" href="#">
                                    <span>مدیریت بسته بندی</span>
                                    <span class="sub-arrow"><i class="fa fa-angle-left"></i></span>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    <li>
                                        <a class="nav-link" href="{{ route('packaging-managements.create') }}">افزودن مدیریت بسته بندی</a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="{{ route('packaging-managements.index') }}">لیست مدیریت بسته بندی ها</a>
                                    </li>
                                </ul>
                            </li>


                            <li>
                                <a class="submenu-title" href="#">
                                    <span>حساب های فاکتور</span>
                                    <span class="sub-arrow"><i class="fa fa-angle-left"></i></span>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    <li>
                                        <a class="nav-link" href="{{ route('invoice-accounts.create') }}">افزودن حساب های فاکتور</a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="{{ route('invoice-accounts.index') }}">لیست حساب های فاکتور</a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a class="submenu-title" href="#">
                                    <span>هزینه تشریفات گمرکی</span>
                                    <span class="sub-arrow"><i class="fa fa-angle-left"></i></span>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    <li>
                                        <a class="nav-link" href="{{ route('customs-formalities-fees.create') }}">افزودن</a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="{{ route('customs-formalities-fees.index') }}">لیست</a>
                                    </li>
                                </ul>
                            </li>


                            <li>
                                <a class="submenu-title" href="#">
                                    <span>شرح هزینه های فاکتور</span>
                                    <span class="sub-arrow"><i class="fa fa-angle-left"></i></span>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    <li>
                                        <a class="nav-link" href="{{ route('price-details.create') }}">افزودن شرح هزینه فاکتور</a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="{{ route('price-details.index') }}">لیست شرح هزینه های فاکتور</a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a class="submenu-title" href="#">
                                    <span>مدیریت مصرف واحدها</span>
                                    <span class="sub-arrow"><i class="fa fa-angle-left"></i></span>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    <li>
                                        <a class="nav-link" href="{{ route('units-consumption.create') }}">افزودن مصرف واحد ها</a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="{{ route('units-consumption.index') }}">لیست مصرف واحد ها</a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a class="submenu-title" href="#">
                                    <span>مدیریت قیمت فروش</span>
                                    <span class="sub-arrow"><i class="fa fa-angle-left"></i></span>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    <li>
                                        <a class="nav-link" href="{{ route('enter-sale-prices.create') }}">افزودن قیمت فروش</a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="{{ route('enter-sale-prices.index') }}">لیست قیمت فروش</a>
                                    </li>
                                </ul>
                            </li>


                            <li>
                                <a class="submenu-title" href="#">حساب های رسمی
                                    <span class="sub-arrow"><i class="fa fa-angle-left"></i></span>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    <?php
                                        use App\Models\Airline;
                                        $sidebarAirlines = Airline::query()
                                            ->select(['id', 'name'])
                                            ->get();
                                    ?>
                                    @foreach($sidebarAirlines as $sidebarAirline)
                                        <li>
                                            <a class="nav-link {{$sidebarAirline->name != 'Mahan Air' ? 'disabled' : ''}}" href="{{ route('airline-sales.index', ['airlineId' => $sidebarAirline->id]) }}">{{ \App\Models\Airline::$airlineTranslations[$sidebarAirline->name] }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>

                            <li>
                                <a class="submenu-title" href="#">حساب های غیر رسمی
                                    <span class="sub-arrow">
                                            <i class="fa fa-angle-left"></i>
                                    </span>
                                </a>

                            </li>
                        </ul>
                    </li>



                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="#">
                            <i data-feather="settings"></i>
                            <span>تنظیمات</span>
                        </a>
                        <ul class="sidebar-submenu">

                            <li class="sidebar-list">
                                <a class="sidebar-link sidebar-title link-nav"
                                   href="{{ route('settings.create-roe') }}">
                                    <span>بروزرسانی نرخ ها</span>
                                </a>
                            </li>

                            @permission('imports')
                            <li>
                                <a class="sidebar-link sidebar-title link-nav" href="{{ route('excel.import.view') }}">
                                    <span>بارگذاری فایل های اکسل</span>
                                </a>
                            </li>
                            @endpermission

                            <li>
                                <a class="submenu-title" href="#">
                                    <span>مدیریت ماهیت کالا</span>
                                    <span class="sub-arrow"><i class="fa fa-angle-left"></i></span>
                                </a>
                                <ul class="nav-sub-childmenu submenu-content">
                                    <li><a class="nav-link" href="{{ route('natures.create') }}">افزودن ماهیت</a></li>
                                    <li><a class="nav-link" href="{{ route('natures.index') }}">لیست ماهیت ها</a></li>
                                </ul>
                            </li>

                        </ul>

                </ul>
            </div>

            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
