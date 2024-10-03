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
					<h3 class="page-title">Admin User</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="#">Dashboard</a></li>
						<li class="breadcrumb-item active">Admin</li>
					</ul>
				</div>
				<div class="col-auto float-end ms-auto">
					<a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_admin"><i
							class="fa-solid fa-plus"></i> Add Admin</a>
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
								<th>  Name</th>
								<th>  Email</th>
								<th class="text-end">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($admins as $admin)
								<tr>
									<td>{{$loop->iteration}}</td>
									<td>{{$admin->name}}</td>
									<td>{{$admin->email}}</td>
									<td class="text-end">
										<div class="dropdown dropdown-action">
											<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"
												aria-expanded="false"><i class="material-icons">more_vert</i></a>
											<div class="dropdown-menu dropdown-menu-right">
												<a class="dropdown-item" href="#" data-id="{{$admin->id}}"
													data-name="{{$admin->name}}" onclick="edit($(this))" data-data="{{json_encode($admin->toArray())}}" ><i
														class="fa-solid fa-pencil m-r-5"  ></i> Edit</a>
												<a class="dropdown-item" href="#" data-id="{{$admin->id}}"
													onclick="dept_delete($(this))"><i
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
	<div id="add_admin" class="modal custom-modal fade" role="dialog">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Add Admin</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form  method="post" id="createForm">
						@csrf
						<div class="row">
						<div class="input-block mb-3">
							<label class="col-form-label">  Name <span class="text-danger">*</span></label>
							<input class="form-control" type="text" id="name" name="name" >
							<small class="text-danger error-text name_error"></small>
						</div>
						<div class="input-block mb-3">
							<label class="col-form-label">  Email <span class="text-danger">*</span></label>
							<input class="form-control" type="email" id="name" name="email" >
							<small class="text-danger error-text  email_error"></small>
						</div>

						<div class="input-block mb-3">
							<label class="col-form-label">  Password <span class="text-danger">*</span></label>
							<input class="form-control" type="password"   name="password" >
							<small class="text-danger error-text  password_error"></small>
						</div>
						<div class="input-block mb-3">
							<label class="col-form-label">  Confirm Password <span class="text-danger">*</span></label>
							<input class="form-control" type="text"   name="password_confirmation" >
							<small class="text-danger error-text  password_confirmation_error"></small>
						</div>
						</div>
					
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
						<div class="row">
                              <div class="col-md-12">
                                 <div class="input-block mb-3">
                                    <h5 class="mb-3">Status</h5>
                                    <div class="status-radio-btns d-flex">
                                       <div class="people-status-radio">
                                          <input type="radio" class="status-radio" id="tests6-1" name="status" value="1">
                                          <label for="tests6-1">Active</label>
                                       </div>
                                       <div class="people-status-radio">
                                          <input type="radio" class="status-radio" id="tests7-0" name="status" value="0">
                                          <label for="tests7-0">Inactive</label>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           
						<div class="submit-section">
							<button class="btn btn-primary submit-btn" id="submitCreate">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div id="edit_department" class="modal custom-modal fade" role="dialog">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Edit Admin</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
				    <form  method="post" id="editForm">
						@csrf
						<div class="row">
						<div class="input-block mb-3">
						<input class="form-control" type="hidden" id="admin_id" name="admin_id" >
							<label class="col-form-label">  Name <span class="text-danger">*</span></label>
							<input class="form-control" type="text" id="edit_name" name="name" >
							<small class="text-danger error-text name_error"></small>
						</div>
						<div class="input-block mb-3">
							<label class="col-form-label">  Email <span class="text-danger">*</span></label>
							<input class="form-control" type="email" id="edit_email" name="email" >
							<small class="text-danger error-text  email_error"></small>
						</div>

						<!-- <div class="input-block mb-3">
							<label class="col-form-label">  Password <span class="text-danger">*</span></label>
							<input class="form-control" type="password"   name="password" >
							<small class="text-danger error-text  password_error"></small>
						</div>
						<div class="input-block mb-3">
							<label class="col-form-label">  Confirm Password <span class="text-danger">*</span></label>
							<input class="form-control" type="text"   name="password_confirmation" >
							<small class="text-danger error-text  password_confirmation_error"></small>
						</div> -->
						</div>
					
					<span onclick="check_all($(this))" class="btn btn-info float-right">Check All</span></br>
					<div class="table-responsive m-t-15">
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
					</div>
						<div class="row">
                              <div class="col-md-12">
                                 <div class="input-block mb-3">
                                    <h5 class="mb-3">Status</h5>
                                    <div class="status-radio-btns d-flex">
                                       <div class="people-status-radio">
                                          <input type="radio" class="status-radio" id="status-1" name="status" value="1">
                                          <label for="status-1">Active</label>
                                       </div>
                                       <div class="people-status-radio">
                                          <input type="radio" class="status-radio" id="status-0" name="status" value="0">
                                          <label for="status-0">Inactive</label>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           
						<div class="submit-section">
							<button class="btn btn-primary submit-btn" id="submitCreate">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- <div class="modal custom-modal fade" id="delete_department" role="dialog">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-body">
					<div class="form-header">
						<h3>Delete Admin</h3>
						<p>Are you sure want to delete?</p>
					</div>
					<form id="deleteform" action="{{route('admin.employee.department.delete')}}" method="post">
						@csrf
						<div class="modal-btn delete-action">
							<div class="row">
								<div class="col-6">
									<input name="department_id" id="department_id" value="0" type="hidden">
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
	</div> -->
</div>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
	integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
	crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
	function dept_delete(el) {
		$('#department_id').val(el.attr("data-id"));
		$('#delete_department').modal('show');
	}

	function edit(el) {
		$('#admin_id').val(el.attr("data-id"));
		$('#edit_name').val(el.attr("data-name"));
		
		var data = $.parseJSON(el.attr("data-data"));
		if (data.status == 1) {
			$('#status-1').prop("checked", 'checked');
		} else {
			$('#status-0').prop("checked", 'checked');
		}
		var permissions = data.permissions;
		$('#edit_email').val(data.email); 
		$.each(permissions, function (index, value) {
			id = '#' + value;
			$(id).prop('checked', true);
		});
		$('#edit_department').modal('show');
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

			$('.error-text').html('');

			$.ajax({
				url: "{{route('admin.admin.register')}}",  // Replace with your route
				type: "POST",
				data: formData,
				contentType: false,
				processData: false,
				success: function (response) {
					// alert("Form submitted successfully with file!");

					console.log(response);
					tost_fire('Registration successful. Please log in.', 'success');
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
				url: "{{route('admin.admin.update')}}",  // Replace with your route
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