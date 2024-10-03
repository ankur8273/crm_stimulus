<div class="sidebar" id="sidebar">
   <div class="sidebar-inner slimscroll">
      <div id="sidebar-menu" class="sidebar-menu">
        
         <ul class="sidebar-vertical">
            <li class="menu-title">
               <span>Menu Panel </span>
            </li>
            <li >
               <a href="{{route('admin.dashboard')}}"><i class="la la-dashcube"></i> <span> Dashboard</span> </a>
               
            </li>
             @if(admin_has_permission('Employee'))
            <li class="submenu">
               <a href="#" class="noti-dot"><i class="la la-user"></i> <span> Employees</span> <span class="menu-arrow"></span></a>
               <ul>
                  <li><a href="{{route('admin.employee.list')}}">All Employees</a></li>
                  <li><a href="{{route('admin.employee.department.list')}}">Departments</a></li>
                  <li><a href="{{route('admin.employee.designation.list')}}">Designations</a></li>
               </ul>
            </li>
			@endif
			@if(admin_has_permission('Lead'))
            <li>
               <a href="{{route('admin.leads.list')}}"><i class="la la-chart-area"></i> <span> Leads </span></a>
            </li>
			@endif
			@if(admin_has_permission('Project'))
            <li class="submenu">
               <a href="#"><i class="la la-rocket"></i> <span> Projects</span> <span class="menu-arrow"></span></a>
               <ul>
                  <li><a href="{{route('admin.project.list')}}">Projects</a></li>
				  <li><a href="{{route('admin.properties.list')}}">Properties</a></li>
               </ul>
            </li>
            @endif
			@if(admin_has_permission('Contact'))
            <li>
               <a href="{{route('admin.contact.list')}}"><i class="la la-user-shield"></i> <span> Contacts </span></a>
            </li>
			@endif
			@if(admin_has_permission('Ticket'))
            <li class="submenu">
               <a href="#"><i class="la la-ticket"></i> <span>Tickets</span><span class="menu-arrow"></span></a>
               <ul>
                  <li><a href="{{route('admin.ticket.list')}}">Tickets</a></li>
               </ul>
            </li>
			@endif
			@if(admin_has_permission('CP'))
			<li class="submenu">
               <a href="#" ><i class="la la-user"></i> <span> Channel Partners</span> <span class="menu-arrow"></span></a>
               <ul>
			       <li><a href="{{route('admin.channel-partner.branch.list')}}">All Branchs</a></li>
                  <li><a href="{{route('admin.channel-partner.list')}}">All Channel Partners</a></li>
               </ul>
            </li>
			@endif
			@if(admin_has_permission('General-settings'))
            <li class="submenu">
               <a href="#"><i class="la la-cog"></i> <span>General settings</span><span class="menu-arrow"></span></a>
               <ul>
                  <li><a href="{{route('admin.setting')}}">Website settings</a></li>
                  <li><a href="{{route('admin.email-settings')}}">Email settings</a></li>
               </ul>
            </li>
            @endif
			<!-- @if(admin_has_permission('Knowledgebase')) -->
            <li>
               <a href="{{route('admin.knowledgebase.list')}}"><i class="la la-question"></i> <span>Knowledgebase1</span></a>
            </li>
			<!-- @endif -->
            
         </ul>
      </div>
   </div>
</div>
