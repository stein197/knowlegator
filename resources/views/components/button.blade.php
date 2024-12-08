@if ($url)
	@if ($icon)
		<a @class(["btn btn-{$variant}", $class]) href="{{ $url }}" data-bs-toggle="tooltip" data-bs-title="{{ $label }}">
			<i class="bi bi-{{ $icon }}"></i>
		</a>
	@else
		<a @class(["btn btn-{$variant}", $class]) href="{{ $url }}">{{ $label }}</a>
	@endif
@else
	@if ($icon)
		<button @class(["btn btn-{$variant}", $class]) type="{{ $type }}" name="{{ $name }}" value="{{ $value }}" data-bs-toggle="tooltip" data-bs-title="{{ $label }}">
			<i class="bi bi-{{ $icon }}"></i>
		</button>
	@else
		<button @class(["btn btn-{$variant}", $class]) type="{{ $type }}" name="{{ $name }}" value="{{ $value }}">{{ $label }}</button>
	@endif
@endif
