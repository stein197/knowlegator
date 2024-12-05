<div class="form-floating">
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
	@if (isset($errors) && $errors->has($f->name))
		<p class="text-danger mb-0">{{ $errors->get($f->name)[0] }}</p>
	@endif
</div>
