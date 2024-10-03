<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Knowledgebase;
use App\Models\KnowledgebaseCategory;

use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;
use App\Notifications\SendEmailNotification;

class KnowledgebaseController extends Controller
{


    /**
     * Display a listing of the Employee.
     */
    public function index(Request $request)
    {
        $categorys = Knowledgebase::groupBy('category')->pluck('category');
        $categories = [];
        foreach($categorys as $cat){
            $categories[$cat] = Knowledgebase::where('category',$cat)->get();
        }
        return view('employee.knowledgebase.index',compact('categories'));
    }
    public function details(Request $request,$id)
    {
        $knowledgebase = Knowledgebase::findOrFail($id);
        $categories = KnowledgebaseCategory::get();
        $latest = Knowledgebase::latest()->get()->take(8);
        return view('employee.knowledgebase.details',compact('categories','knowledgebase','latest'));
    }

     public function category(Request $request)
    {
        $categories = KnowledgebaseCategory::orderBy('id','desc')->get();
        return view('employee.knowledgebase.category',compact('categories'));
    }
    public function category_store(Request $request)
    {
        $category = new KnowledgebaseCategory();
        $category->name = $request->name;
        $category->save();
        return redirect()->back()->with('success', 'added Successfully!');
    }
    public function category_update(Request $request)
    {
        $category =  KnowledgebaseCategory::findOrFail($request->id);
        $category->name = $request->name;
        $category->save();
        return redirect()->back()->with('success', 'Updated Successfully!');
    }
    public function category_delete(Request $request)
    {
        $category =  KnowledgebaseCategory::findOrFail($request->category_id);
        $category->delete();
        return redirect()->back()->with('success', 'Deleted Successfully!');
    }

    public function create(Request $request)
    {
        $categories = KnowledgebaseCategory::get();
        return view('employee.knowledgebase.create',compact('categories'));
    }

    public function store(Request $request)
    {
        $knowledgebase = new Knowledgebase();
        $knowledgebase->created_by = 'employee';
        $knowledgebase->added_by_id = auth('employee')->user()->id;
        $knowledgebase->category = $request->category;
        $knowledgebase->title = $request->title;
        $knowledgebase->details = $request->details;
        $knowledgebase->save();
        $this->send_notification([
            'knowledgebase'=> $knowledgebase,
            'message'=> 'Important update from Admin'
        ]);
        return redirect()->back()->with('success', 'added Successfully!');
    }

    public function edit(Request $request,$id)
    {
        $knowledgebase = Knowledgebase::findOrFail($id);
        $categories = KnowledgebaseCategory::get();
        return view('employee.knowledgebase.edit',compact('categories','knowledgebase'));
    }

    public function update(Request $request,$id)
    {
        // dd($request);
        $knowledgebase = Knowledgebase::findOrFail($id);
        $knowledgebase->category = $request->category;
        $knowledgebase->title = $request->title;
        $knowledgebase->details = $request->details;
        $knowledgebase->save();
        $this->send_notification([
            'knowledgebase'=> $knowledgebase,
            'message'=> 'Important update from Admin'
        ]);
        return redirect()->back()->with('success', 'Updated Successfully!');
    }

    public function delete(Request $request,$id)
    {
        $knowledgebase = Knowledgebase::findOrFail($id);
        $knowledgebase->delete();
        return redirect()->back()->with('success', 'Deleted Successfully!');
    }

    public function send_notification($data)
    {
        $users = Employee::all();
        // $arr = [];
        foreach($users as $user){
            // $arr[] = permission($user,'Lead');
                $user->notify(new UserNotification([
                    'knowledgebase_id'=> $data['knowledgebase']?$data['knowledgebase']->id:'',
                    'message'=> $data['message'],
                    'url'=>$data['knowledgebase']?route('employee.knowledgebase.details',$data['knowledgebase']->id):route('employee.knowledgebase.list')
                ]));
        }
        
    }

}
