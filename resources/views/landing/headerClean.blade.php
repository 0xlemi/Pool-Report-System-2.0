<!-- =========================
        HEADER
    ============================== -->
    <header id="nav2-3">

        <nav class="navbar" id="main-navbar">
        <!-- navbar fixed on top: -->
        <!--
            <nav class="navbar navbar-fixed-top" id="main-navbar" role="navigation">
        -->
        <!-- navbar static: -->
        <!--
            <nav class="navbar navbar-static-top" id="main-navbar" role="navigation">
        -->
        <!-- background transparent: -->
        <!--
            <nav class="navbar navbar-fixed-top bg-transparent" id="main-navbar" role="navigation">
        -->

            <div class="container">
                <!-- Menu Button for Mobile Devices -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Image Logo -->
                    <!-- note:
                        recommended sizes
                            width: 150px;
                            height: 35px;
                    -->
                    <a href="{{url('/')}}" class="navbar-brand smooth-scroll"><img src="img/logo-black.png" alt="logo"></a>
                    <!-- Image Logo For Background Transparent -->
                    <!--
                        <a href="#" class="navbar-brand logo-black smooth-scroll"><img src="img/logo-black.png" alt="logo" /></a>
                        <a href="#" class="navbar-brand logo-white smooth-scroll"><img src="img/logo-white.png" alt="logo" /></a>
                    -->
                </div><!-- /End Navbar Header -->

                <div class="collapse navbar-collapse" id="navbar-collapse">
                    <!-- Menu Links -->
                    <ul class="nav navbar-nav navbar-right">

                        <li><a href="{{url('/login')}}" class="btn-nav btn-grey btn-login" style="font-weight: 700; font-size: 15px; background-color: rgb(215, 220, 229);">Login</a></li>
                        <li><a href="{{url('/register')}}" class="btn-nav btn-blue btn-signup" style="font-weight: 700; font-size: 15px; background-color: rgb(44, 142, 210);">Sign up</a></li>
                    </ul><!-- /End Menu Links -->
                </div><!-- /End Navbar Collapse -->

            </div><!-- /End Container -->
        </nav><!-- /End Navbar -->
    </header>
