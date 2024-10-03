<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Employee;
use DB;

use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login()
    {
        return view('admin.login');
    }

	public function showRegisterForm()
    {
		$admins=Admin::orderBy('id','desc')->get();
		
        return view('admin.admin.register',compact('admins'));
    }
	public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:admins,email'],
            'password' => ['required', 'min:8','confirmed'],
			'password_confirmation' => ['required']
        ]);
		$user_id=90000 . rand(1000, 9999);
		 
       $admin= Admin::create([
			'id'=> $user_id,
            'name' => $request->name??'',
            'email' => $request->email,
            'password' => bcrypt($request->password),
			'permissions' => $request->permission?($request->permission):null,
			'role_id'=>2,
			'status'=>$request->status??0
        ]);
		$admin->id = $user_id;
       $admin->save();

		$employee = new Employee();
        $employee->first_name = $request->name;
        $employee->last_name = '';
		$employee->id= $user_id;
        // $employee->username = $request->username;
        $employee->email = $request->email;
        $employee->employee_id = rand(1000, 9999);
        $employee->joining_date = date('Y-m-d');
        $employee->phone = '';
        $employee->department_id = 0;
        $employee->designation_id =0;
        $employee->reporting_to = 0;
        $employee->team_leader = 0;
        $employee->password = bcrypt($request->password);
		$employee->role=1;
        $employee->permissions = $request->permission?($request->permission):null;
        $employee->save();

		return redirect()->back()->with('success', 'Registration successful. Please log in.');

         
    }
	public function update(Request $request)
    {
        // dd($request); 
		$admin = Admin::findOrFail($request->admin_id);
        $request->validate([
            'name' => 'required|max:255',
            'email' => [
				'required',
				'email',
				'unique:admins,email,'.$admin->id
			] 
            
        ]);

        $data=$request->all();
        unset($data['_token']);

        
		$admin->name= $request->name??'';
		$admin->email = $request->email;
		$admin->permissions = $request->permission?($request->permission):null;
		$admin->status=$request->status??0;
        $admin->save();

		$data = [
			'first_name' => $request->name,
			'last_name' => '', // Set this based on your requirements
			'email' => $request->email,
			'permissions' => $request->permission ? $request->permission : null,
		];
	
		// Update the employee record in the database
		$updated = DB::table('employees')
			->where('id', $request->admin_id)
			->update($data);


		return response()->json([
            'success' => true,
            'message' => 'Updated successfully!',
		]);
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        try{
            if (Auth::guard('admin')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'));
            }
        }catch(Execption $e){
                dd($e);
         }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Remove the session from user.
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
