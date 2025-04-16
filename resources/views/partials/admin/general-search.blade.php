

<div class="card search-container" style="display: none">


    <button id="search-close-button" class="btn fs-4 position-absolute top-0 start-0 m-3" aria-label="Close">
        <i class="fa fa-times"></i>
    </button>

    <div class="card-body custom-card-body">

        <div class="container px-4">
            <div class="fast-estimate-heading">
                <h3 class="text-center fs-4 text-black py-5"> <span class="text-theme-default">0</span>نتیجه جست و جو یافت شد!</h3>
            </div>

            <div class="search-result-container bg-white p-0">
                <div class="search-result-header">
                    <div class="col-12 col-md-6 d-flex flex-column flex-sm-row align-items-center">
                        <img src="{{ asset('panel\assets\images\general-search\first-result.png') }}" alt="" width="60px" height="auto">

                        <h3 class=" text-center fs-4 text-black mb-0 mt-1 pe-5 pe-0 pe-sm-5"> <span class="text-theme-secondary" id="estimates-count"> 0 </span>نتیجه جست و جو در <span class="text-theme-secondary">تخمین سریع </span>یافت شد.</h3>
                    </div>
                    <button class="btn header-btn-price" type="submit" data-target="estimate-search-results">توضیحات بیشتر
                        <i class="text-white fs-4 fa fa-angle-down"></i>
                    </button>
                </div>
                <div class="search-result-table" id="estimate-search-results">
                    <table class="display dataTable no-footer m-0 mb-0 p-0 table-bordered" role="grid">
                        <thead>
                        <tr id="estimate-headers">

                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>


            <div class="container-fluid search-result-container bg-white p-0">
                <div class="search-result-header">
                    <div class="col-12 col-md-6 d-flex flex-column flex-sm-row align-items-center">
                        <img src="{{ asset('panel\assets\images\general-search\second-result.png') }}" alt="" width="60px" height="auto">
                        <h3 class=" text-center fs-4 text-black mb-0 mt-1 pe-5 pe-0 pe-sm-5"> <span class="text-theme-secondary" id="case-count"> 0 </span>نتیجه جست و جو در <span class="text-theme-secondary">پرونده ها </span>یافت شد.</h3>
                    </div>
                    <button class="btn header-btn-price" type="submit" data-target="case-search-results">توضیحات بیشتر
                        <i class="text-white fs-4 fa fa-angle-down"></i>
                    </button>
                </div>
                <div class="search-result-table" id="case-search-results">
                    <table class="display dataTable no-footer m-0 mb-0 p-0 table-bordered" role="grid">
                        <thead>
                        <tr id="case-headers">

                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>
