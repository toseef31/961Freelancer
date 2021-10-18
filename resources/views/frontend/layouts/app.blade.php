<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- SEO meta tags -->
	<meta name="author" content="Zeeshan ">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>961 Freelancer</title>
	<!-- ==============Google Fonts============= -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
	<link rel="stylesheet" media="screen" href="{{ asset('assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" media="screen" href="{{ asset('assets/css/fontawesome.min.css') }}">
	<link rel="stylesheet" media="screen" href="{{ asset('assets/css/chosen.css') }}">
	@yield('style')
	<link rel="stylesheet" media="screen" href="{{ asset('assets/css/main.css') }}">
	<link rel="stylesheet" media="screen" href="{{ asset('assets/css/slick.css') }}">
	<link rel="stylesheet" media="screen" href="{{ asset('assets/css/color.css') }}">
	<link rel="stylesheet" media="screen" href="{{ asset('assets/css/style.css') }}">
	<link rel="stylesheet" media="screen" href="{{ asset('assets/css/responsive.css') }}">
	<link rel="stylesheet" media="screen" href="{{ asset('assets/css/transitions.css') }}">
	<link rel="stylesheet" media="screen" href="{{ asset('assets/css/scrollbar.css') }}">
	@yield('dashboardstyle')
</head>
<body>
	{{ View::make('frontend.includes.navbar') }}
	@yield('content')
	{{ View::make('frontend.includes.footer') }}
	<audio id="messagetone" muted>
    <source src="{{ asset('bell.mp3')}}" type="audio/ogg">
    <source src="{{ asset('bell.mp3')}}" type="audio/mpeg">
  </audio>
	<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
	<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
	<!-- <script src="{{ asset('assets/js/all.min.js') }}"></script> -->
	<script src="{{ asset('assets/js/slick.js') }}"></script>
	<script src="{{ asset('assets/js/scrollbar.min.js') }}"></script>
	<script src="{{ asset('assets/js/chosen.jquery.js') }}"></script>
	<script src="{{ asset('assets/js/tilt.jquery.js') }}"></script>
	<script src="{{ asset('assets/js/readmore.js') }}"></script>
	<script src="{{ URL::asset('assets/js/notify.js') }}"></script>
	@yield('script')
	<script src="{{ asset('assets/js/custom.js') }}"></script>
	<script>
		@if (Session::has('success'))
		   $.notify("{{ session('error') }}" , 'success'  );
		@endif

		@if (Session::has('error'))
		    $.notify("{{ session('error') }}" , 'error'  );
		@endif
	</script>
	<script src="https://peekvideochat.com:22000/socket.io/socket.io.js"></script>
	@if(auth()->user())
	<script type="text/javascript">
	    const socket = io.connect('https://peekvideochat.com:22000');
	    var user_id = "{{auth()->user()->id}}";
	    // alert(user_id);
	    socket.on('birdsreceivemsg', function(data) {
	      // console.log(data);
	      if( user_id == data.message_receiver){
	        var messagetone = document.getElementById("messagetone");
	        messagetone.play();
	        messagetone.muted = false;
	         $.ajax({
	              url: "{{url('/messsageCount')}}/"+user_id,
	              type: "GET"
	            }).then(function(res) {
	              $('.messageCount').html(res);
	            })

	      }

	    });
	</script>
	@endif
</body>
</html>