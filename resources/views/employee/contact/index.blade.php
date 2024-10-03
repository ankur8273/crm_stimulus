@extends('employee.layouts.app')
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
                        <h3 class="page-title">Contact</h3>
                        <ul class="breadcrumb">
                           <li class="breadcrumb-item"><a href="{{route('employee.dashboard')}}">Dashboard</a></li>
                           <li class="breadcrumb-item active">Contact</li>
                        </ul>
                     </div>
                     <div class="col-md-8 float-end ms-auto">
                        <div class="d-flex title-head">
                           <div class="view-icons">
                              <a href="{{route('employee.contact.list')}}" class="grid-view btn btn-link"><i class="las la-redo-alt"></i></a>
                              <a href="#" class="list-view btn btn-link" id="collapse-header"><i class="las la-expand-arrows-alt"></i></a>
                              <a href="javascript:void(0);" class="list-view btn btn-link" id="filter_search"><i class="las la-filter"></i></a>
                           </div>
                           <div class="form-sort">
                              <a href="javascript:void(0);" class="list-view btn btn-link" data-bs-toggle="modal" data-bs-target="#export"><i class="las la-file-export"></i>Export</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="filter-filelds" id="filter_inputs" @if($name||$email||$phone||$status) style="display: block;" @endif>
                  <form id="filter_form" method="get">
                     <div class="row filter-row">
                        <div class="col-xl-2">
                           <div class="input-block mb-3 form-focus">
                              <input type="text" class="form-control floating" name="name" value="{{$name}}">
                              <label class="focus-label">Contact Name</label>
                           </div>
                        </div>
                        <div class="col-xl-2">
                           <div class="input-block mb-3 form-focus">
                              <input type="text" class="form-control floating" name="email" value="{{$email}}">
                              <label class="focus-label">Email</label>
                           </div>
                        </div>
                        <div class="col-xl-2">
                           <div class="input-block mb-3 form-focus">
                              <input type="text" class="form-control floating" name="phone" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" pattern="[0-9]{10}" value="{{$phone}}">
                              <label class="focus-label">Phone Number</label>
                           </div>
                        </div>
                        <div class="col-xl-2">
                           <div class="input-block mb-3 form-focus focused">
                              <input type="text" class="form-control  date-range bookingrange" name="date" value="{{$date}}">
                              <label class="focus-label">From - To Date</label>
                           </div>
                        </div>
                        <div class="col-xl-2">
                           <div class="input-block mb-3 form-focus select-focus">
                              <select class="select floating" name="status">
                                 <option value="">--Select--</option>
                                 <option value="active" {{$status == 'active'?'selected':''}}>Active</option>
                                 <option value="inactive" {{$status == 'inactive'?'selected':''}}>InActive</option>
                              </select>
                              <label class="focus-label">Status</label>
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
                                 <th>Name</th>
                                 <th>Phone</th>
                                 <th>Email</th>
                                 <th>Location</th>
                                 <th>Reviews</th>
                                 <th>Owner</th>
                                 <th>Contact </th>
                                 <th>Status</th>
                                 <th class="text-end">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($contacts as $contact)
                              <tr>
                                 <td>
                                    <div class="set-star star-select">
                                       <i class="fa fa-star filled"></i>
                                    </div>
                                 </td>
                                 <td>
                                    <h2 class="table-avatar d-flex">
                                       <a @if(has_permission('Read-Contact')) href="{{route('employee.contact.details',$contact->id)}}" @endif class="avatar">
                                          @if($contact->image)
                                          <img src="{{asset('assets/img/contact/'.$contact->image)}}" alt="User Image">
                                          @else
                                          <img src="{{asset('assets/img/avatar/images-dummy.jpg')}}" alt="User Image">
                                          @endif
                                       </a>
                                       <a @if(has_permission('Read-Contact')) href="{{route('employee.contact.details',$contact->id)}}" @endif class="profile-split d-flex flex-column">{{$contact->first_name.' '.$contact->last_name}} <span>{{$contact->job_title}}</span></a>
                                    </h2>
                                 </td>
                                 <td>{{$contact->phone}}</td>
                                 <td>{{$contact->email}}</td>
                                 <td>{{$contact->city}}</td>
                                 <td>
                                    {{$contact->reviews}}
                                 </td>
                                 <td>{{$contact->user?($contact->user->first_name.' '.$contact->user->last_name):'--------'}}</td>
                                 <td>
                                    <ul class="social-links d-flex align-items-center">
                                       <li>
                                          <a href="mailto:{{$contact->email}}"><i class="la la-envelope"></i></a>
                                       </li>
                                       <li>
                                          <a href="tel:{{$contact->phone}}"><i class="la la-phone-volume"></i></a>
                                       </li>
                                       <!-- <li>
                                          <a href="#"><i class="lab la-facebook-messenger"></i></a>
                                       </li>
                                       <li>
                                          <a href="#"><i class="la la-skype"></i></a>
                                       </li>
                                       <li>
                                          <a href="#"><i class="la la-facebook "></i></a>
                                       </li> -->
                                    </ul>
                                 </td>
                                 <td>
                                    <div class="dropdown action-label">
                                       @if($contact->status==1)
                                       <a href="#" class="btn btn-white btn-sm badge-outline-success "> Active </a>
                                       @else
                                       <a href="#" class="btn btn-white btn-sm badge-outline-danger "> InActive </a>
                                       @endif
                                    </div>
                                 </td>
                                 <td class="text-end">
                                    <div class="dropdown dropdown-action">
                                       <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                       <div class="dropdown-menu dropdown-menu-right">
                                          @if(has_permission('Write-Contact'))
                                          <a class="dropdown-item" href="#" onclick="edit($(this))" data-data="{{json_encode($contact->toArray())}}" data-user_name="{{$contact->user?($contact->user->first_name.' '.$contact->user->last_name):''}}"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                          @endif
                                          @if(has_permission('Delete-Contact'))
                                          <a class="dropdown-item" href="javascript:void(0);" data-href="{{route('employee.contact.delete',$contact->id)}}" onclick="delete_contact($(this))"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                                          @endif
                                          @if(has_permission('Read-Contact'))
                                          <a class="dropdown-item" href="{{route('employee.contact.details',$contact->id)}}"><i class="fa-regular fa-eye"></i> Preview</a>
                                          <a class="dropdown-item" href="javascript:void(0);" data-href="{{route('employee.contact.add_note',$contact->id)}}" onclick="add_notes($(this))"><i class="la la-file-prescription"></i> Notes</a>
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
                        <form action="{{route('employee.contact.update')}}" method="post" enctype="multipart/form-data">
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
                     <form action="#" method="post" enctype="multipart/form-data" id="add_not_frm">
                        @csrf
                        <div class="input-block mb-3">
                           <label class="col-form-label">Title <span class="text-danger"> *</span></label>
                           <input class="form-control" type="text" name="title">
                           <input type="hidden" name="contact_id" value="">
                        </div>
                        <div class="input-block mb-3">
                           <label class="col-form-label">Note <span class="text-danger"> *</span></label>
                           <textarea class="form-control" rows="4" placeholder="Add text" name="note"></textarea>
                        </div>
                        <div class="input-block mb-3">
                           <label class="col-form-label">Attachment <span class="text-danger"> *</span></label>
                           <div class="drag-upload">
                              <input type="file" name="file">
                              <div class="img-upload">
                                 <i class="las la-file-import"></i>
                                 <p>Drag & Drop your files</p>
                              </div>
                           </div>
                        </div>
                       
                        <div class="col-lg-12 text-end form-wizard-button">
                           <button class="btn btn-primary" type="submit">Save Notes</button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      <div class="modal custom-modal fade" id="success_msg" role="dialog">
         <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
               <div class="modal-body">
                  <div class="success-message text-center">
                     <div class="success-popup-icon">
                        <i class="la la-user-shield"></i>
                     </div>
                     <h3>Contact Created Successfully!!!</h3>
                     <p>View the details of contact</p>
                     <div class="col-lg-12 text-center form-wizard-button">
                        <a href="#" class="button btn-lights" data-bs-dismiss="modal">Close</a>
                        <a href="contact-details.html" class="btn btn-primary">View Details</a>
                     </div>
                  </div>
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
     <!-- <script data-cfasync="false" src="{{asset('assets/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js')}}"></script> -->
     <script src="{{asset('assets/js/jquery-3.7.1.min.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
      <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
      <script src="{{asset('assets/js/jquery.slimscroll.min.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
      <script src="{{asset('assets/js/jquery.dataTables.min.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
      <script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
      <script src="{{asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
      <script src="{{asset('assets/js/moment.min.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
      <script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
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

            function delete_contact(el){
               $('#d-okay').attr("href", el.attr("data-href"));
               $('#delete_models').modal('show');
            }

            function add_notes(el){
               $('#add_not_frm').attr("action", el.attr("data-href"));
               $('#add_notes').modal('show');
            }

            function reset_f(){
                $('.feild-set').css("display", "none"); 
                $('#edit-first-field').css("display", "block"); 
                $('.f-li').removeClass('active');
                $('#f-li').addClass('active');
            }

            
      </script>

@endsection