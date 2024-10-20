@extends('template.content')

@section('content')
	<div>
		<a class="btn btn-danger" href="{{ route('settings.delete', [], false) }}">{{ __('page.settings.deleteAccount') }}</a>
	</div>
@endsection
