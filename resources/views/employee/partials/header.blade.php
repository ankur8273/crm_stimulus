<div class="header">
   <div class="header-left">
      <a href="{{route('employee.dashboard')}}" class="logo">
      <img src="{{asset('assets/logo/jclogo.webp')}}" width="80" height="auto" alt="Logo">
      <!-- <img src="{{asset('assets/img/logo.svg')}}" alt="Logo"> -->
      </a>
      <a href="{{route('employee.dashboard')}}" class="logo collapse-logo">
      <img src="{{asset('assets/logo/jclogo.webp')}}" alt="Logo">
      <!-- <img src="{{asset('assets/img/collapse-logo.svg')}}" alt="Logo"> -->
      </a>
      <a href="{{route('employee.dashboard')}}" class="logo2">
      <img src="{{asset('assets/logo/jclogo.webp')}}" width="80" height="80" alt="Logo">
      <!-- <img src="{{asset('assets/img/logo2.png')}}" width="40" height="40" alt="Logo"> -->
      </a>
   </div>
   <a id="toggle_btn" href="javascript:void(0);">
   <span class="bar-icon">
   <span></span>
   <span></span>
   <span></span>
   </span>
   </a>
   <div class="page-title-box">
      <h3>JC Realtors</h3>
   </div>
   <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa-solid fa-bars"></i></a>
   <ul class="nav user-menu">
      <li class="nav-item">
         <div class="top-nav-search">
            <a href="javascript:void(0);" class="responsive-search">
            <i class="fa-solid fa-magnifying-glass"></i>
            </a>
            <form action="#">
               <input class="form-control" type="text" placeholder="Search here">
               <button class="btn" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
         </div>
      </li>
      <li class="nav-item dropdown">
         <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
         <i class="fa-regular fa-bell"></i> <span class="badge rounded-pill"id="notify-count">{{count(auth('employee')->user()->unreadNotifications)>20?'20+':count(auth('employee')->user()->unreadNotifications)}}</span>
         </a>
         <div class="dropdown-menu notifications">
            <div class="topnav-dropdown-header">
               <span class="notification-title">Notifications</span>
			   @if(auth('employee')->check() && auth('employee')->user()->unreadNotifications && count(auth('employee')->user()->unreadNotifications) > 0)
               <a href="javascript:void(0)" class="clear-noti" onclick="clear_notification()"> Clear All </a>
               @endif
            </div>
            <div class="noti-content">
               <ul class="notification-list" id="notfi-list">
                  @foreach(auth('employee')->user()->unreadNotifications as $notification)
                  <li class="notification-message">
                     <a href="{{$notification->data['url']}}">
                        <div class="chat-block d-flex">
                           <span class="avatar flex-shrink-0">
                           <img src="{{asset('assets/img/avatar/images-dummy.jpg')}}" alt="User Image">
                           </span>
                           <div class="media-body flex-grow-1">
                              <p class="noti-details">{{$notification->data['message']}}</p>
                              <p class="noti-time"><span class="notification-time">{{date('M,d,Y h:i a',strtotime($notification->created_at))}}</span></p>
                           </div>
                        </div>
                     </a>
                  </li>
                  @endforeach
               </ul>
            </div>
            <div class="topnav-dropdown-footer">
               <!-- <a href="activities.html">View all Notifications</a> -->
            </div>
         </div>
      </li>
      <!-- <li class="nav-item dropdown">
         <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
         <i class="fa-regular fa-comment"></i><span class="badge rounded-pill">8</span>
         </a>
         <div class="dropdown-menu notifications">
            <div class="topnav-dropdown-header">
               <span class="notification-title">Messages</span>
               <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
            </div>
            <div class="noti-content">
               <ul class="notification-list">
                  <li class="notification-message">
                     <a href="chat.html">
                        <div class="list-item">
                           <div class="list-left">
                              <span class="avatar">
                              <img src="{{asset('assets/img/profiles/avatar-09.jpg')}}" alt="User Image">
                              </span>
                           </div>
                           <div class="list-body">
                              <span class="message-author">Richard Miles </span>
                              <span class="message-time">12:28 AM</span>
                              <div class="clearfix"></div>
                              <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                           </div>
                        </div>
                     </a>
                  </li>
                  <li class="notification-message">
                     <a href="chat.html">
                        <div class="list-item">
                           <div class="list-left">
                              <span class="avatar">
                              <img src="{{asset('assets/img/profiles/avatar-02.jpg')}}" alt="User Image">
                              </span>
                           </div>
                           <div class="list-body">
                              <span class="message-author">John Doe</span>
                              <span class="message-time">6 Mar</span>
                              <div class="clearfix"></div>
                              <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                           </div>
                        </div>
                     </a>
                  </li>
                  <li class="notification-message">
                     <a href="chat.html">
                        <div class="list-item">
                           <div class="list-left">
                              <span class="avatar">
                              <img src="{{asset('assets/img/profiles/avatar-03.jpg')}}" alt="User Image">
                              </span>
                           </div>
                           <div class="list-body">
                              <span class="message-author"> Tarah Shropshire </span>
                              <span class="message-time">5 Mar</span>
                              <div class="clearfix"></div>
                              <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                           </div>
                        </div>
                     </a>
                  </li>
                  <li class="notification-message">
                     <a href="chat.html">
                        <div class="list-item">
                           <div class="list-left">
                              <span class="avatar">
                              <img src="{{asset('assets/img/profiles/avatar-05.jpg')}}" alt="User Image">
                              </span>
                           </div>
                           <div class="list-body">
                              <span class="message-author">Mike Litorus</span>
                              <span class="message-time">3 Mar</span>
                              <div class="clearfix"></div>
                              <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                           </div>
                        </div>
                     </a>
                  </li>
                  <li class="notification-message">
                     <a href="chat.html">
                        <div class="list-item">
                           <div class="list-left">
                              <span class="avatar">
                              <img src="{{asset('assets/img/profiles/avatar-08.jpg')}}" alt="User Image">
                              </span>
                           </div>
                           <div class="list-body">
                              <span class="message-author"> Catherine Manseau </span>
                              <span class="message-time">27 Feb</span>
                              <div class="clearfix"></div>
                              <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                           </div>
                        </div>
                     </a>
                  </li>
               </ul>
            </div>
            <div class="topnav-dropdown-footer">
               <a href="chat.html">View all Messages</a>
            </div>
         </div>
      </li> -->
      <li class="nav-item dropdown has-arrow main-drop">
         <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
         <span class="user-img">
            @if(auth('employee')->user()->image)
            <img src="{{asset('assets/img/employee/'.auth('employee')->user()->image)}}" alt="User Image">
            @else
            <img src="{{asset('assets/img/icons/profile-upload-img.svg')}}" alt="User Image">
            @endif
         <span class="status online"></span></span>
         <span>{{auth('employee')->user()->first_name.' '.auth('employee')->user()->last_name}}</span>
         </a>
         <div class="dropdown-menu">
            <a class="dropdown-item" href="{{route('employee.profile')}}">My Profile</a>
            <!-- <a class="dropdown-item" href="settings.html">Settings</a> -->
            <a class="dropdown-item" href="{{route('employee.logout')}}">Logout</a>
         </div>
      </li>
   </ul>
   <div class="dropdown mobile-user-menu">
      <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis-vertical"></i></a>
      <div class="dropdown-menu dropdown-menu-right">
         <a class="dropdown-item" href="{{route('employee.profile')}}">My Profile</a>
         <!-- <a class="dropdown-item" href="settings.html">Settings</a> -->
         <a class="dropdown-item" href="{{route('employee.logout')}}">Logout</a>
      </div>
   </div>
</div>