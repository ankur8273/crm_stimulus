@extends('employee.layouts.app')
@push('css')
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
      <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome/css/fontawesome.min.css')}}">
      <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome/css/all.min.css')}}">
      <link rel="stylesheet" href="{{asset('assets/css/line-awesome.min.css')}}">
      <link rel="stylesheet" href="{{asset('assets/css/material.css')}}">
      <link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}">
      <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
      <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
      
@endpush
@section('content')

   <div class="page-wrapper">
            <div class="content container-fluid">
               <div class="page-header">
                  <div class="row align-items-center">
                     <div class="col">
                        <h3 class="page-title">Designations</h3>
                        <ul class="breadcrumb">
                           <li class="breadcrumb-item"><a href="{{route('employee.dashboard')}}">Dashboard</a></li>
                           <li class="breadcrumb-item active">Designations</li>
                        </ul>
                     </div>
                     <div class="col-auto float-end ms-auto">
                        @if(has_permission('Create-Employee'))
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_designation"><i class="fa-solid fa-plus"></i> Add Designation</a>
                        @endif
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0 datatable">
                           <thead>
                              <tr>
                                 <th class="width-thirty">#</th>
                                 <th>Designation </th>
                                 <th>Department </th>
                                 <th class="text-end">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($designations as $designation)
                              <tr>
                                 <td>{{$loop->iteration}}</td>
                                 <td>{{$designation->name}}</td>
                                 <td>{{$designation->department->name}}</td>
                                 <td class="text-end">
                                    <div class="dropdown dropdown-action">
                                       <a href="#" class="action-icon dropd
                                       own-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                       <div class="dropdown-menu dropdown-menu-right">
                                          @if(has_permission('Write-Employee'))
                                          <a class="dropdown-item" href="#" data-id="{{$designation->id}}" data-name="{{$designation->name}}" data-department_id="{{$designation->department_id}}" onclick="edit($(this))"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                          @endif
                                          @if(has_permission('Delete-Employee'))
                                          <a class="dropdown-item" href="#" data-id="{{$designation->id}}" onclick="dept_delete($(this))"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
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
            <div id="add_designation" class="modal custom-modal fade" role="dialog">
               <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title">Add Designation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">
                        <form action="{{route('employee.employee.designation.store')}}" method="post">
                           @csrf
                           <div class="input-block mb-3">
                              <label class="col-form-label">Designation Name <span class="text-danger">*</span></label>
                              <input class="form-control" name="name" type="text" required>
                           </div>
                           <div class="input-block mb-3">
                              <label class="col-form-label">Department <span class="text-danger">*</span></label>
                              <select class="select" name="department_id" required>
                                 <option value="">Select Department</option>
                                 @foreach(get_departments() as $department)
                                 <option value="{{$department->id}}">{{$department->name}}</option>
                                 @endforeach
                              </select>
                           </div>
                           <div class="submit-section">
                              <button class="btn btn-primary submit-btn">Submit</button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            <div id="edit_designation" class="modal custom-modal fade" role="dialog">
               <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title">Edit Designation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">
                        <form action="{{route('employee.employee.designation.update')}}" method="post">
                           @csrf
                           <div class="input-block mb-3">
                              <label class="col-form-label">Designation Name <span class="text-danger">*</span></label>
                              <input  name="id" id="designat_id" value="" type="hidden" required>
                              <input class="form-control" name="name" id="designat_name" value="Web Developer" type="text" required>
                           </div>
                           <div class="input-block mb-3">
                              <label class="col-form-label">Department <span class="text-danger">*</span></label>
                              <select class="select" id="department_id" name="department_id" required>
                                 <option value="">Select Department</option>
                                 @foreach(get_departments() as $department)
                                    <option value="{{$department->id}}">{{$department->name}}</option>
                                 @endforeach
                              </select>
                           </div>
                           <div class="submit-section">
                              <button class="btn btn-primary submit-btn">Save</button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal custom-modal fade" id="delete_designation" role="dialog">
               <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                     <div class="modal-body">
                        <div class="form-header">
                           <h3>Delete Designation</h3>
                           <p>Are you sure want to delete?</p>
                        </div>
                        <form id="deleteform" action="{{route('employee.employee.designation.delete')}}" method="post">
                           @csrf
                           <div class="modal-btn delete-action">
                              <div class="row">
                                 <div class="col-6">
                                    <input name="id" id="designation_id" value="0" type="hidden">
                                    <a href="javascript:void(0);" class="btn btn-primary continue-btn" onclick="$(this).closest('form').submit();">Delete</a>
                                 </div>
                                 <div class="col-6">
                                    <a href="javascript:void(0);" data-bs-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
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
    <script src="{{asset('assets/js/jquery-3.7.1.min.js')}}" type="e2d4dba2f63b17f7af09d7c6-text/javascript"></script>
      <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}" type="e2d4dba2f63b17f7af09d7c6-text/javascript"></script>
      <script src="{{asset('assets/js/jquery.slimscroll.min.js')}}" type="e2d4dba2f63b17f7af09d7c6-text/javascript"></script>
      <script src="{{asset('assets/js/select2.min.js')}}" type="e2d4dba2f63b17f7af09d7c6-text/javascript"></script>
      <script src="{{asset('assets/js/jquery.dataTables.min.js')}}" type="e2d4dba2f63b17f7af09d7c6-text/javascript"></script>
      <script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}" type="e2d4dba2f63b17f7af09d7c6-text/javascript"></script>
      <script src="{{asset('assets/js/layout.js')}}" type="e2d4dba2f63b17f7af09d7c6-text/javascript"></script>
      <!-- <script src="{{asset('assets/js/theme-settings.js')}}" type="e2d4dba2f63b17f7af09d7c6-text/javascript"></script> -->
      <!-- <script src="{{asset('assets/js/greedynav.js')}}" type="e2d4dba2f63b17f7af09d7c6-text/javascript"></script> -->
      <script src="{{asset('assets/js/app.js')}}" type="e2d4dba2f63b17f7af09d7c6-text/javascript"></script>
      <script src="{{asset('assets/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js')}}" data-cf-settings="e2d4dba2f63b17f7af09d7c6-|49" defer></script>
      
      <script type="text/javascript">
            
            function dept_delete(el){
               $('#designation_id').val(el.attr("data-id"));
               $('#delete_designation').modal('show');
            }

            function edit(el){
               $('#designat_id').val(el.attr("data-id"));
               $('#designat_name').val(el.attr("data-name"));
               $('#department_id').val(el.attr("data-department_id")).change();
               $('#edit_designation').modal('show');
            }

        </script>


@endsection