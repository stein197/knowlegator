@extends('template.menu')

@section('content')
	{{ $form->view() }}
	<div class="btn-group">
		@foreach ($buttons as $btn)
			<a class="btn btn-outline-secondary" href="{{ $btn->url }}" data-bs-toggle="tooltip" data-bs-title="{{ $btn->label }}">
				@if ($btn->icon)
					<i class="bi bi-{{ $btn->icon }} color-inherit"></i>
				@else
					<span>{{ $btn->label }}</span>
				@endif
			</a>
		@endforeach
	</div>
@endsection
