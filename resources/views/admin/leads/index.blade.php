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
      <link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}">
      <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
@endpush
@section('content')
@php
$employees = get_employees();
@endphp
   <div class="page-wrapper">
      <div class="content container-fluid">
         <div class="page-header">
            <div class="row align-items-center">
               <div class="col-md-4">
                  <h3 class="page-title">Leads</h3>
                  <ul class="breadcrumb">
                     <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                     <li class="breadcrumb-item active">Leads</li>
                  </ul>
               </div>
               <div class="col-md-8 float-end ms-auto">
                  <div class="d-flex title-head">
                     <div class="view-icons">
                        <a href="{{route('admin.leads.list')}}" class="grid-view btn btn-link" ><i class="las la-redo-alt" ></i></a>
                        <a href="javascript:void(0);" class="list-view btn btn-link" id="collapse-header" ><i class="las la-expand-arrows-alt"></i></a>
                        <a href="javascript:void(0);" class="list-view btn btn-link" id="filter_search"><i class="las la-filter"></i></a>
                     </div>
                     <div class="form-sort">
                        <a href="javascript:void(0);" class="list-view btn btn-link" data-bs-toggle="modal" data-bs-target="#import" onclick="$('#progressbar').addClass('d-none');"><i class="las la-file-import"></i>Import</a>
                     </div>
                     <div class="form-sort">
                        <a href="javascript:void(0);" class="list-view btn btn-link" data-bs-toggle="modal" data-bs-target="#export"><i class="las la-file-export"></i>Export</a>
                     </div>
                     <a href="javascript:void(0);" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_leads"><i class="la la-plus-circle"></i> Add Leads</a>
                  </div>
               </div>
            </div>
         </div>
         <div class="filter-filelds" id="filter_inputs" @if($name||$email||$phone||$lead_status||$user_id) style="display: block;" @endif>
            <form id="filter_form" method="get">
            <div class="row filter-row">
               <div class="col-xl-2">
                  <div class="input-block mb-3 form-focus">
                     <input type="text" class="form-control floating" name="name" value="{{$name}}">
                     <label class="focus-label">Lead Name</label>
                  </div>
               </div>
               <div class="col-xl-1">
                  <div class="input-block mb-3 form-focus">
                     <input type="email" class="form-control floating" name="email" value="{{$email}}">
                     <label class="focus-label">Email</label>
                  </div>
               </div>
               <div class="col-xl-1">
                  <div class="input-block mb-3 form-focus">
                     <input type="text" class="form-control floating" name="phone" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" pattern="[0-9]{10}" value="{{$phone}}">
                     <label class="focus-label">Phone</label>
                  </div>
               </div>
               <div class="col-xl-2">
                  <div class="input-block mb-3 form-focus focused">
                     <input type="text" class="form-control  date-range bookingrange" name="date" value="{{$date}}" >
                     <label class="focus-label">From - To Date</label>
                  </div>
               </div>
               <div class="col-xl-2">
                  <div class="input-block mb-3 form-focus select-focus">
                     <select class="select floating" name="lead_status">
                        <option value="">--Select--</option>
                        <option {{$lead_status=='SITE VISIT DONE'?'selected':''}}>SITE VISIT DONE</option>
                        <option {{$lead_status=='Warm'?'selected':''}}>Warm</option>
                        <option {{$lead_status=='F2F Planned'?'selected':''}}>F2F Planned</option>
                        <option {{$lead_status=='Visited - Cold'?'selected':''}}>Visited - Cold</option>
                        <option {{$lead_status=='Visited - Hot'?'selected':''}}>Visited - Hot</option>
                        <option {{$lead_status=='Revisit Planned'?'selected':''}}>Revisit Planned</option>
                        <option {{$lead_status=='Revisited'?'selected':''}}>Revisited</option>
                        <option {{$lead_status=='Token Received'?'selected':''}}>Token Received</option>
                        <option {{$lead_status=='Sale Done'?'selected':''}}>Sale Done</option>
                        <option {{$lead_status=='Never Picked'?'selected':''}}>Never Picked</option>
                        <option {{$lead_status=='JUST  Arrived'?'selected':''}}>JUST  Arrived</option>
                        <option {{$lead_status=='lost'?'selected':''}}>lost</option>
                        <option {{$lead_status=='Deal Closed'?'selected':''}}>Deal Closed</option>
                     </select>
                     <label class="focus-label">Lead Status</label>
                  </div>
               </div>
               <div class="col-xl-2">
                  <div class="input-block mb-3 form-focus select-focus">
                     <select class="select floating" name="user_id">
                        <option value="">--Select--</option>
                        @foreach(get_employees() as $employee)
                           <option value="{{$employee->id}}"{{$employee->id==$user_id?'selected':''}}>{{$employee->first_name.' '.$employee->last_name}}</option>
                        @endforeach
                     </select>
                     <label class="focus-label">Lead Owner</label>
                  </div>
               </div>
               <div class="col-xl-2">
                  <button type="submit" class="btn btn-success w-100" onclick="$('#filter_form').submit();"> Search </button>
               </div>
            </div>
            </form>
         </div>
         <hr>
       
         <div class="row">
            <div class="col-md-12">
               <div class="table-responsive">
                  <table class="table table-striped custom-table datatable contact-table">
                     <thead>
                        <tr>
                           <th class="no-sort"></th>
                           <th>Lead Name</th>
                           <th>Phone</th>
                           <th>Email</th>
                           <th>Lead Status</th>
                           <th>Created Date</th>
                           <th>Lead Owner</th>
                           <th class="no-sort text-end">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($leads as $lead)
                        <tr>
                           <td>
                              <div class="set-star star-select">
                                 <i class="fa fa-star filled"></i>
                              </div>
                           </td>
                           <td>
                              <h2>
                                 <a href="{{route('admin.leads.details',$lead->id)}}" class="profile-split">{{$lead->name}}</a>
                              </h2>
                           </td>
                           
                           <td>{{$lead->phone}}</td>
                           <td>{{$lead->email}}</td>
                           <td><span class="badge badge-soft-{{$lead->lead_status?'success':'warning'}}">{{$lead->lead_status?$lead->lead_status:'Pending'}}</span></td>
                           <td>{{date('D m Y, h:i a',strtotime($lead->created_at))}}</td>
                           <td>{{$lead->user?($lead->user->first_name.' '.$lead->user->last_name):''}}</td>
                           <td class="text-end">
                              <div class="dropdown dropdown-action">
                                 <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                 <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" onclick="edit($(this))" data-data="{{json_encode($lead->toArray())}}"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                    <a class="dropdown-item" data-href="{{route('admin.leads.delete',$lead->id)}}" onclick="delete_lead($(this))"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                                    <a class="dropdown-item" href="{{route('admin.leads.details',$lead->id)}}"><i class="fa-regular fa-eye"></i> Preview</a>
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
      <div class="modal custom-modal fade custom-modal-two modal-padding" id="add_leads" role="dialog">
         <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
               <div class="modal-header header-border justify-content-between p-0">
                  <h5 class="modal-title">Add New Lead</h5>
                  <button type="button" class="btn-close position-static" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                  </button>
               </div>
               <div class="modal-body p-0">
			   <form action="{{route('admin.leads.store')}}" method="post" id="leadForm">
                     @csrf
                     <div class="contact-input-set">
                        <div class="row">
                           <div class="col-md-12">
                              <div class="input-block mb-3">
                                 <label class="col-form-label">Lead Name <span class="text-danger">*</span></label>
                                 <input class="form-control" type="text" name="name" required>
								 <small class="error-message text-danger"></small>
                              </div>
                           </div>
                          
                           <div class="col-md-12 lead-phno-col del-phno-col">
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="input-block tag-with-img mb-3">
                                       <label class="col-form-label">Owner <span class="text-danger"></span></label>
                                       <select class="select" name="user_id">
                                          <option value="">Select</option>
                                          @foreach( $employees as $key=>$employee )
                                          <option value="{{$employee->id}}">{{$employee->first_name.' '.$employee->last_name}}</option>
                                          @endforeach
                                       </select>
                                    </div>
                                 </div>
                                 <div class="col-lg-6">
                                    <div class="input-block mb-3">
                                       <label class="col-form-label">Phone Number <span class="text-danger">*</span></label>
                                       <input class="form-control" type="text" name="phone" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" pattern="[0-9]{10}" required>
									   <small class="error-message text-danger"></small>
                                    </div>
                                 </div>
                                 <div class="col-lg-6">
                                    <div class="input-block mb-3">
                                       <label class="col-form-label">Alt Number <span class="text-danger"></span></label>
                                       <input class="form-control" type="text" name="alt_phone" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" pattern="[0-9]{10}">
                                    </div>
                                 </div>
                                 <div class="col-lg-6">
                                    <div class="input-block mb-3">
                                       <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                       <input class="form-control" type="email" name="email" required>
									   <small class="error-message text-danger"></small>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-12 lead-email-col del-email-col">
                              <div class="row">
                                 <div class="col-lg-6">
                                    <div class="input-block mb-3">
                                       <label class="col-form-label">City <span class="text-danger">*</span></label>
                                       <input class="form-control" type="text" name="city" required >
									   <small class="error-message text-danger"></small>	

                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="input-block mb-3">
                                       <label class="col-form-label">Source <span class="text-danger">*</span></label>
                                       <select class="select" name="source" required>
                                          <option value="">Select</option>
                                          <option value="Website">Website</option>
                                          <option value="Meta Ads">Meta Ads</option>
                                          <option value="Google Ads">Google Ads</option>
                                          <option value="Other">Other</option>
                                       </select>
									   <small class="error-message text-danger"></small>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           
                           <div class="col-md-6">
                              <div class="input-block mb-3">
                                 <label class="col-form-label">Followup Type <span class="text-danger"></span></label>
                                 <select class="select" name="followup_type">
                                    <option value="">Select</option>
                                    <option>Call</option>
                                    <option>Boucher Sent</option>
                                    <option>Demo/Visit</option>
                                    <option>2ndDemo/Revisit</option>
                                    <option>Negotiation</option>
                                    <option>Negotiation</option>
                                    <option>Closing Meetings</option>
                                    <option>Fresh</option>
                                    <option>NOT INT</option>
                                    <option>Switch off</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="input-block mb-3">
                                 <label class="col-form-label">Lead Type <span class="text-danger"></span></label>
                                 <select class="select" name="lead_type">
                                    <option value="">Select</option>
                                    <option>Buyer</option>
                                    <option>Seller</option>
                                    <option>CP / Dealer</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="input-block mb-3">
                                 <label class="col-form-label">Channel Partner <span class="text-danger"></span></label>
                                 <select class="select" name="channel_partner">
                                    <option value="">Select</option>
                                    <option value="5">cp 1</option>
                                    <option value="5">cp 2</option>
                                    <option value="5">cp 3</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="input-block mb-3">
                                 <label class="col-form-label">Lead Status <span class="text-danger"></span></label>
                                 <select class="select" name="lead_status">
                                    <option value="">Select</option>
                                    <option>SITE VISIT DONE</option>
                                    <option>Warm</option>
                                    <option>F2F Planned</option>
                                    <option>Visited - Cold</option>
                                    <option>Visited - Hot</option>
                                    <option>Revisit Planned</option>
                                    <option>Revisited</option>
                                    <option>Token Received</option>
                                    <option>Sale Done</option>
                                    <option>Never Picked</option>
                                    <option>JUST  Arrived</option>
                                    <option>lost</option>
                                    <option>Deal Closed</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="input-block mb-3">
                                 <label class="col-form-label">Budget <span class="text-danger"></span></label>
                                 <select class="select" name="budget">
                                    <option value="">Select</option>
                                    <option>0-50k</option>
                                    <option>50k-1lac</option>
                                    <option>1lac-20lac</option>
                                    <option>20lac-60lac</option>
                                    <option>60lac-1cr</option>
                                    <option>1cr-2cr</option>
                                    <option>2cr-5cr</option>
                                    <option>more then 5cr</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="input-block mb-3">
                                 <label class="col-form-label">Occupation <span class="text-danger"></span></label>
                                 <select class="select" name="occupation">
                                    <option value="">Select</option>
                                    <option>Salaried</option>
                                    <option>Business</option>
                                    <option>Professional</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="input-block mb-3">
                                 <label class="col-form-label">Purpose <span class="text-danger"></span></label>
                                 <select class="select" name="purpose">
                                    <option value=" ">Select</option>
                                    <option>Investment</option>
                                    <option>For Self</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class="input-block mb-3">
                                 <label class="col-form-label">Location <span class="text-danger">*</span></label>
                                 <input class="form-control" type="text" name="location" required>
								 <small class="error-message text-danger"></small>
                              </div>
                           </div>
                           
                           <div class="col-lg-12">
                              <div class="input-block mb-3">
                                 <label class="col-form-label">Description <span class="text-danger"></span></label>
                                 <textarea class="form-control" rows="5" name="note"></textarea>
                              </div>
                           </div>
                           <hr>
                           <h5>Next Action</h5>
                           <hr>
                           <div class="col-lg-6">
                              <div class="input-block mb-3">
                                 <label class="col-form-label">Next Action Date <span class="text-danger"></span></label>
                                 <input class="form-control" type="date" name="next_action_date">
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="input-block mb-3">
                                 <label class="col-form-label">Next Follow up <span class="text-danger"></span></label>
                                 <select class="select" name="next_followup">
                                    <option value="">Select</option>
                                    <option>Call</option>
                                    <option>Boucher Sent</option>
                                    <option>Demo/Visit</option>
                                    <option>2ndDemo/Revisit</option>
                                    <option>Negotiation</option>
                                    <option>Negotiation</option>
                                    <option>Closing Meetings</option>
                                    <option>Fresh</option>
                                    <option>NOT INT</option>
                                    <option>Switch off</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-lg-12 text-end form-wizard-button">
                              <button class="button btn-lights reset-btn" type="reset" data-bs-dismiss="modal">Reset</button>
                              <button class="btn btn-primary" type="submit" id="submitButton">Save Lead</button>
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      
      <div class="modal custom-modal fade" id="delete_leads" role="dialog">
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
      <div class="modal custom-modal fade modal-padding" id="export" role="dialog">
         <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
               <div class="modal-header header-border justify-content-between p-0">
                  <h5 class="modal-title">Export</h5>
                  <button type="button" class="btn-close position-static" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                  </button>
               </div>
               <div class="modal-body p-0">
                  <form action="{{route('admin.leads.export')}}" method="get">
                     <div class="row">
                        
                        <div class="col-md-6">
                           <div class="input-block mb-3">
                              <label class="col-form-label">From Date <span class="text-danger">*</span></label>
                              <div class="cal-icon">
                                 <input class="form-control floating datetimepicker" type="text" name="from" required>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="input-block mb-3">
                              <label class="col-form-label">To Date <span class="text-danger">*</span></label>
                              <div class="cal-icon">
                                 <input class="form-control floating datetimepicker" type="text" name="to" required>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-12 text-end form-wizard-button">
                           <button class="button btn-lights reset-btn" type="reset" data-bs-dismiss="modal">Reset</button>
                           <button class="btn btn-primary" type="submit">Export Now</button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>

      <div class="modal custom-modal fade modal-padding" id="import" role="dialog">
         <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
               <div class="modal-header header-border justify-content-between p-0">
                  <h5 class="modal-title">Import</h5>
                  <button type="button" class="btn-close position-static" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                  </button>
               </div>
               <div class="modal-body p-0">
                  <form action="{{route('admin.leads.import')}}" method="post" enctype="multipart/form-data">
                     @csrf
                     <div class="row">
                        
                        <div class="input-block mb-3">
                           <label class="col-form-label">Upload File <span class="text-danger"> </span></label>
                           <div class="drag-upload">
                              <input type="file" name="file" required>
                              <div class="img-upload">
                                 <i class="las la-file-import"></i>
                                 <p>Drag & Drop your file</p>
                              </div>
                           </div>
                        </div>
                        <div class="input-block mb-3" id="progressbar">
                           <div class="progress">
                              <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                           </div>
                        </div>
                        <div class="col-lg-12 text-end form-wizard-button">
                           <a class="button btn-lights reset-btn" href="{{asset('assets/download/leads-default.xlsx')}}" download>Download Sample</a>
                           <button class="btn btn-primary" type="submit" onclick="$('#progressbar').removeClass('d-none');">Import Now</button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      
      <div class="modal custom-modal fade custom-modal-two modal-padding" id="edit_leads" role="dialog">
         <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
               <div class="modal-header header-border justify-content-between p-0">
                  <h5 class="modal-title">Edit Lead</h5>
                  <button type="button" class="btn-close position-static" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                  </button>
               </div>
               <div class="modal-body p-0">
                  <form action="{{route('admin.leads.update')}}" method="post">
                     @csrf
                     <div class="contact-input-set">
                        <div class="row">
                           <div class="col-md-12">
                              <div class="input-block mb-3">
                                 <label class="col-form-label">Lead Name <span class="text-danger">*</span></label>
                                 <input class="form-control" type="text" name="name" id="name" required>
                                 <input class="form-control" type="hidden" name="id" id="lead_id">
                              </div>
                           </div>
                          
                           <div class="col-md-12 lead-phno-col del-phno-col">
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="input-block tag-with-img mb-3">
                                       <label class="col-form-label">Owner <span class="text-danger"></span></label>
                                       <select class="select" name="user_id" id="user_id">
                                          <option value="">Select</option>
                                          @foreach( $employees as $key=>$employee )
                                          <option value="{{$employee->id}}">{{$employee->first_name.' '.$employee->last_name}}</option>
                                          @endforeach
                                       </select>
                                    </div>
                                 </div>
                                 <div class="col-lg-6">
                                    <div class="input-block mb-3">
                                       <label class="col-form-label">Phone Number <span class="text-danger">*</span></label>
                                       <input class="form-control" type="text" name="phone" id="phone" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" pattern="[0-9]{10}" required>
                                    </div>
                                 </div>
                                 <div class="col-lg-6">
                                    <div class="input-block mb-3">
                                       <label class="col-form-label">Alt Number <span class="text-danger"></span></label>
                                       <input class="form-control" type="text" name="alt_phone" id="alt_phone" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" pattern="[0-9]{10}">
                                    </div>
                                 </div>
                                 <div class="col-lg-6">
                                    <div class="input-block mb-3">
                                       <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                       <input class="form-control" type="email" name="email" id="email" required>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-12 lead-email-col del-email-col">
                              <div class="row">
                                 <div class="col-lg-6">
                                    <div class="input-block mb-3">
                                       <label class="col-form-label">City <span class="text-danger">*</span></label>
                                       <input class="form-control" type="text" name="city" id="city" required>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="input-block mb-3">
                                       <label class="col-form-label">Source <span class="text-danger">*</span></label>
                                       <select class="select" name="source" id="source" required>
                                          <option value="">Select</option>
                                          <option value="Website">Website</option>
                                          <option value="Meta Ads">Meta Ads</option>
                                          <option value="Google Ads">Google Ads</option>
                                          <option value="Other">Other</option>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           
                           <div class="col-md-6">
                              <div class="input-block mb-3">
                                 <label class="col-form-label">Followup Type <span class="text-danger"></span></label>
                                 <select class="select" name="followup_type" id="followup_type">
                                    <option value="">Select</option>
                                    <option>Call</option>
                                    <option>Boucher Sent</option>
                                    <option>Demo/Visit</option>
                                    <option>2ndDemo/Revisit</option>
                                    <option>Negotiation</option>
                                    <option>Negotiation</option>
                                    <option>Closing Meetings</option>
                                    <option>Fresh</option>
                                    <option>NOT INT</option>
                                    <option>Switch off</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="input-block mb-3">
                                 <label class="col-form-label">Lead Type <span class="text-danger"></span></label>
                                 <select class="select" name="lead_type" id="lead_type">
                                    <option value="">Select</option>
                                    <option>Buyer</option>
                                    <option>Seller</option>
                                    <option>CP / Dealer</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="input-block mb-3">
                                 <label class="col-form-label">Channel Partner <span class="text-danger"></span></label>
                                 <select class="select" name="channel_partner" id="channel_partner">
                                    <option value="">Select</option>
                                    <option value="5">cp 1</option>
                                    <option value="5">cp 2</option>
                                    <option value="5">cp 3</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="input-block mb-3">
                                 <label class="col-form-label">Lead Status <span class="text-danger"></span></label>
                                 <select class="select" name="lead_status" id="lead_status">
                                    <option value="">Select</option>
                                    <option>SITE VISIT DONE</option>
                                    <option>Warm</option>
                                    <option>F2F Planned</option>
                                    <option>Visited - Cold</option>
                                    <option>Visited - Hot</option>
                                    <option>Revisit Planned</option>
                                    <option>Revisited</option>
                                    <option>Token Received</option>
                                    <option>Sale Done</option>
                                    <option>Never Picked</option>
                                    <option>JUST  Arrived</option>
                                    <option>lost</option>
                                    <option>Deal Closed</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="input-block mb-3">
                                 <label class="col-form-label">Budget <span class="text-danger"></span></label>
                                 <select class="select" name="budget" id="budget">
                                    <option value="">Select</option>
                                    <option>0-50k</option>
                                    <option>50k-1lac</option>
                                    <option>1lac-20lac</option>
                                    <option>20lac-60lac</option>
                                    <option>60lac-1cr</option>
                                    <option>1cr-2cr</option>
                                    <option>2cr-5cr</option>
                                    <option>more then 5cr</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="input-block mb-3">
                                 <label class="col-form-label">Occupation <span class="text-danger"></span></label>
                                 <select class="select" name="occupation" id="occupation">
                                    <option value="">Select</option>
                                    <option>Salaried</option>
                                    <option>Business</option>
                                    <option>Professional</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="input-block mb-3">
                                 <label class="col-form-label">Purpose <span class="text-danger"></span></label>
                                 <select class="select" name="purpose" id="purpose">
                                    <option value="">Select</option>
                                    <option>Investment</option>
                                    <option>For Self</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class="input-block mb-3">
                                 <label class="col-form-label">Location <span class="text-danger">*</span></label>
                                 <input class="form-control" type="text" name="location" id="location" required>
                              </div>
                           </div>
                           
                           <div class="col-lg-12">
                              <div class="input-block mb-3">
                                 <label class="col-form-label">Description <span class="text-danger"></span></label>
                                 <textarea class="form-control" rows="5" name="note" id="note"></textarea>
                              </div>
                           </div>
                           <hr>
                           <h5>Next Action</h5>
                           <hr>
                           <div class="col-lg-6">
                              <div class="input-block mb-3">
                                 <label class="col-form-label">Next Action Date <span class="text-danger"></span></label>
                                 <input class="form-control" type="date" name="next_action_date" id="next_action_date">
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="input-block mb-3">
                                 <label class="col-form-label">Next Follow up <span class="text-danger"></span></label>
                                 <select class="select" name="next_followup" id="next_followup">
                                    <option value="">Select</option>
                                    <option>Call</option>
                                    <option>Boucher Sent</option>
                                    <option>Demo/Visit</option>
                                    <option>2ndDemo/Revisit</option>
                                    <option>Negotiation</option>
                                    <option>Negotiation</option>
                                    <option>Closing Meetings</option>
                                    <option>Fresh</option>
                                    <option>NOT INT</option>
                                    <option>Switch off</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-lg-12 text-end form-wizard-button">
                              <button class="button btn-lights reset-btn" type="reset" data-bs-dismiss="modal">Reset</button>
                              <button class="btn btn-primary" type="submit">Save Lead</button>
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
     <script data-cfasync="false" src="{{asset('assets/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js')}}"></script>
     <script src="{{asset('assets/js/jquery-3.7.1.min.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
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
      <script src="{{asset('assets/js/layout.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
      <!-- <script src="{{asset('assets/js/theme-settings.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script> -->
      <!-- <script src="{{asset('assets/js/greedynav.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script> -->
      <script src="{{asset('assets/js/app.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
      <script src="{{asset('assets/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js')}}" data-cf-settings="264280a78fcfef3abf43a170-|49" defer></script>

      <script type="text/javascript"> 

         function edit(el){
               var data = $.parseJSON(el.attr("data-data"));
               if(data.next_action_date){
                  var date = data.next_action_date.split(' ');
                  var newDate = date[0];
               }
               else{
                  var newDate = null;
               }
               console.log(data.next_action_date);
               console.log(newDate);
               // return false;
               $('#name').val(data.name);
               $('#user_id').val(data.user_id).change();
               $('#phone').val(data.phone);
               $('#alt_phone').val(data.alt_phone);
               $('#email').val(data.email);
               $('#city').val(data.city);
               $('#lead_id').val(data.id);
               $('#source').val(data.source).change();
               $('#followup_type').val(data.followup_type).change();
               $('#lead_type').val(data.lead_type).change();
               $('#channel_partner').val(data.channel_partner).change();
               $('#lead_status').val(data.lead_status).change();
               $('#budget').val(data.budget).change();
               $('#occupation').val(data.occupation).change();
               $('#purpose').val(data.purpose).change();
               $('#location').val(data.location);
               $('#note').val(data.note);
               $('#next_action_date').val(newDate);
               $('#next_followup').val(data.next_followup).change();
               
               $('#edit_leads').modal('show');
            }

            function delete_lead(el){
               $('#d-okay').attr("href", el.attr("data-href"));
               $('#delete_leads').modal('show');
            }

      </script>
	  <script>
	document.addEventListener("DOMContentLoaded", function () {
		function validateForm() {
			const form = document.getElementById('leadForm');
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
					const errorMessage1 = document.getElementById(`error-message_${index + 1}`);
					const html_ele = `error-message_${counter}`;
					$('#' + html_ele).html(`${field.previousElementSibling.textContent} is required.`);
					counter++;
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

			return isValid;
		}


		// Attach click event to the submit button
		const submitButton = document.getElementById('submitButton');
		if (submitButton) {
			submitButton.addEventListener('click', function (event) {

				event.preventDefault(); // Prevent form from submitting
				if (validateForm()) {
					document.getElementById('leadForm').submit(); // Submit form if valid
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
	 
	 
</script>

@endsection