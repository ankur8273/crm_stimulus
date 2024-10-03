@extends('admin.layouts.app')
@push('css')
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">

   <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome/css/fontawesome.min.css')}}">
   <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome/css/all.min.css')}}">

   <link rel="stylesheet" href="{{asset('assets/css/line-awesome.min.css')}}">
   <link rel="stylesheet" href="{{asset('assets/css/material.css')}}">

   <link rel="stylesheet" href="{{asset('assets/plugins/morris/morris.css')}}">

   <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
   <link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}">
@endpush
@section('content')

<div class="page-wrapper">
    <div class="content container-fluid pb-0">
       <div class="page-header">
          <div class="row">
             <div class="col-sm-12">
                <h3 class="page-title">Welcome Admin!!</h3>
                <ul class="breadcrumb">
                   <li class="breadcrumb-item active">Dashboard</li>
                </ul>
             </div>
          </div>
       </div>
       <div class="row">
          <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
             <div class="card dash-widget">
                <div class="card-body">
                   <span class="dash-widget-icon"><i class="fa-solid fa-cubes"></i></span>
                   <div class="dash-widget-info">
                      <h3>{{$totalprojects}}</h3>
                      <span>Projects</span>
                   </div>
                </div>
             </div>
          </div>
          <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
             <div class="card dash-widget">
                <div class="card-body">
                   <span class="dash-widget-icon"><i class="fa-solid fa-dollar-sign"></i></span>
                   <div class="dash-widget-info">
                      <h3>{{$totalcontacts}}</h3>
                      <span>Contact</span>
                   </div>
                </div>
             </div>
          </div>
          <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
             <div class="card dash-widget">
                <div class="card-body">
                   <span class="dash-widget-icon"><i class="fa-regular fa-gem"></i></span>
                   <div class="dash-widget-info">
                      <h3>{{$totalleads}}</h3>
                      <span>Leads</span>
                   </div>
                </div>
             </div>
          </div>
          <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
             <div class="card dash-widget">
                <div class="card-body">
                   <span class="dash-widget-icon"><i class="fa-solid fa-user"></i></span>
                   <div class="dash-widget-info">
                      <h3>{{$totalemployees}}</h3>
                      <span>Employees</span>
                   </div>
                </div>
             </div>
          </div>
       </div>
       <div class="row">
          <div class="col-md-12">
             <div class="row">
                <div class="col-md-6 text-center">
                   <div class="card">
                      <div class="card-body">
                         <h3 class="card-title">Lead Status</h3>
                         <div id="bar-charts-lead"></div>
                      </div>
                   </div>
                </div>
                <div class="col-md-6 text-center">
                   <div class="card">
                      <div class="card-body">
                         <h3 class="card-title">Followup Type</h3>
                         <div id="line-charts-lead"></div>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
       <!-- <div class="row">
          <div class="col-md-12">
             <div class="card-group m-b-30">
                <div class="card">
                   <div class="card-body">
                      <div class="d-flex justify-content-between mb-3">
                         <div>
                            <span class="d-block">New Employees</span>
                         </div>
                         <div>
                            <span class="text-success">+10%</span>
                         </div>
                      </div>
                      <h3 class="mb-3">10</h3>
                      <div class="progress height-five mb-2">
                         <div class="progress-bar bg-primary w-70" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <p class="mb-0">Overall Employees 218</p>
                   </div>
                </div>
                <div class="card">
                   <div class="card-body">
                      <div class="d-flex justify-content-between mb-3">
                         <div>
                            <span class="d-block">Earnings</span>
                         </div>
                         <div>
                            <span class="text-success">+12.5%</span>
                         </div>
                      </div>
                      <h3 class="mb-3">$1,42,300</h3>
                      <div class="progress height-five mb-2">
                         <div class="progress-bar bg-primary w-70" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <p class="mb-0">Previous Month <span class="text-muted">$1,15,852</span></p>
                   </div>
                </div>
                <div class="card">
                   <div class="card-body">
                      <div class="d-flex justify-content-between mb-3">
                         <div>
                            <span class="d-block">Expenses</span>
                         </div>
                         <div>
                            <span class="text-danger">-2.8%</span>
                         </div>
                      </div>
                      <h3 class="mb-3">$8,500</h3>
                      <div class="progress height-five mb-2">
                         <div class="progress-bar bg-primary w-70" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <p class="mb-0">Previous Month <span class="text-muted">$7,500</span></p>
                   </div>
                </div>
                <div class="card">
                   <div class="card-body">
                      <div class="d-flex justify-content-between mb-3">
                         <div>
                            <span class="d-block">Profit</span>
                         </div>
                         <div>
                            <span class="text-danger">-75%</span>
                         </div>
                      </div>
                      <h3 class="mb-3">$1,12,000</h3>
                      <div class="progress height-five mb-2">
                         <div class="progress-bar bg-primary w-70" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <p class="mb-0">Previous Month <span class="text-muted">$1,42,000</span></p>
                   </div>
                </div>
             </div>
          </div>
       </div>
       <div class="row">
          <div class="col-md-12 col-lg-12 col-xl-4 d-flex">
             <div class="card flex-fill dash-statistics">
                <div class="card-body">
                   <h5 class="card-title">Statistics</h5>
                   <div class="stats-list">
                      <div class="stats-info">
                         <p>Today Leave <strong>4 <small>/ 65</small></strong></p>
                         <div class="progress">
                            <div class="progress-bar bg-primary w-31" role="progressbar" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>
                         </div>
                      </div>
                      <div class="stats-info">
                         <p>Pending Invoice <strong>15 <small>/ 92</small></strong></p>
                         <div class="progress">
                            <div class="progress-bar bg-warning w-31" role="progressbar" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>
                         </div>
                      </div>
                      <div class="stats-info">
                         <p>Completed Projects <strong>85 <small>/ 112</small></strong></p>
                         <div class="progress">
                            <div class="progress-bar bg-success w-62" role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                         </div>
                      </div>
                      <div class="stats-info">
                         <p>Open Tickets <strong>190 <small>/ 212</small></strong></p>
                         <div class="progress">
                            <div class="progress-bar bg-danger w-62" role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                         </div>
                      </div>
                      <div class="stats-info">
                         <p>Closed Tickets <strong>22 <small>/ 212</small></strong></p>
                         <div class="progress">
                            <div class="progress-bar bg-info w-22" role="progressbar" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                         </div>
                      </div>
                   </div>
                </div>
             </div>
          </div>
          <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
             <div class="card flex-fill">
                <div class="card-body">
                   <h4 class="card-title">Task Statistics</h4>
                   <div class="statistics">
                      <div class="row">
                         <div class="col-md-6 col-6 text-center">
                            <div class="stats-box mb-4">
                               <p>Total Tasks</p>
                               <h3>385</h3>
                            </div>
                         </div>
                         <div class="col-md-6 col-6 text-center">
                            <div class="stats-box mb-4">
                               <p>Overdue Tasks</p>
                               <h3>19</h3>
                            </div>
                         </div>
                      </div>
                   </div>
                   <div class="progress mb-4">
                      <div class="progress-bar bg-purple w-30" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">30%</div>
                      <div class="progress-bar bg-warning w-22" role="progressbar" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100">22%</div>
                      <div class="progress-bar bg-success w-24" role="progressbar" aria-valuenow="12" aria-valuemin="0" aria-valuemax="100">24%</div>
                      <div class="progress-bar bg-danger w-21" role="progressbar" aria-valuenow="14" aria-valuemin="0" aria-valuemax="100">21%</div>
                      <div class="progress-bar bg-info w-10" role="progressbar" aria-valuenow="14" aria-valuemin="0" aria-valuemax="100">10%</div>
                   </div>
                   <div>
                      <p><i class="fa-regular fa-circle-dot text-purple me-2"></i>Completed Tasks <span class="float-end">166</span></p>
                      <p><i class="fa-regular fa-circle-dot text-warning me-2"></i>Inprogress Tasks <span class="float-end">115</span></p>
                      <p><i class="fa-regular fa-circle-dot text-success me-2"></i>On Hold Tasks <span class="float-end">31</span></p>
                      <p><i class="fa-regular fa-circle-dot text-danger me-2"></i>Pending Tasks <span class="float-end">47</span></p>
                      <p class="mb-0"><i class="fa-regular fa-circle-dot text-info me-2"></i>Review Tasks <span class="float-end">5</span></p>
                   </div>
                </div>
             </div>
          </div>
          <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
             <div class="card flex-fill">
                <div class="card-body">
                   <h4 class="card-title">Today Absent <span class="badge bg-inverse-danger ms-2">5</span></h4>
                   <div class="leave-info-box">
                      <div class="media d-flex align-items-center">
                         <a href="profile.html" class="avatar"><img src="{{asset('assets/img/user.jpg')}}" alt="User Image"></a>
                         <div class="media-body flex-grow-1">
                            <div class="text-sm my-0">Martin Lewis</div>
                         </div>
                      </div>
                      <div class="row align-items-center mt-3">
                         <div class="col-6">
                            <h6 class="mb-0">4 Sep 2019</h6>
                            <span class="text-sm text-muted">Leave Date</span>
                         </div>
                         <div class="col-6 text-end">
                            <span class="badge bg-inverse-danger">Pending</span>
                         </div>
                      </div>
                   </div>
                   <div class="leave-info-box">
                      <div class="media d-flex align-items-center">
                         <a href="profile.html" class="avatar"><img src="{{asset('assets/img/user.jpg')}}" alt="User Image"></a>
                         <div class="media-body flex-grow-1">
                            <div class="text-sm my-0">Martin Lewis</div>
                         </div>
                      </div>
                      <div class="row align-items-center mt-3">
                         <div class="col-6">
                            <h6 class="mb-0">4 Sep 2019</h6>
                            <span class="text-sm text-muted">Leave Date</span>
                         </div>
                         <div class="col-6 text-end">
                            <span class="badge bg-inverse-success">Approved</span>
                         </div>
                      </div>
                   </div>
                   <div class="load-more text-center">
                      <a class="text-dark" href="javascript:void(0);">Load More</a>
                   </div>
                </div>
             </div>
          </div>
       </div> -->
       <div class="row">
          <div class="col-md-6 d-flex">
             <div class="card card-table flex-fill">
                <div class="card-header">
                   <h3 class="card-title mb-0">Employees</h3>
                </div>
                <div class="card-body">
                   <div class="table-responsive">
                      <table class="table table-nowrap custom-table mb-0">
                         <thead>
                            <tr>
                               <th>Employee Name</th>
                               <th>Employee ID</th>
                               <th>Employee Email</th>
                               <th>Employee Phone</th>
                               <th>Employee DOJ</th>
                            </tr>
                         </thead>
                         <tbody>
                           @foreach($employees as $employee)
                            <tr>
                               <td>
                                    <h2 class="table-avatar">
                                       <a href="#" class="avatar">
                                          @if($employee->image)
                                          <img src="{{asset('assets/img/employee/'.$employee->image)}}" alt="User Image">
                                          @else
                                          <img src="{{asset('assets/img/avatar/images-dummy.jpg')}}" alt="User Image">
                                          @endif
                                       </a>
                                       <a href="#">{{$employee->first_name.' '.$employee->last_name}}  <span>{{$employee->department->name??''}}</span></a>
                                    </h2>
                               </td>
                               <td>{{$employee->employee_id}}</td>
                              <td><a href="#" >{{$employee->email}}</a></td>
                              <td>{{$employee->phone}}</td>
                              <td>{{date('d M y',strtotime($employee->joining_date))}}</td>
                            </tr>
                           @endforeach
                         </tbody>
                      </table>
                   </div>
                </div>
                <div class="card-footer">
                   <a href="{{route('admin.employee.list')}}">View all Employee</a>
                </div>
             </div>
          </div>
          <div class="col-md-6 d-flex">
             <div class="card card-table flex-fill">
                <div class="card-header">
                   <h3 class="card-title mb-0">Tickets</h3>
                </div>
                <div class="card-body">
                   <div class="table-responsive">
                      <table class="table custom-table table-nowrap mb-0">
                         <thead>
                            <tr>
                                 <th>Ticket Id</th>
                                 <th>Ticket Subject</th>
                                 <th>Created By</th>
                                 <th>Created Date</th>
                                 <th>Last Reply</th>
                            </tr>
                         </thead>
                         <tbody>
                           @foreach($tickets as $ticket)
                            <tr>
                                 <td><a href="{{route('admin.ticket.details',$ticket->id)}}">#{{$ticket->ticket_id}}</a></td>
                                 <td>{{$ticket->subject}}</td>
                                 @if($ticket->created_by == 'admin')
                                 <td>{{$ticket->user->name??''}}</td>
                                 @else
                                 <td>{{$ticket->user->first_name??''.' '. !empty($ticket->user->last_name) ??''}}</td>
                                 @endif
                                 
                                 <td>{{date('d M Y h.i a',strtotime($ticket->created_at))}}</td>
                                 @if(count($ticket->tkt_details)>0)
                                 <td>{{date('d M Y h.i a',strtotime($ticket->tkt_details->last()->created_at))}}</td>
                                 @else
                                 <td>{{date('d M Y h.i a',strtotime($ticket->updated_at))}}</td>
                                 @endif
                            </tr>
                           @endforeach
                         </tbody>
                      </table>
                   </div>
                </div>
                <div class="card-footer">
                   <a href="{{route('admin.ticket.list')}}">View all Tickets</a>
                </div>
             </div>
          </div>
       </div>
       <div class="row">
          <div class="col-md-6 d-flex">
             <div class="card card-table flex-fill">
                <div class="card-header">
                   <h3 class="card-title mb-0">Contacts</h3>
                </div>
                <div class="card-body">
                   <div class="table-responsive">
                      <table class="table custom-table mb-0">
                         <thead>
                            <tr>
                               <th>Name</th>
                               <th>Phone</th>
                               <th>Email</th>
                               <th>Status</th>
                            </tr>
                         </thead>
                         <tbody>
                           @foreach($contacts as $contact)
                            <tr>
                               <td>
                                  <h2 class="table-avatar">
                                     <a href="{{route('admin.contact.details',$contact->id)}}" class="avatar">
                                       @if($contact->image)
                                       <img src="{{asset('assets/img/contact/'.$contact->image)}}" alt="User Image">
                                       @else
                                       <img src="{{asset('assets/img/avatar/images-dummy.jpg')}}" alt="User Image">
                                       @endif
                                    </a>
                                     <a href="{{route('admin.contact.details',$contact->id)}}">{{$contact->first_name.' '.$contact->last_name}} <span>{{$contact->job_title}}</span></a>
                                  </h2>
                               </td>
                               <td>{{$contact->phone}}</td>
                               <td>{{$contact->email}}</td>
                               <td>
                                  <div class="dropdown action-label">
                                     <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                     <i class="fa-regular fa-circle-dot text-success"></i>@if($contact->status==1) Active @else Inactive @endif
                                     </a>
                                     <!--<div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#"><i class="fa-regular fa-circle-dot text-success"></i> Active</a>
                                        <a class="dropdown-item" href="#"><i class="fa-regular fa-circle-dot text-danger"></i> Inactive</a>
                                     </div>-->
                                  </div>
                               </td>
                            </tr>
                            @endforeach
                         </tbody>
                      </table>
                   </div>
                </div>
                <div class="card-footer">
                   <a href="{{route('admin.contact.list')}}">View all Contacts</a>
                </div>
             </div>
          </div>
          <div class="col-md-6 d-flex">
             <div class="card card-table flex-fill">
                <div class="card-header">
                   <h3 class="card-title mb-0">Recent Projects</h3>
                </div>
                <div class="card-body">
                   <div class="table-responsive">
                      <table class="table custom-table mb-0">
                         <thead>
                            <tr>
                               <th>Project Name </th>
                               <th>City</th>
                               <th>Owner</th>
                               <th class="text-end">Action</th>
                            </tr>
                         </thead>
                         <tbody>
                            @foreach($projects as $project)
                            <tr>
                               <td>
                                  <h2><a href="{{route('admin.project.details',$project->id)}}">{{$project->name}}</a></h2>
                                  
                               </td>
                               <td>
                                  {{$project->city}}
                               </td>
                               <td>
                                  <h2 class="table-avatar">
                                     <a href="{{route('admin.contact.details',$contact->id)}}" class="avatar">
                                       @if($project->user && $project->user->image)
                                       <img src="{{asset('assets/img/employee/'.$project->user->image)}}" alt="User Image">
                                       @else
                                       <img src="{{asset('assets/img/avatar/images-dummy.jpg')}}" alt="User Image">
                                       @endif
                                    </a>
                                     <a href="#">{{ $project->user?($project->user->first_name.' '.$project->user->last_name):''}}</span></a>
                                  </h2>
                               </td>
                               <td class="text-end">
                                  <div class="dropdown dropdown-action">
                                     <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                     <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="javascript:void(0)" data-data="{{json_encode($project->toArray())}}" data-href="{{route('admin.project.update',$project->id)}}" onclick="edit_project($(this))"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                        <a class="dropdown-item" href="javascript:void(0)" data-href="{{route('admin.project.delete',$project->id)}}" onclick="delete_project($(this))"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                                     </div>
                                  </div>
                               </td>
                            </tr>
                            @endforeach
                         </tbody>
                      </table>
                   </div>
                </div>
                <div class="card-footer">
                   <a href="{{route('admin.project.list')}}">View all projects</a>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>

