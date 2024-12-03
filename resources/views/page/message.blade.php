@extends('template.content')

@section('content')
	<x-alert type="{{ $type }}">{{ $message }}</x-alert>
	<a class="btn btn-dark" href="{{ url()->previous() }}">{{ __('action.back') }}</a>
@endsection
