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
			<section class="wt-haslayout wt-dbsectionspace">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
							<div class="wt-dashboardbox wt-dashboardtabsholder wt-accountsettingholder">
								<div class="wt-dashboardtabs">
									<ul class="wt-tabstitle nav navbar-nav" id="pills-tab" role="tablist">
										<li class="nav-item">
											<a class="active" id="wt-password-tab" data-bs-toggle="pill" data-bs-target="#wt-password" type="button" role="tab" aria-controls="wt-password" aria-selected="true">Password</a>
										</li>
										<li class="nav-item">
											<a class="" id="wt-emailnoti-tab" data-bs-toggle="pill" data-bs-target="#wt-emailnoti" type="button" role="tab" aria-controls="wt-emailnoti" aria-selected="true">Email Notifications</a>
										</li>
										<li class="nav-item">
											<a class="" id="wt-verify-tab" data-bs-toggle="pill" data-bs-target="#wt-verify" type="button" role="tab" aria-controls="wt-verify" aria-selected="true">Account Verification</a>
										</li>
										<li class="nav-item">
											<a class="" id="wt-deleteaccount-tab" data-bs-toggle="pill" data-bs-target="#wt-deleteaccount" type="button" role="tab" aria-controls="wt-deleteaccount" aria-selected="true">Delete Account</a>
										</li>
									</ul>
								</div>
								<div class="wt-tabscontent tab-content" id="nav-tabContent">
									<div class="wt-passwordholder tab-pane fade active show" id="wt-password" role="tabpanel" aria-labelledby="wt-password-tab">
										<div class="wt-changepassword">
											<div class="wt-tabscontenttitle">
												<h2>Change Your Password</h2>
											</div>
											@if(Session::has('verify'))
											<div class="alert alert-success">
											  {{ Session::get('verify') }}
											  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
											    <span aria-hidden="true">&times;</span>
											  </button>
											</div>
											@endif
											@if(Session::has('resetAlert'))
											<div class="alert alert-danger">
											  {{ Session::get('resetAlert') }}
											  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
											    <span aria-hidden="true">&times;</span>
											  </button>
											</div>
											@endif
											
											@if(Session::has('resetSuccess'))
											<div class="alert alert-success">
											  {{ Session::get('resetSuccess') }}
											  <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="margin-right: 30px;margin-top: 59px;color: black;">
											    <span aria-hidden="true">&times;</span>
											  </button>
											</div>
											@endif
											<form class="wt-formtheme wt-userform" action="{{ url('/reset-password') }}" method="post">
												@csrf
												@if ($errors->any())
												<div class="alert alert-danger">
												  <ul>
												    @foreach ($errors->all() as $error)
												    <li>{{ $error }}</li>
												    @endforeach
												  </ul>
												</div>
												@endif
												<input type="hidden" value="{{ Auth::user()->id }}" name="user_id">
												<fieldset>
													<div class="form-group form-group-half">
														<input type="password" id="current-password" name="password" class="form-control" placeholder="New Password">
														@if ($errors->has('current-password'))
														<span class="help-block">
														  <strong>{{ $errors->first('current-password') }}</strong>
														</span>
														@endif
													</div>
													<div class="form-group form-group-half">
														<input type="password" id="confirm_pass" name="confirm_password" class="form-control" placeholder="Confirm Password">
														@if ($errors->has('new-password'))
														<span class="help-block">
														  <strong>{{ $errors->first('new-password') }}</strong>
														</span>
														@endif
														<span id="match" class="pl-3"></span>
													</div>
													<!-- <div class="form-group">
														<span class="wt-checkbox">
															<input id="termsconditions" type="checkbox" name="termsconditions" value="termsconditions" checked="">
															<label for="termsconditions"><span>Logout from all other web/mobile session now.</span></label>
														</span>
													</div> -->
													<div class="form-group mt-4 text-end">
														<button class="wt-btn" type="submit">Update Password</button>
													</div>
												</fieldset>
											</form>
										</div>
									</div>
									<div class="wt-emailnotiholder tab-pane fade" id="wt-emailnoti" role="tabpanel" aria-labelledby="wt-emailnoti-tab">
										<div class="wt-emailnoti">
											<div class="wt-tabscontenttitle">
												<h2>Manage Email Notifications</h2>
											</div>
											<div class="wt-settingscontent">
												<div class="wt-description">
													<p>Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua aut enim ad minim veniamac quis nostrud exercitation ullamco laboris.</p>
												</div>
												<form class="wt-formtheme wt-userform">
													<fieldset>
														<div class="form-group form-disabeld">
															<input type="password" name="password" class="form-control" placeholder="youremail@domainurl.com" disabled="">
														</div>
													</fieldset>
												</form>
												<ul class="wt-accountinfo">
													<li>
														<div class="wt-on-off">
															<input type="checkbox" id="hide-onemail" name="contact_form">
															<label for="hide-onemail"><i></i></label>
														</div>
														<span>Send me Email notification</span>
													</li>
												</ul>
											</div>
										</div>
									</div>
									<!-- Account Verification -->
									<div class="wt-verifyholder tab-pane fade" id="wt-verify" role="tabpanel" aria-labelledby="wt-verify-tab">
										<div class="wt-verify">
											<div class="wt-tabscontenttitle">
												<h2>Verify Your Account</h2>
											</div>
											<div class="wt-settingscontent">
												<div class="alert alert-success d-none" id="verification_message">Your verification request submitted. Admin will review your request within 24 hours.</div>
												<form class="wt-formtheme wt-userform" id="verificationForm" enctype="multipart/form-data">
													@csrf
													<fieldset>
														<div class="form-group form-group-label">
															<label class="pb-2">Upload ID/Passport:</label>
															<div class="wt-labelgroup">
																<label for="uploadFile"  class="dragBox w-100">
																	<input type="file" name="verification_image" id="uploadFile"onChange="dragNdrop(event)" ondragover="drag()" ondrop="drop()" id="uploadFile" class="d-block">
																	Drag or upload your ID/Passport 
																</label>
															</div>
														</div>
								  					<div class="form-group mb-3">
								  						<ul class="wt-attachfile wt-attachfilevtwo">
								  							<li class="wt-uploadingholder w-100">
								  								<div class="wt-uploadingbox">
								  									<div class="wt-designimg">
								  										<label for="demoz"  id="preview">
								  											@if(Auth::user()->verification_image)
											                    <img src="{{asset('assets/images/user/verification/'.Auth::user()->verification_image)}}" alt="">
								  											@else
								  											<img src="{{asset('assets/images/user/verification/id_sample.jpg')}}" alt="img description" id="profile">
								  											@endif
								  										</label>
								  									</div>
								  									<div class="wt-uploadingbar">
								  										<span id="img_name" class="text-break text-wrap">{{Auth::user()->verification_image}}</span>
								  									</div>
								  								</div>
								  							</li>
								  						</ul>
								  					</div>
													</fieldset>
													<div class="form-group mb-3 text-end">
														<button class="wt-btn" type="submit">Submit Request</button>
													</div>
												</form>
											</div>
										</div>
									</div>
									<div class="wt-accountholder tab-pane fade" id="wt-deleteaccount" role="tabpanel" aria-labelledby="wt-deleteaccount-tab">
										<div class="wt-accountdel">
											<div class="wt-tabscontenttitle">
												<h2>Delete Account</h2>
											</div>
											<form class="wt-formtheme wt-userform">
												<fieldset>
													<div class="form-group form-group-half">
														<input type="password" name="password" class="form-control" placeholder="Enter Password">
													</div>
													<div class="form-group form-group-half">
														<input type="password" name="password" class="form-control" placeholder="Enter Password">
													</div>
													<div class="form-group">
														<span class="wt-select">
															<select>
																<option value="" disabled="">Select Reason to Leave</option>
																<option value="">Reason</option>
																<option value="">Reason</option>
															</select>
														</span>
													</div>
													<div class="form-group">
														<textarea name="message" class="form-control" placeholder="Description (Optional)"></textarea>
													</div>
													<!-- <div class="form-group form-group-half float-right">
														<span class="wt-checkbox">
															<input id="termsconditions1" type="checkbox" name="termsconditions" value="termsconditions">
															<label for="termsconditions1"><span>Unsubscribe me from all newsletter list</span></label>
														</span>
													</div> -->
													<div class="form-group form-group mt-4 text-end wt-btnarea">
														<a href="javascript:void(0);" class="wt-btn">Delete Account</a>
													</div>
												</fieldset>
											</form>
										</div>
									</div>
								</div>
							</div>
							<!-- <div class="wt-updatall">
								<i class="ti-announcement"></i>
								<span>Update all the latest changes made by you, by just clicking on “Save &amp; Continue” button.</span>
								<a class="wt-btn" href="javascript:void(0);">Save &amp; Continue</a>
							</div> -->
						</div>
						<div class="col-xs-12 col-sm-12 col-md-4 col-lg-3"></div>
					</div>
				</section>
			<!--Register Form End-->
		</main>
		<!--Main End-->
	</div>
</div>
@endsection
@section('script')
<script>
  $('#confirm_pass').on('keyup', function () {
    if ($('#current-password').val() == $('#confirm_pass').val()) {
      $('#match').html('Password Match').css('color', 'green');
    } else 
      $('#match').html('Password Not Matching').css('color', 'red');
  });

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

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });


  $('#verificationForm').submit(function(event){
		event.preventDefault();
  	$.ajax({
      url: "{{url('verification-request')}}",
      type: 'POST',
      data: new FormData(this),
      dataType:'JSON',
      contentType: false,
      cache: false,
      processData: false,

      success: (response)=>{
          if (response.status == 'true') {
              $.notify(response.message , 'success'  );
                // window.location.href = window.location.protocol + '//' + window.location.hostname +":"+window.location.port+"/account-setting/";
              $('#wt-password-tab').removeClass('active');
              $('#wt-password').removeClass('active show');
              $('#wt-verify-tab').addClass('active');
              $('#wt-verify').addClass('active show');
              $('#verification_message').removeClass('d-none');
              
              
          }else{
              $.notify(response.message , 'error');

          }
      },
      error: (errorResponse)=>{
          $.notify( errorResponse, 'error'  );


      }
  	})
  })
</script>
@endsection