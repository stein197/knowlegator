@extends('template.menu')

@section('content')
	@if (!$data->isEmpty() || $search['value'] !== null)
		<x-search-bar action="{{ $search['action'] }}" placeholder="{{ $search['placeholder'] }}" value="{{ $search['value'] }}" />
	@endif
	@if ($alert)
		<x-alert class="mb-3" type="{{ $alert['type'] }}" :dismissible="$alert['dismissible']">{{ $alert['message'] }}</x-alert>
	@endif
	@if ($data->isEmpty())
		<x-alert class="text-center mb-3" type="info">{{ $search['value'] === null ? __('resource.index.message.empty') : __('resource.index.message.emptySearchResult') }}</x-alert>
	@else
		@yield('data')
	@endif
	<div class="mt-3">
		@foreach ($action as $btn)
			{{ $btn->render() }}
		@endforeach
	</div>
@endsection
