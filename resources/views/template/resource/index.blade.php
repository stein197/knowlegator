@extends('template.menu')

@section('content')
	@if (!$data->isEmpty() || $search['value'] !== null)
		<x-search-bar action="{{ $search['action'] }}" placeholder="{{ $search['placeholder'] }}" value="{{ $search['value'] }}" />
	@endif
	@if ($data->isEmpty())
		<x-alert class="text-center" type="info">{{ $alert }}</x-alert>
	@else
		@yield('data')
	@endif
	@foreach ($action as $btn)
		<a class="mt-3 btn btn-{{ $btn->type }}" href="{{ $btn->url }}">{{ $btn->label }}</a>
	@endforeach
@endsection
