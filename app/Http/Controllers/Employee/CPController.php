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
use App\Models\ChannelPartner;
use App\Models\ChannelPartnerNote;
use App\Models\Branch;
use App\Models\Employee;
use App\Models\Admin;
 
use App\Models\LeadNote;
use App\Models\CallNote;
 
use App\Exports\LeadExport;
use App\Imports\LeadsImport;

use DB;

use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;
use App\Notifications\SendEmailNotification;


class CPController extends Controller
{
    //
	public function index(Request $request)
    {
        $name = null;
         
        $date = null;
        $start = null;
        $end = null;
        $status = null;
        $frstchannel_partner = ChannelPartner::first();
        if($frstchannel_partner){
            $start = date('Y-m-d',strtotime($frstchannel_partner->created_at));
            $end = date('Y-m-d',strtotime('+ 2 days'));
        }else{
            $start = date('Y-m-d',strtotime('today - 1 days'));
            $end = date('Y-m-d',strtotime('+ 2 days'));
        }
        // dd($request);
        $CPartners = ChannelPartner::orderBy('id','desc');
        if ($request->name) {
            $name = $request->name;
            $CPartners = $CPartners->where('cp_name','like','%'.$request->name.'%');
        }
		$CPartners = ChannelPartner::where('user_id',auth('employee')->user()->id)->orderBy('id','desc');

        if ($request->status) {
            $status = $request->status;
            if($status=='active'){
                $CPartners = $CPartners->where('cp_status',1);
            }else{
                $CPartners = $CPartners->where('cp_status',0);
            }
            
        }

        if ($request->date) {
            $date = $request->date;
            $start = str_replace(' ','',explode('-',$date)[0]);
            $end = str_replace(' ','',explode('-',$date)[1]);
            $CPartners = $CPartners->where('created_at','>=',date('Y-m-d 00:00:00',strtotime($start)))->where('created_at','<=',date('Y-m-d 23:59:59',strtotime($end)));
        }
        $CPartners = $CPartners->get()->take(4000);
        return view('employee.channel_partner.index',compact('CPartners','name','status','date','start','end'));
    }
	public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'cp_name' => 'required|max:255',
            'phone' => [
				'required',
				'regex:/^(\+?\d{1,3}[- ]?)?(\(?\d{3}\)?[- ]?)?[\d\-\s]{7,10}$/',
				'unique:channel_partners,phone'
			],
			'alt_phone' => [
				'regex:/^(\+?\d{1,3}[- ]?)?(\(?\d{3}\)?[- ]?)?[\d\-\s]{7,10}$/',
			],
            'user_id' => 'required|max:255',
			'address' => 'required|max:255',
            
        ]);

        $data=$request->all();
        unset($data['_token']);
        $channel_partner = new ChannelPartner();
        $channel_partner->cp_name = $request->cp_name;
        $channel_partner->phone = $request->phone;
		$channel_partner->address_type = $request->address_type;
		$channel_partner->address = $request->address;
		$channel_partner->status = $request->cp_status;
		$channel_partner->alt_phone = $request->alt_phone;
		$channel_partner->user_id = $request->user_id;  
		$channel_partner->branch_id = $request->branch_id; 
		$channel_partner->looking_for = $request->looking_for;  
        $channel_partner->data = json_encode($data);
        $channel_partner->save();
        return response()->json([
            'success' => true,
            'message' => 'Added successfully!',
		]);

    }


	public function change_status(Request $request,$id)
    {
        // dd($request,$id);
        $CPartner = ChannelPartner::findOrFail($id);
        
        $CPartner->status = $request->status;
        
        $CPartner->save();
        $this->send_notification([
            'cpartner'=> $CPartner,
            'message'=> 'Channel Partner Status By '
        ]);
        return redirect()->route('employee.channel-partner.list')->with('success', 'Status Updated Successfully!');
    }


	public function delete(Request $request,$id)
    {
        $cpartner = ChannelPartner::findOrFail($id);
        $cpartner->delete();
        $this->send_notification([
            'cpartner'=> null,
            'message'=> 'Channel Partner Deleted By '
        ]);
        return redirect()->back()->with('success', 'Deleted Successfully!');
    }

	public function update(Request $request)
    {
        // dd($request); 
		$channel_partner = ChannelPartner::findOrFail($request->id);
        $request->validate([
            'cp_name' => 'required|max:255',
            'phone' => [
				'required',
				'regex:/^(\+?\d{1,3}[- ]?)?(\(?\d{3}\)?[- ]?)?[\d\-\s]{7,10}$/',
				'unique:channel_partners,phone,'.$channel_partner->id
			],
			'alt_phone' => [
				'regex:/^(\+?\d{1,3}[- ]?)?(\(?\d{3}\)?[- ]?)?[\d\-\s]{7,10}$/',
			],
            'user_id' => 'required|max:255',
			'address' => 'required|max:255',
            
        ]);

        $data=$request->all();
        unset($data['_token']);

        
        $channel_partner->cp_name = $request->cp_name;
        $channel_partner->phone = $request->phone;
		$channel_partner->address_type = $request->address_type;
		$channel_partner->address = $request->address;
		$channel_partner->status = $request->cp_status;
		$channel_partner->alt_phone = $request->alt_phone;
		$channel_partner->user_id = $request->user_id;  
        $channel_partner->branch_id = $request->branch_id;  
		$channel_partner->looking_for = $request->looking_for; 

        
        $channel_partner->data = json_encode($data);
        $channel_partner->save();
		return response()->json([
            'success' => true,
            'message' => 'Updated successfully!',
		]);
    }

 

	public function details(Request $request,$id)
    {
        $cpartner = ChannelPartner::findOrFail($id);
        
        //  try{
        //     $st = Notification::send(auth('employee')->user(),new SendEmailNotification([
        //         'view' => 'mail.leadassign',
        //         'lead' => $lead,
        //     ]));
        // }
        // catch (Exception $e) {
        //     dd(e);
        // }

        // get previous user id
        $previous = ChannelPartner::where('id', '<', $cpartner->id)->max('id');
    
        // get next user id
        $next = ChannelPartner::where('id', '>', $cpartner->id)->min('id');
        $total = ChannelPartner::count();
        $leadnotes = ChannelPartnerNote::where('channel_partner_id',$cpartner->id)->orderBy('id','desc')->get();
        $callnotes = CallNote::where('channel_partner_id',$cpartner->id)->orderBy('id','desc')->get();
        $documents = Document::where('channel_partner_id',$cpartner->id)->orderBy('id','desc')->get();
        $leaddates = ChannelPartnerNote::query()
                                    ->select(
                                       DB::raw('DATE(created_at) as created_date')
                                    )
                                    ->where('channel_partner_id',$cpartner->id)
                                    ->groupBy(DB::raw('created_date'))
                                    ->orderBy(DB::raw('created_date'),'desc')
                                    ->pluck('created_date');
        
        $calldates = CallNote::query()
                                    ->select(
                                       DB::raw('DATE(created_at) as created_date')
                                    )
                                    ->where('channel_partner_id',$cpartner->id)
                                    ->groupBy(DB::raw('created_date'))
                                    ->orderBy(DB::raw('created_date'),'desc')
                                    ->pluck('created_date');
        $documentdates = Document::query()
                                    ->select(
                                       DB::raw('DATE(created_at) as created_date')
                                    )
                                    ->where('channel_partner_id',$cpartner->id)
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
        $pro_ids = $cpartner->project_ids?explode(',',$cpartner->project_ids):[];
        $projects = Project::whereIn('id',$pro_ids)->get();
        // dd($dates);
        return view('employee.channel_partner.details-cp',compact('cpartner','previous','next','total','leadnotes','callnotes','documents','activitieDates','projects'));
    }

	public function add_images(Request $request,$id)
    {
        // dd($request);
        $cpartner = ChannelPartner::findOrFail($id);
        if($request->hasFile('files')){
            $farr = $cpartner->images?json_decode($cpartner->images,1):[];
            $files = $request->file('files');
            foreach ($files as $key => $file) {
                $extension = $file->getClientOriginalExtension();
                $original_file_name = $file->getClientOriginalName();
                $files = rand().'-'.$original_file_name;
                // $files = time().rand().'.'.$extension;
                $file->move('assets/img/channel_partners/', $files);
                $farr[] = $files;
            }
            $cpartner->images = json_encode($farr);
        }
        
        $cpartner->save();
        $this->send_notification([
            'cpartner'=> $cpartner,
            'message'=> 'Some Files added on Channel Partner By '
        ]);
        return redirect()->back()->with('success', 'Image Uploded Successfully!');
    }

	public function image_delete(Request $request,$id)
    {
        // dd($request,$id);
        $cpartner = ChannelPartner::findOrFail($id);

        $farr = $cpartner->images?json_decode($cpartner->images,1):[];
        $arr2 = [];
        foreach($farr as $key=>$value){
            if($key != $request->id){
                $arr2[] = $value;
            }else{

			$filePath =  ('assets/img/channel_partners/' . $value); // Update the path as necessary
			if (file_exists($filePath)) {
				unlink($filePath); // Remove the file
			}
		  }
        }
        
        $cpartner->images = json_encode($arr2);
        
        $cpartner->save();
        return redirect()->back()->with('success', 'Image Deleted Successfully!');
    }

	 
	public function file_delete(Request $request,$id)
    {
        // dd($request,$id);
        $cpartner = ChannelPartner::findOrFail($id);

        $farr = $cpartner->files?json_decode($cpartner->files,1):[];
        $arr2 = [];
        foreach($farr as $key=>$value){
            if($key != $request->id){
                $arr2[] = $value;
            }else{
				$filePath =  ('assets/img/channel_partners/' . $value); // Update the path as necessary
				if (file_exists($filePath)) {
					unlink($filePath); // Remove the file
				}
			  }
        }
        
        $cpartner->files = json_encode($arr2);
        
        $cpartner->save();
        return redirect()->back()->with('success', 'File Deleted Successfully!');
    }

	public function add_user(Request $request,$id)
    {
        // dd($request,$id);
        $cpartner = ChannelPartner::findOrFail($id);
        $cpartner->user_id = $request->user_id;
        $cpartner->save();
        $this->send_notification([
            'cpartner'=>$cpartner,
            'message'=> 'Channel Partner Owner added By '
        ]);
        return redirect()->back()->with('success', 'Updated Successfully!');
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
        $cpartner = ChannelPartner::findOrFail($request->lead_id);
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
        $document->channel_partner_id = $cpartner->id;
        $document->user_id = auth('employee')->user()->id;
        $document->title = $request->title;
        $document->note = $request->note;
        $document->save();
        $this->send_notification([
            'cpartner'=> $cpartner,
            'message'=> 'File added By '
        ]);
        return redirect()->back()->with('success', 'Document Added Successfully!');
    }
	public function change_CPStatus(Request $request,$id)
    {
        $cpartner = ChannelPartner::findOrFail($id);
        $cpartner->cp_status = $request->status;
        $cpartner->cp_status_remark = $cpartner->cp_status_remark?($cpartner->cp_status_remark.','.$request->status):'Pending,'.$request->status;
        $cpartner->save();
        $this->send_notification([
            'cpartner'=> $cpartner,
            'message'=> 'New Status is '.$request->status.'Channel Partner  Status Changed By '
        ]);
        
        return 1;
    }
	
	public function change_fellowupType(Request $request,$id)
    {
        $cpartner = ChannelPartner::findOrFail($id);
        $cpartner->followup_type = $request->status;
        $cpartner->followup_remark = $cpartner->followup_remark?($cpartner->followup_remark.','.$request->status):'Pending,'.$request->status;
        $cpartner->save();
        $this->send_notification([
            'cpartner'=> $cpartner,
            'message'=> 'New Fellowup Type '.$request->status.' Changed By '
        ]);
        
        return 1;
    }
	public function send_notification($data)
    {
        $users = Employee::all();
        $admins = Admin::where('id','!=',auth('admin')->user()->id)->get();
        // $arr = [];
        foreach($users as $user){
            // $arr[] = permission($user,'Lead');
            if(permission($user,'channel_partner') || ($data['cpartner'] && $data['cpartner']->user_id == $user->id)){
                $user->notify(new UserNotification([
                    'cpartner_id'=> $data['cpartner']?$data['cpartner']->id:'',
                    'message'=> $data['message'].auth('admin')->user()->name,
                    'url'=>$data['cpartner']?route('employee.channel-partner.details',$data['cpartner']->id,):route('employee.channel-partner.list')
                ]));
            }
        }
        // dd($users,$arr);
        foreach($admins as $admin){
            $admin->notify(new UserNotification([
                'cpartner_id'=> $data['cpartner']?$data['cpartner']->id:'',
                'message'=> $data['message'].auth('admin')->user()->name,
                'url'=>$data['cpartner']?route('employee.channel-partner.details',$data['cpartner']->id,):route('employee.channel-partner.list')
            ])); 
        }
        
        auth('admin')->user()->notify(new UserNotification([
            'cpartner_id'=> $data['cpartner']?$data['cpartner']->id:'',
            'message'=> $data['message'].'You',
            'url'=>$data['cpartner']?route('employee.channel-partner.details',$data['cpartner']->id,):route('employee.channel-partner.list')
        ]));
        
    }
    


	   /**
     * Display a listing of the Branch.
     */
    public function branch(Request $request)
    {
        $branchs = Branch::orderBy('id','desc')->get();
        return view('employee.channel_partner.branch',compact('branchs'));
    }

    public function branch_store(Request $request)
    {
        $branch = new Branch();
        $branch->name = $request->name;
		$branch->city = $request->city;
		$branch->state = $request->state;
        $branch->save();

        return redirect()->back()->with('success', 'Branch added Successfully!');
    }

    public function branch_update(Request $request)
    {
        $branch =  Branch::where('id',$request->id)->first();
        $branch->name = $request->name;
		$branch->city = $request->city;
		$branch->state = $request->state;
        $branch->save();

        return redirect()->back()->with('success', 'Branch Updated Successfully!');
    }

    public function branch_delete(Request $request)
    {
        $branch = Branch::where('id',$request->branch_id)->first();
        $cpartner = ChannelPartner::where('branch_id',$request->branch_id)->first();
        if($cpartner){
            return redirect()->back()->with('error', 'First change Channel partner on this branch!');
        }
        $branch->delete();

        return redirect()->back()->with('success', 'Branch Deleted Successfully!');
    }

	public function add_next_fellowup(Request $request,$id)
    {
        $cpartner = ChannelPartner::findOrFail($id);
        $cpartner->next_fellowup_remark = $request->comment;
        $cpartner->next_followup = $request->fellowup;
        $cpartner->next_action_date = $request->fellowup_date;
        $cpartner->save();
        $this->send_notification([
            'cpartner'=> $cpartner,
            'message'=> 'Channel Partner Updated for next fellowup By '
        ]);
        
        return redirect()->back()->with('success', 'Updated Successfully!');
    }
    /**
     * End Display a listing of the Branch.
     */

	 public function add_owner(Request $request,$id)
	 {
		 $cpartner = ChannelPartner::findOrFail($id);
		 $cpartner->user_id = $request->user_id;
		 $cpartner->save();
		 $this->send_notification([
			 'cpartner'=> $cpartner,
			 'message'=> 'Owner added By '
		 ]);
		 
		 
		 return redirect()->back()->with('success', 'Updated Successfully!');
	 }

	 
	 public function add_note(Request $request)
	 {
		 session()->put('tab','note');
		 $cpartner = ChannelPartner::findOrFail($request->cp_id);
		 $cpartnernote = new ChannelPartnerNote();
		 if($request->hasFile('file')){
			 $file = $request->file('file');
			 $extension = $file->getClientOriginalExtension();
			 $original_file_name = $file->getClientOriginalName();
			 $files = rand().'-'.$original_file_name;
			 // $files = time().rand().'.'.$extension;
			 $file->move('assets/img/lead/', $files);
 
			 $cpartnernote->file = $files;
		 }
		 $cpartnernote->channel_partner_id = $cpartner->id;
		 $cpartnernote->user_id = auth('employee')->user()->id;
		 $cpartnernote->title = $request->title;
		 $cpartnernote->note = $request->note;
		 $cpartnernote->save();
		 $this->send_notification([
			 'cpartner'=> $cpartner,
			 'message'=> 'Note By '
		 ]);
		
		 return redirect()->back()->with('success', 'Note Added Successfully!');
	 }
 
	 public function add_comment(Request $request)
	 {
		 session()->put('tab','note');
		 // dd($request);
		 $note = '<div class="reply-box">
					'.$request->new_comment.'
					<p>Commented by <span class="text-primary">'.auth('employee')->user()->name.'</span> on '.date('d M Y, h:i a').'</p>
				 </div>';
		 $cparnernote = ChannelPartnerNote::findOrFail($request->note_id);
		 $cparnernote->comments = $cparnernote->comments?($cparnernote->comments.$note):$note;
		 $cparnernote->save();
		//  $this->send_notification([
		// 	 'lead'=> $cparnernote->lead,
		// 	 'message'=> 'Note Comment By '
		//  ]);
		 return redirect()->back()->with('success', 'Comment Added Successfully!');
	 }
 
	 public function delete_note(Request $request,$id)
	 {
		 session()->put('tab','note');
		 $cpartnernote = ChannelPartnerNote::findOrFail($id);
		 if ($cpartnernote->file && file_exists('assets/img/lead/'.$cpartnernote->file)) {
				 unlink('assets/img/lead/'.$cpartnernote->file);
			 } 
		//  $cpartnernote->delete();
		//  $this->send_notification([
		// 	 'cpartner'=> $cpartnernote->channel_partner,
		// 	 'message'=> 'Note Deleted By '
		//  ]);
		 return redirect()->back()->with('success', 'Note Deleted Successfully!');
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
 
	 public function add_call(Request $request,$id)
	 {
		 session()->put('tab','call');
		 // dd($request);
		 $cpartner = ChannelPartner::findOrFail($id);
		 $callnote = new CallNote();
		 
		 $callnote->channel_partner_id = $cpartner->id;
		 $callnote->user_id = auth('employee')->user()->id;
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
			 'cpartner'=> $cpartner,
			 'message'=> 'Call note added By '
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

}
