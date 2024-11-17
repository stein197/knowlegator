@extends('template.menu')

@section('content')
	<x-form
		action="{{ $action }}"
		method="POST"
		:fields="$fields"
		:buttons="$buttons" />
@endsection
