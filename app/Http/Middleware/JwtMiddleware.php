<?php
namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\Employee;

class JwtMiddleware
{
	public function handle($request, Closure $next)
    {
        try {
            // Attempt to authenticate the user using the token
            $token = $request->bearerToken();
            
            if (!$token) {
                return response()->json(['status_code'=>400,'msg' => 'Token not provided'], 400);
            }

            // Decode the token to get the payload
            $payload = JWTAuth::setToken($token)->payload();
            $employeeId = $payload['sub']; // Assuming 'sub' contains the employee ID

            // Check if the employee exists
            $employee = Employee::with(['department', 'designation'])->find($employeeId);
			 
			
            if (!$employee) {
                return response()->json(['status_code'=>400,'msg' => 'Employee not found'], 404);
            }
 
			$request->user=$employee;
			$request->user->user_id=  $payload['sub'];

        } catch (JWTException $e) {
            return response()->json(['status_code'=>400,'msg' => 'Token is invalid or expired'], 401);
        }

        return $next($request);
    }
}
