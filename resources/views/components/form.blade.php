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
						<input class="form-check-input" type="checkbox" name="{{ $field->name }}" {{ $field->required ? 'required=""' : '' }} />
						<span>{{ $field->label }}</span>
					</label>
					@break
				@default
					<div class="mb-3 form-floating">
						<input
							class="form-control @isset($errors) @error($field->name) border-danger bg-danger bg-opacity-10 @enderror @endisset"
							type="{{ $field->type->name() }}"
							name="{{ $field->name }}" {{ $field->required ? 'required=""' : '' }}
							value="{{ $field->value }}" />
						<label>{{ $field->label }}</label>
						@isset($errors)
							@error($field->name)
								<p class="text-danger">{{ $message }}</p>
							@enderror
						@endisset
					</div>
			@endswitch
		@endforeach
		@if ($buttons)
			<div class="row">
				@foreach ($buttons as $btn)
					<div class="col col-12 col-sm-{{ $btnBSSize }} mb-3 mb-sm-0">
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
