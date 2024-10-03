@extends('employee.layouts.app')
@push('css')

	<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/plugins/fontawesome/css/fontawesome.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/plugins/fontawesome/css/all.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/line-awesome.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/material.css')}}">
	<link rel="stylesheet" href="{{asset('assets/plugins/daterangepicker/daterangepicker.css')}}">
	<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/feather.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/line-awesome.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
	<style type="text/css">
		.close-icon {
			position: absolute;
			cursor: pointer;
			font-size: 12px;
			background: #ff2f2f;
			width: 20px;
			height: 20px;
			border-radius: 50%;
			text-align: center;
			align-content: center;
			color: #ffffff;
			margin: 0 !important;
		}
	</style>
@endpush
@section('content')

<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="page-header">
			<div class="row align-items-center">
				<div class="col">
					<h3 class="page-title">{{$property->name}}</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="admin-dashboard.html">Dashboard</a></li>
						<li class="breadcrumb-item active">Property</li>
					</ul>
				</div>
				<div class="col-auto float-end ms-auto">
					<a href="#" class="btn add-btn" href="javascript:void(0);"
						data-data="{{json_encode($property->toArray())}}"
						data-href="{{route('admin.project.update', $property->id)}}" onclick="edit_property($(this))"><i
							class="fa-solid fa-plus"></i> Edit Property</a>
					<!-- <a href="task-board.html" class="btn btn-white float-end me-3" data-bs-toggle="tooltip" title="Task Board"><i class="fa-solid fa-bars"></i></a> -->
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-7 col-xl-8">
				<div class="card">
					<div class="card-body">
						<div class="project-title">
							<h5 class="card-title">{{$property->name}}</h5>
							<!-- <small class="block text-ellipsis m-b-15"><span class="text-xs">2</span> <span class="text-muted">open tasks, </span><span class="text-xs">5</span> <span class="text-muted">tasks completed</span></small> -->
						</div>
						<p>{{$property->note}}</p>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<h5 class="card-title m-b-20">Uploaded image files <button type="button"
								class="float-end btn btn-primary btn-sm" data-bs-toggle="modal"
								data-bs-target="#add_images"><i class="fa-solid fa-plus"></i> Add</button>
							<button type="button" class="float-end btn btn-primary btn-sm edit"
								onclick="$('.img-edit').toggleClass('d-none');$('.Cancel').toggleClass('d-none');$(this).toggleClass('d-none');"><i
									class="fa-solid fa-pencil"></i> Edit</button>
							<button type="button" class="float-end btn btn-primary btn-sm Cancel d-none"
								onclick="$('.img-edit').toggleClass('d-none');$('.edit').toggleClass('d-none');$(this).toggleClass('d-none');"><i
									class="fa-solid fa-cancel"></i> Cancel</button>
						</h5>
						<div class="row">
							@if($property->images)
													@foreach(json_decode($property->images) as $id => $image)
																			<div class="col-md-3 col-sm-4 col-lg-4 col-xl-3">
																				<div class="uploaded-box">
																					<div class="uploaded-img">
																						<img src="{{asset('assets/img/property/' . $image)}}" class="img-fluid"
																							alt="Placeholder Image">
																						<span class="close-icon img-edit d-none" title="Remove"
																							data-href="{{route('admin.properties.image_delete', $property->id)}}?id={{$id}}"
																							onclick="delete_file($(this))">X</span>
																					</div>
																					<div class="uploaded-img-name">
																						@php
																							$img = explode('-', $image);
																							unset($img[0]);
																							$image = implode('-', $img);
																						   @endphp
																						{{$image}}
																					</div>
																				</div>
																			</div>
													@endforeach
							@endif
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<h5 class="card-title m-b-20">Uploaded files <button type="button"
								class="float-end btn btn-primary btn-sm" data-bs-toggle="modal"
								data-bs-target="#add_files"><i class="fa-solid fa-plus"></i> Add</button></h5>
						<ul class="files-list">
							@if($property->files)
													@foreach(json_decode($property->files) as $keyd => $file)
																			<li>
																				<div class="files-cont">
																					<div class="file-type">
																						<span class="files-icon"><i class="fa-regular fa-file-pdf"></i></span>
																					</div>
																					<div class="files-info">
																						<span class="file-name text-ellipsis"><a href="#">
																								@php
																									$fl = explode('-', $file);
																									unset($fl[0]);
																									$fls = implode('-', $fl);
																								   @endphp
																								{{$fls}}
																							</a></span>
																						<!-- <span class="file-author"><a href="#">John Doe</a></span> <span class="file-date">May 31st at 6:53 PM</span> -->
																						<div class="file-size">Size:
																							{{number_format((filesize('assets/img/property/' . $file) / 1024), 2)}}KB
																						</div>
																					</div>
																					<ul class="files-action">
																						<li class="dropdown dropdown-action">
																							<a href="#" class="dropdown-toggle btn btn-link" data-bs-toggle="dropdown"
																								aria-expanded="false"><i class="material-icons">more_horiz</i></a>
																							<div class="dropdown-menu dropdown-menu-right">
																								<a class="dropdown-item"
																									href="{{asset('assets/img/property/' . $file)}}"
																									download>Download</a>
																								<!-- <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#share_files">Share</a> -->
																								<a class="dropdown-item" href="javascript:void(0)"
																									data-href="{{route('admin.properties.file_delete', $property->id)}}?id={{$keyd}}"
																									onclick="delete_file($(this))">Delete</a>
																							</div>
																						</li>
																					</ul>
																				</div>
																			</li>
													@endforeach
							@endif

						</ul>
					</div>
				</div>

			</div>
			<div class="col-lg-5 col-xl-4">
				<div class="card">
					<div class="card-body">
						<h6 class="card-title m-b-15">Project details</h6>
						<table class="table table-striped table-border">
							<tbody>
								@php
									//dd($property->property_type);
								 @endphp
								<tr>
									<td>Property category:</td>
									<td class="text-end">{{$property->property_category}}</td>
								</tr>
								<tr>
									<td>Property Type:</td>
									<td class="text-end">{{$property->property_type}}</td>
								</tr>
								<tr>
									<td>Project Unit Type:</td>
									<td class="text-end">{{$property->unit_type}}</td>
								</tr>
								<tr>
									<td>Project Unit No:</td>
									<td class="text-end">{{$property->unit_no}}</td>
								</tr>
								<tr>
									<td>Furnishing:</td>
									<td class="text-end">{{$property->furnishing}}</td>
								</tr>

								<tr>
									<td>Availability:</td>
									<td class="text-end">{{$property->availability}}</td>
								</tr>
								<tr>
									<td>Covered Parking:</td>
									<td class="text-end">{{$property->covered_parking}}</td>
								</tr>
								<tr>
									<td>Bathrooms:</td>
									<td class="text-end">{{$property->bathrooms}}</td>
								</tr>
								<tr>
									<td>Ownership:</td>
									<td class="text-end">{{$property->ownership}}</td>
								</tr>
								<tr>
									<td>Buildup Area Dimensions:</td>
									<td class="text-end">{{$property->buildup_area_dimensions}}</td>
								</tr>
								<tr>
									<td>Buildup Area:</td>
									<td class="text-end">{{$property->buildup_area}}</td>
								</tr>
								<tr>
									<td>Carpet Area Dimensions:</td>
									<td class="text-end">{{$property->carpet_area_dimensions}}</td>
								</tr>

								<tr>
									<td>Carpet Area :</td>
									<td class="text-end">{{$property->carpet_area}}</td>
								</tr>
								<tr>
									<td>Super Area Dimensions:</td>
									<td class="text-end">{{$property->super_area_dimensions}}</td>
								</tr>
								<tr>
									<td>Super Area :</td>
									<td class="text-end">{{$property->super_area}}</td>
								</tr>
								<tr>
									<td>Length Dimensions:</td>
									<td class="text-end">{{$property->length_dimensions}}</td>
								</tr>
								<tr>
									<td>Length:</td>
									<td class="text-end">{{$property->lengths}}</td>
								</tr>
								<tr>
									<td>Breadth Dimensions:</td>
									<td class="text-end">{{$property->breadth_dimensions}}</td>
								</tr>
								<tr>
									<td>Breadth:</td>
									<td class="text-end">{{$property->breadth}}</td>
								</tr>









								<tr>
									<td>Developed By:</td>
									<td class="text-end">{{$property->developed_by}}</td>
								</tr>
								<!-- <tr>
                                    <td>Priority:</td>
                                    <td class="text-end">
                                       <div class="btn-group">
                                          <a href="#" class="badge badge-danger dropdown-toggle" data-bs-toggle="dropdown">Highest </a>
                                          <div class="dropdown-menu dropdown-menu-right">
                                             <a class="dropdown-item" href="#"><i class="fa-regular fa-circle-dot text-danger"></i> Highest priority</a>
                                             <a class="dropdown-item" href="#"><i class="fa-regular fa-circle-dot text-info"></i> High priority</a>
                                             <a class="dropdown-item" href="#"><i class="fa-regular fa-circle-dot text-primary"></i> Normal priority</a>
                                             <a class="dropdown-item" href="#"><i class="fa-regular fa-circle-dot text-success"></i> Low priority</a>
                                          </div>
                                       </div>
                                    </td>
                                 </tr> -->
								<tr>
									<td>Created by:</td>
									<td class="text-end"><a href="profile.html">Barry Cuda</a></td>
								</tr>
								<tr>
									<td>Status:</td>
									@if($property->status == 1)
										<td class="text-end">Active</td>
									@else
										<td class="text-end">Inactive</td>
									@endif
								</tr>
							</tbody>
						</table>

					</div>
				</div>
				<div class="card project-user">
					<div class="card-body">
						<h6 class="card-title m-b-20">Assigned USer <button type="button"
								class="float-end btn btn-primary btn-sm" data-bs-toggle="modal"
								data-bs-target="#assign_leader"><i class="fa-solid fa-plus"></i> Add/Change</button>
						</h6>
						<ul class="list-box">
							<li>
								<a href="profile.html">
									<div class="list-item">
										<div class="list-left">
											<span class="avatar">
												@if($property->user && $property->user->image)
													<img src="{{asset('assets/img/employee/' . $property->user->image)}}"
														alt="User Image">
												@else
													<img src="{{asset('assets/img/avatar/images-dummy.jpg')}}"
														alt="User Image">
												@endif
											</span>
										</div>
										<div class="list-body">
											<span
												class="message-author">{{ $property->user ? ($property->user->first_name . ' ' . $property->user->last_name) : ''}}</span>
											<div class="clearfix"></div>
											<span
												class="message-content">{{ $property->user ? ($property->user->designation->name) : ''}}</span>
										</div>
									</div>
								</a>
							</li>
						</ul>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

