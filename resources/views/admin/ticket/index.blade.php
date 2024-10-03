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
                  <h3 class="page-title">Tickets</h3>
                  <ul class="breadcrumb">
                     <li class="breadcrumb-item"><a href="admin-dashboard.html">Dashboard</a></li>
                     <li class="breadcrumb-item active">Tickets</li>
                  </ul>
               </div>
               <div class="col-auto float-end ms-auto">
                  <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_ticket"><i class="fa-solid fa-plus"></i> Add Ticket</a>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-12">
               <div class="card-group m-b-30">
                  <div class="card">
                     <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                           <div>
                              <span class="d-block">New Tickets</span>
                           </div>
                           <div>
                              <span class="text-success">{{$total??round($new/($total/100),2)}}%</span>
                           </div>
                        </div>
                        <h3 class="mb-3">{{$new}}</h3>
                        <div class="progress height-five mb-2">
                           <div class="progress-bar bg-primary w-{{$total??round($new/($total/100))}}" role="progressbar" aria-valuenow="{{$new}}" aria-valuemin="0" aria-valuemax="{{$total}}"></div>
                        </div>
                     </div>
                  </div>
                  <div class="card">
                     <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                           <div>
                              <span class="d-block">Solved Tickets</span>
                           </div>
                           <div>
                              <span class="text-success">{{$total??round($closed/($total/100),2)}}%</span>
                           </div>
                        </div>
                        <h3 class="mb-3">{{$closed}}</h3>
                        <div class="progress height-five mb-2">
                           <div class="progress-bar bg-primary w-{{$total??round($closed/($total/100))}}" role="progressbar" aria-valuenow="{{$closed}}" aria-valuemin="0" aria-valuemax="{{$total}}"></div>
                        </div>
                     </div>
                  </div>
                  <div class="card">
                     <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                           <div>
                              <span class="d-block">Open Tickets</span>
                           </div>
                           <div>
                              <span class="text-danger">{{$total??round($opened/($total/100),2)}}%</span>
                           </div>
                        </div>
                        <h3 class="mb-3">{{$opened}}</h3>
                        <div class="progress height-five mb-2">
                           <div class="progress-bar bg-primary w-{{$total??round($opened/($total/100))}}" role="progressbar" aria-valuenow="{{$opened}}" aria-valuemin="0" aria-valuemax="{{$total}}"></div>
                        </div>
                     </div>
                  </div>
                  <div class="card">
                     <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                           <div>
                              <span class="d-block">Pending Tickets</span>
                           </div>
                           <div>
                              <span class="text-danger">{{$total??round($pending/($total/100),2)}}%</span>
                           </div>
                        </div>
                        <h3 class="mb-3">{{$pending}}</h3>
                        <div class="progress height-five mb-2">
                           <div class="progress-bar bg-primary w-{{$total??round($pending/($total/100))}}" role="progressbar" aria-valuenow="{{$pending}}" aria-valuemin="0" aria-valuemax="{{$total}}"></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <form action="{{route('admin.ticket.list')}}" method="get">
            <div class="row filter-row">
               <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                  <div class="input-block mb-3 form-focus">
                     <input type="text" class="form-control floating" name="employee_name" value="{{$employee_name}}">
                     <label class="focus-label">Employee Name</label>
                  </div>
               </div>
               <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                  <div class="input-block mb-3 form-focus select-focus">
                     <select class="select floating" name="status">
                        <option value=""> -- Select -- </option>
                        <option {{$status=='Opened'?'selected':''}}>Opened</option>
                        <option {{$status=='Reopened'?'selected':''}}>Reopened</option>
                        <option {{$status=='On Hold'?'selected':''}}>On Hold</option>
                        <option {{$status=='Closed'?'selected':''}}>Closed</option>
                        <option {{$status=='In Progress'?'selected':''}}>In Progress</option>
                        <option {{$status=='Cancelled'?'selected':''}}>Cancelled</option>
                     </select>
                     <label class="focus-label">Status</label>
                  </div>
               </div>
               <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                  <div class="input-block mb-3 form-focus select-focus">
                     <select class="select floating" name="priority">
                        <option value=""> -- Select -- </option>
                        <option {{$priority=='High'?'selected':''}}>High</option>
                        <option {{$priority=='Low'?'selected':''}}>Low</option>
                        <option {{$priority=='Medium'?'selected':''}}>Medium</option>
                     </select>
                     <label class="focus-label">Priority</label>
                  </div>
               </div>
               <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                  <div class="input-block mb-3 form-focus">
                     <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text" name="from" value="{{$from}}">
                     </div>
                     <label class="focus-label">From</label>
                  </div>
               </div>
               <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                  <div class="input-block mb-3 form-focus">
                     <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text" name="to" value="{{$to}}">
                     </div>
                     <label class="focus-label">To</label>
                  </div>
               </div>
               <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                  <button type="submit" class="btn btn-success w-100"> Search </button>
               </div>
            </div>
         </form>
         <div class="row">
            <div class="col-md-12">
               <div class="table-responsive">
                  <table class="table table-striped custom-table mb-0 datatable">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Ticket Id</th>
                           <th>Ticket Subject</th>
                           <th>Created By</th>
                           <th>Created Date</th>
                           <th>Last Reply</th>
                           <th>Priority</th>
                           <th>Status</th>
                           <th>Actions</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($tickets as $ticket)
                        <tr>
                           <td>{{$loop->iteration}}</td>
                           <td><a href="{{route('admin.ticket.details',$ticket->id)}}">#{{$ticket->ticket_id}}</a></td>
                           <td>{{$ticket->subject}}</td>
                           @if($ticket->created_by == 'admin')
                           <td>{{$ticket->user->name??''}}</td>
                           @else
                           <td>{{$ticket->user->first_name??''.' '.$ticket->user->last_name??''}}</td>
                           @endif
                           
                           <td>{{date('d M Y h.i a',strtotime($ticket->created_at))}}</td>
                           @if(count($ticket->tkt_details)>0)
                           <td>{{date('d M Y h.i a',strtotime($ticket->tkt_details->last()->created_at))}}</td>
                           @else
                           <td>{{date('d M Y h.i a',strtotime($ticket->updated_at))}}</td>
                           @endif
                           <td>
                              <div class="dropdown action-label">
                                 <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-regular fa-circle-dot text-{{$ticket->priority=='High'?'danger':''}}{{$ticket->priority=='Medium'?'warning':''}}{{$ticket->priority=='Low'?'success':''}}"></i> {{$ticket->priority}} </a>
                                 <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"><i class="fa-regular fa-circle-dot text-danger"></i> High</a>
                                    <a class="dropdown-item" href="#"><i class="fa-regular fa-circle-dot text-warning"></i> Medium</a>
                                    <a class="dropdown-item" href="#"><i class="fa-regular fa-circle-dot text-success"></i> Low</a>
                                 </div>
                              </div>
                           </td>
                           <td>
                              <div class="dropdown action-label">
                                 <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                 <i class="fa-regular fa-circle-dot text-{{in_array($ticket->status,['Closed','In Progress'])?'success':''}}{{in_array($ticket->status,['Open','Reopened'])?'info':''}}{{in_array($ticket->status,['On Hold','Cancelled','New'])?'danger':''}}"></i> {{$ticket->status}}
                                 </a>
                                 <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="change_status('{{route('admin.ticket.update_status',$ticket->id)}}','Open')"><i class="fa-regular fa-circle-dot text-info"></i> Open</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="change_status('{{route('admin.ticket.update_status',$ticket->id)}}','Reopened')"><i class="fa-regular fa-circle-dot text-info"></i> Reopened</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="change_status('{{route('admin.ticket.update_status',$ticket->id)}}','On Hold')"><i class="fa-regular fa-circle-dot text-danger"></i> On Hold</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="change_status('{{route('admin.ticket.update_status',$ticket->id)}}','Closed')"><i class="fa-regular fa-circle-dot text-success"></i> Closed</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="change_status('{{route('admin.ticket.update_status',$ticket->id)}}','In Progress')"><i class="fa-regular fa-circle-dot text-success"></i> In Progress</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="change_status('{{route('admin.ticket.update_status',$ticket->id)}}','Cancelled')"><i class="fa-regular fa-circle-dot text-danger"></i> Cancelled</a>
                                 </div>
                              </div>
                           </td>
                           <td class="text-end">
                              <div class="dropdown dropdown-action">
                                 <a href="javascript:void(0);" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                 <div class="dropdown-menu dropdown-menu-right">
                                    <!-- <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_ticket"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a> -->
                                    <a class="dropdown-item" href="javascript:void(0);" data-href="{{route('admin.ticket.delete',$ticket->id)}}" onclick="delete_m($(this))"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                                    <a class="dropdown-item" href="{{route('admin.ticket.details',$ticket->id)}}"><i class="fa-regular fa-eye"></i> Preview</a>
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
      
      
            <div id="add_ticket" class="modal custom-modal fade" role="dialog">
               <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title">Add Ticket</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">
                        <form action="{{route('admin.ticket.store')}}" method="post" enctype="multipart/form-data">
                           @csrf
                           <div class="row">
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Ticket Subject</label>
                                    <input class="form-control" type="text" name="subject" required>
                                 </div>
                              </div>
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Priority</label>
                                    <select class="select" name="priority" required>
                                       <option>High</option>
                                       <option>Medium</option>
                                       <option>Low</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           
                           <div class="row">
                              <div class="col-sm-12">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Description</label>
                                    <textarea class="form-control" name="description" required></textarea>
                                 </div>
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Upload Files</label>
                                    <input class="form-control" type="file" name="files[]" multiple>
                                    <p class="text-info">you can choose multiple files</p>
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
            <div id="edit_ticket" class="modal custom-modal fade" role="dialog">
               <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title">Edit Ticket</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">
                        <form>
                           <div class="row">
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Ticket Subject</label>
                                    <input class="form-control" type="text" value="Laptop Issue">
                                 </div>
                              </div>
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Ticket Id</label>
                                    <input class="form-control" type="text" readonly value="TKT-0001">
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Assign Staff</label>
                                    <select class="select">
                                       <option>-</option>
                                       <option selected>Mike Litorus</option>
                                       <option>John Smith</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Client</label>
                                    <select class="select">
                                       <option>-</option>
                                       <option>Delta Infotech</option>
                                       <option selected>International Software Inc</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Priority</label>
                                    <select class="select">
                                       <option>High</option>
                                       <option selected>Medium</option>
                                       <option>Low</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">CC</label>
                                    <input class="form-control" type="text">
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Assign</label>
                                    <input type="text" class="form-control">
                                 </div>
                              </div>
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Ticket Assignee</label>
                                    <div class="project-members">
                                       <a title="John Smith" data-placement="top" data-bs-toggle="tooltip" href="#" class="avatar">
                                       <img src="assets/img/profiles/avatar-02.jpg" alt="User Image">
                                       </a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Add Followers</label>
                                    <input type="text" class="form-control">
                                 </div>
                              </div>
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Ticket Followers</label>
                                    <div class="project-members">
                                       <a title="Richard Miles" data-bs-toggle="tooltip" href="#" class="avatar">
                                       <img src="assets/img/profiles/avatar-09.jpg" alt="User Image">
                                       </a>
                                       <a title="John Smith" data-bs-toggle="tooltip" href="#" class="avatar">
                                       <img src="assets/img/profiles/avatar-10.jpg" alt="User Image">
                                       </a>
                                       <a title="Mike Litorus" data-bs-toggle="tooltip" href="#" class="avatar">
                                       <img src="assets/img/profiles/avatar-05.jpg" alt="User Image">
                                       </a>
                                       <a title="Wilmer Deluna" data-bs-toggle="tooltip" href="#" class="avatar">
                                       <img src="assets/img/profiles/avatar-11.jpg" alt="User Image">
                                       </a>
                                       <span class="all-team">+2</span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-12">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Description</label>
                                    <textarea class="form-control"></textarea>
                                 </div>
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Upload Files</label>
                                    <input class="form-control" type="file">
                                 </div>
                              </div>
                           </div>
                           <div class="submit-section">
                              <button class="btn btn-primary submit-btn">Save</button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal custom-modal fade" id="delete_ticket" role="dialog">
               <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                     <div class="modal-body">
                        <div class="form-header">
                           <h3>Delete Ticket</h3>
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
               $('#delete_ticket').modal('show');
            }

            function change_status(url,status){
            $.ajax({
               url:url,
                method:'post',
                data:{
                    '_token': '{{csrf_token()}}',
                    'status': status
                },
                success:function(result)
                {
                    if (result) {
                           $('#status-bar').html(status); 
                        
                        tost_fire('Status Updated Successfully!','success');
                        location.reload();
                    }else{
                        tost_fire('Can Not Update This Lead!','error');
                    }
                }
            });
         }

      </script>

@endsection