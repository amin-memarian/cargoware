<!-- Page Header Start-->
<div class="page-header">

    <div class="header-wrapper row m-0">
        <div class="header-logo-wrapper col-auto p-0">

            <div class="logo-wrapper">
                <a href="{{ route('admin.dashboard') }}">
                    <img class="img-fluid" src="" alt="">
                </a>
            </div>

            <div class="toggle-sidebar">
                <div class="status_toggle sidebar-toggle d-flex">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g>
                            <g>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M21.0003 6.6738C21.0003 8.7024 19.3551 10.3476 17.3265 10.3476C15.2979 10.3476 13.6536 8.7024 13.6536 6.6738C13.6536 4.6452 15.2979 3 17.3265 3C19.3551 3 21.0003 4.6452 21.0003 6.6738Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.3467 6.6738C10.3467 8.7024 8.7024 10.3476 6.6729 10.3476C4.6452 10.3476 3 8.7024 3 6.6738C3 4.6452 4.6452 3 6.6729 3C8.7024 3 10.3467 4.6452 10.3467 6.6738Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M21.0003 17.2619C21.0003 19.2905 19.3551 20.9348 17.3265 20.9348C15.2979 20.9348 13.6536 19.2905 13.6536 17.2619C13.6536 15.2333 15.2979 13.5881 17.3265 13.5881C19.3551 13.5881 21.0003 15.2333 21.0003 17.2619Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.3467 17.2619C10.3467 19.2905 8.7024 20.9348 6.6729 20.9348C4.6452 20.9348 3 19.2905 3 17.2619C3 15.2333 4.6452 13.5881 6.6729 13.5881C8.7024 13.5881 10.3467 15.2333 10.3467 17.2619Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                        </g>
                    </svg>
                </div>
            </div>
        </div>
        <div class="left-side-header col ps-0 d-none d-md-block">
          <div class="input-group header-search-container"><span class="input-group-text" id="basic-addon1">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g>
                  <g>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.2753 2.71436C16.0029 2.71436 19.8363 6.54674 19.8363 11.2753C19.8363 16.0039 16.0029 19.8363 11.2753 19.8363C6.54674 19.8363 2.71436 16.0039 2.71436 11.2753C2.71436 6.54674 6.54674 2.71436 11.2753 2.71436Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M19.8987 18.4878C20.6778 18.4878 21.3092 19.1202 21.3092 19.8983C21.3092 20.6783 20.6778 21.3097 19.8987 21.3097C19.1197 21.3097 18.4873 20.6783 18.4873 19.8983C18.4873 19.1202 19.1197 18.4878 19.8987 18.4878Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                  </g>
                </g>
              </svg></span>

            <input id="general-search" class="form-control" type="text" placeholder=" جست و جو کنید ..." aria-label="search" aria-describedby="basic-addon1">


          </div>
        </div>
        <div class="left-side-header col ps-0 d-none d-md-block">

        </div>
        <div class="nav-right col-10 col-sm-6 pull-right right-header p-0">
            <ul class="nav-menus">


                <li class="header-btn">


                    <button class="btn header-btn-check-price"><a href="{{ route('customer-invoices.create') }}">صدور فاکتور مشتری</a>
                        <i class="icon-file"></i>
                    </button>

                    <button class="btn header-btn-user" id="submitLoadBtn" type="button" data-isModal="true" disabled>سفارش جدید<i class="icon-plus"> </i>
                    </button>

                    <button class="btn header-btn-price" id="quickEstimateBtn" type="button" data-isModal="true" disabled>دریافت تخمین<i class="icon-plus"></i>
                    </button>


                </li>


                <li class="onhover-dropdown">
                    <div class="notification-box">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <g>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9961 2.51416C7.56185 2.51416 5.63519 6.5294 5.63519 9.18368C5.63519 11.1675 5.92281 10.5837 4.82471 13.0037C3.48376 16.4523 8.87614 17.8618 11.9961 17.8618C15.1152 17.8618 20.5076 16.4523 19.1676 13.0037C18.0695 10.5837 18.3571 11.1675 18.3571 9.18368C18.3571 6.5294 16.4295 2.51416 11.9961 2.51416Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M14.306 20.5122C13.0117 21.9579 10.9927 21.9751 9.68604 20.5122" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </g>
                        </svg><span class="badge rounded-pill badge-warning">1 </span>
                    </div>
                    <div class="onhover-show-div notification-dropdown">
                        <div class="dropdown-title">
                            <h3>اعلان</h3><a class="f-right" href="cart.html"> <i data-feather="bell"> </i></a>
                        </div>
                        <ul class="custom-scrollbar">
                            <li>
                                <div class="media">
                                    <div class="notification-img bg-light-primary">
                                        <img src="{{ asset('panel/assets/images/avtar/man.png') }}" alt="">
                                    </div>
                                    <div class="media-body">
                                        <h5>کارگو ویرفی</h5>
                                        <p>لورم ایپسوم متن ساختگی نامفهوم ...</p><span>10:20</span>
                                    </div>
                                    <div class="notification-right"><a href="#"><i data-feather="x"></i></a></div>
                                </div>
                            </li>
                            <li class="p-0"><a class="btn btn-primary" href="#">بررسی همه</a></li>
                        </ul>
                    </div>
                </li>

                <li>
                    <p>{{ Auth::user()->name }} {{ Auth::user()->lastname }}</p>
                    <span class="badge badge-primary" style="margin-top: 35px; margin-left: 33px;">مدیریت</span>
                </li>
                <li class="profile-nav onhover-dropdown pe-0 py-0 me-0">
                    <div class="media profile-media">
                        <img class="profile-header-photo" src="../panel/assets/images/profile-photo.png" alt="profile">
                    </div>
                    <ul class="profile-dropdown onhover-show-div">
                        <li>
                            <a href="#">
                                <i data-feather="user"></i>
                                <span>حساب کاربری </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i data-feather="log-in"> </i>
                                <span>خروج</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

</div>
</div>
<!-- Page Header Ends-->