@endsection
@section('modal')

<div id="add_files" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add PDF Files</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="{{route('admin.properties.add_files', $property->id)}}" method="post"
					enctype="multipart/form-data">
					@csrf
					<div class="input-group m-b-30">
						<input class="form-control search-input" type="file" name="files[]" multiple>
						<button type="submit" class="btn btn-primary">Upload</button>
					</div>
				</form>
				<div>
					<ul class="chat-user-list">
						<li>
							<span class="designation">You can Select Multiple files</span>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="add_images" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Images</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="{{route('admin.properties.add_images', $property->id)}}" method="post"
					enctype="multipart/form-data">
					@csrf
					<div class="input-group m-b-30">
						<input class="form-control search-input" type="file" name="files[]" multiple>
						<button type="submit" class="btn btn-primary">Upload</button>
					</div>
				</form>
				<div>
					<ul class="chat-user-list">
						<li>
							<span class="designation">You can Select Multiple files</span>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="assign_leader" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Assign Leader to this property</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="{{route('admin.properties.add_user', $property->id)}}" method="post"
				enctype="multipart/form-data">
				@csrf
				<div class="modal-body">
					<div class="input-group m-b-30">
						<select class="select" name="user_id">
							<option value="">Select</option>
							@foreach(get_employees() as $employee)
								<option value="{{$employee->id}}">{{$employee->first_name . ' ' . $employee->last_name}}
								</option>
							@endforeach
						</select>
					</div>
					<div class="submit-section">
						<button class="btn btn-primary submit-btn">Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div id="assign_user" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Assign the user to this project</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="input-group m-b-30">
					<input placeholder="Search a user to assign" class="form-control search-input" type="text">
					<button class="btn btn-primary">Search</button>
				</div>
				<div>
					<ul class="chat-user-list">
						<li>
							<a href="#">
								<div class="chat-block d-flex">
									<span class="avatar"><img src="assets/img/profiles/avatar-09.jpg"
											alt="User Image"></span>
									<div class="media-body align-self-center text-nowrap">
										<div class="user-name">Richard Miles</div>
										<span class="designation">Web Developer</span>
									</div>
								</div>
							</a>
						</li>
						<li>
							<a href="#">
								<div class="chat-block d-flex">
									<span class="avatar"><img src="assets/img/profiles/avatar-10.jpg"
											alt="User Image"></span>
									<div class="media-body align-self-center text-nowrap">
										<div class="user-name">John Smith</div>
										<span class="designation">Android Developer</span>
									</div>
								</div>
							</a>
						</li>
						<li>
							<a href="#">
								<div class="chat-block d-flex">
									<span class="avatar">
										<img src="assets/img/profiles/avatar-16.jpg" alt="User Image">
									</span>
									<div class="media-body align-self-center text-nowrap">
										<div class="user-name">Jeffery Lalor</div>
										<span class="designation">Team Leader</span>
									</div>
								</div>
							</a>
						</li>
					</ul>
				</div>
				<div class="submit-section">
					<button class="btn btn-primary submit-btn">Submit</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="edit_property" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Property</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="{{route('admin.properties.update')}}" method="post" enctype="multipart/form-data">
					@csrf
					<h5 class="modal-title">Property Info</h5>
					<hr>
					<div class="row">

						<div class="col-sm-4">
							<div class="input-block mb-3">
								<label class="col-form-label">Project</label>
								<select class="select" name="project" id="project" required>
									@foreach(get_projects() as $project)
										<option value="{{$project->id}}">{{$project->name}}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="col-sm-4">
							<div class="input-block mb-3">
								<input class="form-control" type="hidden" name="id" id="property_id" required>
								<label class="col-form-label">Property Name</label>
								<input class="form-control" type="text" name="property_name" id="property_name"
									required>
							</div>
						</div>

						<div class="col-sm-4">
							<div class="input-block mb-3">
								<label class="col-form-label">City</label>
								<input class="form-control" type="text" name="city" id="city" required>
							</div>
						</div>
					</div>
					<h5 class="modal-title">Basic Info</h5>
					<hr>
					<div class="row">
						<div class="col-sm-4">
							<div class="input-block mb-3">
								<label class="col-form-label">Property category</label>
								<select class="select" name="property_category" id="property_category" required>
									<option>Resdential</option>
									<option>Commercial</option>
								</select>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="input-block mb-3">
								<label class="col-form-label">Property Type</label>
								<select class="select" name="property_type" id="property_type" required>
									<option>Apartment</option>
									<option>Independent House/ Villa</option>
									<option>Independent Builder Floor</option>
									<option>Studio Apartment</option>
									<option>Serviced Apartment</option>
									<option>Farm House</option>
									<option>Residential Plot</option>
									<option>Office</option>
									<option>Retail</option>
									<option>Commercial Land</option>
									<option>Industrial Land</option>
									<option>Showroom</option>
									<option>Warehouse</option>
								</select>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="input-block mb-3">
								<label class="col-form-label">Unit Type</label>
								<select class="select" name="unit_type" id="unit_type" required>
									<option>1 BHK</option>
									<option>2 BHK</option>
									<option>3 BHK</option>
									<option>4 BHK</option>
									<option>3 plus 1 BHK</option>
								</select>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="input-block mb-3">
								<label class="col-form-label">Unit No</label>
								<input class="form-control" type="text" name="unit_no" id="unit_no" required>
							</div>
						</div>

						<div class="col-sm-4">
							<div class="input-block mb-3">
								<label class="col-form-label">Furnishing</label>
								<select class="select" name="furnishing" id="furnishing">
									<option>Furnished</option>
									<option>Semi-furnished</option>
									<option>Unfurnished</option>
								</select>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="input-block mb-3">
								<label class="col-form-label">Availability</label>
								<select class="select" name="availability" id="availability">
									<option>Immediate</option>
									<option>Within 6 Months</option>
									<option>Within 1 Year</option>
									<option>Within 2 Year</option>
								</select>
							</div>
						</div>

						<div class="col-sm-4">
							<div class="input-block mb-3">
								<label class="col-form-label">Covered Parking</label>
								<select class="select" name="covered_parking" id="covered_parking">
									<option>1</option>
									<option>2</option>
									<option>3</option>
									<option>4</option>
									<option>5</option>
								</select>
							</div>
						</div>

						<div class="col-sm-4">
							<div class="input-block mb-3">
								<label class="col-form-label">Open Parking </label>
								<select class="select" name="open_parking" id="open_parking">
									<option>1</option>
									<option>2</option>
									<option>3</option>
									<option>4</option>
									<option>5</option>
								</select>
							</div>
						</div>

						<div class="col-sm-4">
							<div class="input-block mb-3">
								<label class="col-form-label">Bathrooms </label>
								<select class="select" name="bathrooms" id="bathrooms">
									<option>1</option>
									<option>2</option>
									<option>3</option>
									<option>4</option>
									<option>5</option>
								</select>
							</div>
						</div>

						<div class="col-sm-4">
							<div class="input-block mb-3">
								<label class="col-form-label">Ownership </label>
								<select class="select" name="ownership" id="ownership">
									<option>Freehold</option>
									<option>Leasehold</option>
									<option>Co-operative Society</option>
									<option>Co-operative Society</option>
									<option>Power of Attorney</option>
								</select>
							</div>
						</div>

					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="input-block mb-3">
								<label class="col-form-label">Other Details</label>
								<textarea class="form-control" name="other_details" id="other_details"></textarea>
							</div>
						</div>
					</div>
					<h5 class="modal-title">Dimensions</h5>
					<hr>
					<div class="row">
						<div class="col-sm-4">
							<label class="col-form-label">Buildup Area</label>
							<div class="row">
								<select class="select col-sm-4" name="buildup_area_dimensions"
									id="buildup_area_dimensions">
									<option>Sq. Yds</option>
									<option>Sq. Ft</option>
									<option>Sq. Mt</option>
								</select>
								<input class="form-control col-sm-8" type="text" name="buildup_area" id="buildup_area">
							</div>
						</div>

						<div class="col-sm-4">
							<div class="input-block mb-3">
								<label class="col-form-label">Carpet Area</label>
								<div class="row">
									<select class="select col-sm-4" name="carpet_area_dimensions"
										id="carpet_area_dimensions">
										<option>Sq. Yds</option>
										<option>Sq. Ft</option>
										<option>Sq. Mt</option>
									</select>
									<input class="form-control col-sm-8" type="text" name="carpet_area"
										id="carpet_area">
								</div>
							</div>
						</div>

						<div class="col-sm-4">
							<div class="input-block mb-3">
								<label class="col-form-label">Super Area</label>
								<div class="row">
									<select class="select col-sm-4" name="super_area_dimensions"
										id="super_area_dimensions">
										<option>Sq. Yds</option>
										<option>Sq. Ft</option>
										<option>Sq. Mt</option>
									</select>
									<input class="form-control col-sm-8" type="text" name="super_area" id="super_area">
								</div>
							</div>
						</div>

						<div class="col-sm-4">
							<div class="input-block mb-3">
								<label class="col-form-label">Length</label>
								<div class="row">
									<select class="select col-sm-4" name="length_dimensions" id="length_dimensions">
										<option>yds</option>
										<option>ft</option>
										<option>mts</option>
									</select>
									<input class="form-control col-sm-8" type="text" name="length" id="length">
								</div>
							</div>
						</div>

						<div class="col-sm-4">
							<div class="input-block mb-3">
								<label class="col-form-label">Breadth</label>
								<div class="row">
									<select class="select col-sm-4" name="breadth_dimensions" id="breadth_dimensions">
										<option>yds</option>
										<option>ft</option>
										<option>mts</option>
									</select>
									<input class="form-control col-sm-8" type="text" name="breadth" id="breadth">
								</div>
							</div>
						</div>

						<div class="col-sm-4">
							<div class="input-block mb-3">
								<label class="col-form-label">Plot Area</label>
								<div class="row">
									<select class="select col-sm-4" name="plot_area_dimensions"
										id="plot_area_dimensions">
										<option>Sq. Yds</option>
										<option>Sq. Ft</option>
										<option>Sq. Mt</option>
									</select>
									<input class="form-control col-sm-8" type="text" name="plot_area" id="plot_area">
								</div>
							</div>
						</div>


					</div>
					<h5 class="modal-title">Pricing</h5>
					<hr>
					<div class="row">
						<div class="col-sm-4">
							<div class="input-block mb-3">
								<label class="col-form-label">Expected Pricing</label>
								<div class="row">
									<select class="select col-sm-4" name="expecte_pricing" id="expecte_pricing">
										<option>per Sq. Yd</option>
										<option>per Sq. Ft</option>
										<option>per Sq. Mt</option>
										<option>per Sq. Mt</option>
										<option>per Unit</option>
									</select>
									<input class="form-control col-sm-8" type="text" name="project_open_area"
										id="project_open_area">
								</div>
							</div>
						</div>

						<div class="col-sm-4">
							<div class="input-block mb-3">
								<label class="col-form-label">Price Negotiable </label>
								<select class="select" name="price_negotiable" id="price_negotiable">
									<option>No</option>
									<option>Yes</option>
								</select>
							</div>
						</div>
					</div>

					<h5 class="modal-title">Seller Details</h5>
					<hr>
					<div class="row">
						<div class="col-sm-4">
							<div class="input-block mb-3">
								<label class="col-form-label">Seller Type </label>
								<select class="select" name="seller_type" id="seller_type">
									<option>Broker</option>
									<option>Owner</option>
								</select>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="input-block mb-3">
								<label class="col-form-label">Seller Name </label>
								<input class="form-control" type="text" name="seller_name" id="seller_name">
							</div>
						</div>

						<div class="col-sm-4">
							<div class="input-block mb-3">
								<label class="col-form-label">Mobile</label>
								<input class="form-control" type="text" name="seller_mobile" id="seller_mobile"
									maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
									pattern="[0-9]{10}" title="Mobile number must be 10 digits">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="input-block mb-3">
								<label class="col-form-label">Alt Number</label>
								<input class="form-control" type="text" name="seller_alt_mobile" id="seller_alt_mobile"
									maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
									pattern="[0-9]{10}" title="Mobile number must be 10 digits">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="input-block mb-3">
								<label class="col-form-label">Email</label>
								<input class="form-control" type="text" name="seller_email" id="seller_email">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="input-block mb-3">
								<label class="col-form-label">Address</label>
								<input class="form-control" type="text" name="seller_address" id="seller_address">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="input-block mb-3">
								<h5 class="mb-3">Status</h5>
								<div class="status-radio-btns d-flex">
									<div class="people-status-radio">
										<input type="radio" class="status-radio" id="tests6-1" name="project_status"
											value="1">
										<label for="tests6-1">Active</label>
									</div>
									<div class="people-status-radio">
										<input type="radio" class="status-radio" id="tests7-0" name="project_status"
											value="0">
										<label for="tests7-0">Inactive</label>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="submit-section">
						<button class="btn btn-primary submit-btn">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal custom-modal fade" id="delete_models" role="dialog">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body">
				<div class="form-header">
					<h3>Remove File</h3>
					<p>Are you sure want to delete?</p>
				</div>
				<div class="modal-btn delete-action">
					<div class="row">
						<div class="col-6">
							<a href="javascript:void(0);" class="btn btn-primary continue-btn" id="d-okay">Delete</a>
						</div>
						<div class="col-6">
							<a href="javascript:void(0);" data-bs-dismiss="modal"
								class="btn btn-primary cancel-btn">Cancel</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
