<?php
   
use Carbon\Carbon;
use App\Models\Setting;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Project;
use App\Models\Branch;
use Illuminate\Support\Str;
  
/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('convertYmdToMdy')) {
    function convertYmdToMdy($date)
    {
        return Carbon::createFromFormat('Y-m-d', $date)->format('m-d-Y');
    }
}
  
/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('convertMdyToYmd')) {
    function convertMdyToYmd($date)
    {
        return Carbon::createFromFormat('m-d-Y', $date)->format('Y-m-d');
    }
}

/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('get_setting')) {
    function get_setting($type)
    {
        $setting = Setting::where('type',$type)->first();
        if($setting){
            return $setting->value;
        }else{
            return null;
        }
    }
}

/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('make_slug')) {
    function make_slug($str)
    {
        $slug  = Str::slug($str);
        $slug = strtolower($slug);
        return $slug;
    }
}

/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('get_departments')) {
    function get_departments()
    {
        $departments  = Department::get();
        return $departments;
    }
}

/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('get_employees')) {
    function get_employees()
    {
        $employees = Employee::where('role', '!=', 1)->get();
         return $employees;
    }
}

/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('get_designations')) {
    function get_designations()
    {
        $designation  = Designation::get();
        return $designation;
    }
}

/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('get_projects')) {
    function get_projects()
    {
        $projects  = Project::get();
        return $projects;
    }
}
if (! function_exists('get_branch')) {
    function get_branch()
    {
        $branch  = Branch::get();
        return $branch;
    }
}

/*
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('has_permission')) {
    function has_permission($permission,$user_id='admin')
    {
        $user = auth('employee')->user();
        $permissions = $user->permissions;
        if(in_array($permission,$permissions)){
            return true;
        }
        if($user_id==$user->id){
            return true;
        }
        return false;
    }
}

/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('permission')) {
    function permission($user,$permission)
    {
		if(is_array($user->permissions)){
        $permissions = $user->permissions??[];
        if(in_array($permission,$permissions)){
            return true;
        }
	   }
        return false;
    }
}


if (! function_exists('admin_has_permission')) {
    function admin_has_permission($permission,$user_id='admin')
    {
        $user = auth('admin')->user();
        $permissions = $user->permissions;
        if(in_array($permission,$permissions)){
            return true;
        }
        
        return false;
    }
}