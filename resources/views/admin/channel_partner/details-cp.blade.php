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
      <link rel="stylesheet" href="{{asset('assets/css/feather.css')}}">
      <link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
      <link rel="stylesheet" href="{{asset('assets/css/line-awesome.min.css')}}">
      <link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.min.css')}}">
      <link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}">
      <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
      <style type="text/css">
         
         
         .pipeline-list ul li a.bg-Call,
         .pipeline-list ul li a.bg-Call::after,
         .status-1 {
             background: #f5468e;
         }
         .pipeline-list ul li a.bg-Pending,
         .pipeline-list ul li a.bg-Pending::after {
             background: #FFEB3B;
         }
         .pipeline-list ul li a.bg-Boucher-Sent,
         .pipeline-list ul li a.bg-Boucher-Sent::after,
         .status-2 {
             background: #03A9F4;
             color: #fff;
         }
         .pipeline-list ul li a.bg-Demo-Visit,
         .pipeline-list ul li a.bg-Demo-Visit::after,
         .status-3 {
             background: #00BCD4;
             color: #fff;
         }
         .pipeline-list ul li a.bg-2ndDemo-Revisit,
         .pipeline-list ul li a.bg-2ndDemo-Revisit::after,
         .status-4 {
             background: #9C27B0;
             color: #fff;
         }
         .pipeline-list ul li a.bg-Negotiation,
         .pipeline-list ul li a.bg-Negotiation::after,
         .status-5 {
             background: #FF9800;
         }
         .pipeline-list ul li a.bg-Closing-Meetings,
         .pipeline-list ul li a.bg-Closing-Meetings::after,
         .status-6 {
             background: #009688;
             color: #fff;
         }
         .pipeline-list ul li a.bg-Fresh,
         .pipeline-list ul li a.bg-Fresh::after,
         .status-7 {
             background: #4CAF50;
             color: #fff;
         }
         .pipeline-list ul li a.bg-NOT-INT,
         .pipeline-list ul li a.bg-NOT-INT::after,
         .status-8 {
             background: #F44336;
             color: #fff;
         }
         .pipeline-list ul li a.bg-Switch-off,
         .pipeline-list ul li a.bg-Switch-off::after,
         .status-9 {
             background: #9E9E9E;
             color: #fff;
         }

      </style>
@endpush
@section('content')

