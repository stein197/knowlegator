@extends('template.resource.index')

@section('data')
	<ul class="list-group">
		@foreach ($data as $etype)
			<li class="list-group-item d-flex" href="{{ lroute('etypes.show', ['etype' => $etype->id]) }}">
				<a class="flex-grow-1 text-decoration-none" href="{{ $etype->getActionUrl('show') }}">{{ $etype->name }}</a>
				<a class="btn reset text-decoration-none mx-2" data-bs-toggle="tooltip" title="{{ __('action.show') }}" href="{{ $etype->getActionUrl('show') }}">
					<i class="bi bi-eye-fill"></i>
				</a>
				<a class="btn reset text-decoration-none mx-2" data-bs-toggle="tooltip" title="{{ __('action.edit') }}" href="{{ $etype->getActionUrl('edit') }}">
					<i class="bi bi-pen-fill"></i>
				</a>
				<a class="btn reset text-decoration-none mx-2" data-bs-toggle="tooltip" title="{{ __('action.delete') }}" href="{{ $etype->getActionUrl('delete') }}">
					<i class="bi bi-trash-fill"></i>
				</a>
			</li>
		@endforeach
	</ul>
@endsection
