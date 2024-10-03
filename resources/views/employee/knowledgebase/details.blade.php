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
@endpush
@section('content')

         <div class="page-wrapper">
            <div class="content container-fluid pb-0">
               <div class="page-header">
                  <div class="row">
                     <div class="col-sm-12">
                        <h3 class="page-title">Knowledgebase</h3>
                        <ul class="breadcrumb">
                           <li class="breadcrumb-item"><a href="{{route('employee.dashboard')}}">Dashboard</a></li>
                           <li class="breadcrumb-item active">Knowledgebase</li>
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-lg-8">
                     <div class="card">
                        <div class="card-body">
                           <article class="post">
                              <h1 class="post-title">{{$knowledgebase->title}} </h1>
                              <ul class="meta">
                                 <li><span>Created :</span>{{date('M, d, Y',strtotime($knowledgebase->created_at))}}</li>
                                 <li><span>Category:</span> <a href="#">{{$knowledgebase->category}}</a></li>
                                 <li><span>Last Updated:</span> {{date('M, d, Y',strtotime($knowledgebase->updated_at))}}</li>
                              </ul>
                              {!! $knowledgebase->details !!}
                           </article>
                           
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4">
                     <div class="w-sidebar">
                        <div class="widget widget-category">
                           <h4 class="widget-title"><i class="fa-regular fa-folder"></i> Categories</h4>
                           <ul>
                              @foreach($categories as $category)
                              <li>
                                 <a href="#">{{$category->name}}</a>
                              </li>
                              @endforeach
                           </ul>
                        </div>
                        
                        <div class="widget widget-category">
                           <h4 class="widget-title"><i class="fa-regular fa-folder"></i> Latest Articles</h4>
                           <ul>
                              @foreach($latest as $artical)
                              <li><a href="{{route('employee.knowledgebase.details',$artical->id)}}"> {{$artical->title}} </a></li>
                              @endforeach
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
@endsection
@section('modal')
      
      
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


@endsection