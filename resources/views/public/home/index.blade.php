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
                                           placeholder="drop your link here ..." autofocus>
                                    @if(session('status') == 0)
                                        <span class="uk-text-meta" style="color: white">{{ session('message') }}</span>
                                        @php
                                            session()->forget(['status', 'message']);
                                        @endphp
                                    @endif
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
                                        status: 'danger',
                                        pos: 'top-center',
                                        timeout: 5000
                                    });
                                </script>
                                @endforeach
                        @endif
                        @if (session()->has('status'))
                            @if(session('status') == 1)
                                <div id="tiny-modal" uk-modal>
                                    <div class="uk-modal-dialog uk-margin-auto-vertical">
                                        <button class="uk-modal-close-default" type="button" uk-close></button>
{{--                                        <div class="uk-modal-header">--}}
{{--                                            <h2 class="uk-modal-title">Tiny is ready.</h2>--}}
{{--                                        </div>--}}
                                        <div class="uk-modal-body uk-text-center">
                                            <span style="font-size: 2.625rem;">{{ session('tiny') }}</span>
                                        </div>
                                        <div class="uk-modal-footer uk-text-center">
                                            <a href="{{ route('Link > Redirect', ['tiny'=> session('tiny')]) }}" class="copy uk-button uk-button-warning" target="_blank">Open</a>
                                            <button class="copy uk-button uk-button-secondary" data-clipboard-demo="" data-clipboard-action="copy" data-clipboard-text="{{ route('Link > Redirect', session('tiny')) }}" onclick="UIkit.modal('#tiny-modal').hide()">Copy</button>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    var clipboard = new ClipboardJS('.copy');
                                    UIkit.modal('#tiny-modal', {
                                        'esc-close' : true,
                                        'bg-close' : true,
                                    }).show();
                                </script>
                                @php
                                    session()->forget(['status', 'tiny']);
                                @endphp
                            @endif
                            @if(session('status') == -1)
                                <div id="error-modal" uk-modal>
                                    <div class="uk-modal-dialog uk-margin-auto-vertical">
{{--                                        <button class="uk-modal-close-default" type="button" uk-close></button>--}}
{{--                                        <div class="uk-modal-header">--}}
{{--                                            <h2 class="uk-modal-title">Tiny is ready.</h2>--}}
{{--                                        </div>--}}
                                        <div class="uk-modal-body uk-text-center">
                                            <span style="font-size: 2.625rem;">{{ session('message') }}</span>
                                        </div>
                                        <div class="uk-modal-footer uk-text-center">
                                            <button class="uk-button uk-button-secondary" onclick="UIkit.modal('#error-modal').hide();">Close</button>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    UIkit.modal('#error-modal', {
                                        'esc-close' : true,
                                        'bg-close' : true,
                                    }).show();
                                </script>
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
