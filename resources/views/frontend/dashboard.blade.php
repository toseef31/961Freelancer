@extends('frontend.layouts.app')
@section('dashboardstyle')
<link rel="stylesheet" media="screen" href="{{ asset('assets/css/dashboard.css') }}">
<link rel="stylesheet" media="screen" href="{{ asset('assets/css/dbresponsive.css') }}">
<link rel="stylesheet" media="screen" href="{{ asset('assets/css/croppie.css') }}">
<script src="{{asset('assets/js/modernizr-2.8.3-respond-1.4.2.min.js')}}"></script>
<style>
	.home-header{
		z-index: 29;
		background: #fff;
	}
	textarea:invalid {
	  border: 1px solid red;
	}
	textarea:invalid:focus {
	  border: 1px solid red;
	}
	textarea:valid:focus {
	  border: 1px solid green;
	}
	.dragBox {
	  width: 100%;
	  height: 56px;
	  margin: 0 auto;
	  position: relative;
	  text-align: center;
	  font-weight: bold;
	  line-height: 57px;
	  color: #999;
	  /*border: 2px dashed #ccc;*/
	  display: inline-block;
	  transition: transform 0.3s;
	}
	.dragBox input[type="file"] {
    position: absolute;
    height: 100%;
    width: 100%;
    opacity: 0;
    top: 0;
    left: 0;
  }
	.draging {
	  transform: scale(1.1);
	}
	#preview {
	  text-align: center;
	}
	#preview img {
	  max-width: 100%
	}
	
