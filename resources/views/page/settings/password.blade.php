@extends('template.content')

@section('content')
	<x-form
		action="{{ route('settings.password', [], false) }}"
		method="PUT"
		:fields="[
			'old' => [
				'label' => __('form.password.field.old'),
				'type' => 'password',
				'required' => true
			],
			'new' => [
				'label' => __('form.password.field.new'),
				'type' => 'password',
				'required' => true
			],
			'repeat' => [
				'label' => __('form.password.field.repeat'),
				'type' => 'password',
				'required' => true
			],
		]"
		:buttons="[
			[
				'label' => __('form.password.button.confirm'),
				'type' => 'primary'
			]
		]" />
@endsection
