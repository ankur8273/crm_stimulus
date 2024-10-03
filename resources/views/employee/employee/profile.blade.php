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
                        <h3 class="page-title">Profile</h3>
                        <ul class="breadcrumb">
                           <li class="breadcrumb-item"><a href="{{route('employee.dashboard')}}">Dashboard</a></li>
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
                                    	@if($employee->image)
                                    	<img src="{{asset('assets/img/employee/'.$employee->image)}}" alt="User Image" id="profile-image">
                                    	@else
                                    	<img src="{{asset('assets/img/icons/profile-upload-img.svg')}}" alt="User Image" id="profile-image">
                                    	@endif
                                    </a>
                                 </div>
                              </div>
                              <div class="profile-basic">
                                 <div class="row">
                                    <div class="col-md-5">
                                       <div class="profile-info-left">
                                          <h3 class="user-name m-t-0 mb-0">{{$employee->first_name.' '.$employee->last_name}}</h3>
                                          <h6 class="text-muted">{{$employee->department->name}} Team</h6>
                                          <small class="text-muted">{{$employee->designation->name}}</small>
                                          <div class="staff-id">Employee ID : {{$employee->employee_id}}</div>
                                          <div class="small doj text-muted">Date of Join : {{date('d M Y',strtotime($employee->joining_date))}}</div>
                                          @if(has_permission('Write-Employee'))
                                          <form action="{{route('employee.employee.profile-image',$employee->id)}}" method="post" enctype="multipart/form-data">
                                          	@csrf
	                                          <div class="staff-msg"><input type="file" name="profile_image" onchange="readURL(this,'#profile-image')"></div>
	                                          <div class="staff-msg"><button class="btn btn-custom" type="submit">Update Profile</button></div>
                                          </form>
                                          @endif
                                       </div>
                                    </div>
                                    <div class="col-md-7">
                                       <ul class="personal-info">
                                          <li>
                                             <div class="title">Phone:</div>
                                             <div class="text"><a href="#">{{$employee->phone}}</a></div>
                                          </li>
                                          <li>
                                             <div class="title">Email:</div>
                                             <div class="text"><a href="#">{{$employee->email}}</a></div>
                                          </li>
                                          <li>
                                             <div class="title">Birthday:</div>
                                             <div class="text">{{date('d M',strtotime($employee->date_of_birth))}}</div>
                                          </li>
                                          <li>
                                             <div class="title">Address:</div>
                                             <div class="text">{{$employee->address}}</div>
                                          </li>
                                          <li>
                                             <div class="title">Gender:</div>
                                             <div class="text">{{$employee->gender}}</div>
                                          </li>
                                          <li>
                                             <div class="title">Reports to:</div>
                                             @if($employee->reporting)
                                             <div class="text">
                                                <div class="avatar-box">
                                                   <div class="avatar avatar-xs">
                                                   	@if($employee->reporting->image)
                                                      <img src="{{asset('assets/img/employee/'.$employee->reporting->image)}}" alt="User Image">
                                                      @else
                                                      <img src="{{asset('assets/img/icons/profile-upload-img.svg')}}" alt="User Image">
                                                      @endif
                                                   </div>
                                                </div>
                                                <a href="{{route('employee.employee.profile',$employee->reporting->id)}}">
                                                {{$employee->reporting->first_name.' '.$employee->reporting->last_name}}
                                                </a>
                                             </div>
                                             @endif
                                          </li>
                                       </ul>
                                    </div>
                                 </div>
                              </div>
                              @if(has_permission('Write-Employee'))
                              <div class="pro-edit">
                                 @if($employee->id!= auth('employee')->user()->id)
                                    <a data-bs-target="#change-password" data-bs-toggle="modal" class="edit-icon" href="#"><i class="fa-solid fa-key"></i></a> 
                                 @endif
                                 <a data-bs-target="#profile_info" data-bs-toggle="modal" class="edit-icon" href="#"><i class="fa-solid fa-pencil"></i></a></div>
                              </div>
                              @endif
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
                        <form action="{{route('employee.employee.profile-password',$employee->id)}}" method="post">
                           @csrf
                           <div class="row">
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
                        <form action="{{route('employee.employee.profile-update',$employee->id)}}" method="post" enctype="multipart/form-data">
                           @csrf
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="profile-img-wrap edit-img">
                                    <img class="inline-block" src="{{asset('assets/img/employee/'.$employee->image)}}" alt="User Image" id="profile_image">
                                    <div class="fileupload btn">
                                       <span class="btn-text">edit</span>
                                       <input class="upload" type="file" name="profile_image" onchange="readURL(this,'#profile_image')">
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="input-block mb-3">
                                          <label class="col-form-label">First Name</label>
                                          <input type="text" class="form-control" value="{{$employee->first_name}}"  name="first_name">
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="input-block mb-3">
                                          <label class="col-form-label">Last Name</label>
                                          <input type="text" class="form-control" value="{{$employee->last_name}}"  name="last_name">
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="input-block mb-3">
                                          <label class="col-form-label">Birth Date</label>
                                          <div class="cal-icon">
                                             <input class="form-control datetimepicker" type="text" @if($employee->date_of_birth) value="{{date('d/m/Y',strtotime($employee->date_of_birth))}}" @endif name="date_of_birth">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="input-block mb-3">
                                          <label class="col-form-label">Gender</label>
                                          <select class="select form-control" name="gender">
                                             <option value="male" {{$employee->gender=='male'?'selected':''}}>Male</option>
                                             <option value="female" {{$employee->gender=='female'?'selected':''}}>Female</option>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Address</label>
                                    <input type="text" class="form-control" value="{{$employee->address}}" name="address">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">State</label>
                                    <input type="text" class="form-control" value="{{$employee->state}}" name="state">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Country</label>
                                    <input type="text" class="form-control" value="{{$employee->country}}" name="country">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Pin Code</label>
                                    <input type="text" class="form-control" value="{{$employee->pin_code}}" name="pin_code">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Phone Number</label>
                                    <input type="text" class="form-control" value="{{$employee->phone}}" name="phone">
                                 </div>
                              </div>

                              <div class="col-md-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Reporting To </label>
                                    <select class="select" name="reporting_to" id="reporting_to">
                                       <option value="">Select</option>
                                       @foreach(get_employees() as $employee)
                                          @if($employee->team_leader)
                                          <option value="{{$employee->id}}">{{$employee->first_name.' '.$employee->last_name}}</option>
                                          @endif
                                       @endforeach
                                    </select>
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

@endsection