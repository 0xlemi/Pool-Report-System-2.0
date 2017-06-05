@extends('layouts.app')

@section('content')
<header class="section-header">
	<div class="tbl">
		<div class="tbl-row">
			<div class="tbl-cell">
				<h3>Create Work Order</h3>
				<ol class="breadcrumb breadcrumb-simple">
					<li><a href="{{ url('workorders') }}">Work Orders</a></li>
					<li class="active">Create Work Order</li>
				</ol>
			</div>
		</div>
	</div>
</header>
<div class="row">
	<div class="col-md-12 col-lg-12 col-xl-8 col-xl-offset-2">
		<section class="card">
				<header class="card-header card-header-lg">
					Work Order info:
				</header>
				<div class="card-block">
					<form method="POST" action="{{ url('workorders') }}" enctype="multipart/form-data">
						{{ csrf_field() }}

						<div class="form-group row {{($errors->has('title'))? 'form-group-error':''}}">
							<label class="col-sm-2 form-control-label">Title:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control maxlength-simple"
										name="title" maxlength="50" value="{{ old('title') }}">
								@if ($errors->has('title'))
									<small class="text-muted">{{ $errors->first('title') }}</small>
								@endif
							</div>
						</div>

						<div class="form-group row {{($errors->has('service'))? 'form-group-error':''}}">
							<label class="col-sm-2 form-control-label">Service</label>
							<div class="col-sm-10">
								<dropdown :key="{{ old('service') }}"
											:options="{{ $services }}"
											:name="'service'">
								</dropdown>
								@if ($errors->has('service'))
									<small class="text-muted">{{ $errors->first('service') }}</small>
								@endif
							</div>
						</div>

        				@role('admin')
                        <div class="form-group row {{($errors->has('person'))? 'form-group-error':''}}">
							<label class="col-sm-2 form-control-label">Person</label>
							<div class="col-sm-10">
								<dropdown :key="{{ old('person') }}"
											:options="{{ $persons }}"
											:name="'person'">
								</dropdown>
								@if ($errors->has('person'))
									<small class="text-muted">{{ $errors->first('person') }}</small>
								@endif
							</div>
						</div>
        				@endrole

                        <div class="form-group row {{($errors->has('price') || $errors->has('currency'))? 'form-group-error':''}}">
							<label class="col-sm-2 form-control-label">Price:</label>
							<div class="col-sm-10">
								<div class="input-group">
									<div class="input-group-addon">$</div>
									<input type="text" class="form-control money-mask-input"
											name="price" placeholder="Amount"
											value="{{ old('price') }}">
									<div class="input-group-addon">
										<select name='currency'>
											@foreach ($currencies as $currency)
												<option value="{{ $currency }}" {{ (old('currency') == $currency) ? 'selected':'' }}>{{ $currency }}</option>
											@endforeach
										</select>
									</div>
								</div>
								@if ($errors->has('price'))
									<small class="text-muted">{{ $errors->first('price') }}</small>
								@endif
								@if ($errors->has('currency'))
									<small class="text-muted">{{ $errors->first('currency') }}</small>
								@endif
							</div>
						</div>

                        <div class="form-group row {{($errors->has('start'))? 'form-group-error':''}}">
							<label class="col-sm-2 form-control-label">Started at:</label>
							<div class="col-sm-10">
								<div class='input-group date' id="genericDatepicker">
									<input type='text' name='start' class="form-control"
											id="genericDatepickerInput"
											value="{{ old('start') }}"/>
									@if ($errors->has('start'))
										<small class="text-muted">{{ $errors->first('start') }}</small>
									@endif
									<span class="input-group-addon">
										<i class="font-icon font-icon-calend"></i>
									</span>
								</div>
							</div>
						</div>

						<div class="form-group row {{($errors->has('description'))? 'form-group-error':''}}">
							<label class="col-sm-2 form-control-label">Description:</label>
							<div class="col-sm-10">
								<textarea rows="5" class="form-control"
											placeholder="Describe the work order to be done."
											name="description">{{ old('description') }}</textarea>
								@if ($errors->has('description'))
									<small class="text-muted">{{ $errors->first('description') }}</small>
								@endif
							</div>
						</div>

						<br>
						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Photo</label>
							<div class="col-sm-10">
				                <div class="fileupload fileupload-new" data-provides="fileupload">
				                  <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
				                  <img src="{{ \Storage::url('images/assets/app/no_image.png') }}" alt="Placeholder" /></div>
				                  <div class="fileupload-preview fileupload-exists thumbnail"
				                   		style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
				                  @if ($errors->has('photo'))
				                  	<br>
									<span class="label label-danger">{{ $errors->first('photo') }}</span>
									<br><br>
								  @endif
				                  <div>
				                    <span class="btn btn-default btn-file">
				                    <span class="fileupload-new">Select image</span>
				                    <span class="fileupload-exists">Change</span>
				                    <input type="file" name="photo" id="photo" ></span>
				                    <a href="#" class="btn btn-default fileupload-exists"
				                    	data-dismiss="fileupload">Remove</a>
				                  </div>
				                </div>
			              	</div>
						</div>

						<hr>
						<p style="float: left;">
							<a  class="btn btn-danger"
							href="{{ url('workorders') }}">
							<i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Go back</a>
							<button  class="btn btn-success"
							type='submit'>
							<i class="font-icon font-icon-ok"></i>&nbsp;&nbsp;&nbsp;Create Work Order</button>
						</p>
						<br>
						<br>
					</form>
				</div>
		</section>
	</div>
</div>
@endsection
