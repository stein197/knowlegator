@extends('template.index')

@section('main')
	<section class="my-5">
		<div class="container">
			<div class="row">
				<div class="col col-12 col-md-4 col-lg-2">
					<aside>
						<div class="list-group">
							@foreach (menu('settings') as $menu)
								<a class="list-group-item list-group-item-action {{ $menu->active ? 'active' : '' }}" href="{{ $menu->link }}">{{ $menu->title }}</a>
							@endforeach
						</div>
					</aside>
				</div>
				<div class="col col-12 col-md-8 col-lg-10">
					<h1>{{ $title }}</h1>
					<hr />
					@yield('content')
				</div>
			</div>
		</div>
	</section>
@endsection
