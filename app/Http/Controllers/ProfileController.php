<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\User;
use App\Models\Countries;
use App\Models\Skills;
use App\Models\UserSkill;
use App\Models\UserExperience;
use App\Models\UserEducation;
use App\Models\UserCertification;
use App\Models\UserProject;
use Hash;
use Session;
use Mail;
use Redirect;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $user_id = auth()->user()->id;

      $get_skills = Skills::get();
      $user_skills = UserSkill::with('skillData')->whereuser_id($user_id)->get();
      $countries = Countries::get();
      $experiences = UserExperience::whereuser_id($user_id)->get();
      $educations = UserEducation::whereuser_id($user_id)->get();
      $projects = UserProject::whereuser_id($user_id)->get();
      $certifications = UserCertification::whereuser_id($user_id)->get();
      // dd($user_skills);
      return View::make('frontend.dashboard')->with([
        'skills' => $get_skills,
        'user_skills' => $user_skills,
        'countries' => $countries,
        'experience' => $experiences,
        'education' => $educations,
        'projects' => $projects,
        'certifications' => $certifications,
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // Profile Section
    // public function profile(Request $request){
    //   $user_id = auth()->user()->id;

    //   $get_skills = Skills::get();
    //   $user_skills = UserSkill::with('skillData')->whereuser_id($user_id)->get();
    //   // dd($user_skills);
    //   return View::make('frontend.dashboard')->with([
    //     'skills' => $get_skills,
    //     'user_skills' => $user_skills
    //   ]);
    // }

    public function add_skill(Request $request){
      // dd($request->all());
      $user_skill = new UserSkill;

      $user_skill->user_id = $request->input('user_id');
      $user_skill->skill_id = $request->input('skill_id');
      $user_skill->skill_rate = $request->input('skill_rate');

      $user_skill->save();

      $current_skill = UserSkill::with('skillData')->whereid($user_skill->id)->first();
      return $current_skill;

    }
    // Edit Profile
    public function edit_profile(Request $request){
      // dd($request->all());
      $user_id = auth()->user()->id;
      // dd($request->all());
      $user = User::find($user_id);
      $user->first_name = $request->input('first_name');
      $user->last_name = $request->input('last_name');
      $user->gender = $request->input('gender');
      $user->address = $request->input('address');
      $user->country = $request->input('country');
      $user->hourly_rate = $request->input('hourly_rate');
      $user->tagline = $request->input('tagline');
      $user->description = $request->input('description');
      $profile_image = $request->file('profile_image');
      if($profile_image != ''){
        $filename= $profile_image->getClientOriginalName();
        $imagename= 'profile-'.rand(000000,999999).'.'.$profile_image->getClientOriginalExtension();
        $extension= $profile_image->getClientOriginalExtension();
        // $imagename= $filename;
        $destinationpath= public_path('assets/images/user/profile/');
        $profile_image->move($destinationpath, $imagename);
        $user->profile_image = $imagename;
      }
      $cover_image = $request->file('cover_image');
      if($cover_image != ''){
        $filenames= $cover_image->getClientOriginalName();
        $covername= 'cover-'.rand(000000,999999).'.'.$cover_image->getClientOriginalExtension();
        $extensions= $cover_image->getClientOriginalExtension();
        // $covername= $filename;
        $destinationpath= public_path('assets/images/user/cover/');
        $cover_image->move($destinationpath, $covername);
        $user->cover_image = $covername;
      }
      $save = $user->save();
      return $save;
    }

    // Experience
    public function addExperience(Request $request){
      $user_id = auth()->user()->id;
      $experience = new UserExperience;
      $experience->user_id = $user_id;
      $experience->company_title = $request->input('company_title');
      $experience->start_date = $request->input('start_date');
      $experience->end_date = $request->input('end_date');
      $experience->job_title = $request->input('job_title');
      $experience->job_description = $request->input('job_description');
      $experience->save();
      return 1;
    }

    public function editExperience(Request $request){
      $id = $request->input('id');
      $experience = UserExperience::find($id);
      $experience->company_title = $request->input('company_title');
      $experience->start_date = $request->input('start_date');
      $experience->end_date = $request->input('end_date');
      $experience->job_title = $request->input('job_title');
      $experience->job_description = $request->input('job_description');
      $experience->save();
      return 1;
    }
    public function deleteExperience($id){
      UserExperience::find($id)->delete($id);
        
      return response()->json([
          'success' => 'Record deleted successfully!'
      ]);
    }
    // Education
    public function addEducation(Request $request){
      $user_id = auth()->user()->id;
      $education = new UserEducation;
      $education->user_id = $user_id;
      $education->institute = $request->input('institute');
      $education->start_date = $request->input('start_date');
      $education->end_date = $request->input('end_date');
      $education->degree = $request->input('degree');
      $education->area_of_study = $request->input('area_of_study');
      $education->description = $request->input('description');
      $education->save();
      return 1;
    }

    public function editEducation(Request $request){
      $id = $request->input('id');
      $education = UserEducation::find($id);
      $education->institute = $request->input('institute');
      $education->start_date = $request->input('start_date');
      $education->end_date = $request->input('end_date');
      $education->degree = $request->input('degree');
      $education->area_of_study = $request->input('area_of_study');
      $education->description = $request->input('description');
      $education->save();
      return 1;
    }
    public function deleteEducation($id){
      UserEducation::find($id)->delete($id);
        
      return response()->json([
          'success' => 'Record deleted successfully!'
      ]);
    }

    // Project
    public function addProject(Request $request){
      $user_id = auth()->user()->id;
      $project = new UserProject;
      $project->user_id = $user_id;
      $project->project_title = $request->input('project_title');
      $project->project_url = $request->input('project_url');
      $project_image = $request->file('project_img');
      if($project_image != ''){
        $filename= $project_image->getClientOriginalName();
        $imagename= 'project-'.rand(000000,999999).'.'.$project_image->getClientOriginalExtension();
        $extension= $project_image->getClientOriginalExtension();
        // $imagename= $filename;
        $destinationpath= public_path('assets/images/projects/');
        $project_image->move($destinationpath, $imagename);
        $project->project_img = $imagename;
      }
      $project->project_desc = $request->input('project_desc');
      $project->save();
      return 1;
    }

    public function editProject(Request $request){
      $id = $request->input('id');

      $project = UserProject::find($id);
      $project->project_title = $request->input('project_title');
      $project->project_url = $request->input('project_url');
      $project_image = $request->file('project_img');
      if($project_image != ''){
        $filename= $project_image->getClientOriginalName();
        $imagename= 'project-'.rand(000000,999999).'.'.$project_image->getClientOriginalExtension();
        $extension= $project_image->getClientOriginalExtension();
        // $imagename= $filename;
        $destinationpath= public_path('assets/images/projects/');
        $project_image->move($destinationpath, $imagename);
        $project->project_img = $imagename;
      }
      $project->project_desc = $request->input('project_desc');

      $project->save();
      return 1;
    }
    public function deleteProject($id){
      UserProject::find($id)->delete($id);
        
      return response()->json([
          'success' => 'Record deleted successfully!'
      ]);
    }

    // Certification
    public function addCertificate(Request $request){
      $user_id = auth()->user()->id;
      $certificate = new UserCertification;
      $certificate->user_id = $user_id;
      $certificate->certificate_title = $request->input('certificate_title');
      $certificate->issue_date = $request->input('issue_date');
      $certificate->expire_date = $request->input('expire_date');
      $certificate->certificate_desc = $request->input('certificate_desc');
      $certificate->save();
      return 1;
    }

    public function editCertificate(Request $request){
      
      $id = $request->input('id');

      $certificate = UserCertification::find($id);
      $certificate->certificate_title = $request->input('certificate_title');
      $certificate->issue_date = $request->input('issue_date');
      $certificate->expire_date = $request->input('expire_date');
      $certificate->certificate_desc = $request->input('certificate_desc');
     
      $certificate->save();
      return 1;
    }
    
    public function deleteCertificate($id){
      UserCertification::find($id)->delete($id);
        
      return response()->json([
          'success' => 'Record deleted successfully!'
      ]);
    }

    public function deleteSkill($id){
      UserSkill::find($id)->delete($id);
        
      return response()->json([
          'success' => 'Record deleted successfully!'
      ]);
    }
}