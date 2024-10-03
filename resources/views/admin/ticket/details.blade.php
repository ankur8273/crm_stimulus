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
                     <div class="col-md-4">
                        <h3 class="page-title mb-0">Ticket Detail</h3>
                     </div>
                  </div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-xl-8 col-lg-7">
                     <div class="ticket-detail-head">
                        <div class="row">
                           <div class="col-xxl-3 col-md-6">
                              <div class="ticket-head-card">
                                 <span class="ticket-detail-icon"><i class="la la-stop-circle"></i></span>
                                 <div class="detail-info">
                                    <h6>Status</h6>
                                    <span class="badge badge-soft-{{in_array($ticket->status,['Closed','In Progress'])?'success':''}}{{in_array($ticket->status,['Open','Reopened'])?'info':''}}{{in_array($ticket->status,['On Hold','Cancelled','New'])?'danger':''}}">{{$ticket->status}}</span>
                                 </div>
                              </div>
                           </div>
                           <div class="col-xxl-3 col-md-6">
                              <div class="ticket-head-card">
                                 <span class="ticket-detail-icon bg-danger-lights"><i class="la la-user"></i></span>
                                 <div class="detail-info info-two">
                                    <h6>Created By</h6>
                                    @if($ticket->created_by == 'admin')
                                    <span>{{$ticket->user->name}}</span>
                                    @else
                                    <span>{{$ticket->user->first_name.' '.$ticket->user->last_name}}</span>
                                    @endif
                                 </div>
                              </div>
                           </div>
                           <div class="col-xxl-3 col-md-6">
                              <div class="ticket-head-card">
                                 <span class="ticket-detail-icon bg-warning-lights"><i class="la la-calendar"></i></span>
                                 <div class="detail-info info-two">
                                    <h6>Created Date</h6>
                                    <span>{{date('d M Y',strtotime($ticket->created_at))}}</span>
                                 </div>
                              </div>
                           </div>
                           <div class="col-xxl-3 col-md-6">
                              <div class="ticket-head-card">
                                 <span class="ticket-detail-icon bg-purple-lights"><i class="la la-info-circle"></i></span>
                                 <div class="detail-info">
                                    <h6>Priority</h6>
                                    <span class="badge badge-soft-{{$ticket->priority=='High'?'danger':''}}{{$ticket->priority=='Medium'?'warning':''}}{{$ticket->priority=='Low'?'success':''}}">{{$ticket->priority}}</span>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="ticket-purpose">
                        <h4>{{$ticket->subject}}</h4>
                        {!! $ticket->details !!}
                     </div>
                     <div class="attached-files-info">
                        <div class="row">
                           <div class="col-xxl-6">
                              <div class="attached-files">
                                 <ul>
                                    @if($ticket->file)
                                    <li>
                                       <div class="d-flex align-items-center">
                                          <span class="file-icon"><i class="la la-file-pdf"></i></span>
                                          <p>
                                             @php
                                              $flfn = explode('-',$ticket->file);
                                                unset($flfn[0]);
                                              $flfsn = implode('-',$flfn);
                                             @endphp
                                          {{$flfsn}}
                                          </p>
                                       </div>
                                       <div class="file-download">
                                          <a href="{{asset('assets/img/ticket/'.$ticket->file)}}" download><i class="la la-download"></i>Download</a>
                                       </div>
                                    </li>
                                    @endif
                                    @foreach($files as $key=>$file)
                                    <li>
                                       <div class="d-flex align-items-center">
                                          <span class="file-icon"><i class="la la-file-pdf"></i></span>
                                          <p>
                                             @php
                                              $flf = explode('-',$file);
                                                unset($flf[0]);
                                              $flfs = implode('-',$flf);
                                             @endphp
                                          {{$flfs}}
                                          </p>
                                       </div>
                                       <div class="file-download">
                                          <a href="{{asset('assets/img/ticket/'.$file)}}" download><i class="la la-download"></i>Download</a>
                                       </div>
                                    </li>
                                    @endforeach
                                 </ul>
                              </div>
                           </div>
                           <div class="col-xxl-6">
                              <div class="attached-files media-attached-files">
                                 <ul>
                                    @foreach($images as $keyi=>$image)
                                    <li>
                                       <div class="d-flex align-items-center">
                                          <span class="file-icon"><i class="la la-image"></i></span>
                                          <p>
                                             @php
                                              $flf = explode('-',$image);
                                                unset($flf[0]);
                                              $flfs = implode('-',$flf);
                                             @endphp
                                          {{$flfs}}
                                          </p>
                                       </div>
                                       <div class="file-download">
                                          <a href="{{asset('assets/img/ticket/'.$image)}}" download><i class="la la-download"></i>Download</a>
                                       </div>
                                    </li>
                                    @endforeach
                                    
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-4 col-lg-5 theiaStickySidebar">
                     <div class="ticket-chat">
                        <div class="ticket-chat-head">
                           <h4>Ticket Chat</h4>
                           <div class="chat-post-box">
                              <form action="{{route('admin.ticket.send',$ticket->id)}}" method="post">
                                 @csrf
                                 <textarea class="form-control" rows="4" name="massage">Your Text here</textarea>
                                 <div class="files-attached d-flex justify-content-between align-items-center">
                                    <div class="post-files">
                                       <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#add_images"><i class="la la-image"></i></a>
                                       <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#add_files"><i class="la la-file-pdf"></i></a>
                                    </div>
                                    <button type="submit">Sent</button>
                                 </div>
                              </form>
                           </div>
                        </div>
                        <div class="ticket-chat-body">
                           <ul class="created-tickets-info">
                            
                              
                              @if($ticket->tkt_details)
                              @foreach($ticket->tkt_details as $dtl)
                              <li>
                                 <div class="ticket-created-user">
                                    <span class="avatar">
                                       @if($dtl->user && $dtl->user->image)
                                          @if($dtl->created_by == 'admin')
                                          <img src="{{asset('assets/img/user/'.$dtl->user->image)}}" alt="User Image">
                                          @else
                                          <img src="{{asset('assets/img/employee/'.$dtl->user->image)}}" alt="User Image">
                                          @endif
                                       @else
                                       <img src="{{asset('assets/img/avatar/images-dummy.jpg')}}" alt="User Image">
                                       @endif
                                    </span>
                                    <div class="user-name">
                                       <h5>

                                          @if($dtl->created_by == 'admin')
                                          <span>{{$dtl->user->name}}</span> (Admin)
                                          @else
                                          <span>{{$dtl->user->first_name.' '.$dtl->user->last_name}}</span>
                                          @endif
                                       </h5>
                                       <span>{{date('d M Y h:i a',strtotime($dtl->created_at))}}</span>
                                    </div>
                                 </div>
                                 <p class="details-text">{{$dtl->details}}</p>
                              </li>
                              @endforeach
                              @endif
              
                           </ul>
                        </div>
                        <!-- <div class="ticket-chat-footer">
                           <form action="javascript:void(0);">
                              <div class="d-flex justify-content-between align-items-center">
                                 <input type="text" class="form-control">
                                 <button type="submit"><i class="la la-arrow-right"></i></button>
                              </div>
                           </form>
                        </div> -->
                     </div>
                  </div>
               </div>
            </div>
         </div>