</style>
@endsection
@section('content')
<!--Main Start-->
<!-- Wrapper Start -->
<div id="wt-wrapper" class="wt-wrapper wt-haslayout">
	<!-- Content Wrapper Start -->
	<div class="wt-contentwrapper">
		<main id="wt-main" class="wt-main wt-haslayout">
			<!--Sidebar Start-->
			{{ View::make('frontend.includes.dashboard-sidebar') }}
			<!--Sidebar Start-->
			<!--Register Form Start-->
			<section class="wt-haslayout">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
						<div class="wt-haslayout wt-dbsectionspace">
							<div class="wt-dashboardbox wt-dashboardtabsholder">
								<div class="wt-dashboardboxtitle">
									<h2>My Profile</h2>
								</div>
								
								<div class="wt-dashboardtabs">
									<ul class="wt-tabstitle nav mb-3" id="pills-tab" role="tablist">
									  <li class="nav-item" role="presentation">
									    <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Personal Details &amp; Skills</a>
									  </li>
									  <li class="nav-item" role="presentation">
									    <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Employment &amp; Education</a>
									  </li>
									  @if(Auth::user()->account_type != 'Client')
									  <li class="nav-item" role="presentation">
									    <a class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Portfolio &amp; Certifications</a>
									  </li>
									  @endif
									</ul>
								</div>

								<div class="wt-tabscontent tab-content" id="nav-tabContent">
								  <div class="wt-personalskillshold tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
								  	<div class="wt-yourdetails wt-tabsinfo">
								  		<div class="wt-tabscontenttitle">
								  			<h2>Your Details</h2>
								  		</div>
								  		<form class="wt-formtheme wt-userform" id="edit-profile-form" enctype="multipart/form-data">
								  			@csrf
								  			<fieldset>
								  				<div class="form-group form-group-half">
								  					<label class="form-label">Username</label>
								  					<input type="text" name="username" class="form-control" placeholder="User Name" value="{{Auth::user()->username}}" readonly>
								  				</div>
								  				<div class="form-group form-group-half">
								  					<label class="form-label">Email</label>
								  					<input type="email" name="email" class="form-control" placeholder="Email" value="{{Auth::user()->email}}" readonly>
								  				</div>
								  				<div class="form-group form-group-half">
								  					<label class="form-label">Gender</label>
								  					<span class="wt-select">
								  						<select name="gender">
								  							<option value="">Select Gender</option>
								  							<option value="Male" @if(Auth::user()->gender == 'Male') selected @endif>Male</option>
								  							<option value="Female" @if(Auth::user()->gender == 'Female') selected @endif>Female</option>
								  							<option value="Other" @if(Auth::user()->gender == 'Other') selected @endif>Other</option>
								  						</select>
								  					</span>
								  				</div>
								  				<div class="form-group form-group-half">
								  					<label class="form-label">First Name</label>
								  					<input type="text" name="first_name" class="form-control" placeholder="First Name" value="{{Auth::user()->first_name}}">
								  				</div>
								  				<div class="form-group form-group-half">
								  					<label class="form-label">Last Name</label>
								  					<input type="text" name="last_name" class="form-control" placeholder="Last Name" value="{{Auth::user()->last_name}}">
								  				</div>
								  				
								  				@if(Auth::user()->account_type == 'Freelancer')
								  				<div class="form-group form-group-half">
								  					<label class="form-label">Hourly Rate</label>
								  					<input type="number" name="hourly_rate" class="form-control" placeholder="Your Service Hourly Rate ($)" value="{{Auth::user()->hourly_rate}}">
								  				</div>
								  				<div class="form-group">
								  					<label class="form-label">Date of Birth</label>
								  					<input type="date" name="age" class="form-control" placeholder="Add Date of Birth" value="{{Auth::user()->age}}">
								  				</div>
								  				<div class="form-group">
								  					<label class="form-label">Mobile Number</label>
								  					<input type="text" name="mobile_number" class="form-control" placeholder="Add Mobile Number" value="{{Auth::user()->mobile_number}}">
								  				</div>
								  				<div class="form-group">
								  					<label class="form-label">Tagline</label>
								  					<input type="text" name="tagline" class="form-control" placeholder="Add Designation" value="{{Auth::user()->tagline}}">
								  				</div>
								  				@endif
								  				
								  				@if(Auth::user()->account_type == 'Client')
								  				<div class="form-group form-group-half">
								  					<label class="form-label">Mobile Number</label>
								  					<input type="text" name="mobile_number" class="form-control" placeholder="Add Mobile Number" value="{{Auth::user()->mobile_number}}">
								  				</div>
								  				<div class="form-group">
								  					<label class="form-label">Date of Birth</label>
								  					<input type="number" name="age" class="form-control" placeholder="Add Date of Birth" value="{{Auth::user()->age}}">
								  				</div>
								  				<div class="form-group">
								  					<label class="form-label">Company/Organization Name</label>
								  					<input type="text" name="tagline" class="form-control" placeholder="Add Your Comapny, Organization Name" value="{{Auth::user()->tagline}}">
								  				</div>
								  				@endif
								  				<div class="form-group">
								  					<label class="form-label d-flex justify-content-between">Tell About Yourself/Your Company <span>(Minimum 50 Character)</span></label>
								  					<textarea name="description" class="form-control" placeholder="Description" minlength="50">{{Auth::user()->description}}</textarea>
								  				</div>
								  			</fieldset>
								  		</form>
								  	</div>
								  	<div class="wt-profilephoto wt-tabsinfo">
								  		<div class="wt-tabscontenttitle">
								  			<h2>Profile Photo</h2>
								  		</div>
								  		<div class="wt-profilephotocontent">
								  			<!-- <div class="wt-description">
								  				<p>Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua aut enim ad minim veniamac quis nostrud exercitation ullamco laboris.</p>
								  			</div> -->
								  			<div class="wt-formtheme wt-formprojectinfo wt-formcategory">
								  				<fieldset>
								  					<div class="form-group form-group-label">
								  						<div class="wt-labelgroup">
								  							<label for="uploadFile"  class="dragBox w-100">
								  								<input type="file" name="profile_image" id="uploadFile" form="edit-profile-form" onChange="dragNdrop(event)" ondragover="drag()" ondrop="drop()" id="uploadFile" class="d-block">
								  								Drag or upload profile image
								  							</label>
								  							<!-- <span>File upload</span> -->
								  							<em class="wt-fileuploading">Uploading<i class="fa fa-spinner fa-spin"></i></em>
								  						</div>
								  					</div>
								  					<div class="form-group">
								  						<ul class="wt-attachfile wt-attachfilevtwo">
								  							<li class="wt-uploadingholder">
								  								<div class="wt-uploadingbox">
								  									<div class="wt-designimg">
								  										<input id="demoz" type="radio" name="employees" value="company" checked="">
								  										<label for="demoz"  id="preview">
								  											@if(Auth::user()->profile_image)
									  											@if(!empty(Auth::user()->facebook_id) || !empty(Auth::user()->google_id))
											                    <img src="{{Auth::user()->profile_image}}" alt="">
											                    @else
											                    <img src="{{asset('assets/images/user/profile/'.Auth::user()->profile_image)}}" alt="">
											                    @endif
								  											@else
								  											<img src="{{asset('assets/images/user/userlisting/img-07.jpg')}}" alt="img description" id="profile">
								  											@endif
								  											<i class="fa fa-check"></i></label>
								  									</div>
								  									<div class="wt-uploadingbar">
								  										<!-- <span class="uploadprogressbar"></span> -->
								  										<span id="img_name" class="text-break text-wrap">{{Auth::user()->profile_image}}</span>
								  										<!-- <em>File size: 300 kb<a href="javascript:void(0);" class="lnr lnr-cross"></a></em> -->
								  									</div>
								  								</div>
								  							</li>
								  						</ul>
								  					</div>
								  				</fieldset>
								  			</div>
								  		</div>
								  	</div>
								  	<div class="wt-bannerphoto wt-tabsinfo">
								  		<div class="wt-tabscontenttitle">
								  			<h2>Banner Photo</h2>
								  		</div>
								  		<div class="wt-profilephotocontent">
								  			<!-- <div class="wt-description">
								  				<p>Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua aut enim ad minim veniamac quis nostrud exercitation ullamco laboris.</p>
								  			</div> -->
								  			<div class="wt-formtheme wt-formprojectinfo wt-formcategory">
								  				<fieldset>
								  					<div class="form-group form-group-label">
								  						<div class="wt-labelgroup">
								  							<label for="fileCover" class="dragBox">
								  								<!-- <span class="wt-btn">Select Files</span> -->
								  								<input type="file" name="cover_image" id="fileCover"  onChange="dragNdropCover(event)" ondragover="dragCover()" ondrop="dropCover()" class="d-block" form="edit-profile-form">
								  								Drag or upload cover image
								  							</label>
								  							<!-- <span>file upload</span> -->
								  							<em class="wt-fileuploading">Uploading<i class="fa fa-spinner fa-spin"></i></em>
								  						</div>
								  					</div>
								  					<div class="form-group">
								  						<ul class="wt-attachfile wt-attachfilevtwo">
								  							<li class="wt-uploadingholder">
								  								<div class="wt-uploadingbox">
								  									<div class="wt-designimg">
								  										<input id="demoq" type="radio" name="employees" value="company" checked="">
								  										<label for="demoq" id="coverPreview">
								  											@if(Auth::user()->cover_image)
								  											<img src="{{asset('assets/images/user/cover/'.Auth::user()->cover_image)}}" id="cover" alt="img description">
								  											@else
								  											<img id="cover" src="{{asset('assets/images/company/img-10.jpg')}}" alt="img description">
								  											@endif
								  											<i class="fa fa-check"></i>
								  										</label>
								  									</div>
								  									<div class="wt-uploadingbar">
								  										<span class="uploadprogressbar"></span>
								  										<span id="covrimg_name" class="text-break text-wrap">Banner Photo.jpg</span>
								  										<!-- <em>File size: 300 kb<a href="javascript:void(0);" class="lnr lnr-cross"></a></em> -->
								  									</div>
								  								</div>
								  							</li>
								  						</ul>
								  					</div>
								  				</fieldset>
								  			</div>
								  		</div>
								  	</div>
								  	<div class="wt-location wt-tabsinfo">
								  		<div class="wt-tabscontenttitle">
								  			<h2>Your Location</h2>
								  		</div>
								  		<div class="wt-formtheme wt-userform">
								  			<fieldset style="overflow: initial;">
								  				<div class="form-group form-group-half">
								  					<span class="wt-select">
								  						<select name="country" form="edit-profile-form" class="chosen-select">
								  							@foreach($countries as $country)
								  							<option value="{{$country->name}}"  @if(Auth::user()) {{Auth::user()->country == $country->name ? 'selected="selected"' : ''}} @endif>{{$country->name}}</option>
								  							@endforeach
								  						</select>
								  					</span>
								  				</div>
								  				<div class="form-group form-group-half">
								  					<input type="text" name="address" class="form-control" placeholder="Your Address" form="edit-profile-form" value="{{Auth::user()->address}}">
								  				</div>
								  			</fieldset>
								  		</div>
								  	</div>
								  	@if(Auth::user()->account_type != 'Client')
								  	<div class="wt-skills">
								  		<div class="wt-tabscontenttitle">
								  			<h2>My Skills</h2>
								  		</div>
								  		<div class="wt-skillscontent-holder">
								  			<form class="wt-formtheme wt-skillsform" id="add_skill">
								  				@csrf
								  				<input type="hidden" name="user_id" value="{{Auth::user()->id}}">
								  				<fieldset>
								  					<div class="form-group">
								  						<div class="form-group-holder border-0">
								  							<span class="wt-select w-100 border-top-0">
								  								<select name="skill_id" class="w-100 border rounded">
								  									<option value="">Select Your Skill</option>
								  									@foreach($skills as $skill)
								  									<option value="{{$skill->id}}">{{$skill->skill_name}}</option>
								  									@endforeach
								  								</select>
								  							</span>
								  						</div>
								  					</div>
								  					<div class="form-group wt-btnarea">
								  						<button type="submit" id="addSkills" class="wt-btn" {{count($user_skills) == 12 ? 'disabled' : ''}}>Add Skills</button>
								  					</div>
								  				</fieldset>
								  			</form>
								  			<div class="wt-myskills">
								  				@if(count($user_skills) == 12)
								  					<p class="count_skill">You cannot add more than 12 skills.</p>
								  				@endif
								  				<p id="skill_length" class="d-none">You cannot add more than 12 skills.</p>
								  				<ul class="sortable list" id="userskilss">
								  					@foreach($user_skills as $key => $user_skill)
								  					<li id="userSkill{{$user_skill->id}}">
								  						<!-- <div class="wt-dragdroptool">
								  							<a href="javascript:void(0)" class="fal fa-bars"></a>
								  						</div> -->
								  						<span class="skill-dynamic-html">{{$user_skill->skillData->skill_name}}</span>
								  						<div class="wt-rightarea">
								  							<!-- <a href="javascript:void(0);" class="wt-addinfo" onclick="updateSkill({{$user_skill->id}})"><i class="fal fa-pencil"></i></a> -->
								  							<a href="javascript:void(0);" class="wt-deleteinfo" onclick="deleteSkill({{$user_skill->id}})"><i class="fal fa-trash-alt"></i></a>
								  						</div>
								  					</li>
								  					@endforeach
								  				</ul>
								  			</div>
								  		</div>
								  	</div>
								  	@endif
								  	<div class="wt-updatall shadow-none mt-5">
								  		<button type="submit" id="update_profile" form="edit-profile-form" class="wt-btn">Save &amp; Update</button>
								  		<button type="button" class="wt-btn me-3 d-none" id="continue_education">Continue</button>
								  	</div>
								  </div>
								  <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
								  	<div class="wt-userexperience wt-tabsinfo">
								  		<div class="wt-tabscontenttitle wt-addnew">
								  			<h2>Add Your Employment History</h2>
								  			<a href="javascript:void(0);" id="addExperience" data-bs-toggle="collapse" data-bs-target="#addexperience" aria-expanded="true">Add New</a>
								  		</div>
								  		<div class="wt-collapseexp collapse" id="addexperience" aria-labelledby="accordioninnertitle" data-parent="#accordion">
									  		<form class="wt-formtheme wt-userform" id="add-experience-form">
									  			@csrf
									  			<fieldset>
									  				<div class="form-group form-group-half">
									  					<input type="text" name="company_title" class="form-control" placeholder="Company Title">
									  				</div>
									  				<div class="form-group form-group-half">
									  					<input type="text" name="job_title" class="form-control" placeholder="Your Job Title">
									  				</div>
									  				<div class="form-group form-group-half">
									  					<input type="date" name="start_date" class="form-control" placeholder="Starting Date">
									  				</div>
									  				<div class="form-group form-group-half">
									  					<input type="date" name="end_date" class="form-control" placeholder="Ending Date">
									  				</div>
									  				
									  				<div class="form-group">
									  					<input type="checkbox" name="present_job">
									  					Present Job
									  				</div>
									  				<div class="form-group">
									  					<textarea name="job_description" class="form-control" placeholder="Your Job Description" minlength="50"></textarea>
									  					<span>(Minimum 50 Character)</span>
									  				</div>
									  				<div class="form-group">
									  					<span class="fs-6">* Leave ending date empty if its your current job</span>
									  				</div>
									  				<div class="form-group mt-3 text-end">
									  					<button type="submit" class="wt-btn">Save</button>
									  				</div>
									  			</fieldset>
									  		</form>
									  	</div>
								  		<ul class="wt-experienceaccordion accordion" id="experience-list">
								  			@foreach($experience as $exper)
								  			<li id="expernc{{$exper->id}}">
								  				<div class="wt-accordioninnertitle">
								  					<span id="accordioninner{{$exper->id}}" data-bs-toggle="collapse" data-bs-target="#inner{{$exper->id}}"><span id="title{{$exper->id}}">{{$exper->job_title}}</span><span class="text-muted" id="start{{$exper->id}}"><em> ({{date('d-m-Y', strtotime($exper->start_date))}}</em></span> - <span class="text-muted" id="end{{$exper->id}}">
								  						<em>
								  							@if($exper->present_job == 'on')
								  							Present
								  							@else
								  							{{date('d-m-Y', strtotime($exper->end_date))}}
								  							@endif
								  						)</em>
								  						</span></span>
								  					<div class="wt-rightarea">
								  						<a href="javascript:void(0);" class="wt-addinfo wt-skillsaddinfo" id="accordioninner{{$exper->id}}" data-bs-toggle="collapse" data-bs-target="#inner{{$exper->id}}" aria-expanded="true"><i class="fal fa-pencil"></i></a>
								  						<a href="javascript:void(0);" onclick="deleteExperience({{$exper->id}})" class="wt-deleteinfo"><i class="fal fa-trash-alt"></i></a>
								  					</div>
								  				</div>
								  				<div class="wt-collapseexp collapse" id="inner{{$exper->id}}" aria-labelledby="accordioninnertitle" data-bs-parent="#accordion">
								  					<div class="wt-formtheme wt-userform">
								  						<input type="hidden" name="id" id="experienceId{{$exper->id}}" value="{{$exper->id}}">
								  						<input type="hidden" name="_token" id="experienceId{{$exper->id}}" value="{{$exper->id}}">
								  						<fieldset>
								  							<div class="form-group form-group-half">
								  								<input type="text" id="company_title{{$exper->id}}" name="company_title" class="form-control" placeholder="Company Title" value="{{$exper->company_title}}">
								  							</div>
								  							<div class="form-group form-group-half">
								  								<input type="text" id="job_title{{$exper->id}}" name="job_title" value="{{$exper->job_title}}" class="form-control" placeholder="Your Job Title">
								  							</div>
								  							<div class="form-group form-group-half">
								  								<input type="date" id="start_date{{$exper->id}}" name="start_date" value="{{$exper->start_date}}" class="form-control" placeholder="Starting Date">
								  							</div>
								  							<div class="form-group form-group-half">
								  								<input type="date" id="end_date{{$exper->id}}" name="end_date" value="{{$exper->end_date}}" class="form-control" placeholder="Ending Date ">
								  							</div>
								  							<div class="form-group">
								  								<input type="checkbox" name="present_job" {{ $exper->present_job === "on" ? "checked" : "" }}>
								  								Present Job
								  							</div>
								  							<div class="form-group">
								  								<textarea name="job_description" id="job_description{{$exper->id}}" class="form-control" placeholder="Your Job Description" minlength="50">{{$exper->job_description}}</textarea>
								  								<span>(Minimum 50 Character)</span>
								  							</div>
								  							<div class="form-group">
								  								<span>* Leave ending date empty if its your current job</span>
								  							</div>
								  							<div class="form-group mt-3 text-end">
								  								<button onclick="editExperience({{$exper->id}})" class="wt-btn">Edit Employment History</button>
								  							</div>
								  						</fieldset>
								  					</div>
								  				</div>
								  			</li>
								  			@endforeach
								  		</ul>
								  	</div>
								  	<div class="wt-userexperience">
								  		<div class="wt-tabscontenttitle wt-addnew">
								  			<h2>Add Your Education</h2>
								  			<a href="javascript:void(0);" id="addEducation" data-bs-toggle="collapse" data-bs-target="#addeducation" aria-expanded="true">Add New</a>
								  		</div>
								  		<div class="wt-collapseexp collapse" id="addeducation" aria-labelledby="addEducation" data-parent="#accordion">
								  			<form class="wt-formtheme wt-userform" id="add-education-form">
								  				@csrf
								  				<fieldset>
								  					<div class="form-group form-group-half">
								  						<input type="text" name="institute" class="form-control" placeholder="School/College/University">
								  					</div>
								  					<div class="form-group form-group-half">
								  						<input type="text" name="degree" class="form-control" placeholder="Your Degree Title">
								  					</div>
								  					<div class="form-group form-group-half">
								  						<input type="date" name="start_date" class="form-control" placeholder="From Date">
								  					</div>
								  					<div class="form-group form-group-half">
								  						<input type="date" name="end_date" id="edu_end_date" class="form-control" placeholder="To Date ">
								  					</div>
								  					<div class="form-group">
								  						<input type="checkbox" name="continue_study">
								  						Continue Study
								  					</div>
								  					<div class="form-group">
								  						<input type="text" name="area_of_study" class="form-control" placeholder="Ex: Computer Science">
								  					</div>
								  					<!-- <div class="form-group">
								  						<textarea name="description" class="form-control" placeholder="Your Degree Description"></textarea>
								  					</div> -->
								  					<div class="form-group mt-3 text-end">
								  						<button type="submit" id="add-education" class="wt-btn">Save Education</button>
								  					</div>
								  				</fieldset>
								  			</form>
								  		</div>
								  		<ul class="wt-experienceaccordion accordion" id="education_list">
								  			@foreach($education as $educ)
								  			<li id="educatn{{$educ->id}}">
								  				<div class="wt-accordioninnertitle">
								  					<span id="accordioneducation{{$educ->id}}" data-bs-toggle="collapse" data-bs-target="#innertitleeduc{{$educ->id}}"><span id="degree{{$educ->id}}">{{$educ->degree}}</span> <span id="start_edu{{$educ->id}}"><em>({{date('d-m-Y', strtotime($educ->start_date))}}</em></span> - <span id="end_edu{{$educ->id}}"><em> 
								  						@if($educ->continue_study == 'on')
								  						Continue
								  						@else
								  						{{date('d-m-Y', strtotime($educ->end_date))}}
								  						@endif
								  					)</em></span></span>
								  					<div class="wt-rightarea">
								  						<a href="javascript:void(0);" class="wt-addinfo wt-skillsaddinfo" id="accordioneducation{{$educ->id}}" data-bs-toggle="collapse" data-bs-target="#innertitleeduc{{$educ->id}}" aria-expanded="true"><i class="fal fa-pencil"></i></a>
								  						<a href="javascript:void(0);" class="wt-deleteinfo" onclick="deleteEducation({{$educ->id}})"><i class="fal fa-trash-alt"></i></a>
								  					</div>
								  				</div>
								  				<div class="wt-collapseexp collapse" id="innertitleeduc{{$educ->id}}" aria-labelledby="accordioneducation{{$educ->id}}" data-bs-parent="#accordion">
								  					<div class="wt-formtheme wt-userform">
								  						<fieldset>
								  							<input type="hidden" name="educaId" value="{{$educ->id}}">
										  					<div class="form-group form-group-half">
										  						<input type="text" name="institute" id="institute{{$educ->id}}" class="form-control" placeholder="School/College/University" value="{{$educ->institute}}">
										  					</div>
										  					<div class="form-group form-group-half">
										  						<input type="text" name="degree" id="degree_edu{{$educ->id}}" class="form-control" placeholder="Your Degree Title" value="{{$educ->degree}}">
										  					</div>
										  					<div class="form-group form-group-half">
										  						<input type="date" name="start_date" id="start_date_edu{{$educ->id}}" class="form-control" placeholder="From Date" value="{{$educ->start_date}}">
										  					</div>
										  					<div class="form-group form-group-half">
										  						<input type="date" name="end_date" id="end_date_edu{{$educ->id}}" id="edit_end_date" class="form-control" placeholder="To Date " value="{{$educ->end_date}}" {{ $educ->continue_study === "on" ? "readonly" : "" }}>
										  					</div>
										  					<div class="form-group">
										  						<input type="checkbox" name="continue_study" {{ $educ->continue_study === "on" ? "checked" : "" }}>
										  						Continue Study
										  					</div>
										  					
										  					<div class="form-group">
										  						<input type="text" name="area_of_study" id="area_of_study{{$educ->id}}" class="form-control" placeholder="Ex: Computer Science" value="{{$educ->area_of_study}}">
										  					</div>
										  					<!-- <div class="form-group">
										  						<textarea name="description" id="degree_desc{{$educ->id}}" class="form-control" placeholder="Your Degree Description">{{$educ->description}}</textarea>
										  					</div> -->
										  					<div class="form-group mt-3 text-end">
										  						<button onclick="editEducation({{$educ->id}})" class="wt-btn">Edit Education</button>
										  					</div>
										  				</fieldset>
								  					</div>
								  				</div>
								  			</li>
								  			@endforeach
								  		</ul>
								  	</div>
								  	<div class="form-group mt-5 px-4 text-end">
								  		<button type="button" id="continue_portfolio" class="wt-btn">Continue</button>
								  	</div>
								  </div>
								  <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
								  	<div class="wt-addprojectsholder wt-tabsinfo">
								  		<div class="wt-tabscontenttitle wt-addnew">
								  			<h2>Add Your Portfolio</h2>
								  			<a href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#addProject">Add New</a>
								  		</div>
								  		<div class="wt-collapseexp collapse" id="addProject" aria-labelledby="addProject" data-bs-parent="#accordion">
								  			<form class="wt-formtheme wt-userform wt-formprojectinfo" id="add-project-form">
								  				@csrf
								  				<fieldset>
								  					<div class="form-group form-group-half">
								  						<input type="text" name="project_title" class="form-control" placeholder="Project Title">
								  					</div>
								  					<div class="form-group form-group-half">
								  						<input type="text" name="project_url" class="form-control" placeholder="Project URL">
								  					</div>
								  					<div class="form-group form-group-label wt-infouploading">
								  						<div class="wt-labelgroup">
								  							<label for="filen">
								  								<span class="wt-btn">Select Files</span>
								  								<input type="file" name="project_img" onchange="projectImage(this);" id="filen">
								  							</label>
								  							<span>Files Upload</span>
								  							<!-- <em class="wt-fileuploading">Uploading</em> -->
								  						</div>
								  					</div>
								  					<div class="form-group">
								  						<ul class="wt-attachfile">
								  							<li class="wt-uploaded">
								  								<span id="projectimg_name">Logo.jpg</span>
								  								<em>File size: <span id="projectImg_size">300 kb</span></em>
								  							</li>
								  						</ul>
								  					</div>
								  					<div class="form-group">
								  						<textarea name="project_desc" class="form-control" placeholder="Project Description" minlength="50"></textarea>
								  						<span>(Minimum 50 Character)</span>
								  					</div>
								  					<div class="form-group wt-btnarea text-end">
								  						<button type="submit" class="wt-btn">Save</button>
								  					</div>
								  				</fieldset>
								  			</form>
								  		</div>
								  		<ul class="wt-experienceaccordion accordion" id="projects-list">
								  			@foreach($projects as $project)
								  			<li id="projecList{{$project->id}}">
								  				<div class="wt-accordioninnertitle">
								  					<div class="wt-projecttitle collapsed" data-bs-toggle="collapse" data-bs-target="#innerproject{{$project->id}}" aria-expanded="false" aria-controls="innerproject{{$project->id}}">
								  						<figure><img src="{{asset('assets/images/projects/'.$project->project_img)}}" alt="img description"></figure>
								  						<h3>
								  							<font id="projectName{{$project->id}}">{{$project->project_title}}</font><span id="projectUrl{{$project->id}}">{{$project->project_url}}</span></h3>
								  					</div>
								  					<div class="wt-rightarea">
								  						<a href="javascript:void(0);" class="wt-addinfo wt-skillsaddinfo" data-bs-toggle="collapse" data-bs-target="#innerproject{{$project->id}}"><i class="fal fa-pencil"></i></a>
								  						<a href="javascript:void(0);" onclick="deleteProject({{$project->id}})" class="wt-deleteinfo"><i class="fal fa-trash-alt"></i></a>
								  					</div>
								  				</div>
								  				<div class="wt-collapseexp collapse" id="innerproject{{$project->id}}" aria-labelledby="accordioninnerproject{{$project->id}}" data-bs-parent="#accordion">
								  					<div class="wt-formtheme wt-userform wt-formprojectinfo">
								  						<fieldset>
								  							<div class="form-group form-group-half">
								  								<input type="text" id="project_title{{$project->id}}" name="project_title" class="form-control" placeholder="Project Title" value="{{$project->project_title}}">
								  							</div>
								  							<div class="form-group form-group-half">
								  								<input type="text" name="project_url" id="project_url{{$project->id}}" class="form-control" placeholder="Project URL" value="{{$project->project_url}}">
								  							</div>
								  							<div class="form-group form-group-label wt-infouploading">
								  								<div class="wt-labelgroup">
								  									<label for="filen{{$project->id}}">
								  										<span class="wt-btn">Select Files</span>
								  										<input type="file" name="project_img" onchange="projectImageEdit(this,{{$project->id}});" id="filen{{$project->id}}">
								  									</label>
								  									<span>Drop files here to upload</span>
								  									<!-- <em class="wt-fileupload">Uploading<i class="fa fa-spinner fa-spin"></i></em> -->
								  								</div>
								  							</div>
								  							<div class="form-group">
								  								<ul class="wt-attachfile">
								  									<li class="wt-uploaded">
								  										<span id="projectimg_name{{$project->id}}">{{$project->project_img}}</span>
								  								<em>File size: <span id="projectImg_size{{$project->id}}">300 kb</span></em>
								  									</li>
								  								</ul>
								  							</div>
								  							<div class="form-group">
								  								<textarea name="project_desc" id="project_desc{{$project->id}}" class="form-control" placeholder="Project Description" minlength="50">{{$project->project_desc}}</textarea>
								  								<span>(Minimum 50 Character)</span>
								  							</div>
								  							<div class="form-group wt-btnarea text-end">
								  								<button onclick="editProject({{$project->id}})" class="wt-btn">Edit Project</button>
								  							</div>
								  						</fieldset>
								  					</div>
								  				</div>
								  			</li>
								  			@endforeach
								  		</ul>
								  	</div>
								  	<div class="wt-addprojectsholder">
								  		<div class="wt-tabscontenttitle wt-addnew">
								  			<h2>Add Your Certification</h2>
								  			<a href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#addCertificate">Add New</a>
								  		</div>
								  		<div class="wt-collapseexp collapse" id="addCertificate" aria-labelledby="accordioninnerCertificate" data-parent="#accordion">
								  			<form class="wt-formtheme wt-userform wt-formprojectinfo" id="add-certificate-form">
								  				@csrf
								  				<fieldset>
								  					<div class="form-group">
								  						<input type="text" name="certificate_title" class="form-control" placeholder="Certificate Title">
								  					</div>
								  					<div class="form-group form-group-half">
								  						<input type="date" name="issue_date" class="form-control" placeholder="Issue Date">
								  					</div>
								  					<div class="form-group form-group-half">
								  						<input type="date" name="expire_date" class="form-control" placeholder="Expire Date">
								  					</div>
								  					<div class="form-group">
								  						<textarea name="certificate_desc" id="" class="form-control" placeholder="Certificate Description" minlength="50"></textarea>
								  						<span>(Minimum 50 Character)</span>
								  					</div>
								  					<div class="form-group wt-btnarea text-end">
								  						<button type="submit" class="wt-btn">Save</button>
								  					</div>
								  				</fieldset>
								  			</form>
								  		</div>
								  		<ul class="wt-experienceaccordion accordion" id="certificates-list">
								  			@foreach($certifications as $certificate)
								  			<li id="certifcateList{{$certificate->id}}">
								  				<div class="wt-accordioninnertitle">
								  					<div class="wt-projecttitle collapsed" data-bs-toggle="collapse" data-bs-target="#innertitlecwcertificate{{$certificate->id}}">
								  						
								  						<h3><font id="certificateName{{$certificate->id}}">{{$certificate->certificate_title}}</font><samp id="certificateDate{{$certificate->id}}">{{date('d-m-Y', strtotime($certificate->issue_date))}}</samp></h3>
								  					</div>
								  					<div class="wt-rightarea">
								  						<a href="javascript:void(0);" class="wt-addinfo wt-skillsaddinfo" data-bs-toggle="collapse" data-bs-target="#innertitlecwcertificate{{$certificate->id}}"><i class="fal fa-pencil"></i></a>
								  						<a href="javascript:void(0);" onclick="deleteCertificate({{$certificate->id}})" class="wt-deleteinfo"><i class="fal fa-trash-alt"></i></a>
								  					</div>
								  				</div>
								  				<div class="wt-collapseexp collapse" id="innertitlecwcertificate{{$certificate->id}}" aria-labelledby="accordioninnertitle1" data-parent="#accordion">
								  					<div class="wt-formtheme wt-userform wt-formprojectinfo">
								  						<fieldset>
								  							<div class="form-group">
								  								<input type="text" id="certificate_title{{$certificate->id}}" name="certificate_title" class="form-control" value="{{$certificate->certificate_title}}" placeholder="Certificate Title">
								  							</div>
								  							<div class="form-group form-group-half">
								  								<input type="date" id="issue_date{{$certificate->id}}" name="issue_date" value="{{$certificate->issue_date}}" class="form-control" placeholder="Issue Date">
								  							</div>
								  							<div class="form-group form-group-half">
								  								<input type="date" id="expire_date{{$certificate->id}}" name="expire_date" class="form-control" value="{{$certificate->expire_date}}" placeholder="Expire Date">
								  							</div>
								  							<div class="form-group">
								  								<textarea name="certificate_desc" id="certificate_desc{{$certificate->id}}" id="" class="form-control" placeholder="Certificate Description" minlength="50">{{$certificate->certificate_desc}}</textarea>
								  								<span>(Minimum 50 Character)</span>
								  							</div>
								  							<div class="form-group wt-btnarea text-end">
								  								<button onclick="editCertificate({{$certificate->id}})" class="wt-btn">Edit Certificate</button>
								  							</div>
								  						</fieldset>
								  					</div>
								  				</div>
								  			</li>
								  			@endforeach
								  		</ul>
								  	</div>
								  </div>
								</div>
							</div>
						</div>
						<!-- <div class="wt-updatall">
							<i class="ti-announcement"></i>
							<span>Update all the latest changes made by you, by just clicking on “Save &amp; Continue” button.</span>
							<a class="wt-btn" href="javascript:void(0);">Save &amp; Update</a>
						</div> -->
					</div>
				</div>
			</section>
			<!--Register Form End-->
		</main>
		<!--Main End-->
	</div>
