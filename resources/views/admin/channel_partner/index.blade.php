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
	<link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/line-awesome.min.css')}}">
	<!-- <link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.min.css')}}"> -->
	<link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
@endpush
@section('content')

<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="page-header">
			<div class="row align-items-center">
				<div class="col">
					<h3 class="page-title">Channel Partner</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
						<li class="breadcrumb-item active">Channel Partner</li>
					</ul>
				</div>
				<div class="col-auto float-end ms-auto">
				    @if(admin_has_permission('Create-CP'))
					<a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#create_cp"><i
							class="fa-solid fa-plus"></i> Create Channel Partner</a>
						@endif
					<div class="view-icons">
						<a href="{{route('admin.channel-partner.list')}}" class="grid-view btn btn-link"><i
								class="las la-redo-alt"></i></a>
						<!-- <a href="projects.html" class="grid-view btn btn-link"><i class="fa fa-th"></i></a> -->
						<!-- <a href="project-list.html" class="list-view btn btn-link active"><i class="fa-solid fa-bars"></i></a> -->
					</div>
				</div>
			</div>
		</div>

		<form id="filter_form" method="get">
			<div class="row filter-row">
				<div class="col-sm-6 col-md-3">
					<div class="input-block mb-3 form-focus">
						<input type="text" class="form-control floating" name="name" value="{{$name}}">
						<label class="focus-label">CP Name</label>
					</div>
				</div>
				<!-- <div class="col-sm-6 col-md-3">
                        <div class="input-block mb-3 form-focus">
                           <input type="text" class="form-control floating">
                           <label class="focus-label">Employee Name</label>
                        </div>
                     </div> -->
				<div class="col-xl-3">
					<div class="input-block mb-3 form-focus focused">
						<input type="text" class="form-control  date-range bookingrange" name="date" value="{{$date}}">
						<label class="focus-label">From - To Date</label>
					</div>
				</div>
				<div class="col-sm-6 col-md-3">
					<div class="input-block mb-3 form-focus select-focus">
						<select class="select floating" name="status">
							<option value="">--Select--</option>
							<option value="active" {{$status == 'active' ? 'selected' : ''}}>Active</option>
							<option value="inactive" {{$status == 'inactive' ? 'selected' : ''}}>InActive</option>
						</select>
						<label class="focus-label">Status</label>
					</div>
				</div>
				<div class="col-sm-6 col-md-3">
					<button href="#" class="btn btn-success w-100" onclick="$('#filter_form').submit();"> Search
					</button>
				</div>
			</div>
		</form>
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-striped custom-table datatable">
						<thead>
							<tr>
								<th>CP Name</th>

								<th>Assigned user</th>
								<th>Created</th>
								<th>Status</th>
								<th class="text-end">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($CPartners as $CPartner)
								<tr>
									<td>
										<a
											href="{{route('admin.channel-partner.details', $CPartner->id)}}">{{$CPartner->cp_name}}</a>
									</td>

									<td>
										<ul class="team-members">
											<li>
												<a href="#" data-bs-toggle="tooltip"
													title="{{ $CPartner->user ? ($CPartner->user->first_name . ' ' . $CPartner->user->last_name) : ''}} ">
													@if($CPartner->user && $CPartner->user->image)
														<img src="{{asset('assets/img/employee/' . $CPartner->user->image)}}"
															alt="User Image">
													@else
														<img src="{{asset('assets/img/avatar/images-dummy.jpg')}}"
															alt="User Image">
													@endif
												</a>
												<span>{{ $CPartner->user ? ($CPartner->user->first_name . ' ' . $CPartner->user->last_name) : ''}}</span>
											</li>
										</ul>
									</td>

									<td>{{date('d M Y', strtotime($CPartner->created_at))}} </td>

									<td>
										<div class="dropdown action-label">
											<a href="#" class="btn btn-white btn-sm btn-rounded dropdown-toggle"
												data-bs-toggle="dropdown" aria-expanded="false"><i
													class="fa-regular fa-circle-dot text-{{$CPartner->cp_status == 1 ? 'success' : 'danger'}}"></i>
												{{$CPartner->cp_status == 1 ? 'Active' : 'Inactive' }}</a>
											<div class="dropdown-menu">
												
												<a class="dropdown-item"
													href="{{route('admin.channel-partner.change_status', $CPartner->id)}}?status=1"><i
														class="fa-regular fa-circle-dot text-success"></i> Active</a>
												<a class="dropdown-item"
													href="{{route('admin.channel-partner.change_status', $CPartner->id)}}?status=0"><i
														class="fa-regular fa-circle-dot text-danger"></i> Inactive</a>
											</div>
										</div>
									</td>
									<td class="text-end">
										<div class="dropdown dropdown-action">
											<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"
												aria-expanded="false"><i class="material-icons">more_vert</i></a>
											<div class="dropdown-menu dropdown-menu-right">
											  @if(admin_has_permission('Write-CP'))
												<a class="dropdown-item" href="javascript:void(0);"
													data-data="{{json_encode($CPartner->toArray())}}"
													data-href="{{route('admin.channel-partner.update', $CPartner->id)}}"
													onclick="edit_Cpartner($(this))"><i
														class="fa-solid fa-pencil m-r-5"></i>
													Edit</a>
													@endif
													@if(admin_has_permission('Read-CP'))
												<a class="dropdown-item"
													href="{{route('admin.channel-partner.details', $CPartner->id)}}"><i
														class="fa-regular fa-eye"></i> Preview</a>
														@endif
														@if(admin_has_permission('Delete-CP'))
												     <a class="dropdown-item" href="javascript:void(0);"
													data-href="{{route('admin.channel-partner.delete', $CPartner->id)}}"
													onclick="delete_m($(this))"><i
														class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
														@endif
											</div>
										</div>
									</td>
								</tr>
							@endforeach

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

