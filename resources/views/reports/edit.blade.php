@extends('layouts.app')

@section('content')
	<header class="section-header">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3>Edit Report</h3>
					<ol class="breadcrumb breadcrumb-simple">
						<li><a href="{{ url('reports') }}">Reports</a></li>
						<li><a href="{{ url('reports/'.$report->seq_id) }}">View Report {{ $report->seq_id }}</a></li>
						<li class="active">Edit Report {{ $report->seq_id }}</li>
					</ol>
				</div>
			</div>
		</div>
	</header>
	<div class="row">
		<div class="col-md-12 col-lg-12 col-xl-8 col-xl-offset-2">
			<section class="card">
					<header class="card-header card-header-lg">
						Report info:
					</header>
					<div class="card-block">
						<form method="POST" action="{{ url('reports/'.$report->seq_id) }}">
							{{ csrf_field() }}
							{{ method_field('PATCH') }}
							<div class="form-group row {{($errors->has('completed_at'))? 'form-group-error':''}}">
								<label class="col-sm-2 form-control-label">Compleated at:</label>
								<div class="col-sm-10">
									<div class='input-group date' id="edit_report_datepicker">
										<input type='text' name='completed_at' class="form-control" id="edit_report_datepicker_input"/>
										@if ($errors->has('completed_at'))
											<small class="text-muted">{{ $errors->first('completed_at') }}</small>
										@endif
										<span class="input-group-addon">
											<i class="font-icon font-icon-calend"></i>
										</span>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Service</label>
								<div class="col-sm-10">
									<select class="bootstrap-select bootstrap-select-arrow" name="service" data-live-search="true">
										@foreach($services as $service)
											<option data-content='<span class="user-item"><img src="{{ url($service->icon()) }}"/>
														{{ $service->seq_id.' '.$service->name.' '.$service->last_name}}
														</span>' {{ ($report->service()->id == $service->id) ? 'selected':''}}
														value="{{ $service->seq_id }}">
														{{ $service->name.' '.$service->last_name }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Technician</label>
								<div class="col-sm-10">
									<select class="bootstrap-select bootstrap-select-arrow" name="technician" data-live-search="true">
										@foreach($technicians as $technician)
											<option data-content='<span class="user-item">
														<img src="{{ url($technician->icon()) }}"/>
														{{ $technician->seq_id.' '.$technician->name.' '.$technician->last_name}}
													</span>' {{ ($report->technician()->id == $technician->id) ? 'selected':''}}
														value="{{ $technician->seq_id }}">
														{{ $technician->name.' '.$technician->last_name }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">PH</label>
								<div class="col-md-3 col-lg-3 col-xl-4">
									<select class="bootstrap-select bootstrap-select-arrow" name="ph">
										<option data-content='<span class="glyphicon glyphicon-asterisk"
																style="color: #FA424A;">
																</span>&nbsp;&nbsp;Very High'
																{{ ($report->ph == 5) ? 'selected':''}}
																value="5" >Very High
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk"
																style="color: #FDAD2A;">
																</span>&nbsp;&nbsp;High'
																{{ ($report->ph == 4) ? 'selected':''}}
																value="4" >High
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk"
																style="color: #46C35F;">
																</span>&nbsp;&nbsp;Perfect'
																{{ ($report->ph == 3) ? 'selected':''}}
																value="3" >Perfect
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk"
																style="color: #00A8FF;">
																</span>&nbsp;&nbsp;Low'
																{{ ($report->ph == 2) ? 'selected':''}}
																value="2" >Low
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk"
																style="color: #AC6BEC;">
																</span>&nbsp;&nbsp;Very Low'
																{{ ($report->ph == 1) ? 'selected':''}}
																value="1" >Very Low
										</option>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Clorine</label>
								<div class="col-md-3 col-lg-3 col-xl-4">
									<select class="bootstrap-select bootstrap-select-arrow" name="clorine">
										<option data-content='<span class="glyphicon glyphicon-asterisk"
																style="color: #FA424A;">
																</span>&nbsp;&nbsp;Very High'
																{{ ($report->clorine == 5) ? 'selected':''}}
																value="5" >Very High
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk"
																style="color: #FDAD2A;">
																</span>&nbsp;&nbsp;High'
																{{ ($report->clorine == 4) ? 'selected':''}}
																value="4" >High
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk"
																style="color: #46C35F;">
																</span>&nbsp;&nbsp;Perfect'
																{{ ($report->clorine == 3) ? 'selected':''}}
																value="3" >Perfect
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk"
																style="color: #00A8FF;">
																</span>&nbsp;&nbsp;Low'
																{{ ($report->clorine == 2) ? 'selected':''}}
																value="2" >Low
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk"
																style="color: #AC6BEC;">
																</span>&nbsp;&nbsp;Very Low'
																{{ ($report->clorine == 1) ? 'selected':''}}
																value="1" >Very Low
										</option>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Temperature</label>
								<div class="col-md-3 col-lg-3 col-xl-4">
									<select class="bootstrap-select bootstrap-select-arrow" name="temperature">
										<option data-content='<span class="glyphicon glyphicon-asterisk"
																style="color: #FA424A;">
																</span>&nbsp;&nbsp;Very High'
																{{ ($report->temperature == 5) ? 'selected':''}}
																value="5" >Very High
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk"
																style="color: #FDAD2A;">
																</span>&nbsp;&nbsp;High'
																{{ ($report->temperature == 4) ? 'selected':''}}
																value="4" >High
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk"
																style="color: #46C35F;">
																</span>&nbsp;&nbsp;Perfect'
																{{ ($report->temperature == 3) ? 'selected':''}}
																value="3" >Perfect
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk"
																style="color: #00A8FF;">
																</span>&nbsp;&nbsp;Low'
																{{ ($report->temperature == 2) ? 'selected':''}}
																value="2" >Low
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk"
																style="color: #AC6BEC;">
																</span>&nbsp;&nbsp;Very Low'
																{{ ($report->temperature == 1) ? 'selected':''}}
																value="1" >Very Low
										</option>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Turbidity</label>
								<div class="col-md-3 col-lg-3 col-xl-4">
									<select class="bootstrap-select bootstrap-select-arrow" name="turbidity">
										<option data-content='<span class="glyphicon glyphicon-asterisk"
																style="color: #FA424A;">
																</span>&nbsp;&nbsp;Very High'
																{{ ($report->turbidity == 4) ? 'selected':''}}
																value="4" >Very High
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk"
																style="color: #FDAD2A;">
																</span>&nbsp;&nbsp;High'
																{{ ($report->turbidity == 3) ? 'selected':''}}
																value="3" >High
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk"
																style="color: #00A8FF;">
																</span>&nbsp;&nbsp;Low'
																{{ ($report->turbidity == 2) ? 'selected':''}}
																value="2" >Low
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk"
																style="color: #46C35F;">
																</span>&nbsp;&nbsp;Perfect'
																{{ ($report->turbidity == 1) ? 'selected':''}}
																value="1" >Perfect
										</option>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 form-control-label">Salt</label>
								<div class="col-md-3 col-lg-3 col-xl-4">
									<select class="bootstrap-select bootstrap-select-arrow" name="salt">
										<option data-content='<span class="glyphicon glyphicon-asterisk"
																style="color: #FA424A;">
																</span>&nbsp;&nbsp;Very High'
																{{ ($report->salt == 5) ? 'selected':''}}
																value="5" >Very High
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk"
																style="color: #FDAD2A;">
																</span>&nbsp;&nbsp;High'
																{{ ($report->salt == 4) ? 'selected':''}}
																value="5" >High
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk"
																style="color: #46C35F;">
																</span>&nbsp;&nbsp;Perfect'
																{{ ($report->salt == 3) ? 'selected':''}}
																value="3" >Perfect
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk"
																style="color: #00A8FF;">
																</span>&nbsp;&nbsp;Low'
																{{ ($report->salt == 2) ? 'selected':''}}
																value="2" >Low
										</option>
										<option data-content='<span class="glyphicon glyphicon-asterisk"
																style="color: #AC6BEC;">
																</span>&nbsp;&nbsp;Very Low'
																{{ ($report->salt == 1) ? 'selected':''}}
																value="1" >Very Low
										</option>
									</select>
								</div>
							</div>
							<br>
							<br>
							<p style="float: left;">
								<a  class="btn btn-danger"
								href="{{ url('/reports/'.$report->seq_id) }}">
								<i class="glyphicon glyphicon-arrow-left"></i>&nbsp;&nbsp;&nbsp;Go back</a>
								<button  class="btn btn-success"
								type='submit'>
								<i class="font-icon font-icon-ok"></i>&nbsp;&nbsp;&nbsp;Save Changes</button>
							</p>
						</form>
						<br>
						<br>
						<hr>
						<h4>Photos</h4>
						<br>
						<div class="row">
							@foreach($report->images as $image)
	                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-5 m-b-md">
	                                <div class="gallery-col">
										<article class="gallery-item">
											<img class="gallery-picture" src="{{ url($image->thumbnail_path) }}" alt="" height="158">
											<div class="gallery-hover-layout">
												<div class="gallery-hover-layout-in">
													<p class="gallery-item-title">{{ get_image_tag($image->order) }}</p>
													<div class="btn-group">
														<a class="fancybox btn" href="{{ url($image->normal_path) }}" title="{{ get_image_tag($image->order) }}">
															<i class="font-icon font-icon-eye"></i>
														</a>
														<a href="{{ url('reports/photos/'.$report->seq_id.'/'.$image->order) }}"
															data-method="delete" data-token="{{ csrf_token() }}"  class="btn">
															<i class="font-icon font-icon-trash"></i>
														</a>
													</div>
													<p>Photo number {{ $image->order }}</p>
												</div>
											</div>
										</article>
									</div><!--.gallery-col-->
	                            </div><!--.col-->
                            @endforeach
                        </div><!--.row-->
                        <br>
						<div class="row">
                            <div class="col-sm-12">
                                <div class="box-typical-upload box-typical-upload-in">
                                    <div class="drop-zone">
	                                    <form id="addPhotosReport" action="{{ url('reports/photos/'.$report->seq_id)}}" method="POST" class="dropzone">
	                                    	{{ csrf_field() }}
	                                    	<div class="dz-message" data-dz-message><span><i class="font-icon font-icon-cloud-upload-2"></i>
	                                        <div class="drop-zone-caption">Drag file or click to add photos</div></span></div>
	                                    </form>
                                    </div><!--.drop-zone-->
                                </div>
                            </div><!--.col-->
                        </div><!--.row-->
					</div>
			</section>
		</div>
	</div>
@endsection
