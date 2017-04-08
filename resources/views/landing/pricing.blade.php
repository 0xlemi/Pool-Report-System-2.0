@extends('landing.main')

@section('content')

 <!-- =========================
           PRICING
        ============================== -->
        <section id="pricing5-1" class="p-y-lg bg-edit bg-light">
            <div class="container">
                <!-- Section Header -->
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="section-header text-center wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
                            <h2>Pricing</h2>
                            <p class="lead">We only charge for active users and the first 2 are free.</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-10 col-md-offset-1 c2">
                        <!-- Dynamic Options -->
                        <div class="col-md-6">
                            <div class="options-table">
                                <form>
                                    <div class="switch">
                                        <p class="package-title">Need More Than 2 Users ?</p>
                                        <input id="package1" class="package-toggle toggle-round-flat" type="checkbox" data-price="5">
                                        <label for="package1"></label>
                                    </div>
                                </form>
                            </div>
                        </div><!--/End Col Options -->

                        <!-- Dynamic Price -->
                        <div class="col-md-6">
                            <div class="pricing-table">
                                <ul class="list-unstyled">
                                    <li class="price text-edit"><i>$</i><span>0</span></li>
                                    <li class="text-edit">First 2 users are completly <strong>FREE</strong></li>
                                    <li class="package1 text-edit">Per user/month</li>
                                    <li class="package1 text-edit">Add all the users you want.</li>
                                    <li class="m-t p-b"><a href="{{ url('/register') }}" class="btn btn-shadow btn-blue text-uppercase">GET STARTED NOW</a></li>
                                </ul>
                            </div>
                        </div><!-- /End Col Price -->

                    </div><!-- /End Col-10 -->
                </div><!-- /End Row -->
                <!-- Pricing Note -->
                <div class="row">
                    <br>
                    <div class="col-md-8 col-md-offset-2 text-center">
                        <p><strong>Note.</strong> All of this prices are in US Dollars.<br>
                            *Users are registed supervisors or technicians.
                        </p>
                    </div>
                </div>
            </div><!-- /End Container -->

        </section>

@include('landing.footer')
@endsection
