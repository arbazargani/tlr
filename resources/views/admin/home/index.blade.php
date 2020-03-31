@extends('admin.template')

@section('meta')
    <title>Tiny Admin</title>
@endsection

@section('content')
<div class="content-padder content-background uk-background-secondary">
{{--    @include('admin.template-parts.info')--}}
    <div class="uk-section-small">
        <div class="uk-container uk-container-large">
            <div uk-grid class="uk-child-width-1-1@s uk-child-width-1-2@m uk-child-width-1-4@xl">
                <div>
                    <div class="uk-card uk-card-default uk-card-body">
                        <span class="statistics-text"><span uk-icon="icon: link"></span> Today Links</span><br />
                        <span class="statistics-number">
                            {{ count($todayLinks) }}
                            @if(count($todayLinks) > count($yesterdayLinks))
                            <span class="uk-label uk-label-success">
                                {{ count($todayLinks) - count($yesterdayLinks) }} <span class="ion-arrow-up-c"></span>
                            </span>
                            @elseif(count($todayLinks) < count($yesterdayLinks))
                            <span class="uk-label uk-label-danger">
                                {{ count($todayLinks) - count($yesterdayLinks) }} <span class="ion-arrow-down-c"></span>
                            </span>
                            @else
                            <span class="uk-label" style="background-color: gray;">
                                {{ count($todayLinks) - count($yesterdayLinks) }} -
                            </span>
                            @endif
                        </span>
                    </div>
                </div>
                <div>
                    <div class="uk-card uk-card-default uk-card-body">
                        <span class="statistics-text"><span uk-icon="icon: user"></span> Today Traffic</span><br />
                        <span class="statistics-number">
                            123.238
                            <span class="uk-label uk-label-danger">
                                13% <span class="ion-arrow-down-c"></span>
                            </span>
                        </span>
                    </div>
                </div>
                <div>
                    <div class="uk-card uk-card-default uk-card-body">
                        <span class="statistics-text"><span uk-icon="icon: plus"></span> Total Links</span><br />
                        <span class="statistics-number">
                            {{ $totalLinks }}
                            <span class="uk-label uk-label-success">
                                37% <span class="ion-arrow-up-c"></span>
                            </span>
                        </span>
                    </div>
                </div>
                <div>
                    <div class="uk-card uk-card-default uk-card-body">
                        <span class="statistics-text"><span uk-icon="icon: credit-card"></span> Total Income</span><br />
                        <span class="statistics-number">
                            6.384€
                            <span class="uk-label uk-label-success">
                                26% <span class="ion-arrow-up-c"></span>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
            <div uk-grid class="uk-child-width-1-1@s uk-child-width-1-2@m uk-child-width-1-4@xl">
                <div>
                    <div class="uk-card uk-card-default">
                        <div class="uk-card-header">
                            Website Traffic
                        </div>
                        <div class="uk-card-body">
                            <canvas id="chart1"></canvas>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="uk-card uk-card-default">
                        <div class="uk-card-header">
                            Website Traffic
                        </div>
                        <div class="uk-card-body">
                            <canvas id="chart2"></canvas>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="uk-card uk-card-default">
                        <div class="uk-card-header">
                            Links Registered
                        </div>
                        <div class="uk-card-body">
                            <div style="height: 200px;">
                                {!! $Link_Count_Chart->container() !!}
                                {!! $Link_Count_Chart->script() !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="uk-card uk-card-default">
                        <div class="uk-card-header">
                        Loyal Users
                        </div>
                        <div class="uk-card-body">
                            <div style="height: 200px;">
                            {!! $loyal_users_chart->container() !!}
                            {!! $loyal_users_chart->script() !!}
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
