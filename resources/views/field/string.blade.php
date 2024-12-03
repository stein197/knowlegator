<div class="form-floating">
	<input
		@class([
			'form-control',
			'border-danger bg-danger bg-opacity-10' => isset($errors) && $errors->has($f->name)
		])
		type="{{ $f->params['type'] }}"
		name="{{ $f->name }}"
		value="{{ $f->value }}"
		@readonly($f->readonly)
		@required($f->required) />
	<label>{{ $f->label }}</label>
	@if (isset($errors) && $errors->has($f->name))
		<p class="text-danger">{{ $errors->get($f->name)[0] }}</p>
	@endif
</div>
