@extends('template.menu')

@section('content')
	<x-form
		action="{{ lroute('account.tag.create') }}"
		method="POST"
		:fields="[
			'name' => [
				'label' => __('form.field.name')
			]
		]"
		:buttons="[
			[
				'label' => __('form.button.confirm'),
				'type' => 'success'
			]
		]" />
@endsection
