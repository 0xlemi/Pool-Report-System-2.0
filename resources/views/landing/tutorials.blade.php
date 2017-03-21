@extends('landing.main')

@section('content')

<!-- =========================
   VIDEO
============================== -->
<section id="video5-1" class="p-y-lg bg-edit">

    <div class="container">
        <div class="row video">
            <!-- Section Header -->
            <div class="col-md-8 col-md-offset-2">
                <div class="section-header text-center wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
                    <h2>Complete System Overview</h2>
                    <p class="lead">Lets explain how Pool Report System works.<br> And how the different parts fit in.</p>
                </div>
            </div>
            <!-- Video Iframe -->
            <div class="col-md-10 col-md-offset-1 text-center">
                <div class="videoWrapper">
                    <!-- <iframe width="560" height="315" src="https://www.youtube.com/embed/sU3FkzUKHXU" allowfullscreen=""></iframe> -->
                    <img src="{{ \Storage::url('images/assets/landing/coming_soon.png') }}" width="950" height="530" alt="Coming Soon" />
                </div>
            </div>
        </div><!-- /End Row -->
    </div><!-- /End Container -->

</section>
<!-- /End Video Section --><!-- =========================
   VIDEO
============================== -->
<section id="video2-1" class="p-y-lg content-align-md bg-edit">
    <div class="container">
        <div class="row video y-middle c2">
            <div class="col-md-5">
                <h3 class="f-w-900">Quick overview of the android app</h3>
                <p class="h5">The moble app has the same functionality the web app, but there are some differences that need to be clear up.</p>
            </div>
            <div class="col-md-6">
                <div class="videoWrapper">
                    <!-- <iframe width="560" height="315" src="https://www.youtube.com/embed/sU3FkzUKHXU" allowfullscreen=""></iframe> -->
                    <img src="{{ \Storage::url('images/assets/landing/coming_soon.png') }}" alt="Coming Soon" />
                </div>
            </div><!--/End Col -->
        </div><!--/End Row -->
    </div><!-- /End Container -->
</section><!-- =========================
   SOCIAL WIDGET
============================== -->
<section id="social1-1" class="p-b-lg bg-edit">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 text-center share-color">
                <div class="col-md-4 col-md-offset-2">
                    <a target="_blank" href="https://www.youtube.com/channel/UCTe2VUvEMl1k9AsgidvQc4A" class="share-block gp"><i class="fa fa-youtube"></i>Watch the rest on Youtube</a>
                </div>
                <div class="col-md-4">
                    <a target="_blank" href="https://vimeo.com/poolreportsystem" class="share-block twt"><i class="fa fa-vimeo"></i>Watch the rest on Vimeo</a>
                </div>
            </div>
        </div><!-- /End Row -->
    </div><!-- /End Container -->
</section>

@include('landing.footer')
@endsection
