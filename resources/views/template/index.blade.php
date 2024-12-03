@php
	$menus = [
		'account' => [
			'enabled' => auth()->user() !== null
		],
		'settings' => [
			'enabled' => auth()->user() !== null
		],
		'lang' => [
			'enabled' => true
		]
	];
@endphp
<!DOCTYPE html>
<html lang="{{ app()->currentLocale() }}" data-bs-theme="{{ app('theme') }}">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="icon" href="/favicon.ico" />
		<title>{{ $title }}</title>

		<!-- bootstrap -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
		<!-- /bootstrap -->

		<!-- bootstrap-icons -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
		<!-- /bootstrap-icons -->

		<!-- google-fonts -->
		<link rel="preconnect" href="https://fonts.googleapis.com" />
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
		<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet" />
		<!-- /google-fonts -->

		<!-- flag-icons -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.2.3/css/flag-icons.min.css" />
		<!-- /flag-icons -->

		<!-- app-assets -->
		<link rel="stylesheet" href="/index.css?{{ filemtime(public_path('index.css')) }}" />
		<script src="/index.js?{{ filemtime(public_path('index.js')) }}"></script>
		<!-- /app-assets -->
	</head>
	<body class="d-flex flex-column">
		<header class="position-sticky top-0 border-bottom">
			<nav class="navbar navbar-expand-lg bg-body-tertiary">
				<div class="container">
					<a class="navbar-brand" href="/">Knowlegator</a>
					<div class="align-items-center d-none d-md-flex">
						@auth
							<em class="mx-2">{{ auth()->user()->email }}</em>
							<div class="vr"></div>
						@endauth
						@include('include.theme-toggle')
						<div class="vr"></div>
						<div class="dropdown">
							<button class="btn dropdown-toggle dropdown-toggle-noarrow text-dark fs-5" type="button" data-bs-toggle="dropdown" aria-expanded="false">
								<i class="bi bi-globe-americas hover-warning"></i>
							</button>
							<ul class="dropdown-menu dropdown-menu-end">
								@foreach (app('menu')->get('lang') as $item)
									<li>
										<a @class(['dropdown-item', 'active' => $item->active]) href="{{ $item->link }}">
											<span class="fi fi-{{ $item->icon }}"></span>
											<span>{{ $item->title }}</span>
										</a>
									</li>
								@endforeach
							</ul>
						</div>
						@auth
							<div class="vr"></div>
							<div class="dropdown">
								<button class="btn dropdown-toggle dropdown-toggle-noarrow text-dark fs-5" type="button" data-bs-toggle="dropdown" aria-expanded="false">
									<i class="bi bi-person-circle hover-warning"></i>
								</button>
								<ul class="dropdown-menu dropdown-menu-end">
									@foreach (app('menu')->get('main') as $menu)
										<li>
											<a class="dropdown-item" href={{ $menu->link }}>
												<i class="bi bi-{{ $menu->icon }}"></i>
												<span>{{ $menu->title }}</span>
											</a>
										</li>
									@endforeach
									<li>
										<span class="dropdown-item">
											<form action="{{ lroute('logout') }}" method="POST" enctype="multipart/form-data">
												@csrf
												<button class="reset w-100 text-start">
													<i class="bi bi-box-arrow-right"></i>
													<span>{{ __('menu.main.logout') }}</span>
												</button>
											</form>
										</span>
									</li>
								</ul>
							</div>
						@endauth
					</div>
					<button class="btn reset d-md-none fs-1" data-bs-toggle="offcanvas" data-bs-target="#menu-mobile">
						<i class="bi bi-list"></i>
					</button>
				</div>
			</nav>
		</header>

		<section id="menu-mobile" class="offcanvas offcanvas-start">
			<div class="offcanvas-header border-bottom">
				@auth
					<em>{{ auth()->user()->email }}</em>
				@endauth
				<div class="ms-auto d-flex align-items-center">
					@include('include.theme-toggle')
					<button class="btn btn-close ms-0" data-bs-dismiss="offcanvas"></button>
				</div>
			</div>
			<div class="offcanvas-body">
				<ul class="list-group list-group-flush">
					@foreach ($menus as $k => ['enabled' => $enabled])
						@if ($enabled)
							<li class="list-group-item">
								<a class="text-decoration-none text-body d-flex justify-content-between align-items-center" href="#menu-mobile-{{ $k }}" data-bs-toggle="offcanvas">
									<span>{{ __("menu.main.{$k}") }}</span>
									<i class="bi bi-chevron-right"></i>
								</a>
							</li>
						@endif
					@endforeach
					@auth
						<li class="list-group-item">
							<form action="{{ lroute('logout') }}" method="POST" enctype="multipart/form-data">
								@csrf
								<button class="reset w-100 text-start">
									<i class="bi bi-box-arrow-left"></i>
									<span>{{ __('menu.main.logout') }}</span>
								</button>
							</form>
						</li>
					@endauth
				</ul>
			</div>
		</section>

		@foreach ($menus as $k => ['enabled' => $enabled])
			@if ($enabled)
				@include('include.offcanvas', [
					'id' => "menu-mobile-{$k}",
					'target' => '#menu-mobile',
					'header' => __("menu.main.{$k}"),
					'menu' => app('menu')->get($k)
				])
			@endif
		@endforeach

		<main class="flex-grow-1 d-flex flex-column">@yield('main')</main>
	</body>
</html>
