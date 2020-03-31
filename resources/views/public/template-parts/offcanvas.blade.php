<div id="offcanvas-flip" uk-offcanvas="flip: true; overlay: true">
    <div class="uk-offcanvas-bar">

        <button class="uk-offcanvas-close" type="button" uk-close></button>

        <h3>About us</h3>

        <p>
            Tiny Links! <br>
            by the way everyone knows why you should to make your links shorten!
            and don't blame yourself!
            we are not just a website.
            tiny structured on a webservice.
            it means you can use tiny by API
            or Browsers Add-on & cross-platform applications. <br>
            Enjoy so.
        </p>

        <hr>

        @if(!Auth::check())
            <div class="uk-child-width-1-2@m">
                <a href="{{ route('login') }}" class="uk-button uk-button-default uk-button-small"><span uk-icon="user"></span> login</a>
                <br>
                <br>
                <a href="{{ route('register') }}" class="uk-button uk-button-default uk-button-small"><span uk-icon="plus"></span> register</a>
            </div>
        @else
            <div class="uk-child-width-1-2@m">
            @if(Auth::user()->admin == 'true')
            <a href="{{ route('Admin') }}" class="uk-button uk-button-default uk-button-small"><span uk-icon="user"></span> panel</a>
            <br>
            @else
            <a href="{{ route('Panel') }}" class="uk-button uk-button-default uk-button-small"><span uk-icon="user"></span> panel</a>
            <br>
            @endif
            </div>
        @endif

    </div>
</div>
