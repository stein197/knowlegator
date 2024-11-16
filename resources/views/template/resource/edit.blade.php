@extends('template.menu')

@section('content')
	@isset ($message)
		<x-alert type="{{ $message['type'] }}">{!! $message['text'] !!}</x-alert>
	@endisset
	<x-form
		method="PUT"
		action="{{ $action }}"
		:fields="$fields"
		:buttons="$actions" />
@endsection
