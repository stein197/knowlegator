<label class="form-label m-0">
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
