@extends('template.content')

@section('content')
	<div class="row">
		<div class="col col-auto">
			<a class="btn btn-dark" href="{{ route('settings.password', ['locale' => app()->getLocale()], false) }}">{{ __('page.settings.changePassword') }}</a>
		</div>
		<div class="col col-auto">
			<a class="btn btn-danger" href="{{ route('settings.delete', ['locale' => app()->getLocale()], false) }}">{{ __('page.settings.deleteAccount') }}</a>
		</div>
	</div>
@endsection
