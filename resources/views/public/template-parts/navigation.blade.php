<div class="uk-position-top">
    <nav class="uk-navbar-container uk-navbar-transparent" uk-navbar>
        <div class="uk-navbar-left">
            <ul class="uk-navbar-nav">
                <li class="uk-active"><a href="#"><span uk-icon="link"></span> TINY</a></li>
            </ul>
        </div>
        <div class="uk-navbar-right">
            <ul class="uk-navbar-nav" style="direction: rtl">
                <li class="uk-active">
                <a href="#offcanvas-usage" uk-toggle="target: #offcanvas-flip" onClick="hideLoginAlert()">
                <span uk-icon="menu"></span>
                </a>
                </li>
                @if(Auth::check() && Auth::user()->admin == 'true')
                <li>
                    <a href="">
                    <img src="https://image.flaticon.com/icons/png/512/0/315.png" style="width: 20px; filter: invert(100%);">
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </nav>
</div>
@include('public.template-parts.offcanvas')
