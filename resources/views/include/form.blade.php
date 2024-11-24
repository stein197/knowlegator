<form class="card shadow" action="{{ $action }}" method="{{ $method === 'GET' ? 'GET' : 'POST' }}" enctype="multipart/form-data">
	@csrf
	@method($method)
	<div class="card-body">
		@if ($title)
			<p>
				<strong>{{ $title }}</strong>
			</p>
		@endif
		@foreach ($fields as $field)
			{{ $field->view() }}
		@endforeach
		@if ($buttons)
			<div class="row">
				@foreach ($buttons as $i => $btn)
					<div @class(["col col-12 col-sm-{$colSize}", 'mb-3 mb-sm-0' => !$loop->last])>
						@if ($btn->url)
							<a class="btn btn-{{ $btn->type }} w-100" href="{{ $btn->url }}">{{ $btn->label }}</a>
						@else
							<button class="btn btn-{{ $btn->type }} w-100" name="{{ $btn->name }}" value="{{ $btn->value }}">{{ $btn->label }}</button>
						@endif
					</div>
				@endforeach
			</div>
		@endif
	</div>
</form>
