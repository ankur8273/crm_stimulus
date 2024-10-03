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
      <link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.min.css')}}">
      <link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}">
      <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
      <style type="text/css">
         a.edit-icon.icon-shed {
             padding-left: 0px !important;
         }
      </style>
@endpush
@section('content')

         <div class="page-wrapper">
            <div class="content container-fluid pb-0">
               <div class="page-header">
                  <div class="row align-items-center">
                     <div class="col">
                        <h3 class="page-title">Knowledgebase</h3>
                        <ul class="breadcrumb">
                           <li class="breadcrumb-item"><a href="{{route('employee.dashboard')}}">Dashboard</a></li>
                           <li class="breadcrumb-item active">Knowledgebase</li>
                        </ul>
                     </div>
                     <div class="col-auto float-end ms-auto">
                        @if(has_permission('Create-Knowledgebase'))
                        <a href="{{route('employee.knowledgebase.create')}}" class="btn add-btn" ><i class="fa-solid fa-plus"></i> Add new</a>
                        <a href="{{route('employee.knowledgebase.category')}}" class="btn add-btn" ><i class="fa-solid fa-plus"></i> Add Category</a>
                        @endif
                        <div class="view-icons">
                           <!-- <a href="#" class="grid-view btn btn-link"><i class="fa fa-th"></i></a> -->
                           <!-- <a href="#" class="list-view btn btn-link active"><i class="fa-solid fa-bars"></i></a> -->
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  @foreach($categories as $key=>$cat)
                  <div class="col-xl-4 col-md-6 col-sm-6">
                     <div class="topics">
                        <h3 class="topic-title"><a href="#"><i class="fa-regular fa-folder"></i> {{$key}} <span>{{count($cat)}}</span></a></h3>
                        <ul class="topics-list">
                           @foreach($cat as $topic)
                           <li>
                              <div class="pro-edit">
                                 @if(has_permission('Write-Knowledgebase'))
                                 <a  class="edit-icon icon-shed" href="{{route('employee.knowledgebase.edit',$topic->id)}}"><i class="fa-solid fa-pencil"></i></a>
                                 @endif
                                 @if(has_permission('Delete-Knowledgebase'))
                                 <a  class="edit-icon icon-shed" data-href="{{route('employee.knowledgebase.delete',$topic->id)}}" onclick="delete_m($(this))"><i class="fa-solid fa-trash"></i></a>
                                 @endif
                              </div>
                              <a href="{{route('employee.knowledgebase.details',$topic->id)}}"> {{$topic->title}} </a>
                           </li>
                           @endforeach
                        </ul>
                     </div>
                  </div>
                  @endforeach
               </div>
            </div>
         </div>
@endsection
@section('modal')
      
            <div class="modal custom-modal fade" id="delete" role="dialog">
               <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                     <div class="modal-body">
                        <div class="form-header">
                           <h3>Delete Artical</h3>
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
            <div id="add_new" class="modal custom-modal fade" role="dialog">
               <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title">Add</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">
                        <form action="{{route('employee.knowledgebase.store')}}" method="post" enctype="multipart/form-data">
                           @csrf
                           <div class="row">
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Title</label>
                                    <input class="form-control" type="text" name="subject" required>
                                 </div>
                              </div>
                              <div class="col-sm-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Priority</label>
                                    <select class="select" name="priority" required>
                                       <option>High</option>
                                       <option>Medium</option>
                                       <option>Low</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           
                           <div class="row">
                              <div class="col-sm-12">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Details</label>
                                    <textarea class="form-control summernote" name="setails " required></textarea>
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
      <script src="{{asset('assets/plugins/summernote/summernote-bs4.min.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
      <script src="{{asset('assets/js/layout.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
      <!-- <script src="{{asset('assets/js/theme-settings.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script> -->
      <!-- <script src="{{asset('assets/js/greedynav.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script> -->
      <script src="{{asset('assets/js/app.js')}}" type="264280a78fcfef3abf43a170-text/javascript"></script>
      <script src="{{asset('assets/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js')}}" data-cf-settings="264280a78fcfef3abf43a170-|49" defer></script>

      <script type="text/javascript"> 

        
            function delete_m(el){
               $('#d-okay').attr("href", el.attr("data-href"));
               $('#delete').modal('show');
            }

          

      </script>

@endsection