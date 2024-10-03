@extends('admin.layouts.app')
@push('css')
<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">

<link rel="stylesheet" href="{{asset('assets/plugins/fontawesome/css/fontawesome.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/fontawesome/css/all.min.css')}}">

<link rel="stylesheet" href="{{asset('assets/css/line-awesome.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/material.css')}}">

<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">

<link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}">

<link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">

<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
<meta name="csrf-token" content="{{ csrf_token() }}">

@endpush
@section('content')

<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="page-header">
			<div class="row align-items-center">
				<div class="col">
					<h3 class="page-title">Employee</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="admin-dashboard.html">Dashboard</a></li>
						<li class="breadcrumb-item active">Employee</li>
					</ul>
				</div>
				<div class="col-auto float-end ms-auto">
				@if(admin_has_permission('Write-Employee'))
					<a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_employee"><i
							class="fa-solid fa-plus"></i> Add Employee</a>
					<div class="view-icons">
					@endif
						<!-- <a href="employees.html" class="grid-view btn btn-link"><i class="fa fa-th"></i></a> -->
						<!-- <a href="employees-list.html" class="list-view btn btn-link active"><i class="fa-solid fa-bars"></i></a> -->
					</div>
				</div>
			</div>
		</div>
		<form action="" method="get">
			<div class="row filter-row">
				<div class="col-sm-6 col-md-3">
					<div class="input-block mb-3 form-focus">
						<input type="text" class="form-control floating" name="employee_id" value="{{$employee_id}}">
						<label class="focus-label">Employee ID</label>
					</div>
				</div>
				<div class="col-sm-6 col-md-3">
					<div class="input-block mb-3 form-focus">
						<input type="text" class="form-control floating" name="employee_name"
							value="{{$employee_name}}">
						<label class="focus-label">Employee Name</label>
					</div>
				</div>

				<div class="col-sm-6 col-md-3">
					<button class="btn btn-success w-100" type="submit"> Search </button>
				</div>
			</div>
		</form>
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-striped custom-table datatable">
						<thead>
							<tr>
								<th>Name</th>
								<th>Employee ID</th>
								<th>Email</th>
								<th>Mobile</th>
								<th class="text-nowrap">Join Date</th>
								<th>Role</th>
								<th class="text-end no-sort">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($employees as $employee)
							<tr>
								<td>
									<h2 class="table-avatar">
										<a href="{{route('admin.employee.profile', $employee->id)}}" class="avatar">
											@if($employee->image)
											<img src="{{asset('assets/img/employee/' . $employee->image)}}"
												alt="User Image" id="profile-image">
											@else
											<img src="{{asset('assets/img/icons/profile-upload-img.svg')}}"
												alt="User Image" id="profile-image">
											@endif
											<a href="{{route('admin.employee.profile', $employee->id)}}">{{$employee->first_name
												. ' ' . $employee->last_name}}
												<span>{{$employee->department ? $employee->department->name :
													''}}</span></a>
									</h2>
								</td>
								<td>{{$employee->employee_id}}</td>
								<td><a href="#">{{$employee->email}}</a></td>
								<td>{{$employee->phone}}</td>
								<td>{{date('d M y', strtotime($employee->joining_date))}}</td>
								<td>
									<div class="dropdown">
										<a href="#" class="btn btn-white btn-sm btn-rounded dropdown-toggle"
											data-bs-toggle="dropdown" aria-expanded="false">{{$employee->designation ?
											$employee->designation->name : ''}}
										</a>
										<!--<div class="dropdown-menu">
											@foreach(get_designations() as $designation)
											   @if($designation->id != $employee->designation_id)
											   <a class="dropdown-item" href="#">{{$designation->name}}</a>
											   @endif
											@endforeach
										 </div>-->
									</div>
								</td>
								<td class="text-end">
									<div class="dropdown dropdown-action">
										<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"
											aria-expanded="false"><i class="material-icons">more_vert</i></a>
										<div class="dropdown-menu dropdown-menu-right">
										 @if(admin_has_permission('Write-Employee'))
											<a class="dropdown-item" href="#" data-id="{{$employee->id}}"
												data-data="{{json_encode($employee->toArray())}}"
												onclick="edit($(this))"><i class="fa-solid fa-pencil m-r-5"></i>
												Edit</a>
											@endif
											@if(admin_has_permission('Read-Employee'))
											<a class="dropdown-item"
												href="{{route('admin.employee.profile', $employee->id)}}"><i
													class="fa-regular fa-eye"></i> Preview</a>
											@endif
											@if(admin_has_permission('Delete-Employee'))
											<a class="dropdown-item" href="#" data-id="{{$employee->id}}"
												onclick="emp_delete($(this))"><i
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
<div id="add_employee" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Employee</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="{{route('admin.employee.store')}}" method="post" id="employeeForm">
					@csrf
					<div class="row">
						<div class="col-sm-6">
							<div class="input-block mb-3">
								<label class="col-form-label">First Name <span class="text-danger">*</span></label>
								<input class="form-control" name="first_name" type="text" required>
								<small class="error-message text-danger"></small>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="input-block mb-3">
								<label class="col-form-label">Last Name</label>
								<input class="form-control" name="last_name" type="text">
								<small class="error-message text-danger"></small>
							</div>
						</div>
						<!--<div class="col-sm-6">
						   <div class="input-block mb-3">
							  <label class="col-form-label">Username <span class="text-danger">*</span></label>
							  <input class="form-control" name="username" type="text">
						   </div>
						</div>-->
						<div class="col-sm-6">
							<div class="input-block mb-3">
								<label class="col-form-label">Email <span class="text-danger">*</span></label>
								<input class="form-control" name="email" type="email" required id="email_check">
								<small class="error-message text-danger"></small>
								<div id="responseMessage"></div>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="input-block mb-3">
								<label class="col-form-label">Employee ID <span class="text-danger">*</span></label>
								<input type="text" name="employee_id" class="form-control" required>
								<small class="error-message text-danger"></small>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="input-block mb-3">
								<label class="col-form-label">Joining Date <span class="text-danger">*</span></label>
								<div class="cal-icon"><input class="form-control joindatetimepicker" name="joining_date"
										id="joining_date_add" type="text" required></div>
								<small class="error-message error-message_join text-danger"></small>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="input-block mb-3">
								<label class="col-form-label">Phone <span class="text-danger">*</span></label>
								<input class="form-control" name="phone" type="text" required maxlength="13"
									oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
									pattern="[0-9]{10}">
								<small class="error-message text-danger"></small>
							</div>
						</div>

						<div class="col-md-6">
							<div class="input-block mb-3">
								<label class="col-form-label">Department <span class="text-danger">*</span></label>
								<select class="select" name="department_id" required id="department">
									<option value="">Select Department</option>
									@foreach(get_departments() as $department)
									<option value="{{$department->id}}">{{$department->name}}</option>
									@endforeach
								</select>
								<small class="error-message text-danger" id="error-message_1"></small>
							</div>
						</div>
						<div class="col-md-4">
							<div class="input-block mb-3">
								<label class="col-form-label">Designation <span class="text-danger">*</span></label>
								<select class="select" name="designation_id" required id="designation">
									<option value="">Select Designation</option>
									@foreach(get_designations() as $designation)
									<option value="{{$designation->id}}">{{$designation->name}}</option>
									@endforeach
								</select>
								<small class="error-message text-danger" id="error-message_2"></small>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="input-block mb-4">
								<label class="col-form-label">Team Leader </label>
								<select class="select" name="team_leader" required>
									<option value="">No</option>
									<option value="1">Yes</option>
								</select>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="input-block mb-3">
								<label class="col-form-label">Reporting To </label>
								<select class="select" name="reporting_to">
									<option value="">Select Employee</option>
									@foreach(get_employees() as $employee)
									@if($employee->team_leader)
									<option value="{{$employee->id}}">
										{{$employee->first_name . ' ' . $employee->last_name}}
									</option>
									@endif
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-sm-6">
							<div class="input-block mb-3">
								<label class="col-form-label">Password</label>
								<input class="form-control pass" type="password" id="password" name="password" required>
								<small class="error-message text-danger"></small>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="input-block mb-3">
								<label class="col-form-label">Confirm Password</label>
								<input class="form-control pass" type="text" data-parsley-equalto="#password"
									id="repassword" name="password_confirmation" required>
								<small class="error-message text-danger"></small>
							</div>
						</div>

					</div>
					<span onclick="$('.pass').val(Math.random().toString(36).slice(-8));"
						class="btn btn-secondary float-right">Generate Password</span></br></br>
					<span onclick="check_all($(this))" class="btn btn-info float-right">Check All</span></br>
					<div class="table-responsive m-t-15">
						<table class="table table-striped custom-table">
							<thead>
								<tr>
									<th>Module Permission</th>
									<th class="text-center">Read</th>
									<th class="text-center">Write</th>
									<th class="text-center">Create</th>
									<th class="text-center">Delete</th>
									<th class="text-center">Import</th>
									<th class="text-center">Export</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<span>Employee </span>
										<span class="m-2 float-end">
											<label class="custom_check">
												<input type="checkbox" name="permission[]" value="Employee">
												<span class="checkmark"></span>
											</label>
										</span>
									</td>
									<td class="text-center">
										<label class="custom_check">
											<input type="checkbox" name="permission[]" value="Read-Employee">
											<span class="checkmark"></span>
										</label>
									</td>
									<td class="text-center">
										<label class="custom_check">
											<input type="checkbox" name="permission[]" value="Write-Employee">
											<span class="checkmark"></span>
										</label>
									</td>
									<td class="text-center">
										<label class="custom_check">
											<input type="checkbox" name="permission[]" value="Create-Employee">
											<span class="checkmark"></span>
										</label>
									</td>
									<td class="text-center">
										<label class="custom_check">
											<input type="checkbox" name="permission[]" value="Delete-Employee">
											<span class="checkmark"></span>
										</label>
									</td>
									<td class="text-center">

									</td>
									<td class="text-center">

									</td>
								</tr>
								<tr>
									<td>
										<span>Lead </span>
										<span class="m-2 float-end">
											<label class="custom_check">
												<input type="checkbox" name="permission[]" value="Lead">
												<span class="checkmark"></span>
											</label>
										</span>
									</td>
									<td class="text-center">
										<label class="custom_check">
											<input type="checkbox" name="permission[]" value="Read-Lead">
											<span class="checkmark"></span>
										</label>
									</td>
									<td class="text-center">
										<label class="custom_check">
											<input type="checkbox" name="permission[]" value="Write-Lead">
											<span class="checkmark"></span>
										</label>
									</td>
									<td class="text-center">
										<label class="custom_check">
											<input type="checkbox" name="permission[]" value="Create-Lead">
											<span class="checkmark"></span>
										</label>
									</td>
									<td class="text-center">
										<label class="custom_check">
											<input type="checkbox" name="permission[]" value="Delete-Lead">
											<span class="checkmark"></span>
										</label>
									</td>
									<td class="text-center">
										<label class="custom_check">
											<input type="checkbox" name="permission[]" value="Import-Lead">
											<span class="checkmark"></span>
										</label>
									</td>
									<td class="text-center">
										<label class="custom_check">
											<input type="checkbox" name="permission[]" value="Export-Lead">
											<span class="checkmark"></span>
										</label>
									</td>
								</tr>
								<tr>
									<td>
										<span>Project </span>
										<span class="m-2 float-end">
											<label class="custom_check">
												<input type="checkbox" name="permission[]" value="Project">
												<span class="checkmark"></span>
											</label>
										</span>
									</td>
									<td class="text-center">
										<label class="custom_check">
											<input type="checkbox" name="permission[]" value="Read-Project">
											<span class="checkmark"></span>
										</label>
									</td>
									<td class="text-center">
										<label class="custom_check">
											<input type="checkbox" name="permission[]" value="Write-Project">
											<span class="checkmark"></span>
										</label>
									</td>
									<td class="text-center">
										<label class="custom_check">
											<input type="checkbox" name="permission[]" value="Create-Project">
											<span class="checkmark"></span>
										</label>
									</td>
									<td class="text-center">
										<label class="custom_check">
											<input type="checkbox" name="permission[]" value="Delete-Project">
											<span class="checkmark"></span>
										</label>
									</td>
									<td class="text-center">

									</td>
									<td class="text-center">

									</td>
								</tr>
								<tr>
									<td>
										<span>Contact </span>
										<span class="m-2 float-end">
											<label class="custom_check">
												<input type="checkbox" name="permission[]" value="Contact">
												<span class="checkmark"></span>
											</label>
										</span>
									</td>
									<td class="text-center">
										<label class="custom_check">
											<input type="checkbox" name="permission[]" value="Read-Contact">
											<span class="checkmark"></span>
										</label>
									</td>
									<td class="text-center">
										<label class="custom_check">
											<input type="checkbox" name="permission[]" value="Write-Contact">
											<span class="checkmark"></span>
										</label>
									</td>
									<td class="text-center">
										<label class="custom_check">
											<input type="checkbox" name="permission[]" value="Create-Contact">
											<span class="checkmark"></span>
										</label>
									</td>
									<td class="text-center">
										<label class="custom_check">
											<input type="checkbox" name="permission[]" value="Delete-Contact">
											<span class="checkmark"></span>
										</label>
									</td>
									<td class="text-center">

									</td>
									<td class="text-center">

									</td>
								</tr>
								<tr>
									<td>
										<span>Ticket </span>
										<span class="m-2 float-end">
											<label class="custom_check">
												<input type="checkbox" name="permission[]" value="Ticket">
												<span class="checkmark"></span>
											</label>
										</span>
									</td>
									<td class="text-center">
										<label class="custom_check">
											<input type="checkbox" name="permission[]" value="Read-Ticket">
											<span class="checkmark"></span>
										</label>
									</td>
									<td class="text-center">
										<label class="custom_check">
											<input type="checkbox" name="permission[]" value="Write-Ticket">
											<span class="checkmark"></span>
										</label>
									</td>
									<td class="text-center">
										<label class="custom_check">
											<input type="checkbox" name="permission[]" value="Create-Ticket">
											<span class="checkmark"></span>
										</label>
									</td>
									<td class="text-center">
										<label class="custom_check">
											<input type="checkbox" name="permission[]" value="Delete-Ticket">
											<span class="checkmark"></span>
										</label>
									</td>
									<td class="text-center">

									</td>
									<td class="text-center">

									</td>
								</tr>

								<tr>
									<td>
										<span>Knowledgebase </span>
										<span class="m-2 float-end">
											<label class="custom_check">
												<input type="checkbox" name="permission[]" value="Knowledgebase">
												<span class="checkmark"></span>
											</label>
										</span>
									</td>
									<td class="text-center">
										<label class="custom_check">
											<input type="checkbox" name="permission[]" value="Read-Knowledgebase">
											<span class="checkmark"></span>
										</label>
									</td>
									<td class="text-center">
										<label class="custom_check">
											<input type="checkbox" name="permission[]" value="Write-Knowledgebase">
											<span class="checkmark"></span>
										</label>
									</td>
									<td class="text-center">
										<label class="custom_check">
											<input type="checkbox" name="permission[]" value="Create-Knowledgebase">
											<span class="checkmark"></span>
										</label>
									</td>
									<td class="text-center">
										<label class="custom_check">
											<input type="checkbox" name="permission[]" value="Delete-Knowledgebase">
											<span class="checkmark"></span>
										</label>
									</td>
									<td class="text-center">

									</td>
									<td class="text-center">

									</td>
								</tr>

								<tr>
                                 <td>
                                    <span >Channel Partner </span>

                                 </td>
								 <td>
                                    <span class="m-2 float-end">
                                       <label class="custom_check">
                                          <input type="checkbox" name="permission[]" value="CP" >
                                          <span class="checkmark"></span>
                                       </label>
                                    </span>
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Read-CP">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Write-CP">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Create-CP">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Delete-CP">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>

								 
                                 <td class="text-center">
                                    
                                 </td>
                                 <td class="text-center">
                                    
                                 </td>
                              </tr>
							  <tr>
                                 <td>
                                    <span >General settings </span>
                                 </td>
                                 <td>
                                    <span class="m-2 float-end">
                                       <label class="custom_check">
                                          <input type="checkbox" name="permission[]" value="General-settings" id="General-settings">
                                          <span class="checkmark"></span>
                                       </label>
                                    </span>
                                 </td>
                                 <td class="text-center">
                                    
                                 </td>
                                 <td class="text-center">
                                    
                                 </td>
                                 <td class="text-center">
                                    
                                 </td>
                                 <td class="text-center">
                                    
                                 </td>
                                 <td class="text-center">
                                    
                                 </td>
                                 <td class="text-center">
                                    
                                 </td>
                              </tr>
							</tbody>
						</table>
					</div>
					<div class="submit-section">
						<button class="btn btn-primary submit-btn" id="submitButton">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div id="edit_employee" class="modal custom-modal fade" role="dialog">
         <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">Edit Employee</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <form action="{{route('admin.employee.update')}}" method="post">
                     @csrf
                     <div class="row">
                        <div class="col-sm-6">
                           <div class="input-block mb-3">
                              <label class="col-form-label">First Name <span class="text-danger">*</span></label>
                              <input class="form-control" id="first_name" name="first_name" type="text" required>
                              <input  id="id" name="id" type="hidden">
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="input-block mb-3">
                              <label class="col-form-label">Last Name</label>
                              <input class="form-control" id="last_name" name="last_name" type="text">
                           </div>
                        </div>
                        <!--<div class="col-sm-6">
                           <div class="input-block mb-3">
                              <label class="col-form-label">Username <span class="text-danger">*</span></label>
                              <input class="form-control" id="username" name="username" type="text" required>
                           </div>
                        </div>-->
                        <div class="col-sm-6">
                           <div class="input-block mb-3">
                              <label class="col-form-label">Email <span class="text-danger">*</span></label>
                              <input class="form-control" id="email" name="email" type="email" required>
                           </div>
                        </div>
                        
                        <div class="col-sm-6">
                           <div class="input-block mb-3">
                              <label class="col-form-label">Employee ID <span class="text-danger">*</span></label>
                              <input type="text" id="employee_id" name="employee_id" class="form-control" required>
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="input-block mb-3">
                              <label class="col-form-label">Joining Date <span class="text-danger">*</span></label>
                              <div class="cal-icon"><input class="form-control joindatetimepicker" id="joining_date" name="joining_date" type="text" required></div>
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="input-block mb-3">
                              <label class="col-form-label">Phone <span class="text-danger">*</span></label>
                              <input class="form-control" id="phone" name="phone" type="text" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" pattern="[0-9]{10}" title="Mobile number must be 10 digits" required>
                           </div>
                        </div>
                        
                        <div class="col-md-6">
                           <div class="input-block mb-3">
                              <label class="col-form-label">Department <span class="text-danger">*</span></label>
                              <select class="select" id="department_id" name="department_id" required>
                                 <option value="">Select Department</option>
                                 @foreach(get_departments() as $department)
                                    <option value="{{$department->id}}">{{$department->name}}</option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="input-block mb-3">
                              <label class="col-form-label">Designation <span class="text-danger">*</span></label>
                              <select class="select" id="designation_id" name="designation_id" required>
                                 <option value="">Select Designation</option>
                                 @foreach(get_designations() as $designation)
                                    <option value="{{$designation->id}}">{{$designation->name}}</option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="input-block mb-4">
                              <label class="col-form-label">Team Leader </label>
                              <select class="select" name="team_leader" id="team_leader" >
                                 <option value="">No</option>
                                 <option value="1">Yes</option>
                              </select>
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="input-block mb-3">
                              <label class="col-form-label">Reporting To </label>
                              <select class="select" name="reporting_to" id="reporting_to">
                                 <option value="">Select Employee</option>
                                 @foreach(get_employees() as $employee)
                                    @if($employee->team_leader)
                                    <option value="{{$employee->id}}">{{$employee->first_name.' '.$employee->last_name}}</option>
                                    @endif
                                 @endforeach
                              </select>
                           </div>
                        </div>
                     </div>
                     <hr>

                     <div class="table-responsive m-t-15">
                        <table class="table table-striped custom-table">
                           <thead>
                              <tr>
                                 <th>Module Permission</th>
                                 <th class="text-center">Status</th>
                                 <th class="text-center">Read</th>
                                 <th class="text-center">Write</th>
                                 <th class="text-center">Create</th>
                                 <th class="text-center">Delete</th>
                                 <th class="text-center">Import</th>
                                 <th class="text-center">Export</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <td>
                                    <span >Employee </span>
                                 </td>
                                 <td>
                                    <span class="m-2 float-end">
                                       <label class="custom_check">
                                          <input type="checkbox" name="permission[]" value="Employee" id="Employee">
                                          <span class="checkmark"></span>
                                       </label>
                                    </span>
                                 </td>
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Read-Employee" id="Read-Employee">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Write-Employee" id="Write-Employee">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Create-Employee" id="Create-Employee">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Delete-Employee" id="Delete-Employee">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>
                                 <td class="text-center">
                                    
                                 </td>
                                 <td class="text-center">
                                    
                                 </td>
                              </tr>
                              <tr>
                                 <td>
                                    <span >Lead </span>
                                 </td>
                                 <td>
                                    <span class="m-2 float-end">
                                       <label class="custom_check">
                                          <input type="checkbox" name="permission[]" value="Lead" id="Lead">
                                          <span class="checkmark"></span>
                                       </label>
                                    </span>
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Read-Lead" id="Read-Lead">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Write-Lead" id="Write-Lead">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Create-Lead" id="Create-Lead">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Delete-Lead" id="Delete-Lead">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Import-Lead" id="Import-Lead">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Export-Lead" id="Export-Lead">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>
                              </tr>
                              <tr>
                                 <td>
                                    <span >Project </span>
                                 </td>
                                 <td>
                                    <span class="m-2 float-end">
                                       <label class="custom_check">
                                          <input type="checkbox" name="permission[]" value="Project" id="Project">
                                          <span class="checkmark"></span>
                                       </label>
                                    </span>
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Read-Project" id="Read-Project">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Write-Project" id="Write-Project">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Create-Project" id="Create-Project">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Delete-Project" id="Delete-Project">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>
                                 <td class="text-center">
                                    
                                 </td>
                                 <td class="text-center">
                                   
                                 </td>
                              </tr>
                              <tr>
                                 <td>
                                    <span >Contact </span>
                                    
                                 </td>
                                 <td>
                                    <span class="m-2 float-end">
                                       <label class="custom_check">
                                          <input type="checkbox" name="permission[]" value="Contact" id="Contact">
                                          <span class="checkmark"></span>
                                       </label>
                                    </span>
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Read-Contact" id="Read-Contact">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Write-Contact" id="Write-Contact">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Create-Contact" id="Create-Contact">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Delete-Contact" id="Delete-Contact">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>
                                 <td class="text-center">
                                    
                                 </td>
                                 <td class="text-center">
                                    
                                 </td>
                              </tr>
                              <tr>
                                 <td>
                                    <span >Ticket </span>
                                 </td>
                                 <td>
                                    <span class="m-2 float-end">
                                       <label class="custom_check">
                                          <input type="checkbox" name="permission[]" value="Ticket" id="Ticket">
                                          <span class="checkmark"></span>
                                       </label>
                                    </span>
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Read-Ticket" id="Read-Ticket">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Write-Ticket" id="Write-Ticket">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Create-Ticket" id="Create-Ticket">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Delete-Ticket" id="Delete-Ticket">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>
                                 <td class="text-center">
                                    
                                 </td>
                                 <td class="text-center">
                                    
                                 </td>
                              </tr>
                              <tr>
                                 <td>
                                    <span >Knowledgebase </span>
                                    
                                 </td>
                                 <td>
                                    
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Read-Knowledgebase" id="Read-Knowledgebase">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Write-Knowledgebase" id="Write-Knowledgebase">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Create-Knowledgebase" id="Create-Knowledgebase">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Delete-Knowledgebase" id="Delete-Knowledgebase">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>
                                 <td class="text-center">
                                    
                                 </td>
                                 <td class="text-center">
                                    
                                 </td>
                              </tr>
							  <tr>
                                 <td>
                                    <span >Channel Partner </span>

                                 </td>
								 <td>
                                    <span class="m-2 float-end">
                                       <label class="custom_check">
                                          <input type="checkbox" name="permission[]" value="CP" id="CP">
                                          <span class="checkmark"></span>
                                       </label>
                                    </span>
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Read-CP" id="Read-CP">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Write-CP"  id="Write-CP">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Create-CP"  id="Create-CP">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>
                                 <td class="text-center">
                                    <label class="custom_check">
                                    <input type="checkbox" name="permission[]" value="Delete-CP"  id="Delete-CP">
                                    <span class="checkmark"></span>
                                    </label>
                                 </td>

								 
                                 <td class="text-center">
                                    
                                 </td>
                                 <td class="text-center">
                                    
                                 </td>
                              </tr>
                              <tr>
                                 <td>
                                    <span >General settings </span>
                                    
                                 </td>
                                 <td>
                                    <span class="m-2 float-end">
                                       <label class="custom_check">
                                          <input type="checkbox" name="permission[]" value="General-settings" id="General-settings">
                                          <span class="checkmark"></span>
                                       </label>
                                    </span>
                                 </td>
                                 <td class="text-center">
                                    
                                 </td>
                                 <td class="text-center">
                                    
                                 </td>
                                 <td class="text-center">
                                    
                                 </td>
                                 <td class="text-center">
                                    
                                 </td>
                                 <td class="text-center">
                                    
                                 </td>
                                 <td class="text-center">
                                    
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                     <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Save</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
<div class="modal custom-modal fade" id="delete_employee" role="dialog">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body">
				<div class="form-header">
					<h3>Delete Employee</h3>
					<p>Are you sure want to delete?</p>
				</div>
				<form id="deleteform" action="{{route('admin.employee.delete')}}" method="post">
					@csrf
					<div class="modal-btn delete-action">
						<div class="row">
							<div class="col-6">
								<input name="id" id="emp_id" value="0" type="hidden">
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
@endsection
@section('scripts')
<script data-cfasync="false"
	src="{{asset('assets/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js')}}"></script>
