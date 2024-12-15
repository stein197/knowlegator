<form class="card shadow needs-validation" action="{{ $action }}" method="{{ $method === 'GET' ? 'GET' : 'POST' }}" enctype="multipart/form-data" novalidate>
	@csrf
	@method($method)
	<div class="card-body vstack gap-3">
		@if ($title)
			<p class="m-0">
				<strong>{{ $title }}</strong>
			</p>
		@endif
		@notnull ($alert)
			<p @class(["alert alert-{$alert['type']} mb-0", 'alert-dismissible fade show' => @$alert['dismissible']])>
				<span>{{ $alert['message'] }}</span>
				@isset ($alert['dismissible'])
					<button class="btn-close" type="button" data-bs-dismiss="alert"></button>
				@endisset
			</p>
		@endnotnull
		@if (!empty($fields))
			<div class="vstack gap-3">
				@foreach ($fields as $field)
					{{ $field->view(['readonly' => $readonly]) }}
				@endforeach
			</div>
		@endif
		@if ($buttons)
			<div class="hstack gap-3">
				@foreach ($buttons as $i => $btn)
					{{ $btn->render(['class' => 'flex-grow-1']) }}
				@endforeach
			</div>
		@endif
	</div>
</form>
