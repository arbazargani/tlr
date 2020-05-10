@extends('admin.template')

@section('meta')
    <title>Tiny Admin</title>
@endsection

@section('content')
<div class="content-padder content-background">
    <br>
    <div class="uk-container uk-width-1-1 uk-background-default uk-padding-large" style="margin: 10px !important;">
        <div class="uk-container uk-margin-small">
        @if(count($links))
            <div class="uk-overflow-auto">
                <table class="uk-table uk-table-hover uk-table-divider">
                    <style>
                        thead > tr > th {
                            text-align: left !important;
                        }
                    </style>
                    <thead>
                    <tr>
                        <th>URL</th>
                        <th>TLD</th>
                        <th>TINY</th>
                        <th>VIEWS</th>
                        <th>STATE</th>
                        <th>IP</th>
                        <th>Registered_AT</th>
                        <th>DEACTIVATE</th>
                        <th>DELETE</th>
                    </tr>
                    </thead>
                    <tbody>
                    @include('admin.link.fetch')
                    </tbody>
                </table>
                {{ $links->render() }}
            </div>
        @else
            <div class="uk-alert-warning" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p>لینکی در سیستم موجود نیست.</p>
            </div>
        @endif
    </div>
    </div>
</div>
@endsection
