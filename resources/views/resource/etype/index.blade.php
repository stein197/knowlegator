@php
	$routing = app(App\Services\ModelRoutingService::class);
@endphp

@extends('template.resource.index')

@section('data')
	@foreach ($data as $etype)
		<div @class(['card', 'mb-3' => !$loop->last])>
			<div class="card-header d-flex">
				<a class="flex-grow-1" href="{{ lroute('etypes.show', ['etype' => $etype->id]) }}">{{ $etype->name }}</a>
				<x-button class="reset text-decoration-none mx-2" icon="eye-fill" label="{{ __('action.show') }}" href="{{ $routing->route($etype, 'show') }}" />
				<x-button class="reset text-decoration-none mx-2" icon="pen-fill" label="{{ __('action.edit') }}" href="{{ $routing->route($etype, 'edit') }}" />
				<x-button class="reset text-decoration-none mx-2" icon="trash-fill" label="{{ __('action.delete') }}" href="{{ $routing->route($etype, 'delete') }}" />
			</div>
			@if ($etype->description)
				<div class="card-body">
					<p class="card-text">{{ $etype->description }}</p>
				</div>
			@endif
		</div>
	@endforeach
@endsection
