@extends('template.content')

@section('content')
	<p class="alert alert-{{ $type }}">{{ $message }}</p>
	<a class="btn btn-dark" href="{{ url()->previous() }}">{{ __('back') }}</a>
@endsection
