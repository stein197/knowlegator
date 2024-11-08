@extends('template.menu')

@section('content')
	<x-form
		action="{{ lroute('settings.password') }}"
		method="PUT"
		:fields="[
			new FormFieldRecord(
				name: 'old',
				label: __('form.field.oldPassword'),
				type: FormFieldType::Password,
				required: true
			),
			new FormFieldRecord(
				name: 'new',
				label: __('form.field.newPassword'),
				type: FormFieldType::Password,
				required: true
			),
			new FormFieldRecord(
				name: 'repeat',
				label: __('form.field.repeatPassword'),
				type: FormFieldType::Password,
				required: true
			),
		]"
		:buttons="[
			new ButtonRecord(
				label: __('form.button.confirm'),
				type: 'primary'
			)
		]" />
@endsection
