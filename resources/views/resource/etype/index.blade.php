@extends('template.resource.index')

@section('data')
	@foreach ($data as $etype)
		<div @class(['card', 'mb-3' => !$loop->last])>
			<div class="card-header d-flex">
				<a class="flex-grow-1" href="{{ lroute('etypes.show', ['etype' => $etype->id]) }}">{{ $etype->name }}</a>
				<a class="btn reset text-decoration-none mx-2" data-bs-toggle="tooltip" title="{{ __('action.show') }}" href="{{ $etype->getActionUrl('show') }}">
					<i class="bi bi-eye-fill hover-warning"></i>
				</a>
				<a class="btn reset text-decoration-none mx-2" data-bs-toggle="tooltip" title="{{ __('action.edit') }}" href="{{ $etype->getActionUrl('edit') }}">
					<i class="bi bi-pen-fill hover-warning"></i>
				</a>
				<a class="btn reset text-decoration-none mx-2" data-bs-toggle="tooltip" title="{{ __('action.delete') }}" href="{{ $etype->getActionUrl('delete') }}">
					<i class="bi bi-trash-fill hover-warning"></i>
				</a>
			</div>
			@if ($etype->description)
				<div class="card-body">
					<p class="card-text">{{ $etype->description }}</p>
				</div>
			@endif
		</div>
	@endforeach
@endsection
