<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Lead;
use App\Models\Contact;
use App\Models\ContactNote;
use App\Models\ContactCall;
use App\Models\Document;
use App\Models\Project;
use App\Models\Property;
use App\Models\Employee;
use App\Models\Admin;
use DB;

use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;
use App\Notifications\SendEmailNotification;


class PropertiesController extends Controller
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
        $frstproperty = Property::first();
        if($frstproperty){
            $start = date('Y-m-d',strtotime($frstproperty->created_at));
            $end = date('Y-m-d',strtotime('+ 2 days'));
        }else{
            $start = date('Y-m-d',strtotime('today - 1 days'));
            $end = date('Y-m-d',strtotime('+ 2 days'));
        }
        // dd($request);
        $properties = Property::orderBy('id','desc');
        if ($request->name) {
            $name = $request->name;
            $properties = $properties->where('name','like','%'.$request->name.'%');
        }
        

        if ($request->status) {
            $status = $request->status;
            if($status=='active'){
                $properties = $properties->where('status',1);
            }else{
                $properties = $properties->where('status',0);
            }
            
        }
		if(has_permission('Project')){
            $properties = $properties->where('user_id',auth('employee')->user()->id)->orderBy('id','desc');
        }else{
			$properties = $properties->where('user_id',auth('employee')->user()->id)->orderBy('id','desc');
		}
        

        if ($request->date) {
            $date = $request->date;
            $start = str_replace(' ','',explode('-',$date)[0]);
            $end = str_replace(' ','',explode('-',$date)[1]);
            $properties = $properties->where('created_at','>=',date('Y-m-d 00:00:00',strtotime($start)))->where('created_at','<=',date('Y-m-d 23:59:59',strtotime($end)));
        }
        $properties = $properties->get()->take(4000);
        return view('employee.properties.index',compact('properties','name','status','date','start','end'));
    }

    public function details(Request $request,$id)
    {
        $property = Property::findOrFail($id);
        
        // get previous user id
        $previous = Property::where('id', '<', $property->id)->max('id');
    
        // get next user id
        $next = Property::where('id', '>', $property->id)->min('id');
        $total = Property::count();
        
        return view('employee.properties.details',compact('property','previous','next','total'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
            // 'project_name' => 'required|max:255',
            // 'project_location' => 'required|max:255',
            // 'project_city' => 'required|max:255',
            
        ]);

        $data=$request->all();
        unset($data['_token']);

        $property = new Property();
        
        $property->name = $request->property_name;
        $property->project_id = $request->project;
        $property->city = $request->city;
        $property->property_category = $request->property_category;
        $property->property_type = $request->property_type;
        $property->unit_type = $request->unit_type;
        $property->unit_no = $request->unit_no;
        $property->furnishing = $request->furnishing;
        $property->availability = $request->availability;
        $property->covered_parking = $request->covered_parking;
        $property->open_parking = $request->open_parking;
        $property->bathrooms = $request->bathrooms;
        $property->ownership = $request->ownership;
        $property->other_details = $request->other_details;
        $property->buildup_area_dimensions = $request->buildup_area_dimensions;
        $property->buildup_area = $request->buildup_area;
        $property->carpet_area_dimensions = $request->carpet_area_dimensions;
        $property->carpet_area = $request->carpet_area;
        $property->super_area_dimensions = $request->super_area_dimensions;
        $property->super_area = $request->super_area;
        $property->length_dimensions = $request->length_dimensions;
        $property->lengths = $request->length;
        $property->breadth_dimensions = $request->breadth_dimensions;
        $property->breadth = $request->breadth;
        $property->plot_area_dimensions = $request->plot_area_dimensions;
        $property->plot_area = $request->plot_area;
        $property->expecte_pricing = $request->expecte_pricing;
        $property->project_open_area = $request->project_open_area;
        $property->price_negotiable = $request->price_negotiable;
        $property->seller_type = $request->seller_type;
        $property->seller_name = $request->seller_name;
        $property->seller_mobile = $request->seller_mobile;
        $property->seller_alt_mobile = $request->seller_alt_mobile;
        $property->seller_email = $request->seller_email;
        $property->seller_address = $request->seller_address;
        $property->status = $request->status?1:0 ;
		$property->user_id = $request->user_id;
        
        $property->data = json_encode($data);
        $property->save();
        return redirect()->back()->with('success', 'Added Successfully!');
    }

    public function update(Request $request)
    {
        // dd($request); 
        // $request->validate([
        //     'project_name' => 'required|max:255',
        //     'project_location' => 'required|max:255',
        //     'project_city' => 'required|max:255',
            
        // ]);
	

        $data=$request->all();
        unset($data['_token']);
	
        $property = Property::findOrFail($request->id);
		
        if($request->hasFile('file')){
            if ($property->file && file_exists('assets/img/project/'.$project->file)) {
                unlink('assets/img/project/'.$project->file);
            } 
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $original_file_name = $file->getClientOriginalName();
            $files = rand().'-'.$original_file_name;
            // $files = time().rand().'.'.$extension;
            $file->move('assets/img/project/', $files);

            $property->file = $files;
        }
        
        
        $property->name = $request->property_name;
        $property->project_id = $request->project;
        $property->city = $request->city;
        $property->property_category = $request->property_category;
        $property->property_type = $request->property_type;
        $property->unit_type = $request->unit_type;
        $property->unit_no = $request->unit_no;
        $property->furnishing = $request->furnishing;
        $property->availability = $request->availability;
        $property->covered_parking = $request->covered_parking;
        $property->open_parking = $request->open_parking;
        $property->bathrooms = $request->bathrooms;
        $property->ownership = $request->ownership;
        $property->other_details = $request->other_details;
        $property->buildup_area_dimensions = $request->buildup_area_dimensions;
        $property->buildup_area = $request->buildup_area;
        $property->carpet_area_dimensions = $request->carpet_area_dimensions;
        $property->carpet_area = $request->carpet_area;
        $property->super_area_dimensions = $request->super_area_dimensions;
        $property->super_area = $request->super_area;
        $property->length_dimensions = $request->length_dimensions;
        $property->lengths = $request->length;
        $property->breadth_dimensions = $request->breadth_dimensions;
        $property->breadth = $request->breadth;
        $property->plot_area_dimensions = $request->plot_area_dimensions;
        $property->plot_area = $request->plot_area;
        $property->expecte_pricing = $request->expecte_pricing;
        $property->project_open_area = $request->project_open_area;
        $property->price_negotiable = $request->price_negotiable;
        $property->seller_type = $request->seller_type;
        $property->seller_name = $request->seller_name;
        $property->seller_mobile = $request->seller_mobile;
        $property->seller_alt_mobile = $request->seller_alt_mobile;
        $property->seller_email = $request->seller_email;
        $property->seller_address = $request->seller_address;
        $property->status = $request->status?1:0 ;
        
        $property->data = json_encode($data);
        $property->save();
        return redirect()->back()->with('success', 'Updated Successfully!');
    }

    public function change_status(Request $request,$id)
    {
        // dd($request,$id);
        $property = Property::findOrFail($id);
        
        $property->status = $request->status;
        
        $property->save();
        $this->send_notification([
            'property'=> $property,
            'message'=> 'Property Status By '
        ]);
        return redirect()->route('employee.properties.list')->with('success', 'Status Updated Successfully!');
    }

    public function delete(Request $request,$id)
    {
        $property = Property::findOrFail($id);
        $property->delete();
        $this->send_notification([
            'property'=> null,
            'message'=> 'Property Deleted By '
        ]);
        return redirect()->back()->with('success', 'Deleted Successfully!');
    }

    public function image_delete(Request $request,$id)
    {
        // dd($request,$id);
        $property = Property::findOrFail($id);

        $farr = $property->images?json_decode($property->images,1):[];
        $arr2 = [];
        foreach($farr as $key=>$value){
            if($key != $request->id){
                $arr2[] = $value;
            }
        }
        
        $property->images = json_encode($arr2);
        
        $property->save();
        return redirect()->back()->with('success', 'Image Deleted Successfully!');
    }

    public function add_images(Request $request,$id)
    {
        // dd($request);
        $property = Property::findOrFail($id);
        if($request->hasFile('files')){
            $farr = $property->images?json_decode($property->images,1):[];
            $files = $request->file('files');
            foreach ($files as $key => $file) {
                $extension = $file->getClientOriginalExtension();
                $original_file_name = $file->getClientOriginalName();
                $files = rand().'-'.$original_file_name;
                // $files = time().rand().'.'.$extension;
                $file->move('assets/img/property/', $files);
                $farr[] = $files;
            }
            $property->images = json_encode($farr);
        }
        
        $property->save();
        $this->send_notification([
            'property'=> $property,
            'message'=> 'Some Files added on Property By '
        ]);
        return redirect()->back()->with('success', 'Image Uploded Successfully!');
    }

    public function add_user(Request $request,$id)
    {
        // dd($request,$id);
        $property = Property::findOrFail($id);
        
        $property->user_id = $request->user_id;
        
        $property->save();
        $this->send_notification([
            'property'=> $property,
            'message'=> 'Property Owner added By '
        ]);
        return redirect()->back()->with('success', 'Updated Successfully!');
    }


    public function file_delete(Request $request,$id)
    {
        // dd($request,$id);
        $property = Property::findOrFail($id);

        $farr = $property->files?json_decode($property->files,1):[];
        $arr2 = [];
        foreach($farr as $key=>$value){
            if($key != $request->id){
                $arr2[] = $value;
            }
        }
        
        $property->files = json_encode($arr2);
        
        $property->save();
        return redirect()->back()->with('success', 'File Deleted Successfully!');
    }

    public function add_files(Request $request,$id)
    {
        // dd($request);
        $property = Property::findOrFail($id);
        if($request->hasFile('files')){
            $farr = $property->files?json_decode($property->files,1):[];
            $files = $request->file('files');
            foreach ($files as $key => $file) {
                $extension = $file->getClientOriginalExtension();
                $original_file_name = $file->getClientOriginalName();
                $files = rand().'-'.$original_file_name;
                // $files = time().rand().'.'.$extension;
                $file->move('assets/img/property/', $files);
                $farr[] = $files;
            }
            $property->files = json_encode($farr);
        }
        
        $property->save();
        $this->send_notification([
            'property'=> $property,
            'message'=> 'Some Files added on Project By '
        ]);
        return redirect()->back()->with('success', 'Image Uploded Successfully!');
    }

    public function send_notification($data)
    {
        $users = Employee::all();
        $admins = Admin::where('id','!=',auth('admin')->user()->id)->get();
        // $arr = [];
        foreach($users as $user){
            // $arr[] = permission($user,'Lead');
            if(permission($user,'Property') || ($data['property'] && $data['property']->user_id == $user->id)){
                $user->notify(new UserNotification([
                    'property_id'=> $data['property']?$data['property']->id:'',
                    'message'=> $data['message'].auth('admin')->user()->name,
                    'url'=>$data['property']?route('employee.properties.details',$data['property']->id,):route('employee.properties.list')
                ]));
            }
        }
        // dd($users,$arr);
        foreach($admins as $admin){
            $admin->notify(new UserNotification([
                'property_id'=> $data['property']?$data['property']->id:'',
                'message'=> $data['message'].auth('admin')->user()->name,
                'url'=>$data['property']?route('employee.properties.details',$data['property']->id,):route('employee.properties.list')
            ])); 
        }
        
        auth('admin')->user()->notify(new UserNotification([
            'property_id'=> $data['property']?$data['property']->id:'',
            'message'=> $data['message'].'You',
            'url'=>$data['property']?route('employee.properties.details',$data['property']->id,):route('employee.properties.list')
        ]));
        
    }

}
