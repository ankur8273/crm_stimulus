<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;  // Ensure this is correct
use App\Models\Employee;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
// Import the base Controller




class AuthController extends Controller
{
	public function register(Request $request)
	{
		$validated = $request->validate([
			'name' => 'required|string|max:255',
			'email' => 'required|string|email|max:255|unique:Employees',
			'password' => 'required|string|min:6|confirmed',
		]);

		$Employee = Employee::create([
			'name' => $validated['name'],
			'email' => $validated['email'],
			'password' => Hash::make($validated['password']),
		]);

		$token = JWTAuth::fromEmployee($Employee);

		return response()->json(compact('Employee', 'token'));
	}

	public function login(Request $request)
	{
		// Manually fetch the credentials
		$credentials = $request->only('email', 'password');


		// Retrieve the employee by email
		$employee = Employee::with(['department', 'designation'])->where('email', $credentials['email'])->first();

		if (!$employee) {
			return response()->json(["status_code" => 400, 'msg' => 'Email not found'], 404);
		}

		// Manually check the password
		if (!Hash::check($credentials['password'], $employee->password)) {
			return response()->json(["status_code" => 400, 'msg' => 'Invalid password'], 401);
		}

		// Generate a JWT token for the authenticated employee
		$token = JWTAuth::fromUser($employee);
		$data = array('status_code' => 200, 'msg' => 'Login successfully', "token" => $token, 'data' => $employee);
		return response()->json($data, 200);
	}

	public function logout()
	{

		return response()->json(['status_code' => 200, 'msg' => 'Successfully logged out']);
	}

	public function userdata(Request $request)
	{
		// Manually fetch the credentials




		$data = array('status_code' => 200, 'msg' => 'User Found Successfully', 'data' => $request->user);
		return response()->json($data, 200);

	}
	public function update_profile_image(Request $request)
	{
		try {
			$request->validate([
				'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
			]);


			$employee = Employee::findOrFail($request->user->user_id);
			if ($request->hasFile('profile_image')) {
				$file = $request->file('profile_image');
				$extension = $file->getClientOriginalExtension();
				$image = time() . rand() . '.' . $extension;
				$file->move('assets/img/employee/', $image);

				$employee->image = $image;
				$employee->save();
			}

			$data = array('status_code' => 200, 'msg' => 'Profile Updated  Successfully');
			return response()->json($data, 200);
		} catch (\Illuminate\Validation\ValidationException $e) {
			$firstErrorKey = $e->validator->errors()->keys()[0]; // Get the first error key
			$firstError = $e->validator->errors()->first($firstErrorKey); // Get the first error message for that key

			return response()->json([
				'msg' => $firstError,
				'status_code' => 400
			], 422);
		}


	}
	public function update_profile(Request $request)
	{
		try { 
			$request->validate([
				'first_name' => 'required',
				'date_of_birth' => 'required',
				'gender' => 'required',
				'address' => 'required',
				'phone' => 'required' 
			]);

			$employee = Employee::findOrFail($request->user->user_id);
			 
			// Fill only the non-empty fields
			$employee->first_name = $request->input('first_name', $employee->first_name);
			$employee->last_name = $request->input('last_name', $employee->last_name);
			$employee->gender = $request->input('gender', $employee->gender);
			$employee->address = $request->input('address', $employee->address);
			$employee->state = $request->input('state', $employee->state);
			$employee->country = $request->input('country', $employee->country);
			$employee->pin_code = $request->input('pin_code', $employee->pin_code);
			$employee->phone = $request->input('phone', $employee->phone);

			// Update date_of_birth only if it's filled
			if ($request->filled('date_of_birth')) {
				$employee->date_of_birth = date('Y-m-d', strtotime($request->date_of_birth));
			}

			$employee->save();
			$data = array('status_code' => 200, 'msg' => 'Profile Updated  Successfully');
			return response()->json($data, 200);
		} catch (\Illuminate\Validation\ValidationException $e) {
			$firstErrorKey = $e->validator->errors()->keys()[0]; // Get the first error key
			$firstError = $e->validator->errors()->first($firstErrorKey); // Get the first error message for that key

			return response()->json([
				'msg' => $firstError,
				'status_code' => 400
			], 422);
		}

	}


}
