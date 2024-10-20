<form class="card shadow" action="{{ $action }}" method="POST" enctype="multipart/form-data">
	@csrf
	@method($method)
	<div class="card-body">
		@if ($title)
			<p>
				<strong>{{ $title }}</strong>
			</p>
		@endif
		@foreach ($fields as $name => $field)
			@switch (@$field['type'])
				@case ('checkbox')
					<label class="form-label">
						<input class="form-check-input" type="checkbox" name="{{ $name }}" {{ @$field['required'] ? 'required' : '' }} />
						<span>{{ $field['label'] }}</span>
					</label>
					@break
				@default
					<div class="mb-3">
						<p class="form-label">{{ $field['label'] }}</p>
						<input class="form-control" type="{{ @$field['type'] ?? 'text' }}" name="{{ $name }}" {{ @$field['required'] ? 'required' : '' }} />
					</div>
			@endswitch
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
