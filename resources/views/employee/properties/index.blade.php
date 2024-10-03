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
      <!-- <link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.min.css')}}"> -->
      <link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}">
      <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
@endpush
@section('content')

         <div class="page-wrapper">
            <div class="content container-fluid">
               <div class="page-header">
                  <div class="row align-items-center">
                     <div class="col">
                        <h3 class="page-title">Properties</h3>
                        <ul class="breadcrumb">
                           <li class="breadcrumb-item"><a href="{{route('employee.dashboard')}}">Dashboard</a></li>
                           <li class="breadcrumb-item active">Properties</li>
                        </ul>
                     </div>
                     <div class="col-auto float-end ms-auto">
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#create_project"><i class="fa-solid fa-plus"></i> Create Property</a>
                        <div class="view-icons">
                           <a href="{{route('employee.properties.list')}}" class="grid-view btn btn-link"><i class="las la-redo-alt"></i></a>
                           <!-- <a href="projects.html" class="grid-view btn btn-link"><i class="fa fa-th"></i></a> -->
                           <!-- <a href="project-list.html" class="list-view btn btn-link active"><i class="fa-solid fa-bars"></i></a> -->
                        </div>
                     </div>
                  </div>
               </div>
               
               <form id="filter_form" method="get">
                  <div class="row filter-row">
                     <div class="col-sm-6 col-md-3">
                        <div class="input-block mb-3 form-focus">
                           <input type="text" class="form-control floating" name="name" value="{{$name}}">
                           <label class="focus-label">Property Name</label>
                        </div>
                     </div>
                     <!-- <div class="col-sm-6 col-md-3">
                        <div class="input-block mb-3 form-focus">
                           <input type="text" class="form-control floating">
                           <label class="focus-label">Employee Name</label>
                        </div>
                     </div> -->
                     <div class="col-xl-3">
                        <div class="input-block mb-3 form-focus focused">
                           <input type="text" class="form-control  date-range bookingrange" name="date" value="{{$date}}">
                           <label class="focus-label">From - To Date</label>
                        </div>
                     </div>
                     <div class="col-sm-6 col-md-3">
                        <div class="input-block mb-3 form-focus select-focus">
                           <select class="select floating" name="status">
                              <option value="">--Select--</option>
                              <option value="active" {{$status == 'active'?'selected':''}}>Active</option>
                              <option value="inactive" {{$status == 'inactive'?'selected':''}}>InActive</option>
                           </select>
                           <label class="focus-label">Status</label>
                        </div>
                     </div>
                     <div class="col-sm-6 col-md-3">
                        <button href="#" class="btn btn-success w-100" onclick="$('#filter_form').submit();"> Search </button>
                     </div>
                  </div>
               </form>
               <div class="row">
                  <div class="col-md-12">
                     <div class="table-responsive">
                        <table class="table table-striped custom-table datatable">
                           <thead>
                              <tr>
                                 <th>Property</th>
                                 <th>City</th>
                                 <th>Project</th>
                                 <th>Created</th>
                                 <th>Status</th>
                                 <th class="text-end">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($properties as $property)
                              <tr>
                                 <td>
                                    <a href="{{route('employee.properties.details',$property->id)}}">{{$property->name}}</a>
                                 </td>
                                 <td>{{$property->city}}</td>
                                 <td>
                                    <ul class="team-members">
                                       <li>
                                          
                                          <span>{{ $property->project?($property->project->name):''}}</span>
                                       </li>
                                    </ul>
                                 </td>
                                 
                                 <td>{{date('d M Y',strtotime($property->created_at))}} </td>
                                
                                 <td>
                                    <div class="dropdown action-label">
                                       <a href="#" class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-regular fa-circle-dot text-{{$property->status==1?'success':'danger'}}"></i> {{$property->status==1?'Active':'Inactive' }}</a>
                                       <div class="dropdown-menu">
                                          <a class="dropdown-item" href="{{route('employee.properties.change_status',$property->id)}}?status=1"><i class="fa-regular fa-circle-dot text-success"></i> Active</a>
                                          <a class="dropdown-item" href="{{route('employee.properties.change_status',$property->id)}}?status=0"><i class="fa-regular fa-circle-dot text-danger"></i> Inactive</a>
                                       </div>
                                    </div>
                                 </td>
                                 <td class="text-end">
                                    <div class="dropdown dropdown-action">
                                       <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                       <div class="dropdown-menu dropdown-menu-right">
                                          <a class="dropdown-item" href="javascript:void(0);" data-data="{{json_encode($property->toArray())}}" data-href="{{route('employee.properties.update',$property->id)}}" onclick="edit_property($(this))"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
                                          <a class="dropdown-item" href="{{route('employee.properties.details',$property->id)}}"><i class="fa-regular fa-eye"></i> Preview</a>
                                          <a class="dropdown-item" href="javascript:void(0);" data-href="{{route('employee.properties.delete',$property->id)}}" onclick="delete_m($(this))"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
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
      
      
            <div id="create_project" class="modal custom-modal fade" role="dialog">
               <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title">Create Property</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">
                        <form action="{{route('employee.properties.store')}}" method="post" enctype="multipart/form-data" id="propertyForm">
                           @csrf
                           <h5 class="modal-title">Property Info</h5>
                           <hr>
                           <div class="row">
                               
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Project</label>
                                    <select class="select" name="project" required>
                                        @foreach(get_projects() as $project)
                                            <option value="{{$project->id}}">{{$project->name}}</option>
                                        @endforeach
                                    </select>
                                 </div>
                              </div>

                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Property Name</label>
                                    <input class="form-control" type="text" name="property_name" required>
									<small class="error-message text-danger"></small>
                                 </div>
                              </div>
                              
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">City</label>
                                    <input class="form-control" type="text" name="city" required>
									<small class="error-message text-danger"></small>
                                 </div>
                              </div>
                           </div>
                           <h5 class="modal-title">Basic Info</h5>
                           <hr>
                           <div class="row">
                               <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Property category</label>
                                    <select class="select" name="property_category" required>
                                       <option>Resdential</option>
                                       <option>Commercial</option>
                                    </select>
									<small class="error-message text-danger"></small>
                                 </div>
                              </div>
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Property Type</label>
                                    <select class="select" name="property_type" required>
                                       <option>Apartment</option>
                                       <option>Independent House/ Villa</option>
                                       <option>Independent Builder Floor</option>
                                       <option>Studio Apartment</option>
                                       <option>Serviced Apartment</option>
                                       <option>Farm House</option>
                                       <option>Residential Plot</option>
                                       <option>Office</option>
                                       <option>Retail</option>
                                       <option>Commercial Land</option>
                                       <option>Industrial Land</option>
                                       <option>Showroom</option>
                                       <option>Warehouse</option>
                                    </select>
									<small class="error-message text-danger"></small>
                                 </div>
                              </div>
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Unit Type</label>
                                    <select class="select" name="unit_type" required>
                                       <option>1 BHK</option>
                                       <option>2 BHK</option>
                                       <option>3 BHK</option>
                                       <option>4 BHK</option>
                                       <option>3 plus 1 BHK</option>
                                    </select>
									<small class="error-message text-danger"></small>
                                 </div>
                              </div>
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Unit No</label>
                                    <input class="form-control" type="number" name="unit_no" required>
									<small class="error-message text-danger"></small>
                                 </div>
                              </div>

                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Furnishing</label>
                                    <select class="select" name="furnishing" >
                                       <option>Furnished</option>
                                       <option>Semi-furnished</option>
                                       <option>Unfurnished</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Availability</label>
                                    <select class="select" name="availability" >
                                       <option>Immediate</option>
                                       <option>Within 6 Months</option>
                                       <option>Within 1 Year</option>
                                       <option>Within 2 Year</option>
                                    </select>
                                 </div>
                              </div>
                              
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Covered Parking</label>
                                    <select class="select" name="covered_parking" >
                                       <option>1</option>
                                       <option>2</option>
                                       <option>3</option>
                                       <option>4</option>
                                       <option>5</option>
                                    </select>
                                 </div>
                              </div>
                              
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Open Parking  </label>
                                    <select class="select" name="open_parking" >
                                       <option>1</option>
                                       <option>2</option>
                                       <option>3</option>
                                       <option>4</option>
                                       <option>5</option>
                                    </select>
                                 </div>
                              </div>
                              
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Bathrooms  </label>
                                    <select class="select" name="bathrooms" >
                                       <option>1</option>
                                       <option>2</option>
                                       <option>3</option>
                                       <option>4</option>
                                       <option>5</option>
                                    </select>
                                 </div>
                              </div>
                              
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Ownership  </label>
                                    <select class="select" name="ownership" >
                                       <option>Freehold</option>
                                       <option>Leasehold</option>
                                       <option>Co-operative Society</option>
                                       <option>Co-operative Society</option>
                                       <option>Power of Attorney</option>
                                    </select>
                                 </div>
                              </div>
                              
                           </div>
                           <div class="row">
                              <div class="col-sm-12">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Other Details</label>
                                    <textarea class="form-control" name="other_details"></textarea>
                                 </div>
                              </div>
                           </div>
                            <h5 class="modal-title">Dimensions</h5>
                           <hr>
                           <div class="row">
                              <div class="col-sm-4">
                                    <label class="col-form-label">Buildup Area</label>
                                    <div class="row">
                                       <select class="select col-sm-4" name="buildup_area_dimensions">
                                           <option>Sq. Yds</option>
                                           <option>Sq. Ft</option>
                                           <option>Sq. Mt</option>
                                        </select>
                                        <input class="form-control col-sm-8" type="text" name="buildup_area"> 
                                    </div>
                              </div>
                              
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Carpet Area</label>
                                    <div class="row">
                                       <select class="select col-sm-4" name="carpet_area_dimensions">
                                           <option>Sq. Yds</option>
                                           <option>Sq. Ft</option>
                                           <option>Sq. Mt</option>
                                        </select>
                                        <input class="form-control col-sm-8" type="text" name="carpet_area"> 
                                    </div>
                                 </div>
                              </div>
                              
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Super Area</label>
                                    <div class="row">
                                       <select class="select col-sm-4" name="super_area_dimensions">
                                           <option>Sq. Yds</option>
                                           <option>Sq. Ft</option>
                                           <option>Sq. Mt</option>
                                        </select>
                                        <input class="form-control col-sm-8" type="text" name="super_area"> 
                                    </div>
                                 </div>
                              </div>
                              
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Length</label>
                                    <div class="row">
                                       <select class="select col-sm-4" name="length_dimensions">
                                           <option>yds</option>
                                           <option>ft</option>
                                           <option>mts</option>
                                        </select>
                                        <input class="form-control col-sm-8" type="text" name="length"> 
                                    </div>
                                 </div>
                              </div>
                              
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Breadth</label>
                                    <div class="row">
                                       <select class="select col-sm-4" name="breadth_dimensions">
                                           <option>yds</option>
                                           <option>ft</option>
                                           <option>mts</option>
                                        </select>
                                        <input class="form-control col-sm-8" type="text" name="breadth"> 
                                    </div>
                                 </div>
                              </div>
                              
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Plot Area</label>
                                    <div class="row">
                                       <select class="select col-sm-4" name="plot_area_dimensions">
                                           <option>Sq. Yds</option>
                                           <option>Sq. Ft</option>
                                           <option>Sq. Mt</option>
                                        </select>
                                        <input class="form-control col-sm-8" type="text" name="plot_area"> 
                                    </div>
                                 </div>
                              </div>
                              
                              
                           </div>
                           <h5 class="modal-title">Pricing</h5>
                           <hr>
                           <div class="row">
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Expected Pricing</label>
                                    <div class="row">
                                       <select class="select col-sm-4" name="expecte_pricing">
                                           <option>per Sq. Yd</option>
                                           <option>per Sq. Ft</option>
                                           <option>per Sq. Mt</option>
                                           <option>per Sq. Mt</option>
                                           <option>per Unit</option>
                                        </select>
                                        <input class="form-control col-sm-8" type="text" name="project_open_area"> 
                                    </div>
                                 </div>
                              </div>

                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Price Negotiable  </label>
                                    <select class="select" name="price_negotiable" >
                                       <option>No</option>
                                       <option>Yes</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           
                             <h5 class="modal-title">Seller Details</h5>
                           <hr>
                           <div class="row">
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Seller Type </label>
                                    <select class="select" name="seller_type" >
                                       <option>Broker</option>
                                       <option>Owner</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Seller Name </label>
                                    <input class="form-control" type="text" name="seller_name">
                                 </div>
                              </div>

                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Mobile</label>
                                    <input class="form-control" type="text" name="seller_mobile" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" pattern="[0-9]{10}" title="Mobile number must be 10 digits">
                                 </div>
                              </div>
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Alt Number</label>
                                    <input class="form-control" type="text" name="seller_alt_mobile" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" pattern="[0-9]{10}" title="Mobile number must be 10 digits">
                                 </div>
                              </div>
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Email</label>
                                    <input class="form-control" type="text" name="seller_email">
                                 </div>
                              </div>
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Address</label>
                                    <input class="form-control" type="text" name="seller_address">
                                 </div>
                              </div>
							  <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Add Property Leader</label>
                                    <select class="select" name="user_id">
                                       <option value="">Select</option>
                                       @foreach(get_employees() as $employee)
                                       <option value="{{$employee->id}}">{{$employee->first_name.' '.$employee->last_name}}</option>
                                       @endforeach
                                    </select>
                                 </div>
                              </div>
                           </div>
                           
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="input-block mb-3">
                                    <h5 class="mb-3">Status</h5>
                                    <div class="status-radio-btns d-flex">
                                       <div class="people-status-radio">
                                          <input type="radio" class="status-radio" id="tests6" name="project_status" value="1" checked>
                                          <label for="tests6">Active</label>
                                       </div>
                                       <div class="people-status-radio">
                                          <input type="radio" class="status-radio" id="tests7" name="project_status" value="0">
                                          <label for="tests7">Inactive</label>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           
                           <div class="submit-section">
                              <button class="btn btn-primary submit-btn" id="submitButton">Submit</button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            <div id="edit_property" class="modal custom-modal fade" role="dialog">
               <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title">Edit Properties</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">
                        <form action="{{route('employee.properties.update')}}" method="post" enctype="multipart/form-data">
                           @csrf
                           <h5 class="modal-title">Property Info</h5>
                           <hr>
                           <div class="row">
                               
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Project</label>
                                    <select class="select" name="project" id="project" required>
                                        @foreach(get_projects() as $project)
                                            <option value="{{$project->id}}">{{$project->name}}</option>
                                        @endforeach
                                    </select>
                                 </div>
                              </div>

                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
								 <input class="form-control" type="hidden" name="id" id="property_id" required>
                                    <label class="col-form-label">Property Name</label>
                                    <input class="form-control" type="text" name="property_name" id="property_name" required>
                                 </div>
                              </div>
                              
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">City</label>
                                    <input class="form-control" type="text" name="city" id="city" required>
                                 </div>
                              </div>
                           </div>
                           <h5 class="modal-title">Basic Info</h5>
                           <hr>
                           <div class="row">
                               <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Property category</label>
                                    <select class="select" name="property_category" id="property_category" required>
                                       <option>Resdential</option>
                                       <option>Commercial</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Property Type</label>
                                    <select class="select" name="property_type" id="property_type" required>
                                       <option>Apartment</option>
                                       <option>Independent House/ Villa</option>
                                       <option>Independent Builder Floor</option>
                                       <option>Studio Apartment</option>
                                       <option>Serviced Apartment</option>
                                       <option>Farm House</option>
                                       <option>Residential Plot</option>
                                       <option>Office</option>
                                       <option>Retail</option>
                                       <option>Commercial Land</option>
                                       <option>Industrial Land</option>
                                       <option>Showroom</option>
                                       <option>Warehouse</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Unit Type</label>
                                    <select class="select" name="unit_type" id="unit_type" required>
                                       <option>1 BHK</option>
                                       <option>2 BHK</option>
                                       <option>3 BHK</option>
                                       <option>4 BHK</option>
                                       <option>3 plus 1 BHK</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Unit No</label>
                                    <input class="form-control" type="number" name="unit_no" id="unit_no" required>
                                 </div>
                              </div>

                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Furnishing</label>
                                    <select class="select" name="furnishing" id="furnishing" >
                                       <option>Furnished</option>
                                       <option>Semi-furnished</option>
                                       <option>Unfurnished</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Availability</label>
                                    <select class="select" name="availability" id="availability" >
                                       <option>Immediate</option>
                                       <option>Within 6 Months</option>
                                       <option>Within 1 Year</option>
                                       <option>Within 2 Year</option>
                                    </select>
                                 </div>
                              </div>
                              
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Covered Parking</label>
                                    <select class="select" name="covered_parking" id="covered_parking" >
                                       <option>1</option>
                                       <option>2</option>
                                       <option>3</option>
                                       <option>4</option>
                                       <option>5</option>
                                    </select>
                                 </div>
                              </div>
                              
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Open Parking  </label>
                                    <select class="select" name="open_parking" id="open_parking" >
                                       <option>1</option>
                                       <option>2</option>
                                       <option>3</option>
                                       <option>4</option>
                                       <option>5</option>
                                    </select>
                                 </div>
                              </div>
                              
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Bathrooms  </label>
                                    <select class="select" name="bathrooms" id="bathrooms" >
                                       <option>1</option>
                                       <option>2</option>
                                       <option>3</option>
                                       <option>4</option>
                                       <option>5</option>
                                    </select>
                                 </div>
                              </div>
                              
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Ownership  </label>
                                    <select class="select" name="ownership" id="ownership" >
                                       <option>Freehold</option>
                                       <option>Leasehold</option>
                                       <option>Co-operative Society</option>
                                       <option>Co-operative Society</option>
                                       <option>Power of Attorney</option>
                                    </select>
                                 </div>
                              </div>
                              
                           </div>
                           <div class="row">
                              <div class="col-sm-12">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Other Details</label>
                                    <textarea class="form-control" name="other_details" id="other_details"></textarea>
                                 </div>
                              </div>
                           </div>
                            <h5 class="modal-title">Dimensions</h5>
                           <hr>
                           <div class="row">
                              <div class="col-sm-4">
                                    <label class="col-form-label">Buildup Area</label>
                                    <div class="row">
                                       <select class="select col-sm-4" name="buildup_area_dimensions" id="buildup_area_dimensions">
                                           <option>Sq. Yds</option>
                                           <option>Sq. Ft</option>
                                           <option>Sq. Mt</option>
                                        </select>
                                        <input class="form-control col-sm-8" type="text" name="buildup_area" id="buildup_area"> 
                                    </div>
                              </div>
                              
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Carpet Area</label>
                                    <div class="row">
                                       <select class="select col-sm-4" name="carpet_area_dimensions" id="carpet_area_dimensions">
                                           <option>Sq. Yds</option>
                                           <option>Sq. Ft</option>
                                           <option>Sq. Mt</option>
                                        </select>
                                        <input class="form-control col-sm-8" type="text" name="carpet_area" id="carpet_area"> 
                                    </div>
                                 </div>
                              </div>
                              
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Super Area</label>
                                    <div class="row">
                                       <select class="select col-sm-4" name="super_area_dimensions" id="super_area_dimensions">
                                           <option>Sq. Yds</option>
                                           <option>Sq. Ft</option>
                                           <option>Sq. Mt</option>
                                        </select>
                                        <input class="form-control col-sm-8" type="text" name="super_area" id="super_area"> 
                                    </div>
                                 </div>
                              </div>
                              
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Length</label>
                                    <div class="row">
                                       <select class="select col-sm-4" name="length_dimensions" id="length_dimensions">
                                           <option>yds</option>
                                           <option>ft</option>
                                           <option>mts</option>
                                        </select>
                                        <input class="form-control col-sm-8" type="text" name="length" id="length"> 
                                    </div>
                                 </div>
                              </div>
                              
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Breadth</label>
                                    <div class="row">
                                       <select class="select col-sm-4" name="breadth_dimensions" id="breadth_dimensions">
                                           <option>yds</option>
                                           <option>ft</option>
                                           <option>mts</option>
                                        </select>
                                        <input class="form-control col-sm-8" type="text" name="breadth" id="breadth"> 
                                    </div>
                                 </div>
                              </div>
                              
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Plot Area</label>
                                    <div class="row">
                                       <select class="select col-sm-4" name="plot_area_dimensions" id="plot_area_dimensions">
                                           <option>Sq. Yds</option>
                                           <option>Sq. Ft</option>
                                           <option>Sq. Mt</option>
                                        </select>
                                        <input class="form-control col-sm-8" type="text" name="plot_area" id="plot_area"> 
                                    </div>
                                 </div>
                              </div>
                              
                              
                           </div>
                           <h5 class="modal-title">Pricing</h5>
                           <hr>
                           <div class="row">
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Expected Pricing</label>
                                    <div class="row">
                                       <select class="select col-sm-4" name="expecte_pricing" id="expecte_pricing">
                                           <option>per Sq. Yd</option>
                                           <option>per Sq. Ft</option>
                                           <option>per Sq. Mt</option>
                                           <option>per Sq. Mt</option>
                                           <option>per Unit</option>
                                        </select>
                                        <input class="form-control col-sm-8" type="text" name="project_open_area" id="project_open_area"> 
                                    </div>
                                 </div>
                              </div>

                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Price Negotiable  </label>
                                    <select class="select" name="price_negotiable"  id="price_negotiable" >
                                       <option>No</option>
                                       <option>Yes</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           
                             <h5 class="modal-title">Seller Details</h5>
                           <hr>
                           <div class="row">
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Seller Type </label>
                                    <select class="select" name="seller_type"  id="seller_type" >
                                       <option>Broker</option>
                                       <option>Owner</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Seller Name </label>
                                    <input class="form-control" type="text" name="seller_name" id="seller_name">
                                 </div>
                              </div>

                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Mobile</label>
                                    <input class="form-control" type="text" name="seller_mobile" id="seller_mobile" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" pattern="[0-9]{10}" title="Mobile number must be 10 digits">
                                 </div>
                              </div>
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Alt Number</label>
                                    <input class="form-control" type="text" name="seller_alt_mobile" id="seller_alt_mobile" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" pattern="[0-9]{10}" title="Mobile number must be 10 digits">
                                 </div>
                              </div>
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Email</label>
                                    <input class="form-control" type="text" name="seller_email" id="seller_email">
                                 </div>
                              </div>
                              <div class="col-sm-4">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Address</label>
                                    <input class="form-control" type="text" name="seller_address" id="seller_address">
                                 </div>
                              </div>
                           </div>
                           
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="input-block mb-3">
                                    <h5 class="mb-3">Status</h5>
                                    <div class="status-radio-btns d-flex">
                                       <div class="people-status-radio">
                                          <input type="radio" class="status-radio" id="tests6-1" name="project_status" value="1">
                                          <label for="tests6-1">Active</label>
                                       </div>
                                       <div class="people-status-radio">
                                          <input type="radio" class="status-radio" id="tests7-0" name="project_status" value="0">
                                          <label for="tests7-0">Inactive</label>
                                       </div>
                                    </div>
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
            <div class="modal custom-modal fade" id="delete" role="dialog">
               <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                     <div class="modal-body">
                        <div class="form-header">
                           <h3>Delete Project</h3>
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

         function edit_property(el){
               var data = $.parseJSON(el.attr("data-data"));
               
               $('#property_name').val(data.name);
			   $('#property_id').val(data.id);
               $('#city').val(data.city);
               $('#project').val(data.project_id).change();
               $('#property_category').val(data.property_category).change();
               $('#property_type').val(data.property_type).change();
               $('#unit_type').val(data.unit_type).change();
               $('#furnishing').val(data.furnishing).change();
               $('#availability').val(data.availability).change();
               $('#covered_parking').val(data.covered_parking).change();
               $('#open_parking').val(data.open_parking).change();
               $('#bathrooms').val(data.bathrooms).change();
               $('#ownership').val(data.ownership).change();
               $('#buildup_area_dimensions').val(data.buildup_area_dimensions).change();
               $('#super_area_dimensions').val(data.super_area_dimensions).change();
               $('#length_dimensions').val(data.length_dimensions).change();
               $('#breadth_dimensions').val(data.breadth_dimensions).change();
               $('#plot_area_dimensions').val(data.plot_area_dimensions).change();
               $('#expecte_pricing').val(data.expecte_pricing).change();
               $('#price_negotiable').val(data.price_negotiable).change();
               $('#seller_type').val(data.seller_type).change();
               $('#unit_no').val(data.unit_no);
               $('#other_details').val(data.other_details);
               $('#buildup_area').val(data.buildup_area);
               $('#super_area').val(data.super_area);
               $('#length').val(data.lengths);
               $('#breadth').val(data.breadth);
               $('#plot_area').val(data.plot_area);
               $('#project_open_area').val(data.project_open_area);
               $('#seller_name').val(data.seller_name);
               $('#seller_mobile').val(data.seller_mobile);
               $('#seller_alt_mobile').val(data.seller_alt_mobile);
               $('#seller_email').val(data.seller_email);
               $('#seller_address').val(data.seller_address);
               
               if(data.status == 1){
                  $('#tests6-1').prop("checked", true);
               }else{
                  $('#tests7-0').prop("checked", true);
               }


               $('#edit_property').modal('show');
            }

            function delete_m(el){
               $('#d-okay').attr("href", el.attr("data-href"));
               $('#delete').modal('show');
            }

      </script>

<script>
	document.addEventListener("DOMContentLoaded", function () {

		function validateForm(form_id_name) {
			const form = document.getElementById(form_id_name);
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



			return isValid;
		}


		// Attach click event to the submit button
		const submitButton = document.getElementById('submitButton');
		if (submitButton) {
			submitButton.addEventListener('click', function (event) {
				event.preventDefault();
				if (validateForm('propertyForm')) {
					document.getElementById('propertyForm').submit(); // Submit form if valid
				}
			});
		}
		const edtSubmitButton = document.getElementById('editsubmitButton');
		if (edtSubmitButton) {
			edtSubmitButton.addEventListener('click', function (event) {

				event.preventDefault();
				if (validateForm('editprojectForm')) {

					document.getElementById('editprojectForm').submit(); // Submit form if valid
				}
			});
		}
	});

</script>

@endsection