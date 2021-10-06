<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\CategoriesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('frontend.index');
})->name('home');

Route::match(['get','post'],'/register', [RegisterController::class, 'register'])->name('register');
Route::get('/login', [RegisterController::class, 'accountLogin'])->name('login');
Route::post('/login', [RegisterController::class, 'checkLogin']);
Route::get('/logout', [RegisterController::class, 'logout'])->name('logout');
// Forgot Password routes
Route::get('/forgot-password', [RegisterController::class, 'forgotPasswordRoute'])->name('forgot-password');
Route::post('/password/email', [RegisterController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{email}/{token}', [RegisterController::class, 'showPasswordResetForm']);
Route::post('/reset-password', [RegisterController::class, 'resetPassword']);

// Profile
Route::middleware(['auth'])->group(function () {
	Route::resource('profile',ProfileController::class);
	Route::match(['get','post'],'/edit-profile', [ProfileController::class, 'edit_profile']);
	Route::post('/add_skill',[ProfileController::class,'add_skill']);
	Route::delete('/delete-skill/{id}',[ProfileController::class,'deleteSkill']);
	Route::post('/add-experience',[ProfileController::class,'addExperience']);
	Route::delete('/delete-experience/{id}', [ProfileController::class, 'deleteExperience']);
	Route::post('/edit-experience', [ProfileController::class, 'editExperience']);
	Route::post('/add-education',[ProfileController::class,'addEducation']);
	Route::delete('/delete-education/{id}', [ProfileController::class, 'deleteEducation']);
	Route::post('/edit-education', [ProfileController::class, 'editEducation']);
	Route::post('/add-project',[ProfileController::class,'addProject']);
	Route::delete('/delete-project/{id}', [ProfileController::class, 'deleteProject']);
	Route::post('/edit-project', [ProfileController::class, 'editProject']);
	Route::post('/add-certificate',[ProfileController::class,'addCertificate']);
	Route::delete('/delete-certificate/{id}', [ProfileController::class, 'deleteCertificate']);
	Route::post('/edit-certificate', [ProfileController::class, 'editCertificate']);

	// Jobs
	Route::resource('job',JobsController::class);
	Route::get('job-detail/{id}',[JobsController::class, 'show'])->name('job.show');
	Route::get('manage-jobs',[JobsController::class, 'manageJobs'])->name('job.manage-jobs');

	Route::post('save-freelancer',[FreelancerController::class, 'saveFreelancer']);
	Route::post('save-job',[FreelancerController::class, 'saveJob']);
});

Route::resource('freelancers',FreelancerController::class);
Route::get('freelancer/{username}',[FreelancerController::class, 'show'])->name('freelancers.show');
Route::get('saved-items',[FreelancerController::class, 'savedItems'])->name('freelancers.saved-items');


Route::get('/job-listings', function () {
    return view('frontend.job-listings');
})->name('job-listings');
Route::get('/job-single', function () {
    return view('frontend.single-job');
})->name('job-single');
Route::get('/job-proposal', function () {
    return view('frontend.job-proposal');
})->name('job-proposal');

Route::get('/account-setting', function () {
    return view('frontend.account-setting');
})->name('account-setting');


Route::name('admin.')->namespace('Admin')->prefix('admin')->group(function(){

	  Route::namespace('Auth')->middleware('guest:admin')->group(function(){
	    Route::match(['get','post'],'/login', [AdminController::class, 'adminLogin'])->name('login');

	  });
  	Route::namespace('Auth')->middleware('auth:admin')->group(function(){

      Route::get('/', function(){
        return view('admin.index');
      });

      Route::get('/freelancers-list', [AdminController::class, 'index'])->name('freelancers-list');
      Route::get('/clients-list', [AdminController::class, 'clientsList'])->name('clients-list');
      Route::resource('projects','\App\Http\Controllers\Admin\ProjectController');
      Route::resource('categories','\App\Http\Controllers\Admin\CategoriesController');
      // Route::get('projects',[ProjectController::class, 'index']);

      Route::get('/form-layouts', function(){
        return view('admin.form-layouts');
      });
      Route::get('/form-advanced', function(){
        return view('admin.form-advanced');
      });
      Route::get('/form-uploads', function(){
        return view('admin.form-uploads');
      });
      Route::get('/form-elements', function(){
        return view('admin.form-elements');
      });
      Route::get('/tables-basic', function(){
        return view('admin.tables-basic');
      });
      Route::get('/tables-datatable', function(){
        return view('admin.tables-datatable');
      });
      Route::get('/tables-editable', function(){
        return view('admin.tables-editable');
      });
      Route::get('/tables-responsive', function(){
        return view('admin.tables-responsive');
      });
      Route::get('/tasks-create', function(){
        return view('admin.tasks-create');
      });
      Route::get('/tasks-list', function(){
        return view('admin.tasks-list');
      });
      Route::get('/contacts-grid', function(){
        return view('admin.contacts-grid');
      });
      
      Route::get('/icons-boxicons', function(){
        return view('admin.icons-boxicons');
      });
      Route::get('/icons-dripicons', function(){
        return view('admin.icons-dripicons');
      });
      Route::get('/icons-materialdesign', function(){
        return view('admin.icons-materialdesign');
      });
      Route::get('/icons-fontawesome', function(){
        return view('admin.icons-fontawesome');
      });

      Route::get('/projects-create', function(){
        return view('admin.projects-create');
      });
      Route::get('/projects-overview', function(){
        return view('admin.projects-overview');
      });



      Route::post('/logout',function(){
       Auth::guard('admin')->logout();
       return redirect()->action([
           AdminController::class,
           'adminLogin'
       ]);
   		})->name('logout');

      Route::get('pages-login', [AdminController::class,'index']);
      Route::get('pages-login-2', [AdminController::class,'index']);
      Route::get('pages-register', [AdminController::class,'index']);
      Route::get('pages-register-2', [AdminController::class,'index']);
      Route::get('pages-recoverpw', [AdminController::class,'index']);
      Route::get('pages-recoverpw-2', [AdminController::class,'index']);
      Route::get('pages-lock-screen', [AdminController::class,'index']);
      Route::get('pages-lock-screen-2', [AdminController::class,'index']);
      Route::get('pages-404', [AdminController::class,'index']);
      Route::get('pages-500', [AdminController::class,'index']);
      Route::get('pages-maintenance', [AdminController::class,'index']);
      Route::get('pages-comingsoon', [AdminController::class,'index']);

      Route::post('keep-live', [AdminController::class,'live']);
      
    });


    // Route::get('/', [HomeController::class, 'root']);

    // Route::get('{any}', [HomeController::class, 'index']);
});




