@extends('template.resource.index')

@section('data')
	<div class="list-group">
		@foreach ($data as $etype)
			<a class="list-group-item list-group-item-action" href="{{ lroute('etypes.show', ['etype' => $etype->id]) }}">{{ $etype->name }}</a>
		@endforeach
	</div>
@endsection
