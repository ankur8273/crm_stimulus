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
                        <h3 class="page-title">Setting Update</h3>
                        <ul class="breadcrumb">
                           <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                           <li class="breadcrumb-item active">Setting</li>
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="card mb-0">
                  <div class="card-body">
                     <div class="row">
                        <div class="col-md-12">
                            
                               
                              <div class="profile-basic">
                                 <div class="row">
                                    <div class="col-md-7">
                                       <div class="profile-info-left">
                                          
                                          
                                          <form action="{{route('admin.update-settings')}}" method="post" enctype="multipart/form-data">
                                             @csrf
                                             <div class="col-md-12">
                                                    <div class="input-block mb-3">
                                                    <label class="col-form-label">Logo </label> <br>    
                                                <img src="{{asset(get_setting('logo'))}}" alt="Logo Image" id="profile-imagen" width="100">
                                               
                                             <div class="col-md-12">
                                              
                                             <input type="file" name="logo" class="form-controll" onchange="readURL(this,'#profile-imagen')">
                                             </div>
                                            </div>
                                            </div>

                                             <div class="col-md-12">
                                                    <div class="input-block mb-3">

                                                    <label class="col-form-label">Favicon </label><br>
                                                <img src="{{asset(get_setting('favicon'))}}" alt="FavICon Image" id="profile-images" width="100">
                                               
                                             <div class="col-md-12">
                                              
                                             <input type="file" name="favicon" class="form-controll" onchange="readURL(this,'#profile-images')">
                                             </div>
                                             </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-md-12">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Project Name</label>
                                                        <input type="text" class="form-control" value="{{get_setting('project_name')}}" name="project_name">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Project Description </label>
                                                        <input type="text" class="form-control" placeholder="Enter Project Description.."name="project_desc" value="{{get_setting('project_desc')}}"required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Email</label>
                                                        <input type="text" class="form-control" placeholder="Enter Email.."name="email" value="{{get_setting('email')}}"required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="input-block mb-3">
                                                        <label class="col-form-label">Phone </label>
                                                        <input type="text" class="form-control" placeholder="Enter Phone.."name="phone" value="{{get_setting('phone')}}"required>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                             <div class="staff-msg">
                                                <button class="btn btn-custom btn-primary   " type="submit">Update Settings</button>
                                            </div>
                                          </form>
                                       </div>
                                    </div>
                                   
                                 </div>
                              </div>
                               
                     </div>
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