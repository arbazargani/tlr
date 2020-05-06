<div uk-sticky class="uk-navbar-container tm-navbar-container uk-active">
    <div class="uk-container uk-container-expand">
        <nav uk-navbar>
            <div class="uk-navbar-left">
                <a id="sidebar_toggle" class="uk-navbar-toggle" uk-navbar-toggle-icon ></a>
                <a href="#" class="uk-navbar-item uk-logo">
                    Tiny Admin
                </a>
            </div>
            <div class="uk-navbar-right uk-light">
                <ul class="uk-navbar-nav">
                    <li class="uk-active">
                        <a href="#">Actions &nbsp;<span class="ion-ios-arrow-down"></span></a>
                        <div uk-dropdown="pos: bottom-right; mode: click; offset: -17;">
                           <ul class="uk-nav uk-navbar-dropdown-nav">
                               <li class="uk-nav-header">Options</li>
                               <li><a href="#">Edit Profile</a></li>
                               <li class="uk-nav-header">Actions</li>
                               <li><a href="#">Lock</a></li>
                           </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
<div id="sidebar" class="tm-sidebar-left uk-background-default">
    <center>
        <div class="user">
            <img id="avatar" width="100" class="uk-border-circle" src="https://avatars0.githubusercontent.com/u/46598928?s=460&v=4" />
            <div class="uk-margin-top"></div>
            <div id="name" class="uk-text-truncate">{{ Auth::User()->name }}</div>
            <div id="email" class="uk-text-truncate">{{ Auth::User()->email }}</div>
            <span id="status" data-enabled="true" data-online-text="Online" data-away-text="Away" data-interval="10000" class="uk-margin-top uk-label uk-label-success"></span>
        </div>
        <br />
    </center>
    <ul class="uk-nav uk-nav-default">
        <li><a href="{{ route('Admin') }}">Home</a></li>
        <li class="uk-nav-header">
            Links
        </li>
        <li><a href="{{ route('Admin > Links') }}">Manage</a></li>

        <li class="uk-nav-header">
            Users
        </li>
        <li><a href="login.html">Login</a></li>
        <li><a href="register.html">Register</a></li>
        <li><a href="article.html">Article</a></li>
        <li><a href="404.html">404</a></li>

        <li class="uk-nav-header">
            Main Actions
        </li>
        <li>
            <a href="">Lock</a>
        </li>
        <br>
        <li>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="uk-button uk-button-danger uk-button-small">logout</button>
            </form>
        </li>
    </ul>
</div>
