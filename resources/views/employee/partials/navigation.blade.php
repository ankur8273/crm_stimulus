<div class="sidebar" id="sidebar">
   <div class="sidebar-inner slimscroll">
      <div id="sidebar-menu" class="sidebar-menu">
        
         <ul class="sidebar-vertical">
            <li class="menu-title">
               <span>Main</span>
            </li>
            <li >
               <a href="{{route('employee.dashboard')}}"><i class="la la-dashcube"></i> <span> Dashboard</span> </a>
               
            </li>
            @if(has_permission('Employee'))
            <li class="submenu">
               <a href="#" class="noti-dot"><i class="la la-user"></i> <span> Employees</span> <span class="menu-arrow"></span></a>
               <ul>
                  <li><a href="{{route('employee.employee.list')}}">All Employees</a></li>
                  <li><a href="{{route('employee.employee.department.list')}}">Departments</a></li>
                  <li><a href="{{route('employee.employee.designation.list')}}">Designations</a></li>
               </ul>
            </li>
            @endif
            <li>
               <a href="{{route('employee.leads.list')}}"><i class="la la-chart-area"></i> <span> Leads </span></a>
            </li>
            <li class="submenu">
               <a href="#"><i class="la la-rocket"></i> <span> Projects</span> <span class="menu-arrow"></span></a>
               <ul>
                  <li><a href="{{route('employee.project.list')}}">Projects</a></li>
				  <li><a href="{{route('employee.properties.list')}}">Properties</a></li>
               </ul>
            </li>
            <li>
               <a href="{{route('employee.contact.list')}}"><i class="la la-user-shield"></i> <span> Contacts </span></a>
            </li>
            <li class="submenu">
               <a href="#"><i class="la la-ticket"></i> <span>Tickets</span><span class="menu-arrow"></span></a>
               <ul>
                  <li><a href="{{route('employee.ticket.list')}}">Tickets</a></li>
               </ul>
            </li>

			@if(has_permission('CP'))
            <li class="submenu">
               <a href="#" ><i class="la la-user"></i> <span> Channel Partners</span> <span class="menu-arrow"></span></a>
               <ul>
                  <li><a href="{{route('employee.channel-partner.list')}}">All Channel Partners</a></li>
                  
               </ul>
            </li>
            @endif

            @if(has_permission('General-settings'))
            <li class="submenu">
               <a href="#"><i class="la la-cog"></i> <span>General settings</span><span class="menu-arrow"></span></a>
               <ul>
                  <li><a href="{{route('employee.setting')}}">Website settings</a></li>
                  <li><a href="{{route('employee.email-settings')}}">Email settings</a></li>
               </ul>
            </li>
            @endif
            <li>
               <a href="{{route('employee.knowledgebase.list')}}"><i class="la la-question"></i> <span>Knowledgebase</span></a>
            </li>
            
         </ul>
      </div>
   </div>
</div>
