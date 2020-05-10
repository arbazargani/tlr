@extends('admin.template')

@section('meta')
    <title>Tiny Admin</title>
@endsection

@section('content')
<div class="content-padder content-background">
    <br>
    <div class="uk-container uk-background-default uk-padding-large">
        <div class="uk-container uk-margin-small" uk-margin>
        <form method="post" action="{{ route('Admin > Links > Submit') }}">
        @CSRF
            <div class="uk-margin">
                <input class="uk-input uk-form-width-large" type="text" placeholder="Insert main link" name="url" value="{{ @old('url') }}">
                @if(session('status') == 0)
                    <span class="uk-text-meta" style="color: white">{{ session('message') }}</span>
                    @php
                        session()->forget(['status', 'message']);
                    @endphp
                @endif
                <button class="uk-button uk-button-primary">Add</button>
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
