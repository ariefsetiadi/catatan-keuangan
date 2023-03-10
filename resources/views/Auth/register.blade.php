<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">

		<title>{{ $title . ' | ' . config('app.name') }}</title>

		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	</head>

	<body style="background-color: #F0E68C">
		<div class="container py-5">
			<div class="row justify-content-center">
				<div class="col-8">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title text-center">{{ 'Form ' . $title }}</h3>
						</div>

						<div class="card-body">
							<form action="{{ route('register') }}" method="POST">
								@csrf

								<div class="form-group">
									<input type="text" name="fullname" id="fullname" class="form-control @error('fullname') is-invalid @enderror" placeholder="Nama Lengkap" value="{{ old('fullname') }}" required>
									@error('fullname')
										<span class="text-danger">{{ $message }}</span>
									@enderror
								</div>

								<div class="form-group">
									<input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Alamat Email" value="{{ old('email') }}" required>
									@error('email')
										<span class="text-danger">{{ $message }}</span>
									@enderror
								</div>

								<div class="row">
									<div class="col-6">
										<div class="form-group">
											<div class="input-group">
												<input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
												<div class="input-group-append">
													<span class="input-group-text" onclick="showPassword()">
														<i class="fa fa-eye" id="icon"></i>
													</span>
												</div>
											</div>
											@error('password')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
									</div>

									<div class="col-6">
										<div class="form-group">
											<div class="input-group">
												<input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Konfirmasi Password" required>
												<div class="input-group-append">
													<span class="input-group-text" onclick="showPasswordConfirm()">
														<i class="fa fa-eye" id="icons"></i>
													</span>
												</div>
											</div>
											@error('password_confirmation')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
									</div>
								</div>

								<div class="row justify-content-center">
									<a href="{{ route('login') }}" class="btn btn-link">Login</a>
									<button type="submit" class="btn btn-info">REGISTRASI</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

		<script type="text/javascript">
			function showPassword() {
				var a = document.getElementById("password");
				var b = document.getElementById("icon");

				if (a.type === "password") {
					a.type = "text";
					b.classList.replace('fa-eye', 'fa-eye-slash');
				} else {
					a.type = "password";
					b.classList.replace('fa-eye-slash', 'fa-eye');
				}
			}

			function showPasswordConfirm() {
				var a = document.getElementById("password_confirmation");
				var b = document.getElementById("icons");

				if (a.type === "password") {
					a.type = "text";
					b.classList.replace('fa-eye', 'fa-eye-slash');
				} else {
					a.type = "password";
					b.classList.replace('fa-eye-slash', 'fa-eye');
				}
			}
		</script>
	</body>
</html>