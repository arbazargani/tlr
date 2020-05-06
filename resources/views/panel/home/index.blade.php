@extends('panel.template')

@section('content')
    <div class="uk-container uk-padding uk-margin uk-background-muted uk-border-rounded">
        <div uk-grid>
            <div class="uk-width-1-2@m">
                <div class="uk-container uk-text-center">
                    <img src="https://illustoon.com/photo/2092.png" class="uk-border-pill" style="max-width: 220px;">
                </div>
            </div>
            <div class="uk-width-1-2@m">
                <h2>{{ Auth::user()->name . ' ' . Auth::user()->family }}</h2>
                <p> عضویت در تاریخ {{ Auth::user()->created_at }}</p>
                <p>تعداد لینک ثبت شده در سیستم: <span class="uk-label">{{ $count }}</span></p>
                <p>نوع عضویت: <span class="uk-label uk-label-warning">{{ Auth::user()->membership }}</span></p>
                <hr>
                <div class="uk-container uk-text-center">
                    <a href="edit-profile" class="uk-button uk-button-primary uk-disabled">ویرایش پروفایل</a>
                    <a href="edit-profile" class="uk-button uk-button-secondary uk-disabled">ثبت لینک</a>
                </div>
            </div>
        </div>
    </div>
@endsection
