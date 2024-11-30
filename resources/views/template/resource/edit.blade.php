@extends('template.menu')

@section('content')
	@if ($alert)
		<x-alert type="{{ $alert['type'] }}">{!! $alert['text'] !!}</x-alert>
	@endif
	{{ $form->view() }}
@endsection
