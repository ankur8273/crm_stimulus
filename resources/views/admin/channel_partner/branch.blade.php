@extends('admin.layouts.app')
@push('css')
	<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/plugins/fontawesome/css/fontawesome.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/plugins/fontawesome/css/all.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/line-awesome.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/material.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

@endpush
@section('content')

<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="page-header">
			<div class="row align-items-center">
				<div class="col">
					<h3 class="page-title">Branch</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="#">Dashboard</a></li>
						<li class="breadcrumb-item active">Branch</li>
					</ul>
				</div>
				<div class="col-auto float-end ms-auto">
					<a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_barnch"><i
							class="fa-solid fa-plus"></i> Add Branch</a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div>
					<table class="table table-striped custom-table mb-0 datatable">
						<thead>
							<tr>
								<th class="width-thirty">#</th>
								<th>Branch Name</th>
								<th>Branch City</th>
								<th>Branch State</th>
								<th class="text-end">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($branchs as $branch)
								<tr>
									<td>{{$loop->iteration}}</td>
									<td>{{$branch->name}}</td>
									<td>{{$branch->city}}</td>
									<td>{{$branch->state}}</td>
									<td class="text-end">
										<div class="dropdown dropdown-action">
											<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"
												aria-expanded="false"><i class="material-icons">more_vert</i></a>
											<div class="dropdown-menu dropdown-menu-right">
												<a class="dropdown-item" href="#" data-id="{{$branch->id}}"
													data-name="{{$branch->name}}" data-city="{{$branch->city}}" data-state="{{$branch->state}}" onclick="edit($(this))"><i
														class="fa-solid fa-pencil m-r-5"></i> Edit</a>
												<a class="dropdown-item" href="#" data-id="{{$branch->id}}"
													onclick="branch_delete($(this))"><i
														class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
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
	<div id="add_barnch" class="modal custom-modal fade" role="dialog">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Add Branchs</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="{{route('admin.channel-partner.branch.store')}}" method="post" id="departmentForm">
						@csrf
						<div class="input-block mb-3">
							<label class="col-form-label">Branch Name <span class="text-danger">*</span></label>
							<input class="form-control" type="text" id="name" name="name" required>
							<small class="error-message text-danger"></small>
						</div>
						<div class="input-block mb-3">
							<label class="col-form-label">Branch City <span class="text-danger">*</span></label>
							<input class="form-control" type="text" id="name" name="city" required>
							<small class="error-message text-danger"></small>
						</div>
						<div class="input-block mb-3">
							<label class="col-form-label">Branch State <span class="text-danger">*</span></label>
							<input class="form-control" type="text" id="name" name="state" required>
							<small class="error-message text-danger"></small>
						</div>
						<div class="submit-section">
							<button class="btn btn-primary submit-btn" id="submitButton">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div id="edit_department" class="modal custom-modal fade" role="dialog">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Edit Branch</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="{{route('admin.channel-partner.branch.update')}}" method="post" id="editdepartmentForm">
						@csrf
						<div class="input-block mb-3">
							<label class="col-form-label">Branch  Name <span class="text-danger">*</span></label>

							<input class="form-control" value="" name="name" id="depart_name" type="text" required>
							<small class="error-message text-danger"></small>
							<input value="" name="id" id="depart_id" type="hidden">
						</div>
						<div class="input-block mb-3">
							<label class="col-form-label">Branch City <span class="text-danger">*</span></label>
							<input class="form-control" type="text" id="edit_city" name="city" required>
							<small class="error-message text-danger"></small>
						</div>
						<div class="input-block mb-3">
							<label class="col-form-label">Branch State <span class="text-danger">*</span></label>
							<input class="form-control" type="text" id="edit_state" name="state" required>
							<small class="error-message text-danger"></small>
						</div>
						<div class="submit-section">
							<button class="btn btn-primary submit-btn" id="editsubmitButton">Save</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="modal custom-modal fade" id="delete_branch" role="dialog">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-body">
					<div class="form-header">
						<h3>Delete Branch</h3>
						<p>Are you sure want to delete?</p>
					</div>
					<form id="deleteform" action="{{route('admin.channel-partner.branch.delete')}}" method="post">
						@csrf
						<div class="modal-btn delete-action">
							<div class="row">
								<div class="col-6">
									<input name="branch_id" id="branch_id" value="0" type="hidden">
									<a href="javascript:void(0);" class="btn btn-primary continue-btn"
										onclick="$(this).closest('form').submit();">Delete</a>
								</div>
								<div class="col-6">
									<a href="javascript:void(0);" data-bs-dismiss="modal"
										class="btn btn-primary cancel-btn">Cancel</a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script src="{{asset('assets/js/jquery-3.7.1.min.js')}}" type="a77ca2864b88690ee5a4547f-text/javascript"></script>
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}" type="a77ca2864b88690ee5a4547f-text/javascript"></script>
<script src="{{asset('assets/js/jquery.slimscroll.min.js')}}" type="a77ca2864b88690ee5a4547f-text/javascript"></script>

