<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;

use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;
use App\Notifications\SendEmailNotification;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the Employee.
     */
    public function profile(Request $request,$id)
    {
        $employee = Employee::findOrFail($id);
        return view('employee.employee.profile',compact('employee'));
    }

    /**
     * Display a listing of the Employee.
     */
    public function update_profile_image(Request $request,$id)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $employee = Employee::findOrFail($id);
        if($request->hasFile('profile_image')){
            $file = $request->file('profile_image');
            $extension = $file->getClientOriginalExtension();
            $image = time().rand().'.'.$extension;
            $file->move('assets/img/employee/', $image);

            $employee->image = $image;
        }
        $employee->save();
        return redirect()->back()->with('success', 'Updated Successfully!');
    }
    public function update_profile(Request $request,$id)
    {
        // dd($request);
        $request->validate([
            'first_name' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $employee = Employee::findOrFail($id);
        if($request->hasFile('profile_image')){
            $file = $request->file('profile_image');
            $extension = $file->getClientOriginalExtension();
            $image = time().rand().'.'.$extension;
            $file->move('assets/img/employee/', $image);

            $employee->image = $image;
        }
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        if($request->date_of_birth){
            $employee->date_of_birth = date('Y-m-d',strtotime($request->date_of_birth));
        }
        $employee->gender = $request->gender;
        $employee->address = $request->address;
        $employee->state = $request->state;
        $employee->country = $request->country;
        $employee->pin_code = $request->pin_code;
        $employee->phone = $request->phone;
        $employee->reporting_to = $request->reporting_to;
        $employee->save();
        return redirect()->back()->with('success', 'Updated Successfully!');
    }

    public function update_password(Request $request,$id)
    {
        
        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);
        // dd($request);
        $employee = Employee::findOrFail($id);
        
        $employee->password = Hash::make($request->password);
        $employee->save();

        return redirect()->back()->with('success', 'Updated Successfully!');
    }

    /**
     * Display a listing of the Employee.
     */
    public function index(Request $request)
    {
        $employee_id = null;
        $employee_name = null;
        $employees = Employee::orderBy('id','desc');
        if($request->employee_id){
            $employee_id = $request->employee_id;
            $employees = $employees->where('employee_id','like','%'.$request->employee_id.'%');
        }
        if($request->employee_name){
            $employees = $employees->where('first_name','like','%'.$request->employee_name.'%')->orWhere('first_name','like','%'.$request->employee_name.'%');
            $employee_name = $request->employee_name;
        }
        $employees = $employees->where('role', '!=',1)->get();
        return view('employee.employee.index',compact('employees','employee_id','employee_name'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            // 'username' => 'required',
            'email' => 'required|unique:employees',
            'employee_id' => 'required|unique:employees',
            'joining_date' => 'required',
            'department_id' => 'required',
            'designation_id' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);
        $employee = new Employee();
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        // $employee->username = $request->username;
        $employee->email = $request->email;
        $employee->employee_id = $request->employee_id;
        $employee->joining_date = date('Y-m-d',strtotime($request->joining_date));
        $employee->phone = $request->phone;
        $employee->department_id = $request->department_id;
        $employee->designation_id = $request->designation_id;
        $employee->reporting_to = $request->reporting_to;
        $employee->team_leader = $request->team_leader?$request->team_leader:0;
        $employee->password = Hash::make($request->password);
        $employee->permissions = $request->permission?($request->permission):null;
        $employee->save();

        $st = Notification::send($employee,new SendEmailNotification([
            'view' => 'mail.registeremail',
            'employee' => $employee,
        ]));
        return redirect()->back()->with('success', 'Employee added Successfully!');
    }

    public function update(Request $request)
    {
        $employee = Employee::where('id',$request->id)->first();
        $request->validate([
            'first_name' => 'required',
            // 'username' => 'required',
            'email' => 'required|unique:employees,email,'.$employee->id,
            "employee_id" => 'required|unique:employees,employee_id,'.$employee->id,
            'joining_date' => 'required',
            'department_id' => 'required',
            'designation_id' => 'required',
        ]);
        
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        // $employee->username = $request->username;
        $employee->email = $request->email;
        $employee->employee_id = $request->employee_id;
        $employee->joining_date = date('Y-m-d',strtotime($request->joining_date));
        $employee->phone = $request->phone;
        $employee->department_id = $request->department_id;
        $employee->designation_id = $request->designation_id;
        $employee->reporting_to = $request->reporting_to;
        $employee->team_leader = $request->team_leader?$request->team_leader:0;
        $employee->permissions = $request->permission?($request->permission):null;
        $employee->save();
        return redirect()->back()->with('success', 'Employee Updated Successfully!');
    }

    public function delete(Request $request)
    {
        $employee = Employee::where('id',$request->id)->first();
        $employee->delete();
        return redirect()->back()->with('success', 'Employee Deleted Successfully!');
    }

    /**
     * Display a listing of the Department.
     */
    public function department(Request $request)
    {
        $departments = Department::orderBy('id','desc')->get();
        return view('employee.employee.department',compact('departments'));
    }

    public function department_store(Request $request)
    {
        $department = new Department();
        $department->name = $request->name;
        $department->save();

        return redirect()->back()->with('success', 'Department added Successfully!');
    }

    public function department_update(Request $request)
    {
        $department =  Department::where('id',$request->id)->first();
        $department->name = $request->name;
        $department->save();

        return redirect()->back()->with('success', 'Department Updated Successfully!');
    }

    public function department_delete(Request $request)
    {
        $department = Department::where('id',$request->department_id)->first();
        $department->delete();

        return redirect()->back()->with('success', 'Department Deleted Successfully!');
    }

    /**
     * Display a listing of the Designation.
     */
    public function designation(Request $request)
    {
        $designations = Designation::orderBy('id','desc')->get();
        return view('employee.employee.designations',compact('designations'));
    }

    public function designation_store(Request $request)
    {
        $designation = new Designation();
        $designation->name = $request->name;
        $designation->department_id = $request->department_id;
        $designation->save();

        return redirect()->back()->with('success', 'Designation added Successfully!');
    }

    public function designation_update(Request $request)
    {
        $designation =  Designation::where('id',$request->id)->first();
        $designation->name = $request->name;
        $designation->department_id = $request->department_id;
        $designation->save();

        return redirect()->back()->with('success', 'Designation Updated Successfully!');
    }

    public function designation_delete(Request $request)
    {
        $designation = Designation::where('id',$request->id)->first();
        $designation->delete();

        return redirect()->back()->with('success', 'Designation Deleted Successfully!');
    }
}