<script src="{{asset('assets/js/jquery-3.7.1.min.js')}}" type="222069f2b20a5c6f1393ed05-text/javascript"></script>

<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}" type="222069f2b20a5c6f1393ed05-text/javascript"></script>

<script src="{{asset('assets/js/jquery.slimscroll.min.js')}}" type="222069f2b20a5c6f1393ed05-text/javascript"></script>

<script src="{{asset('assets/js/select2.min.js')}}" type="222069f2b20a5c6f1393ed05-text/javascript"></script>

<script src="{{asset('assets/js/moment.min.js')}}" type="222069f2b20a5c6f1393ed05-text/javascript"></script>
<script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}"
	type="222069f2b20a5c6f1393ed05-text/javascript"></script>

<script src="{{asset('assets/js/jquery.dataTables.min.js')}}" type="222069f2b20a5c6f1393ed05-text/javascript"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"
	type="222069f2b20a5c6f1393ed05-text/javascript"></script>

<script src="{{asset('assets/js/layout.js')}}" type="222069f2b20a5c6f1393ed05-text/javascript"></script>
<!-- <script src="{{asset('assets/js/theme-settings.js')}}" type="222069f2b20a5c6f1393ed05-text/javascript"></script> -->
<!-- <script src="{{asset('assets/js/greedynav.js')}}" type="222069f2b20a5c6f1393ed05-text/javascript"></script> -->

