@extends('public.template')

@section('meta')
    <title>یافت نشد ...</title>
@endsection

@section('content')
    <div class="uk-section uk-section-secondary uk-flex uk-flex-middle uk-animation-fade body" uk-height-viewport>
        <div class="uk-width-1-1">
            <div class="uk-container">
                @include('public.template-parts.navigation')
                <div class="uk-container uk-text-center">
                    <h1 style="font-family: IranSans; font-size: 100px;">۴۰۴</h1>
                    <p style="font-family: IranSans; direction: rtl;">صفحه موردنظر وجود ندارد!</p>
                </div>
            </div>
        </div>
    </div>
@endsection
