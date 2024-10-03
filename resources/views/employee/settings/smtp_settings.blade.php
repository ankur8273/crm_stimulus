@extends('employee.layouts.app')
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
                    <h3 class="page-title">Smtp Mail Setting Update</h3>
                    <ul class="breadcrumb">
                       <li class="breadcrumb-item"><a href="{{route('employee.dashboard')}}">Dashboard</a></li>
                       <li class="breadcrumb-item active">Setting</li>
                    </ul>
                 </div>
              </div>
           </div>
           <div class="card mb-0">
              <div class="card-body">
                 <div class="row">
                    
                    <div class="col-md-6">
                       <div class="profile-info-left">

                          <form action="{{route('employee.smtp-update-settings')}}" method="post" enctype="multipart/form-data">
                             @csrf
                             
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Transport</label>
                                        <input type="text" class="form-control" value="{{env('MAIL_MAILER')}}" name="MAIL_MAILER">
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Host</label>
                                        <input type="text" class="form-control" placeholder="Enter host.."name="MAIL_HOST" value="{{env('MAIL_HOST')}}"required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Port </label>
                                        <input type="text" class="form-control" placeholder="Enter port.."name="MAIL_PORT" value="{{env('MAIL_PORT')}}"required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Encryption </label>
                                        <input type="text" class="form-control" placeholder="Enter encryption.."name="MAIL_ENCRYPTION" value="{{env('MAIL_ENCRYPTION')}}"required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Username </label>
                                        <input type="text" class="form-control" placeholder="Enter username.."name="MAIL_USERNAME" value="{{env('MAIL_USERNAME')}}"required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Password </label>
                                        <input type="text" class="form-control" placeholder="Enter password.."name="MAIL_PASSWORD" value="{{env('MAIL_PASSWORD')}}"required>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Mail from</label>
                                        <input type="text" class="form-control" placeholder="Enter password.."name="MAIL_FROM_ADDRESS" value="{{env('MAIL_FROM_ADDRESS')}}"required>
                                    </div>
                                </div>

                                
                            </div>
                             <div class="staff-msg">
                                <button class="btn btn-custom btn-primary   " type="submit">Update Smtp Settings</button>
                            </div>
                          </form>
                       </div>
                    </div>
                    
                    <div class="col-md-6">
                       <div class="profile-info-left">

                          <form action="{{route('employee.smtp-test')}}" method="post" enctype="multipart/form-data">
                             @csrf
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="input-block mb-3">
                                        <label class="col-form-label">Your Email</label>
                                        <input type="email" class="form-control" value="" name="email">
                                    </div>
                                </div>
                            </div>
                             <div class="staff-msg">
                                <button class="btn btn-custom btn-primary float-end" type="submit">Test</button>
                            </div>
                          </form>
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