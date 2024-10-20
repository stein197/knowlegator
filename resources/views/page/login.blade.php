@extends('template.index')

@section('main')
	<section class="flex-grow-1 d-flex align-items-center">
		<div class="container">
			<div class="row">
				<div class="col col-12 col-sm-8 col-md-6 offset-sm-2 offset-md-3">
					<form class="card shadow" action="{{ route('login', [], false) }}" method="POST" enctype="multipart/form-data">
						@csrf
						<div class="card-body">
							<p>
								<strong>{{ __('form.login.title') }}</strong>
							</p>
							<div class="mb-3">
								<p class="form-label">{{ __('form.login.field.email') }}</p>
								<input class="form-control" type="email" name="email" required="" />
								@error('email')
									<p class="text-danger">{{ $message }}</p>
								@enderror
							</div>
							<div class="mb-3">
								<p class="form-label">{{ __('form.login.field.password') }}</p>
								<input class="form-control" type="password" name="password" required="" />
								@error('password')
									<p class="text-danger">{{ $message }}</p>
								@enderror
							</div>
							<label class="form-label">
								<input class="from-check-input" type="checkbox" name="remember" />
								<span>{{ __('form.login.field.remember') }}</span>
							</label>
							<div class="row">
								<div class="col col-12 col-sm-6 mb-3 mb-sm-0">
									<button class="btn btn-primary w-100" name="action" value="login">{{ __('form.login.button.login') }}</button>
								</div>
								<div class="col col-12 col-sm-6">
									<button class="btn btn-success w-100" name="action" value="register">{{ __('form.login.button.register') }}</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
@endsection
