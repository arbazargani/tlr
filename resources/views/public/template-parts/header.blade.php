<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="{{ asset('assets/public/images/favicon.png') }}">

<!-- UIkit CSS -->
<link rel="stylesheet" href="{{ asset('assets/public/css/uikit.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/public/css/custom.css') }}">

<!-- UIkit JS -->
<script src="{{ asset('assets/public/js/uikit.min.js') }}"></script>
<script src="{{ asset('assets/public/js/uikit-icons.min.js') }}"></script>

<!-- Jquery -->
<script src="{{ asset('assets/public/js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('assets/public/js/jquery.backstretch.min.js') }}"></script>

<!-- Clipboard -->
<script src="{{ asset('assets/public/js/clipboard.min.js') }}"></script>

<style>
    .smoke {
        background-color: whitesmoke;
    }
    .body {
        background-image: url("{{ asset('assets/public/images/dark-bg-004.jpg') }}");
        background-position: center;
        background-size: cover;
        background-color: rgba(0, 0, 0, 0.40);
    }
    .rounded {
        border-radius: 4px !important;
    }
    .half-opacity {
        opacity: 0.5;
    }
    .uk-hidden {
        display: none;
    }
</style>
