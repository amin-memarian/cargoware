<div class="modal fade" id="new-user-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">افزودن مشتری جدید</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="new-user-form" action="#">
                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label class="col-form-label" for="recipient-name">نام : </label>
                            <input class="form-control" name="name" required type="text" placeholder="نام مشتری" minlength="2" maxlength="40" pattern="[a-zA-Zآ-ی ]+">

                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="col-form-label" for="recipient-name">نام خانوادگی : </label>
                            <input class="form-control" name="lastname" required type="text" placeholder="نام خانوادگی مشتری" minlength="2" maxlength="100" pattern="[a-zA-Zآ-ی ]+">

                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="col-form-label" for="recipient-name">موبایل : </label>
                            <input class="form-control" name="mobile" required type="text" placeholder="شماره موبایل مشتری"  minlength="11" maxlength="11">

                        </div>
                    </div>
                    @csrf

                    <div class="form-check checkbox mb-0">
                        <div class="row">
                            <div class="col">
                                <p class="text-dark mt-1 mb-1">آیا بازاریاب هستید</p>
                                <div class="m-t-15 m-checkbox-inline custom-radio-ml">
                                    <div class="form-check form-check-inline radio radio-primary">
                                        <input class="form-check-input" id="radioinline1" type="radio" name="is_partner" value="yes" checked>
                                        <label class="form-check-label mb-0 text-dark" for="radioinline1">
                                            بله
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline radio radio-primary">
                                        <input class="form-check-input" id="radioinline2" type="radio" name="is_partner" value="no">
                                        <label class="form-check-label mb-0 text-dark" for="radioinline2">
                                            خیر
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <input class="form-control mt-4" id="search-field-partner" style="display: none" type="text" placeholder="جستوجوی بازاریاب (بر اساس نام، موبایل)">
                        </div>
                        <div class="col-12 text-center" id="search-result-partner"></div>
                        <div class="col-md-12" id="partner-list"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" data-bs-dismiss="modal" id="new-user-close-btn">لغو</button>
                <button class="btn btn-primary" type="button" id="add-user-btn">ذخیره مشتری</button>
            </div>
        </div>
    </div>
</div>

