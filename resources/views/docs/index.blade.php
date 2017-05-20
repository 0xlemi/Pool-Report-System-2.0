<!DOCTYPE html>
<html><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- TITLE OF SITE -->
    <title>Pool Business Management Software | Pool Report System</title>

    <meta name="description" content="Web-based software that helps you automate alot of the management work in your pool service business. ">
    <meta name="keywords" content="pool, service, business, management, web, pool service business,
software, pool service business management software">
    <meta name="author" content="Luis Espinosa de los Monteros">

    <!-- FAVICON  -->
    <!-- Place your favicon.ico in the img directory -->
    <link rel="shortcut icon" href="{{ url('img/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ url('img/favicon.ico') }}" type="image/x-icon">

    <!-- =========================
       STYLESHEETS
    ============================== -->
    <!-- GOOGLE FONTS -->
    <link href="//fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic" rel="stylesheet" type="text/css">
    <link href='//fonts.googleapis.com/css?family=Raleway:100,300,400,500%7CLato:300,400' rel='stylesheet' type='text/css'>

    <!-- CUSTOM STYLESHEET -->
    <link rel="stylesheet" href="{{ url('css/landing/style.css') }}">

    <!-- RESPONSIVE FIXES -->
    <link rel="stylesheet" href="{{ url('css/landing/responsive.css') }}">

    <!-- DOCUMENTATION STYLESHEET -->
    <link href="{{ elixir('css/docs.css') }}" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body data-spy="scroll" data-target="#main-navbar">
<div class="main-container" id="page">

 @include('landing.header')