<div class="page-wrapper">
            <div class="content container-fluid">
               <div class="page-header">
                  <div class="row align-items-center">
                     <div class="col-md-4">
                        <h3 class="page-title">Channel Partner</h3>
                        <ul class="breadcrumb">
                           <li class="breadcrumb-item"><a href="{{route('employee.dashboard')}}">Dashboard</a></li>
                           <li class="breadcrumb-item active">Channel Partner</li>
                        </ul>
                     </div>
                     <div class="col-md-8 float-end ms-auto">
                        <div class="d-flex title-head">
                           <div class="view-icons">
                              <a href="#" class="grid-view btn btn-link"><i class="las la-redo-alt"></i></a>
                              <a href="javascript:void(0);" class="list-view btn btn-link" id="collapse-header"><i class="las la-expand-arrows-alt"></i></a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-12">
                     <div class="contact-head">
                        <div class="row align-items-center">
                           <div class="col-sm-6">
                              <ul class="contact-breadcrumb">
                                 <li><a href="leads.html"><i class="las la-arrow-left"></i> Channel Partner</a></li>
                                 <li>{{$cpartner->name}}</li>
                              </ul>
                           </div>
                           <div class="col-sm-6 text-sm-end">
                              @if(admin_has_permission('CP') && admin_has_permission('Read-CP'))
                              <div class="contact-pagination">
                                 <p>{{$cpartner->row+1 .' of '. $total}}</p>
                                 <ul>
                                    <li>
                                       @if($previous)
                                       <a href="{{route('admin.channel-partner.details',$previous)}}"><i class="fas fa-angle-left"></i></a>
                                       @endif
                                   </li>
                                   <li>
                                       @if($next)
                                       <a href="{{route('admin.channel-partner.details',$next)}}"><i class="fas fa-angle-right"></i></a>
                                       @endif
                                   </li>
                                 </ul>
                              </div>
                              @endif
                           </div>
                        </div>
                     </div>
                     <div class="contact-wrap">
                        <div class="contact-profile">
                           <div class="avatar company-avatar">
                              <span class="text-icon">HT</span>
                           </div>
                           <div class="name-user">
                              <!-- <h4>{{$cpartner->name}} @if($cpartner->add_to_favourite==1)<span class="star-icon"><i class="fa-solid fa-star"></i></span>@endif</h4> -->
                              <p><i class="las la-building"></i> {{$cpartner->cp_name}}</p>
                              <p class="mb-0"><i class="las la-map-marker"></i> {{$cpartner->address}}</p>
                           </div>
                        </div>
                        <div class="contacts-action">
                           <span class="badge badge-light"><i class="las la-lock"></i>Private</span>
                           <div class="dropdown action-drops">
                              <!-- <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                              <span><span id="status-bar">@if($cpartner->status==2) Closed @elseif($cpartner->status==1) Opened @else Pending @endif</span><i class="las la-angle-down ms-2"></i></span>
                              </a> -->
                              <!-- <div class="dropdown-menu dropdown-menu-right">
                                 <a class="dropdown-item" href="javascript:void(0);" onclick="change_status('2')"><span>Closed</span></a>
                                 <a class="dropdown-item" href="javascript:void(0);" onclick="change_status('1')"><span>Opened</span></a>
                              </div> -->
                           </div>
                           <div class="dropdown action-drops">
                              <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                              <span><span id="lead_status-bar">{{$cpartner->cp_status?$cpartner->cp_status:'Pending'}}</span><i class="las la-angle-down ms-2"></i></span>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="change_ladstatus('SITE VISIT DONE')"><span>SITE VISIT DONE</span></a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="change_ladstatus('Warm')"><span>Warm</span></a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="change_ladstatus('F2F Planned')"><span>F2F Planned</span></a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="change_ladstatus('Visited - Cold')"><span>Visited - Cold</span></a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="change_ladstatus('Visited - Hot')"><span>Visited - Hot</span></a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="change_ladstatus('Revisit Planned')"><span>Revisit Planned</span></a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="change_ladstatus('Revisited')"><span>Revisited</span></a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="change_ladstatus('Token Received')"><span>Token Received</span></a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="change_ladstatus('Sale Done')"><span>Sale Done</span></a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="change_ladstatus('Never Picked')"><span>Never Picked</span></a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="change_ladstatus('JUST  Arrived')"><span>JUST  Arrived</span></a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="change_ladstatus('lost')"><span>lost</span></a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="change_ladstatus('Deal Closed')"><span>Deal Closed</span></a>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-3">
                     <div class="card contact-sidebar">
                        <h5>Channel Partner Information</h5>
                        <ul class="other-info">
                           <li><span class="other-title">Date Created</span><span>{{date('d M Y, h:i a',strtotime($cpartner->created_at))}}</span></li>
                           <!-- <li><span class="other-title">Budget</span><span>{{$cpartner->lead_type}}</span></li> -->
                           <!-- <li><span class="other-title">Due Date</span><span>20 Jan 2024, 10:00 am</span></li> -->
                           <li title="{{$cpartner->next_fellowup_remark}}">
                              <span class="other-title">Next Follow Up</span>
                              <span>{{$cpartner->next_followup}}</span>
                              <a  class="edit-icon" data-href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#next-followup"><i class="fa-solid fa-pencil"></i></a>
                           </li>
                           <li><span class="other-title">Follow Up Date</span><span>{{$cpartner->next_action_date?date('d M Y',strtotime($cpartner->next_action_date)):'---------------'}}</span></li>
                           <li><span class="other-title">Source</span><span>{{$cpartner->source}}</span></li>
                           <li><span class="other-title">Address Type</span><span>{{$cpartner->address_type}}</span></li>
                           <li><span class="other-title">Looking For</span><span>{{$cpartner->looking_for}}</span></li>
                           <!-- <li><span class="other-title">Purpose</span><span>{{$cpartner->purpose}}</span></li> -->
                        </ul>
                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                           <h5>Owner</h5>
                           @if(admin_has_permission('Create-CP'))
                           <a href="javascript:void(0);" class="com-add" data-bs-toggle="modal" data-bs-target="#add_owner"><i class="las la-plus-circle me-1"></i>Add/Change</a>
                           @endif
                        </div>
                        <ul class="deals-info">
                           <li>
                              <span>
                              @if($cpartner->user && $cpartner->user->image)
                              <img src="{{asset('assets/img/employee/'.$cpartner->user->image)}}" alt="User Image">
                              @else
                              <img src="{{asset('assets/img/avatar/images-dummy.jpg')}}" alt="User Image">
                              @endif
                              </span>
                              <div>
                                 <p>{{$cpartner->user?($cpartner->user->first_name.' '.$cpartner->user->last_name):'Not Assigned'}}</p>
                              </div>
                           </li>
                        </ul>
                        
                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                           <h5>Followup Type</h5>
                        </div>
                        <ul class="priority-info">
                           <li>
                              <div class="dropdown">
                                 <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><span><i class="fa-solid fa-circle me-1 text-warning circle"></i><span id="fellowup-bar">{{$cpartner->followup_type?$cpartner->followup_type:'Pending'}}</span></span><i class="las la-angle-down ms-1"></i></a>
                                 <div class="dropdown-menu dropdown-menu-right">
                                    
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="change_fellouptus('Call')">
                                       <span><i class="fa-solid fa-circle me-1 text-info circle"></i>Call</span>
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="change_fellouptus('Boucher Sent')">
                                       <span><i class="fa-solid fa-circle me-1 text-success circle"></i>Boucher Sent</span>
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="change_fellouptus('Demo/Visit')">
                                       <span><i class="fa-solid fa-circle me-1 text-warning circle"></i>Demo/Visit</span>
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="change_fellouptus('2ndDemo/Revisit')">
                                       <span><i class="fa-solid fa-circle me-1 text-success circle"></i>2ndDemo/Revisit</span>
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="change_fellouptus('Negotiation')">
                                       <span><i class="fa-solid fa-circle me-1 text-warning circle"></i>Negotiation</span>
                                    </a>
                                    
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="change_fellouptus('Closing Meetings')">
                                       <span><i class="fa-solid fa-circle me-1 text-info circle"></i>Closing Meetings</span>
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="change_fellouptus('Fresh')">
                                       <span><i class="fa-solid fa-circle me-1 text-success circle"></i>Fresh</span>
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="change_fellouptus('NOT INT')">
                                       <span><i class="fa-solid fa-circle me-1 text-danger circle"></i>NOT INT</span>
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="change_fellouptus('Switch off')">
                                       <span><i class="fa-solid fa-circle me-1 text-warning circle"></i>Switch off</span>
                                    </a>
                                 </div>
                              </div>
                           </li>
                        </ul>
                        <!-- <div class="d-flex align-items-center justify-content-between flex-wrap">
                           <h5>Projects</h5>
                           <a href="javascript:void(0);" class="com-add" data-bs-toggle="modal" data-bs-target="#add_project"><i class="las la-plus-circle me-1"></i>Add New</a>
                        </div>
                        <ul class="projects-info">
                          
                           @foreach($projects as $project)
                           <li>
                              <a href="{{route('employee.project.details',$project->id)}}" class="badge badge-light">{{$project->name}}</a>
                           </li>
                           @endforeach
                           
                        </ul>
                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                           <h5>Contacts</h5>
                           @if(admin_has_permission('Create-Contact'))
                           <a href="javascript:void(0);" class="com-add" data-bs-toggle="modal" data-bs-target="#add_contact"><i class="las la-plus-circle me-1"></i>Add New</a>
                           @endif
                        </div> -->
                        <ul class="deals-info">
                           @if($cpartner->contacts)
                           @foreach($cpartner->contacts as $ccontact)
                           <li>
                              
                              <span>
                              @if($ccontact->image)
                              <img src="{{asset('assets/img/contact/'.$ccontact->image)}}" alt="Image">
                              @else
                              <img src="{{asset('assets/img/avatar/images-dummy.jpg')}}" alt="Image">
                              @endif
                              </span>
                              <a href="{{route('employee.contact.details',$ccontact->id)}}">
                                 <div>
                                    <p>{{$ccontact->first_name.' '.$ccontact->last_name}}</p>
                                 </div>
                              </a>
                           </li>
                           @endforeach
                           @endif
                        </ul>
                        <ul class="other-info">
                           <li><span class="other-title">Last Modified</span><span>{{date('d M Y, h:i a',strtotime($cpartner->updated_at))}}</span></li>
                           <li>
                              <span class="other-title">Modified By</span>
                              @if($cpartner->user)
                              <span>
                                 @if($cpartner->user->image)
                                 <img src="{{asset('assets/img/employee/'.$cpartner->user->image)}}" class="avatar-xs rounded-circle" alt="img"> 
                                 @else
                                 <img src="{{asset('assets/img/avatar/images-dummy.jpg')}}" class="avatar-xs rounded-circle" alt="img"> 
                                 @endif

                                 {{$cpartner->user?($cpartner->user->first_name.' '.$cpartner->user->last_name):'Not Assigned'}}</span>
                              @endif
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="col-xl-9">
                     <div class="contact-tab-wrap">
                        <h4>Channel Paretner Followup Status</h4>
                        <div class="pipeline-list">
                           <ul>
                              @php
                                 $remarks = $cpartner->followup_remark?explode(',',$cpartner->followup_remark):['Pending'];
                                 $tab = session()->get('tab');
                              @endphp
                              @foreach($remarks as $remarks)
                              <li><a href="javascript:void(0);" class="bg-{{str_replace('/','-',str_replace(' ','-',$remarks))}}">{{$remarks}}</a></li>
                              @endforeach
                           </ul>
                        </div>
                        <ul class="contact-nav nav">
                           <li>
                              <a href="#" data-bs-toggle="tab" data-bs-target="#activities" @if($tab == null) class="active" @endif><i class="las la-user-clock"></i>Activities</a>
                           </li>
                           <li>
                              <a href="#" data-bs-toggle="tab" data-bs-target="#notes" @if($tab == "note") class="active" @endif><i class="las la-file"></i>Notes</a>
                           </li>
                           <li>
                              <a href="#" data-bs-toggle="tab" data-bs-target="#calls" @if($tab == "call") class="active" @endif><i class="las la-phone-volume"></i>Calls</a>
                           </li>
                           <li>
                              <a href="#" data-bs-toggle="tab" data-bs-target="#files" @if($tab == "file") class="active" @endif><i class="las la-file"></i>Files</a>
                           </li>
                           
                        </ul>
                     </div>
                     <div class="contact-tab-view">
                        <div class="tab-content pt-0">
                           <div class="tab-pane @if($tab==null) active show @else fade @endif" id="activities">
                              <div class="view-header">
                                 <h4>Activities</h4>
                                 <ul>
                                    <li>
                                       <div class="form-sort">
                                          <i class="las la-sort-amount-up-alt"></i>
                                          <select class="select">
                                             <option>Sort By Date</option>
                                             <!-- <option>Ascending</option> -->
                                             <!-- <option>Descending</option> -->
                                          </select>
                                       </div>
                                    </li>
                                 </ul>
                              </div>
                              <div class="contact-activity">
                                 @foreach($activitieDates as $date)
                                 <div class="badge-day"><i class="fa-regular fa-calendar-check"></i>{{date('d M Y',strtotime($date))}}</div>
                                 <ul>
                                    @php
                                       $nottes = App\Models\ChannelPartnerNote::where('channel_partner_id',$cpartner->id)
                                                ->where('created_at','>=',date('Y-m-d 00:00:00',strtotime($date)))
                                                ->where('created_at','<=',date('Y-m-d 23:59:59',strtotime($date)))
                                                ->orderBy('created_at','desc')
                                                ->get();
                                       $callnottes = App\Models\CallNote::where('channel_partner_id',$cpartner->id)
                                                ->where('created_at','>=',date('Y-m-d 00:00:00',strtotime($date)))
                                                ->where('created_at','<=',date('Y-m-d 23:59:59',strtotime($date)))
                                                ->orderBy('created_at','desc')
                                                ->get();

                                       $documentts = App\Models\Document::where('channel_partner_id',$cpartner->id)
                                                ->where('created_at','>=',date('Y-m-d 00:00:00',strtotime($date)))
                                                ->where('created_at','<=',date('Y-m-d 23:59:59',strtotime($date)))
                                                ->orderBy('created_at','desc')
                                                ->get();
                                    @endphp
                                    @foreach($documentts as $id=>$documentt)
                                    <li class="activity-wrap">
                                       <span class="activity-icon bg-info">
                                       <i class="las la-comment-alt"></i>
                                       </span>
                                       <div class="activity-info">
                                          <h6>{{$documentt->note}}</h6>
                                          <p>{{date('h:i a',strtotime($documentt['created_at']))}}</p>
                                          <span class="badge badge-soft-grey"><a href="{{asset('assets/files/'.$documentt->file)}}">Download <i class="las la-download"></i></a></span>
                                       </div>
                                    </li>
                                    @endforeach
                                    @foreach($callnottes as $id=>$callnotte)
                                    <li class="activity-wrap">
                                       <span class="activity-icon bg-success">
                                       <i class="las la-phone"></i>
                                       </span>
                                       <div class="activity-info">
                                          <h6>{{$callnotte->note}}</h6>
                                          <p>{{date('h:i a',strtotime($callnotte['created_at']))}}</p>
                                       </div>
                                    </li>
                                    @endforeach
                                    @foreach($nottes as $id=>$notte)
                                    <li class="activity-wrap">
                                       <span class="activity-icon bg-warning">
                                       <i class="las la-file-alt"></i>
                                       </span>
                                       <div class="activity-info">
                                          <h6>Notes added by {{$notte->user?($notte->user->first_name.' '.$notte->user->last_name):''}}</h6>
                                          <p>{{$notte->note}}</p>
                                          <p>{{date('h:i a',strtotime($notte['created_at']))}}</p>
                                       </div>
                                    </li>
                                    @endforeach
                                 </ul>
                                 @endforeach
                              </div>
                           </div>
                           <div class="tab-pane @if($tab=='note') active show @else fade @endif" id="notes">
                              <div class="view-header">
                                 <h4>Notes</h4>
                                 <ul>
                                    <li>
                                       <div class="form-sort">
                                          <i class="las la-sort-amount-up-alt"></i>
                                          <select class="select">
                                             <option>Sort By Date</option>
                                          </select>
                                       </div>
                                    </li>
                                    <li>
                                       <a href="javascript:void(0);" class="com-add" data-bs-toggle="modal" data-bs-target="#add_notes"><i class="las la-plus-circle me-1"></i>Add New</a>
                                    </li>
                                 </ul>
                              </div>
                              <div class="notes-activity">
                                 
                                 @foreach($leadnotes as $leadnote)
                                 <div class="calls-box">
                                    <div class="caller-info">
                                       <div class="calls-user">
                                          @if($leadnote->user && $leadnote->user->image)
                                          <img src="{{asset('assets/img/employee/'.$leadnote->user->image)}}" alt="img">
                                          @else
                                          <img src="{{asset('assets/img/avatar/images-dummy.jpg')}}" alt="img">
                                          @endif
                                          <div>
                                             <h6>{{$leadnote->user?($leadnote->user->first_name.' '.$leadnote->user->last_name):''}}</h6>
                                             <p>{{date('d M Y, h:i  a',strtotime($leadnote->created_at))}}</p>
                                          </div>
                                       </div>
                                       <div class="calls-action">
                                          <div class="dropdown action-drop">
                                             <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="feather-more-vertical"></i></a>
                                             <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="javascript:void(0);" data-href="{{route('admin.channel-partner.delete_note',$leadnote->id)}}" onclick="delete_note($(this))"><i class="las la-trash me-1"></i>Delete</a>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <h5>Notes added by {{$leadnote->user?($leadnote->user->first_name.' '.$leadnote->user->last_name):''}}</h5>
                                    <p>{{$leadnote->note}}</p>
                                    <ul>
                                       @if($leadnote->file)
                                       <li>
                                          <div class="note-download">
                                             <div class="note-info">
                                                @if (str_contains(mime_content_type('assets/img/lead/'.$leadnote->file), 'image/')) 
                                                <span class="note-icon">
                                                   <img src="{{asset('assets/img/lead/'.$leadnote->file)}}" alt="img">
                                                </span>
                                                @else
                                                <span class="note-icon bg-success">
                                                   <i class="las la-file-excel"></i>
                                                </span>
                                                @endif
                                                <div>
                                                   <h6>{{$leadnote->file}}</h6>
                                                   <p>{{number_format(filesize('assets/img/lead/'.$leadnote->file)/1024, 2)}} KB</p>
                                                </div>
                                             </div>
                                             <a href="{{asset('assets/img/lead/'.$leadnote->file)}}"><i class="las la-download"></i></a>
                                          </div>
                                       </li>
                                       @endif
                                    </ul>
                                    {!! $leadnote->comments !!}
                                    <form action="{{route('admin.channel-partner.add_comment')}}" method="post">
                                       @csrf
                                       <input type="hidden" name="note_id" value="{{$leadnote->id}}">
                                       <div class="notes-editor">
                                          <div class="note-edit-wrap">
                                             <textarea class="summernote" name="new_comment">Write a new comment, send your team notification by typing @ followed by their name</textarea>
                                             <div class="text-end note-btns">
                                                <a href="javascript:void(0);" class="btn btn-lighter add-cancel">Cancel</a>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                             </div>
                                          </div>
                                          <div class="text-end">
                                             <a href="javascript:void(0);" class="add-comment"><i class="las la-plus-circle me-1"></i>Add Comment</a>
                                          </div>
                                       </div>
                                    </form>
                                 </div>
                                 @endforeach
                                 
                              </div>
                           </div>
                           <div class="tab-pane @if($tab=='call') active show @else fade @endif" id="calls">
                              <div class="view-header">
                                 <h4>Calls</h4>
                                 <ul>
                                    <li>
                                       <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#create_call" class="com-add"><i class="las la-plus-circle me-1"></i>Add New</a>
                                    </li>
                                 </ul>
                              </div>
                              <div class="calls-activity">
                                 @foreach($callnotes as $callnote)
                                 <div class="calls-box">
                                    <div class="caller-info">
                                       <div class="calls-user">
                                           @if($callnote->user && $callnote->user->image)
                                          <img src="{{asset('assets/img/employee/'.$callnote->user->image)}}" alt="img">
                                          @else
                                          <img src="{{asset('assets/img/avatar/images-dummy.jpg')}}" alt="img">
                                          @endif
                                          <p><span>{{$callnote->user?($callnote->user->first_name.' '.$callnote->user->last_name):''}}</span> logged a call on {{date('d M Y, h:i a',strtotime($callnote->created_at))}}</p>
                                       </div>
                                       <div class="calls-action">
                                          <div class="dropdown call-drop">
                                             <a href="#" class="dropdown-toggle {{$callnote->status=='No Answer'?'bg-light-pending':''}}" data-bs-toggle="dropdown" aria-expanded="false">{{$callnote->status}}<i class="las la-angle-down ms-1"></i></a>
                                             <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="javascript:void(0);">Busy</a>
                                                <a class="dropdown-item" href="javascript:void(0);">No Answer</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Unavailable</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Wrong Number</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Left Voice Message</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Moving Forward</a>
                                             </div>
                                          </div>
                                          <div class="dropdown">
                                             <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="feather-more-vertical"></i></a>
                                             <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="javascript:void(0);" data-href="{{route('employee.leads.delete_callNote',$callnote->id)}}" onclick="delete_note($(this))">Delete</a>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <p>{{$callnote->note}}</p>
                                 </div>
                                 @endforeach
                              </div>
                           </div>
                           <div class="tab-pane @if($tab=='file') active show @else fade @endif" id="files">
                              <div class="view-header">
                                 <h4>Files</h4>
                              </div>
                              <div class="files-activity">
                                 <div class="files-wrap">
                                    <div class="row align-items-center">
                                       <div class="col-md-8">
                                          <div class="file-info">
                                             <h4>Manage Documents</h4>
                                             <p>Upload customizable quotes, proposals and contracts here.</p>
                                          </div>
                                       </div>
                                       <div class="col-md-4 text-md-end">
                                          <ul class="file-action">
                                             <li>
                                                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_files">Create Document</a>
                                             </li>
                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                                 @foreach($documents as $document)
                                 <div class="files-wrap">
                                    <div class="row align-items-center">
                                       <div class="col-md-8">
                                          <div class="file-info">
                                             <h4>{{$document->title}}</h4>
                                             <p>{{$document->note}}</p>
                                             <div class="file-user">
                                                @if($document->user && $document->user->image)
                                                <img src="{{asset('assets/img/employee/'.$document->user->image)}}" alt="img">
                                                @else
                                                <img src="{{asset('assets/img/avatar/images-dummy.jpg')}}" alt="img">
                                                @endif
                                                <div>
                                                   <p><span>Owner</span> {{$document->user?($document->user->first_name.' '.$document->user->last_name):''}}</p>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-md-4 text-md-end">
                                          <ul class="file-action">
                                             <li>
                                                <span class="badge badge-soft-grey"><a href="{{asset('assets/files/'.$document->file)}}">Download <i class="las la-download"></i></a></span>
                                             </li>
                                             
                                             <li>
                                                <div class="dropdown action-drop">
                                                   <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="feather-more-vertical"></i></a>
                                                   <div class="dropdown-menu dropdown-menu-right">
                                                      <!-- <a class="dropdown-item" href="javascript:void(0);"><i class="las la-edit me-1"></i>Edit</a> -->
                                                      <a class="dropdown-item" href="javascript:void(0);" data-href="{{route('employee.leads.delete_file',$document->id)}}" onclick="delete_note($(this))"><i class="las la-trash me-1"></i>Delete</a> 
                                                      <a class="dropdown-item" href="{{asset('assets/files/'.$document->file)}}" download><i class="las la-download me-1"></i>Download</a>
                                                   </div>
                                                </div>
                                             </li>
                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                                 @endforeach
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         @endsection
         @section('modal')

            <div id="next-followup" class="modal custom-modal fade" role="dialog">
               <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title">Add Next Fellowup </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <form action="{{route('admin.channel-partner.add_next_fellowup',$cpartner->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                           <div class="input-group m-b-30">
                              <label class="col-form-label">Fellowup <span class="text-danger"> *</span></label>
                              <select class="select" name="fellowup" required>
                                 <option value="">Select</option>
                                    <option>Call</option>
                                    <option>Boucher Sent</option>
                                    <option>Demo/Visit</option>
                                    <option>2ndDemo/Revisit</option>
                                    <option>Negotiation</option>
                                    <option>Closing Meetings</option>
                                    <option>Fresh</option>
                                    <option>NOT INT</option>
                                    <option>Switch off</option>
                              </select>
                           </div>
                           <div class="contact-input-set">
                                 <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                       <div class="input-block mb-3">
                                          <label class="col-form-label">Date <span class="text-danger"> *</span></label>
                                          <input class="form-control" type="date" name="fellowup_date" required>
                                       </div>
                                    </div>
                                    
                                    <div class="col-lg-12">
                                       <div class="input-block mb-3">
                                          <label class="col-form-label">Comments<span class="text-danger">*</span></label>
                                          <textarea class="form-control" rows="5" name="comment" required></textarea>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           <div class="submit-section">
                              <button class="btn btn-primary submit-btn">Submit</button>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>

            <div id="add_owner" class="modal custom-modal fade" role="dialog">
               <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title">Add Owner On This </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <form action="{{route('admin.channel-partner.add_owner',$cpartner->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                           <div class="input-group m-b-30">
                              <select class="select" name="user_id">
                                 <option value="">Select</option>
                                 @foreach(get_employees() as $employee)
                                    <option value="{{$employee->id}}">{{$employee->first_name.' '.$employee->last_name}}</option>
                                 @endforeach
                              </select>
                           </div>
                           <div class="submit-section">
                              <button class="btn btn-primary submit-btn">Submit</button>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>

            <div id="add_project" class="modal custom-modal fade" role="dialog">
               <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title">Add projects On This </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <form action="{{route('employee.leads.add_projects',$cpartner->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                           <div class="input-group m-b-30">
                              <select class="select" name="project_ids[]" multiple>
                                 <option value="">Select</option>
                                 @foreach(get_projects() as $get_project)
                                 @if($get_project->status==1)
                                    <option value="{{$get_project->id}}">{{$get_project->name}}</option>
                                 @endif
                                 @endforeach
                              </select>
                           </div>
                           <div class="submit-section">
                              <button class="btn btn-primary submit-btn">Submit</button>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>

         <div class="modal custom-modal fade custom-modal-two modal-padding" id="add_contact" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
               <div class="modal-content">
                  <div class="modal-header header-border justify-content-between p-0">
                     <h5 class="modal-title">Add New Contact</h5>
                     <button type="button" class="btn-close position-static" data-bs-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span>
                     </button>
                  </div>
                  
                     <div class="add-info-fieldset">
                        <fieldset id="first-field">
                           <form action="{{route('employee.contact.store')}}" method="post" enctype="multipart/form-data">
                              @csrf
                              <input type="hidden" name="lead_id" value="{{$cpartner->id}}">
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
                                          <input class="form-control" type="text" name="first_name" required>
                                       </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                       <div class="input-block mb-3">
                                          <label class="col-form-label">Last Name <span class="text-danger"> </span></label>
                                          <input class="form-control" type="text" name="last_name">
                                       </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                       <div class="input-block mb-3">
                                          <label class="col-form-label">Job Title <span class="text-danger"> </span></label>
                                          <input class="form-control" type="text" name="job_title">
                                       </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                       <div class="input-block mb-3">
                                          <label class="col-form-label">Company Name <span class="text-danger"></span></label>
                                          <input class="form-control" type="text" name="Company_name">
                                       </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                       <div class="input-block mb-3">
                                          <div class="d-flex justify-content-between align-items-center">
                                             <label class="col-form-label">Email <span class="text-danger"> *</span></label>
                                             
                                          </div>
                                          <input class="form-control" type="email" name="email" required>
                                       </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                       <div class="input-block mb-3">
                                          <label class="col-form-label">Phone Number <span class="text-danger"> *</span></label>
                                          <input class="form-control" type="text" name="phone" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" pattern="[0-9]{10}" required>
                                       </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                       <div class="input-block mb-3">
                                          <label class="col-form-label">Alt Phone Number <span class="text-danger"> </span></label>
                                          <input class="form-control" type="text" name="alt_phone" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" pattern="[0-9]{10}">
                                       </div>
                                    </div>
                                   
                                    <div class="col-lg-4 col-md-6">
                                       <div class="input-block mb-3">
                                          <label class="col-form-label">Reviews <span class="text-danger"></span></label>
                                          <select class="select" name="reviews">
                                             <option value="">Select</option>
                                             <option>Lowest</option>
                                             <option>Highest</option>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                       <div class="input-block mb-3">
                                          <label class="col-form-label">Owner <span class="text-danger"></span></label>
                                          <select class="select" name="user_id">
                                             <option value="">Select</option>
                                             @foreach( get_employees() as $key=>$employee )
                                             @if($employee->id == $cpartner->user_id)
                                             <option value="{{$employee->id}}">{{$employee->first_name.' '.$employee->last_name}}</option>
                                             @endif
                                             @endforeach
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-lg-12">
                                       <div class="input-block mb-3">
                                          <label class="col-form-label">Comments<span class="text-danger">*</span></label>
                                          <textarea class="form-control" rows="5" name="comment" required></textarea>
                                       </div>
                                    </div>
                                    <div class="col-lg-12 text-end form-wizard-button">
                                       <button class="button btn-lights reset-btn" type="reset">Reset</button>
                                       <button type="submit" class="btn btn-primary" type="button">Save</button>
                                    </div>
                                 </div>
                              </div>
                           </form>
                        </fieldset>
                      
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="modal custom-modal fade modal-padding" id="add_notes" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
               <div class="modal-content">
                  <div class="modal-header header-border align-items-center justify-content-between p-0">
                     <h5 class="modal-title">Add Note</h5>
                     <button type="button" class="btn-close position-static" data-bs-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span>
                     </button>
                  </div>
                  <div class="modal-body p-0">
                     <form action="{{route('admin.channel-partner.add_note')}}" method="post" enctype="multipart/form-data" >
                        @csrf
                        <div class="input-block mb-3">
                           <label class="col-form-label">Title <span class="text-danger"> *</span></label>
                           <input class="form-control" type="text" name="title" required>
                           <input type="hidden" name="cp_id" value="{{$cpartner->id}}">
                        </div>
                        <div class="input-block mb-3">
                           <label class="col-form-label">Note <span class="text-danger"> *</span></label>
                           <textarea class="form-control" rows="4" placeholder="Add text" name="note" required></textarea>
                        </div>
                        <div class="input-block mb-3">
                           <label class="col-form-label">Attachment <span class="text-danger"> </span></label>
                           <div class="drag-upload">
                              <input type="file" name="file">
                              <div class="img-upload">
                                 <i class="las la-file-import"></i>
                                 <p>Drag & Drop your files</p>
                              </div>
                           </div>
                        </div>
                        
                        <div class="col-lg-12 text-end form-wizard-button">
                           <!-- <button class="button btn-lights reset-btn" type="reset">Reset</button> -->
                           <button class="btn btn-primary" type="submit">Save Notes</button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>

         <div class="modal custom-modal fade modal-padding" id="add_files" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
               <div class="modal-content">
                  <div class="modal-header header-border align-items-center justify-content-between p-0">
                     <h5 class="modal-title">Add File</h5>
                     <button type="button" class="btn-close position-static" data-bs-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span>
                     </button>
                  </div>
                  <div class="modal-body p-0">
                     <form action="{{route('admin.channel-partner.add_file',$cpartner->id)}}" method="post" enctype="multipart/form-data" >
                        @csrf
                        <div class="input-block mb-3">
                           <label class="col-form-label">Title <span class="text-danger"> *</span></label>
                           <input class="form-control" type="text" name="title" required>
                           <input type="hidden" name="lead_id" value="{{$cpartner->id}}">
                        </div>
                        <div class="input-block mb-3">
                           <label class="col-form-label">Note <span class="text-danger"> *</span></label>
                           <textarea class="form-control" rows="4" placeholder="Add text" name="note" required></textarea>
                        </div>
                        <div class="input-block mb-3">
                           <label class="col-form-label">Attachment <span  class="text-danger"> </span></label>
                           <div class="drag-upload">
                              <input type="file" name="file">
                              <div class="img-upload">
                                 <i class="las la-file-import"></i>
                                 <p>Drag & Drop your files</p>
                              </div>
                           </div>
                        </div>
                        
                        <div class="col-lg-12 text-end form-wizard-button">
                           <!-- <button class="button btn-lights reset-btn" type="reset">Reset</button> -->
                           <button class="btn btn-primary" type="submit">Add File</button>
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

      <div class="modal custom-modal fade modal-padding" id="create_call" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
               <div class="modal-content">
                  <div class="modal-header header-border align-items-center justify-content-between p-0">
                     <h5 class="modal-title">Create Call Log</h5>
                     <button type="button" class="btn-close position-static" data-bs-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span>
                     </button>
                  </div>
                  <div class="modal-body p-0">
                     <form action="{{route('admin.channel-partner.add_call',$cpartner->id)}}" method="post">
                        @csrf
                        <div class="row">
                           <div class="col-md-6">
                              <div class="input-block mb-3">
                                 <label class="col-form-label">Status <span class="text-danger"> *</span></label>
                                 <select class="select" name="status" required>
                                    <option>Busy</option>
                                    <option>Unavailable</option>
                                    <option>No Answer</option>
                                    <option>Wrong Number</option>
                                    <option>Left Voice Message</option>
                                    <option>Moving Forward</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="input-block mb-3">
                                 <label class="col-form-label">Followup Date <span class="text-danger"></span></label>
                                 <input class="form-control datetimepicker" type="text" name="fellowup_date" max="{{date('Y-m-d')}}">
                              </div>
                           </div>
                        </div>
                        <div class="input-block mb-3">
                           <label class="col-form-label">Note <span class="text-danger"> *</span></label>
                           <textarea class="form-control" rows="4" placeholder="Add text" name="note" required></textarea>
                        </div>
                        <!-- <div class="input-block mb-3">
                           <label class="custom_check check-box mb-0">
                           <input type="checkbox" name="fellowup_task">
                           <span class="checkmark"></span> Create a Follow up task
                           </label>
                        </div> -->
                        <div class="col-lg-12 text-end form-wizard-button">
                           <!-- <button class="button btn-lights reset-btn" type="reset">Reset</button> -->
                           <button class="btn btn-primary" type="submit">Save Call</button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
@endsection
@section('scripts')
     <script data-cfasync="false" src="{{asset('assets/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js')}}"></script>
     <script src="{{asset('assets/js/jquery-3.7.1.min.js')}}" type="712a4b0e0e5ee5c24248da6b-text/javascript"></script>
      <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}" type="712a4b0e0e5ee5c24248da6b-text/javascript"></script>
      <script src="{{asset('assets/js/jquery.slimscroll.min.js')}}" type="712a4b0e0e5ee5c24248da6b-text/javascript"></script>
      <script src="{{asset('assets/js/jquery.dataTables.min.js')}}" type="712a4b0e0e5ee5c24248da6b-text/javascript"></script>
      <script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}" type="712a4b0e0e5ee5c24248da6b-text/javascript"></script>
      <script src="{{asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}" type="712a4b0e0e5ee5c24248da6b-text/javascript"></script>
      <script src="{{asset('assets/js/moment.min.js')}}" type="712a4b0e0e5ee5c24248da6b-text/javascript"></script>
      <script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}" type="712a4b0e0e5ee5c24248da6b-text/javascript"></script>
      <script src="{{asset('assets/js/moment.min.js')}}" type="712a4b0e0e5ee5c24248da6b-text/javascript"></script>
      <script src="{{asset('assets/plugins/daterangepicker/daterangepicker.js')}}" type="712a4b0e0e5ee5c24248da6b-text/javascript"></script>
      <script src="{{asset('assets/js/select2.min.js')}}" type="712a4b0e0e5ee5c24248da6b-text/javascript"></script>
      <script src="{{asset('assets/plugins/summernote/summernote-bs4.min.js')}}" type="712a4b0e0e5ee5c24248da6b-text/javascript"></script>
      <script src="{{asset('assets/js/layout.js')}}" type="712a4b0e0e5ee5c24248da6b-text/javascript"></script>
      <!-- <script src="{{asset('assets/js/theme-settings.js')}}" type="712a4b0e0e5ee5c24248da6b-text/javascript"></script> -->
      <!-- <script src="{{asset('assets/js/greedynav.js')}}" type="712a4b0e0e5ee5c24248da6b-text/javascript"></script> -->
      <script src="{{asset('assets/js/app.js')}}" type="712a4b0e0e5ee5c24248da6b-text/javascript"></script>
      <script src="{{asset('assets/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js')}}" data-cf-settings="712a4b0e0e5ee5c24248da6b-|49" defer></script>

      <script type="text/javascript">
         function change_ladstatus(status){
            $.ajax({
               url:"{{route('admin.channel-partner.change_cp_status',$cpartner->id)}}",
                method:'post',
                data:{
                    '_token': '{{csrf_token()}}',
                    'status': status
                },
                success:function(result)
                {
                    if (result) {
                        $('#lead_status-bar').html(status); 
                        tost_fire('Status Updated Successfully!','success');
                    }else{
                        tost_fire('Can Not Update This Lead!','error');
                    }
                }
            });
         }

         function change_fellouptus(status){
            $.ajax({
               url:"{{route('admin.channel-partner.change_fellowupType',$cpartner->id)}}",
                method:'post',
                data:{
                    '_token': '{{csrf_token()}}',
                    'status': status
                },
                success:function(result)
                {
                    if (result) {
                        $('#fellowup-bar').html(status); 
                        tost_fire('Fellowup Updated Successfully!','success');
                    }else{
                        tost_fire('Can Not Update This Lead!','error');
                    }
                }
            });
         }

         function change_status(status){
            $.ajax({
               url:"{{route('employee.leads.change_status',$cpartner->id)}}",
                method:'post',
                data:{
                    '_token': '{{csrf_token()}}',
                    'status': status
                },
                success:function(result)
                {
                    if (result) {
                        if (status==1) {
                           $('#status-bar').html('Opened'); 
                        }else{
                           $('#status-bar').html('Closed'); 
                        }
                        
                        tost_fire('Status Updated Successfully!','success');
                    }else{
                        tost_fire('Can Not Update This Lead!','error');
                    }
                }
            });
         }

         function delete_note(el){
               $('#d-okay').attr("href", el.attr("data-href"));
               $('#delete_models').modal('show');
            }
         
      </script>

@endsection