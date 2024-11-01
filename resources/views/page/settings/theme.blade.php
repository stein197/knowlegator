@extends('template.menu')

@section('content')
	<x-form
		action="{{ lroute('settings.theme') }}"
		method="POST"
		>
		<div class="btn-group w-100">
			@foreach ($themes as $tName => $theme)
				<button name="theme" value="{{ $tName }}" class="btn btn-light {{ $theme['active'] ? 'active' : '' }}">{{ $theme['title'] }}</button>
			@endforeach
		</div>
	</x-form>
	<p class="my-3 alert alert-warning">
		<i class="bi bi-exclamation-triangle-fill"></i>
		<span>{{ __('page.settings.theme.warning') }}</span>
	</p>
@endsection
