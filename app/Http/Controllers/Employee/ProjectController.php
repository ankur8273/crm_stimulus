<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Contact;
use App\Models\Employee;
use App\Models\Admin;
use App\Models\Lead;
use App\Models\ContactNote;
use App\Models\ContactCall;
use App\Models\Document;
use App\Models\Project;
use Illuminate\Support\Facades\Notification;
use DB;
use App\Notifications\UserNotification;
use App\Notifications\SendEmailNotification;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $name = null;
        
        $date = null;
        $start = null;
        $end = null;
        $status = null;
        $frstproject = Project::first();
        if($frstproject){
            $start = date('Y-m-d',strtotime($frstproject->created_at));
            $end = date('Y-m-d',strtotime('+ 2 days'));
        }else{
            $start = date('Y-m-d',strtotime('today - 1 days'));
            $end = date('Y-m-d',strtotime('+ 2 days'));
        }
        // dd($request);
        if(has_permission('Project')){
            $projects = Project::orderBy('id','desc');
        }else{
            $projects = Project::where('user_id',auth('employee')->user()->id)->orderBy('id','desc');
        }
        
        if ($request->name) {
            $name = $request->name;
            $projects = $projects->where('name','like','%'.$request->name.'%');
        }
        

        if ($request->status) {
            $status = $request->status;
            if($status=='active'){
                $projects = $projects->where('status',1);
            }else{
                $projects = $projects->where('status',0);
            }
            
        }

        if ($request->date) {
            $date = $request->date;
            $start = str_replace(' ','',explode('-',$date)[0]);
            $end = str_replace(' ','',explode('-',$date)[1]);
            $projects = $projects->where('created_at','>=',date('Y-m-d 00:00:00',strtotime($start)))->where('created_at','<=',date('Y-m-d 23:59:59',strtotime($end)));
        }
        $projects = $projects->get()->take(4000);
        return view('employee.projects.index',compact('projects','name','status','date','start','end'));
    }

    public function details(Request $request,$id)
    {
        $project = Project::findOrFail($id);
        
        // get previous user id
        $previous = Project::where('id', '<', $project->id)->max('id');
    
        // get next user id
        $next = Project::where('id', '>', $project->id)->min('id');
        $total = Project::count();
        
        return view('employee.projects.details',compact('project','previous','next','total'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'project_name' => 'required|max:255',
            'project_location' => 'required|max:255',
            'project_city' => 'required|max:255',
            
        ]);

        $data=$request->all();
        unset($data['_token']);

        $project = new Project();
        if($request->hasFile('file')){
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $original_file_name = $file->getClientOriginalName();
            $files = rand().'-'.$original_file_name;
            // $files = time().rand().'.'.$extension;
            $file->move('assets/img/project/', $files);

            $project->file = $files;
        }
        $project->name = $request->project_name;
        $project->location = $request->project_location;
        $project->city = $request->project_city;
        $project->user_id = $request->user_id;
        $project->property_category = $request->property_category?implode(',',$request->property_category):'';
        $project->property_type = $request->property_type?implode(',',$request->property_type):'';
        $project->project_land_parcel = $request->project_land_parcel;
        $project->project_open_area = $request->project_open_area;
        $project->no_of_towers = $request->no_of_towers;

        $project->inventory_per_floor = $request->inventory_per_floor;
        $project->carpet_area_range = $request->carpet_area_range;
        $project->costing_range = $request->costing_range;
        $project->contact_person = $request->contact_person;
        $project->spokes_person_Contact = $request->spokes_person_Contact;
        $project->customer_project_kit = $request->customer_project_kit;
        $project->office_project_kit = $request->office_project_kit;
        $project->developed_by = $request->developed_by;
        $project->note = $request->note;
        $project->status = $request->project_status ;
        
        $project->data = json_encode($data);
        $project->save();
        return redirect()->back()->with('success', 'Added Successfully!');
    }

    public function update(Request $request)
    {
        // dd($request); 
        $request->validate([
            'project_name' => 'required|max:255',
            'project_location' => 'required|max:255',
            'project_city' => 'required|max:255',
            
        ]);

        $data=$request->all();
        unset($data['_token']);

        $project = Project::findOrFail($request->id);
        if($request->hasFile('file')){
            if ($project->file && file_exists('assets/img/project/'.$project->file)) {
                unlink('assets/img/project/'.$project->file);
            } 
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $original_file_name = $file->getClientOriginalName();
            $files = rand().'-'.$original_file_name;
            // $files = time().rand().'.'.$extension;
            $file->move('assets/img/project/', $files);

            $project->file = $files;
        }
        $project->name = $request->project_name;
        $project->location = $request->project_location;
        $project->city = $request->project_city;
        $project->user_id = $request->user_id;
        $project->property_category = $request->property_category?implode(',',$request->property_category):'';
        $project->property_type = $request->property_type?implode(',',$request->property_type):'';
        $project->project_land_parcel = $request->project_land_parcel;
        $project->project_open_area = $request->project_open_area;
        $project->no_of_towers = $request->no_of_towers;

        $project->inventory_per_floor = $request->inventory_per_floor;
        $project->carpet_area_range = $request->carpet_area_range;
        $project->costing_range = $request->costing_range;
        $project->contact_person = $request->contact_person;
        $project->spokes_person_Contact = $request->spokes_person_Contact;
        $project->customer_project_kit = $request->customer_project_kit;
        $project->office_project_kit = $request->office_project_kit;
        $project->developed_by = $request->developed_by;
        $project->note = $request->note;
        $project->status = $request->project_status ;
        
        $project->data = json_encode($data);
        $project->save();
        return redirect()->back()->with('success', 'Updated Successfully!');
    }

    public function change_status(Request $request,$id)
    {
        // dd($request,$id);
        $project = Project::findOrFail($id);
        
        $project->status = $request->status;
        
        $project->save();
        $this->send_notification([
            'project'=> $project,
            'message'=> 'Project status changed By '
        ]);
        return redirect()->route('employee.project.list')->with('success', 'Status Updated Successfully!');
    }

    public function delete(Request $request,$id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return redirect()->back()->with('success', 'Deleted Successfully!');
    }

    public function image_delete(Request $request,$id)
    {
        // dd($request,$id);
        $project = Project::findOrFail($id);

        $farr = $project->images?json_decode($project->images,1):[];
        $arr2 = [];
        foreach($farr as $key=>$value){
            if($key != $request->id){
                $arr2[] = $value;
            }
        }
        
        $project->images = json_encode($arr2);
        
        $project->save();
        return redirect()->back()->with('success', 'Image Deleted Successfully!');
    }

    public function add_images(Request $request,$id)
    {
        // dd($request);
        $project = Project::findOrFail($id);
        if($request->hasFile('files')){
            $farr = $project->images?json_decode($project->images,1):[];
            $files = $request->file('files');
            foreach ($files as $key => $file) {
                $extension = $file->getClientOriginalExtension();
                $original_file_name = $file->getClientOriginalName();
                $files = rand().'-'.$original_file_name;
                // $files = time().rand().'.'.$extension;
                $file->move('assets/img/project/', $files);
                $farr[] = $files;
            }
            $project->images = json_encode($farr);
        }
        
        $project->save();
        $this->send_notification([
            'project'=> $project,
            'message'=> 'Images added on Project By '
        ]);
        return redirect()->back()->with('success', 'Image Uploded Successfully!');
    }

    public function add_user(Request $request,$id)
    {
        // dd($request,$id);
        $project = Project::findOrFail($id);
        
        $project->user_id = $request->user_id;
        
        $project->save();
        $this->send_notification([
            'project'=> $project,
            'message'=> 'Owner added on Project By '
        ]);
        return redirect()->back()->with('success', 'Updated Successfully!');
    }


    public function file_delete(Request $request,$id)
    {
        // dd($request,$id);
        $project = Project::findOrFail($id);

        $farr = $project->files?json_decode($project->files,1):[];
        $arr2 = [];
        foreach($farr as $key=>$value){
            if($key != $request->id){
                $arr2[] = $value;
            }
        }
        
        $project->files = json_encode($arr2);
        
        $project->save();
        return redirect()->back()->with('success', 'File Deleted Successfully!');
    }

    public function add_files(Request $request,$id)
    {
        // dd($request);
        $project = Project::findOrFail($id);
        if($request->hasFile('files')){
            $farr = $project->files?json_decode($project->files,1):[];
            $files = $request->file('files');
            foreach ($files as $key => $file) {
                $extension = $file->getClientOriginalExtension();
                $original_file_name = $file->getClientOriginalName();
                $files = rand().'-'.$original_file_name;
                // $files = time().rand().'.'.$extension;
                $file->move('assets/img/project/', $files);
                $farr[] = $files;
            }
            $project->files = json_encode($farr);
        }
        
        $project->save();
        $this->send_notification([
            'project'=> $project,
            'message'=> 'Some Files added on Project By '
        ]);
        return redirect()->back()->with('success', 'Image Uploded Successfully!');
    }

    public function send_notification($data)
    {
        $users = Employee::where('id','!=',auth('employee')->user()->id)->get();
        $admins = Admin::all();
        // $arr = [];
        foreach($users as $user){
            // $arr[] = permission($user,'Lead');
            if(permission($user,'Project') || $data['project']->user_id == $user->id){
                $user->notify(new UserNotification([
                    'project_id'=> $data['project']?$data['project']->id:'',
                    'message'=> $data['message'].auth('employee')->user()->first_name.' '.auth('employee')->user()->last_name,
                    'url'=>$data['project']?route('employee.project.details',$data['project']->id,):route('employee.project.list')
                ]));
            }
        }
        // dd($users,$arr);
        foreach($admins as $admin){
            $admin->notify(new UserNotification([
                'project_id'=> $data['project']?$data['project']->id:'',
                'message'=> $data['message'].auth('employee')->user()->first_name.' '.auth('employee')->user()->last_name,
                'url'=>$data['project']?route('admin.project.details',$data['project']->id,):route('admin.project.list')
            ])); 
        }
        
        auth('employee')->user()->notify(new UserNotification([
            'project_id'=> $data['project']?$data['project']->id:'',
            'message'=> $data['message'].'You',
            'url'=>$data['project']?route('admin.project.details',$data['project']->id,):route('admin.project.list')
        ]));
    }

}
