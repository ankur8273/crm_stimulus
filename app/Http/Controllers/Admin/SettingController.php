<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{
    /**
     * Display index page.
     */
    public function index(Request $request)
    {
        return view('admin.settings.settings');
    }
    

    public function update(Request $request)
    {
        if($request->hasFile('website_logo')){
            $site_logo = Setting::where('type','website_logo')->first();
            if ($site_logo && file_exists('public/front/img/logo/'.$site_logo->value)) {
                    unlink('public/front/img/logo/'.$site_logo->value);
                } 
            $file = $request->file('website_logo');
            $extension = $file->getClientOriginalExtension();
            $image = time().rand().'.'.$extension;
            $file->move('public/front/img/logo/', $image);

            if(!$site_logo){
                $site_logo = new Setting();
                $site_logo->type = 'website_logo';
            }
            $site_logo->value = $image;
            $site_logo->save();
        }

        if($request->hasFile('website_logo_white')){
            $site_logo = Setting::where('type','website_logo_white')->first();
            if ($site_logo && file_exists('public/front/img/logo/'.$site_logo->value)) {
                    unlink('public/front/img/logo/'.$site_logo->value);
                } 
            $file = $request->file('website_logo_white');
            $extension = $file->getClientOriginalExtension();
            $image = time().rand().'.'.$extension;
            $file->move('public/front/img/logo/', $image);

            if(!$site_logo){
                $site_logo = new Setting();
                $site_logo->type = 'website_logo_white';
            }
            $site_logo->value = $image;
            $site_logo->save();
        }

        if($request->hasFile('website_favicon')){
            $site_logo = Setting::where('type','website_favicon')->first();
            if ($site_logo && file_exists('public/front/img/logo/'.$site_logo->value)) {
                    unlink('public/front/img/logo/'.$site_logo->value);
                } 
            $file = $request->file('website_favicon');
            $extension = $file->getClientOriginalExtension();
            $image = time().rand().'.'.$extension;
            $file->move('public/front/img/logo/', $image);

            if(!$site_logo){
                $site_logo = new Setting();
                 $site_logo->type = 'website_favicon';
            }
            $site_logo->value = $image;
            $site_logo->save();
        }

        foreach($request->types as $key=>$value){
            $setting = Setting::where('type',$value)->first();
            if(!$setting){
                $setting = new Setting();
                $setting->type = $value;
            }
            $setting->value = is_array($request->$value)?json_encode($request->$value):$request->$value;
            $setting->save();
        }
        return redirect()->back()->with('success', 'Setting Updated Successfully!');
    }
    
    public function email_settings(Request $request)
    {
        return view('admin.settings.smtp_settings');
    }
    
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

            Setting::updateOrCreate(['type' => $key], ['value' => 'uploads/' . $fileName]);
            } else { 
                Setting::updateOrCreate(['type' => $key], ['value' => $value??'']);
            }
        }
    
        // Redirect with success message
        return redirect()->back()->with('success', 'Settings updated successfully!');
     }
     
     /**
     * Show list.
     */
    public function update_email_settings(Request $request)
    {
        // dd($request);
        $path = base_path('.env');

        if (file_exists($path)) {
            if($request->MAIL_MAILER){
                $key = getenv('MAIL_MAILER');
                $val = $request->MAIL_MAILER;
                file_put_contents($path, str_replace(
                    'MAIL_MAILER='.$key, 'MAIL_MAILER='.$val, file_get_contents($path)
                ));
            }
            
            if($request->MAIL_HOST){
                $key = getenv('MAIL_HOST');
                $val = $request->MAIL_HOST;
                file_put_contents($path, str_replace(
                    'MAIL_HOST="'.$key.'"', 'MAIL_HOST="'.$val.'"', file_get_contents($path)
                ));
            }
            
            if($request->MAIL_USERNAME){
                $key = getenv('MAIL_USERNAME');
                $val = $request->MAIL_USERNAME;
                file_put_contents($path, str_replace(
                    'MAIL_USERNAME="'.$key.'"', 'MAIL_USERNAME="'.$val.'"', file_get_contents($path)
                ));
            }
            if($request->MAIL_PASSWORD){
                $key = getenv('MAIL_PASSWORD');
                $val = $request->MAIL_PASSWORD;
                file_put_contents($path, str_replace(
                    'MAIL_PASSWORD="'.$key.'"', 'MAIL_PASSWORD="'.$val.'"', file_get_contents($path)
                ));
            }
            if($request->MAIL_PORT){
                $key = getenv('MAIL_PORT');
                $val = $request->MAIL_PORT;
                file_put_contents($path, str_replace(
                    'MAIL_PORT='.$key, 'MAIL_PORT='.$val, file_get_contents($path)
                ));
            }
            if($request->MAIL_ENCRYPTION){
                $key = getenv('MAIL_ENCRYPTION');
                $val = $request->MAIL_ENCRYPTION;
                file_put_contents($path, str_replace(
                    'MAIL_ENCRYPTION='.$key, 'MAIL_ENCRYPTION='.$val, file_get_contents($path)
                ));
            }
            if($request->MAIL_FROM_ADDRESS){
                $key = getenv('MAIL_FROM_ADDRESS');
                $val = $request->MAIL_FROM_ADDRESS;
                file_put_contents($path, str_replace(
                    'MAIL_FROM_ADDRESS="'.$key.'"', 'MAIL_FROM_ADDRESS="'.$val.'"', file_get_contents($path)
                ));
            }
            if($request->MAIL_FROM_NAME){
                $key = getenv('MAIL_FROM_NAME');
                $val = $request->MAIL_FROM_NAME;
                file_put_contents($path, str_replace(
                    'MAIL_FROM_NAME="'.$key.'"', 'MAIL_FROM_NAME="'.$val.'"', file_get_contents($path)
                ));
            }
        }
        return redirect()->back()->with('success', 'Updated Successfully!');
    }
    
    /**
     * Show list.
     */
    public function smtp_test(Request $request)
    {
        // dd($request);
        $email = $request->email;
        Mail::raw('This Is Test Mail!', function($msg) use ($email) {$msg->to($email)->subject('Test Email'); });
        
        $mail = new PHPMailer(true);
    
        try {
    
            /* Email SMTP Settings */
            $mail->SMTPDebug = 3;
            $mail->isSMTP();
            $mail->Host = env('MAIL_HOST');
            $mail->SMTPAuth = true;
            $mail->Username = env('MAIL_USERNAME');
            $mail->Password = env('MAIL_PASSWORD');
            $mail->SMTPSecure = env('MAIL_ENCRYPTION');
            $mail->Port = env('MAIL_PORT');
    
            $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $mail->addAddress($request->email);
    
            $mail->isHTML(true);
    
            $mail->Subject = 'Test Email';
            $mail->Body    = 'This Is Test Mail!';
    
            if( !$mail->send() ) {

                dd($mail->ErrorInfo);
            }
                
            else {
                // dd("Email has been sent.");
            }
    
        } catch (Exception $e) {
                dd($e);
        }

        return redirect()->back()->with('success', 'Mail Send Successfully!');
    }
   
    public function clear_cache(Request $request)
    {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('config:clear');
        Artisan::call('optimize:clear');
        return redirect()->back()->with('success', 'Cache Cleared Successfully!');
    }
    
}
