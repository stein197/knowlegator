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
	@else
		@yield('data')
	@endif
	@foreach ($action as $btn)
		@if ($btn->icon)
			<a class="btn btn-{{ $btn->type }}" href="{{ $btn->url }}" data-bs-toggle="tooltip" data-bs-title="{{ $btn->label }}">
				<i class="bi bi-{{ $btn->icon }}"></i>
			</a>
		@else
			<a class="btn btn-{{ $btn->type }}" href="{{ $btn->url }}">{{ $btn->label }}</a>
		@endif
	@endforeach
@endsection
