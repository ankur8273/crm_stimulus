<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SmtpSettings;

class SmtpController extends Controller
{
    //
    public function smtp_settings(Request $request)
    {
        $user = auth('admin')->user();
        return view('admin.settings.smtp_settings',compact('user'));
    }

    /**
     * Display a listing of the Employee.
     */
    
     public function update_settings(Request $request)
     {
        $settings = $request->except(['_token', '_method']); // Exclude unnecessary tokens
    

        // dd($settings);
        // Loop through the settings
        foreach ($settings as $key => $value) {
            
            if ($request->hasFile($key)) { 
                $file = $request->file($key);

            
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);

            SmtpSettings::updateOrCreate(['key' => $key], ['value' => 'uploads/' . $fileName]);
            } else { 
                SmtpSettings::updateOrCreate(['key' => $key], ['value' => $value??'']);
            }
        }
    
        // Redirect with success message
        return redirect()->back()->with('success', 'Smtp Settings updated successfully!');
     }
     
}
