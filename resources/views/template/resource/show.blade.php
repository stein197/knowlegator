@use('App\Enum\Action')

@extends('template.menu')

@section('content')
	@foreach ($buttons as $btn)
		@if ($btn->icon)
			<a class="btn btn-{{ $btn->type }}" href="{{ $btn->url }}">
				<i class="bi bi-{{ $btn->icon }} color-inherit"></i>
				<span>{{ $btn->label }}</span>
			</a>
		@else
			<a class="btn btn-{{ $btn->type }}" href="{{ $btn->url }}">{{ $btn->label }}</a>
		@endif
	@endforeach
@endsection
