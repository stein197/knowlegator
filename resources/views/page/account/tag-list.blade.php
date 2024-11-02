@extends('template.menu')

@section('content')
	@if ($tags->isEmpty())
		<p class="alert alert-primary text-center text-primary">{{ __('page.account.tag-list.empty') }}</p>
	@else
		<div class="d-flex flex-wrap m-n1">
			@foreach ($tags as $tag)
				<a class="badge text-bg-primary rounded-pill fs-6 m-1 flex-grow-1" href="">{{ $tag->name }}</a>
			@endforeach
		</div>
	@endif
@endsection
