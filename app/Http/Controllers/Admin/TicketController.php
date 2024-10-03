<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use App\Models\Ticket;
use App\Models\Employee;
use App\Models\Admin;
use App\Models\TicketDetail;

use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;
use App\Notifications\SendEmailNotification;

class TicketController extends Controller
{
    /**
     * Display a listing of the Employee.
     */
    public function index(Request $request)
    {
        // dd($request->all());
        $employee_name = null;
        $status = null;
        $priority = null;
        $from = null;
        $to = null;
        $tickets = Ticket::orderBy('id','desc');
        if($request->status){
            $status = $request->status;
            $tickets = $tickets->where('status',$status);
        }
        if($request->priority){
            $priority = $request->priority;
            $tickets = $tickets->where('priority',$priority);
        }
        if($request->from){
            $from = $request->from;
            $tickets = $tickets->where('created_at','>=',date('Y-m-d H:i:s',strtotime($from)));
        }
        if($request->to){
            $to = $request->to;
            $tickets = $tickets->where('created_at','<=',date('Y-m-d H:i:s',strtotime($to)));
        }
        if($request->employee_name){
            $employee_name = $request->employee_name;
            $employee_ids = Employee::where('first_name','like','%'.$employee_name.'%')->orWhere('last_name','like','%'.$employee_name.'%')->pluck('id');
            $tickets = $tickets->whereIn('id',$employee_ids);
        }
        $new = Ticket::where('status','New')->count();
        $closed = Ticket::whereIn('status',['Closed','Cancelled'])->count();
        $opened = Ticket::whereIn('status',['Opened','In Progress','Reopened'])->count();
        $pending  = Ticket::where('status','On Hold')->count();
        $total  = Ticket::count();

        $tickets = $tickets->get()->take(4000);
        return view('admin.ticket.index',compact('tickets','employee_name','status','priority','from','to','new','closed','opened','pending','total'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $ticket = new Ticket();
        if($request->hasFile('files')){
            $farr = [];
            $files = $request->file('files');
            foreach ($files as $key => $file) {
                $extension = $file->getClientOriginalExtension();
                $original_file_name = $file->getClientOriginalName();
                $files = rand().'-'.$original_file_name;
                // $files = time().rand().'.'.$extension;
                $file->move('assets/img/ticket/', $files);
                $farr[] = $files;
            }
            $ticket->files = json_encode($farr);
        }
        
        $ticket->created_by = 'admin';
        $ticket->user_id = auth('admin')->user()->id;
        $ticket->subject = $request->subject;
        $ticket->details = $request->description;
        $ticket->priority = $request->priority;
        $ticket->save();


        $ticket->ticket_id = $this->randomstring(8).$ticket->id;
        $ticket->save();
        $this->send_notification([
            'ticket'=> $ticket,
            'message'=> 'Ticket Created By '
        ]);

        return redirect()->back()->with('success', 'Ticket Created Successfully!');
    }

    function randomstring($length) {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $str = array(); //remember to declare $str as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $str[] = $alphabet[$n];
        }
        return implode($str); //turn the array into a string
    }

    public function update_status(Request $request,$id)
    {
        // dd($id,$request->all());
        $ticket = Ticket::findOrFail($id);
        $ticket->status = $request->status;
        $ticket->save();
        $this->send_notification([
            'ticket'=> $ticket,
            'message'=> 'Ticket status updated By '
        ]);
        return 1;
    }

    public function details(Request $request,$id)
    {
        $ticket = Ticket::findOrFail($id);
        $images = $ticket->images?json_decode($ticket->images):[];
        $files = $ticket->files?json_decode($ticket->files):[];
        return view('admin.ticket.details',compact('ticket','images','files'));
    }

    public function delete(Request $request,$id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();
        return redirect()->back()->with('success', 'Deleted Successfully!');
    }

    public function send(Request $request,$id)
    {
        // dd($request);
        $ticket = Ticket::findOrFail($id);
        $tdetail = new TicketDetail();
        $tdetail->ticket_id = $ticket->id;
        $tdetail->created_by = 'admin';
        $tdetail->user_id = auth('admin')->user()->id;
        $tdetail->details = $request->massage;
        $tdetail->save();
        $this->send_notification([
            'ticket'=> $ticket,
            'message'=> 'Ticket replied By '
        ]);
        return redirect()->back()->with('success', 'Send Successfully!');
    }

    public function add_images(Request $request,$id)
    {
        $ticket = Ticket::findOrFail($id);
        if($request->hasFile('files')){
            $farr = $ticket->images?json_decode($ticket->images,1):[];
            $files = $request->file('files');
            foreach ($files as $key => $file) {
                $extension = $file->getClientOriginalExtension();
                $original_file_name = $file->getClientOriginalName();
                $files = rand().'-'.$original_file_name;
                // $files = time().rand().'.'.$extension;
                $file->move('assets/img/ticket/', $files);
                $farr[] = $files;
            }
            $ticket->images = json_encode($farr);
        }
        
        $ticket->save();
        $this->send_notification([
            'ticket'=> $ticket,
            'message'=> 'Some images added on ticket By '
        ]);
        return redirect()->back()->with('success', 'Image Uploded Successfully!');
    }

    public function add_files(Request $request,$id)
    {
        // dd($request);
        $ticket = Ticket::findOrFail($id);
        if($request->hasFile('files')){
            $farr = $ticket->files?json_decode($ticket->files,1):[];
            $files = $request->file('files');
            foreach ($files as $key => $file) {
                $extension = $file->getClientOriginalExtension();
                $original_file_name = $file->getClientOriginalName();
                $files = rand().'-'.$original_file_name;
                // $files = time().rand().'.'.$extension;
                $file->move('assets/img/ticket/', $files);
                $farr[] = $files;
            }
            $ticket->files = json_encode($farr);
        }
        
        $ticket->save();
        $this->send_notification([
            'ticket'=> $ticket,
            'message'=> 'Some files added on ticket By '
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
            if(permission($user,'Ticket') || ($data['ticket'] && $data['ticket']->user_id == $user->id)){
                $user->notify(new UserNotification([
                    'ticket_id'=> $data['ticket']?$data['ticket']->id:'',
                    'message'=> $data['message'].auth('admin')->user()->name,
                    'url'=>$data['ticket']?route('employee.ticket.details',$data['ticket']->id,):route('employee.ticket.list')
                ]));
            }
        }
        // dd($users,$arr);
        foreach($admins as $admin){
            $admin->notify(new UserNotification([
                'project_id'=> $data['ticket']?$data['ticket']->id:'',
                'message'=> $data['message'].auth('admin')->user()->name,
                'url'=>$data['ticket']?route('admin.ticket.details',$data['ticket']->id,):route('admin.ticket.list')
            ])); 
        }
        
        auth('admin')->user()->notify(new UserNotification([
            'ticket_id'=> $data['ticket']?$data['ticket']->id:'',
            'message'=> $data['message'].'You',
            'url'=>$data['ticket']?route('admin.ticket.details',$data['ticket']->id,):route('admin.ticket.list')
        ]));
        
    }
    
}
