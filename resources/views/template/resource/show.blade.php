@use('App\Enum\Action')

@extends('template.menu')

@section('content')
	@switch ($action)
		@case (Action::Delete)
			<x-alert type="danger" icon="exclamation-triangle-fill">{{ $actions['delete']['alert'] }}</x-alert>
			<x-form
				method="DELETE"
				action="{{ $actions['delete']['url'] }}"
				:buttons="[
					new ButtonRecord(
						label: __('action.delete'),
						type: 'danger'
					)
				]" />
			@break

		@default
			<div>
				@foreach ($buttons as $btn)
					@if ($btn->icon)
						<a class="btn btn-{{ $btn->type }}" href="{{ $btn->url }}">
							<i class="bi bi-{{ $btn->icon }} color-inherit"></i>
							<span>{{ $btn->label }}</span>
						</a>
					@else
						<a class="btn btn-{{ $btn->type }}" href="{{ $btn->url }}">{{ $btn->label }}</a>
					@endif
				@endforeach
			</div>
	@endswitch
@endsection
