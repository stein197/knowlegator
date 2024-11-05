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
					<nav>
						<ol class="breadcrumb">
							@foreach (app('breadcrumb')->list() as $i => $item)
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
