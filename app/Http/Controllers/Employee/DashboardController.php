<?php

namespace App\Http\Controllers\Employee;

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
         auth('employee')->user()->unreadNotifications->markAsRead();
         return 1;
     }

    public function index(Request $request)
    {
        $data= [];
        $data['employees'] = has_permission('Employee')?Employee::where('role', '!=',1)->latest()->get()->take(5):[];
        $data['totalemployees'] = has_permission('Employee')?Employee::where('role', '!=',1)->count():0;
        $data['leads'] = Lead::when(!has_permission('Lead'), function($query){
            return $query->where('user_id', auth('employee')->user()->id);
        })->latest()->get()->take(5);
        $data['totalleads'] = Lead::when(!has_permission('Lead'), function($query){
            return $query->where('user_id', auth('employee')->user()->id);
        })->count();
        $data['projects'] = Project::when(!has_permission('Project'), function($query){
            return $query->where('user_id', auth('employee')->user()->id);
        })->latest()->get()->take(5);
        $data['totalprojects'] = Project::when(!has_permission('Project'), function($query){
            return $query->where('user_id', auth('employee')->user()->id);
        })->count();
        $data['contacts'] = Contact::when(!has_permission('Contact'), function($query){
            return $query->where('user_id', auth('employee')->user()->id);
        })->latest()->get()->take(5);
        $data['totalcontacts'] = Contact::when(!has_permission('Contact'), function($query){
            return $query->where('user_id', auth('employee')->user()->id);
        })->count();
        $data['tickets'] = Ticket::when(!has_permission('Ticket'), function($query){
            return $query->where('user_id', auth('employee')->user()->id);
        })->latest()->get()->take(5);


        $data['status']['Pending'] = Lead::when(!has_permission('Lead'), function($query){
            return $query->where('user_id', auth('employee')->user()->id);
        })->where('lead_status',null)->count();
        $data['status']['SITE_VISIT_DONE'] = Lead::when(!has_permission('Lead'), function($query){
            return $query->where('user_id', auth('employee')->user()->id);
        })->where('lead_status','SITE VISIT DONE')->count();
        $data['status']['Warm'] = Lead::when(!has_permission('Lead'), function($query){
            return $query->where('user_id', auth('employee')->user()->id);
        })->where('lead_status','Warm')->count();
        $data['status']['F2F_Planned'] = Lead::when(!has_permission('Lead'), function($query){
            return $query->where('user_id', auth('employee')->user()->id);
        })->where('lead_status','F2F Planned')->count();
        $data['status']['Visited_Hot'] = Lead::when(!has_permission('Lead'), function($query){
            return $query->where('user_id', auth('employee')->user()->id);
        })->where('lead_status','Visited - Hot')->count();
        $data['status']['Visited_Cold'] = Lead::when(!has_permission('Lead'), function($query){
            return $query->where('user_id', auth('employee')->user()->id);
        })->where('lead_status','Visited - Cold')->count();
        $data['status']['Revisit_Planned'] = Lead::when(!has_permission('Lead'), function($query){
            return $query->where('user_id', auth('employee')->user()->id);
        })->where('lead_status','Revisit Planned')->count();
        $data['status']['Revisited'] = Lead::when(!has_permission('Lead'), function($query){
            return $query->where('user_id', auth('employee')->user()->id);
        })->where('lead_status','Revisited')->count();
        $data['status']['Token_Received'] = Lead::when(!has_permission('Lead'), function($query){
            return $query->where('user_id', auth('employee')->user()->id);
        })->where('lead_status','Token Received')->count();
        $data['status']['Sale_Done'] = Lead::when(!has_permission('Lead'), function($query){
            return $query->where('user_id', auth('employee')->user()->id);
        })->where('lead_status','Sale Done')->count();
        $data['status']['Never_Picked'] = Lead::when(!has_permission('Lead'), function($query){
            return $query->where('user_id', auth('employee')->user()->id);
        })->where('lead_status','Never Picked')->count();
        $data['status']['JUST_Arrived'] = Lead::when(!has_permission('Lead'), function($query){
            return $query->where('user_id', auth('employee')->user()->id);
        })->where('lead_status','JUST  Arrived')->count();
        $data['status']['lost'] = Lead::when(!has_permission('Lead'), function($query){
            return $query->where('user_id', auth('employee')->user()->id);
        })->where('lead_status','lost')->count();
        $data['status']['Deal_Closed'] = Lead::when(!has_permission('Lead'), function($query){
            return $query->where('user_id', auth('employee')->user()->id);
        })->where('lead_status','Deal Closed')->count();

        $data['followup']['Pending'] = Lead::when(!has_permission('Lead'), function($query){
            return $query->where('user_id', auth('employee')->user()->id);
        })->where('followup_type',null)->count();
        $data['followup']['Call'] = Lead::when(!has_permission('Lead'), function($query){
            return $query->where('user_id', auth('employee')->user()->id);
        })->where('followup_type','Call')->count();
        $data['followup']['Boucher_Sent'] = Lead::when(!has_permission('Lead'), function($query){
            return $query->where('user_id', auth('employee')->user()->id);
        })->where('followup_type','Boucher Sent')->count();
        $data['followup']['Demo_Visit'] = Lead::when(!has_permission('Lead'), function($query){
            return $query->where('user_id', auth('employee')->user()->id);
        })->where('followup_type','Demo/Visit')->count();
        $data['followup']['2ndDemo_Revisit'] = Lead::when(!has_permission('Lead'), function($query){
            return $query->where('user_id', auth('employee')->user()->id);
        })->where('followup_type','2ndDemo/Revisit')->count();
        $data['followup']['Negotiation'] = Lead::when(!has_permission('Lead'), function($query){
            return $query->where('user_id', auth('employee')->user()->id);
        })->where('followup_type','Negotiation')->count();
        $data['followup']['Closing_Meetings'] = Lead::when(!has_permission('Lead'), function($query){
            return $query->where('user_id', auth('employee')->user()->id);
        })->where('followup_type','Closing Meetings')->count();
        $data['followup']['Fresh'] = Lead::when(!has_permission('Lead'), function($query){
            return $query->where('user_id', auth('employee')->user()->id);
        })->where('followup_type','Fresh')->count();
        $data['followup']['NOT_INT'] = Lead::when(!has_permission('Lead'), function($query){
            return $query->where('user_id', auth('employee')->user()->id);
        })->where('followup_type','NOT INT')->count();
        $data['followup']['Switch_off'] = Lead::when(!has_permission('Lead'), function($query){
            return $query->where('user_id', auth('employee')->user()->id);
        })->where('followup_type','Switch off')->count();

        return view('employee.dashboard',$data);
    }
}
