<p @class(["my-3 alert alert-{$type}", $class, 'callout' => $callout, 'alert-dismissible fade show' => $dismissible])>
	@if ($icon)
		<i class="bi bi-{{ $icon }} color-inherit"></i>
	@endif
	@isset ($slot)
		<span>{{ $slot }}</span>
	@endisset
	@if ($dismissible)
		<button class="btn-close" type="button" data-bs-dismiss="alert"></button>
	@endif
</p>
