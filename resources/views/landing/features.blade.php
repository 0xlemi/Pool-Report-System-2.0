@extends('landing.main')

@section('content')

<!-- =========================
       FEATURES SECTION
    ============================== -->
    <section id="features5-1" class="p-y-lg bg-edit">
        <div class="container">
            <!-- Section Header -->
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="section-header text-center wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
                    <h2>The Things You are Going To Love.</h2>
                        <p class="lead">If you never had custom made software, you are in for a treat.</p>
                    </div>
                </div>
            </div>

            <div class="row features-block text-center">
                <div class="col-md-10 col-md-offset-1 c2">
                    <!-- Features Item -->
                    <div class="col-sm-6">
                        <img src="{{ \Storage::url('images/assets/landing/wallet.png') }}" alt="" style="border-radius: 0px; border: 1px none rgb(105, 105, 110);">
                        <h5 class="m-t f-w-900">Reduce Managment Costs</h5>
                        <p>Managing a big pool service teams comes at a cost of time and money. We can replace man maniging hours with automatisation.</p>
                    </div>
                    <!-- Features Item -->
                    <div class="col-sm-6">
                        <img src="{{ \Storage::url('images/assets/landing/supervision.png') }}" alt="" style="border-radius: 0px; border: 1px none rgb(105, 105, 110);">
                        <h5 class="m-t f-w-900">Technician Supervision</h5>
                        <p>People are lazy. But not when they know they are been supervised all the time.</p>
                    </div>
                </div>
            </div>

            <div class="row features-block new-row-sm text-center">
                <div class="col-md-10 col-md-offset-1 c2">
                    <!-- Features Item -->
                    <div class="col-sm-6">
                        <img src="{{ \Storage::url('images/assets/landing/megaphone.png') }}" alt="" style="border-radius: 0px; border: 1px none rgb(105, 105, 110);">
                        <h5 class="m-t f-w-900">Client Comunication</h5>
                        <p>Let your client know how is their pool doing even if they are not there to see it, is going to give them more confidence in your pool company.</p>
                    </div>
                    <!-- Features Item -->
                    <div class="col-sm-6">
                        <img src="{{ \Storage::url('images/assets/landing/printer.png') }}" alt="" style="border-radius: 0px; border: 1px none rgb(105, 105, 110);">
                        <h5 class="m-t f-w-900">Automatization of Invoices</h5>
                        <p>Sending invoices on time is tedious and error prone. <br>Leave that to us.</p>
                    </div>
                </div>
            </div>

            <div class="row features-block new-row-sm text-center">
                <div class="col-md-10 col-md-offset-1 c2">
                    <!-- Features Item -->
                    <div class="col-sm-6">
                        <img src="{{ \Storage::url('images/assets/landing/bar-chart.png') }}" alt="" style="border-radius: 0px; border: 1px none rgb(105, 105, 110);">
                        <h5 class="m-t f-w-900">Insights In Your Company Performance</h5>
                        <p>You are going to have access to data about your company that is going to anable you to make strategic decisions.</p>
                    </div>
                    <!-- Features Item -->
                    <div class="col-sm-6">
                        <img src="{{ \Storage::url('images/assets/landing/devices.png') }}" alt="" style="border-radius: 0px; border: 1px none rgb(105, 105, 110);">
                        <h5 class="m-t f-w-900">Everything In One Place</h5>
                        <p>All your pool information is synced in the cloud and with the mobile app. You can make modifications in one place and continue in another.</p>
                    </div>
                </div>
            </div>
        </div><!-- /End Container -->

    </section>

<!-- =========================
   FEATURES SECTION
