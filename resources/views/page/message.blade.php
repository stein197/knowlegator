@extends('template.content')

@section('content')
	<p class="alert alert-{{ $type }}">{{ $message }}</p>
	<a class="btn btn-dark" href="/">{{ __('back') }}</a>
@endsection
