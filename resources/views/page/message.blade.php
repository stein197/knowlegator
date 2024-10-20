@extends('template.index')

@section('main')
	<section class="my-5">
		<div class="container">
			<h1>{{ __('oops') }}</h1>
			<p class="alert alert-{{ $type }}">{{ $message }}</p>
			<a class="btn btn-dark" href="/">{{ __('back') }}</a>
		</div>
	</section>
@endsection
