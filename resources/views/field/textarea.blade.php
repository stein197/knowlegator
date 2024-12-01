<div class="mb-3 form-floating">
	<textarea
		@class([
			'form-control',
			'border-danger bg-danger bg-opacity-10' => isset($errors) && $errors->has($f->name)
		])
		name="{{ $f->name }}"
		value="{{ $f->value }}"
		rows="{{ $f->params['rows'] }}"
		@readonly($f->readonly)
		@required($f->required)
		>{{ $f->value }}</textarea>
	<label>{{ $f->label }}</label>
</div>