@section('scripts')
<script data-cfasync="false"
	src="{{asset('assets/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js')}}"></script>
<script src="{{asset('assets/js/jquery-3.7.1.min.js')}}" type="712a4b0e0e5ee5c24248da6b-text/javascript"></script>
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}" type="712a4b0e0e5ee5c24248da6b-text/javascript"></script>
<script src="{{asset('assets/js/jquery.slimscroll.min.js')}}" type="712a4b0e0e5ee5c24248da6b-text/javascript"></script>
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}" type="712a4b0e0e5ee5c24248da6b-text/javascript"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"
	type="712a4b0e0e5ee5c24248da6b-text/javascript"></script>
<script src="{{asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"
	type="712a4b0e0e5ee5c24248da6b-text/javascript"></script>
<script src="{{asset('assets/js/moment.min.js')}}" type="712a4b0e0e5ee5c24248da6b-text/javascript"></script>
<script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}"
	type="712a4b0e0e5ee5c24248da6b-text/javascript"></script>
<script src="{{asset('assets/js/moment.min.js')}}" type="712a4b0e0e5ee5c24248da6b-text/javascript"></script>
<script src="{{asset('assets/plugins/daterangepicker/daterangepicker.js')}}"
	type="712a4b0e0e5ee5c24248da6b-text/javascript"></script>
