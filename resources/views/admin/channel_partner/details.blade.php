@extends('admin.layouts.app')
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
					<h3 class="page-title">{{$cpartner->cp_name}}</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="admin-dashboard.html">Dashboard</a></li>
						<li class="breadcrumb-item active">Channel Partner</li>
					</ul>
				</div>
				<div class="col-auto float-end ms-auto">
				@if(admin_has_permission('Write-CP'))
					<a href="#" class="btn add-btn" href="javascript:void(0);"
						data-data="{{json_encode($cpartner->toArray())}}"
						data-href="{{route('admin.project.update', $cpartner->id)}}" onclick="edit_Cpartner($(this))"><i
							class="fa-solid fa-plus"></i> Edit Channel Partner</a>
					@endif
					<!-- <a href="task-board.html" class="btn btn-white float-end me-3" data-bs-toggle="tooltip" title="Task Board"><i class="fa-solid fa-bars"></i></a> -->
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-7 col-xl-8">
				<div class="card">
					<div class="card-body">
						<div class="project-title">
							<h5 class="card-title">{{$cpartner->name}}</h5>
							<!-- <small class="block text-ellipsis m-b-15"><span class="text-xs">2</span> <span class="text-muted">open tasks, </span><span class="text-xs">5</span> <span class="text-muted">tasks completed</span></small> -->
						</div>
						<p>{{$cpartner->address}}</p>
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
							@if($cpartner->images)
													@foreach(json_decode($cpartner->images) as $id => $image)
																			<div class="col-md-3 col-sm-4 col-lg-4 col-xl-3">
																				<div class="uploaded-box">
																					<div class="uploaded-img">
																						<img src="{{asset('assets/img/channel_partners/' . $image)}}" class="img-fluid"
																							alt="Placeholder Image">
																						<span class="close-icon img-edit d-none" title="Remove"
																							data-href="{{route('admin.channel-partner.image_delete', $cpartner->id)}}?id={{$id}}"
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
						<h5 class="card-title m-b-20">Uploaded Document Files <button type="button"
								class="float-end btn btn-primary btn-sm" data-bs-toggle="modal"
								data-bs-target="#add_files"><i class="fa-solid fa-plus"></i> Add</button></h5>
						<ul class="files-list">
							@if($cpartner->files)
													@foreach(json_decode($cpartner->files) as $keyd => $file)
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
																							{{number_format((filesize('assets/img/channel_partners/' . $file) / 1024), 2)}}KB
																						</div>
																					</div>
																					<ul class="files-action">
																						<li class="dropdown dropdown-action">
																							<a href="#" class="dropdown-toggle btn btn-link" data-bs-toggle="dropdown"
																								aria-expanded="false"><i class="material-icons">more_horiz</i></a>
																							<div class="dropdown-menu dropdown-menu-right">
																								<a class="dropdown-item" href="{{asset('assets/img/channel_partners/' . $file)}}"
																									download>Download</a>
																								<!-- <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#share_files">Share</a> -->
																								<a class="dropdown-item" href="javascript:void(0)"
																									data-href="{{route('admin.channel-partner.file_delete', $cpartner->id)}}?id={{$keyd}}"
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
						<h6 class="card-title m-b-15">Channel Partner details</h6>
						<table class="table table-striped table-border">
							<tbody>
								@php
									//dd($cpartner->property_type);
								 @endphp
								<tr>
									<td>CP Name:</td>
									<td class="text-end">{{$cpartner->cp_name}}</td>
								</tr>
								<tr>
									<td>Phone:</td>
									<td class="text-end">{{$cpartner->phone}}</td>
								</tr>
								<tr>
									<td>Alternet Phone No.:</td>
									<td class="text-end">{{$cpartner->alt_phone}}</td>
								</tr>
								<tr>
									<td>Address Type:</td>
									<td class="text-end">{{$cpartner->address_type}}</td>
								</tr>
								<tr>
									<td>Address</td>
									<td class="text-end">{{$cpartner->address}}</td>
								</tr>
								@if($cpartner->branch->name??'')
								<tr>
									<td>Branch Name</td>
									<td class="text-end">{{$cpartner->branch->name}}</td>
								</tr>
								@endif

								 
								 
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
									<td>Status:</td>
									@if($cpartner->cp_status == 1)
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
												@if($cpartner->user && $cpartner->user->image)
													<img src="{{asset('assets/img/employee/' . $cpartner->user->image)}}"
														alt="User Image">
												@else
													<img src="{{asset('assets/img/avatar/images-dummy.jpg')}}"
														alt="User Image">
												@endif
											</span>
										</div>
										<div class="list-body">
											<span
												class="message-author">{{ $cpartner->user ? ($cpartner->user->first_name . ' ' . $cpartner->user->last_name) : ''}}</span>
											<div class="clearfix"></div>
											<span
												class="message-content">{{ $cpartner->user ? ($cpartner->user->designation->name) : ''}}</span>
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
				<form action="{{route('admin.channel-partner.add_files', $cpartner->id)}}" method="post"
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
				<form action="{{route('admin.channel-partner.add_images', $cpartner->id)}}" method="post"
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
				<h5 class="modal-title">Assign CP Owner</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="{{route('admin.channel-partner.add_user', $cpartner->id)}}" method="post"
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
<div id="edit_Cpartner" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Channel Partner</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="editForm" method="post" enctype="multipart/form-data">
					@csrf
					<div class="row">
						<div class="col-sm-6">
							<div class="input-block mb-3">
								<input class="form-control" type="hidden" name="id" id="edit_id">
								<label class="col-form-label">CP Owner</label>
								<select class="select" name="user_id" id="edit_user_id">
									<option value="">Select</option>
									@foreach(get_employees() as $employee)
										<option value="{{$employee->id}}">
											{{$employee->first_name . ' ' . $employee->last_name}}
										</option>
									@endforeach
								</select>
								<span class="text-danger error-text user_id_error"></span>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="input-block mb-3">
								<label class="col-form-label">CP Name</label>
								<input class="form-control" type="text" name="cp_name" id="edit_cp_name">
								<span class="text-danger error-text cp_name_error"></span>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="input-block mb-3">
								<label class="col-form-label">Contact No</label>
								<input class="form-control" type="text" name="phone" id="edit_phone">
								<span class="text-danger error-text phone_error"></span>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="input-block mb-3">
								<label class="col-form-label">Alt. Contact No.</label>
								<input class="form-control" type="text" name="alt_phone" id="edit_alt_phone">
								<span class="text-danger error-text alt_phone_error"></span>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="input-block mb-3">
								<label class="col-form-label">Select Branch</label>
								<select class="select" name="branch_id" id="edit_branch_id">
									<option value="">Select Branch</option>
									@foreach(get_branch() as $branch)
										<option value="{{$branch->id}}">
											{{$branch->name }}
										</option>
									@endforeach
								</select>
							 
							</div>
						</div>
						<div class="col-sm-6">
							<div class="input-block mb-3">
								<label class="col-form-label">Looking For</label>
								<select class="select" name="looking_for" id="looking_for">
									<option value="Residence">Residence</option>
									<option value="Commercial">Commercial</option>

								</select>
							</div>
							</div>
						<div class="col-sm-6">
							<div class="input-block mb-3">
								<label class="col-form-label">Address Type</label>
								<select class="select" name="address_type" id="edit_address_type">
									<option>Parament Address</option>
									<option>Corresponding Address</option>

								</select>
							</div>
						</div>


						<div class="col-sm-12"></div>
						<div class="input-block mb-3">
							<label class="col-form-label">Address</label>
							<textarea class="form-control" name="address" id="edit_address"></textarea>
							<span class="text-danger error-text address_error"></span>
						</div>
					</div>





					<div class="col-md-12">
						<div class="input-block mb-3">
							<h5 class="mb-3">Status</h5>
							<div class="status-radio-btns d-flex">
								<div class="people-status-radio">
									<input type="radio" class="status-radio" id="status-1" name="cp_status" value="1"
										checked>
									<label for="status-1">Active</label>
								</div>
								<div class="people-status-radio">
									<input type="radio" class="status-radio" id="status-0" name="cp_status" value="0">
									<label for="status-0">Inactive</label>
								</div>
							</div>
						</div>
					</div>

					<button class="btn btn-primary submit-btn" id="submitUpdate">Update <span class="loadingSpinner"
							class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
							style="display: none;"></span></button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
	integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
	crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
	function edit_Cpartner(el) {
		var data = $.parseJSON(el.attr("data-data"));
		console.log(data.cp_status);
		$('#edit_user_id').val(data.user_id).change();
		$('#edit_cp_name').val(data.cp_name);
		$('#edit_id').val(data.id);
		$('#edit_phone').val(data.phone);
		$('#edit_alt_phone').val(data.alt_phone);
		$('#edit_address').val(data.address);
		$('#edit_address_type').val(data.address_type).change();
		$('#looking_for').val(data.looking_for).change();
		
		$('#edit_branch_id').val(data.branch_id).change();

		if (data.cp_status == 1) {
			$('#status-1').prop("checked", 'checked');
		} else {
			$('#status-0').prop("checked", 'checked');
		}
		$('#edit_Cpartner').modal('show');
		return false;


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
	$(document).ready(function () {
		$('#editForm').on('submit', function (e) {

			e.preventDefault();  // Prevent the default form submission

			$('#submitUpdate').attr('disabled', true);
			$('.loadingSpinner').show();  // Show spinner

			var formData = new FormData(this);  // Create FormData object with form elements

			console.log("Formdata", formData);

			$('span.error-text').text('');

			$.ajax({
				url: "{{route('admin.channel-partner.update')}}",  // Replace with your route
				type: "POST",
				data: formData,
				contentType: false,
				processData: false,
				success: function (response) {
					// alert("Form submitted successfully with file!");

					console.log(response);
					tost_fire(response.message, 'success');
					setTimeout(function () {
						$('#submitUpdate').attr('disabled', false).text('Submit');
						$('.loadingSpinner').hide();  // Hide spinner
						location.reload();  // Reload the page
					}, 2000);


				},
				error: function (xhr) {
					if (xhr.status === 422) {  // Validation error
						var errors = xhr.responseJSON.errors;
						$.each(errors, function (key, value) {
							$('.' + key + '_error').text(value[0]);
						});
						$('#submitUpdate').attr('disabled', false).text('Submit');
						$('.loadingSpinner').hide();  // Hide spinner
					} else {
						alert("Something went wrong!");
						console.error(xhr);
						$('#submitUpdate').attr('disabled', false).text('Submit');
						$('.loadingSpinner').hide();  // Hide spinner
					}
				}
			});
		});
	});
</script>
@endsection