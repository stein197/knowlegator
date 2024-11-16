@extends('template.resource.index')

@section('data')
	<div class="d-flex flex-wrap m-n1">
		@foreach ($data as $tag)
			<a class="badge text-bg-primary fs-6 m-1 flex-grow-1" href="{{ lroute('tags.show', ['tag' => $tag->id]) }}">{{ $tag->name }}</a>
		@endforeach
	</div>
@endsection
