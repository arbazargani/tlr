@extends('public.template')

@section('meta')
    <title>Tiny</title>
@endsection

@section('content')
<div class="uk-section uk-section-secondary uk-flex uk-flex-middle uk-animation-fade body" uk-height-viewport>
    <div class="uk-width-1-1">
        <div class="uk-container">
            @include('public.template-parts.navigation')
            <div class="uk-grid-margin uk-grid uk-grid-stack" uk-grid>
                <div class="uk-width-1-1@m">
                    <div class="uk-margin uk-width-large uk-margin-auto uk-card uk-card- uk-card-body">
{{--                        <h1 class="uk-card-title uk-text-center">TINY LINKER</h1>--}}
                        <form class="uk-search uk-search-default uk-width-1-1" action="{{ route('Link > Submit') }}" method="POST">
                            @csrf
                            <div class="uk-margin">
                                <div class="uk-inline uk-width-1-1">
                                    <span class="uk-form-icon" uk-icon="icon: link"></span>
                                    <input class="uk-input uk-form-large rounded" type="text" name="url"
                                           placeholder="drop your link here ...">
                                </div>
                                <div class="uk-inline uk-width-1-1 uk-margin-top">
                                    <button type="submit"
                                            class="uk-input uk-button uk-button-primary uk-button-small uk-align-center rounded" style="width: auto">
                                        Tiny
                                    </button>
                                </div>
                            </div>
                        </form>
                        @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                <script>
                                    UIkit.notification({
                                        message: "{{ $error }}",
                                        status: 'warning',
                                        pos: 'bottom-right',
                                        timeout: 5000
                                    });
                                </script>
                                @endforeach
                        @endif
                        @if (session()->has('status'))
                            @if(session('status'))
                                <div class="uk-text-right uk-align-right">
                                    <script>
                                        UIkit.notification({
                                            message: "<span>{{ session('tiny') }}</span>" + ' ' + '<span class="btn" data-clipboard-demo="" data-clipboard-action="copy" data-clipboard-text="{{ route('Link > Redirect', session('tiny')) }}" uk-icon="icon: move"></span>',
                                            status: 'success',
                                            pos: 'bottom-right',
                                            timeout: 20000
                                        });

                                    </script>
                                    <script>
                                        var clipboard = new ClipboardJS('.btn');
                                    </script>
                                </div>
                                @php
                                    session()->forget(['status', 'tiny']);
                                @endphp
                            @else
                                <div class="uk-text-right uk-align-right">
                                    <script>
                                        UIkit.notification({
                                            message: "{{ session('message') }}",
                                            status: 'danger',
                                            pos: 'bottom-right',
                                            timeout: 20000
                                        });

                                    </script>
                                </div>
                                @php
                                    session()->forget(['status', 'message']);
                                @endphp
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
