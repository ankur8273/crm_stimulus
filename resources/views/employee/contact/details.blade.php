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
@endpush
@section('content')

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
                              <a href="#" class="grid-view btn btn-link"><i class="las la-redo-alt"></i></a>
                              <a href="#" class="list-view btn btn-link" id="collapse-header"><i class="las la-expand-arrows-alt"></i></a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-12">
                     <div class="contact-head">
                        <div class="row align-items-center">
                           <div class="col-sm-6">
                              <ul class="contact-breadcrumb">
                                 <li><a href="contact-grid.html"><i class="las la-arrow-left"></i> Contacts</a></li>
                                 <li>Jackson Daniel</li>
                              </ul>
                           </div>
                           <div class="col-sm-6 text-sm-end">
                              <div class="contact-pagination">
                                 <p>{{$contact->row+1 .' of '. $total}}</p>
                                 <ul>
                                    <li>
                                       @if($previous)
                                       <a href="{{route('employee.contact.details',$previous)}}"><i class="fas fa-angle-left"></i></a>
                                       @endif
                                   </li>
                                   <li>
                                       @if($next)
                                       <a href="{{route('employee.contact.details',$next)}}"><i class="fas fa-angle-right"></i></a>
                                       @endif
                                   </li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="contact-wrap">
                        <div class="contact-profile">
                           <div class="avatar avatar-xxl">
                              @if($contact->image)
                              <img src="{{asset('assets/img/contact/'.$contact->image)}}" alt="User Image">
                              @else
                              <img src="{{asset('assets/img/avatar/images-dummy.jpg')}}" alt="User Image">
                              @endif
                              <span class="status online"></span>
                           </div>
                           <div class="name-user">
                              <h4>{{$contact->first_name.' '.$contact->last_name}}</h4>
                              <p>{{$contact->job_title}}, {{$contact->Company_name}}</p>
                              <div class="badge-rate">
                                 <span class="badge badge-light"><i class="las la-lock"></i>Private</span>
                                 <!-- <p><i class="fa-solid fa-star"></i> 5.0</p> -->
                              </div>
                           </div>
                        </div>
                        <div class="contacts-action">
                           <!-- <a href="#" class="btn-icon text-warning"><i class="fa-solid fa-star"></i></a> -->
                           <!-- <a href="#" data-bs-toggle="modal" data-bs-target="#add_deals" class="btn btn-pink"><i class="feather-plus-circle"></i>Add Deal</a>
                           <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_compose"><i class="feather-mail"></i>Send Email</a>
                           <a href="chat.html" class="btn-icon"><i class="feather-message-circle"></i></a> -->
                           @if(has_permission('Write-Contact'))
                           <a href="#" class="btn-icon" onclick="edit($(this))" data-data="{{json_encode($contact->toArray())}}" data-user_name="{{$contact->user?($contact->user->first_name.' '.$contact->user->last_name):''}}"><i class="feather-edit"></i></a>
                           @endif
                           <div class="dropdown">
                              <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="feather-more-vertical"></i></a>
                              <div class="dropdown-menu dropdown-menu-right">
                                 @if(has_permission('Delete-Contact'))
                                 <a class="dropdown-item" href="javascript:void(0);" data-href="{{route('employee.contact.delete',$contact->id)}}" onclick="delete_note($(this))">Delete</a>
                                 @endif
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-3">
                     <div class="card contact-sidebar">
                        <h5>Basic Information</h5>
                        <ul class="basic-info">
                           <li>
                              <span>
                              <i class="feather-mail"></i>
                              </span>
                              <p>{{$contact->email}}</p>
                           </li>
                           <li>
                              <span>
                              <i class="feather-phone"></i>
                              </span>
                              <p>{{$contact->phone}}</p>
                           </li>
                           <li>
                              <span>
                              <i class="feather-map-pin"></i>
                              </span>
                              @if($contact->address)
                              <p>{{implode(',',json_decode($contact->address,1))}}</p>
                              @endif
                           </li>
                           <li>
                              <span>
                              <i class="las la-calendar-week"></i>
                              </span>
                              <p>Created on {{date('d M Y, h:i a',strtotime($contact->created_at))}}</p>
                           </li>
                        </ul>
                        <h5>Other Information</h5>
                        <ul class="other-info">
                           <li><span class="other-title">Last Modified</span><span>{{date('d M Y, h:i a',strtotime($contact->updated_at))}}</span></li>
                           <li><span class="other-title">Source</span><span>{{$contact->lead?$contact->lead->source:'Other'}}</span></li>
                        </ul>
                        
                        @php
                        $socials = $contact->socials?json_decode($contact->socials,1):[];
                        $tab = session()->get('tab');
                        //dd($socials);
                        @endphp
                        <h5>Social Profile</h5>
                        <ul class="social-info">
                           @if(isset($socials['skype']))
                           <li>
                              <a href="{{$socials['skype']}}"><i class="fa-brands fa-skype"></i></a>
                           </li>
                           @endif
                           @if(isset($socials['facebook']))
                           <li>
                              <a href="{{$socials['facebook']}}"><i class="fa-brands fa-facebook-f"></i></a>
                           </li>
                           @endif
                           @if(isset($socials['instagram']))
                           <li>
                              <a href="{{$socials['instagram']}}"><i class="fa-brands fa-instagram"></i></a>
                           </li>
                           @endif
                           @if(isset($socials['facebook']))
                           <li>
                              <a href="{{$socials['whatsapp']}}"><i class="fa-brands fa-whatsapp"></i></a>
                           </li>
                           @endif
                           @if(isset($socials['twitter']))
                           <li>
                              <a href="{{$socials['twitter']}}"><i class="fa-brands fa-twitter"></i></a>
                           </li>
                           @endif
                           @if(isset($socials['linkedin']))
                           <li>
                              <a href="{{$socials['linkedin']}}"><i class="fa-brands fa-linkedin"></i></a>
                           </li>
                           @endif
                        </ul>
                        <h5>Settings</h5>
                        <ul class="set-info">
                           
                           <li>
                              <a href="javascript:void(0);"><i class="feather-star"></i>Add to Favourite</a>
                           </li>
                           @if(has_permission('Delete-Contact'))
                           <li>
                              <a href="javascript:void(0);" data-href="{{route('employee.contact.delete',$contact->id)}}" onclick="delete_note($(this))"><i class="feather-trash-2"></i>Delete Contact</a>
                           </li>
                           @endif
                        </ul>
                     </div>
                  </div>
                  <div class="col-xl-9">
                     <div class="contact-tab-wrap">
                        <ul class="contact-nav nav">
                           <li>
                              <a href="#" data-bs-toggle="tab" data-bs-target="#activities"@if($tab==null) class="active" @endif><i class="las la-user-clock"></i>Activities</a>
                           </li>
                           <li>
                              <a href="#" data-bs-toggle="tab" data-bs-target="#notes" @if($tab=='note') class="active" @endif><i class="las la-file"></i>Notes</a>
                           </li>
                           <li>
                              <a href="#" data-bs-toggle="tab" data-bs-target="#calls" @if($tab=='call') class="active" @endif><i class="las la-phone-volume"></i>Calls</a>
                           </li>
                           <li>
                              <a href="#" data-bs-toggle="tab" data-bs-target="#files" @if($tab=='file') class="active" @endif><i class="las la-file"></i>Files</a>
                           </li>
                           
                        </ul>
                     </div>
                     <div class="contact-tab-view">
                        <div class="tab-content pt-0">
                           <div class="tab-pane @if($tab==null) active show @else fade @endif" id="activities">
                              <div class="view-header">
                                 <h4>Activities</h4>
                                 <ul>
                                    <li>
                                       <div class="form-sort">
                                          <i class="las la-sort-amount-up-alt"></i>
                                          <select class="select">
                                             <option>Sort By Date</option>
                                             <!-- <option>Ascending</option> -->
                                             <!-- <option>Descending</option> -->
                                          </select>
                                       </div>
                                    </li>
                                 </ul>
                              </div>
                              <div class="contact-activity">
                                 @foreach($activitieDates as $date)
                                 <div class="badge-day"><i class="fa-regular fa-calendar-check"></i>{{date('d M Y',strtotime($date))}}</div>
                                 <ul>
                                    @php
                                       $nottes = App\Models\ContactNote::where('contact_id',$contact->id)
                                                ->where('created_at','>=',date('Y-m-d 00:00:00',strtotime($date)))
                                                ->where('created_at','<=',date('Y-m-d 23:59:59',strtotime($date)))
                                                ->orderBy('created_at','desc')
                                                ->get();
                                       $callnottes = App\Models\ContactCall::where('contact_id',$contact->id)
                                                ->where('created_at','>=',date('Y-m-d 00:00:00',strtotime($date)))
                                                ->where('created_at','<=',date('Y-m-d 23:59:59',strtotime($date)))
                                                ->orderBy('created_at','desc')
                                                ->get();

                                       $documentts = App\Models\Document::where('contact_id',$contact->id)
                                                ->where('created_at','>=',date('Y-m-d 00:00:00',strtotime($date)))
                                                ->where('created_at','<=',date('Y-m-d 23:59:59',strtotime($date)))
                                                ->orderBy('created_at','desc')
                                                ->get();
                                    @endphp
                                    @foreach($documentts as $id=>$documentt)
                                    <li class="activity-wrap">
                                       <span class="activity-icon bg-info">
                                       <i class="las la-comment-alt"></i>
                                       </span>
                                       <div class="activity-info">
                                          <h6>{{$documentt->note}}</h6>
                                          <p>{{date('h:i a',strtotime($documentt['created_at']))}}</p>
                                          <span class="badge badge-soft-grey"><a href="{{asset('assets/files/'.$documentt->file)}}">Download <i class="las la-download"></i></a></span>
                                       </div>
                                    </li>
                                    @endforeach
                                    @foreach($callnottes as $id=>$callnotte)
                                    <li class="activity-wrap">
                                       <span class="activity-icon bg-success">
                                       <i class="las la-phone"></i>
                                       </span>
                                       <div class="activity-info">
                                          <h6>{{$callnotte->note}}</h6>
                                          <p>{{date('h:i a',strtotime($callnotte['created_at']))}}</p>
                                       </div>
                                    </li>
                                    @endforeach
                                    @foreach($nottes as $id=>$notte)
                                    <li class="activity-wrap">
                                       <span class="activity-icon bg-warning">
                                       <i class="las la-file-alt"></i>
                                       </span>
                                       <div class="activity-info">
                                          <h6>Notes added by {{$notte->user?($notte->user->first_name.' '.$notte->user->last_name):''}}</h6>
                                          <p>{{$notte->note}}</p>
                                          <p>{{date('h:i a',strtotime($notte['created_at']))}}</p>
                                       </div>
                                    </li>
                                    @endforeach
                                 </ul>
                                 @endforeach
                              </div>
                           </div>
                           <div class="tab-pane @if($tab=='note') active show @else fade @endif" id="notes">
                              <div class="view-header">
                                 <h4>Notes</h4>
                                 <ul>
                                    <li>
                                       <div class="form-sort">
                                          <i class="las la-sort-amount-up-alt"></i>
                                          <select class="select">
                                             <option>Sort By Date</option>
                                          </select>
                                       </div>
                                    </li>
                                    <li>
                                       <a href="javascript:void(0);" class="com-add" data-bs-toggle="modal" data-bs-target="#add_notes"><i class="las la-plus-circle me-1"></i>Add New</a>
                                    </li>
                                 </ul>
                              </div>
                              <div class="notes-activity">
                                 
                                 @foreach($leadnotes as $leadnote)
                                 <div class="calls-box">
                                    <div class="caller-info">
                                       <div class="calls-user">
                                          @if($leadnote->user && $leadnote->user->image)
                                          <img src="{{asset('assets/img/employee/'.$leadnote->user->image)}}" alt="img">
                                          @else
                                          <img src="{{asset('assets/img/avatar/images-dummy.jpg')}}" alt="img">
                                          @endif
                                          <div>
                                             <h6>{{$leadnote->user?($leadnote->user->first_name.' '.$leadnote->user->last_name):''}}</h6>
                                             <p>{{date('d M Y, h:i  a',strtotime($leadnote->created_at))}}</p>
                                          </div>
                                       </div>
                                       <div class="calls-action">
                                          <div class="dropdown action-drop">
                                             <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="feather-more-vertical"></i></a>
                                             <div class="dropdown-menu dropdown-menu-right">
                                                <!-- <a class="dropdown-item" href="javascript:void(0);"><i class="las la-edit me-1"></i>Edit</a> -->
                                                <a class="dropdown-item" href="javascript:void(0);" data-href="{{route('employee.contact.delete_note',$leadnote->id)}}" onclick="delete_note($(this))"><i class="las la-trash me-1"></i>Delete</a>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <h5>Notes added by {{$leadnote->user?($leadnote->user->first_name.' '.$leadnote->user->last_name):''}}</h5>
                                    <p>{{$leadnote->note}}</p>
                                    <ul>
                                       @if($leadnote->file)
                                       <li>
                                          <div class="note-download">
                                             <div class="note-info">
                                                @if (str_contains(mime_content_type('assets/img/contact/'.$leadnote->file), 'image/')) 
                                                <span class="note-icon">
                                                   <img src="{{asset('assets/img/contact/'.$leadnote->file)}}" alt="img">
                                                </span>
                                                @else
                                                <span class="note-icon bg-success">
                                                   <i class="las la-file-excel"></i>
                                                </span>
                                                @endif
                                                <div>
                                                   <h6>{{$leadnote->file}}</h6>
                                                   <p>{{number_format(filesize('assets/img/contact/'.$leadnote->file)/1024, 2)}} KB</p>
                                                </div>
                                             </div>
                                             <a href="{{asset('assets/img/contact/'.$leadnote->file)}}"><i class="las la-download"></i></a>
                                          </div>
                                       </li>
                                       @endif
                                    </ul>
                                    {!! $leadnote->comments !!}
                                    <form action="{{route('employee.contact.add_comment')}}" method="post">
                                       @csrf
                                       <input type="hidden" name="note_id" value="{{$leadnote->id}}">
                                       <div class="notes-editor">
                                          <div class="note-edit-wrap">
                                             <textarea class="summernote" name="new_comment">Write a new comment, send your team notification by typing @ followed by their name</textarea>
                                             <div class="text-end note-btns">
                                                <a href="javascript:void(0);" class="btn btn-lighter add-cancel">Cancel</a>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                             </div>
                                          </div>
                                          <div class="text-end">
                                             <a href="javascript:void(0);" class="add-comment"><i class="las la-plus-circle me-1"></i>Add Comment</a>
                                          </div>
                                       </div>
                                    </form>
                                 </div>
                                 @endforeach
                                 
                              </div>
                           </div>
                           <div class="tab-pane @if($tab=='call') active show @else fade @endif" id="calls">
                              <div class="view-header">
                                 <h4>Calls</h4>
                                 <ul>
                                    <li>
                                       <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#create_call" class="com-add"><i class="las la-plus-circle me-1"></i>Add New</a>
                                    </li>
                                 </ul>
                              </div>
                              <div class="calls-activity">
                                 @foreach($callnotes as $callnote)
                                 <div class="calls-box">
                                    <div class="caller-info">
                                       <div class="calls-user">
                                           @if($callnote->user && $callnote->user->image)
                                          <img src="{{asset('assets/img/employee/'.$callnote->user->image)}}" alt="img">
                                          @else
                                          <img src="{{asset('assets/img/avatar/images-dummy.jpg')}}" alt="img">
                                          @endif
                                          <p><span>{{$callnote->user?($callnote->user->first_name.' '.$callnote->user->last_name):''}}</span> logged a call on {{date('d M Y, h:i a',strtotime($callnote->created_at))}}</p>
                                       </div>
                                       <div class="calls-action">
                                          <div class="dropdown call-drop">
                                             <a href="#" class="dropdown-toggle {{$callnote->status=='No Answer'?'bg-light-pending':''}}" data-bs-toggle="dropdown" aria-expanded="false">{{$callnote->status}}<i class="las la-angle-down ms-1"></i></a>
                                             <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="javascript:void(0);">Busy</a>
                                                <a class="dropdown-item" href="javascript:void(0);">No Answer</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Unavailable</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Wrong Number</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Left Voice Message</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Moving Forward</a>
                                             </div>
                                          </div>
                                          <div class="dropdown">
                                             <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="feather-more-vertical"></i></a>
                                             <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="javascript:void(0);" data-href="{{route('employee.contact.delete_callNote',$callnote->id)}}" onclick="delete_note($(this))">Delete</a>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <p>{{$callnote->note}}</p>
                                 </div>
                                 @endforeach
                              </div>
                           </div>
                           <div class="tab-pane @if($tab=='file') active show @else fade @endif" id="files">
                              <div class="view-header">
                                 <h4>Files</h4>
                              </div>
                              <div class="files-activity">
                                 <div class="files-wrap">
                                    <div class="row align-items-center">
                                       <div class="col-md-8">
                                          <div class="file-info">
                                             <h4>Manage Documents</h4>
                                             <p>Upload customizable quotes, proposals and contracts here.</p>
                                          </div>
                                       </div>
                                       <div class="col-md-4 text-md-end">
                                          <ul class="file-action">
                                             <li>
                                                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_files">Create Document</a>
                                             </li>
                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                                 @foreach($documents as $document)
                                 <div class="files-wrap">
                                    <div class="row align-items-center">
                                       <div class="col-md-8">
                                          <div class="file-info">
                                             <h4>{{$document->title}}</h4>
                                             <p>{{$document->note}}</p>
                                             <div class="file-user">
                                                @if($document->user && $document->user->image)
                                                <img src="{{asset('assets/img/employee/'.$document->user->image)}}" alt="img">
                                                @else
                                                <img src="{{asset('assets/img/avatar/images-dummy.jpg')}}" alt="img">
                                                @endif
                                                <div>
                                                   <p><span>Owner</span> {{$document->user?($document->user->first_name.' '.$document->user->last_name):''}}</p>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-md-4 text-md-end">
                                          <ul class="file-action">
                                             <li>
                                                <span class="badge badge-soft-grey"><a href="{{asset('assets/files/'.$document->file)}}">Download <i class="las la-download"></i></a></span>
                                             </li>
                                             <!-- <li>
                                                <span class="badge badge-soft-pink priority-badge"><i class="fa-solid fa-circle"></i>Low</span>
                                             </li> -->
                                             <li>
                                                <div class="dropdown action-drop">
                                                   <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="feather-more-vertical"></i></a>
                                                   <div class="dropdown-menu dropdown-menu-right">
                                                      <a class="dropdown-item" href="javascript:void(0);"><i class="las la-edit me-1"></i>Edit</a>
                                                      <a class="dropdown-item" href="javascript:void(0);" data-href="{{route('employee.contact.delete_file',$document->id)}}" onclick="delete_note($(this))"><i class="las la-trash me-1"></i>Delete</a> 
                                                      <a class="dropdown-item" href="{{asset('assets/files/'.$document->file)}}" download><i class="las la-download me-1"></i>Download</a>
                                                   </div>
                                                </div>
                                             </li>
                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                                 @endforeach
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>

