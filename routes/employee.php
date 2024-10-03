<?php
use App\Http\Controllers\Employee\LoginController;
use App\Http\Controllers\Employee\DashboardController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Employee\LeadController;
use App\Http\Controllers\Employee\ContactController;
use App\Http\Controllers\Employee\ProjectController;
use App\Http\Controllers\Employee\TicketController;
use App\Http\Controllers\Employee\ProfileController;
use App\Http\Controllers\Employee\KnowledgebaseController;
use App\Http\Controllers\Employee\SettingController;
use App\Http\Controllers\Employee\PropertiesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\Employee\CPController;
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login/auth', 'authenticate')->name('authenticate');

    Route::middleware('employee')->group(function () {
        Route::get('/logout', 'logout')->name('logout');
    });

});

Route::middleware('employee')->controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'index')->name('dashboard');
    Route::post('/clear_notification', 'clear_notification')->name('clear_notification');
});

Route::middleware('employee')->controller(SettingController::class)->group(function () {
    Route::get('/clear-cache', 'clear_cache')->name('clear_cache');
    Route::get('/setting', 'index')->name('setting');
    Route::post('/setting/update', 'update')->name('setting.update');
    Route::post('/update_settings', 'update_settings')->name('update-settings');
    
    Route::post('/setting/smtp-test', 'smtp_test')->name('smtp-test');
    Route::get('/setting/email-settings', 'email_settings')->name('email-settings');
    Route::post('/setting/email-update', 'update_email_settings')->name('smtp-update-settings');
});

Route::middleware('employee')->controller(ProfileController::class)->group(function () {
    Route::get('/profile', 'profile')->name('profile');
    Route::post('/profile-image', 'update_profile_image')->name('profile-image');
    Route::post('/profile-update', 'update_profile')->name('profile-update');
    Route::post('/profile-password', 'update_password')->name('profile-password');
});

Route::middleware('employee')->prefix('employee')->name('employee.')->controller(EmployeeController::class)->group(function () {
    Route::get('/', 'index')->name('list');
    Route::post('/store', 'store')->name('store');
    Route::post('/update', 'update')->name('update');
    Route::post('/delete', 'delete')->name('delete');


    Route::get('/department', 'department')->name('department.list');
    Route::post('/department/store', 'department_store')->name('department.store');
    Route::post('/department/update', 'department_update')->name('department.update');
    Route::post('/department/delete', 'department_delete')->name('department.delete');

    Route::get('/designation', 'designation')->name('designation.list');
    Route::post('/designation/store', 'designation_store')->name('designation.store');
    Route::post('/designation/update', 'designation_update')->name('designation.update');
    Route::post('/designation/delete', 'designation_delete')->name('designation.delete');

    Route::get('/profile/{id}', 'profile')->name('profile');
    Route::post('/profile-image/{id}', 'update_profile_image')->name('profile-image');
    Route::post('/profile-update/{id}', 'update_profile')->name('profile-update');
    Route::post('/profile-password/{id}', 'update_password')->name('profile-password');
});




Route::middleware('employee')->prefix('leads')->name('leads.')->controller(LeadController::class)->group(function () {
    Route::get('/', 'index')->name('list');
    Route::get('/detail/{id}', 'details')->name('details');
    Route::post('/store', 'store')->name('store');
    Route::post('/update', 'update')->name('update');
    Route::get('/delete/{id}', 'delete')->name('delete');

    Route::get('/export', 'export')->name('export');
    Route::post('/import', 'import')->name('import');
    Route::post('/add_projects/{id}', 'add_projects')->name('add_projects');
    Route::post('/add_next_fellowup/{id}', 'add_next_fellowup')->name('add_next_fellowup');
    Route::post('/add_owner/{id}', 'add_owner')->name('add_owner');
    
    Route::post('/add_to_favourite/{id}', 'add_to_favourite')->name('add_to_favourite');

    Route::post('/add_call/{id}', 'add_call')->name('add_call');
    Route::get('/delete_callNote/{id}', 'delete_callNote')->name('delete_callNote');

    Route::post('/add_file/{id}', 'add_file')->name('add_file');
    Route::get('/delete_file/{id}', 'delete_file')->name('delete_file');

    Route::post('/change_status/{id}', 'change_status')->name('change_status');
    Route::post('/change_fellowupType/{id}', 'change_fellowupType')->name('change_fellowupType');
    Route::post('/change_lead_status/{id}', 'change_leadStatus')->name('change_lead_status');
    Route::post('/add_note', 'add_note')->name('add_note');
    Route::post('/add_comment', 'add_comment')->name('add_comment');
    Route::get('/delete_note/{id}', 'delete_note')->name('delete_note');

});
Route::middleware('employee')->prefix('contact')->name('contact.')->controller(ContactController::class)->group(function () {
    Route::get('/', 'index')->name('list');
    Route::get('/detail/{id}', 'details')->name('details');
    Route::post('/store', 'store')->name('store');
    Route::post('/update', 'update')->name('update');
    Route::get('/delete/{id}', 'delete')->name('delete');

    Route::post('/add_note/{id}', 'add_note')->name('add_note');
    Route::post('/add_comment', 'add_comment')->name('add_comment');
    Route::get('/delete_note/{id}', 'delete_note')->name('delete_note');

    Route::post('/add_call/{id}', 'add_call')->name('add_call');
    Route::get('/delete_callNote/{id}', 'delete_callNote')->name('delete_callNote');

    Route::post('/add_file/{id}', 'add_file')->name('add_file');
    Route::get('/delete_file/{id}', 'delete_file')->name('delete_file');

});

