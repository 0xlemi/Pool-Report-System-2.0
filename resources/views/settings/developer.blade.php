@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-md-12 col-lg-12 col-xl-8 col-xl-offset-2">
		<section class="card">
				<header class="card-header card-header-lg">
					Developer Settings:
				</header>
				<div class="card-block">

                    <div class="form-group row">
						<div class="col-sm-12">
                            <passport-clients></passport-clients>
						</div>
					</div>
                    <div class="form-group row">
						<div class="col-sm-12">
                            <passport-authorized-clients></passport-authorized-clients>
						</div>
					</div>
                    <div class="form-group row">
						<div class="col-sm-12">
                            <passport-personal-access-tokens></passport-personal-access-tokens>
						</div>
					</div>
				</div>
		</section>
	</div>
</div>

@endsection