@endsection
@section('modal')
         
      <div class="modal custom-modal fade custom-modal-two modal-padding" id="edit_contact" role="dialog">
         <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
               <div class="modal-header header-border justify-content-between p-0">
                  <h5 class="modal-title">Edit Contact</h5>
                  <button type="button" class="btn-close position-static" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                  </button>
               </div>
               <div class="modal-body p-0">
                  <div class="add-details-wizard">
                     <ul id="progressbar2" class="progress-bar-wizard">
                        <li class="f-li active" id="f-li">
                           <span><i class="la la-user-tie"></i></span>
                           <div class="multi-step-info">
                              <h6>Basic Info</h6>
                           </div>
                        </li>
                        <li class="f-li">
                           <span><i class="la la-map-marker"></i></span>
                           <div class="multi-step-info">
                              <h6>Address</h6>
                           </div>
                        </li>
                        <li class="f-li">
                           <div class="multi-step-icon">
                              <span><i class="la la-icons"></i></span>
                           </div>
                           <div class="multi-step-info">
                              <h6>Social Profiles</h6>
                           </div>
                        </li>
                        <li class="f-li">
                           <div class="multi-step-icon">
                              <span><i class="la la-images"></i></span>
                           </div>
                           <div class="multi-step-info">
                              <h6>Access</h6>
                           </div>
                        </li>
                     </ul>
                  </div>
                  <div class="add-info-fieldset" >
                     <fieldset id="edit-first-field" class="feild-set">
                        <form action="{{route('admin.contact.update')}}" method="post" enctype="multipart/form-data">
                           @csrf
                           <input type="hidden" name="contact_id" id="contact_id">
                           <div class="form-upload-profile">
                              <h6 class>Profile Image <span> *</span></h6>
                              <div class="profile-pic-upload">
                                 <div class="profile-pic">
                                    <span><img src="{{asset('assets/img/icons/profile-upload-img.svg')}}" alt="Img" id="profilePreview"></span>
                                 </div>
                                 <div class="employee-field">
                                    <div class="mb-0">
                                       <div class="image-upload mb-0">
                                          <input type="file" name="profile_image" onchange="readURL(this,'#profilePreview')">
                                          <div class="image-uploads">
                                             <h4 class="text-nowrap">Choose</h4>
                                          </div>
                                       </div>
                                    </div>
                                    
                                 </div>
                              </div>
                           </div>
                           <div class="contact-input-set">
                              <div class="row">
                                 <div class="col-lg-4 col-md-6">
                                    <div class="input-block mb-3">
                                       <label class="col-form-label">First Name <span class="text-danger"> *</span></label>
                                       <input class="form-control" type="text" name="first_name" id="first_name" required>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-6">
                                    <div class="input-block mb-3">
                                       <label class="col-form-label">Last Name <span class="text-danger"> </span></label>
                                       <input class="form-control" type="text" name="last_name" id="last_name">
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-6">
                                    <div class="input-block mb-3">
                                       <label class="col-form-label">Job Title <span class="text-danger"> </span></label>
                                       <input class="form-control" type="text" name="job_title" id="job_title">
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-6">
                                    <div class="input-block mb-3">
                                       <label class="col-form-label">Company Name <span class="text-danger"></span></label>
                                       <input class="form-control" type="text" name="Company_name" id="Company_name">
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-6">
                                    <div class="input-block mb-3">
                                       <div class="d-flex justify-content-between align-items-center">
                                          <label class="col-form-label">Email <span class="text-danger"> *</span></label>
                                    
                                       </div>
                                       <input class="form-control" type="email" name="email" id="email" required>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-6">
                                    <div class="input-block mb-3">
                                       <label class="col-form-label">Phone Number <span class="text-danger"> *</span></label>
                                       <input class="form-control" type="text" name="phone" id="phone" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" pattern="[0-9]{10}" required>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-6">
                                    <div class="input-block mb-3">
                                       <label class="col-form-label">Alt Phone Number <span class="text-danger"> </span></label>
                                       <input class="form-control" type="text" name="alt_phone" id="alt_phone" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" pattern="[0-9]{10}">
                                    </div>
                                 </div>
                                
                                 <div class="col-lg-4 col-md-6">
                                    <div class="input-block mb-3">
                                       <label class="col-form-label">Reviews <span class="text-danger"></span></label>
                                       <select class="select" name="reviews" id="reviews">
                                          <option value="">Select</option>
                                          <option>Lowest</option>
                                          <option>Highest</option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-6">
                                    <div class="input-block mb-3">
                                       <label class="col-form-label">Owner <span class="text-danger"></span></label>
                                       <select class="select" name="user_id" id="user_id">
                                          <option value="">Select</option>
                                          
                                          <option value="1">user 1</option>
                                          
                                       </select>
                                    </div>
                                 </div>
                                 <div class="col-lg-12">
                                    <div class="input-block mb-3">
                                       <label class="col-form-label">Comments<span class="text-danger">*</span></label>
                                       <textarea class="form-control" rows="5" name="comment" id="comment" required></textarea>
                                    </div>
                                 </div>
                                 <div class="col-lg-12 text-end form-wizard-button">
                                    <button class="button btn-lights reset-btn reset-f-btn" onclick="reset_f()" type="button">Reset</button>
                                    <button class="btn btn-primary wizard-next-btn" type="button">Save & Next</button>
                                 </div>
                              </div>
                           </div>

                     </fieldset>
                     <fieldset class="feild-set">
                        
                           <div class="contact-input-set">
                              <div class="row">
                                 <div class="col-lg-12">
                                    <div class="input-block mb-3">
                                       <label class="col-form-label">Street Address<span class="text-danger"> *</span></label>
                                       <input class="form-control" type="text" name="address[street_address]" id="street_address" value="38 Simpson Stree">
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="input-block mb-3">
                                       <label class="col-form-label">City <span class="text-danger"> *</span></label>
                                       <input class="form-control" type="text" name="address[city]" id="city" value="Rock Island">
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="input-block mb-3">
                                       <label class="col-form-label">State / Province <span class="text-danger"> *</span></label>
                                       <input class="form-control" type="text" name="address[state]" id="state" value="USA">
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="input-block mb-3">
                                       <label class="col-form-label">Country <span class="text-danger">*</span></label>
                                       <select class="select" name="address[country]" id="country">
                                          <option>Germany</option>
                                          <option>USA</option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="input-block mb-3">
                                       <label class="col-form-label">Zipcode <span class="text-danger"> *</span></label>
                                       <input class="form-control" type="text" name="address[zipcode]" value="65" id="zipcode">
                                    </div>
                                 </div>
                                 <div class="col-lg-12 text-end form-wizard-button">
                                    <button class="button btn-lights reset-btn reset-f-btn" onclick="reset_f()" type="button">Reset</button>
                                    <button class="btn btn-primary wizard-next-btn" type="button">Save & Next</button>
                                 </div>
                              </div>
                           </div>
                 
                     </fieldset>
                     <fieldset class="feild-set">
                       
                           <div class="contact-input-set">
                              <div class="row">
                                 <div class="col-lg-12">
                                    <div class="input-block mb-3">
                                       <label class="col-form-label">Facebook</label>
                                       <input class="form-control" type="text" name="social[facebook]" id="facebook" value="Darlee Robertson">
                                    </div>
                                 </div>
                                 <div class="col-lg-12">
                                    <div class="input-block mb-3">
                                       <label class="col-form-label">Twitter</label>
                                       <input class="form-control" type="text" name="social[twitter]" id="twitter" value="Darlee Robertson">
                                    </div>
                                 </div>
                                 <div class="col-lg-12">
                                    <div class="input-block mb-3">
                                       <label class="col-form-label">Linkedin</label>
                                       <input class="form-control" type="text" name="social[linkedin]" id="linkedin" value="Darlee Robertson">
                                    </div>
                                 </div>
                                 <div class="col-lg-12">
                                    <div class="input-block mb-3">
                                       <label class="col-form-label">Skype</label>
                                       <input class="form-control" type="text" name="social[skype]" id="skype" value="Darlee Robertson">
                                    </div>
                                 </div>
                                 <div class="col-lg-12">
                                    <div class="input-block mb-3">
                                       <label class="col-form-label">Whatsapp</label>
                                       <input class="form-control" type="text" name="social[whatsapp]" id="whatsapp" value="Darlee Robertson">
                                    </div>
                                 </div>
                                 <div class="col-lg-12">
                                    <div class="input-block mb-3">
                                       <label class="col-form-label">Instagram</label>
                                       <input class="form-control" type="text" name="social[instagram]" id="instagram" value="Darlee_Robertson">
                                    </div>
                                 </div>
                                 
                                 <div class="col-lg-12 text-end form-wizard-button">
                                    <button class="button btn-lights reset-btn reset-f-btn" onclick="reset_f()" type="button">Reset</button>
                                    <button class="btn btn-primary wizard-next-btn" type="button">Save & Next</button>
                                 </div>
                              </div>
                           </div>
                        
                     </fieldset>
                     <fieldset class="feild-set">
                        
                           <div class="contact-input-set">
                              <div class="input-blocks add-products">
                                 <label class="mb-3">Visibility</label>
                                 <div class="access-info-tab">
                                    
                                 </div>
                              </div>
                              
                              <div class="status-radio-btns d-flex mb-3">
                                 <div class="col-md-12">
                                    <div class="input-block mb-3">
                                       <h5 class="mb-3">Status</h5>
                                       <div class="status-radio-btns d-flex">
                                          <div class="people-status-radio">
                                             <input type="radio" class="status-radio" id="tests6" name="contact_status" checked>
                                             <label for="tests6">Active</label>
                                          </div>
                                          <div class="people-status-radio">
                                             <input type="radio" class="status-radio" id="tests7" name="contact_status">
                                             <label for="tests7">Inactive</label>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-lg-12 text-end form-wizard-button">
                                 <button class="button btn-lights reset-btn reset-f-btn" onclick="reset_f()" type="button" >Reset</button>
                                 <button class="btn btn-primary" type="submit">Submit</button>
                              </div>
                           </div>
                        </form>
                     </fieldset>
                  </div>
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
                        <form action="{{route('admin.project.update')}}" method="post" enctype="multipart/form-data">
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

      <div class="modal custom-modal fade" id="delete_models" role="dialog">
         <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
               <div class="modal-body">
                  <div class="success-message text-center">
                     <div class="success-popup-icon bg-danger">
                        <i class="la la-trash-restore"></i>
                     </div>
                     <h3>Are you sure, You want to delete</h3>
                     <p>You won't be able to revert this!</p>
                     <div class="col-lg-12 text-center form-wizard-button">
                        <a href="#" class="button btn-lights" data-bs-dismiss="modal">Not Now</a>
                        <a href="" class="btn btn-primary" id="d-okay">Okay</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
