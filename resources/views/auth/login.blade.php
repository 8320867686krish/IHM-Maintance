<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    
    <!-- Bootstrap and MDB CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link href="{{ asset('assets/vendor/fonts/circular-std/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/libs/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome/css/fontawesome-all.css') }}">
    
    <style>
        .container-fluid{
            padding-left: 0px !important;
        }
        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }

        .h-custom {
            height: calc(100% - 73px);
        }

        @media (max-width: 450px) {
            .h-custom {
                height: 100%;
            }
        }
    </style>
</head>

<body>
    <!-- Login Page -->
    <div class="">
        <section >
            <div class="container-fluid">
                <div class="row d-flex">
                    <div class="col-md-9 col-lg-6 col-xl-6">
                        <img src="https://assets.cntraveller.in/photos/640af7ca1ee43c0c0b7eb57c/3:2/w_1427,h_951,c_limit/image-007.jpg" class="img-fluid" alt="Sample image" style="height:100vh">
                    </div>
                    <br/>
                    <div class="col-xl-6 mt-5">
				<div class="auth-full-page d-flex p-4 p-xl-3 offset-xl-2 mt-5">
					<div class="d-flex flex-column w-75 h-100 mt-5">
						<div class="auth-form mt-5">

							<div class="text-center mt-5">
								<h1 class="h2">Sign In</h1>
								<p class="lead">
									&nbsp;
								</p>
							</div>

							<div class="mb-3">
								<div class="d-grid gap-2 mb-3">
							
                                <form method="POST" id="loginForm">
                                    @csrf
									
									<div class="mb-3">
										<label class="form-label">Email</label>
										<input class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email">
                                        <div class="emailMsg error tex
                                        
                                        
                                        t-danger mt-1"></div>

									</div>
									<div class="mb-3">
										<label class="form-label">Password</label>
										<input class="form-control form-control-lg" type="password" name="password" placeholder="Enter password">
                                        <div class="passwordMsg error text-danger mt-1"></div>
                                        <div class="autherrorMsg error text-danger mt-3"></div>
									</div>
                                    <div class="mb-3 float-right">
                                    <a href="{{ route('password.request') }}" class="footer-link ">Forgot Password</a>
                                    </div>
									<div class="d-grid gap-2 mt-5 text-center">
                                        <button type="submit" class="btn btn-lg btn-primary">Sign In</button>
									</div>
                                  
								</form>
							</div>

						
						</div>
						
					</div>
				</div>
			</div>
                </div>
            </div>

         
        </section>
    </div>

    <!-- Optional JavaScript -->
    <script src="{{ asset('assets/vendor/jquery/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#loginForm').submit(function(e) {
                e.preventDefault();
                $('.text-danger').text("");
                var $submitButton = $(this).find('button[type="submit"]');
                var originalText = $submitButton.html();
                $submitButton.text('Wait...');
                $submitButton.prop('disabled', true);

                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('login') }}", // Change this to the URL where you handle the form submission
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Handle success response
                        window.location.href = "{{ url('dashboard') }}";
                    },
                    error: function(err) {
                        console.log(err);
                        if (err.responseJSON == 'undefined') {
                            window.location.href = "{{ url('dashboard') }}";
                        } else {
                            $.each(err.responseJSON.errors, function(i, error) {
                                $('.' + i + 'Msg').text(error);
                            });
                            $submitButton.html(originalText);
                            $submitButton.prop('disabled', false);
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>
