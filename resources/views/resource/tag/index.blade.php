@extends('template.menu')

@section('content')
	@if (!$tags->isEmpty() || $search['value'] !== null)
		<x-search-bar action="{{ $search['action'] }}" placeholder="{{ $search['placeholder'] }}" value="{{ $search['value'] }}" />
	@endif
	@if ($tags->isEmpty())
		<p class="alert alert-info text-center m-0">{{ __($search['value'] === null ? 'resource.tag.index.message.empty' : 'resource.tag.index.message.emptySearchResult') }}</p>
	@else
		<div class="d-flex flex-wrap m-n1">
			@foreach ($tags as $tag)
				<a class="badge text-bg-primary rounded-pill fs-6 m-1 flex-grow-1" href="{{ lroute('tags.show', ['tag' => $tag->id]) }}">{{ $tag->name }}</a>
			@endforeach
		</div>
	@endif
	<a class="mt-3 btn btn-primary" href="{{ lroute('tags.create') }}">{{ __('resource.tag.create.title') }}</a>
@endsection
