@extends('landing.main')

@section('content')

<!-- =========================
           PRICING
        ============================== -->
        <section id="pricing2-1" class="p-y-lg bg-edit bg-light content-align-sm">
            <div class="container">
                <div class="row pricing-st y-middle">
                    <!-- Pricing Table -->
                    <div class="col-md-5 col-sm-6 m-b">
                        <div class="info text-center">
                            <h4 class="m-b f-w-900 text-left">Become a member</h4>
                            <div class="price text-edit text-left"> <span class="currency">$</span>29</div>
                            <p class="m-t-lg m-b-md f-w-900 text-left">Perfect for single freelancers who work by themselves</p>
                            <ul class="details text-right m-b-lg text-edit">
                                <li>Unlimited access to all courses</li>
                                <li>Unlimited access to all screencasts</li>
                                <li>Engage with the latest technologies</li>
                                <li>Cancel anytime</li>
                            </ul>
                            <a class="btn btn-shadow btn-green text-uppercase" href="">Start Learning Now</a>
                        </div>
                    </div>
                    <!-- Testimonial Carousel -->
                    <div class="col-md-5 col-sm-6 text-center">

                        <div id="carousel-testimonial4" class="carousel slide carousel-fade carousel-testimonial-single" data-ride="carousel">
                            <!-- Indicators -->
                            <ol class="carousel-indicators inverse">
                                <li data-target="#carousel-testimonial4" data-slide-to="0" class="active"></li>
                                <li data-target="#carousel-testimonial4" data-slide-to="1" class=""></li>
                            </ol>

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" role="listbox">
                                <!-- Testimonial 1 -->
                                <div class="item next left">
                                    <blockquote>
                                        <figure><img src="images/testimonial1.jpg" alt="" class="img-circle img-thumbnail m-b-md" width="150" height="150"> </figure>
                                        <p class="p-opacity m-b-md">Optio accusamus quos ratione iusto non pariatur voluptatum! Eos ipsam maxime assumenda quas, unde officia provident nam, ducimus veritatis eius suscipit, amet ullam consequatur odit sapiente.</p>
                                        <cite class="p-opacity text-edit"><strong>Justin Jordan</strong>, Ipsum Enterpreneur</cite>
                                    </blockquote>
                                </div>
                                <!-- Testimonial 2 -->
                                <div class="item active left">
                                    <blockquote>
                                        <figure><img src="images/testimonial3.jpg" alt="" class="img-circle img-thumbnail m-b-md" width="150" height="150"> </figure>
                                        <p class="p-opacity m-b-md">Optio accusamus quos ratione iusto non pariatur voluptatum! Eos ipsam maxime assumenda quas, unde officia provident nam, ducimus veritatis eius suscipit, amet ullam consequatur odit sapiente.</p>
                                        <cite class="p-opacity text-edit"><strong>Justin Jordan</strong>, Ipsum Enterpreneur</cite>
                                    </blockquote>
                                </div>
                            </div>
                        </div>

                    </div><!-- /End Testimonial Carousel -->
                </div><!-- /End Row -->
            </div><!-- /End Container -->
        </section>

@include('landing.footer')
@endsection
