@extends('template.menu')

@section('content')
	<x-form
		action="{{ lroute('tags.index') }}"
		method="POST"
		:fields="[
			new FormFieldRecord(
				name: 'name',
				label: __('form.field.name')
			)
		]"
		:buttons="[
			new ButtonRecord(
				label: __('form.button.confirm'),
				type: 'success'
			)
		]" />
@endsection
