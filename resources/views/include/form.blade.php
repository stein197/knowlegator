<form class="card shadow" action="{{ $action }}" method="{{ $method === 'GET' ? 'GET' : 'POST' }}" enctype="multipart/form-data">
	@csrf
	@method($method)
	<div class="card-body vstack gap-3">
		@if ($title)
			<p class="m-0">
				<strong>{{ $title }}</strong>
			</p>
		@endif
		<div class="vstack gap-3">
			@foreach ($fields as $field)
				{{ $field->view() }}
			@endforeach
		</div>
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