</div>

@endsection
@section('modal')


<div id="create_cp" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Create Channel Partner</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="createForm" method="post" enctype="multipart/form-data">
					@csrf
					<div class="row">
						<div class="col-sm-6">
							<div class="input-block mb-3">
								<label class="col-form-label">CP Owner</label>
								<select class="select" name="user_id">
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
								<input class="form-control" type="text" name="cp_name">
								<span class="text-danger error-text cp_name_error"></span>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="input-block mb-3">
								<label class="col-form-label">Contact No</label>
								<input class="form-control" type="text" name="phone">
								<span class="text-danger error-text phone_error"></span>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="input-block mb-3">
								<label class="col-form-label">Alt. Contact No.</label>
								<input class="form-control" type="text" name="alt_phone">
								<span class="text-danger error-text alt_phone_error"></span>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="input-block mb-3">
								<label class="col-form-label">Select Branch</label>
								<select class="select" name="branch_id">
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
								<select class="select" name="looking_for" >
									<option value="Residence">Residence</option>
									<option value="Commercial">Commercial</option>

								</select>
							</div>
							</div>
						<div class="col-sm-6">
							<div class="input-block mb-3">
								<label class="col-form-label">Address Type</label>
								<select class="select" name="address_type">
									<option value="Parament Address">Parament Address</option>
									<option value="Corresponding Address">Corresponding Address</option>

								</select>
							</div>
						</div>


						<div class="col-sm-12"></div>
						<div class="input-block mb-3">
							<label class="col-form-label">Address</label>
							<textarea class="form-control" name="address"></textarea>
							<span class="text-danger error-text address_error"></span>
						</div>
					</div>





					<div class="col-md-12">
						<div class="input-block mb-3">
							<h5 class="mb-3">Status</h5>
							<div class="status-radio-btns d-flex">
								<div class="people-status-radio">
									<input type="radio" class="status-radio" id="tests6" name="cp_status" value="1"
										checked>
									<label for="tests6">Active</label>
								</div>
								<div class="people-status-radio">
									<input type="radio" class="status-radio" id="tests7" name="cp_status" value="0">
									<label for="tests7">Inactive</label>
								</div>
							</div>
						</div>
					</div>
			</div>

			<div class="submit-section">
				<button class="btn btn-primary submit-btn" id="submitCreate">Submit <span class="loadingSpinner"
						class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
						style="display: none;"></span></button>
			</div>
			</form>
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

					<div class="submit-section">
						<button class="btn btn-primary submit-btn" id="submitUpdate">Update <span class="loadingSpinner"
								class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
								style="display: none;"></span></button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="modal custom-modal fade" id="delete" role="dialog">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body">
				<div class="form-header">
					<h3>Delete Channel Partner</h3>
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
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
<script src="{{asset('assets/js/jquery.slimscroll.min.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"
	type="264280a78fcfef3abf43a170-text/javascript"></script>
<script src="{{asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"
	type="264280a78fcfef3abf43a170-text/javascript"></script>
<script src="{{asset('assets/js/moment.min.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
<script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}"
	type="264280a78fcfef3abf43a170-text/javascript"></script>
<script src="{{asset('assets/js/moment.min.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
<script src="{{asset('assets/plugins/daterangepicker/daterangepicker.js')}}"
	type="264280a78fcfef3abf43a170-text/javascript"></script>
<script src="{{asset('assets/js/select2.min.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
<!-- <script src="{{asset('assets/plugins/summernote/summernote-bs4.min.js')}}" type="712a4b0e0e5ee5c24248da6b-text/javascript"></script> -->
<script src="{{asset('assets/js/layout.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
<!-- <script src="{{asset('assets/js/theme-settings.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script> -->
<!-- <script src="{{asset('assets/js/greedynav.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script> -->
<script src="{{asset('assets/js/app.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
<script src="{{asset('assets/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js')}}"
	data-cf-settings="264280a78fcfef3abf43a170-|49" defer></script>

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
		$('#edit_branch_id').val(data.branch_id).change();
		$('#edit_address_type').val(data.address_type).change();
		
		$('#edit_branch_id').val(data.branch_id).change();

		if (data.cp_status == 1) {
			$('#status-1').prop("checked", 'checked');
		} else {
			$('#status-0').prop("checked", 'checked');
		}
		$('#edit_Cpartner').modal('show');
		return false;


	}

	function delete_m(el) {
		$('#d-okay').attr("href", el.attr("data-href"));
		$('#delete').modal('show');
	}

</script>


<script>
	$(document).ready(function () {
		$('#createForm').on('submit', function (e) {
			e.preventDefault();  // Prevent the default form submission
			$('#submitCreate').attr('disabled', true);
			$('.loadingSpinner').show();  // Show spinner

			var formData = new FormData(this);  // Create FormData object with form elements

			console.log("Formdata", formData);

			$('span.error-text').text('');

			$.ajax({
				url: "{{route('admin.channel-partner.store')}}",  // Replace with your route
				type: "POST",
				data: formData,
				contentType: false,
				processData: false,
				success: function (response) {
					// alert("Form submitted successfully with file!");

					console.log(response);
					tost_fire(response.message, 'success');
					setTimeout(function () {
						$('#submitCreate').attr('disabled', false).text('Submit');
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
						$('#submitCreate').attr('disabled', false).text('Submit');
						$('.loadingSpinner').hide();  // Hide spinner
					} else {
						alert("Something went wrong!");
						console.error(xhr);
						$('#submitCreate').attr('disabled', false).text('Submit');
						$('.loadingSpinner').hide();  // Hide spinner
					}
				}
			});
		});

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