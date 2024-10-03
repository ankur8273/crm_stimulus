<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Ticket;
use App\Models\Employee;
use App\Models\Lead;
use App\Models\Project;
use App\Models\Contact;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function clear_notification(Request $request)
    {
        auth('admin')->user()->unreadNotifications->markAsRead();
        return 1;
    }
    public function index(Request $request)
    {
        $data= [];
        $data['employees'] = Employee::where('role', '!=',1)->latest()->get()->take(5);
        $data['totalemployees'] = Employee::where('role', '!=',1)->count();
        $data['leads'] = Lead::latest()->get()->take(5);
        $data['totalleads'] = Lead::count();
        $data['projects'] = Project::latest()->get()->take(5);
        $data['totalprojects'] = Project::count();
        $data['contacts'] = Contact::latest()->get()->take(5);
        $data['totalcontacts'] = Contact::count();
        $data['tickets'] = Ticket::latest()->get()->take(5);


        $data['status']['Pending'] = Lead::where('lead_status',null)->count();
        $data['status']['SITE_VISIT_DONE'] = Lead::where('lead_status','SITE VISIT DONE')->count();
        $data['status']['Warm'] = Lead::where('lead_status','Warm')->count();
        $data['status']['F2F_Planned'] = Lead::where('lead_status','F2F Planned')->count();
        $data['status']['Visited_Cold'] = Lead::where('lead_status','Visited - Cold')->count();
        $data['status']['Visited_Hot'] = Lead::where('lead_status','Visited - Hot')->count();
        $data['status']['Revisit_Planned'] = Lead::where('lead_status','Revisit Planned')->count();
        $data['status']['Revisited'] = Lead::where('lead_status','Revisited')->count();
        $data['status']['Token_Received'] = Lead::where('lead_status','Token Received')->count();
        $data['status']['Sale_Done'] = Lead::where('lead_status','Sale Done')->count();
        $data['status']['Never_Picked'] = Lead::where('lead_status','Never Picked')->count();
        $data['status']['JUST_Arrived'] = Lead::where('lead_status','JUST  Arrived')->count();
        $data['status']['lost'] = Lead::where('lead_status','lost')->count();
        $data['status']['Deal_Closed'] = Lead::where('lead_status','Deal Closed')->count();

        $data['followup']['Pending'] = Lead::where('followup_type',null)->count();
        $data['followup']['Call'] = Lead::where('followup_type','Call')->count();
        $data['followup']['Boucher_Sent'] = Lead::where('followup_type','Boucher Sent')->count();
        $data['followup']['Demo_Visit'] = Lead::where('followup_type','Demo/Visit')->count();
        $data['followup']['2ndDemo_Revisit'] = Lead::where('followup_type','2ndDemo/Revisit')->count();
        $data['followup']['Negotiation'] = Lead::where('followup_type','Negotiation')->count();
        $data['followup']['Closing_Meetings'] = Lead::where('followup_type','Closing Meetings')->count();
        $data['followup']['Fresh'] = Lead::where('followup_type','Fresh')->count();
        $data['followup']['NOT_INT'] = Lead::where('followup_type','NOT INT')->count();
        $data['followup']['Switch_off'] = Lead::where('followup_type','Switch off')->count();

        return view('admin.dashboard',$data);
    }
}
