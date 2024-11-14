@use('App\Services\ApplicationVersionService')
@use('App\Services\LocaleService')

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
		<header>
			<nav class="navbar navbar-expand-lg bg-body-tertiary">
				<div class="container">
					<a class="navbar-brand" href="/">Knowlegator</a>
					<div class="d-flex align-items-center">
						@auth
							<em class="mx-2">{{ auth()->user()->email }}</em>
							<div class="vr"></div>
						@endauth
						<form action="{{ lroute('theme') }}" method="POST" enctype="multipart/form-data">
							@csrf
							@method('PUT')
							<button class="reset d-flex align-items-center fs-5 cursor-pointer mx-2">
								<i class="bi bi-sun-fill"></i>
								<div class="form-check form-switch p-0 mb-0 mx-2 d-flex align-items-center">
									<input class="form-check-input cursor-pointer m-0 float-none pe-none" type="checkbox" @checked(app('theme')->dark()) />
								</div>
								<i class="bi bi-moon-fill"></i>
							</button>
						</form>
						<div class="vr"></div>
						<div class="dropdown">
							<button class="btn dropdown-toggle dropdown-toggle-noarrow text-dark fs-5" type="button" data-bs-toggle="dropdown" aria-expanded="false">
								<i class="bi bi-globe-americas"></i>
							</button>
							<ul class="dropdown-menu dropdown-menu-end">
								@foreach (app(LocaleService::class)->locales(app()->request) as $k => $locale)
									<li>
										<a class="dropdown-item {{ app()->getLocale() === $k ? 'active' : '' }}" href="{{ $locale['url'] }}">
											<span class="fi fi-{{ $locale['flag-icon'] }}"></span>
											<span>{{ $locale['name'] }}</span>
										</a>
									</li>
								@endforeach
							</ul>
						</div>
						@auth
							<div class="vr"></div>
							<div class="dropdown">
								<button class="btn dropdown-toggle dropdown-toggle-noarrow text-dark fs-5" type="button" data-bs-toggle="dropdown" aria-expanded="false">
									<i class="bi bi-person-circle"></i>
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
				</div>
			</nav>
		</header>
		<main class="flex-grow-1 d-flex flex-column">@yield('main')</main>
	</body>
</html>