@endsection
@section('modal')

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
                     <form action="{{route('employee.contact.add_note',$contact->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="input-block mb-3">
                           <label class="col-form-label">Title <span class="text-danger"> *</span></label>
                           <input class="form-control" type="text" name="title">
                           <input type="hidden" name="contact_id" value="{{$contact->id}}">
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

         <div class="modal custom-modal fade modal-padding" id="add_files" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
               <div class="modal-content">
                  <div class="modal-header header-border align-items-center justify-content-between p-0">
                     <h5 class="modal-title">Add File</h5>
                     <button type="button" class="btn-close position-static" data-bs-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span>
                     </button>
                  </div>
                  <div class="modal-body p-0">
                     <form action="{{route('employee.contact.add_file',$contact->id)}}" method="post" enctype="multipart/form-data" >
                        @csrf
                        <div class="input-block mb-3">
                           <label class="col-form-label">Title <span class="text-danger"> *</span></label>
                           <input class="form-control" type="text" name="title" required>
                           <input type="hidden" name="contact_id" value="{{$contact->id}}">
                        </div>
                        <div class="input-block mb-3">
                           <label class="col-form-label">Note <span class="text-danger"> *</span></label>
                           <textarea class="form-control" rows="4" placeholder="Add text" name="note" required></textarea>
                        </div>
                        <div class="input-block mb-3">
                           <label class="col-form-label">Attachment <span  class="text-danger"> </span></label>
                           <div class="drag-upload">
                              <input type="file" name="file">
                              <div class="img-upload">
                                 <i class="las la-file-import"></i>
                                 <p>Drag & Drop your files</p>
                              </div>
                           </div>
                        </div>
                        
                        <div class="col-lg-12 text-end form-wizard-button">
                           <button class="btn btn-primary" type="submit">Add File</button>
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

         <div class="modal custom-modal fade modal-padding" id="create_call" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
               <div class="modal-content">
                  <div class="modal-header header-border align-items-center justify-content-between p-0">
                     <h5 class="modal-title">Create Call Log</h5>
                     <button type="button" class="btn-close position-static" data-bs-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span>
                     </button>
                  </div>
                  <div class="modal-body p-0">
                     <form action="{{route('employee.contact.add_call',$contact->id)}}" method="post">
                        @csrf
                        <div class="row">
                           <div class="col-md-6">
                              <div class="input-block mb-3">
                                 <label class="col-form-label">Status <span class="text-danger"> *</span></label>
                                 <select class="select" name="status" required>
                                    <option>Busy</option>
                                    <option>Unavailable</option>
                                    <option>No Answer</option>
                                    <option>Wrong Number</option>
                                    <option>Left Voice Message</option>
                                    <option>Moving Forward</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="input-block mb-3">
                                 <label class="col-form-label">Followup Date <span class="text-danger"> </span></label>
                                 <input class="form-control datetimepicker" type="text" name="fellowup_date">
                              </div>
                           </div>
                        </div>
                        <div class="input-block mb-3">
                           <label class="col-form-label">Note <span class="text-danger"> *</span></label>
                           <textarea class="form-control" rows="4" placeholder="Add text" name="note" required></textarea>
                        </div>
                        <div class="input-block mb-3">
                           <label class="custom_check check-box mb-0">
                           <input type="checkbox" name="fellowup_task">
                           <span class="checkmark"></span> Create a Follow up task
                           </label>
                        </div>
                        <div class="col-lg-12 text-end form-wizard-button">
                           <!-- <button class="button btn-lights reset-btn" type="reset">Reset</button> -->
                           <button class="btn btn-primary" type="submit">Save Call</button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal custom-modal fade modal-padding" id="create_email" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
               <div class="modal-content">
                  <div class="modal-header header-border align-items-center justify-content-between p-0">
                     <h5 class="modal-title">Connect Account</h5>
                     <button type="button" class="btn-close position-static" data-bs-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span>
                     </button>
                  </div>
                  <div class="modal-body p-0">
                     <div class="input-block mb-3">
                        <label class="col-form-label">Account type <span class="text-danger"> *</span></label>
                        <select class="select">
                           <option>Gmail</option>
                           <option>Outlook</option>
                           <option>Imap</option>
                        </select>
                     </div>
                     <div class="input-block mb-3">
                        <h5 class="mb-3">Sync emails from</h5>
                        <div class="sync-radio">
                           <div class="radio-item">
                              <input type="radio" class="status-radio" id="test1" name="radio-group" checked>
                              <label for="test1">Now</label>
                           </div>
                           <div class="radio-item">
                              <input type="radio" class="status-radio" id="test2" name="radio-group">
                              <label for="test2">1 Month Ago</label>
                           </div>
                           <div class="radio-item">
                              <input type="radio" class="status-radio" id="test3" name="radio-group">
                              <label for="test3">3 Month Ago</label>
                           </div>
                           <div class="radio-item">
                              <input type="radio" class="status-radio" id="test4" name="radio-group">
                              <label for="test4">6 Month Ago</label>
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-12 text-end form-wizard-button">
                        <button class="button btn-lights reset-btn" data-bs-dismiss="modal" type="reset">Reset</button>
                        <button class="btn btn-primary wizard-next-btn" data-bs-target="#success_mail" data-bs-toggle="modal" data-bs-dismiss="modal" type="button">Connect Account</button>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         
         
       
        
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
                                       <input class="form-control" type="email" name="email" id="c-email" required>
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
                              
                              <h5 class="mb-3">Status</h5>
                              <div class="status-radio-btns d-flex mb-3">
                                 <div class="people-status-radio">
                                    <input type="radio" class="status-radio" id="active-status" name="status" value="1" checked>
                                    <label for="test4">Active</label>
                                 </div>
                                 
                                 <div class="people-status-radio">
                                    <input type="radio" class="status-radio" id="inactive-status" name="status" value="0">
                                    <label for="test6">Inactive</label>
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
         function edit(el){
               var data = $.parseJSON(el.attr("data-data"));
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
               $('#c-email').val(data.email);
               
               $('#contact_id').val(data.id);
               $('#reviews').val(data.reviews).change();
               if(data.user_id){
                  var user_name = el.attr("data-user_name");
                  if(user_name){
                     var userop = '<option value="'+data.id+'" selected>'+user_name+'</option>';
                     $('#user_id').html(userop);
                  }
                  
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

            function reset_f(){
                $('.feild-set').css("display", "none"); 
                $('#edit-first-field').css("display", "block"); 
                $('.f-li').removeClass('active');
                $('#f-li').addClass('active');
            }

            function delete_note(el){
               $('#d-okay').attr("href", el.attr("data-href"));
               $('#delete_models').modal('show');
            }
      </script>
@endsection