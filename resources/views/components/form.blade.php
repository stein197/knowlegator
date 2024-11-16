<form class="card shadow" action="{{ $action }}" method="POST" enctype="multipart/form-data">
	@csrf
	@method($method)
	<div class="card-body">
		@if ($title)
			<p>
				<strong>{{ $title }}</strong>
			</p>
		@endif
		@foreach ($fields as $field)
			@switch ($field->type)
				@case (FormFieldType::Checkbox)
					<label class="form-label">
						<input class="form-check-input" type="checkbox" name="{{ $field->name }}" @required($field->required) />
						<span>{{ $field->label ?? $field->name }}</span>
					</label>
					@break
				@default
					<div class="mb-3 form-floating">
						<input
							class="form-control @isset($errors) @error($field->name) border-danger bg-danger bg-opacity-10 @enderror @endisset"
							type="{{ $field->type->name() }}"
							name="{{ $field->name }}"
							value="{{ $field->value }}"
							@required($field->required) />
						<label>{{ $field->label ?? $field->name }}</label>
						@isset($errors)
							@error($field->name)
								<p class="text-danger">{{ $message }}</p>
							@enderror
						@endisset
						@if ($field->tooltip)
							<div class="position-absolute end-0 top-0 h-100 d-flex align-items-center me-3 pe-none">
								<i class="bi bi-info-circle-fill pe-auto text-info" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="{{ $field->tooltip }}"></i>
							</div>
						@endif
					</div>
			@endswitch
		@endforeach
		@if ($buttons)
			<div class="row">
				@foreach ($buttons as $i => $btn)
					<div @class(["col col-12 col-sm-{$btnBSSize}", 'mb-3 mb-sm-0' => @$buttons[$i + 1] !== null])>
						@if ($btn->url)
							<a class="btn btn-{{ $btn->type }} w-100" href="{{ $btn->url }}">{{ $btn->label }}</a>
						@else
							<button class="btn btn-{{ $btn->type }} w-100" name="{{ $btn->name }}" value="{{ $btn->value }}">{{ $btn->label }}</button>
						@endif
					</div>
				@endforeach
			</div>
		@endif
		@isset($slot)
			{{ $slot }}
		@endisset
	</div>
</form>
