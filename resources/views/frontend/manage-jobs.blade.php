@extends('frontend.layouts.app')
@section('dashboardstyle')
<link rel="stylesheet" media="screen" href="{{ asset('assets/css/dashboard.css') }}">
<link rel="stylesheet" media="screen" href="{{ asset('assets/css/dbresponsive.css') }}">
<script src="{{asset('assets/js/modernizr-2.8.3-respond-1.4.2.min.js')}}"></script>
<style>
	.home-header{
		z-index: 29;
		background: #fff;
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
			<section class="wt-haslayout wt-dbsectionspace">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-9">
						<div class="wt-dashboardbox">
							<div class="wt-dashboardboxtitle">
								<h2>Manage Jobs</h2>
							</div>
							<div class="wt-dashboardboxcontent wt-jobdetailsholder">
								<div class="wt-freelancerholder">
									<div class="wt-tabscontenttitle">
										<h2>Posted Jobs</h2>
									</div>
									<div class="wt-managejobcontent wt-verticalscrollbar">
										@foreach($myJobs as $job)
										<div class="wt-userlistinghold wt-featured wt-userlistingvtwo">
											<!-- <span class="wt-featuredtag"><img src="{{asset('assets/images/joblisting/featured.png')}}" alt="img description" data-tipso="Plus Member" class="template-content tipso_style"></span> -->
											<div class="wt-userlistingcontent">
												<div class="wt-contenthead">
													<div class="wt-title">
														<a href="usersingle.html"><i class="fa fa-check-circle"></i> {{$job->clientInfo->first_name}} {{$job->clientInfo->last_name}}
														</a>
														<h2>{{$job->job_title}}</h2>
													</div>
													<ul class="wt-saveitem-breadcrumb wt-userlisting-breadcrumb">
														<li><span class="wt-dashboraddoller"><i class="fa fa-dollar-sign"></i> {{$job->service_level}}</span></li>
														<li><span><i class="fal fa-map-marker-alt text-danger"></i> {{$job->job_location}}</span></li>
														<li><a href="javascript:void(0);" class="wt-clicksavefolder text-capitalize"><i class="far fa-folder"></i> Type: {{$job->job_type}}</a></li>
														<li><span class="wt-dashboradclock"><i class="far fa-clock"></i> Duration: {{$job->job_duration}}</span></li>															
													</ul>
												</div>
												<div class="wt-rightarea">
													<div class="wt-btnarea">
														<a href="{{ route('job.show',$job->job_id)}}" class="wt-btn">VIEW DETAILS</a>
													</div>
													<div class="wt-hireduserstatus">
														<h4>{{App\Models\Proposal::getProposalCount($job->job_id)}}</h4><span>Proposals</span>
														<ul class="wt-hireduserimgs">
															@foreach($job->proposal as $proposalUser)
															<li><figure><img src="{{asset('assets/images/user/profile/'.App\Models\Proposal::freelancer($proposalUser->user_id)->profile_image)}}" alt="img description" class="mCS_img_loaded"></figure></li>
															@endforeach
															<!-- <li><figure><img src="{{asset('assets/images/user/userlisting/img-05.jpg')}}" alt="img description"></figure></li> -->
														</ul>
													</div>
												</div>
											</div>	
										</div>
										@endforeach
									</div>
								</div>
							</div>
							{{ $myJobs->links('frontend.pagination.manage-jobs') }}								
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-3">
						<aside id="wt-sidebar" class="wt-sidebar wt-dashboardsave">
							<div class="wt-proposalsr">
								<div class="wt-proposalsrcontent">
									<figure>
										<img src="{{asset('assets/images/thumbnail/img-17.png')}}" alt="image">
									</figure>
									<div class="wt-title">
										<h3>{{App\Models\Job::clientOngoingCount(Auth::user()->id)}}</h3>
										<span>Total Ongoing Jobs</span>
									</div>
								</div> 
							</div>
							<div class="wt-proposalsr">
								<div class="wt-proposalsrcontent wt-componyfolow">
									<figure>
										<img src="{{asset('assets/images/thumbnail/img-16.png')}}" alt="image">
									</figure>
									<div class="wt-title">
										<h3>{{App\Models\Job::clientCompletedCount(Auth::user()->id)}}</h3>
										<span>Total Completed Jobs</span>
									</div>
								</div> 
							</div>								
							<div class="wt-proposalsr">
								<div class="wt-proposalsrcontent  wt-freelancelike">
									<figure>
										<img src="{{asset('assets/images/thumbnail/img-15.png')}}" alt="image">
									</figure>
									<div class="wt-title">
										<h3>{{App\Models\Job::clientCancelledCount(Auth::user()->id)}}</h3>
										<span>Total Cancelled Jobs</span>
									</div>
								</div> 
							</div>								
						</aside>
					</div>
				</div>
			</section>
			<!--Register Form End-->
		</main>
		<!--Main End-->
	</div>
</div>
@endsection
@section('script')
@endsection