@extends('template.index')

@section('main')
	<section class="my-5">
		<div class="container">
			<h1>{{ $title }}</h1>
			<hr />
			@yield('content')
		</div>
	</section>
@endsection