<main class="container">
    <div class="row">


        <!-- Sidebar -->
        <aside class="col-md-3 col-sm-3 sidebar sidebar-icon">

          <ul class="sidenav dropable sticky">
            <li>
              <a href="#"><i class="fa fa-columns"></i> Quick Start</a>
              <ul>
                <li><a href="layout_boxed_left-sidebar.html">Authentication</a></li>
              </ul>
            </li>

            <li>
              <a href="#"><i class="fa fa-th-large"></i> Users/Roles</a>
              <ul>
                <li><a href="component_navbar.html"><i class="fa fa-list-alt"></i> Navbar</a></li>
                <li><a href="component_banner.html"><i class="fa fa-tv"></i> Banner</a></li>
                <li><a href="component_sidebar.html"><i class="fa fa-th-list"></i> Sidebar - default</a></li>
                <li><a href="component_sidebar_line.html"><i class="fa fa-th-list"></i> Sidebar - line</a></li>
                <li><a class="active" href="component_sidebar_icon.html"><i class="fa fa-th-list"></i> Sidebar - icon</a></li>
                <li><a href="component_footer.html"><i class="fa fa-copyright"></i> Footer</a></li>
              </ul>
            </li>

            <li>
              <a href="#"><i class="fa fa-th-large"></i> Company</a>
              <ul>
                <li><a href="component_navbar.html"><i class="fa fa-list-alt"></i> Navbar</a></li>
                <li><a href="component_banner.html"><i class="fa fa-tv"></i> Banner</a></li>
                <li><a href="component_sidebar.html"><i class="fa fa-th-list"></i> Sidebar - default</a></li>
                <li><a href="component_sidebar_line.html"><i class="fa fa-th-list"></i> Sidebar - line</a></li>
                <li><a class="active" href="component_sidebar_icon.html"><i class="fa fa-th-list"></i> Sidebar - icon</a></li>
                <li><a href="component_footer.html"><i class="fa fa-copyright"></i> Footer</a></li>
              </ul>
            </li>

            <li>
              <a href="#"><i class="fa fa-th-large"></i> Services</a>
              <ul>
                <li><a href="component_navbar.html"><i class="fa fa-list-alt"></i> Navbar</a></li>
                <li><a href="component_banner.html"><i class="fa fa-tv"></i> Banner</a></li>
                <li><a href="component_sidebar.html"><i class="fa fa-th-list"></i> Sidebar - default</a></li>
                <li><a href="component_sidebar_line.html"><i class="fa fa-th-list"></i> Sidebar - line</a></li>
                <li><a class="active" href="component_sidebar_icon.html"><i class="fa fa-th-list"></i> Sidebar - icon</a></li>
                <li><a href="component_footer.html"><i class="fa fa-copyright"></i> Footer</a></li>
              </ul>
            </li>

            <li>
              <a href="#"><i class="fa fa-th-large"></i> Reports</a>
              <ul>
                <li><a href="component_navbar.html"><i class="fa fa-list-alt"></i> Navbar</a></li>
                <li><a href="component_banner.html"><i class="fa fa-tv"></i> Banner</a></li>
                <li><a href="component_sidebar.html"><i class="fa fa-th-list"></i> Sidebar - default</a></li>
                <li><a href="component_sidebar_line.html"><i class="fa fa-th-list"></i> Sidebar - line</a></li>
                <li><a class="active" href="component_sidebar_icon.html"><i class="fa fa-th-list"></i> Sidebar - icon</a></li>
                <li><a href="component_footer.html"><i class="fa fa-copyright"></i> Footer</a></li>
              </ul>
            </li>

            <li>
              <a href="#"><i class="fa fa-th-large"></i> Todays Route</a>
              <ul>
                <li><a href="component_navbar.html"><i class="fa fa-list-alt"></i> Navbar</a></li>
                <li><a href="component_banner.html"><i class="fa fa-tv"></i> Banner</a></li>
                <li><a href="component_sidebar.html"><i class="fa fa-th-list"></i> Sidebar - default</a></li>
                <li><a href="component_sidebar_line.html"><i class="fa fa-th-list"></i> Sidebar - line</a></li>
                <li><a class="active" href="component_sidebar_icon.html"><i class="fa fa-th-list"></i> Sidebar - icon</a></li>
                <li><a href="component_footer.html"><i class="fa fa-copyright"></i> Footer</a></li>
              </ul>
            </li>

            <li>
              <a href="#"><i class="fa fa-th-large"></i> Work Orders</a>
              <ul>
                <li><a href="component_navbar.html"><i class="fa fa-list-alt"></i> Navbar</a></li>
                <li><a href="component_banner.html"><i class="fa fa-tv"></i> Banner</a></li>
                <li><a href="component_sidebar.html"><i class="fa fa-th-list"></i> Sidebar - default</a></li>
                <li><a href="component_sidebar_line.html"><i class="fa fa-th-list"></i> Sidebar - line</a></li>
                <li><a class="active" href="component_sidebar_icon.html"><i class="fa fa-th-list"></i> Sidebar - icon</a></li>
                <li><a href="component_footer.html"><i class="fa fa-copyright"></i> Footer</a></li>
              </ul>
            </li>

            <li>
              <a href="#"><i class="fa fa-th-large"></i> Inovices/Payments</a>
              <ul>
                <li><a href="component_navbar.html"><i class="fa fa-list-alt"></i> Navbar</a></li>
                <li><a href="component_banner.html"><i class="fa fa-tv"></i> Banner</a></li>
                <li><a href="component_sidebar.html"><i class="fa fa-th-list"></i> Sidebar - default</a></li>
                <li><a href="component_sidebar_line.html"><i class="fa fa-th-list"></i> Sidebar - line</a></li>
                <li><a class="active" href="component_sidebar_icon.html"><i class="fa fa-th-list"></i> Sidebar - icon</a></li>
                <li><a href="component_footer.html"><i class="fa fa-copyright"></i> Footer</a></li>
              </ul>
            </li>

            <li>
              <a href="#"><i class="fa fa-th-large"></i> Chat</a>
              <ul>
                <li><a href="component_navbar.html"><i class="fa fa-list-alt"></i> Navbar</a></li>
                <li><a href="component_banner.html"><i class="fa fa-tv"></i> Banner</a></li>
                <li><a href="component_sidebar.html"><i class="fa fa-th-list"></i> Sidebar - default</a></li>
                <li><a href="component_sidebar_line.html"><i class="fa fa-th-list"></i> Sidebar - line</a></li>
                <li><a class="active" href="component_sidebar_icon.html"><i class="fa fa-th-list"></i> Sidebar - icon</a></li>
                <li><a href="component_footer.html"><i class="fa fa-copyright"></i> Footer</a></li>
              </ul>
            </li>

            <li>
              <a href="#"><i class="fa fa-th-large"></i> Settings</a>
              <ul>
                <li><a href="component_navbar.html"><i class="fa fa-list-alt"></i> Navbar</a></li>
                <li><a href="component_banner.html"><i class="fa fa-tv"></i> Banner</a></li>
                <li><a href="component_sidebar.html"><i class="fa fa-th-list"></i> Sidebar - default</a></li>
                <li><a href="component_sidebar_line.html"><i class="fa fa-th-list"></i> Sidebar - line</a></li>
                <li><a class="active" href="component_sidebar_icon.html"><i class="fa fa-th-list"></i> Sidebar - icon</a></li>
                <li><a href="component_footer.html"><i class="fa fa-copyright"></i> Footer</a></li>
              </ul>
            </li>

            <li>
              <a href="#"><i class="fa fa-list"></i> Menu level</a>
              <ul>
                <li><a href="#">Level 1</a></li>
                <li>
                  <a href="#">Level 1</a>
                  <ul>
                    <li><a href="#">Level 2</a></li>
                    <li>
                      <a href="#">Level 2</a>
                      <ul>
                        <li><a href="#">Level 3</a></li>
                        <li><a href="#">Level 3</a></li>
                      </ul>
                    </li>
                    <li><a href="#">Level 2</a></li>
                  </ul>
                </li>
                <li><a href="#">Level 1</a></li>
                <li><a href="#">Level 1</a></li>
              </ul>
            </li>

          </ul>

        </aside>
        <!-- END Sidebar -->


        <!-- Main content -->
        <article class="col-md-9 col-sm-9 main-content" role="main">

          <header>
            <h1>Sidebar</h1>
            <p>A necessary component for your documentation template. Categorize your pages in different categories and let your readers to easily navigate between the pages.</p>
          </header>

          <section>
            <p>You can find an example of a sidebar in left side of this page. A sample code is as follow.</p>
            <div class="code-snippet">
