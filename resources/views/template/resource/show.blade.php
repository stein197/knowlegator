@extends('template.menu')

@section('content')
	<table class="table">
		<caption class="caption-top">{{ __('table.resource.caption') }}</caption>
		<thead>
			<tr>
				<th>{{ __('table.resource.col.key') }}</th>
				<th>{{ __('table.resource.col.value') }}</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($model::getPublicAttributes() as $k)
				<tr>
					<td>{{ $k }}</td>
					<td>{{ $model->{$k} }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
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
