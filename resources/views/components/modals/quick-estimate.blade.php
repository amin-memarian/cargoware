<div  id="quickEstimate" class="modal fade custom-modal" tabindex="-1" role="dialog" aria-labelledby="quickEstimateLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"  role="document">
        <div class="modal-content">

            <div class="modal-header justify-content-center">
                <h3 class="custom-title"> تخمین سریع قیمت</h3>
            </div>

            <form method="post" action="{{ route('loads.store') }}" id="estimate-form">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        {{-- warning message --}}
                        <div id="collectionAgentTypeMessageContainerQuickEstimate" class="col-12 py-3 px-3 mt-3" style="border: 2px solid red;border-radius: 14px;display: none">
                            <span class="justify-content-center align-content-center text-danger">
                                <i data-feather="alert-triangle" class="fs-3"></i>
                                <b id="" class="ms-2 fs-3">قیمت</b>
                            </span>
                            <h6 id="collectionAgentTypeMessage" class="mt-3">
                                لطفا جهت استعلام قیمت با مدیر فروش ارتباط برقرار کنید
                            </h6>
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-12 mb-3 px-4 pt-3">
                                    <label class="mb-4 custom-label"><b>مبدا :</b></label>
                                    <select class="multiple-limit custom-select" name="store[]" multiple="multiple">
                                        @foreach($countries as $key => $country)
                                            <option value="{{ $country->en_title }}" {{ $country->en_title == 'IKA' ? 'selected' : ''}}>
                                                {{ $country->fa_full_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 mb-3 px-4 pt-3">
                                    <label class="mb-4 custom-label" for="recipient-name">وزن : <span class="text-danger">*</span> </label>
                                    <input class="form-control custom-elements" id="recipient-name" type="number" name="weight" placeholder="وزن به کیلوگرم" >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-12 mb-3 px-4 pt-3">
                                    <label class="mb-4 custom-label" for="destination">مقصد :  </label>
                                    <select class="multiple-limit custom-select" name="destination[]" multiple="multiple" data-placeholder="انتخاب مقصد">
                                        @foreach($countries as $key => $country)
                                            <option value="{{ $country->en_title }}">{{ $country->fa_full_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 mb-3 px-4 pt-3">
                                    <label class="mb-4 custom-label" for="collection_agent_type_id">انتخاب نوع : <span class="text-danger">*</span> </label>
                                    <select class="js-example-basic-single col-sm-12 custom-select" id="collectionAgentTypeQuickEstimate" name="load_type" data-placeholder="انتخاب کنید">
                                        <option value="">یک گزینه انتخاب کنید</option>
                                        @foreach(\App\Models\Load::$types as $key => $agent)
                                            <option value="{{ $key }}" {{ $key == 'GCR' ? 'selected' : '' }}>{{ $agent }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="volume-load-exist" class="col-12 mb-4 mt-4 px-4 pt-3">
                            <label class="mb-4 custom-label"><b>آیا میخواهید وزن حجمی وارد کنید ؟</b></label>
                            <div class="m-t-15 m-checkbox-inline custom-radio-ml">
                                <div class="form-check form-check-inline radio radio-primary">
                                    <input id="volume-load-yes" class="form-check-input" type="radio" name="volume_load" value="yes">
                                    <label class="form-check-label mb-0" for="volume-load-yes"><span class="digits">بله</span></label>
                                </div>
                                <div class="form-check form-check-inline radio radio-primary">
                                    <input id="volume-load-no" class="form-check-input" type="radio" name="volume_load" value="no" checked>
                                    <label class="form-check-label mb-0" for="volume-load-no"><span class="digits">خیر</span></label>
                                </div>
                            </div>
                        </div>

                        <div id="volume-load" class="col-12 mb-3 mt-3" style="display: none">

                            <div class="row">
                                <div class="mt-1 col-md-2 px-4 pt-3">
                                    <label class="mb-4 custom-label" for="size">ارتفاع کالا : </label>
                                    <input class="form-control custom-elements" name="size_height[]" maxlength="3" type="text" placeholder="ارتفاع">
                                </div>

                                <div class="mt-1 col-md-2 px-4 pt-3">
                                    <label class="mb-4 custom-label" for="size">طول کالا : </label>
                                    <input class="form-control custom-elements" name="size_length[]" maxlength="3" type="text" placeholder="طول">
                                </div>

                                <div class="mt-1 col-md-2 px-4 pt-3">
                                    <label class="mb-4 custom-label" for="size">عرض کالا : </label>
                                    <input class="form-control custom-elements" name="size_width[]" maxlength="3" type="text" placeholder="عرض">
                                </div>

                                <div class="mt-1 col-md-2 px-4 pt-3">

                                    <label class="custom-label" for="count">تعداد بسته : </label>
                                    <input class="form-control custom-elements" value="1" min="1" name="count[]" type="number" placeholder="تعداد بسته را انتخاب کنید">

                                    <div class="invalid-feedback" id="count-error"></div>
                                </div>

                                <div class="mt-1 col-md-2 px-4 pt-3">
                                    <i data-feather="plus-circle" class="add-row-button"></i>
                                    <i data-feather="minus-circle" class="delete-row-button"></i>
                                </div>

                            </div>

                            <div id="quickEstimateDimensionsContainer">

                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" data-bs-dismiss="modal" data-bs-original-title="" title="">لغو</button>
                    <button class="btn btn-primary collectionAgentTypeButtonQuickEstimate" id="quick-estimate-submit-btn" type="button" form="quickEstimate">تخمین قیمت</button>
                </div>
            </form>
        </div>
    </div>
</div>



