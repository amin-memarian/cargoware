@extends('layouts.admin.master')

@section('title')
    <title>پنل مدیریت | داشبورد</title>
@endsection

@section('styles')@endsection

@section('breadcrumb')
    <div class="row">
        <div class="col-12 col-sm-6">
            <h3>تخمین قیمت</h3>
        </div>
        <div class="col-12 col-sm-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <i data-feather="home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item">پنل مدیریت</li>
                <li class="breadcrumb-item active">تخمین قیمت</li>
            </ol>
        </div>
    </div>
@endsection

@section('body-content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header pb-0">
                <h5>کارت ساده</h5>
            </div>
            <div class="card-body">
                <h6>متن HTML پیش فرض</h6>
                <p>
                    <strong>لورم ایپسوم متن ساختگی با تولید سادگی</strong> لورم ایپسوم متن ساختگی با تولید سادگی
                    نامفهوم، لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم، لورم ایپسوم متن ساختگی با تولید سادگی
                    نامفهوم. <em>لورم ایپسوم متن ساختگی صنعت چاپ</em> لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم،
                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم، <code>لورم ایپسوم</code>، لورم ایپسوم متن ساختگی با
                    تولید سادگی نامفهوم، لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم. <a href="#">متن ساختگی
                        نامفهوم</a>
                    لورم ایپسوم متن ساختگی نامفهوم صنعت چاپ.
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header pb-0">
                <h5>با هدر</h5>
            </div>
            <div class="card-body">
                <h5>عنوان محتوا</h5>
                <p>عنوانی را با کلاس <code>.card-header</code> به کارت اضافه کنید</p>
                <p>همچنین می‌توانید هر &lt;h1&gt;-&lt;h6&gt; را با کلاس <code>.card-header </code> و
                    <code>.card-title</code> برای اضافه کردن عنوان اضافه کنید.</p>
                <p>سوفله کیک جو دوسر کیک پنیر لوبیا ژله. کیک هویج تارت آلو قند. لوبیای ژله ای تیرامیسو ویفر مارشمالو.
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header pb-0 card-no-border">
                <h5>با هدر بدون خط مرز</h5>
            </div>
            <div class="card-body">
                <h5>عنوان محتوا</h5>
                <p>عنوان را با کلاس <code>.card-header</code> به کارت اضافه کنید و برای هدر بدون مرز کلاس
                    <code>.border-bottom-0</code> را اضافه کنید.</p>
                <p>همچنین می‌توانید هر &lt;h1&gt;-&lt;h6&gt; را با کلاس <code>.card-header </code> و
                    <code>.card-title</code> برای اضافه کردن عنوان اضافه کنید.</p>
                <p>شیرینی زنجفیلی براونی شیرین رول چیزکیک کیک شکلاتی ژله لوبیا مارزیپان دسر صمغی. سوفله کیک جو دوسر
                    کیک پنیر لوبیا ژله.</p>
            </div>
        </div>
    </div>
@endsection

@section('script')@endsection



