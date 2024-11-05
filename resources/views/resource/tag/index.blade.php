@extends('template.menu')

@section('content')
	@if ($tags->isEmpty())
		<p class="alert alert-primary text-center text-primary m-0">{{ __('resource.tag.index.message.empty') }}</p>
	@else
		<div class="d-flex flex-wrap m-n1">
			@foreach ($tags as $tag)
				<a class="badge text-bg-primary rounded-pill fs-6 m-1 flex-grow-1" href="">{{ $tag->name }}</a>
			@endforeach
		</div>
	@endif
	<a class="mt-3 btn btn-primary" href="{{ lroute('tags.create') }}">{{ __('resource.tag.create.title') }}</a>
@endsection
