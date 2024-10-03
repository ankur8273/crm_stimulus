<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin;
use App\Models\Employee;
use App\Models\Lead;
use App\Models\LeadNote;
use App\Models\CallNote;
use App\Models\Document;
use App\Models\Project;
use App\Exports\LeadExport;
use App\Imports\LeadsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Notification;
use DB;
use App\Notifications\UserNotification;
use App\Notifications\SendEmailNotification;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $name = null;
        $email = null;
        $phone = null;
        $user_id = null;
        $date = null;
        $start = null;
        $end = null;
        $lead_status = null;
        $frstlead = Lead::first();
        if($frstlead){
            $start = date('Y-m-d',strtotime($frstlead->created_at));
            $end = date('Y-m-d',strtotime('+ 2 days'));
        }else{
            $start = date('Y-m-d',strtotime('today - 1 days'));
            $end = date('Y-m-d',strtotime('+ 2 days'));
        }
        // dd($request);
        $leads = Lead::orderBy('id','desc');
        if ($request->name) {
            $name = $request->name;
            $leads = $leads->where('name','like','%'.$request->name.'%');
        }
        if ($request->email) {
            $email = $request->email;
            $leads = $leads->where('email',$request->email);
        }

        if ($request->phone) {
            $phone = $request->phone;
            $leads = $leads->where('phone','like','%'.$request->phone.'%');
        }

        if ($request->lead_status) {
            $lead_status = $request->lead_status;
            $leads = $leads->where('lead_status',$request->lead_status);
        }

        if ($request->user_id) {
            $user_id = $request->user_id;
            $leads = $leads->where('user_id',$request->user_id);
        }

        if ($request->date) {
            $date = $request->date;
            $start = str_replace(' ','',explode('-',$date)[0]);
            $end = str_replace(' ','',explode('-',$date)[1]);
            $leads = $leads->where('created_at','>=',date('Y-m-d 00:00:00',strtotime($start)))->where('created_at','<=',date('Y-m-d 23:59:59',strtotime($end)));
        }
        $leads = $leads->get()->take(4000);
        return view('admin.leads.index',compact('leads','name','email','phone','user_id','lead_status','date','start','end'));
    }

    public function details(Request $request,$id)
    {
        $lead = Lead::findOrFail($id);

        // get previous user id
        $previous = Lead::where('id', '<', $lead->id)->max('id');
    
        // get next user id
        $next = Lead::where('id', '>', $lead->id)->min('id');
        $total = Lead::count();
        $leadnotes = LeadNote::where('lead_id',$lead->id)->orderBy('id','desc')->get();
        $callnotes = CallNote::where('lead_id',$lead->id)->orderBy('id','desc')->get();
        $documents = Document::where('lead_id',$lead->id)->orderBy('id','desc')->get();
        $leaddates = LeadNote::query()
                                    ->select(
                                       DB::raw('DATE(created_at) as created_date')
                                    )
                                    ->where('lead_id',$lead->id)
                                    ->groupBy(DB::raw('created_date'))
                                    ->orderBy(DB::raw('created_date'),'desc')
                                    ->pluck('created_date');
        
        $calldates = CallNote::query()
                                    ->select(
                                       DB::raw('DATE(created_at) as created_date')
                                    )
                                    ->where('lead_id',$lead->id)
                                    ->groupBy(DB::raw('created_date'))
                                    ->orderBy(DB::raw('created_date'),'desc')
                                    ->pluck('created_date');
        $documentdates = Document::query()
                                    ->select(
                                       DB::raw('DATE(created_at) as created_date')
                                    )
                                    ->where('lead_id',$lead->id)
                                    ->groupBy(DB::raw('created_date'))
                                    ->orderBy(DB::raw('created_date'),'desc')
                                    ->pluck('created_date');
        $dates = $leaddates->merge($calldates);
        $dates = $dates->merge($documentdates);
        $dates = $dates->unique()->toArray();
        usort($dates, function($a1, $a2) {
                   $value1 = strtotime($a1);
                   $value2 = strtotime($a2);
                   // return $value1 - $value2; //asc
                   return $value2 - $value1; //desc
                });
        $activitieDates = $dates;
        $pro_ids = $lead->project_ids?explode(',',$lead->project_ids):[];
        $projects = Project::whereIn('id',$pro_ids)->get();
        // dd($dates);
        return view('admin.leads.details',compact('lead','previous','next','total','leadnotes','callnotes','documents','activitieDates','projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required|unique:leads|max:255',
            'email' => 'required|unique:leads|max:255',
            
        ]);

        $data=$request->all();
        unset($data['_token']);

        $lead = new Lead();
        $lead->name = $request->name;
        $lead->user_id = $request->user_id;
        $lead->phone = $request->phone;
        $lead->alt_phone = $request->alt_phone;
        $lead->email = $request->email;
        $lead->city = $request->city;
        $lead->source = $request->source;

        $lead->followup_type = $request->followup_type;
        $lead->lead_type = $request->lead_type;
        $lead->channel_partner = $request->channel_partner;
        
        $lead->lead_status = $request->lead_status;
        
        $lead->budget = $request->budget;
        $lead->occupation = $request->occupation;
        $lead->purpose = $request->purpose;
        $lead->location = $request->location;
        $lead->note = $request->note;
        $lead->followup_remark = $request->followup_type?('Pending,'.$request->followup_type):'Pending';
        $lead->next_action_date = $request->next_action_date?date('Y-m-d H:i:s',strtotime($request->next_action_date)):null;
        $lead->next_followup = $request->next_followup;
        $lead->data = json_encode($data);
        $lead->save();
        return redirect()->back()->with('success', 'Added Successfully!');
    }

    public function update(Request $request)
    {
         $lead = Lead::findOrFail($request->id);
        $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required|unique:leads,phone,'.$lead->id,
            'email' => 'required|unique:leads,email,'.$lead->id,
            
        ]);

        $data=$request->all();
        unset($data['_token']);

       
        $lead->name = $request->name;
        $lead->user_id = $request->user_id;
        $lead->phone = $request->phone;
        $lead->alt_phone = $request->alt_phone;
        $lead->email = $request->email;
        $lead->city = $request->city;
        $lead->source = $request->source;

        $lead->followup_type = $request->followup_type;
        $lead->lead_type = $request->lead_type;
        $lead->channel_partner = $request->channel_partner;
        
        $lead->lead_status = $request->lead_status;
        
        $lead->budget = $request->budget;
        $lead->occupation = $request->occupation;
        $lead->purpose = $request->purpose;
        $lead->location = $request->location;
        $lead->note = $request->note;
        $followup_remarks = $lead->followup_remark?explode(',',$lead->followup_remark):['Pending'];
        $followup_remark=$lead->followup_remark;
        if(count($followup_remarks)>1){
            $followup_remark = ($followup_remarks[count($followup_remarks)-1]==$request->followup_remark)?$lead->followup_remark:$lead->followup_remark.','.$request->followup_remark;
        }
        $lead->followup_remark = $lead->followup_remark?$followup_remark:'Pending';
        $lead->next_action_date = $request->next_action_date?date('Y-m-d H:i:s',strtotime($request->next_action_date)):null;
        $lead->next_followup = $request->next_followup;
        $lead->data = json_encode($data);
        $lead->save();
        $this->send_notification([
            'lead'=> $lead,
            'message'=> 'Lead Updated By '
        ]);
        return redirect()->back()->with('success', 'Updated Successfully!');
    }

    public function add_projects(Request $request,$id)
    {
        $lead = Lead::findOrFail($id);
        $lead->project_ids =$lead->project_ids?($lead->project_ids.','.implode(',',$request->project_ids)):implode(',',$request->project_ids);
        $lead->save();
        $this->send_notification([
            'lead'=> $lead,
            'message'=> 'Project added on Lead By '
        ]);
        return redirect()->back()->with('success', 'Added Successfully!');
    }

    public function change_leadStatus(Request $request,$id)
    {
        $lead = Lead::findOrFail($id);
        $lead->lead_status = $request->status;
        $lead->lead_status_remark = $lead->lead_status_remark?($lead->lead_status_remark.','.$request->status):'Pending,'.$request->status;
        $lead->save();
        $this->send_notification([
            'lead'=> $lead,
            'message'=> 'Lead status changed By '
        ]);
        return 1;
    }

    public function change_fellowupType(Request $request,$id)
    {
        $lead = Lead::findOrFail($id);
        $lead->followup_type = $request->status;
        $lead->followup_remark = $lead->followup_remark?($lead->followup_remark.','.$request->status):'Pending,'.$request->status;
        $lead->save();
        $this->send_notification([
            'lead'=> $lead,
            'message'=> 'Followup type changed By '
        ]);
        return 1;
    }

    public function change_status(Request $request,$id)
    {
        $lead = Lead::findOrFail($id);
        $lead->status = $request->status;
        $lead->save();
        return 1;
    }

    public function add_owner(Request $request,$id)
    {
        $lead = Lead::findOrFail($id);
        $lead->user_id = $request->user_id;
        $lead->save();
        $this->send_notification([
            'lead'=> $lead,
            'message'=> 'Lead Owner changed By '
        ]);
        return redirect()->back()->with('success', 'Updated Successfully!');
    }

    public function delete(Request $request,$id)
    {
        $lead = Lead::findOrFail($id);
        $lead->delete();
        $this->send_notification([
            'lead'=> $lead,
            'message'=> 'Lead Deleted By '
        ]);
        return redirect()->back()->with('success', 'Deleted Successfully!');
    }

    public function export(Request $request){
        return Excel::download(new LeadExport($request->all()), 'leads.xlsx');
    }

    public function add_note(Request $request)
    {
        session()->put('tab','note');
        $lead = Lead::findOrFail($request->lead_id);
        $leadnote = new LeadNote();
        if($request->hasFile('file')){
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $original_file_name = $file->getClientOriginalName();
            $files = rand().'-'.$original_file_name;
            // $files = time().rand().'.'.$extension;
            $file->move('assets/img/lead/', $files);

            $leadnote->file = $files;
        }
        $leadnote->lead_id = $lead->id;
        $leadnote->user_id = auth('admin')->user()->id;
        $leadnote->title = $request->title;
        $leadnote->note = $request->note;
        $leadnote->save();
        $this->send_notification([
            'lead'=> $lead,
            'message'=> 'Leadnote added By '
        ]);
        return redirect()->back()->with('success', 'Note Added Successfully!');
    }

    public function add_comment(Request $request)
    {
        session()->put('tab','note');
        // dd($request);
        $note = '<div class="reply-box">
                   '.$request->new_comment.'
                   <p>Commented by <span class="text-primary">'.auth('admin')->user()->name.'</span> on '.date('d M Y, h:i a').'</p>
                </div>';
        $leadnote = LeadNote::findOrFail($request->note_id);
        $leadnote->comments = $leadnote->comments?($leadnote->comments.$note):$note;
        $leadnote->save();
        $this->send_notification([
            'lead'=> $leadnote->lead,
            'message'=> 'Lead comment added By '
        ]);
        return redirect()->back()->with('success', 'Comment Added Successfully!');
    }

    public function delete_note(Request $request,$id)
    {
        session()->put('tab','note');
        $leadnote = LeadNote::findOrFail($id);
        if ($leadnote->file && file_exists('assets/img/lead/'.$leadnote->file)) {
                unlink('assets/img/lead/'.$leadnote->file);
            } 
        $leadnote->delete();
        return redirect()->back()->with('success', 'Note Deleted Successfully!');
    }

    public function update_note(Request $request)
    {
        dd($request);
        $lead = LeadNote::findOrFail($id);
        $leadnote = new LeadNote();
        if($request->hasFile('profile')){
            if ($user->image && file_exists('public/front/img/user/'.$user->image)) {
                    unlink('public/front/img/user/'.$user->image);
                } 
            $file = $request->file('profile');
            $extension = $file->getClientOriginalExtension();
            $image = time().rand().'.'.$extension;
            $file->move('public/front/img/user/', $image);

            $user->image = $image;
            $user->save();
        }
        $leadnote->title = $request->title;
        $leadnote->note = $request->note;
        return redirect()->back()->with('success', 'Note Added Successfully!');
    }

    public function add_call(Request $request,$id)
    {
        session()->put('tab','call');
        // dd($request);
        $lead = Lead::findOrFail($id);
        $callnote = new CallNote();
        
        $callnote->lead_id = $lead->id;
        $callnote->user_id = auth('admin')->user()->id;
        $callnote->status = $request->status;
        $callnote->note = $request->note;
        if($request->fellowup_date){
            $callnote->fellowup_date = date('Y-m-d H:i:s',strtotime($request->fellowup_date));
        }
        if($request->fellowup_task){
            $callnote->fellowup_task = 1;
        }
        
        $callnote->save();
        $this->send_notification([
            'lead'=> $lead,
            'message'=> 'Callnote added By '
        ]);
        return redirect()->back()->with('success', 'Note Added Successfully!');
    }

    public function delete_callNote(Request $request,$id)
    {
        session()->put('tab','call');
        $callnote = CallNote::findOrFail($id);
        
        $callnote->delete();
        return redirect()->back()->with('success', 'Note Deleted Successfully!');
    }

    public function add_file(Request $request,$id)
    {
        session()->put('tab','file');
        $request->validate([
            'title' => 'required|max:255',
            'note' => 'required|max:255',
            'file' => 'required|max:255',
            
        ]);
        // dd($request);
        $lead = Lead::findOrFail($request->lead_id);
        $document = new Document();
        if($request->hasFile('file')){
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $original_file_name = $file->getClientOriginalName();
            $files = rand().'-'.$original_file_name;
            // $files = time().rand().'.'.$extension;
            $file->move('assets/files/', $files);

            $document->file = $files;
        }
        $document->lead_id = $lead->id;
        $document->user_id = auth('admin')->user()->id;
        $document->title = $request->title;
        $document->note = $request->note;
        $document->save();
        $this->send_notification([
            'lead'=> $lead,
            'message'=> 'File added By '
        ]);
        return redirect()->back()->with('success', 'Document Added Successfully!');
    }

    public function delete_file(Request $request,$id)
    {
        session()->put('tab','file');
        $document = Document::findOrFail($id);
        if ($document->file && file_exists('assets/files/'.$document->file)) {
                unlink('assets/files/'.$document->file);
            } 
        $document->delete();
        return redirect()->back()->with('success', 'Document Deleted Successfully!');
    }

    public function import(Request $request)
    {
        if ($request->has('file')) {
			$file = $request->file('file');
			// $import_data = Excel::import(new LeadsImport('admin'), $file);
			$import = new LeadsImport('admin');
			Excel::import($import, $file);

			// Get the result from the import and return it as JSON
			$result = $import->getResult();
			$total = $result['total_count']-$result['exit_count_records'];

			return redirect()->back()->with(array('success' => 'File Uploded Successfully! total '.$total.' record inserted', 'result' => $result));
		}
        return redirect()->back()->with('error', 'Please choose valide Execl file To upload!');
    }

    public function send_notification($data)
    {
        $users = Employee::all();
        $admins = Admin::where('id','!=',auth('admin')->user()->id)->get();
        // $arr = [];
        foreach($users as $user){
            // $arr[] = permission($user,'Lead');
            if(permission($user,'Lead') || ($data['lead'] && $data['lead']->user_id == $user->id)){
                $user->notify(new UserNotification([
                    'lead_id'=> $data['lead']->id,
                    'message'=> $data['message'].auth('admin')->user()->name,
                    'url'=>$data['lead']?route('employee.leads.details',$data['lead']->id):route('employee.leads.list')
                ]));
            }
        }
        // dd($users,$arr);
        foreach($admins as $admin){
            $admin->notify(new UserNotification([
                'lead_id'=> $data['lead']->id,
                'message'=> $data['message'].auth('admin')->user()->name,
                'url'=>$data['lead']?route('admin.leads.details',$data['lead']->id):route('admin.leads.list')
            ])); 
        }
        
        auth('admin')->user()->notify(new UserNotification([
            'lead_id'=> $data['lead']->id,
            'message'=> $data['message'].'You',
            'url'=>$data['lead']?route('admin.leads.details',$data['lead']->id):route('admin.leads.list')
        ]));
        
    }
}
