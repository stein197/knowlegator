@extends('template.menu')

@section('content')
	<x-form
		action="{{ lroute('settings.theme') }}"
		method="put"
		>
		<div class="btn-group w-100">
			@foreach ($themes as $tName => $theme)
				<button name="theme" value="{{ $tName }}" class="btn btn-light {{ $theme['active'] ? 'active' : '' }}">{{ $theme['title'] }}</button>
			@endforeach
		</div>
	</x-form>
	<x-alert type="warning" message="page.settings.theme.warning" />
@endsection
