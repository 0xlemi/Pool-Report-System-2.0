<header class="site-header">
    <div class="container-fluid">
        <a href="{{ url('/dashboard') }}" class="site-logo">
            <img class="hidden-md-down" src="{{ \Storage::url('images/assets/app/logo-2.png') }}" alt="">
            <img class="hidden-lg-up" src="{{ \Storage::url('images/assets/app/logo-2-mob.png') }}" alt="">
        </a>
        <button class="hamburger hamburger--htla">
            <span>toggle menu</span>
        </button>
        <div class="site-header-content">
            <div class="site-header-content-in">
                <div class="site-header-shown">

                    <role-picker :selected-user="{{ $selectedUser }}" :companies="{{ $roles }}"></role-picker>

                    <notifications-widget></notifications-widget>
                    <messages-widget :selected-user="{{ $selectedUser }}" sound-url="{{ $chat->sound }}"></messages-widget>

                    <!--

                    <div class="dropdown dropdown-lang">
                        <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="flag-icon flag-icon-us"></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-menu-col">
                                <a class="dropdown-item" href="#"><span class="flag-icon flag-icon-ru"></span>Русский</a>
                                <a class="dropdown-item" href="#"><span class="flag-icon flag-icon-de"></span>Deutsch</a>
                                <a class="dropdown-item" href="#"><span class="flag-icon flag-icon-it"></span>Italiano</a>
                                <a class="dropdown-item" href="#"><span class="flag-icon flag-icon-es"></span>Español</a>
                                <a class="dropdown-item" href="#"><span class="flag-icon flag-icon-pl"></span>Polski</a>
                                <a class="dropdown-item" href="#"><span class="flag-icon flag-icon-li"></span>Lietuviu</a>
                            </div>
                            <div class="dropdown-menu-col">
                                <a class="dropdown-item current" href="#"><span class="flag-icon flag-icon-us"></span>English</a>
                                <a class="dropdown-item" href="#"><span class="flag-icon flag-icon-fr"></span>Français</a>
                                <a class="dropdown-item" href="#"><span class="flag-icon flag-icon-by"></span>Беларускi</a>
                                <a class="dropdown-item" href="#"><span class="flag-icon flag-icon-ua"></span>Українська</a>
                                <a class="dropdown-item" href="#"><span class="flag-icon flag-icon-cz"></span>Česky</a>
                                <a class="dropdown-item" href="#"><span class="flag-icon flag-icon-ch"></span>中國</a>
                            </div>
                        </div>
                    </div> -->

                    <div class="dropdown user-menu">
                        <button class="dropdown-toggle" id="dd-user-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ \Storage::url('images/assets/app/avatar-2-64.png') }}" alt="">
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd-user-menu">
                            <!-- <a class="dropdown-item" href="{{ url('/profile') }}"><span class="font-icon glyphicon glyphicon-user"></span>Profile</a> -->
                            <a class="dropdown-item" href="{{ url('/settings') }}"><span class="font-icon glyphicon glyphicon-cog"></span>Settings</a>
                            <a class="dropdown-item" href="{{ url('/help') }}"><span class="font-icon glyphicon glyphicon-question-sign"></span>Help</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url('/logout') }}"><span class="font-icon glyphicon glyphicon-log-out"></span>Logout</a>
                        </div>
                    </div>

                    <button type="button" class="burger-right">
                        <i class="font-icon-menu-addl"></i>
                    </button>
                </div><!--.site-header-shown-->

                <div class="mobile-menu-right-overlay"></div>

            </div><!--site-header-content-in-->
        </div><!--.site-header-content-->
    </div><!--.container-fluid-->
</header><!--.site-header-->
