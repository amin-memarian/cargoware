@extends('layouts.admin.master')

@section('title')
    <title>پنل مدیریت | لیست سفارش ها</title>
@endsection

@section('styles')@endsection

@section('breadcrumb')
    <div class="row">
        <div class="col-12 col-sm-6">
            <h3>لیست سفارش ها</h3>
        </div>
    </div>
@endsection

@section('body-content')

    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display" id="basic-2">
                        <thead>
                        <tr>
                            <th class="text-center">ردیف</th>
                            <th class="text-center">اطلاعات مشتری</th>
                            <th class="text-center">تاریخ ثبت سفارش</th>
                            <th class="text-center">نام ادمین فروش</th>
                            <th class="text-center">وزن</th>
                            <th class="text-center">مقصد</th>
                            <th class="text-center">وضعیت</th>
                            <th class="text-center">قیمت نهایی</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')

    <script>


        $( document ).ready(function() {

            let table = $('#basic-2').DataTable();

            if ($.fn.dataTable.isDataTable('#basic-2')) {
                table.destroy();
            }

            $('#basic-2').DataTable({
                processing: true,
                serverSide: true,
                searchable: true,
                ajax: '{{ route('orders.data') }}',
                columns: [
                    {data: 'id', name: 'id', className: 'text-center' },
                    {data: 'user_info', name: 'user_info', className: 'text-center' },
                    {data: 'collection_date', name: 'collection_date', className: 'text-center' },
                    {data: 'admin_name', name: 'admin_name', className: 'text-center' },
                    {data: 'weight', name: 'weight', className: 'text-center' },
                    {data: 'address', name: 'address', className: 'text-center' },
                    {data: 'state', name: 'state', className: 'text-center' },
                    {data: 'estimate', name: 'estimate', className: 'text-center', searchable: true },
                    {data: 'actions', name: 'actions', orderable: false, className: 'text-center' }
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        text: '<i class="icon-reload fa-2x"></i>',
                        action: function (e, dt, node, config) {
                            dt.ajax.reload(null, false);
                        }
                    }
                ],
                language: {
                    url: '{{ url('panel/assets/js/datatable/datatables/buttons.bootstrap5.min.js') }}'
                }
            });

        });

    </script>
@endsection


