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
								<div class='input-group date' id="editGenericDatepicker">
									<input type='text' name='completed_at' class="form-control" id="editGenericDatepickerInput"/>
									@if($errors->has('completed_at'))
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
								<dropdown :key="{{ $report->service()->seq_id }}"
											:options="{{ $services }}"
											:name="'service'">
								</dropdown>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Technician</label>
							<div class="col-sm-10">
								<dropdown :key="{{ $report->technician()->seq_id }}"
											:options="{{ $technicians }}"
											:name="'technician'">
								</dropdown>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">PH</label>
							<div class="col-md-3 col-lg-3 col-xl-4">
								<select class="bootstrap-select bootstrap-select-arrow" name="ph">
									@foreach($tags->ph()->asArrayWithColor() as $key => $tag)
									<option data-content='
										<span class="glyphicon glyphicon-asterisk"
												style="color: {{$tag->color}};">
										</span>
										&nbsp;&nbsp;{{$tag->text}}'
										value="{{$key}}"
										{{ ($report->ph == $key) ? 'selected':''}}>
									</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Chlorine</label>
							<div class="col-md-3 col-lg-3 col-xl-4">
								<select class="bootstrap-select bootstrap-select-arrow" name="chlorine">
									@foreach($tags->chlorine()->asArrayWithColor() as $key => $tag)
									<option data-content='
										<span class="glyphicon glyphicon-asterisk"
												style="color: {{$tag->color}};">
										</span>
										&nbsp;&nbsp;{{$tag->text}}'
										value="{{$key}}"
										{{ ($report->chlorine == $key) ? 'selected':''}}>
									</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Temperature</label>
							<div class="col-md-3 col-lg-3 col-xl-4">
								<select class="bootstrap-select bootstrap-select-arrow" name="temperature">
									@foreach($tags->temperature()->asArrayWithColor() as $key => $tag)
									<option data-content='
										<span class="glyphicon glyphicon-asterisk"
												style="color: {{$tag->color}};">
										</span>
										&nbsp;&nbsp;{{$tag->text}}'
										value="{{$key}}"
										{{ ($report->temperature == $key) ? 'selected':''}}>
									</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Turbidity</label>
							<div class="col-md-3 col-lg-3 col-xl-4">
								<select class="bootstrap-select bootstrap-select-arrow" name="turbidity">
									@foreach($tags->turbidity()->asArrayWithColor() as $key => $tag)
									<option data-content='
										<span class="glyphicon glyphicon-asterisk"
												style="color: {{$tag->color}};">
										</span>
										&nbsp;&nbsp;{{$tag->text}}'
										value="{{$key}}"
										{{ ($report->turbidity == $key) ? 'selected':''}}>
									</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-2 form-control-label">Salt</label>
							<div class="col-md-3 col-lg-3 col-xl-4">
								<select class="bootstrap-select bootstrap-select-arrow" name="salt">
									@foreach($tags->salt()->asArrayWithColor() as $key => $tag)
									<option data-content='
										<span class="glyphicon glyphicon-asterisk"
												style="color: {{$tag->color}};">
										</span>
										&nbsp;&nbsp;{{$tag->text}}'
										value="{{$key}}"
										{{ ($report->salt == $key) ? 'selected':''}}>
									</option>
									@endforeach
								</select>
							</div>
						</div>

						<br>
						<br>
						<p style="float: right;">
							<a  class="btn btn-warning"
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
                                    <form id="genericDropzone" action="{{ url('reports/photos/'.$report->seq_id)}}" method="POST" class="dropzone">
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
