@extends('template.index')

@php
	$path = App\path_split(request()->getRequestUri());
	[, $section] = $path;
@endphp

@section('main')
	<section class="mt-3 mt-md-5">
		<div class="container">
			<div class="row">
				<div class="col col-12 col-md-4 col-lg-2 d-none d-md-block">
					@if (app('menu')->exists($section))
						<aside>
							<div class="list-group">
								@foreach (app('menu')->get($section) as $item)
									<a @class(['list-group-item list-group-item-action', 'active' => $item->active]) href="{{ $item->link }}">{{ $item->title }}</a>
								@endforeach
							</div>
						</aside>
					@endif
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
