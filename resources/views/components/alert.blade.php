<p class="my-3 alert alert-{{ $type }}">
	@if ($icon)
		<i class="bi bi-{{ $icon }} color-inherit"></i>
	@endif
	<span>{{ $message }}</span>
</p>