@endsection
@section('scripts')
      <script src="{{asset('assets/js/jquery-3.7.1.min.js')}}" type="7391b6d38a339c17e417d73c-text/javascript"></script>
      <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}" type="7391b6d38a339c17e417d73c-text/javascript"></script>
      <script src="{{asset('assets/js/jquery.slimscroll.min.js')}}" type="7391b6d38a339c17e417d73c-text/javascript"></script>
      <script src="{{asset('assets/plugins/morris/morris.min.js')}}" type="7391b6d38a339c17e417d73c-text/javascript"></script>
      <script src="{{asset('assets/plugins/raphael/raphael.min.js')}}" type="7391b6d38a339c17e417d73c-text/javascript"></script>
      <!-- <script src="{{asset('assets/js/chart.js')}}" type="7391b6d38a339c17e417d73c-text/javascript"></script> -->
      <!-- <script src="{{asset('assets/js/greedynav.js')}}" type="7391b6d38a339c17e417d73c-text/javascript"></script> -->
      <script src="{{asset('assets/js/select2.min.js')}}" type="7391b6d38a339c17e417d73c-text/javascript"></script>
      <script src="{{asset('assets/js/layout.js')}}" type="7391b6d38a339c17e417d73c-text/javascript"></script>
      <!-- <script src="{{asset('assets/js/theme-settings.js')}}" type="7391b6d38a339c17e417d73c-text/javascript"></script> -->
      <script src="{{asset('assets/js/app.js')}}" type="7391b6d38a339c17e417d73c-text/javascript"></script>
      <script src="{{asset('assets/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js')}}" data-cf-settings="7391b6d38a339c17e417d73c-|49" defer></script>

      <script type="text/javascript">
            function edit_contact(el){
               var data = $.parseJSON(el.attr("data-data"));
               
               // return false;
               if(data.image){
                  $('#profilePreview').attr('src', '{{asset("assets/img/contact")}}/'+data.image);
               }else{
                  $('#profilePreview').attr('src', '{{asset("assets/img/icons/profile-upload-img.svg")}}');
               }
               
               $('#first_name').val(data.first_name);
               $('#last_name').val(data.last_name);
               $('#job_title').val(data.job_title);
               $('#Company_name').val(data.Company_name);
               $('#phone').val(data.phone);
               $('#alt_phone').val(data.alt_phone);
               $('#email').val(data.email);
               
               $('#contact_id').val(data.id);
               $('#reviews').val(data.reviews).change();
               if(data.id){
                  var user_name = el.attr("data-user_name");
                  var userop = '<option value="'+data.id+'" selected>'+user_name+'</option>';
                  $('#user_id').html(userop);
               }else{
                  var userop = '<option value="" selected>Select</option>';
                  $('#user_id').html(userop);
               }
               if(data.socials){
                  var socials = $.parseJSON(data.socials);
                  $('#facebook').val(socials.facebook);
                  $('#twitter').val(socials.twitter);
                  $('#linkedin').val(socials.linkedin);
                  $('#skype').val(socials.skype);
                  $('#whatsapp').val(socials.whatsapp);
                  $('#instagram').val(socials.instagram);
               }
               if(data.address){
                  var address = $.parseJSON(data.address);
                  $('#street_address').val(address.street_address);
                  $('#city').val(address.city);
                  $('#state').val(address.state);
                  $('#country').val(address.country);
                  $('#zipcode').val(address.zipcode);
               }
               
               $('#comment').val(data.comment);               
               $('#edit_contact').modal('show');
            }

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

            function delete_contact(el){
               $('#d-okay').attr("href", el.attr("data-href"));
               $('#delete_models').modal('show');
            }

            function delete_project(el){
               $('#d-okay').attr("href", el.attr("data-href"));
               $('#delete_models').modal('show');
            }
      </script>


      <script type="text/javascript">
         window.onload = function() {
            $(document).ready(function () {
                   Morris.Bar({
                       element: "bar-charts-lead",
                       redrawOnParentResize: true,
                       data: [
                           { y: "Pending", a: "{{$status['Pending']}}"},
                           { y: "SITE VISIT DONE", a: "{{$status['SITE_VISIT_DONE']}}"},
                           { y: "Warm", a: "{{$status['Warm']}}" },
                           { y: "F2F Planned", a: "{{$status['F2F_Planned']}}" },
                           { y: "Visited - Cold", a: "{{$status['Visited_Cold']}}" },
                           { y: "Visited - Hot", a: "{{$status['Visited_Hot']}}" },
                           { y: "Revisit Planned", a: "{{$status['Revisit_Planned']}}" },
                           { y: "Revisited", a: "{{$status['Revisited']}}" },
                           { y: "Token Received", a: "{{$status['Token_Received']}}" },
                           { y: "Sale Done", a: "{{$status['Sale_Done']}}" },
                           { y: "Never Picked", a: "{{$status['Never_Picked']}}" },
                           { y: "JUST  Arrived", a: "{{$status['JUST_Arrived']}}" },
                           { y: "lost", a: "{{$status['lost']}}" },
                           { y: "Deal Closed", a: "{{$status['Deal_Closed']}}" },
                       ],
                       xkey: "y",
                       ykeys: ["a"],
                       labels: ["Leads"],
                       lineColors: ["#ff9b44"],
                       lineWidth: "3px",
                       barColors: ["#ff9b44"],
                       resize: true,
                       redraw: true,
                   });
                   Morris.Bar({
                       element: "line-charts-lead",
                       redrawOnParentResize: true,
                       data: [
                           { y: "Pending", a: "{{$followup['Pending']}}" },
                           { y: "Call", a: "{{$followup['Call']}}" },
                           { y: "Boucher Sent", a: "{{$followup['Boucher_Sent']}}" },
                           { y: "Demo/Visit", a: "{{$followup['Demo_Visit']}}" },
                           { y: "2ndDemo/Revisit", a: "{{$followup['2ndDemo_Revisit']}}" },
                           { y: "Negotiation", a: "{{$followup['Negotiation']}}" },
                           { y: "Closing Meetings", a: "{{$followup['Closing_Meetings']}}" },
                           { y: "Fresh", a: "{{$followup['Fresh']}}" },
                           { y: "NOT INT", a: "{{$followup['NOT_INT']}}" },
                           { y: "Switch off", a: "{{$followup['Switch_off']}}" },
                       ],
                       xkey: "y",
                       ykeys: ["a"],
                       labels: ["Leads"],
                       lineColors: ["#ff9b44"],
                       lineWidth: "3px",
                       resize: true,
                       redraw: true,
                   });
               });
         }
      </script>
@endsection