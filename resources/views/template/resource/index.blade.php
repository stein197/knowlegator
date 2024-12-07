@extends('template.menu')

@section('content')
	@if (!$data->isEmpty() || $search['value'] !== null)
		<x-search-bar action="{{ $search['action'] }}" placeholder="{{ $search['placeholder'] }}" value="{{ $search['value'] }}" />
	@endif
	@if ($alert)
		<x-alert type="{{ $alert['type'] }}" :dismissible="$alert['dismissible']">{{ $alert['message'] }}</x-alert>
	@endif
	@if ($data->isEmpty())
		<x-alert class="text-center" type="info">{{ $search['value'] === null ? __('resource.index.message.empty') : __('resource.index.message.emptySearchResult') }}</x-alert>
	@endif
	@yield('data')
	@foreach ($action as $btn)
		<a class="mt-3 btn btn-{{ $btn->type }}" href="{{ $btn->url }}">{{ $btn->label }}</a>
	@endforeach
@endsection
