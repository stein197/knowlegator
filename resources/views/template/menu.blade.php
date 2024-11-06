@extends('template.index')

@php
	[, $section] = path_split(request()->getRequestUri());
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
					@if (app('breadcrumb')->exists($section))
						<nav>
							<ol class="breadcrumb">
								@foreach (app('breadcrumb')->get($section) as $item)
									@if ($item->link)
										<li class="breadcrumb-item">
											<a href="{{ $item->link }}">{{ $item->title }}</a>
										</li>
									@else
										<li class="breadcrumb-item">{{ $item->title }}</li>
									@endif
								@endforeach
							</ol>
						</nav>
					@endif
					<h1>{{ $title }}</h1>
					<hr />
					@yield('content')
				</div>
			</div>
		</div>
	</section>
@endsection