<script src="{{asset('assets/js/select2.min.js')}}" type="712a4b0e0e5ee5c24248da6b-text/javascript"></script>
<script src="{{asset('assets/plugins/summernote/summernote-bs4.min.js')}}"
	type="712a4b0e0e5ee5c24248da6b-text/javascript"></script>
<script src="{{asset('assets/js/layout.js')}}" type="712a4b0e0e5ee5c24248da6b-text/javascript"></script>
<!-- <script src="{{asset('assets/js/theme-settings.js')}}" type="712a4b0e0e5ee5c24248da6b-text/javascript"></script> -->
<!-- <script src="{{asset('assets/js/greedynav.js')}}" type="712a4b0e0e5ee5c24248da6b-text/javascript"></script> -->
<script src="{{asset('assets/js/app.js')}}" type="712a4b0e0e5ee5c24248da6b-text/javascript"></script>
<script src="{{asset('assets/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js')}}"
	data-cf-settings="712a4b0e0e5ee5c24248da6b-|49" defer></script>
<script type="text/javascript">
	function edit_property(el) {
		var data = $.parseJSON(el.attr("data-data"));

		$('#property_name').val(data.name);
		$('#property_id').val(data.id);
		$('#city').val(data.city);
		$('#project').val(data.project_id).change();
		$('#property_category').val(data.property_category).change();
		$('#property_type').val(data.property_type).change();
		$('#unit_type').val(data.unit_type).change();
		$('#furnishing').val(data.furnishing).change();
		$('#availability').val(data.availability).change();
		$('#covered_parking').val(data.covered_parking).change();
		$('#open_parking').val(data.open_parking).change();
		$('#bathrooms').val(data.bathrooms).change();
		$('#ownership').val(data.ownership).change();
		$('#buildup_area_dimensions').val(data.buildup_area_dimensions).change();
		$('#super_area_dimensions').val(data.super_area_dimensions).change();
		$('#length_dimensions').val(data.length_dimensions).change();
		$('#breadth_dimensions').val(data.breadth_dimensions).change();
		$('#plot_area_dimensions').val(data.plot_area_dimensions).change();
		$('#expecte_pricing').val(data.expecte_pricing).change();
		$('#price_negotiable').val(data.price_negotiable).change();
		$('#seller_type').val(data.seller_type).change();
		$('#unit_no').val(data.unit_no);
		$('#other_details').val(data.other_details);
		$('#buildup_area').val(data.buildup_area);
		$('#super_area').val(data.super_area);
		$('#length').val(data.lengths);
		$('#breadth').val(data.breadth);
		$('#plot_area').val(data.plot_area);
		$('#project_open_area').val(data.project_open_area);
		$('#seller_name').val(data.seller_name);
		$('#seller_mobile').val(data.seller_mobile);
		$('#seller_alt_mobile').val(data.seller_alt_mobile);
		$('#seller_email').val(data.seller_email);
		$('#seller_address').val(data.seller_address);

		if (data.status == 1) {
			$('#tests6-1').prop("checked", true);
		} else {
			$('#tests7-0').prop("checked", true);
		}


		$('#edit_property').modal('show');
	}


	function reset_f() {
		$('.feild-set').css("display", "none");
		$('#edit-first-field').css("display", "block");
		$('.f-li').removeClass('active');
		$('#f-li').addClass('active');
	}

	function delete_file(el) {
		$('#d-okay').attr("href", el.attr("data-href"));
		$('#delete_models').modal('show');
	}
</script>
@endsection