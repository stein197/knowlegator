@extends('template.menu')

@section('content')
	<x-alert type="danger" icon="exclamation-triangle-fill">{{ $message }}</x-alert>
	<x-form
		method="DELETE"
		action="{{ $action }}"
		:buttons="[
			new ButtonRecord(
				label: __('action.delete'),
				type: 'danger'
			)
		]" />
@endsection
