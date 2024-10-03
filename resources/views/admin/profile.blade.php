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
      <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
      <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
@endpush
@section('content')

      <div class="page-wrapper">
            <div class="content container-fluid pb-0">
               <div class="page-header">
                  <div class="row">
                     <div class="col-sm-12">
                        <h3 class="page-title">Profile</h3>
                        <ul class="breadcrumb">
                           <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                           <li class="breadcrumb-item active">Profile</li>
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="card mb-0">
                  <div class="card-body">
                     <div class="row">
                        <div class="col-md-12">
                           <div class="profile-view">
                              <div class="profile-img-wrap">
                                 <div class="profile-img">
                                    <a href="#">
                                       @if($user->image)
                                       <img src="{{asset('assets/img/employee/'.$user->image)}}" alt="User Image" id="profile-imagea">
                                       @else
                                       <img src="{{asset('assets/img/icons/profile-upload-img.svg')}}" alt="User Image" id="profile-imagea">
                                       @endif
                                    </a>
                                 </div>
                              </div>
                              <div class="profile-basic">
                                 <div class="row">
                                    <div class="col-md-5">
                                       <div class="profile-info-left">
                                          <h3 class="user-name m-t-0 mb-0">{{$user->first_name}}</h3>
                                          
                                          <form action="{{route('admin.profile-image')}}" method="post" enctype="multipart/form-data">
                                             @csrf
                                             <div class="staff-msg"><input type="file" name="profile_image" onchange="readURL(this,'#profile-imagea')"></div>
                                             <div class="staff-msg"><button class="btn btn-custom" type="submit">Update Profile</button></div>
                                          </form>
                                       </div>
                                    </div>
                                    <div class="col-md-7">
                                       <ul class="personal-info">
                                          <li>
                                             <div class="title">Name:</div>
                                             <div class="text"><a href="#">{{$user->first_name}}</a></div>
                                          </li>
                                          <li>
                                             <div class="title">Phone:</div>
                                             <div class="text"><a href="#">{{$user->phone}}</a></div>
                                          </li>
                                          <li>
                                             <div class="title">Email:</div>
                                             <div class="text"><a href="#">{{$user->email}}</a></div>
                                          </li>
                                          
                                       </ul>
                                    </div>
                                 </div>
                              </div>
                              
                              <div class="pro-edit">
                                 <a data-bs-target="#change-password" data-bs-toggle="modal" class="edit-icon" href="#"><i class="fa-solid fa-key"></i></a> 
                                 <a data-bs-target="#profile_info" data-bs-toggle="modal" class="edit-icon" href="#"><i class="fa-solid fa-pencil"></i></a></div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               
            </div>
         </div>

@endsection
@section('modal')
         
            <div id="change-password" class="modal custom-modal fade" role="dialog">
               <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title">Change Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">
                        <form action="{{route('admin.profile-password',$user->id)}}" method="post">
                           @csrf
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Old password</label>
                                    <input type="password" class="form-control" value="" name="old_password">
                                 </div>
                              </div>

                              <div class="col-md-12">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">New password</label>
                                    <input type="password" class="form-control" value="" name="password">
                                 </div>
                              </div>

                              <div class="col-md-12">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">confirm Password</label>
                                    <input type="text" class="form-control" value="" name="password_confirmation">
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

            <div id="profile_info" class="modal custom-modal fade" role="dialog">
               <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title">Profile Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">
                        <form action="{{route('admin.profile-update')}}" method="post" enctype="multipart/form-data">
                           @csrf
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="profile-img-wrap edit-img">
                                    <img class="inline-block" src="{{asset('assets/img/employee/'.$user->image)}}" alt="User Image" id="profile_image">
                                    <div class="fileupload btn">
                                       <span class="btn-text">edit</span>
                                       <input class="upload" type="file" name="profile_image" onchange="readURL(this,'#profile_image')">
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="input-block mb-3">
                                          <label class="col-form-label">Name</label>
                                          <input type="text" class="form-control" value="{{$user->first_name}}"  name="name">
                                       </div>
                                    </div>
                                    
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              
                              <div class="col-md-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Phone Number</label>
                                    <input type="text" class="form-control" value="{{$user->phone}}" name="phone">
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
            
@endsection
@section('scripts')
      <script src="{{asset('assets/js/jquery-3.7.1.min.js')}}" type="78ea7a8757c998612cde210a-text/javascript"></script>
      <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}" type="78ea7a8757c998612cde210a-text/javascript"></script>
      <script src="{{asset('assets/js/jquery.slimscroll.min.js')}}" type="78ea7a8757c998612cde210a-text/javascript"></script>
      <script src="{{asset('assets/js/select2.min.js')}}" type="78ea7a8757c998612cde210a-text/javascript"></script>
      <script src="{{asset('assets/js/moment.min.js')}}" type="78ea7a8757c998612cde210a-text/javascript"></script>
      <script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}" type="78ea7a8757c998612cde210a-text/javascript"></script>
      <script src="{{asset('assets/js/jquery.dataTables.min.js')}}" type="78ea7a8757c998612cde210a-text/javascript"></script>
      <script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}" type="78ea7a8757c998612cde210a-text/javascript"></script>
      <script src="{{asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js')}}" type="78ea7a8757c998612cde210a-text/javascript"></script>
      <script src="{{asset('assets/js/layout.js')}}" type="78ea7a8757c998612cde210a-text/javascript"></script>
      <!-- <script src="{{asset('assets/js/theme-settings.js')}}" type="78ea7a8757c998612cde210a-text/javascript"></script> -->
      <!-- <script src="{{asset('assets/js/greedynav.js')}}" type="78ea7a8757c998612cde210a-text/javascript"></script> -->
      <script src="{{asset('assets/js/app.js')}}" type="78ea7a8757c998612cde210a-text/javascript"></script>
      <script src="{{asset('assets/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js')}}" data-cf-settings="78ea7a8757c998612cde210a-|49" defer></script>


@endsection