@extends('panel.template')

@section('content')
    <div class="container uk-padding">
        <div class="uk-card uk-card-default uk-card-hover uk-card-body">
            <h1 class="uk-card-title">لینک‌های ثبت شده</h1>
            <hr>
            <div class="uk-overflow-auto">
            @if(count($links->links) > 0)
                <table class="uk-table uk-table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>لینک اصلی</th>
                        <th>لینک کوتاه</th>
                        <th>تاریخ ثبت</th>
                        <th>تاریخ انقضا</th>
                        <th>بازدید</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($links->links as $link)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><span title="{{ $link->url }}">{{  substr(urldecode($link->url), 0, 100) }}</span></td>
                            <td><a href="{{ route('Link > Redirect', $link->tiny) }}">{{ $link->tiny }}</a></td>
                            <td>{{ $link->created_at }}</td>
                            <td>
                                @if($link->deactivate < date('Y-m-d H-i-s'))
                                    <span class="uk-text-danger">منقضی شده</span>
                                @else
                                    {{ $link->deactivate }}
                                @endif
                            </td>
                            <td>{{ $link->views }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
                <div>
                    {{ $links->links->render("pagination::uikit") }}
                </div>
            @else
                <div class="uk-alert uk-alert-warning">
                    شما تا بحال لینکی ثبت نکرده‌اید.
                </div>
            @endif
        </div>
    </div>
@endsection
