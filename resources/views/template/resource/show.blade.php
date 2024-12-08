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
			@foreach ($model::getPublicAttributes() as $k => $Field)
				<tr>
					<td>{{ $k }}</td>
					<td>{{ $model->{$k} }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	<div class="btn-group">
		@foreach ($buttons as $btn)
			{{ $btn->render() }}
		@endforeach
	</div>
@endsection
