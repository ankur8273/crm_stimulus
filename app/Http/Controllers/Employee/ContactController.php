<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Employee;
use App\Models\Admin;
use App\Models\Lead;
use App\Models\Contact;
use App\Models\ContactNote;
use App\Models\ContactCall;
use App\Models\Document;
use Illuminate\Support\Facades\Notification;
use DB;
use App\Notifications\UserNotification;
use App\Notifications\SendEmailNotification;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $name = null;
        $email = null;
        $phone = null;
        $date = null;
        $start = null;
        $end = null;
        $status = null;
        $frstcontact = Contact::first();
        if($frstcontact){
            $start = date('Y-m-d',strtotime($frstcontact->created_at));
            $end = date('Y-m-d',strtotime('+ 2 days'));
        }else{
            $start = date('Y-m-d',strtotime('today - 1 days'));
            $end = date('Y-m-d',strtotime('+ 2 days'));
        }
        // dd($request);
        if(has_permission('Contact')){
            $contacts = Contact::orderBy('id','desc');
        }else{
            $contacts = Contact::where('user_id',auth('employee')->user()->id)->orderBy('id','desc');
        }
        
        if ($request->name) {
            $name = $request->name;
            $contacts = $contacts->where('first_name','like','%'.$request->name.'%')->orWhere('last_name','like','%'.$request->name.'%');
        }
        if ($request->email) {
            $email = $request->email;
            $contacts = $contacts->where('email',$request->email);
        }

        if ($request->phone) {
            $phone = $request->phone;
            $contacts = $contacts->where('phone','like','%'.$request->phone.'%');
        }

        if ($request->status) {
            $status = $request->status;
            if($status=='active'){
                $contacts = $contacts->where('status',1);
            }else{
                $contacts = $contacts->where('status',0);
            }
            
        }

        if ($request->date) {
            $date = $request->date;
            $start = str_replace(' ','',explode('-',$date)[0]);
            $end = str_replace(' ','',explode('-',$date)[1]);
            $contacts = $contacts->where('created_at','>=',date('Y-m-d 00:00:00',strtotime($start)))->where('created_at','<=',date('Y-m-d 23:59:59',strtotime($end)));
        }
        $contacts = $contacts->get()->take(4000);
        return view('employee.contact.index',compact('contacts','name','email','phone','status','date','start','end'));
    }

    public function details(Request $request,$id)
    {
        $contact = Contact::findOrFail($id);
        
        // get previous user id
        $previous = Contact::where('id', '<', $contact->id)->max('id');
    
        // get next user id
        $next = Contact::where('id', '>', $contact->id)->min('id');
        $total = Contact::count();
        $leadnotes = ContactNote::where('contact_id',$contact->id)->orderBy('id','desc')->get();
        $callnotes = ContactCall::where('contact_id',$contact->id)->orderBy('id','desc')->get();
        $documents = Document::where('contact_id',$contact->id)->orderBy('id','desc')->get();
        $leaddates = ContactNote::query()
                                    ->select(
                                       DB::raw('DATE(created_at) as created_date')
                                    )
                                    ->where('contact_id',$contact->id)
                                    ->groupBy(DB::raw('created_date'))
                                    ->orderBy(DB::raw('created_date'),'desc')
                                    ->pluck('created_date');
        
        $calldates = ContactCall::query()
                                    ->select(
                                       DB::raw('DATE(created_at) as created_date')
                                    )
                                    ->where('contact_id',$contact->id)
                                    ->groupBy(DB::raw('created_date'))
                                    ->orderBy(DB::raw('created_date'),'desc')
                                    ->pluck('created_date');
        $documentdates = Document::query()
                                    ->select(
                                       DB::raw('DATE(created_at) as created_date')
                                    )
                                    ->where('contact_id',$contact->id)
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
        return view('employee.contact.details',compact('contact','previous','next','total','leadnotes','callnotes','documents','activitieDates'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'first_name' => 'required|max:255',
            'phone' => 'required|max:255',
            'email' => 'required|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            
        ]);

        $data=$request->all();
        unset($data['_token']);

        $contact = new Contact();
        if($request->hasFile('profile_image')){
            $file = $request->file('profile_image');
            $extension = $file->getClientOriginalExtension();
            $image = time().rand().'.'.$extension;
            $file->move('assets/img/contact/', $image);

            $contact->image = $image;
        }
        $contact->first_name = $request->first_name;
        $contact->last_name = $request->last_name;
        $contact->lead_id = $request->lead_id;
        $contact->user_id = $request->user_id;
        $contact->phone = $request->phone;
        $contact->alt_phone = $request->alt_phone;
        $contact->email = $request->email;
        $contact->job_title = $request->job_title;
        $contact->Company_name = $request->Company_name;

        $contact->reviews = $request->reviews;
        $contact->comment = $request->comment;
        
        $contact->data = json_encode($data);
        $contact->save();
        return redirect()->back()->with('success', 'Added Successfully!');
    }

    public function update(Request $request)
    {
        // dd($request);
        $request->validate([
            'first_name' => 'required|max:255',
            'phone' => 'required|max:255',
            'email' => 'required|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            
        ]);

        $data=$request->all();
        unset($data['_token']);

        $contact = Contact::findOrFail($request->contact_id);
        if($request->hasFile('profile_image')){
            $file = $request->file('profile_image');
            $extension = $file->getClientOriginalExtension();
            $image = time().rand().'.'.$extension;
            $file->move('assets/img/contact/', $image);

            $contact->image = $image;
        }
        $contact->first_name = $request->first_name;
        $contact->last_name = $request->last_name;
        $contact->lead_id = $request->lead_id;
        $contact->user_id = $request->user_id;
        $contact->phone = $request->phone;
        $contact->alt_phone = $request->alt_phone;
        $contact->email = $request->email;
        $contact->job_title = $request->job_title;
        $contact->Company_name = $request->Company_name;

        $contact->reviews = $request->reviews;
        $contact->comment = $request->comment;
        
        $contact->address = json_encode($request->address);
        $contact->socials = json_encode($request->social);
        $contact->status = $request->status==1?1:0;
        $contact->data = json_encode($data);
        $contact->save();
        return redirect()->back()->with('success', 'Updated Successfully!');
    }

    public function delete(Request $request,$id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        $this->send_notification([
            'contact'=> null,
            'message'=> 'Contact Deleted By '
        ]);
        return redirect()->route('employee.contact.list')->with('success', 'Deleted Successfully!');
    }

    public function add_note(Request $request,$id)
    {
        session()->put('tab','note');
        $contact = Contact::findOrFail($id);
        $contactnote = new ContactNote();
        if($request->hasFile('file')){
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $original_file_name = $file->getClientOriginalName();
            $files = rand().'-'.$original_file_name;
            // $files = time().rand().'.'.$extension;
            $file->move('assets/img/contact/', $files);

            $contactnote->file = $files;
        }
        $contactnote->contact_id = $contact->id;
        $contactnote->user_id = auth('employee')->user()->id;
        $contactnote->title = $request->title;
        $contactnote->note = $request->note;
        $contactnote->save();
        $this->send_notification([
            'contact'=> $contact,
            'message'=> 'Contact note added By '
        ]);
        return redirect()->back()->with('success', 'Note Added Successfully!');
    }

    public function add_comment(Request $request)
    {
        // dd($request);
        session()->put('tab','note');
        $note = '<div class="reply-box">
                   '.$request->new_comment.'
                   <p>Commented by <span class="text-primary">'.auth('employee')->user()->name.'</span> on '.date('d M Y, h:i a').'</p>
                </div>';
        $contactnote = ContactNote::findOrFail($request->note_id);
        $contactnote->comments = $contactnote->comments?($contactnote->comments.$note):$note;
        $contactnote->save();
        $this->send_notification([
            'contact_id'=> $contactnote->contact_id,
            'message'=> 'note comment on Contact added By '
        ]);
        return redirect()->back()->with('success', 'Comment Added Successfully!');
    }

    public function delete_note(Request $request,$id)
    {
        $contactnote = ContactNote::findOrFail($id);
        if ($contactnote->file && file_exists('assets/img/contact/'.$contactnote->file)) {
                unlink('assets/img/contact/'.$contactnote->file);
            } 
        $contactnote->delete();
        session()->put('tab','note');
        return redirect()->back()->with('success', 'Note Deleted Successfully!');
    }

    public function add_call(Request $request,$id)
    {
        // dd($request);
        session()->put('tab','call');
        $contact = Contact::findOrFail($id);
        $callnote = new ContactCall();
        
        $callnote->contact_id = $contact->id;
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
            'contact'=> $contact,
            'message'=> 'call note on Contact added By '
        ]);
        return redirect()->back()->with('success', 'Note Added Successfully!');
    }

    public function delete_callNote(Request $request,$id)
    {
        $callnote = ContactCall::findOrFail($id);
        
        $callnote->delete();
        session()->put('tab','call');
        return redirect()->back()->with('success', 'Note Deleted Successfully!');
    }

    public function add_file(Request $request,$id)
    {

        $request->validate([
            'title' => 'required|max:255',
            'note' => 'required|max:255',
            'file' => 'required|max:255',
            
        ]);
        // dd($request);
        session()->put('tab','file');
        $contact = Contact::findOrFail($request->contact_id);
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
        $document->contact_id = $contact->id;
        $document->user_id = auth('employee')->user()->id;
        $document->title = $request->title;
        $document->note = $request->note;
        $document->save();
        $this->send_notification([
            'contact'=> $contact,
            'message'=> 'File added on Contact added By '
        ]);
        return redirect()->back()->with('success', 'Document Added Successfully!');
    }

    public function delete_file(Request $request,$id)
    {
        $document = Document::findOrFail($id);
        if ($document->file && file_exists('assets/files/'.$document->file)) {
                unlink('assets/files/'.$document->file);
            } 
        $document->delete();
        session()->put('tab','file');
        return redirect()->back()->with('success', 'Document Deleted Successfully!');
    }

    public function send_notification($data)
    {
        $users = Employee::where('id','!=',auth('employee')->user()->id)->get();
        $admins = Admin::all();
        // $arr = [];
        foreach($users as $user){
            // $arr[] = permission($user,'Lead');
            if(permission($user,'Contact')  || ($data['contact'] &&  $data['contact']->user_id == $user->id)){
                $user->notify(new UserNotification([
                    'contact_id'=> $data['contact']?$data['contact']->id:'',
                    'message'=> $data['message'].auth('employee')->user()->first_name.' '.auth('employee')->user()->last_name,
                    'url'=>$data['contact']?route('employee.contact.details',$data['contact']->id):route('employee.contact.list')
                ]));
            }
        }
        // dd($users,$arr);
        foreach($admins as $admin){
                $admin->notify(new UserNotification([
                    'contact_id'=> $data['contact']?$data['contact']->id:'',
                    'message'=> $data['message'].auth('employee')->user()->first_name.' '.auth('employee')->user()->last_name,
                    'url'=>$data['contact']?route('admin.contact.details',$data['contact']->id):route('admin.contact.list')
                ]));
        }
        
        auth('employee')->user()->notify(new UserNotification([
            'contact_id'=> $data['contact']?$data['contact']->id:'',
            'message'=> $data['message'].'You',
            'url'=>$data['contact']?route('employee.contact.details',$data['contact']->id):route('employee.contact.list')
        ]));
    }
}