Route::middleware('employee')->prefix('project')->name('project.')->controller(ProjectController::class)->group(function () {
    Route::get('/', 'index')->name('list');
    Route::get('/detail/{id}', 'details')->name('details');
    Route::post('/store', 'store')->name('store');
    Route::post('/update', 'update')->name('update');
    Route::get('/delete/{id}', 'delete')->name('delete');

    Route::get('/change_status/{id}', 'change_status')->name('change_status');

    Route::post('/add_images/{id}', 'add_images')->name('add_images');
    Route::get('/image_delete/{id}', 'image_delete')->name('image_delete');
    Route::post('/add_files/{id}', 'add_files')->name('add_files');
    Route::get('/file_delete/{id}', 'file_delete')->name('file_delete');

    Route::post('/add_user/{id}', 'add_user')->name('add_user');
   

});

Route::middleware('employee')->prefix('properties')->name('properties.')->controller(PropertiesController::class)->group(function () {
    Route::get('/', 'index')->name('list');
    Route::get('/detail/{id}', 'details')->name('details');
    Route::post('/store', 'store')->name('store');
    Route::post('/update', 'update')->name('update');
    Route::get('/delete/{id}', 'delete')->name('delete');

    Route::get('/change_status/{id}', 'change_status')->name('change_status');

    Route::post('/add_images/{id}', 'add_images')->name('add_images');
    Route::get('/image_delete/{id}', 'image_delete')->name('image_delete');
    Route::post('/add_files/{id}', 'add_files')->name('add_files');
    Route::get('/file_delete/{id}', 'file_delete')->name('file_delete');

    Route::post('/add_user/{id}', 'add_user')->name('add_user');
   

});

Route::middleware('employee')->prefix('ticket')->name('ticket.')->controller(TicketController::class)->group(function () {
    Route::get('/', 'index')->name('list');
    Route::get('/detail/{id}', 'details')->name('details');
    Route::post('/store', 'store')->name('store');
    Route::post('/update', 'update')->name('update');
    Route::get('/delete/{id}', 'delete')->name('delete');

    Route::post('/send/{id}', 'send')->name('send');

    Route::post('/add_images/{id}', 'add_images')->name('add_images');
    Route::get('/image_delete/{id}', 'image_delete')->name('image_delete');
    Route::post('/add_files/{id}', 'add_files')->name('add_files');
    Route::get('/file_delete/{id}', 'file_delete')->name('file_delete');


    Route::post('/update_status/{id}', 'update_status')->name('update_status');
});

Route::middleware('employee')->prefix('knowledgebase')->name('knowledgebase.')->controller(KnowledgebaseController::class)->group(function () {
    Route::get('/', 'index')->name('list');
    Route::get('/create', 'create')->name('create');
    Route::get('/edit/{id}', 'edit')->name('edit');
    
    Route::get('/detail/{id}', 'details')->name('details');
    Route::post('/store', 'store')->name('store');
    Route::post('/update/{id}', 'update')->name('update');
    Route::get('/delete/{id}', 'delete')->name('delete');

    Route::get('/category', 'category')->name('category');
    Route::post('/category/store', 'category_store')->name('category.store');
    Route::post('/category/update', 'category_update')->name('category.update');
    Route::post('/category/delete', 'category_delete')->name('category.delete');

});


Route::middleware('employee')->prefix('channel-partner')->name('channel-partner.')->controller(CPController::class)->group(function () {
    Route::get('/', 'index')->name('list');
    Route::get('/details/{id}', 'details')->name('details');
    Route::post('/store', 'store')->name('store');
    Route::post('/update', 'update')->name('update');
    Route::get('/delete/{id}', 'delete')->name('delete');

    Route::get('/change_status/{id}', 'change_status')->name('change_status');

    Route::post('/add_images/{id}', 'add_images')->name('add_images');
    Route::get('/image_delete/{id}', 'image_delete')->name('image_delete');
    Route::post('/add_files/{id}', 'add_files')->name('add_files');
    Route::get('/file_delete/{id}', 'file_delete')->name('file_delete');

    Route::post('/add_user/{id}', 'add_user')->name('add_user');




    Route::get('/detail/{id}', 'details')->name('details');
    Route::get('/export', 'export')->name('export');
    Route::post('/import', 'import')->name('import');
    Route::post('/add_projects/{id}', 'add_projects')->name('add_projects');
    Route::post('/add_next_fellowup/{id}', 'add_next_fellowup')->name('add_next_fellowup');
    Route::post('/add_owner/{id}', 'add_owner')->name('add_owner');
    
    Route::post('/add_to_favourite/{id}', 'add_to_favourite')->name('add_to_favourite');

    Route::post('/add_call/{id}', 'add_call')->name('add_call');
    Route::get('/delete_callNote/{id}', 'delete_callNote')->name('delete_callNote');

    Route::post('/add_file/{id}', 'add_file')->name('add_file');
    Route::get('/delete_file/{id}', 'delete_file')->name('delete_file');

    Route::post('/change_status/{id}', 'change_status')->name('change_status');
    Route::post('/change_fellowupType/{id}', 'change_fellowupType')->name('change_fellowupType');
    Route::post('/change_cp_status/{id}', 'change_cpstatus')->name('change_cp_status');
    Route::post('/add_note', 'add_note')->name('add_note');
    Route::post('/add_comment', 'add_comment')->name('add_comment');
    Route::get('/delete_note/{id}', 'delete_note')->name('delete_note');

});


