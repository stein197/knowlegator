@extends('template.menu')

@section('content')
	@if ($alert)
		<x-alert type="{{ $alert['type'] }}">{!! $alert['text'] !!}</x-alert>
	@endif
	<x-form
		method="PUT"
		action="{{ $action }}"
		:fields="$fields"
		:buttons="$actions" />
@endsection
