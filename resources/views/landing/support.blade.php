@extends('landing.main')

@section('content')
<section id="faq3-1" class="p-y-lg faqs schedule">

    <div class="container">
        <!-- Section Header -->
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="section-header text-center wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
                    <h2 class="m-b-md">Wanna Quick Support?</h2>
                    <p class="lead m-b-md">We are here for any question you might have.
                        <br> Make sure to check the tutorial and FAQ sections you might find your answers there.
                    </p>
                    <a href="mailto:support@poolreportsystem.com?subject=Support Request" class="btn btn-green">Email Your Question</a>
                    <!-- <a href="" class="btn btn-blue">Send Us a Tweet</a> -->
                </div>
            </div>
        </div>
        <!-- Faq Panel -->
        <div class="row p-t-md c2">
            <div class="col-md-6">
                <h4 class="text-center m-b-md">Basic</h4>
                <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <p class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">If I subscribe buissness plan for three users. How much is it going to cost ?</a>
                            </p>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <p>You are only going to be changed 1 user because the first 2 are free.</p>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <p class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Can I send feature requests?</a>
                            </p>
                        </div>
                        <div id="collapse2" class="panel-collapse collapse">
                            <div class="panel-body">
                                <p>We are actively searching for cool features to add to the system, we really appreciate you taking the time to send feature requests. Send them to support@poolreportsystem.com</p>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="panel panel-default">
                        <div class="panel-heading">
                            <p class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">How to deposit money in Themeforest to purchase GetLeads?</a>
                            </p>
                        </div> -->
                        <!-- <div id="collapse3" class="panel-collapse collapse">
                            <div class="panel-body">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A tenetur accusamus nobis nisi consectetur fugiat aliquam beatae dignissimos sed commodi. Sapiente sequi possimus accusamus qui, a sed facere! Aspernatur ullam officia, molestias minus quidem praesentium laboriosam, corporis quaerat distinctio at est eaque, aliquam, totam dolore. Dolor repellendus delectus, omnis labore maiores consectetur fuga quaerat in expedita. Cum praesentium dolore rerum consequatur.</p>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <p class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">Can i get support after purchasing this theme?</a>
                            </p>
                        </div>
                        <div id="collapse4" class="panel-collapse collapse">
                            <div class="panel-body">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A tenetur accusamus nobis nisi consectetur fugiat aliquam beatae dignissimos sed commodi. Sapiente sequi possimus accusamus qui, a sed facere! Aspernatur ullam officia, molestias minus quidem praesentium laboriosam, corporis quaerat distinctio at est eaque, aliquam, totam dolore. Dolor repellendus delectus, omnis labore maiores consectetur fuga quaerat in expedita. Cum praesentium dolore rerum consequatur.</p>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <p class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse5">What kind of security do you provide through GetLeads?</a>
                            </p>
                        </div>
                        <div id="collapse5" class="panel-collapse collapse">
                            <div class="panel-body">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A tenetur accusamus nobis nisi consectetur fugiat aliquam beatae dignissimos sed commodi. Sapiente sequi possimus accusamus qui, a sed facere! Aspernatur ullam officia, molestias minus quidem praesentium laboriosam, corporis quaerat distinctio at est eaque, aliquam, totam dolore. Dolor repellendus delectus, omnis labore maiores consectetur fuga quaerat in expedita. Cum praesentium dolore rerum consequatur.</p>
                            </div>
                        </div>
                    </div> -->
                </div><!-- /End Panel Group -->
            </div><!-- /End Col -->

            <div class="col-md-6">
                <h4 class="text-center m-b-md">Technical</h4>
                <div class="panel-group" id="accordion-tech">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <p class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion-tech" href="#collapse11">Can I import company information from my own database?</a>
                            </p>
                        </div>
                        <div id="collapse11" class="panel-collapse collapse">
                            <div class="panel-body">
                                <p>Depends, send us a email with the information about your current system to support@poolreportsystem.com</p>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="panel panel-default">
                        <div class="panel-heading">
                            <p class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion-tech" href="#collapse12">How to install or modify this theme?</a>
                            </p>
                        </div>
                        <div id="collapse12" class="panel-collapse collapse">
                            <div class="panel-body">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A tenetur accusamus nobis nisi consectetur fugiat aliquam beatae dignissimos sed commodi. Sapiente sequi possimus accusamus qui, a sed facere! Aspernatur ullam officia, molestias minus quidem praesentium laboriosam, corporis quaerat distinctio at est eaque, aliquam, totam dolore. Dolor repellendus delectus, omnis labore maiores consectetur fuga quaerat in expedita. Cum praesentium dolore rerum consequatur.</p>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <p class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion-tech" href="#collapse13">How to deposit money in Themeforest to purchase GetLeads?</a>
                            </p>
                        </div>
                        <div id="collapse13" class="panel-collapse collapse">
                            <div class="panel-body">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A tenetur accusamus nobis nisi consectetur fugiat aliquam beatae dignissimos sed commodi. Sapiente sequi possimus accusamus qui, a sed facere! Aspernatur ullam officia, molestias minus quidem praesentium laboriosam, corporis quaerat distinctio at est eaque, aliquam, totam dolore. Dolor repellendus delectus, omnis labore maiores consectetur fuga quaerat in expedita. Cum praesentium dolore rerum consequatur.</p>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <p class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion-tech" href="#collapse14">Can i get support after purchasing this theme?</a>
                            </p>
                        </div>
                        <div id="collapse14" class="panel-collapse collapse">
                            <div class="panel-body">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A tenetur accusamus nobis nisi consectetur fugiat aliquam beatae dignissimos sed commodi. Sapiente sequi possimus accusamus qui, a sed facere! Aspernatur ullam officia, molestias minus quidem praesentium laboriosam, corporis quaerat distinctio at est eaque, aliquam, totam dolore. Dolor repellendus delectus, omnis labore maiores consectetur fuga quaerat in expedita. Cum praesentium dolore rerum consequatur.</p>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <p class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion-tech" href="#collapse15">What kind of security do you provide through GetLeads?</a>
                            </p>
                        </div>
                        <div id="collapse15" class="panel-collapse collapse">
                            <div class="panel-body">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A tenetur accusamus nobis nisi consectetur fugiat aliquam beatae dignissimos sed commodi. Sapiente sequi possimus accusamus qui, a sed facere! Aspernatur ullam officia, molestias minus quidem praesentium laboriosam, corporis quaerat distinctio at est eaque, aliquam, totam dolore. Dolor repellendus delectus, omnis labore maiores consectetur fuga quaerat in expedita. Cum praesentium dolore rerum consequatur.</p>
                            </div>
                        </div> -->
                    </div>
                </div><!-- /End Panel Group -->
            </div><!-- /End Col -->
        </div><!-- /End Row -->
    </div><!-- /End Container -->

</section>

@include('landing.footer')
@endsection
