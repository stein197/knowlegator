@extends('template.index')

@php
	$path = path_split(request()->getRequestUri());
	[, $section] = $path;
@endphp

@section('main')
	<section class="my-5">
		<div class="container">
			<div class="row">
				<div class="col col-12 col-md-4 col-lg-2">
					@if (app('menu')->exists($section))
						<aside>
							<div class="list-group">
								@foreach (app('menu')->get($section) as $item)
									<a class="{{ classname('list-group-item list-group-item-action', $item->active ? 'active' : null) }}" href="{{ $item->link }}">{{ $item->title }}</a>
								@endforeach
							</div>
						</aside>
					@endif
				</div>
				<div class="col col-12 col-md-8 col-lg-10">
					@isset($path[3])
						<a class="fs-5" href="..">&laquo; {{ __('back') }}</a>
					@endisset
					<h1>{{ $title }}</h1>
					<hr />
					@yield('content')
				</div>
			</div>
		</div>
	</section>
@endsection