============================== -->
<section id="features8-1" class="p-y-lg content-align-md bg-edit">
    <div class="container">
        <!-- Section Header -->
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="section-header text-center wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
                    <h2>Beautifull Android App</h2>
                    <p class="lead">You can access the full system anywhere you go.</p>
                </div>
            </div>
        </div>

        <div class="row y-middle">
            <!-- Features Left -->
            <div class="col-md-4 col-sm-6">
                <ul class="features-list features-list-left list-unstyled">
                    <li class="m-b-lg wow zoomIn" style="visibility: visible; animation-name: zoomIn;">
                        <h5>All the Features</h5>
                        <p>This is not a dumb down version of the system is the full thing with all the features. But on your phone.</p>
                    </li>
                    <li class="m-b-lg wow zoomIn" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: zoomIn;">
                        <h5>Camara only Photos with Location</h5>
                        <p>Stop worring if the work is really been done. With this tools you can ensure that peolpe are where they sey they are.</p>
                    </li>
                    <li class="m-b-lg wow zoomIn" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: zoomIn;">
                        <br>
                        <br>
                        <br>
                        <br>
                        <!-- <h5>Very Flexible</h5> -->
                        <!-- <p>Rerum asperiores, sint hic iure accusantium. Quidem, placeat nam doloremque quisquam eveniet voluptatem sapiente.</p> -->
                    </li>
                </ul>
            </div>

            <!-- Features Right -->
            <div class="col-md-4 col-md-push-4 col-sm-6">
                <ul class="features-list list-unstyled">
                    <li class="m-b-lg wow zoomIn" style="visibility: visible; animation-name: zoomIn;">
                        <h5>Offline Usage</h5>
                        <p>If you dont have internet connection when doing a report. Saves the reports and resends it when connection to comes back.</p>
                    </li>
                    <li class="m-b-lg wow zoomIn" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: zoomIn;">
                        <h5>Made with Love</h5>
                        <p>Hope you love using it as much as we love making it.</p>
                    </li>
                    <li class="m-b-lg wow zoomIn" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: zoomIn;">
                        <a target="_blank" href="https://play.google.com/store/apps/details?id=com.poolreportsystem">
                            <img src="{{ \Storage::url('images/assets/landing/google-play-badge.png') }}" width="250px" alt="">
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Center Device Image -->
            <div class="col-md-4 col-md-pull-4 text-center features-list-img wow slideInUp" style="visibility: visible; animation-name: slideInUp;">
                <img src="{{ \Storage::url('images/assets/landing/androidSmall.png') }}" class="img-responsive m-x-auto" alt="">
            </div>
        </div><!-- /End Row -->
    </div><!-- /End Container -->
</section>




<!-- =========================
   FEATURES SECTION
============================== -->
<section id="features7-1" class="p-y-lg content-dashboard content-align-md bg-edit">

    <div class="container">
        <div class="row features-block y-middle">
            <!-- Image Device -->
            <div class="col-md-7 col-md-push-5 text-center wow fadeInRight" style="visibility: visible; animation-name: fadeInRight;">
                <img src="{{ \Storage::url('images/assets/landing/computer.png') }}" alt="">
            </div>
            <!-- Features -->
            <div class="col-md-5 col-md-pull-7 center-md">
                <div class="col-xs-12 p-t m-b-md">
                    <h2 class="m-b">Ready in any browser.</h2>
                    <p>Modern web application, so you can access your company information anywhere where there is a web browser.</p>
                </div>
                <div class="col-xs-12 m-b-md clearfix">
                    <div class="col-md-3">
                        <img src="{{ \Storage::url('images/assets/landing/like.png') }}"/>
                    </div>
                    <div class="col-md-9">
                        <h5 class="m-t f-w-900"> Easy to use</h5>
                        <p>Designed with ease of use as a priority.</p>
                    </div>
                </div>
                <div class="col-xs-12 m-b-md clearfix">
                    <div class="col-md-3">
                        <img src="{{ \Storage::url('images/assets/landing/cloud-computing.png') }}"/>
                    </div>
                    <div class="col-md-9">
                        <h5 class="m-t f-w-900">Everything Synced</h5>
                        <p>Everything gets synced in the cloud, all your information is in one place.</p>
                    </div>
                </div>
            </div><!-- /End Col -->
        </div><!-- /End Row -->
    </div><!-- /End Container -->

</section>

@include('landing.footer')
@endsection
