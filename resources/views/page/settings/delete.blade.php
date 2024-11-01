@extends('template.menu')

@section('content')
	<p>{{ __('page.settings.delete.confirmation') }}</p>
	<div class="row mb-3">
		<div class="col col-6 col-sm-auto">
			<a class="btn btn-dark w-100" href="{{ lroute('settings') }}">{{ __('back') }}</a>
		</div>
		<div class="col col-6 col-sm-auto">
			<form action="{{ lroute('settings.delete') }}" method="POST" enctype="multipart/form-data">
				@csrf
				@method('DELETE')
				<button class="btn btn-danger w-100">{{ __('yes') }}</button>
			</form>
		</div>
	</div>
	<p class="alert alert-danger text-danger">
		<i class="bi bi-exclamation-triangle-fill"></i>
		<span>{{ __('page.settings.delete.consequences') }}</span>
	</p>
@endsection
