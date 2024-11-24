<label class="form-label">
	<input
		class="form-check-input"
		type="checkbox"
		name="{{ $f->name }}"
		@checked($f->params['checked'])
		@required($f->required)
		@readonly($f->readonly)
		/>
	<span>{{ $f->label }}</span>
</label>
