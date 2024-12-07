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
			<p class="alert alert-{{ $alert['type'] }} mb-0 alert-dismissible fade show">
				<span>{{ $alert['message'] }}</span>
				<button class="btn-close" data-bs-dismiss="alert"></button>
			</p>
		@endnotnull
		@if (!empty($fields))
			<div class="vstack gap-3">
				@foreach ($fields as $field)
					{{ $field->view() }}
				@endforeach
			</div>
		@endif
		@if ($buttons)
			<div class="hstack gap-3">
				@foreach ($buttons as $i => $btn)
					@if ($btn->url)
						<a class="btn btn-{{ $btn->type }} flex-grow-1" href="{{ $btn->url }}">{{ $btn->label }}</a>
					@else
						<button class="btn btn-{{ $btn->type }} flex-grow-1" name="{{ $btn->name }}" value="{{ $btn->value }}">{{ $btn->label }}</button>
					@endif
				@endforeach
			</div>
		@endif
	</div>
</form>
