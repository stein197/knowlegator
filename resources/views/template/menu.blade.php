@extends('template.index')

@php
	$routeName = request()->route()->getName();
	[$routeNamePrefix] = explode('.', $routeName);
	$menu = menu($routeNamePrefix);
@endphp

@section('main')
	<section class="my-5">
		<div class="container">
			<div class="row">
				<div class="col col-12 col-md-4 col-lg-2">
					@if ($menu)
						<aside>
							<div class="list-group">
								@foreach ($menu as $item)
									<a class="list-group-item list-group-item-action {{ $item->active ? 'active' : '' }}" href="{{ $item->link }}">{{ $item->title }}</a>
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
