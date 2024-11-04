@use('App\Services\BreadcrumbService')
@extends('template.index')

@php
	$routeName = request()->route()->getName();
	[$routeNamePrefix] = explode('.', $routeName);
@endphp

@section('main')
	<section class="my-5">
		<div class="container">
			<div class="row">
				<div class="col col-12 col-md-4 col-lg-2">
					<aside>
						<div class="list-group">
							@foreach (app('menu')->get($routeNamePrefix) as $item)
								<a class="{{ classname('list-group-item list-group-item-action', $item->active ? 'active' : null) }}" href="{{ $item->link }}">{{ $item->title }}</a>
							@endforeach
						</div>
					</aside>
				</div>
				<div class="col col-12 col-md-8 col-lg-10">
					<nav>
						<ol class="breadcrumb">
							@foreach (app(BreadcrumbService::class)->list() as $i => $item)
								<li class="breadcrumb-item">
									@if ($item->link)
										<a href="{{ $item->link }}">{{ $item->title }}</a>
									@else
										<span>{{ $item->title }}</span>
									@endif
								</li>
							@endforeach
						</ol>
					</nav>
					<h1>{{ $title }}</h1>
					<hr />
					@yield('content')
				</div>
			</div>
		</div>
	</section>
@endsection
