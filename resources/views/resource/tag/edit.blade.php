@extends('template.menu')

@section('content')
	@if ($message)
		<x-alert type="{{ $message['type'] }}" message="{!! $message['text'] !!}" :icon="null" />
	@endif
	<x-form
		method="PUT"
		action="{{ $action }}"
		:fields="[
			new FormFieldRecord(
				name: 'name',
				label: __('form.field.name'),
				value: $tag->name
			)
		]"
		:buttons="[
			new ButtonRecord(
				label: __('action.cancel'),
				type: 'warning',
				url: $cancelUrl
			),
			new ButtonRecord(
				label: __('action.save'),
				type: 'success'
			)
		]" />
@endsection
