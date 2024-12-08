@if ($href)
	@if ($icon)
		<a class="{{ $class }}" href="{{ $href }}" data-bs-toggle="tooltip" data-bs-title="{{ $label }}">
			<i class="bi bi-{{ $icon }}"></i>
		</a>
	@else
		<a class="{{ $class }}" href="{{ $href }}">{{ $label }}</a>
	@endif
@else
	@if ($icon)
		<button class="{{ $class }}" type="{{ $type }}" name="{{ $name }}" value="{{ $value }}" data-bs-toggle="tooltip" data-bs-title="{{ $label }}">
			<i class="bi bi-{{ $icon }}"></i>
		</button>
	@else
		<button class="{{ $class }}" type="{{ $type }}" name="{{ $name }}" value="{{ $value }}">{{ $label }}</button>
	@endif
@endif