<script src="{{asset('assets/js/app.js')}}" type="222069f2b20a5c6f1393ed05-text/javascript"></script>
<script src="{{asset('assets/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js')}}"
	data-cf-settings="222069f2b20a5c6f1393ed05-|49" defer></script>

<script type="text/javascript">
	function check_all(el) {
		if (el.hasClass('check')) {
			el.removeClass('check');
			el.html('Check All');
			$('input:checkbox').prop('checked', false);
		} else {
			el.addClass('check');
			el.html('Uncheck All');
			$('input:checkbox').prop('checked', true);
		}

	}

	function emp_delete(el) {
		$('#emp_id').val(el.attr("data-id"));
		$('#delete_employee').modal('show');
	}

	function edit(el) {
		var data = $.parseJSON(el.attr("data-data"));
		var permissions = data.permissions;
		var dateAr = data.joining_date.split('-');
		var newDate = dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0];
		$('#first_name').val(data.first_name);
		$('#last_name').val(data.first_name);
		$('#email').val(data.email);
		$('#employee_id').val(data.employee_id);
		$('#id').val(data.id);
		$('#phone').val(data.phone);
		$('#joining_date').val(newDate);
		$('#username').val(data.username);
		$('#department_id').val(data.department_id).change();
		$('#designation_id').val(data.designation_id).change();
		$('#reporting_to').val(data.reporting_to).change();
		$('input:checkbox').prop('checked', false);
		if (data.team_leader) {
			$('#team_leader').val(data.team_leader).change();
		}
		$.each(permissions, function (index, value) {
			id = '#' + value;
			$(id).prop('checked', true);
		});
		$('#edit_employee').modal('show');
	}

