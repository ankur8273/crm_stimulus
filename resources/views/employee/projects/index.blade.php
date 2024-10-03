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
                        <h3 class="page-title">Projects</h3>
                        <ul class="breadcrumb">
                           <li class="breadcrumb-item"><a href="{{route('employee.dashboard')}}">Dashboard</a></li>
                           <li class="breadcrumb-item active">Projects</li>
                        </ul>
                     </div>
                     <div class="col-auto float-end ms-auto">
                        @if(has_permission('Create-Project'))
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#create_project"><i class="fa-solid fa-plus"></i> Create Project</a>
                        @endif
                        <div class="view-icons">
                           <a href="{{route('employee.project.list')}}" class="grid-view btn btn-link"><i class="las la-redo-alt"></i></a>
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
                           <label class="focus-label">Project Name</label>
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
                              <option value="active" {{$status == 'active'?'selected':''}}>Active</option>
                              <option value="inactive" {{$status == 'inactive'?'selected':''}}>InActive</option>
                           </select>
                           <label class="focus-label">Status</label>
                        </div>
                     </div>
                     <div class="col-sm-6 col-md-3">
                        <button href="#" class="btn btn-success w-100" onclick="$('#filter_form').submit();"> Search </button>
                     </div>
                  </div>
               </form>
               <div class="row">
                  <div class="col-md-12">
                     <div class="table-responsive">
                        <table class="table table-striped custom-table datatable">
                           <thead>
                              <tr>
                                 <th>Project</th>
                                 <th>City</th>
                                 <th>Assigned user</th>
                                 <th>Created</th>
                                 <th>Status</th>
                                 <th class="text-end">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($projects as $project)
                              <tr>
                                 <td>
                                    <a @if(has_permission('Read-Project')) href="{{route('employee.project.details',$project->id)}}" @endif >{{$project->name}}</a>
                                 </td>
                                 <td>{{$project->city}}</td>
                                 <td>
                                    <ul class="team-members">
                                       <li>
                                          <a href="#" data-bs-toggle="tooltip" title="{{ $project->user?($project->user->first_name.' '.$project->user->last_name):''}} ">
                                             @if($project->user && $project->user->image)
                                             <img src="{{asset('assets/img/employee/'.$project->user->image)}}" alt="User Image">
                                             @else
                                             <img src="{{asset('assets/img/avatar/images-dummy.jpg')}}" alt="User Image">
                                             @endif
                                          </a>
                                          <span>{{ $project->user?($project->user->first_name.' '.$project->user->last_name):''}}</span>
                                       </li>
                                    </ul>
                                 </td>
                                 
                                 <td>{{date('d M Y',strtotime($project->created_at))}} </td>
                                
                                 <td>
                                    <div class="dropdown action-label">
                                       <a href="#" class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-regular fa-circle-dot text-{{$project->status==1?'success':'danger'}}"></i> {{$project->status==1?'Active':'Inactive' }}</a>
                                       <div class="dropdown-menu">
                                          <a class="dropdown-item" href="{{route('employee.project.change_status',$project->id)}}?status=1"><i class="fa-regular fa-circle-dot text-success"></i> Active</a>
                                          <a class="dropdown-item" href="{{route('employee.project.change_status',$project->id)}}?status=0"><i class="fa-regular fa-circle-dot text-danger"></i> Inactive</a>
                                       </div>
                                    </div>
                                 </td>
                                 <td class="text-end">
                                    <div class="dropdown dropdown-action">
                                       <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                       <div class="dropdown-menu dropdown-menu-right">
                                          @if(has_permission('Write-Project'))
                                          <a class="dropdown-item" href="javascript:void(0);" data-data="{{json_encode($project->toArray())}}" data-href="{{route('employee.project.update',$project->id)}}" onclick="edit_project($(this))"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                          @endif
                                          @if(has_permission('Read-Project'))
                                          <a class="dropdown-item" href="{{route('employee.project.details',$project->id)}}"><i class="fa-regular fa-eye"></i> Preview</a>
                                          @endif
                                          @if(has_permission('Delete-Project'))
                                          <a class="dropdown-item" href="javascript:void(0);" data-href="{{route('employee.project.delete',$project->id)}}" onclick="delete_m($(this))"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
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
      
      
      <div id="create_project" class="modal custom-modal fade" role="dialog">
               <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title">Create Project</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">
                        <form action="{{route('employee.project.store')}}" method="post" enctype="multipart/form-data">
                           @csrf
                           <div class="row">
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Project Name</label>
                                    <input class="form-control" type="text" name="project_name">
                                 </div>
                              </div>

                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Project Location</label>
                                    <input class="form-control" type="text" name="project_location">
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Project City</label>
                                    <input class="form-control" type="text" name="project_city">
                                 </div>
                              </div>

                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Property category</label>
                                    <select class="select" name="property_category[]" multiple>
                                       <option>Resdential</option>
                                       <option>Commercial</option>
                                       <option>Land</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Property Type</label>
                                    <select class="select" name="property_type[]" multiple>
                                       <option>1BHK</option>
                                       <option>2BHK</option>
                                       <option>3BHK</option>
                                       <option>4BHK</option>
                                       <option>Villa</option>
                                       <option>Office</option>
                                       <option>Shop</option>
                                       <option>Gated Land</option>
                                       <option>Open Land</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Project Land Parcel</label>
                                    <input class="form-control" name="project_land_parcel" type="text">
                                 </div>
                              </div>
                           </div>

                           <div class="row">
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Project Open Area</label>
                                    <input class="form-control" type="text" name="project_open_area">
                                 </div>
                              </div>

                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">No. Of Towers</label>
                                    <input class="form-control" type="text" name="no_of_towers">
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Inventory Per Floor</label>
                                    <input class="form-control" type="text" name="inventory_per_floor">
                                 </div>
                              </div>

                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Carpet Area Range</label>
                                    <input class="form-control" type="text" name="carpet_area_range">
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Costing Range</label>
                                    <input class="form-control" type="text" name="costing_range">
                                 </div>
                              </div>

                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Contact Person</label>
                                    <input class="form-control" type="text" name="contact_person">
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Spokes Person Contact</label>
                                    <input class="form-control" type="text" name="spokes_person_Contact" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" pattern="[0-9]{10}">
                                 </div>
                              </div>

                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Customer Project Kit</label>
                                    <input class="form-control" type="text" name="customer_project_kit">
                                 </div>
                              </div>
                           </div>

                           <div class="row">
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Office Project Kit</label>
                                    <input class="form-control" type="text" name="office_project_kit">
                                 </div>
                              </div>

                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Developed By(Company Name)</label>
                                    <input class="form-control" type="text" name="developed_by">
                                 </div>
                              </div>
                           </div>
                           
                           <div class="row">
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Add Project Leader</label>
                                    <select class="select" name="user_id">
                                       <option value="">Select</option>
                                       @foreach(get_employees() as $employee)
                                       <option value="{{$employee->id}}">{{$employee->first_name.' '.$employee->last_name}}</option>
                                       @endforeach
                                    </select>
                                 </div>
                              </div>
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Upload Files</label>
                                    <input class="form-control" type="file" name="file">
                                 </div>
                              </div>
                           </div>
                           
                           <div class="input-block mb-3">
                              <label class="col-form-label">Description</label>
                              <textarea class="form-control" name="note"></textarea>
                           </div>
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="input-block mb-3">
                                    <h5 class="mb-3">Status</h5>
                                    <div class="status-radio-btns d-flex">
                                       <div class="people-status-radio">
                                          <input type="radio" class="status-radio" id="tests6" name="project_status" value="1" checked>
                                          <label for="tests6">Active</label>
                                       </div>
                                       <div class="people-status-radio">
                                          <input type="radio" class="status-radio" id="tests7" name="project_status" value="0">
                                          <label for="tests7">Inactive</label>
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
            <div id="edit_project" class="modal custom-modal fade" role="dialog">
               <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title">Edit Project</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">
                        <form action="{{route('employee.project.update')}}" method="post" enctype="multipart/form-data">
                           @csrf
                           <div class="row">
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Project Name</label>
                                    <input class="form-control" type="text" name="project_name" id="project_name">
                                    <input type="hidden" name="id" id="project_id">
                                 </div>
                              </div>

                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Project Location</label>
                                    <input class="form-control" type="text" name="project_location" id="project_location">
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Project City</label>
                                    <input class="form-control" type="text" name="project_city" id="project_city">
                                 </div>
                              </div>

                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Property category</label>
                                    <select class="select" name="property_category[]" id="property_category" multiple>
                                       <option>Resdential</option>
                                       <option>Commercial</option>
                                       <option>Land</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Property Type</label>
                                    <select class="select" name="property_type[]" id="property_type" multiple>
                                       <option>1BHK</option>
                                       <option>2BHK</option>
                                       <option>3BHK</option>
                                       <option>4BHK</option>
                                       <option>Villa</option>
                                       <option>Office</option>
                                       <option>Shop</option>
                                       <option>Gated Land</option>
                                       <option>Open Land</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Project Land Parcel</label>
                                    <input class="form-control" name="project_land_parcel" type="text" id="project_land_parcel">
                                 </div>
                              </div>
                           </div>

                           <div class="row">
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Project Open Area</label>
                                    <input class="form-control" type="text" name="project_open_area" id="project_open_area">
                                 </div>
                              </div>

                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">No. Of Towers</label>
                                    <input class="form-control" type="text" name="no_of_towers" id="no_of_towers">
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Inventory Per Floor</label>
                                    <input class="form-control" type="text" name="inventory_per_floor" id="inventory_per_floor">
                                 </div>
                              </div>

                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Carpet Area Range</label>
                                    <input class="form-control" type="text" name="carpet_area_range" id="carpet_area_range">
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Costing Range</label>
                                    <input class="form-control" type="text" name="costing_range" id="costing_range">
                                 </div>
                              </div>

                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Contact Person</label>
                                    <input class="form-control" type="text" name="contact_person" id="contact_person">
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Spokes Person Contact</label>
                                    <input class="form-control" type="text" name="spokes_person_Contact" id="spokes_person_Contact" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" pattern="[0-9]{10}">
                                 </div>
                              </div>

                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Customer Project Kit</label>
                                    <input class="form-control" type="text" name="customer_project_kit" id="customer_project_kit">
                                 </div>
                              </div>
                           </div>

                           <div class="row">
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Office Project Kit</label>
                                    <input class="form-control" type="text" name="office_project_kit" id="office_project_kit">
                                 </div>
                              </div>

                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Developed By(Company Name)</label>
                                    <input class="form-control" type="text" name="developed_by" id="developed_by">
                                 </div>
                              </div>
                           </div>
                           
                           <div class="row">
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Add Project Leader</label>
                                    <select class="select" name="user_id" id="user_id">
                                       <option value="">Select</option>
                                       @foreach(get_employees() as $employee)
                                       <option value="{{$employee->id}}">{{$employee->first_name.' '.$employee->last_name}}</option>
                                       @endforeach
                                    </select>
                                 </div>
                              </div>
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Upload Files</label>
                                    <input class="form-control" type="file" name="file" id="file">
                                 </div>
                              </div>
                           </div>
                           
                           <div class="input-block mb-3">
                              <label class="col-form-label">Description</label>
                              <textarea class="form-control" name="note" id="description"></textarea>
                           </div>
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="input-block mb-3">
                                    <h5 class="mb-3">Status</h5>
                                    <div class="status-radio-btns d-flex">
                                       <div class="people-status-radio">
                                          <input type="radio" class="status-radio" id="status-1" name="project_status" value="1">
                                          <label for="status-1">Active</label>
                                       </div>
                                       <div class="people-status-radio">
                                          <input type="radio" class="status-radio" id="status-0" name="project_status" value="0">
                                          <label for="status-0">Inactive</label>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           
                           <div class="submit-section">
                              <button class="btn btn-primary submit-btn">Update</button>
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
                           <h3>Delete Project</h3>
                           <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                           <div class="row">
                              <div class="col-6">
                                 <a href="javascript:void(0);" class="btn btn-primary continue-btn" id="d-okay">Delete</a>
                              </div>
                              <div class="col-6">
                                 <a href="javascript:void(0);" data-bs-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
      
      
