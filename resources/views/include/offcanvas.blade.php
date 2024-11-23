<section id="{{ $id }}" class="offcanvas offcanvas-start">
	<div class="offcanvas-header shadow justify-content-between" data-bs-toggle="offcanvas" data-bs-target="{{ $target }}">
		<bi class="bi-chevron-left"></bi>
		<span>{{ $header }}</span>
	</div>
	<div class="offcanvas-body">
		<div class="list-group list-group-flush">
			@foreach ($menu as $item)
				@if ($item->icon)
					<a @class(['list-group-item text-decoration-none text-body', 'active' => $item->active]) href="{{ $item->link }}">
						<i class="fi fi-{{ $item->icon }}"></i>
						<span>{{ $item->title }}</span>
					</a>
				@else
					<a @class(['list-group-item text-decoration-none text-body', 'active' => $item->active]) href="{{ $item->link }}">{{ $item->title }}</a>
				@endif
			@endforeach
		</div>
	</div>
</section>
