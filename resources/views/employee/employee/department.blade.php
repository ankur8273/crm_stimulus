@extends('employee.layouts.app')
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
                  <h3 class="page-title">Department</h3>
                  <ul class="breadcrumb">
                     <li class="breadcrumb-item"><a href="{{route('employee.dashboard')}}">Dashboard</a></li>
                     <li class="breadcrumb-item active">Department</li>
                  </ul>
               </div>
               <div class="col-auto float-end ms-auto">
                  @if(has_permission('Create-Employee'))
                  <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_department"><i class="fa-solid fa-plus"></i> Add Department</a>
                  @endif
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
                           <th>Department Name</th>
                           <th class="text-end">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($departments as $department)
                        <tr>
                           <td>{{$loop->iteration}}</td>
                           <td>{{$department->name}}</td>
                           <td class="text-end">
                              <div class="dropdown dropdown-action">
                                 <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                 <div class="dropdown-menu dropdown-menu-right">
                                    @if(has_permission('Write-Employee'))
                                    <a class="dropdown-item" href="#" data-id="{{$department->id}}" data-name="{{$department->name}}" onclick="edit($(this))"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                    @endif
                                    @if(has_permission('Delete-Employee'))
                                    <a class="dropdown-item" href="#" data-id="{{$department->id}}" onclick="dept_delete($(this))"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
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
      <div id="add_department" class="modal custom-modal fade" role="dialog">
         <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">Add Department</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <form action="{{route('employee.employee.department.store')}}" method="post">
                     @csrf
                     <div class="input-block mb-3">
                        <label class="col-form-label">Department Name <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" id="name" name="name" required>
                     </div>
                     <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
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
                  <h5 class="modal-title">Edit Department</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <form action="{{route('employee.employee.department.update')}}" method="post">
                     @csrf
                     <div class="input-block mb-3">
                        <label class="col-form-label">Department Name <span class="text-danger">*</span></label>
                        <input  value="" name="id" id="depart_id" type="hidden">
                        <input class="form-control" value="" name="name" id="depart_name" type="text">
                     </div>
                     <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Save</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <div class="modal custom-modal fade" id="delete_department" role="dialog">
         <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
               <div class="modal-body">
                  <div class="form-header">
                     <h3>Delete Department</h3>
                     <p>Are you sure want to delete?</p>
                  </div>
                  <form id="deleteform" action="{{route('employee.employee.department.delete')}}" method="post">
                     @csrf
                     <div class="modal-btn delete-action">
                        <div class="row">
                           <div class="col-6">
                              <input name="department_id" id="department_id" value="0" type="hidden">
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
    <script src="{{asset('assets/js/jquery-3.7.1.min.js')}}" type="a77ca2864b88690ee5a4547f-text/javascript"></script>
      <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}" type="a77ca2864b88690ee5a4547f-text/javascript"></script>
      <script src="{{asset('assets/js/jquery.slimscroll.min.js')}}" type="a77ca2864b88690ee5a4547f-text/javascript"></script>
      
      <script src="{{asset('assets/js/jquery.dataTables.min.js')}}" type="a77ca2864b88690ee5a4547f-text/javascript"></script>
      <script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}" type="a77ca2864b88690ee5a4547f-text/javascript"></script>
      <script src="{{asset('assets/js/layout.js')}}" type="a77ca2864b88690ee5a4547f-text/javascript"></script>
      <!-- <script src="{{asset('assets/js/theme-settings.js')}}" type="a77ca2864b88690ee5a4547f-text/javascript"></script> -->
      <!-- <script src="{{asset('assets/js/greedynav.js')}}" type="a77ca2864b88690ee5a4547f-text/javascript"></script> -->
      <script src="{{asset('assets/js/app.js')}}" type="a77ca2864b88690ee5a4547f-text/javascript"></script>
      <script src="{{asset('assets/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js')}}" data-cf-settings="a77ca2864b88690ee5a4547f-|49" defer></script>
      
      <script type="text/javascript">
            
            function dept_delete(el){
               $('#department_id').val(el.attr("data-id"));
               $('#delete_department').modal('show');
            }

            function edit(el){
               $('#depart_id').val(el.attr("data-id"));
               $('#depart_name').val(el.attr("data-name"));
               $('#edit_department').modal('show');
            }

        </script>


@endsection