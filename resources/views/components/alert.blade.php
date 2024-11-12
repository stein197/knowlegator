<p class="my-3 alert alert-{{ $type }}">
	@if ($icon)
		<i class="bi bi-{{ $icon }} color-inherit"></i>
	@endif
	@isset ($slot)
		<span>{{ $slot }}</span>
	@endisset
</p>
