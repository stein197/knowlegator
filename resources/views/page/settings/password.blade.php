@extends('template.content')

@section('content')
	<x-form
		action="{{ lroute('settings.password') }}"
		method="PUT"
		:fields="[
			'old' => [
				'label' => __('form.field.oldPassword'),
				'type' => 'password',
				'required' => true
			],
			'new' => [
				'label' => __('form.field.newPassword'),
				'type' => 'password',
				'required' => true
			],
			'repeat' => [
				'label' => __('form.field.repeatPassword'),
				'type' => 'password',
				'required' => true
			],
		]"
		:buttons="[
			[
				'label' => __('form.button.confirm'),
				'type' => 'primary'
			]
		]" />
@endsection
