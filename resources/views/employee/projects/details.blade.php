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
      <link rel="stylesheet" href="{{asset('assets/css/feather.css')}}">
      <link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
      <link rel="stylesheet" href="{{asset('assets/css/line-awesome.min.css')}}">
      <link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.min.css')}}">
      <link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}">
      <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
      <style type="text/css">
         .close-icon {
             position: absolute;
             cursor: pointer;
             font-size: 12px;
             background: #ff2f2f;
             width: 20px;
             height: 20px;
             border-radius: 50%;
             text-align: center;
             align-content: center;
             color: #ffffff;
             margin: 0 !important;
         }
      </style>
@endpush
@section('content')

         <div class="page-wrapper">
            <div class="content container-fluid">
               <div class="page-header">
                  <div class="row align-items-center">
                     <div class="col">
                        <h3 class="page-title">{{$project->name}}</h3>
                        <ul class="breadcrumb">
                           <li class="breadcrumb-item"><a href="{{route('employee.dashboard')}}">Dashboard</a></li>
                           <li class="breadcrumb-item active">Project</li>
                        </ul>
                     </div>
                     <div class="col-auto float-end ms-auto">
                        @if(has_permission('Write-Project'))
                        <a href="#" class="btn add-btn" href="javascript:void(0);" data-data="{{json_encode($project->toArray())}}" data-href="{{route('employee.project.update',$project->id)}}" onclick="edit_project($(this))"><i class="fa-solid fa-plus"></i> Edit Project</a>
                        @endif
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-lg-7 col-xl-8">
                     <div class="card">
                        <div class="card-body">
                           <div class="project-title">
                              <h5 class="card-title">{{$project->name}}</h5>
                              
                           </div>
                           <p>{{$project->note}}</p>
                        </div>
                     </div>
                     <div class="card">
                        <div class="card-body">
                           <h5 class="card-title m-b-20">Uploaded image files <button type="button" class="float-end btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#add_images"><i class="fa-solid fa-plus"></i> Add</button>
                              <button type="button" class="float-end btn btn-primary btn-sm edit" onclick="$('.img-edit').toggleClass('d-none');$('.Cancel').toggleClass('d-none');$(this).toggleClass('d-none');"><i class="fa-solid fa-pencil"></i> Edit</button>
                              <button type="button" class="float-end btn btn-primary btn-sm Cancel d-none" onclick="$('.img-edit').toggleClass('d-none');$('.edit').toggleClass('d-none');$(this).toggleClass('d-none');"><i class="fa-solid fa-cancel"></i> Cancel</button></h5>
                           <div class="row">
                              @if($project->images)
                              @foreach(json_decode($project->images) as $id=>$image)
                              <div class="col-md-3 col-sm-4 col-lg-4 col-xl-3">
                                 <div class="uploaded-box">
                                    <div class="uploaded-img">
                                       <img src="{{asset('assets/img/project/'.$image)}}" class="img-fluid" alt="Placeholder Image">
                                       <span class="close-icon img-edit d-none" title="Remove" data-href="{{route('employee.project.image_delete',$project->id)}}?id={{$id}}" onclick="delete_file($(this))">X</span>
                                    </div>
                                    <div class="uploaded-img-name">
                                       @php
                                        $img = explode('-',$image);
                                          unset($img[0]);
                                        $image = implode('-',$img);
                                       @endphp
                                       {{$image}} 
                                    </div>
                                 </div>
                              </div>
                              @endforeach
                              @endif
                           </div>
                        </div>
                     </div>
                     <div class="card">
                        <div class="card-body">
                           <h5 class="card-title m-b-20">Uploaded files <button type="button" class="float-end btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#add_files"><i class="fa-solid fa-plus"></i> Add</button></h5>
                           <ul class="files-list">
                              @if($project->files)
                              @foreach(json_decode($project->files) as $keyd=>$file)
                              <li>
                                 <div class="files-cont">
                                    <div class="file-type">
                                       <span class="files-icon"><i class="fa-regular fa-file-pdf"></i></span>
                                    </div>
                                    <div class="files-info">
                                       <span class="file-name text-ellipsis"><a href="#">
                                       @php
                                        $fl = explode('-',$file);
                                          unset($fl[0]);
                                        $fls = implode('-',$fl);
                                       @endphp
                                       {{$fls}} 
                                    </a></span>
                                       @if ($file && file_exists('assets/img/project/'.$file))
                                       <div class="file-size">Size: {{number_format((filesize('assets/img/project/'.$file)/1024), 2)}}KB</div>
                                       @endif
                                    </div>
                                    <ul class="files-action">
                                       <li class="dropdown dropdown-action">
                                          <a href="#" class="dropdown-toggle btn btn-link" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_horiz</i></a>
                                          <div class="dropdown-menu dropdown-menu-right">
                                             <a class="dropdown-item" href="{{asset('assets/img/project/'.$file)}}" download>Download</a>
                                             
                                             <a class="dropdown-item" href="javascript:void(0)" data-href="{{route('employee.project.file_delete',$project->id)}}?id={{$keyd}}" onclick="delete_file($(this))">Delete</a>
                                          </div>
                                       </li>
                                    </ul>
                                 </div>
                              </li>
                              @endforeach
                              @endif
                              
                           </ul>
                        </div>
                     </div>
                     
                  </div>
                  <div class="col-lg-5 col-xl-4">
                     <div class="card">
                        <div class="card-body">
                           <h6 class="card-title m-b-15">Project details</h6>
                           <table class="table table-striped table-border">
                              <tbody>
                                 
                                 <tr>
                                    <td>Property category:</td>
                                    <td class="text-end">{{$project->property_category}}</td>
                                 </tr>
                                 <tr>
                                    <td>Property Type:</td>
                                    <td class="text-end">{{$project->property_type}}</td>
                                 </tr>
                                 <tr>
                                    <td>Project Land Parcel:</td>
                                    <td class="text-end">{{$project->project_land_parcel}}</td>
                                 </tr>
                                 <tr>
                                    <td>Project Open Area:</td>
                                    <td class="text-end">{{$project->project_open_area}}</td>
                                 </tr>
                                 <tr>
                                    <td>No. Of Towers:</td>
                                    <td class="text-end">{{$project->no_of_towers}}</td>
                                 </tr>

                                 <tr>
                                    <td>Inventory Per Floor:</td>
                                    <td class="text-end">{{$project->inventory_per_floor}}</td>
                                 </tr>
                                 <tr>
                                    <td>Carpet Area Range:</td>
                                    <td class="text-end">{{$project->carpet_area_range}}</td>
                                 </tr>
                                 <tr>
                                    <td>Costing Range:</td>
                                    <td class="text-end">{{$project->costing_range}}</td>
                                 </tr>
                                 <tr>
                                    <td>Contact Person:</td>
                                    <td class="text-end">{{$project->contact_person}}</td>
                                 </tr>
                                 <tr>
                                    <td>Spokes Person Contact:</td>
                                    <td class="text-end">{{$project->spokes_person_Contact}}</td>
                                 </tr>
                                 <tr>
                                    <td>Customer Project Kit:</td>
                                    <td class="text-end">{{$project->customer_project_kit}}</td>
                                 </tr>
                                 <tr>
                                    <td>Office Project Kit:</td>
                                    <td class="text-end">{{$project->office_project_kit}}</td>
                                 </tr>
                                 <tr>
                                    <td>Developed By:</td>
                                    <td class="text-end">{{$project->developed_by}}</td>
                                 </tr>
                                 
                                 <tr>
                                    <td>Created by:</td>
                                    <td class="text-end"><a href="profile.html">Barry Cuda</a></td>
                                 </tr>
                                 <tr>
                                    <td>Status:</td>
                                    @if($project->status == 1)
                                    <td class="text-end">Active</td>
                                    @else
                                    <td class="text-end">Inactive</td>
                                    @endif
                                 </tr>
                              </tbody>
                           </table>
                           
                        </div>
                     </div>
                     <div class="card project-user">
                        <div class="card-body">
                           <h6 class="card-title m-b-20">Assigned USer @if(has_permission('Write-Project')) <button type="button" class="float-end btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#assign_leader"><i class="fa-solid fa-plus"></i> Add/Change</button> @endif </h6>
                           <ul class="list-box">
                              <li>
                                 <a href="profile.html">
                                    <div class="list-item">
                                       <div class="list-left">
                                          <span class="avatar">
                                             @if($project->user && $project->user->image)
                                             <img src="{{asset('assets/img/employee/'.$project->user->image)}}" alt="User Image">
                                             @else
                                             <img src="{{asset('assets/img/avatar/images-dummy.jpg')}}" alt="User Image">
                                             @endif
                                          </span>
                                       </div>
                                       <div class="list-body">
                                          <span class="message-author">{{ $project->user?($project->user->first_name.' '.$project->user->last_name):''}}</span>
                                          <div class="clearfix"></div>
                                          <span class="message-content">{{ $project->user?($project->user->designation->name):''}}</span>
                                       </div>
                                    </div>
                                 </a>
                              </li>
                           </ul>
                        </div>
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
                        <form action="{{route('employee.project.add_files',$project->id)}}" method="post" enctype="multipart/form-data">
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
                        <form action="{{route('employee.project.add_images',$project->id)}}" method="post" enctype="multipart/form-data">
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

            <div id="assign_leader" class="modal custom-modal fade" role="dialog">
               <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title">Assign Leader to this project</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <form action="{{route('employee.project.add_user',$project->id)}}" method="post" enctype="multipart/form-data">
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
            <div id="assign_user" class="modal custom-modal fade" role="dialog">
               <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title">Assign the user to this project</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">
                        <div class="input-group m-b-30">
                           <input placeholder="Search a user to assign" class="form-control search-input" type="text">
                           <button class="btn btn-primary">Search</button>
                        </div>
                        <div>
                           <ul class="chat-user-list">
                              <li>
                                 <a href="#">
                                    <div class="chat-block d-flex">
                                       <span class="avatar"><img src="assets/img/profiles/avatar-09.jpg" alt="User Image"></span>
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
                                       <span class="avatar"><img src="assets/img/profiles/avatar-10.jpg" alt="User Image"></span>
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
                                       <img src="assets/img/profiles/avatar-16.jpg" alt="User Image">
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
                           <button class="btn btn-primary submit-btn">Submit</button>
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
                        <form action="{{route('employee.project.update')}}" method="post" enctype="multipart/form-data">
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
                        <div class="form-header">
                           <h3>Remove File</h3>
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
         function edit_project(el){
               var data = $.parseJSON(el.attr("data-data"));
               
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

            function reset_f(){
                $('.feild-set').css("display", "none"); 
                $('#edit-first-field').css("display", "block"); 
                $('.f-li').removeClass('active');
                $('#f-li').addClass('active');
            }

            function delete_file(el){
               $('#d-okay').attr("href", el.attr("data-href"));
               $('#delete_models').modal('show');
            }
      </script>
@endsection