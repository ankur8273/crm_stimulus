<?php

namespace App\Http\Controllers\Admin;

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
        $user = auth('admin')->user();
        return view('admin.profile',compact('user'));
    }

    /**
     * Display a listing of the Employee.
     */
    public function update_profile_image(Request $request)
    {
        // dd($request);
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = auth('admin')->user();
        if($request->hasFile('profile_image')){
            $file = $request->file('profile_image');
            $extension = $file->getClientOriginalExtension();
            $image = time().rand().'.'.$extension;
            $file->move('assets/img/employee/', $image);

            $user->image = $image;
        }
        $user->save();
        return redirect()->back()->with('success', 'Updated Successfully!');
    }
    public function update_profile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = auth('admin')->user();
        if($request->hasFile('profile_image')){
            $file = $request->file('profile_image');
            $extension = $file->getClientOriginalExtension();
            $image = time().rand().'.'.$extension;
            $file->move('assets/img/employee/', $image);

            $user->image = $image;
        }
        $user->first_name = $request->name;
       
        $user->phone = $request->phone;
        $user->save();
        return redirect()->back()->with('success', 'Updated Successfully!');
    }

    public function update_password(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);
        // dd($request);
        $user = auth('admin')->user();
        $check = Hash::check($request->old_password, $user->password);
        if (!$check) {
            return redirect()->back()->with('error', 'Password does not match. Please Verify!');
        }
        $user->password = Hash::make($request->password);
        $user->save();
        auth('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect()->back()->with('success', 'Updated Successfully!');
    }

}
