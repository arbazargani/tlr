@extends('admin.template')

@section('meta')
    <title>Tiny Admin</title>
@endsection

@section('content')
<div class="content-padder content-background">
    <br>
    <div class="uk-container uk-background-default uk-padding-large">
        <div class="uk-container uk-margin-small" uk-margin>
        <p>Add <span class="uk-label uk-label-success">Cross</span> Tiny</p>
        @if (session()->has('status'))
            @if(session('status') == 0)
                <div class="uk-alert-danger" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <span>{{ session('message') }}</span>
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
        @endif
        <form method="post" action="{{ route('Link > Submit') }}">
        @CSRF
            <div class="uk-margin" uk-grid>
                <div class="uk-width-auto@m">
                    <div class="uk-margin">
                        <ion-icon name="star-outline"></ion-icon>
                        <input class="uk-input uk-form-width-medium" type="text" placeholder="Master link" name="url" value="{{ @old('url') }}">
                    </div>

                    <div class="uk-margin">
                        <ion-icon name="logo-android"></ion-icon>
                        <input class="uk-input uk-form-width-medium" type="text" placeholder="ANDROID link" name="android-url" value="{{ @old('android-url') }}">
                    </div>

                    <div class="uk-margin">
                        <ion-icon name="logo-apple"></ion-icon>
                        <input class="uk-input uk-form-width-medium" type="text" placeholder="IOS link" name="ios-url" value="{{ @old('ios-url') }}">
                    </div>

                    <div class="uk-margin">
                        <ion-icon name="logo-windows"></ion-icon>
                        <input class="uk-input uk-form-width-medium" type="text" placeholder="WINDOWS PHONE link" name="windows-url" value="{{ @old('windows-url') }}">
                    </div>
                </div>
                <div class="uk-width-expand@m">
                    <ul class="uk-list uk-list-bullet">
                        <li>Main link is required.</li>
                        <li>X-Crosses are optional.</li>
                        <li>Consider if the browser agent wont detected, user will redirect to the main destination.</li>
                    </ul>
                    <hr>
                    <button class="uk-button uk-button-primary">Add</button>
                </div>


                @if(session('status') == 0)
                    <span class="uk-text-meta" style="color: white">{{ session('message') }}</span>
                    @php
                        session()->forget(['status', 'message']);
                    @endphp
                @endif
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
                <div uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <h3>Ready to rock and roll ¯\_(ツ)_/¯</h3>
                    <span style="font-size: 2.625rem;">{{ session('tiny') }}</span>
                    <a href="{{ route('Link > Redirect', ['tiny'=> session('tiny')]) }}" class="copy uk-button uk-button-warning" target="_blank">Open</a>
                    <button class="copy uk-button uk-button-secondary" data-clipboard-demo="" data-clipboard-action="copy" data-clipboard-text="{{ route('Link > Redirect', session('tiny')) }}" onclick="UIkit.modal('#tiny-modal').hide()">Copy</button>
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
        @endif
        </div>
    </div>
</div>
@endsection