@endsection
@section('modal')

            <div id="add_files" class="modal custom-modal fade" role="dialog">
               <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title">Add PDF Files</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">
                        <form action="{{route('admin.ticket.add_files',$ticket->id)}}" method="post" enctype="multipart/form-data">
                           @csrf
                           <div class="input-group m-b-30">
                              <input class="form-control search-input" type="file" name="files[]" multiple>
                              <button type="submit" class="btn btn-primary">Upload</button>
                           </div>
                        </form>
                        <div>
                           <ul class="chat-user-list">
                              <li>
                                 <span class="designation">You can Select Multiple files</span>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div id="add_images" class="modal custom-modal fade" role="dialog">
               <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title">Add Images</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">
                        <form action="{{route('admin.ticket.add_images',$ticket->id)}}" method="post" enctype="multipart/form-data">
                           @csrf
                           <div class="input-group m-b-30">
                              <input class="form-control search-input" type="file" name="files[]" multiple>
                              <button type="submit" class="btn btn-primary">Upload</button>
                           </div>
                        </form>
                        <div>
                           <ul class="chat-user-list">
                              <li>
                                 <span class="designation">You can Select Multiple files</span>
                              </li>
                           </ul>
                        </div>
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
                              <div class="col-md-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Ticket Subject</label>
                                    <input class="form-control" type="text" value="Laptop Issue">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Ticket Id</label>
                                    <input class="form-control" type="text" readonly value="TKT-0001">
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Assign Staff</label>
                                    <select class="select">
                                       <option>-</option>
                                       <option selected>Mike Litorus</option>
                                       <option>John Smith</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-6">
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
                              <div class="col-md-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Priority</label>
                                    <select class="select">
                                       <option>High</option>
                                       <option selected>Medium</option>
                                       <option>Low</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">CC</label>
                                    <input class="form-control" type="text">
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Assign</label>
                                    <input type="text" class="form-control">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Ticket Assignee</label>
                                    <div class="project-members">
                                       <a title="John Smith" data-bs-toggle="tooltip" href="#">
                                       <img src="assets/img/profiles/avatar-10.jpg" alt="User Image">
                                       </a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Add Followers</label>
                                    <input type="text" class="form-control">
                                 </div>
                              </div>
                              <div class="col-md-6">
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
                              <div class="col-md-12">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Description</label>
                                    <textarea class="form-control" rows="4"></textarea>
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
                                 <a href="javascript:void(0);" class="btn btn-primary continue-btn">Delete</a>
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
            <div id="assignee" class="modal custom-modal fade" role="dialog">
               <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title">Assign to this task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">
                        <div class="input-group m-b-30">
                           <input placeholder="Search to add" class="form-control search-input" type="text">
                           <button class="btn btn-primary">Search</button>
                        </div>
                        <div>
                           <ul class="chat-user-list">
                              <li>
                                 <a href="#">
                                    <div class="chat-block d-flex">
                                       <span class="avatar">
                                       <img src="assets/img/profiles/avatar-09.jpg" alt="User Image">
                                       </span>
                                       <div class="media-body align-self-center text-nowrap">
                                          <div class="user-name">Richard Miles</div>
                                          <span class="designation">Web Developer</span>
                                       </div>
                                    </div>
                                 </a>
                              </li>
                              <li>
                                 <a href="#">
                                    <div class="chat-block d-flex">
                                       <span class="avatar">
                                       <img src="assets/img/profiles/avatar-10.jpg" alt="User Image">
                                       </span>
                                       <div class="media-body align-self-center text-nowrap">
                                          <div class="user-name">John Smith</div>
                                          <span class="designation">Android Developer</span>
                                       </div>
                                    </div>
                                 </a>
                              </li>
                              <li>
                                 <a href="#">
                                    <div class="chat-block d-flex">
                                       <span class="avatar">
                                       <img src="assets/img/profiles/avatar-10.jpg" alt="User Image">
                                       </span>
                                       <div class="media-body align-self-center text-nowrap">
                                          <div class="user-name">Jeffery Lalor</div>
                                          <span class="designation">Team Leader</span>
                                       </div>
                                    </div>
                                 </a>
                              </li>
                           </ul>
                        </div>
                        <div class="submit-section">
                           <button class="btn btn-primary submit-btn">Assign</button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div id="task_followers" class="modal custom-modal fade" role="dialog">
               <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title">Add followers to this task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">
                        <div class="input-group m-b-30">
                           <input placeholder="Search to add" class="form-control search-input" type="text">
                           <button class="btn btn-primary">Search</button>
                        </div>
                        <div>
                           <ul class="chat-user-list">
                              <li>
                                 <a href="#">
                                    <div class="chat-block d-flex">
                                       <span class="avatar">
                                       <img src="assets/img/profiles/avatar-10.jpg" alt="User Image">
                                       </span>
                                       <div class="media-body media-middle text-nowrap">
                                          <div class="user-name">Jeffery Lalor</div>
                                          <span class="designation">Team Leader</span>
                                       </div>
                                    </div>
                                 </a>
                              </li>
                              <li>
                                 <a href="#">
                                    <div class="chat-block d-flex">
                                       <span class="avatar">
                                       <img src="assets/img/profiles/avatar-08.jpg" alt="User Image">
                                       </span>
                                       <div class="media-body media-middle text-nowrap">
                                          <div class="user-name">Catherine Manseau</div>
                                          <span class="designation">Android Developer</span>
                                       </div>
                                    </div>
                                 </a>
                              </li>
                              <li>
                                 <a href="#">
                                    <div class="chat-block d-flex">
                                       <span class="avatar">
                                       <img src="assets/img/profiles/avatar-11.jpg" alt="User Image">
                                       </span>
                                       <div class="media-body media-middle text-nowrap">
                                          <div class="user-name">Wilmer Deluna</div>
                                          <span class="designation">Team Leader</span>
                                       </div>
                                    </div>
                                 </a>
                              </li>
                           </ul>
                        </div>
                        <div class="submit-section">
                           <button class="btn btn-primary submit-btn">Add to Follow</button>
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