<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;

class ProfileController extends Controller
{
    /**
     * Display a listing of the Employee.
     */
    public function profile(Request $request)
    {
        $employee = auth('employee')->user();
        return view('employee.profile',compact('employee'));
    }

    /**
     * Display a listing of the Employee.
     */
    public function update_profile_image(Request $request)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $employee = auth('employee')->user();
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
    public function update_profile(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $employee = auth('employee')->user();
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
        $employee->save();
        return redirect()->back()->with('success', 'Updated Successfully!');
    }

    public function update_password(Request $request)
    {
        
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);
        // dd($request);
        $employee = auth('employee')->user();
        $check = Hash::check($request->old_password, $employee->password);
        if (!$check) {
            return redirect()->back()->with('error', 'Password does not match. Please Verify!');
        }
        $employee->password = Hash::make($request->password);
        $employee->save();
        auth('employee')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect()->back()->with('success', 'Updated Successfully!');
    }

}