</div>
<div id="insertimageModal" class="modal" role="dialog">
  <div class="modal-dialog modal-md">
  <div class="modal-content">
    <div class="modal-header">
     Crop & Insert Image <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">
      <div id="image_demo" style="width:100% !important;"></div>
    </div>
    <div class="modal-footer">
      <input type="hidden" name="img_type" value="">
      <button class="btn crop_image">Crop Image</button>
      <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
    </div>
    </div>
  </div>
</div>

<div id="insertCoverModal" class="modal" role="dialog">
  <div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
     Crop & Insert Cover <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">
      <div id="cover_demo" style="width:100% !important;"></div>
    </div>
    <div class="modal-footer">
      <input type="hidden" name="img_type_cover" value="">
      <button class="btn crop_image_cover">Crop Image</button>
      <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
    </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script src="{{ URL::asset('assets/js/croppie.js') }}"></script>
<script>
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
 $('#add_skill').on('submit', function(event){
   	event.preventDefault();
   	

   	$.ajax({
	    url:"{{ url('add_skill') }}",
	    method:"POST",
	    data:new FormData(this),
	    dataType:'JSON',
	    contentType: false,
	    cache: false,
	    processData: false,
	    success:function(data){
	    	console.log(data);
	    	$('#userskilss').append('<li id="userSkill'+data.skill.id+'"><span class="skill-dynamic-html">'+data.skill.skill_data.skill_name+'</span><div class="wt-rightarea"><a href="javascript:void(0);" class="wt-deleteinfo" onclick="deleteSkill('+data.skill.id+')"><i class="fal fa-trash-alt"></i></a></div></li>');
	    	if(data.count == 12){
	    		$('#addSkills').attr('disabled','true');
	    		$('#skill_length').removeClass('d-none');
	    		$('.count_skill').addClass('d-none');
	    	}
	     	// window.location.href = "{{url('manage-orders')}}"
	     	// $('.added-questions').append(data);
	     	// $('#requirements-form textarea').val('');
    	}
   	})
	});

 $('#edit-profile-form').on('submit', function(event){
   	event.preventDefault();
   	

   	$.ajax({
	    url:"{{ url('edit-profile') }}",
	    method:"POST",
	    data:new FormData(this),
	    dataType:'JSON',
	    contentType: false,
	    cache: false,
	    processData: false,
	    success:function(data){
	    	console.log(data);
	    	$('#continue_education').removeClass('d-none');
    	}
   	})
	});
 	
 	$('#continue_education').click(function(){
 		$('#pills-home-tab').removeClass('active');
 		$('#pills-profile-tab').addClass('active');
 		$('#pills-home').removeClass('show active');
 		$('#pills-profile').addClass('show active');
 	});

 $('#add-experience-form').on('submit', function(event){
   	event.preventDefault();
   	

   	$.ajax({
	    url:"{{ url('add-experience') }}",
	    method:"POST",
	    data:new FormData(this),
	    dataType:'JSON',
	    contentType: false,
	    cache: false,
	    processData: false,
	    success:function(response){
	    	console.log(response);
	    	$("#add-experience-form")[0].reset();
	    	
	    	if (response.status == 'true') {
	    		 	
	    		 $.notify(response.message , 'success'  );
	    	      $('#experience-list').append('<li id="expernc'+response.data.id+'"><div class="wt-accordioninnertitle"><span id="accordioninner'+response.data.id+'" data-bs-toggle="collapse" data-bs-target="#inner'+response.data.id+'"><span id="title'+response.data.id+'">'+response.data.job_title+'</span><span class="text-muted" id="startresponse.data.id"><em> ('+response.data.start_date+'</em></span> - <span class="text-muted" id="end'+response.data.id+'"><em>'+response.data.end_date+')</em></span></span><div class="wt-rightarea"><a href="javascript:void(0);" class="wt-addinfo wt-skillsaddinfo" id="accordioninner'+response.data.id+'" data-bs-toggle="collapse" data-bs-target="#inner'+response.data.id+'" aria-expanded="true"><i class="fal fa-pencil"></i></a><a href="javascript:void(0);" onclick="deleteExperience('+response.data.id+')" class="wt-deleteinfo"><i class="fal fa-trash-alt"></i></a></div></div></li>');
	    		 	 // 	$('#pills-home-tab').removeClass('active');
	    		 		// $('#pills-profile-tab').addClass('active');
	    		 		// $('#pills-home').removeClass('show active');
	    		 		// $('#pills-profile').addClass('show active');   
	    	    
	    	}else{
	    	    $.notify(response.message , 'error');

	    	}
	    	
    	}
   	})
	});

 $('#add-education-form').on('submit', function(event){
   	event.preventDefault();
   	

   	$.ajax({
	    url:"{{ url('add-education') }}",
	    method:"POST",
	    data:new FormData(this),
	    dataType:'JSON',
	    contentType: false,
	    cache: false,
	    processData: false,
	    success:function(response){
	    	console.log(response);
	    	$("#add-education-form")[0].reset();
	    	if (response.status == 'true') {
	    		 	
	    		 $.notify(response.message , 'success'  );
	    	      $('#education_list').append('<li id="educatn'+response.data.id+'"><div class="wt-accordioninnertitle"><span id="accordioneducation'+response.data.id+'" data-bs-toggle="collapse" data-bs-target="#innertitleeduc'+response.data.id+'"><span id="degree'+response.data.id+'">'+response.data.degree+'</span> <span id="start_edu'+response.data.id+'"><em>('+response.data.start_date+'</em></span> - <span id="end_edu'+response.data.id+'"><em> '+response.data.end_date+')</em></span></span><div class="wt-rightarea"><a href="javascript:void(0);" class="wt-addinfo wt-skillsaddinfo" id="accordioneducation'+response.data.id+'" data-bs-toggle="collapse" data-bs-target="#innertitleeduc'+response.data.id+'" aria-expanded="true"><i class="fal fa-pencil"></i></a><a href="javascript:void(0);" class="wt-deleteinfo" onclick="deleteEducation('+response.data.id+')"><i class="fal fa-trash-alt"></i></a></div></div></li>');
	    		 	   
	    	    
	    	}else{
	    	    $.notify(response.message , 'error');

	    	}

    	}
   	})
	});

 	$('#continue_portfolio').click(function(){
 		$('#pills-contact-tab').addClass('active');
 		$('#pills-profile-tab').removeClass('active');
 		$('#pills-contact').addClass('show active');
 		$('#pills-profile').removeClass('show active');
 	});

 $('#add-project-form').on('submit', function(event){
   	event.preventDefault();
   	

   	$.ajax({
	    url:"{{ url('add-project') }}",
	    method:"POST",
	    data:new FormData(this),
	    dataType:'JSON',
	    contentType: false,
	    cache: false,
	    processData: false,
	    success:function(response){
	    	console.log(response);
	    	$("#add-project-form")[0].reset();
	    	if (response.status == 'true') {
	    		 	
	    		 $.notify(response.message , 'success'  );
	    	      $('#projects-list').append('<li id="projecList'+response.data.id+'"><div class="wt-accordioninnertitle"><div class="wt-projecttitle collapsed" data-bs-toggle="collapse" data-bs-target="#innerproject'+response.data.id+'" aria-expanded="false" aria-controls="innerproject'+response.data.id+'"><figure><img src="/assets/images/projects/'+response.data.project_img+'" alt="img description"></figure><h3><font id="projectName'+response.data.id+'">'+response.data.project_title+'</font><span id="projectUrl'+response.data.id+'">'+response.data.project_url+'</span></h3></div><div class="wt-rightarea"><a href="javascript:void(0);" class="wt-addinfo wt-skillsaddinfo" data-bs-toggle="collapse" data-bs-target="#innerproject'+response.data.id+'"><i class="fal fa-pencil"></i></a><a href="javascript:void(0);" onclick="deleteProject('+response.data.id+')" class="wt-deleteinfo"><i class="fal fa-trash-alt"></i></a></div></div></li>');
	    		 	   
	    	    
	    	}else{
	    	    $.notify(response.message , 'error');

	    	}

    	}
   	})
	});

 $('#add-certificate-form').on('submit', function(event){
   	event.preventDefault();
   	

   	$.ajax({
	    url:"{{ url('add-certificate') }}",
	    method:"POST",
	    data:new FormData(this),
	    dataType:'JSON',
	    contentType: false,
	    cache: false,
	    processData: false,
	    success:function(response){
	    	console.log(response);
	    	$("#add-certificate-form")[0].reset();
	    	if (response.status == 'true') {
	    		 	
	    		$.notify(response.message , 'success'  );
  	      $('#certificates-list').append('<li id="certifcateList'+response.data.id+'"><div class="wt-accordioninnertitle"><div class="wt-projecttitle collapsed" data-bs-toggle="collapse" data-bs-target="#innertitlecwcertificate'+response.data.id+'"><h3><font id="certificateName'+response.data.id+'">'+response.data.certificate_title+'</font><samp id="certificateDate'+response.data.id+'">'+response.data.issue_date+'</samp></h3></div><div class="wt-rightarea"><a href="javascript:void(0);" class="wt-addinfo wt-skillsaddinfo" data-bs-toggle="collapse" data-bs-target="#innertitlecwcertificate'+response.data.id+'"><i class="fal fa-pencil"></i></a><a href="javascript:void(0);" onclick="deleteCertificate('+response.data.id+')" class="wt-deleteinfo"><i class="fal fa-trash-alt"></i></a></div></div></li>');
	    		 	      
	    	}else{
	    	  $.notify(response.message , 'error');

	    	}
    	}
   	})
	});

 	function updateSkill(id){
 		// alert(id);
 	}

 	function deleteSkill(id){
 		// alert(id);
	   	
 	   	$.ajax({
 		    url:"{{ url('delete-skill') }}/"+id,
 		    type: 'DELETE',
 	      data: {
 	      		"_token": CSRF_TOKEN,
 	          "id": id
 	      },
 	      success: function (data){
 	        $('#userSkill'+id).remove();
 	        if(data.count < 12){
 	        	$('#addSkills').removeAttr('disabled');
 	        	$('#skill_length').addClass('d-none');
 	        }
 	      }
 	   	})
 	}
 	function profileImage(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        console.log(reader);
        reader.onload = function (e) {
            $('#profile')
                .attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
    var filename = $('#uploadFile').val().split('\\').pop();
    $('#img_name').html(filename);
   
	}
 	function coverImage(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        console.log(reader);
        reader.onload = function (e) {
            $('#cover')
                .attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
    var filename = $('#filew').val().split('\\').pop();
    $('#covrimg_name').html(filename);
   
	}

 	function projectImage(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        console.log(reader);
        reader.onload = function (e) {
            $('#projectImg')
                .attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);

        var _size = input.files[0].size;
          var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'),
      		i=0;while(_size>900){_size/=1024;i++;}
          var exactSize = (Math.round(_size*100)/100)+' '+fSExt[i];
      	$('#projectImg_size').html(exactSize)
    }
    var filename = $('#filen').val().split('\\').pop();
    $('#projectimg_name').html(filename);
    
	}
 	function projectImageEdit(input,id) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        console.log(reader);
        reader.onload = function (e) {
            $('#projectImg'+id)
                .attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);

        var _size = input.files[0].size;
          var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'),
      		i=0;while(_size>900){_size/=1024;i++;}
          var exactSize = (Math.round(_size*100)/100)+' '+fSExt[i];
      	$('#projectImg_size'+id).html(exactSize)
    }
    var filename = $('#filen'+id).val().split('\\').pop();
    $('#projectimg_name'+id).html(filename);
    
	}

	function deleteExperience(id){
   	$.ajax({
	    url:"{{ url('delete-experience') }}/"+id,
	    type: 'DELETE',
      data: {
      		"_token": CSRF_TOKEN,
          "id": id
      },
      success: function (){
        $('#expernc'+id).remove();
      }
   	})
	}
	function editExperience(id){
		var title = $('#job_title'+id).val();
		var start = $('#start_date'+id).val();
		var end = $('#end_date'+id).val();
   	$.ajax({
	    url:"{{ url('edit-experience') }}",
	    method: 'POST',
      data: {
    		"_token": CSRF_TOKEN,
        "id": id,
        "company_title": $('#company_title'+id).val(),
        "start_date": $('#start_date'+id).val(),
        "end_date": $('#end_date'+id).val(),
        "job_title": $('#job_title'+id).val(),
        "job_description": $('#job_description'+id).val(),
      },
      success: function (){
        $('#title'+id).html($('#job_title'+id).val());
        $('#start'+id).html('<span class="text-muted" id="start'+id+'"><em>('+start+'</em></span>');
        $('#end'+id).html('<span class="text-muted" id="end'+id+'"><em>'+end+')</em></span>');
      }
   	})
	}

	function editEducation(id){
		var degree = $('#degree_edu'+id).val();
		// alert(degree);
		var start = $('#start_date_edu'+id).val();
		var end = $('#end_date_edu'+id).val();
   	$.ajax({
	    url:"{{ url('edit-education') }}",
	    method: 'POST',
      data: {
    		"_token": CSRF_TOKEN,
        "id": id,
        "institute": $('#institute'+id).val(),
        "start_date": $('#start_date_edu'+id).val(),
        "end_date": $('#end_date_edu'+id).val(),
        "degree": $('#degree_edu'+id).val(),
        "area_of_study": $('#area_of_study'+id).val()
      },
      success: function (){
        $('#degree'+id).html($('#degree_edu'+id).val());
        $('#start_edu'+id).html('<span class="text-muted" id="start'+id+'"><em>('+start+'</em></span>');
        $('#end_edu'+id).html('<span class="text-muted" id="end'+id+'"><em>'+end+')</em></span>');
      }
   	})
	}
	function deleteEducation(id){
   	$.ajax({
	    url:"{{ url('delete-education') }}/"+id,
	    type: 'DELETE',
      data: {
      		"_token": CSRF_TOKEN,
          "id": id
      },
      success: function (){
        $('#educatn'+id).remove();
      }
   	})
	}

	function editProject(id){
		var project_url = $('#project_url'+id).val();
		var img = $('#filen'+id)[0].files;
	
		var project_title = $('#project_title'+id).val();
		var postData = new FormData();
		postData.append('_token',CSRF_TOKEN);
		postData.append('id',id);
		postData.append('project_title',$('#project_title'+id).val());
		postData.append('project_url',$('#project_url'+id).val());
		postData.append('project_img',img);
		postData.append('project_desc',$('#project_desc'+id).val());
   	$.ajax({
	    url:"{{ url('edit-project') }}",
	    async:true,
	    type: 'POST',
	    contentType:false,
      data: postData,
      processData:false,
      success: function (){
        $('#projectName'+id).html(project_title);
        $('#projectUrl'+id).html(project_url);
        // $('#end_edu'+id).html('<span class="text-muted" id="end'+id+'"><em>'+end+')</em></span>');
      }
   	})
	}
	function deleteProject(id){
   	$.ajax({
	    url:"{{ url('delete-project') }}/"+id,
	    type: 'DELETE',
      data: {
      		"_token": CSRF_TOKEN,
          "id": id
      },
      success: function (){
        $('#projecList'+id).remove();
      }
   	})
	}


	function editCertificate(id){
		var issue_date = $('#issue_date'+id).val();
		
		var certificate_title = $('#certificate_title'+id).val();
		
   	$.ajax({
	    url:"{{ url('edit-certificate') }}",
      method: 'POST',
      data: {
    		"_token": CSRF_TOKEN,
        "id": id,
        "certificate_title": $('#certificate_title'+id).val(),
        "issue_date": $('#issue_date'+id).val(),
        "expire_date": $('#expire_date'+id).val(),
        "certificate_desc": $('#certificate_desc'+id).val(),
      },
      success: function (){
        $('#certificateName'+id).html(certificate_title);
        $('#certificateDate'+id).html(issue_date);
        // $('#end_edu'+id).html('<span class="text-muted" id="end'+id+'"><em>'+end+')</em></span>');
      }
   	})
	}
	function deleteCertificate(id){
   	$.ajax({
	    url:"{{ url('delete-certificate') }}/"+id,
	    type: 'DELETE',
      data: {
      		"_token": CSRF_TOKEN,
          "id": id
      },
      success: function (){
        $('#certifcateList'+id).remove();
      }
   	})
	}

	var config = {
		'.chosen-select'           : {},
		'.chosen-select-deselect'  : {allow_single_deselect:true},
		'.chosen-select-no-single' : {disable_search_threshold:10},
		'.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
		'.chosen-select-width'     : {width:"95%"}
		}
		for (var selector in config) {
			jQuery(selector).chosen(config[selector]);
	}

	function dragNdrop(event) {
	    var fileName = URL.createObjectURL(event.target.files[0]);
	    var preview = document.getElementById("preview");
	    var previewImg = document.createElement("img");
	    previewImg.setAttribute("src", fileName);
	    preview.innerHTML = "";
	    preview.appendChild(previewImg);

	    var filename = $('#uploadFile').val().split('\\').pop();
	    $('#img_name').html(filename);
	}
	function drag() {
	    document.getElementById('uploadFile').parentNode.className = 'draging dragBox';
	}
	function drop() {
	    document.getElementById('uploadFile').parentNode.className = 'dragBox';
	}

	// CoverImage
	function dragNdropCover(event) {
	    var fileName = URL.createObjectURL(event.target.files[0]);
	    var preview = document.getElementById("coverPreview");
	    var previewImg = document.createElement("img");
	    previewImg.setAttribute("src", fileName);
	    preview.innerHTML = "";
	    preview.appendChild(previewImg);

	    var filename = $('#fileCover').val().split('\\').pop();
	    $('#covrimg_name').html(filename);
	}
	function dragCover() {
	    document.getElementById('fileCover').parentNode.className = 'draging dragBox';
	}
	function dropCover() {
	    document.getElementById('fileCover').parentNode.className = 'dragBox';
	}

	$.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
	    });

	$image_crop = $('#image_demo').croppie({
	    enableExif: true,
	    viewport: {
	      width:200,
	      height:200,
	      type:'circle' //circle
	    },
	    boundary:{
	      width:100,
	      height:250
	    }    
	    });
	  function crop(data){
	    var reader = new FileReader();
	    reader.onload = function (event) {
	      $image_crop.croppie('bind',{
	      url: event.target.result
	      }).then(function(){
	      console.log('jQuery bind complete');
	      });
	    }
	    reader.readAsDataURL(data.files[0]);
	    $('#insertimageModal').modal('show');
	    $('input[type=hidden][name=img_type]').val($(data).attr('name'));
	  }
	  $(document).on('change','#uploadFile', function(){
	  	var size = $(this)[0].files[0].size; 
	  	var ext = $(this).val().split('.').pop().toLowerCase();
	  	if($.inArray(ext,['jpeg','jpg','gif','png']) == -1){
	  		alert('Your File Extension Is Not Allowed.');
	  		$(this).val('');
	  	}else{
	  		crop(this);
	  	}
	  });
	  $('.crop_image').click(function(event){
	  
	  // $('#wait').addClass("loader");
	  var name = $('input[type=hidden][name=img_type]').val();
	    $image_crop.croppie('result', {
	      type: 'canvas',
	      size: 'viewport'
	    }).then(function(response){
	      $.ajax({
	        url:"{{url('crop_upload')}}",
	        type: "POST",
	        data:{image: response, fileProfile: $('input[type=file][name='+ name +']').val().replace(/C:\\fakepath\\/i, '') },
	        success:function(data){
	          // $('#wait').removeClass("loader");
	          $('#insertimageModal').modal('hide');
	          $('input[type=hidden][name='+ name +']').val(data);
	          main = $('input[type=hidden][name='+ name +']').parent();
	          // main.prepend("<img src='user_images/"+data+"' class='img-fluid'>");
	          // $('.img-circle').hide();
	          $('.wt-userimg img').attr("src", "assets/images/user/profile/"+data.name+"");
	          $('.mCS_img_loaded').attr("src", "assets/images/user/profile/"+data.name+"");
	        }
	      });
	    });
	  });
	  // Cover Inage
	$image_crop_cover = $('#cover_demo').croppie({
	    enableExif: true,
	    viewport: {
	      width:300,
	      height:150,
	      type:'square' //circle
	    },
	    boundary:{
	      width:100,
	      height:250
	    }    
	    });
	  function crop_cover(data){
	    var reader = new FileReader();
	    reader.onload = function (event) {
	      $image_crop_cover.croppie('bind',{
	      url: event.target.result
	      }).then(function(){
	      console.log('jQuery bind complete');
	      });
	    }
	    reader.readAsDataURL(data.files[0]);
	    $('#insertCoverModal').modal('show');
	    $('input[type=hidden][name=img_type]').val($(data).attr('name'));
	  }
	  $(document).on('change','#fileCover', function(){
	  	var size = $(this)[0].files[0].size; 
	  	var ext = $(this).val().split('.').pop().toLowerCase();
	  	if($.inArray(ext,['jpeg','jpg','gif','png']) == -1){
	  		alert('Your File Extension Is Not Allowed.');
	  		$(this).val('');
	  	}else{
	  		crop_cover(this);
	  	}
	  });
	  $('.crop_image_cover').click(function(event){
	  
	  // $('#wait').addClass("loader");
	  var name = $('input[type=hidden][name=img_type]').val();
	    $image_crop_cover.croppie('result', {
	      type: 'canvas',
	      size: 'viewport'
	    }).then(function(response){
	      $.ajax({
	        url:"{{url('crop_upload_cover')}}",
	        type: "POST",
	        data:{image: response, fileCover: $('input[type=file][name='+ name +']').val().replace(/C:\\fakepath\\/i, '') },
	        success:function(data){
	          // $('#wait').removeClass("loader");
	          $('#insertCoverModal').modal('hide');
	          $('input[type=hidden][name='+ name +']').val(data);
	          main = $('input[type=hidden][name='+ name +']').parent();
	          // main.prepend("<img src='user_images/"+data+"' class='img-fluid'>");
	          // $('.img-circle').hide();
	          $('.wt-companysimg img').attr("src", "assets/images/user/cover/"+data.name+"");
	        }
	      });
	    });
	  });
	  $('input[name="present_job"]').change(function(){
		  if ($(this).is(":checked")) {
		  	$('input[name="end_date"]').attr('readonly', 'true');
		  	$('input[name="end_date"]').addClass('bg-light');
	    }else{
	    	$('input[name="end_date"]').removeAttr('readonly');
	    	$('input[name="end_date"]').removeClass('bg-light');
	    }	
	  })

	  $('input[name="continue_study"]').change(function(){
		  if ($(this).is(":checked")) {
		  	$('#edu_end_date').attr('readonly', 'true');
		  	$('#edu_end_date').addClass('bg-light');
		  	$('#edit_end_date').attr('readonly', 'true');
		  	$('#edit_end_date').addClass('bg-light');
	    }else{
	    	$('#edu_end_date').removeAttr('readonly');
	    	$('#edu_end_date').removeClass('bg-light');
	    	$('#edit_end_date').removeAttr('readonly');
	    	$('#edit_end_date').removeClass('bg-light');
	    }	
	  })
	  
	  // var url = window.location.href;
	  // var activeTab = url.substring(url.indexOf("#") + 1);
	  // alert(activeTab);
	  // $(".tab-pane").removeClass("active in");
	  // $("#" + activeTab).addClass("active in");
	  // $('a[href="#'+ activeTab +'"]').tab('show')
</script>
@endsection