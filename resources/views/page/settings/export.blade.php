@extends('template.menu')

@section('content')
	<a class="text-decoration-none text-center border border-3 rounded-3 p-3 p-md-5 d-block text-secondary" href="{{ $href }}">
		<span class="fs-3">{{ $message }}</span>
		<br />
		<i class="bi bi-download fs-1"></i>
	</a>
@endsection