<pre class="line-numbers"><code class="language-markup">
&lt;aside class=&quot;col-md-3 sidebar&quot;&gt;

  &lt;ul class=&quot;sidenav&quot;&gt;
    &lt;li&gt;
      &lt;a href=&quot;#&quot;&gt;Getting started&lt;/a&gt;
      &lt;ul&gt;
        &lt;li&gt;&lt;a href=&quot;#&quot;&gt;Overview&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a href=&quot;#&quot;&gt;How to install&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a href=&quot;#&quot;&gt;Configuration&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a href=&quot;#&quot;&gt;Next step&lt;/a&gt;&lt;/li&gt;
      &lt;/ul&gt;
    &lt;/li&gt;

    &lt;li&gt;
      Components
      &lt;ul&gt;
        &lt;li&gt;&lt;a href=&quot;#&quot;&gt;Code&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a href=&quot;#&quot;&gt;Promo&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a href=&quot;#&quot;&gt;Steps&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a href=&quot;#&quot;&gt;Media&lt;/a&gt;&lt;/li&gt;
      &lt;/ul&gt;
    &lt;/li&gt;

    &lt;li&gt;
      &lt;a href=&quot;#&quot;&gt;&lt;span class=&quot;fa fa-css3&quot;&gt;&lt;/span&gt;CSS&lt;/a&gt;
      &lt;ul&gt;
        &lt;li&gt;&lt;a href=&quot;#&quot;&gt;&lt;span class=&quot;fa fa-font&quot;&gt;&lt;/span&gt; Typography&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a href=&quot;#&quot;&gt;&lt;span class=&quot;fa fa-tag&quot;&gt;&lt;/span&gt; Label&lt;/a&gt;&lt;/li&gt;
        &lt;li&gt;&lt;a href=&quot;#&quot;&gt;&lt;span class=&quot;fa fa-square-o&quot;&gt;&lt;/span&gt; Button&lt;/a&gt;&lt;/li&gt;
      &lt;/ul&gt;
    &lt;/li&gt;
  &lt;/ul&gt;

&lt;/aside&gt;
</code></pre>
            </div>


            <div class="callout callout-info" role="alert">
              <h4>Dropable</h4>
              <p>If you want to show sub-links by clicking on main category, add <code>.dropable</code> class to your <code>.sidenav</code>. You can add <code>.open</code> class to your <code>.sidenav ul</code> to make them open by default.</p>
            </div>

            <div class="callout callout-info" role="alert">
              <h4>Sticky</h4>
              <p>If you want to have your sidebar always in screen, even after scrolling, add <code>.sticky</code> class to the <code>.sidenav</code> tag.</p>
            </div>

            <h3>Variations</h3>
            <p>Checkout other examples of sidebar component. You should add your desire class to the <code>.sidebar</code> tag.</p>

            <div class="row">
              <div class="col-md-4">
                <div class="promo">
                  <img class="bordered" src="assets/img/sidebar-default.png" alt="default">
                  <h3>Default</h3>
                  <p>It's default sidebar type, doesn't require any class.</p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="promo">
                  <img class="bordered" src="assets/img/sidebar-line.png" alt="line">
                  <h3>Line</h3>
                  <p>Uses <code>.sidebar-line</code> class.</p>
                  <a class="btn btn-purple" href="component_sidebar_line.html">Demo</a>
                </div>
              </div>

              <div class="col-md-4">
                <div class="promo">
                  <img class="bordered" src="assets/img/sidebar-icon.png" alt="icon">
                  <h3>Icon</h3>
                  <p>Uses <code>.sidebar-icon</code> class.</p>
                  <a class="btn btn-purple" href="component_sidebar_icon.html">Demo</a>
                </div>
              </div>
            </div>

          </section>


        </article>


    <!-- END Main content -->
    </div>
</main>

    <!-- Footer -->
    <footer class="site-footer">
      <div class="container">
        <a id="scroll-up" href="#"><i class="fa fa-angle-up"></i></a>

        <div class="row">
          <div class="col-md-6 col-sm-6">
            <p>Pool Report System 2017. All right reserved</p>
          </div>
          <div class="col-md-6 col-sm-6">
            <ul class="footer-menu">
              <li><a href="page_changelog.html">Changelog</a></li>
              <li><a href="mailto:support@poolreportsystem.com">Contact us</a></li>
            </ul>
          </div>
        </div>
      </div>
    </footer>
    <!-- END Footer -->

    <!-- Scripts -->
    <script src="{{ asset('storage/js/theDocs.all.min.js') }}"></script>

  </body>
</html>
