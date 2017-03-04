<header class="site-header">
    <div class="container-fluid">
        <a href="{{ url('') }}" class="site-logo">
            <img class="hidden-md-down" src="{{ url('img/logo-2.png') }}" alt="">
            <img class="hidden-lg-up" src="{{ url('img/logo-2-mob.png') }}" alt="">
        </a>
        <button class="hamburger hamburger--htla">
            <span>toggle menu</span>
        </button>
        <div class="site-header-content">
            <div class="site-header-content-in">
                <div class="site-header-shown">

                    <notifications-widget></notifications-widget>

                    <!-- <div class="dropdown dropdown-notification messages">
                        <a href="#"
                           class="header-alarm dropdown-toggle active"
                           id="dd-messages"
                           data-toggle="dropdown"
                           aria-haspopup="true"
                           aria-expanded="false">
                            <i class="font-icon-mail"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-messages" aria-labelledby="dd-messages">
                            <div class="dropdown-menu-messages-header">
                                <ul class="nav" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active"
                                           data-toggle="tab"
                                           href="#tab-incoming"
                                           role="tab">
                                            Inbox
                                            <span class="label label-pill label-danger">8</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link"
                                           data-toggle="tab"
                                           href="#tab-outgoing"
                                           role="tab">Outbox</a>
                                    </li>
                                </ul>
                                <button type="button" class="create">
                                    <i class="font-icon font-icon-pen-square"></i>
                                </button>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab-incoming" role="tabpanel">
                                    <div class="dropdown-menu-messages-list">
                                        <a href="#" class="mess-item">
                                            <span class="avatar-preview avatar-preview-32"><img src="{{ url('img/photo-64-2.jpg') }}" alt=""></span>
                                            <span class="mess-item-name">Tim Collins</span>
                                            <span class="mess-item-txt">Morgan was bothering about something!</span>
                                        </a>
                                        <a href="#" class="mess-item">
                                            <span class="avatar-preview avatar-preview-32"><img src="{{ url('img/avatar-2-64.png') }}" alt=""></span>
                                            <span class="mess-item-name">Christian Burton</span>
                                            <span class="mess-item-txt">Morgan was bothering about something! Morgan was bothering about something.</span>
                                        </a>
                                        <a href="#" class="mess-item">
                                            <span class="avatar-preview avatar-preview-32"><img src="{{ url('img/photo-64-2.jpg') }}" alt=""></span>
                                            <span class="mess-item-name">Tim Collins</span>
                                            <span class="mess-item-txt">Morgan was bothering about something!</span>
                                        </a>
                                        <a href="#" class="mess-item">
                                            <span class="avatar-preview avatar-preview-32"><img src="{{ url('img/avatar-2-64.png') }}" alt=""></span>
                                            <span class="mess-item-name">Christian Burton</span>
                                            <span class="mess-item-txt">Morgan was bothering about something...</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-outgoing" role="tabpanel">
                                    <div class="dropdown-menu-messages-list">
                                        <a href="#" class="mess-item">
                                            <span class="avatar-preview avatar-preview-32"><img src="{{ url('img/avatar-2-64.png') }}" alt=""></span>
                                            <span class="mess-item-name">Christian Burton</span>
                                            <span class="mess-item-txt">Morgan was bothering about something! Morgan was bothering about something...</span>
                                        </a>
                                        <a href="#" class="mess-item">
                                            <span class="avatar-preview avatar-preview-32"><img src="{{ url('img/photo-64-2.jpg') }}" alt=""></span>
                                            <span class="mess-item-name">Tim Collins</span>
                                            <span class="mess-item-txt">Morgan was bothering about something! Morgan was bothering about something.</span>
                                        </a>
                                        <a href="#" class="mess-item">
                                            <span class="avatar-preview avatar-preview-32"><img src="{{ url('img/avatar-2-64.png') }}" alt=""></span>
                                            <span class="mess-item-name">Christian Burtons</span>
                                            <span class="mess-item-txt">Morgan was bothering about something!</span>
                                        </a>
                                        <a href="#" class="mess-item">
                                            <span class="avatar-preview avatar-preview-32"><img src="{{ url('img/photo-64-2.jpg') }}" alt=""></span>
                                            <span class="mess-item-name">Tim Collins</span>
                                            <span class="mess-item-txt">Morgan was bothering about something!</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-menu-notif-more">
                                <a href="#">See more</a>
                            </div>
                        </div>
                    </div>

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
                            <img src="{{ url('img/avatar-2-64.png') }}" alt="">
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