<script src="{{asset('assets/js/jquery.dataTables.min.js')}}" type="a77ca2864b88690ee5a4547f-text/javascript"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"
	type="a77ca2864b88690ee5a4547f-text/javascript"></script>
<script src="{{asset('assets/js/layout.js')}}" type="a77ca2864b88690ee5a4547f-text/javascript"></script>
<!-- <script src="{{asset('assets/js/theme-settings.js')}}" type="a77ca2864b88690ee5a4547f-text/javascript"></script> -->
<!-- <script src="{{asset('assets/js/greedynav.js')}}" type="a77ca2864b88690ee5a4547f-text/javascript"></script> -->
<script src="{{asset('assets/js/app.js')}}" type="a77ca2864b88690ee5a4547f-text/javascript"></script>
<script src="{{asset('assets/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js')}}"
	data-cf-settings="a77ca2864b88690ee5a4547f-|49" defer></script>

<script type="text/javascript">

	function branch_delete(el) {
		$('#branch_id').val(el.attr("data-id"));
		$('#delete_branch').modal('show');
	}

	function edit(el) {
		$('#depart_id').val(el.attr("data-id"));
		$('#depart_name').val(el.attr("data-name"));
		$('#edit_city').val(el.attr("data-city"));
		$('#edit_state').val(el.attr("data-state"));
		$('#edit_department').modal('show');
	}

</script>
<script>
	document.addEventListener("DOMContentLoaded", function () {

		function validateForm(form_id_name) {
			const form = document.getElementById(form_id_name);
			let isValid = true;

			// Clear previous error messages
			const errorMessages = form.querySelectorAll('.error-message');
			errorMessages.forEach(message => {
				message.textContent = '';
			});

			// Check for required fields
			const requiredFields = form.querySelectorAll("[required]");
			let counter = 1;
			requiredFields.forEach(function (field, index) {
				let fieldValid = true;
				const errorMessage = field.nextElementSibling;

				if (!field.value.trim()) {
					if (errorMessage) {
						errorMessage.textContent = `${field.previousElementSibling.textContent} is required.`;
					}
					field.focus();
					fieldValid = false;
				}

				if (!fieldValid) {
					isValid = false;
				}

			});



			return isValid;
		}


		// Attach click event to the submit button
		const submitButton = document.getElementById('submitButton');
		if (submitButton) {
			submitButton.addEventListener('click', function (event) {
				event.preventDefault();
				if (validateForm('departmentForm')) {
					document.getElementById('departmentForm').submit(); // Submit form if valid
				}
			});
		}
		const edtSubmitButton = document.getElementById('editsubmitButton');
		if (edtSubmitButton) {
			edtSubmitButton.addEventListener('click', function (event) {

				event.preventDefault();
				if (validateForm('editdepartmentForm')) {

					document.getElementById('editdepartmentForm').submit(); // Submit form if valid
				}
			});
		}
	});

</script>


@endsection