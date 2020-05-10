<nav class="uk-navbar-nav uk-background-muted uk-padding-large uk-padding-remove-top uk-padding-remove-bottom" uk-navbar>
    <div class="uk-navbar-right">
        <ul class="uk-navbar-nav">
            <li class="uk-active"><a href="{{ route('Panel') }}">صفحه اصلی</a></li>
            <li ><a href="{{ route('Panel > Links') }}">لینک‌ها</a></li>
        </ul>
    </div>
    <div class="uk-navbar-left">
        <li>
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit" class="uk-button uk-button-link uk-text-danger">خروج</button>
            </form>
        </li>
    </div>
</nav>