</script>

<script>
	document.addEventListener("DOMContentLoaded", function () {
		function validateForm() {
			const form = document.getElementById('employeeForm');
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

				if (field.tagName === 'SELECT') {
					var selecteddepartment = $('#department').val();
					if (selecteddepartment === '') {
						event.preventDefault(); // Prevent form submission
						$('#error-message_1').html('Department is required'); // Show error message
						fieldValid = false;
					}
					var selecteddesignation = $('#designation').val();
					if (selecteddesignation === '') {
						event.preventDefault(); // Prevent form submission
						$('#error-message_2').html('Designation is required'); // Show error message
						fieldValid = false;
					}

				} else if (!field.value.trim()) {
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

			// Validate email
			const emailField = form.querySelector('input[name="email"]');
			const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
			if (emailField && !emailPattern.test(emailField.value)) {
				const errorMessage = emailField.nextElementSibling;
				if (errorMessage) {
					errorMessage.textContent = "Please enter a valid email address.";
				}
				emailField.focus();
				isValid = false;
			}

			// Check if passwords match
			const passwordField = form.querySelector('input[name="password"]');
			const confirmPasswordField = form.querySelector('input[name="password_confirmation"]');
			if (passwordField && confirmPasswordField && passwordField.value !== confirmPasswordField.value) {
				const errorMessage = confirmPasswordField.nextElementSibling;
				if (errorMessage) {
					errorMessage.textContent = "Passwords do not match.";
				}
				confirmPasswordField.focus();
				isValid = false;
			}
			var joining_date_add = $('#joining_date_add').val();
			if (joining_date_add === '') {
				event.preventDefault(); // Prevent form submission
				$('.error-message_join').html('Joining Date  is required'); // Show error message
				isValid = false;
			}


			return isValid;
		}


		// Attach click event to the submit button
		const submitButton = document.getElementById('submitButton');
		if (submitButton) {
			submitButton.addEventListener('click', function (event) {
				event.preventDefault(); // Prevent form from submitting
				if (validateForm()) {
					document.getElementById('employeeForm').submit(); // Submit form if valid
				}
			});
		}
		const edtSubmitButton = document.getElementById('editsubmitButton');
		if (edtSubmitButton) {
			edtSubmitButton.addEventListener('click', function (event) {

				event.preventDefault(); // Prevent form from submitting
				if (validateForm()) {

					document.getElementById('editEmployeeForm').submit(); // Submit form if valid
				}
			});
		}
	});
	function checkEmailUnique(email, messageElement) {
		const checkUniqueUrl = "{{ route('admin.employee.check.unique_email') }}"; // Using the named route

		if (email) {
			fetch(checkUniqueUrl, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
					'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
				},
				body: JSON.stringify({ email: email })
			})
				.then(response => response.json())
				.then(data => {
					if (!data.unique) {
						messageElement.textContent = 'Email already exists!';
						messageElement.style.color = 'red';
					} else {
						messageElement.textContent = 'Email is available.';
						messageElement.style.color = 'green';
					}
				})
				.catch(error => {
					console.error('Error:', error);
					messageElement.textContent = 'An error occurred. Please try again.';
					messageElement.style.color = 'red';
				});
		} else {
			// Clear the message if the email field is empty
			messageElement.textContent = '';
			messageElement.style.color = '';
		}
	}

	// Attach event listener to email input field
	document.getElementById('email_check').addEventListener('blur', function () {
		const email = this.value;
		const messageElement = document.getElementById('responseMessage');
		checkEmailUnique(email, messageElement);
	});

	 
</script>


@endsection