@endsection
@section('scripts')
     <script data-cfasync="false" src="{{asset('assets/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js')}}"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
      <script src="{{asset('assets/js/jquery.slimscroll.min.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
      <script src="{{asset('assets/js/jquery.dataTables.min.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
      <script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
      <script src="{{asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
      <script src="{{asset('assets/js/moment.min.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
      <script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
      <script src="{{asset('assets/js/moment.min.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
      <script src="{{asset('assets/plugins/daterangepicker/daterangepicker.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
      <script src="{{asset('assets/js/select2.min.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
      <!-- <script src="{{asset('assets/plugins/summernote/summernote-bs4.min.js')}}" type="712a4b0e0e5ee5c24248da6b-text/javascript"></script> -->
      <script src="{{asset('assets/js/layout.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
      <!-- <script src="{{asset('assets/js/theme-settings.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script> -->
      <!-- <script src="{{asset('assets/js/greedynav.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script> -->
      <script src="{{asset('assets/js/app.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
      <script src="{{asset('assets/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js')}}" data-cf-settings="264280a78fcfef3abf43a170-|49" defer></script>

      <script type="text/javascript"> 

         function edit_project(el){
               var data = $.parseJSON(el.attr("data-data"));
               // console.log(data.status);
               // return false;
               
               // return false;
               $('#project_name').val(data.name);
               $('#project_location').val(data.location);
               $('#project_city').val(data.city);
               $('#property_category').val(data.property_category.split(",")).change();
               // $.each(data.property_category.split(","), function(i,e){
               //     $("#property_category option[value='" + e + "']").prop("selected", true);
               // });
               $('#property_type').val(data.property_type.split(",")).change();
               // $.each(data.property_type.split(","), function(i,e){
               //     $("#property_type option[value='" + e + "']").prop("selected", true);
               // });
               $('#project_land_parcel').val(data.project_land_parcel);
               $('#project_open_area').val(data.project_open_area);
               $('#no_of_towers').val(data.no_of_towers);
               $('#inventory_per_floor').val(data.inventory_per_floor);
               $('#carpet_area_range').val(data.carpet_area_range);
               $('#costing_range').val(data.costing_range);
               $('#contact_person').val(data.contact_person);
               $('#spokes_person_Contact').val(data.spokes_person_Contact);
               $('#customer_project_kit').val(data.customer_project_kit);
               $('#office_project_kit').val(data.office_project_kit);
               $('#developed_by').val(data.developed_by);
               $('#user_id').val(data.user_id).change();
               $('#project_id').val(data.id);
               $('#description').val(data.note);
               if(data.status == 1){
                  $('#status-1').prop("checked", 'checked');
               }else{
                  $('#status-0').prop("checked", 'checked');
               }

               // $('#next_followup').val(data.next_followup).change();
               
               $('#edit_project').modal('show');
            }

            function delete_m(el){
               $('#d-okay').attr("href", el.attr("data-href"));
               $('#delete').modal('show');
            }

      </script>

@endsection