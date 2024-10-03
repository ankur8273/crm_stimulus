@extends('admin.layouts.app')
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
                           <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
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
                                       <a href="{{route('admin.contact.details',$previous)}}"><i class="fas fa-angle-left"></i></a>
                                       @endif
                                   </li>
                                   <li>
                                       @if($next)
                                       <a href="{{route('admin.contact.details',$next)}}"><i class="fas fa-angle-right"></i></a>
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
                           <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_compose"><i class="feather-mail"></i>Send Email</a> -->
                           <!-- <a href="chat.html" class="btn-icon"><i class="feather-message-circle"></i></a> -->
						   @if(admin_has_permission('Write-Contact'))
						   <a href="#" class="btn-icon" onclick="edit($(this))" data-data="{{json_encode($contact->toArray())}}" data-user_name="{{$contact->user?($contact->user->first_name.' '.$contact->user->last_name):''}}"><i class="feather-edit"></i></a>
						   @endif
						   @if(admin_has_permission('Delete-Contact'))
                           <div class="dropdown">
                              <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="feather-more-vertical"></i></a>
                              <div class="dropdown-menu dropdown-menu-right">
                                 <a class="dropdown-item" href="javascript:void(0);" data-href="{{route('admin.contact.delete',$contact->id)}}" onclick="delete_note($(this))">Delete</a>
                              </div>
                           </div>
						   @endif
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
                        <!-- <h5>Tags</h5>
                        <ul class="tag-info">
                           <li>
                              <a href="javascript:void(0);" class="bg-success-light">Collab</a>
                           </li>
                           <li>
                              <a href="javascript:void(0);" class="bg-warning-light">Rated</a>
                           </li>
                        </ul> -->
                        <!-- <div class="d-flex align-items-center justify-content-between flex-wrap">
                           <h5>Company</h5>
                           <a href="javascript:void(0);" class="com-add" data-bs-toggle="modal" data-bs-target="#add_contact"><i class="las la-plus-circle me-1"></i>Add New</a>
                        </div>
                        <ul class="company-info">
                           <li>
                              <span>
                              <img src="assets/img/icons/google-icon.svg" alt="Img">
                              </span>
                              <div>
                                 <h6>Google. Inc <i class="fa-solid fa-circle-check text-success"></i></h6>
                                 <p>www.google.com</p>
                              </div>
                           </li>
                        </ul> -->
                        @php
                        $socials = $contact->socials?json_decode($contact->socials,1):[];
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
                           <!-- <li>
                              <a href="javascript:void(0);"><i class="las la-upload"></i>Share Contact</a>
                           </li> -->
                           <li>
                              <a href="javascript:void(0);"><i class="feather-star"></i>Add to Favourite</a>
                           </li>
                           <li>
                              <a href="javascript:void(0);" data-href="{{route('admin.contact.delete',$contact->id)}}" onclick="delete_note($(this))"><i class="feather-trash-2"></i>Delete Contact</a>
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="col-xl-9">
                     <div class="contact-tab-wrap">
                        <ul class="contact-nav nav">
                           <li>
                              <a href="#" data-bs-toggle="tab" data-bs-target="#activities" class="active"><i class="las la-user-clock"></i>Activities</a>
                           </li>
                           <li>
                              <a href="#" data-bs-toggle="tab" data-bs-target="#notes"><i class="las la-file"></i>Notes</a>
                           </li>
                           <li>
                              <a href="#" data-bs-toggle="tab" data-bs-target="#calls"><i class="las la-phone-volume"></i>Calls</a>
                           </li>
                           <li>
                              <a href="#" data-bs-toggle="tab" data-bs-target="#files"><i class="las la-file"></i>Files</a>
                           </li>
                          
                        </ul>
                     </div>
                     <div class="contact-tab-view">
                        <div class="tab-content pt-0">
                           <div class="tab-pane active show" id="activities">
                              <div class="view-header">
                                 <h4>Activities</h4>
                                 <ul>
                                    <li>
                                       <div class="form-sort">
                                          <i class="las la-sort-amount-up-alt"></i>
                                          <select class="select">
                                             <option>Sort By Date</option>
                                             
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
                           <div class="tab-pane fade" id="notes">
                              <div class="view-header">
                                 <h4>Notes</h4>
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
                                                <a class="dropdown-item" href="javascript:void(0);" data-href="{{route('admin.contact.delete_note',$leadnote->id)}}" onclick="delete_note($(this))"><i class="las la-trash me-1"></i>Delete</a>
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
                                    <form action="{{route('admin.contact.add_comment')}}" method="post">
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
                           <div class="tab-pane fade" id="calls">
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
                                                <a class="dropdown-item" href="javascript:void(0);" data-href="{{route('admin.contact.delete_callNote',$callnote->id)}}" onclick="delete_note($(this))">Delete</a>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <p>{{$callnote->note}}</p>
                                 </div>
                                 @endforeach
                              </div>
                           </div>
                           <div class="tab-pane fade" id="files">
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
                                             
                                             <li>
                                                <div class="dropdown action-drop">
                                                   <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="feather-more-vertical"></i></a>
                                                   <div class="dropdown-menu dropdown-menu-right">
                                                      <a class="dropdown-item" href="javascript:void(0);"><i class="las la-edit me-1"></i>Edit</a>
                                                      <a class="dropdown-item" href="javascript:void(0);" data-href="{{route('admin.contact.delete_file',$document->id)}}" onclick="delete_note($(this))"><i class="las la-trash me-1"></i>Delete</a> 
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
                           <div class="tab-pane fade" id="email">
                              <div class="view-header">
                                 <h4>Email</h4>
                                 <ul>
                                    <li>
                                       <a href="javascript:void(0);" class="com-add create-mail" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-dark" data-bs-original-title="There are no email accounts configured, Please configured your email account in order to Send/ Create EMails"><i class="las la-plus-circle me-1"></i>Create Email</a>
                                    </li>
                                 </ul>
                              </div>
                              <div class="files-activity">
                                 <div class="files-wrap">
                                    <div class="row align-items-center">
                                       <div class="col-md-8">
                                          <div class="file-info">
                                             <h4>Manage Emails</h4>
                                             <p>You can send and reply to emails directly via this section.</p>
                                          </div>
                                       </div>
                                       <div class="col-md-4 text-md-end">
                                          <ul class="file-action">
                                             <li>
                                                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create_email">Connect Account</a>
                                             </li>
                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="files-wrap">
                                    <div class="email-header">
                                       <div class="row">
                                          <div class="col top-action-left">
                                             <div class="float-start d-none d-sm-block">
                                                <input type="text" placeholder="Search Messages" class="form-control search-message">
                                             </div>
                                          </div>
                                          <div class="col-auto top-action-right">
                                             <div class="text-end">
                                                <button type="button" title="Refresh" data-bs-toggle="tooltip" class="btn btn-white d-none d-md-inline-block"><i class="fa-solid fa-rotate"></i></button>
                                                <div class="btn-group">
                                                   <a class="btn btn-white"><i class="fa-solid fa-angle-left"></i></a>
                                                   <a class="btn btn-white"><i class="fa-solid fa-angle-right"></i></a>
                                                </div>
                                             </div>
                                             <div class="text-end">
                                                <span class="text-muted d-none d-md-inline-block">Showing 10 of 112 </span>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    
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
                     <form action="{{route('admin.contact.add_note',$contact->id)}}" method="post" enctype="multipart/form-data">
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
                        <!-- <div class="input-block mb-3">
                           <label class="col-form-label">Uploaded Files</label>
                           <div class="upload-file">
                              <h6>Projectneonals teyys.xls</h6>
                              <p>4.25 MB</p>
                              <div class="progress">
                                 <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                              <p>45%</p>
                           </div>
                           <div class="upload-file upload-list">
                              <div>
                                 <h6>Projectneonals teyys.xls</h6>
                                 <p>4.25 MB</p>
                              </div>
                              <a href="javascript:void(0);" class="text-danger"><i class="las la-trash"></i></a>
                           </div>
                        </div> -->
                        <div class="col-lg-12 text-end form-wizard-button">
                           <!-- <button class="button btn-lights reset-btn" type="reset">Reset</button> -->
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
                     <form action="{{route('admin.contact.add_file',$contact->id)}}" method="post" enctype="multipart/form-data" >
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
                           <!-- <button class="button btn-lights reset-btn" type="reset">Reset</button> -->
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
                     <form action="{{route('admin.contact.add_call',$contact->id)}}" method="post">
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
         <div class="modal custom-modal fade" id="success_mail" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
               <div class="modal-content">
                  <div class="modal-body">
                     <div class="success-message text-center">
                        <div class="success-popup-icon">
                           <i class="la la-envelope-open"></i>
                        </div>
                        <h3>Email Connected Successfully!!!</h3>
                        <p>Email Account is configured with “<a href="https://smarthr.dreamstechnologies.com/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="fc99849d918c9099bc99849d918c9099d29f9391">[email&#160;protected]</a>”. Now you can access email.</p>
                        <div class="col-lg-12 text-center form-wizard-button">
                           <a href="contact-details.html" class="btn btn-primary">Go to email</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal custom-modal fade custom-modal-two modal-padding" id="add_contact" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
               <div class="modal-content">
                  <div class="modal-header header-border justify-content-between p-0">
                     <h5 class="modal-title">Add Company</h5>
                     <button type="button" class="btn-close position-static" data-bs-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span>
                     </button>
                  </div>
                  <div class="modal-body p-0">
                     <h5 class="mb-3">Sync emails from</h5>
                     <ul class="nav email-item">
                        <li class="nav-item">
                           <span class="active mb-0" data-bs-toggle="tab" data-bs-target="#existing-company">
                           <input type="radio" class="status-radio" id="mail1" name="email" checked>
                           <label for="mail1">Existing Company</label>
                           </span>
                        </li>
                        <li class="nav-item">
                           <span class=" mb-0" data-bs-toggle="pill" data-bs-target="#new-company">
                           <input type="radio" class="status-radio" id="mail2" name="email">
                           <label for="mail2">New Company</label>
                           </span>
                        </li>
                     </ul>
                     <div class="tab-content pt-0">
                        <div class="tab-pane show active" id="existing-company">
                           <form action="https://smarthr.dreamstechnologies.com/html/template/contact-details.html">
                              <div class="existing-company mb-3">
                                 <div class="input-block mb-0">
                                    <label class="col-form-label">Company <span class="text-danger"> *</span></label>
                                    <select class="select">
                                       <option>SilverHawk</option>
                                       <option>NovaWaveLLC</option>
                                    </select>
                                    <p>Use this field to associate existing deal instead of creating new one.</p>
                                 </div>
                              </div>
                              <div class="col-lg-12 text-end form-wizard-button">
                                 <button class="button btn-lights reset-btn" data-bs-dismiss="modal" type="reset">Reset</button>
                                 <button class="btn btn-primary" type="submit">Save</button>
                              </div>
                           </form>
                        </div>
                        <div class="tab-pane fade" id="new-company">
                           <div class="add-details-wizard">
                              <ul id="progressbar" class="progress-bar-wizard">
                                 <li class="active">
                                    <span><i class="la la-user-tie"></i></span>
                                    <div class="multi-step-info">
                                       <h6>Basic Info</h6>
                                    </div>
                                 </li>
                                 <li>
                                    <span><i class="la la-map-marker"></i></span>
                                    <div class="multi-step-info">
                                       <h6>Address</h6>
                                    </div>
                                 </li>
                                 <li>
                                    <div class="multi-step-icon">
                                       <span><i class="la la-icons"></i></span>
                                    </div>
                                    <div class="multi-step-info">
                                       <h6>Social Profiles</h6>
                                    </div>
                                 </li>
                                 <li>
                                    <div class="multi-step-icon">
                                       <span><i class="la la-images"></i></span>
                                    </div>
                                    <div class="multi-step-info">
                                       <h6>Access</h6>
                                    </div>
                                 </li>
                              </ul>
                           </div>
                           <div class="add-info-fieldset">
                              <fieldset id="first-field">
                                 <form action="https://smarthr.dreamstechnologies.com/html/template/contact-details.html">
                                    <div class="form-upload-profile">
                                       <h6 class>Profile Image <span> *</span></h6>
                                       <div class="profile-pic-upload">
                                          <div class="profile-pic">
                                             <span><img src="assets/img/icons/profile-upload-img.svg" alt="Img"></span>
                                          </div>
                                          <div class="employee-field">
                                             <div class="mb-0">
                                                <div class="image-upload mb-0">
                                                   <input type="file">
                                                   <div class="image-uploads">
                                                      <h4>Upload</h4>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="img-reset-btn">
                                                <a href="#">Reset</a>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="contact-input-set">
                                       <div class="row">
                                          <div class="col-lg-4 col-md-6">
                                             <div class="input-block mb-3">
                                                <label class="col-form-label">First Name <span class="text-danger"> *</span></label>
                                                <input class="form-control" type="text">
                                             </div>
                                          </div>
                                          <div class="col-lg-4 col-md-6">
                                             <div class="input-block mb-3">
                                                <label class="col-form-label">Last Name <span class="text-danger"> *</span></label>
                                                <input class="form-control" type="text">
                                             </div>
                                          </div>
                                          <div class="col-lg-4 col-md-6">
                                             <div class="input-block mb-3">
                                                <label class="col-form-label">Job Title <span class="text-danger"> *</span></label>
                                                <input class="form-control" type="text">
                                             </div>
                                          </div>
                                          <div class="col-lg-4 col-md-6">
                                             <div class="input-block mb-3">
                                                <label class="col-form-label">Company Name <span class="text-danger">*</span></label>
                                                <select class="select">
                                                   <option>Select</option>
                                                   <option>NovaWaveLLC</option>
                                                   <option>BlueSky Industries</option>
                                                   <option>SilverHawk</option>
                                                </select>
                                             </div>
                                          </div>
                                          <div class="col-lg-4 col-md-6">
                                             <div class="input-block mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <label class="col-form-label">Email <span class="text-danger"> *</span></label>
                                                   <div class="status-toggle small-toggle-btn d-flex align-items-center">
                                                      <span class="me-2 label-text">Option</span>
                                                      <input type="checkbox" id="user2" class="check" checked>
                                                      <label for="user2" class="checktoggle"></label>
                                                   </div>
                                                </div>
                                                <input class="form-control" type="email">
                                             </div>
                                          </div>
                                          <div class="col-lg-4 col-md-6">
                                             <div class="input-block mb-3">
                                                <label class="col-form-label">Phone Number 1<span class="text-danger"> *</span></label>
                                                <input class="form-control" type="text">
                                             </div>
                                          </div>
                                          <div class="col-lg-4 col-md-6">
                                             <div class="input-block mb-3">
                                                <label class="col-form-label">Phone Number 2<span class="text-danger"> *</span></label>
                                                <input class="form-control" type="text">
                                             </div>
                                          </div>
                                          <div class="col-lg-4 col-md-6">
                                             <div class="input-block mb-3">
                                                <label class="col-form-label">Fax </label>
                                                <input class="form-control" type="text">
                                             </div>
                                          </div>
                                          <div class="col-lg-4 col-md-6">
                                             <div class="input-block mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <label class="col-form-label">Deals <span class="text-danger">*</span></label>
                                                   <a href="#" class="add-new"><i class="la la-plus-circle me-2"></i>Add New</a>
                                                </div>
                                                <select class="select">
                                                   <option>Select</option>
                                                   <option>Collins</option>
                                                   <option>Konopelski</option>
                                                   <option>Adams</option>
                                                </select>
                                             </div>
                                          </div>
                                          <div class="col-lg-4 col-md-6">
                                             <div class="input-block mb-3">
                                                <label class="col-form-label">Date of birth <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text">
                                             </div>
                                          </div>
                                          <div class="col-lg-4 col-md-6">
                                             <div class="input-block mb-3">
                                                <label class="col-form-label">Reviews <span class="text-danger">*</span></label>
                                                <select class="select">
                                                   <option>Select</option>
                                                   <option>Lowest</option>
                                                   <option>Highest</option>
                                                </select>
                                             </div>
                                          </div>
                                          <div class="col-lg-4 col-md-6">
                                             <div class="input-block mb-3">
                                                <label class="col-form-label">Owner <span class="text-danger">*</span></label>
                                                <select class="select">
                                                   <option>Select</option>
                                                   <option>Hendry</option>
                                                   <option>Guillory</option>
                                                   <option>Jami</option>
                                                </select>
                                             </div>
                                          </div>
                                          <div class="col-lg-4 col-md-6">
                                             <div class="input-block mb-3">
                                                <label class="col-form-label">Industry <span class="text-danger">*</span></label>
                                                <select class="select">
                                                   <option>Select</option>
                                                   <option>Barry Cuda</option>
                                                   <option>Tressa Wexler</option>
                                                </select>
                                             </div>
                                          </div>
                                          <div class="col-lg-4 col-md-6">
                                             <div class="input-block mb-3">
                                                <label class="col-form-label">Currency <span class="text-danger">*</span></label>
                                                <select class="select">
                                                   <option>Select</option>
                                                   <option>$</option>
                                                   <option>€</option>
                                                </select>
                                             </div>
                                          </div>
                                          <div class="col-lg-4 col-md-6">
                                             <div class="input-block mb-3">
                                                <label class="col-form-label">Language <span class="text-danger">*</span></label>
                                                <select class="select">
                                                   <option>Select</option>
                                                   <option>English</option>
                                                   <option>French</option>
                                                </select>
                                             </div>
                                          </div>
                                          <div class="col-lg-6 col-md-6">
                                             <div class="input-block mb-3">
                                                <label class="col-form-label">Tags <span class="text-danger">*</span></label>
                                                <input class="input-tags form-control" id="inputBox" type="text" data-role="tagsinput" name="Label" value="Promotion, Rated">
                                             </div>
                                          </div>
                                          <div class="col-lg-6 col-md-6">
                                             <div class="input-block mb-3">
                                                <label class="col-form-label">Source <span class="text-danger">*</span></label>
                                                <select class="select">
                                                   <option>Select</option>
                                                   <option>Barry Cuda</option>
                                                   <option>Tressa Wexler</option>
                                                </select>
                                             </div>
                                          </div>
                                          <div class="col-lg-12">
                                             <div class="input-block mb-3">
                                                <label class="col-form-label">Comments<span class="text-danger">*</span></label>
                                                <textarea class="form-control" rows="5"></textarea>
                                             </div>
                                          </div>
                                          <div class="col-lg-12 text-end form-wizard-button">
                                             <button class="button btn-lights reset-btn" type="reset">Reset</button>
                                             <button class="btn btn-primary wizard-next-btn" type="button">Save & Next</button>
                                          </div>
                                       </div>
                                    </div>
                                 </form>
                              </fieldset>
                              <fieldset>
                                 <form action="https://smarthr.dreamstechnologies.com/html/template/contact-details.html">
                                    <div class="contact-input-set">
                                       <div class="row">
                                          <div class="col-lg-12">
                                             <div class="input-block mb-3">
                                                <label class="col-form-label">Street Address<span class="text-danger"> *</span></label>
                                                <input class="form-control" type="text">
                                             </div>
                                          </div>
                                          <div class="col-md-6">
                                             <div class="input-block mb-3">
                                                <label class="col-form-label">City <span class="text-danger"> *</span></label>
                                                <input class="form-control" type="text">
                                             </div>
                                          </div>
                                          <div class="col-md-6">
                                             <div class="input-block mb-3">
                                                <label class="col-form-label">State / Province <span class="text-danger"> *</span></label>
                                                <input class="form-control" type="text">
                                             </div>
                                          </div>
                                          <div class="col-md-6">
                                             <div class="input-block mb-3">
                                                <label class="col-form-label">Country <span class="text-danger">*</span></label>
                                                <select class="select">
                                                   <option>Select</option>
                                                   <option>Germany</option>
                                                   <option>USA</option>
                                                </select>
                                             </div>
                                          </div>
                                          <div class="col-md-6">
                                             <div class="input-block mb-3">
                                                <label class="col-form-label">Zipcode <span class="text-danger"> *</span></label>
                                                <input class="form-control" type="text">
                                             </div>
                                          </div>
                                          <div class="col-lg-12 text-end form-wizard-button">
                                             <button class="button btn-lights reset-btn" type="reset">Reset</button>
                                             <button class="btn btn-primary wizard-next-btn" type="button">Save & Next</button>
                                          </div>
                                       </div>
                                    </div>
                                 </form>
                              </fieldset>
                              <fieldset>
                                 <form action="https://smarthr.dreamstechnologies.com/html/template/contact-details.html">
                                    <div class="contact-input-set">
                                       <div class="row">
                                          <div class="col-lg-12">
                                             <div class="input-block mb-3">
                                                <label class="col-form-label">Facebook</label>
                                                <input class="form-control" type="text">
                                             </div>
                                          </div>
                                          <div class="col-lg-12">
                                             <div class="input-block mb-3">
                                                <label class="col-form-label">Twitter</label>
                                                <input class="form-control" type="text">
                                             </div>
                                          </div>
                                          <div class="col-lg-12">
                                             <div class="input-block mb-3">
                                                <label class="col-form-label">Linkedin</label>
                                                <input class="form-control" type="text">
                                             </div>
                                          </div>
                                          <div class="col-lg-12">
                                             <div class="input-block mb-3">
                                                <label class="col-form-label">Skype</label>
                                                <input class="form-control" type="text">
                                             </div>
                                          </div>
                                          <div class="col-lg-12">
                                             <div class="input-block mb-3">
                                                <label class="col-form-label">Whatsapp</label>
                                                <input class="form-control" type="text">
                                             </div>
                                          </div>
                                          <div class="col-lg-12">
                                             <div class="input-block mb-3">
                                                <label class="col-form-label">Instagram</label>
                                                <input class="form-control" type="text">
                                             </div>
                                          </div>
                                          <div class="col-lg-12">
                                             <div class="input-block mb-3">
                                                <a href="#" class="add-new"><i class="la la-plus-circle me-2"></i>Add New</a>
                                             </div>
                                          </div>
                                          <div class="col-lg-12 text-end form-wizard-button">
                                             <button class="button btn-lights reset-btn" type="reset">Reset</button>
                                             <button class="btn btn-primary wizard-next-btn" type="button">Save & Next</button>
                                          </div>
                                       </div>
                                    </div>
                                 </form>
                              </fieldset>
                              <fieldset>
                                 <form action="https://smarthr.dreamstechnologies.com/html/template/contact-details.html">
                                    <div class="contact-input-set">
                                       <div class="input-blocks add-products">
                                          <label class="mb-3">Visibility</label>
                                          <div class="access-info-tab">
                                             <ul class="nav nav-pills" id="pills-tab1" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                   <span class="custom_radio mb-0" id="pills-public-tab" data-bs-toggle="pill" data-bs-target="#pills-public" role="tab" aria-controls="pills-public" aria-selected="true">
                                                   <input type="radio" class="form-control" name="public" checked>
                                                   <span class="checkmark"></span> Public</span>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                   <span class="custom_radio mb-0" id="pills-private-tab" data-bs-toggle="pill" data-bs-target="#pills-private" role="tab" aria-controls="pills-private" aria-selected="false">
                                                   <input type="radio" class="form-control" name="private">
                                                   <span class="checkmark"></span> Private</span>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                   <span class="custom_radio mb-0 active" id="pills-select-people-tab" data-bs-toggle="pill" data-bs-target="#pills-select-people" role="tab" aria-controls="pills-select-people" aria-selected="false">
                                                   <input type="radio" class="form-control" name="select-people">
                                                   <span class="checkmark"></span> Select People</span>
                                                </li>
                                             </ul>
                                          </div>
                                       </div>
                                       <div class="tab-content" id="pills-tabContent">
                                          <div class="tab-pane fade" id="pills-public" role="tabpanel" aria-labelledby="pills-public-tab"></div>
                                          <div class="tab-pane fade" id="pills-private" role="tabpanel" aria-labelledby="pills-private-tab"></div>
                                          <div class="tab-pane fade show active" id="pills-select-people" role="tabpanel" aria-labelledby="pills-select-people-tab">
                                             <div class="people-select-tab">
                                                <h3>Select People</h3>
                                                <div class="select-people-checkbox">
                                                   <label class="custom_check">
                                                   <input type="checkbox">
                                                   <span class="checkmark"></span>
                                                   <span class="people-profile">
                                                   <img src="assets/img/avatar/avatar-19.jpg" alt="Img">
                                                   <a href="#">Darlee Robertson</a>
                                                   </span>
                                                   </label>
                                                </div>
                                                <div class="select-people-checkbox">
                                                   <label class="custom_check">
                                                   <input type="checkbox">
                                                   <span class="checkmark"></span>
                                                   <span class="people-profile">
                                                   <img src="assets/img/avatar/avatar-20.jpg" alt="Img">
                                                   <a href="#">Sharon Roy</a>
                                                   </span>
                                                   </label>
                                                </div>
                                                <div class="select-people-checkbox">
                                                   <label class="custom_check">
                                                   <input type="checkbox">
                                                   <span class="checkmark"></span>
                                                   <span class="people-profile">
                                                   <img src="assets/img/avatar/avatar-21.jpg" alt="Img">
                                                   <a href="#">Vaughan</a>
                                                   </span>
                                                   </label>
                                                </div>
                                                <div class="select-people-checkbox">
                                                   <label class="custom_check">
                                                   <input type="checkbox">
                                                   <span class="checkmark"></span>
                                                   <span class="people-profile">
                                                   <img src="assets/img/avatar/avatar-1.jpg" alt="Img">
                                                   <a href="#">Jessica</a>
                                                   </span>
                                                   </label>
                                                </div>
                                                <div class="select-confirm-btn">
                                                   <a href="#" class="btn danger-btn">Confirm</a>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <h5 class="mb-3">Status</h5>
                                       <div class="status-radio-btns d-flex mb-3">
                                          <div class="people-status-radio">
                                             <input type="radio" class="status-radio" id="test7" name="radio-group" checked>
                                             <label for="test7">Active</label>
                                          </div>
                                          <div class="people-status-radio">
                                             <input type="radio" class="status-radio" id="test5" name="radio-group">
                                             <label for="test5">Private</label>
                                          </div>
                                          <div class="people-status-radio">
                                             <input type="radio" class="status-radio" id="test6" name="radio-group">
                                             <label for="test6">Inactive</label>
                                          </div>
                                       </div>
                                       <div class="col-lg-12 text-end form-wizard-button">
                                          <button class="button btn-lights reset-btn" type="reset">Reset</button>
                                          <button class="btn btn-primary" type="submit">Save Contact</button>
                                       </div>
                                    </div>
                                 </form>
                              </fieldset>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal custom-modal fade custom-modal-two modal-padding" id="new_file" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
               <div class="modal-content">
                  <div class="modal-header header-border justify-content-between p-0">
                     <h5 class="modal-title">Create New File</h5>
                     <button type="button" class="btn-close position-static" data-bs-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span>
                     </button>
                  </div>
                  <div class="modal-body p-0">
                     <div class="add-info-fieldset">
                        <div class="add-details-wizard">
                           <ul class="progress-bar-wizard">
                              <li class="active">
                                 <span><i class="la la-file"></i></span>
                                 <div class="multi-step-info">
                                    <h6>Basic Info</h6>
                                 </div>
                              </li>
                              <li>
                                 <span><i class="la la-plus-circle"></i></span>
                                 <div class="multi-step-info">
                                    <h6>Add Recipient</h6>
                                 </div>
                              </li>
                           </ul>
                        </div>
                        <fieldset id="first-field-file">
                           <form action="https://smarthr.dreamstechnologies.com/html/template/contact-details.html">
                              <div class="contact-input-set">
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="input-block mb-3">
                                          <label class="col-form-label">Choose Deal <span class="text-danger">*</span></label>
                                          <select class="select">
                                             <option>Select</option>
                                             <option>Collins</option>
                                             <option>Wisozk</option>
                                             <option>Walter</option>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="input-block mb-3">
                                          <label class="col-form-label">Document Type <span class="text-danger">*</span></label>
                                          <select class="select">
                                             <option>Select</option>
                                             <option>Contract</option>
                                             <option>Proposal</option>
                                             <option>Quote</option>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="input-block mb-3">
                                          <label class="col-form-label">Owner <span class="text-danger">*</span></label>
                                          <select class="select">
                                             <option>Select</option>
                                             <option>Admin</option>
                                             <option>Jackson Daniel</option>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="input-block mb-3">
                                          <label class="col-form-label">Title <span class="text-danger"> *</span></label>
                                          <input class="form-control" type="text" placeholder="Enter Name">
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="input-block mb-3">
                                          <label class="col-form-label">Locale <span class="text-danger">*</span></label>
                                          <select class="select">
                                             <option>Select</option>
                                             <option>en</option>
                                             <option>es</option>
                                             <option>ru</option>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-lg-12">
                                       <div class="signature-wrap">
                                          <h4>Signature</h4>
                                          <ul class="nav sign-item">
                                             <li class="nav-item">
                                                <span class=" mb-0" data-bs-toggle="tab" data-bs-target="#nosign">
                                                <input type="radio" class="status-radio" id="sign1" name="email">
                                                <label for="sign1"><span class="sign-title">No Signature</span>This document does not require a signature before acceptance.</label>
                                                </span>
                                             </li>
                                             <li class="nav-item">
                                                <span class="active mb-0" data-bs-toggle="tab" data-bs-target="#use-esign">
                                                <input type="radio" class="status-radio" id="sign2" name="email" checked>
                                                <label for="sign2"><span class="sign-title">Use e-signature</span>This document require e-signature before acceptance.</label>
                                                </span>
                                             </li>
                                          </ul>
                                          <div class="tab-content">
                                             <div class="tab-pane show active" id="use-esign">
                                                <div class="input-block mb-0">
                                                   <label class="col-form-label">Document Signers <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="sign-content">
                                                   <div class="row">
                                                      <div class="col-md-6">
                                                         <div class="input-block mb-3">
                                                            <input class="form-control" type="text" placeholder="Enter Name">
                                                         </div>
                                                      </div>
                                                      <div class="col-md-6">
                                                         <div class="d-flex align-items-center">
                                                            <div class="input-block float-none mb-3 me-3">
                                                               <input class="form-control" type="text" placeholder="Email Address">
                                                            </div>
                                                            <div class="input-btn mb-3">
                                                               <a href="javascript:void(0);" class="add-sign"><i class="las la-plus-circle"></i></a>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-12">
                                       <div class="input-block mb-3">
                                          <label class="col-form-label">Content <span class="text-danger"> *</span></label>
                                          <textarea class="form-control" rows="3" placeholder="Add Content"></textarea>
                                       </div>
                                    </div>
                                    <div class="col-lg-12 text-end form-wizard-button">
                                       <button class="button btn-lights reset-btn" type="reset">Reset</button>
                                       <button class="btn btn-primary wizard-next-btn" type="button">Next</button>
                                    </div>
                                 </div>
                              </div>
                           </form>
                        </fieldset>
                        <fieldset>
                           <form action="https://smarthr.dreamstechnologies.com/html/template/contact-details.html">
                              <div class="contact-input-set">
                                 <div class="row">
                                    <div class="col-lg-12">
                                       <div class="signature-wrap">
                                          <h4 class="mb-2">Send the document to following signers</h4>
                                          <p>In order to send the document to the signers</p>
                                          <div class="input-block mb-0">
                                             <label class="col-form-label">Recipients (Additional recipients)</label>
                                          </div>
                                          <div class="sign-content">
                                             <div class="row">
                                                <div class="col-md-6">
                                                   <div class="input-block mb-3">
                                                      <input class="form-control" type="text" placeholder="Enter Name">
                                                   </div>
                                                </div>
                                                <div class="col-md-6">
                                                   <div class="d-flex align-items-center">
                                                      <div class="input-block float-none mb-3 me-3">
                                                         <input class="form-control" type="text" placeholder="Email Address">
                                                      </div>
                                                      <div class="input-btn mb-3">
                                                         <a href="javascript:void(0);" class="add-sign"><i class="las la-plus-circle"></i></a>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-lg-12">
                                       <div class="input-block mb-3">
                                          <label class="col-form-label">Message Subject <span class="text-danger"> *</span></label>
                                          <input class="form-control" type="text" placeholder="Enter Subject">
                                       </div>
                                       <div class="input-block mb-3">
                                          <label class="col-form-label">Message Text <span class="text-danger"> *</span></label>
                                          <textarea class="form-control" rows="3" placeholder="Your document is ready"></textarea>
                                       </div>
                                       <button class="btn btn-lighter mb-3">Send Now</button>
                                       <div class="send-success">
                                          <p><i class="las la-check-circle"></i> Document Sent successfully to the Selected Recipients</p>
                                       </div>
                                    </div>
                                    <div class="col-lg-12 text-end form-wizard-button">
                                       <button class="button btn-lights reset-btn" type="reset">Reset</button>
                                       <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Save & Next</button>
                                    </div>
                                 </div>
                              </div>
                           </form>
                        </fieldset>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal custom-modal fade custom-modal-two modal-padding" id="add_deals" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
               <div class="modal-content">
                  <div class="modal-header header-border justify-content-between p-0">
                     <h5 class="modal-title">Add New Deals</h5>
                     <button type="button" class="btn-close position-static" data-bs-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span>
                     </button>
                  </div>
                  <div class="modal-body p-0">
                     <form action="https://smarthr.dreamstechnologies.com/html/template/contact-details.html">
                        <div class="contact-input-set">
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Deal Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text">
                                 </div>
                              </div>
                              <div class="col-md-6 pipeline-add-col">
                                 <div class="input-block mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                       <label class="col-form-label">Pipeline <span class="text-danger">*</span></label>
                                       <a href="#" class="add-new add-pipeline-btn"><i class="la la-plus-circle me-2"></i>Add New</a>
                                    </div>
                                    <select class="select">
                                       <option>Select</option>
                                       <option>Sales</option>
                                       <option>Marketing</option>
                                       <option>Calls</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Status <span class="text-danger">*</span></label>
                                    <select class="select">
                                       <option>Select</option>
                                       <option>Open</option>
                                       <option>Lost</option>
                                       <option>Won</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Deal Value<span class="text-danger"> *</span></label>
                                    <input class="form-control" type="text">
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Currency <span class="text-danger">*</span></label>
                                    <select class="select">
                                       <option>Select</option>
                                       <option>$</option>
                                       <option>€</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Period <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text">
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Period Value <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text">
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="input-block tag-with-img mb-3">
                                    <label class="col-form-label">Contact <span class="text-danger">*</span></label>
                                    <input class="input-tags form-control" id="inputBox5" type="text" data-role="tagsinput" name="Label" value="James">
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Project <span class="text-danger">*</span></label>
                                    <input class="input-tags form-control" id="inputBox6" type="text" data-role="tagsinput" name="Label" value="Divine dran">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Due Date <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Expected Closing Date <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text">
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="input-block tag-with-img mb-3">
                                    <label class="col-form-label">Assignee <span class="text-danger">*</span></label>
                                    <input class="input-tags form-control" id="inputBox3" type="text" data-role="tagsinput" name="Label" value="James">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Tags <span class="text-danger">*</span></label>
                                    <input class="input-tags form-control" id="inputBox4" type="text" data-role="tagsinput" name="Label" value="Promotion, Rated">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Followup Date <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Source <span class="text-danger">*</span></label>
                                    <select class="select">
                                       <option>Select</option>
                                       <option>Barry Cuda</option>
                                       <option>Tressa Wexler</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Priority <span class="text-danger">*</span></label>
                                    <select class="select">
                                       <option>Select</option>
                                       <option>Highy</option>
                                       <option>Low</option>
                                       <option>Medium</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-lg-12">
                                 <div class="input-block mb-3">
                                    <label class="col-form-label">Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control" rows="5"></textarea>
                                 </div>
                              </div>
                              <div class="col-lg-12 text-end form-wizard-button">
                                 <button class="button btn-lights reset-btn" type="reset" data-bs-dismiss="modal">Reset</button>
                                 <button class="btn btn-primary" type="submit">Save Deal</button>
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal custom-modal fade custom-modal-two modal-padding" id="add_compose" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
               <div class="modal-content">
                  <div class="modal-header header-border justify-content-between p-0">
                     <h5 class="modal-title">Add Compose</h5>
                     <button type="button" class="btn-close position-static" data-bs-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span>
                     </button>
                  </div>
                  <div class="modal-body p-0">
                     <form action="#">
                        <div class="input-block mb-3">
                           <input type="email" placeholder="To" class="form-control">
                        </div>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="input-block mb-3">
                                 <input type="email" placeholder="Cc" class="form-control">
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="input-block mb-3">
                                 <input type="email" placeholder="Bcc" class="form-control">
                              </div>
                           </div>
                        </div>
                        <div class="input-block mb-3">
                           <input type="text" placeholder="Subject" class="form-control">
                        </div>
                        <div class="input-block mb-3">
                           <div id="summernote"></div>
                        </div>
                        <div class="input-block mb-3 mb-0">
                           <div class="text-center">
                              <button class="btn btn-primary"><span>Send</span> <i class="fa-solid fa-paper-plane m-l-5"></i></button>
                              <button class="btn btn-success m-l-5" type="button"><span>Draft</span> <i class="fa-regular fa-floppy-disk m-l-5"></i></button>
                              <button class="btn btn-success m-l-5" type="button"><span>Delete</span> <i class="fa-regular fa-trash-can m-l-5"></i></button>
                           </div>
                        </div>
                     </form>
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
                        <form action="{{route('admin.contact.update')}}" method="post" enctype="multipart/form-data">
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
         <div class="modal custom-modal fade" id="delete_contact" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
               <div class="modal-content">
                  <div class="modal-body">
                     <div class="success-message text-center">
                        <div class="success-popup-icon bg-danger">
                           <i class="la la-trash-restore"></i>
                        </div>
                        <h3>Are you sure, You want to delete</h3>
                        <p>Contact ”Jackson Daniel” from your Account</p>
                        <div class="col-lg-12 text-center form-wizard-button">
                           <a href="#" class="button btn-lights" data-bs-dismiss="modal">Not Now</a>
                           <a href="contact-details.html" class="btn btn-primary">Okay</a>
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