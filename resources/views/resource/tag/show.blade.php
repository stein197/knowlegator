@use('App\Enum\Action')

@extends('template.menu')

@section('content')
	@switch ($action)
		@case (Action::Delete)
			<x-alert
				:message="__('resource.tag.delete.confirmation', ['tag' => $tag->name])"
				type="danger" />
			<x-form method="DELETE" :buttons="[
				new ButtonRecord(
					label: __('action.delete'),
					type: 'danger'
				)
			]" />
			@break

		@default
			<div>
				<a class="btn btn-danger" href="{{ $link['delete'] }}">
					<i class="bi bi-trash-fill color-inherit"></i>
					<span>{{ __('action.delete') }}</span>
				</a>
			</div>
	@endswitch
@endsection
