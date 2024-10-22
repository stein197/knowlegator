@extends('template.content')

@section('content')
	<div class="row">
		<div class="col col-auto">
			<a class="btn btn-dark" href="{{ lroute('settings.password') }}">{{ __('page.settings.changePassword') }}</a>
		</div>
		<div class="col col-auto">
			<a class="btn btn-danger" href="{{ lroute('settings.delete') }}">{{ __('page.settings.deleteAccount') }}</a>
		</div>
	</div>
@endsection
