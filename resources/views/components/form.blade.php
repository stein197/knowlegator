<form class="card" action="{{ $action }}" method="POST" enctype="multipart/form-data">
	@csrf
	@method($method)
	<div class="card-body">
		@foreach ($fields as $name => $field)
			<div class="mb-3">
				<p class="form-label">{{ $field['label'] }}</p>
				<input class="form-control" type="{{ $field['type'] }}" name="{{ $name }}" {{ @$field['required'] ? 'required' : '' }} />
			</div>
		@endforeach
		@if ($buttons)
			<div class="row">
				@foreach ($buttons as $btn)
					<div class="col col-12 col-sm-{{ $btnBSSize }} mb-3 mb-sm-0">
						<button class="btn btn-{{ $btn['type'] }} w-100" name="{{ @$btn['name'] }}" value="{{ @$btn['value'] }}">{{ $btn['label'] }}</button>
					</div>
				@endforeach
			</div>
		@endif
	</div>
</form>
