<!DOCTYPE html>
<html lang="fr">

	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>@yield('title', 'WidriveU - Nous vous conduisons')</title>
		<link rel="shortcut icon" href="{{ asset('logo/widriveu-logo.png') }}">

		<!-- Google Fonts - Sora (display) + Poppins (body) -->
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

		<!-- fraimwork - css include -->
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">

		<!-- icon - css include -->
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/fontawesome.css') }}">

		<!-- animation - css include -->
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/aos.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/animate.css') }}">

		<!-- carousel - css include -->
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/slick.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/slick-theme.css') }}">

		<!-- popup - css include -->
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/magnific-popup.css') }}">

		<!-- select options - css include -->
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/nice-select.css') }}">

		<!-- pricing range - css include -->
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery-ui.css') }}">

		<!-- custom - css include -->
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">

		<style>
			/* ── FONT SWITCH ───────────────────────────────────────
			   Pour revenir à Sora uniquement, changer --font-body
			   en 'Sora', sans-serif dans les 3 layouts.
			─────────────────────────────────────────────────────── */
			:root {
				--font-body:    'Poppins', sans-serif;
				--font-display: 'Sora', sans-serif;
				--color-red: #860000;
				--color-blue: #860000;
				--color-dark: #000C21;
			}
			body { font-family: var(--font-body); }
			h1, h2, h3, h4, h5, h6,
			.item_title, .title_text, .page_title,
			.footer_widget_title, .input_title { font-family: var(--font-display); }

			.overflow-x-hidden {
			overflow-x: hidden;
			}
		</style>

		@stack('styles')

	</head>


	<body class="overflow-x-hidden">


		<!-- backtotop - start -->
		<div id="thetop"></div>
		<div class="backtotop">
			<a href="#" class="scroll">
				<i class="far fa-arrow-up"></i>
			</a>
		</div>
		<!-- backtotop - end -->

		<!-- preloader - start -->
		<div class="preloader">
			<div class="animation_preloader">
				<div class="spinner"></div>
				<p class="text-center">Chargement</p>
			</div>
			<div class="loader">
				<div class="row vh-100">
					<div class="col-3 loader_section section-left">
						<div class="bg"></div>
					</div>
					<div class="col-3 loader_section section-left">
						<div class="bg"></div>
					</div>
					<div class="col-3 loader_section section-right">
						<div class="bg"></div>
					</div>
					<div class="col-3 loader_section section-right">
						<div class="bg"></div>
					</div>
				</div>
			</div>
		</div>
		<!-- preloader - end -->


		<!-- header_section - start
		================================================== -->
		<header class="header_section @yield('header_class', 'secondary_header') sticky clearfix">
			<div class="header_top clearfix">
				<div class="container">
					<div class="row align-items-center">
						<div class="col-lg-7">
							<ul class="header_contact_info ul_li clearfix">
								<li><i class="fal fa-envelope"></i> reservation@widriveu.com</li>
								<li><i class="fal fa-phone"></i> +229 94 08 08 08</li>
							</ul>
						</div>

						<div class="col-lg-5">
							<ul class="primary_social_links ul_li_right clearfix">
								<li><a href="https://www.facebook.com/Widriveu" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a></li>
								<li><a href="#!"><i class="fab fa-instagram"></i></a></li>
								<li><a href="#!"><i class="fab fa-twitter"></i></a></li>
								<li><a href="#!"><i class="fab fa-youtube"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="header_bottom clearfix">
				<div class="container">
					<div class="row align-items-center">

						<div class="col-lg-3 col-md-6 col-sm-6 col-6">
							<div class="brand_logo">
								<a href="{{ route('home') }}">
								<img src="{{ asset('logo/widriveu-logo.png') }}" alt="WidriveU" style="height:70px;width:65%;object-fit:contain;">
								</a>
							</div>
						</div>

						<div class="col-lg-3 col-md-6 col-sm-6 col-6 order-last">
							<ul class="header_action_btns ul_li_right clearfix" style="display:flex;align-items:center;gap:8px;flex-wrap:nowrap;">
								@auth
								<li class="dropdown">
									<button type="button" class="user_btn" id="user_dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="fal fa-user"></i>
									</button>
									<div class="user_dropdown rotors_dropdown dropdown-menu clearfix" aria-labelledby="user_dropdown">
										<div class="profile_info clearfix">
											<a href="#!" class="user_thumbnail">
												<img src="{{ asset('assets/images/meta/img_01.png') }}" alt="thumbnail_not_found">
											</a>
											<div class="user_content">
												<h4 class="user_name"><a href="#!">{{ Auth::user()->name }}</a></h4>
												<span class="user_title">{{ Auth::user()->email }}</span>
											</div>
										</div>
										<ul class="ul_li_block clearfix">
											@if(Auth::user()->role === 'admin')
											<li><a href="{{ route('admin.dashboard') }}"><i class="fal fa-cog"></i> Administration</a></li>
											@endif
											<li><a href="{{ route('dashboard') }}"><i class="fal fa-th-large"></i> Tableau de bord</a></li>
											<li><a href="{{ route('reservations.index') }}"><i class="fal fa-calendar-check"></i> Mes réservations</a></li>
											<li>
												<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
													<i class="fal fa-sign-out"></i> Déconnexion
												</a>
												<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
													@csrf
												</form>
											</li>
										</ul>
									</div>
								</li>
								@else
								<li style="display:flex;align-items:center;">
									<a href="{{ route('login') }}" class="custom_btn bg_default_red text-uppercase">
										Connexion <img src="{{ asset('assets/images/icons/icon_01.png') }}" alt="icon_not_found">
									</a>
								</li>
								@endauth
								<li style="display:flex;align-items:center;">
									<button type="button" class="mobile_sidebar_btn"><i class="fal fa-align-right"></i></button>
								</li>
							</ul>
						</div>

						<div class="col-lg-6 col-md-12">
							<nav class="main_menu clearfix">
								<ul class="ul_li_center clearfix">
									<li class="{{ request()->routeIs('home') ? 'active' : '' }}">
										<a href="{{ route('home') }}">Accueil</a>
									</li>
									<li class="{{ request()->routeIs('about') ? 'active' : '' }}">
										<a href="{{ route('about') }}">A propos</a>
									</li>
									<li class="{{ request()->routeIs('fleet') || request()->routeIs('vehicle.show') ? 'active' : '' }}">
										<a href="{{ route('fleet') }}">Notre flotte</a>
									</li>
									<li class="{{ request()->routeIs('contact') ? 'active' : '' }}">
										<a href="{{ route('contact') }}">Contact</a>
									</li>
								</ul>
							</nav>
						</div>

					</div>
				</div>
			</div>

			</header>
		<!-- header_section - end
		================================================== -->


		<!-- main body - start
		================================================== -->
		<main>


			<!-- mobile menu - start
			================================================== -->
			<div class="sidebar-menu-wrapper">
				<div class="mobile_sidebar_menu">
					<button type="button" class="close_btn"><i class="fal fa-times"></i></button>

					<div class="about_content mb_60">
						<div class="brand_logo mb_15">
							<a href="{{ route('home') }}">
								<img src="{{ asset('logo/widriveu-logo.png') }}" alt="WidriveU" style="height:70px;width:65%;object-fit:contain;">
							</a>
						</div>
						<p class="mb-0">
							WidriveU est votre agence de référence pour la location de véhicules au Bénin. Avec ou sans chauffeur, nous vous conduisons partout à Cotonou et dans tout le pays.
						</p>
					</div>

					<div class="menu_list mb_60 clearfix">
						<h3 class="title_text text-white">Menu</h3>
						<ul class="ul_li_block clearfix">
							<li class="{{ request()->routeIs('home') ? 'active' : '' }}">
								<a href="{{ route('home') }}">Accueil</a>
							</li>
							<li class="{{ request()->routeIs('about') ? 'active' : '' }}">
								<a href="{{ route('about') }}">A propos</a>
							</li>
							<li class="{{ request()->routeIs('fleet') || request()->routeIs('vehicle.show') ? 'active' : '' }}">
								<a href="{{ route('fleet') }}">Notre flotte</a>
							</li>
							<li class="{{ request()->routeIs('contact') ? 'active' : '' }}">
								<a href="{{ route('contact') }}">Contact</a>
							</li>
							@auth
							<li>
								<a href="{{ route('dashboard') }}">Mon compte</a>
							</li>
							@else
							<li>
								<a href="{{ route('login') }}">Connexion</a>
							</li>
							@endauth
						</ul>
					</div>

					<div class="booking_car_form">
						<h3 class="title_text text-white mb-2">Réserver un véhicule</h3>
						<p class="mb_15">
							Disponible 7j/7 de 6h à 22h. Contactez-nous pour toute réservation ou renseignement.
						</p>
						<div class="form_item">
							<h4 class="input_title text-white"><i class="fas fa-phone"></i> Téléphone</h4>
							<p class="text-white mb-0"><strong>+229 94 08 08 08</strong></p>
						</div>
						<div class="form_item" style="margin-top:15px;">
							<h4 class="input_title text-white"><i class="fas fa-envelope"></i> Email</h4>
							<p class="text-white mb-0"><strong>reservation@widriveu.com</strong></p>
						</div>
						<a href="{{ route('fleet') }}" class="custom_btn bg_default_red btn_width text-uppercase" style="margin-top:15px;display:inline-block;">Voir notre flotte <img src="{{ asset('assets/images/icons/icon_01.png') }}" alt="icon_not_found"></a>
					</div>

				</div>
				<div class="overlay"></div>
			</div>
			<!-- mobile menu - end
			================================================== -->

			<!-- flash messages - start -->
			@if(session('success') || session('error') || session('warning') || $errors->any())
			<div class="container" style="margin-top:15px;">
				@if(session('success'))
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				@endif
				@if(session('error'))
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				@endif
				@if(session('warning'))
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
					<i class="fas fa-exclamation-triangle mr-2"></i> {{ session('warning') }}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				@endif
				@if($errors->any())
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<ul class="mb-0">
						@foreach($errors->all() as $error)
						<li>{{ $error }}</li>
						@endforeach
					</ul>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				@endif
			</div>
			@endif
			<!-- flash messages - end -->

			<!-- breadcrumb_section - start
			================================================== -->
			@hasSection('breadcrumb')
			<section class="breadcrumb_section text-center clearfix">
				<div class="page_title_area has_overlay d-flex align-items-center clearfix"
				     data-bg-image="{{ asset('assets/images/breadcrumb/bg_03.jpg') }}">
					<div class="overlay"></div>
					<div class="container" data-aos="fade-up" data-aos-delay="100">
						<h1 class="page_title text-white mb-0">@yield('breadcrumb_title')</h1>
					</div>
				</div>
				<div class="breadcrumb_nav clearfix" data-bg-color="#F2F2F2">
					<div class="container">
						<ul class="ul_li clearfix">
							<li><a href="{{ route('home') }}">Accueil</a></li>
							@yield('breadcrumb')
						</ul>
					</div>
				</div>
			</section>
			@endif
			<!-- breadcrumb_section - end
			================================================== -->

			@yield('content')

		</main>
		<!-- main body - end
		================================================== -->


		<!-- footer_section - start
		================================================== -->
		<footer class="footer_section clearfix">
			<div class="footer_widget_area sec_ptb_100 clearfix">
				<div class="container">
					<div class="row justify-content-lg-between">
						<div class="col-lg-4 col-md-4 col-sm-12 col-sm-12">
							<div class="footer_about" data-aos="fade-up" data-aos-delay="100">
								<div class="brand_logo mb_30">
									<a href="{{ route('home') }}">
										<img src="{{ asset('logo/widriveu-logo.png') }}" alt="WidriveU" style="height:70px;width:65%;object-fit:contain;">
									</a>
								</div>
								<p class="mb_15">
									WidriveU est votre agence de location de véhicules de confiance à Cotonou, Bénin. Location avec ou sans chauffeur pour tous vos déplacements : tourisme, mariages, événements et transferts.
								</p>
								</div>
						</div>

						<div class="col-lg-3 col-md-4 col-sm-12 col-sm-12">
							<div class="footer_contact_info" data-aos="fade-up" data-aos-delay="200">
								<h3 class="footer_widget_title">Contactez-nous :</h3>
								<ul class="ul_li_block clearfix">
									<li>
										<strong><i class="fas fa-map-marker-alt"></i> Adresse :</strong>
										<p class="mb-0">Cotonou, Bénin</p>
									</li>
									<li><i class="fas fa-clock"></i> 6h00 - 22h00 (7j/7)</li>
									<li><i class="fas fa-phone"></i> <strong>+229 94 08 08 08</strong></li>
									<li><i class="fas fa-envelope"></i> <strong>reservation@widriveu.com</strong></li>
								</ul>
							</div>
						</div>

						<div class="col-lg-4 col-md-4 col-sm-12 col-sm-12">
							<div class="footer_useful_links" data-aos="fade-up" data-aos-delay="300">
								<h3 class="footer_widget_title">Liens utiles :</h3>
								<ul class="ul_li_block clearfix">
									<li><a href="{{ route('home') }}"><i class="fal fa-angle-right"></i> Accueil</a></li>
									<li><a href="{{ route('about') }}"><i class="fal fa-angle-right"></i> A propos</a></li>
									<li><a href="{{ route('fleet') }}"><i class="fal fa-angle-right"></i> Notre flotte</a></li>
									<li><a href="{{ route('contact') }}"><i class="fal fa-angle-right"></i> Contact</a></li>
									@guest
									<li><a href="{{ route('login') }}"><i class="fal fa-angle-right"></i> Connexion</a></li>
									<li><a href="{{ route('register') }}"><i class="fal fa-angle-right"></i> Inscription</a></li>
									@endguest
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="footer_bottom text-white clearfix" data-bg-color="#000C21">
				<div class="container">
					<div class="row align-items-center justify-content-lg-between">
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<p class="copyright_text mb-0">Copyright &copy; {{ date('Y') }}. <a class="author_links text-white" href="{{ route('home') }}">WidriveU</a> &mdash; Nous vous conduisons</p>
						</div>

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<ul class="primary_social_links ul_li_right clearfix">
								<li><a href="https://www.facebook.com/Widriveu" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a></li>
								<li><a href="#!"><i class="fab fa-instagram"></i></a></li>
								<li><a href="#!"><i class="fab fa-twitter"></i></a></li>
								<li><a href="#!"><i class="fab fa-youtube"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<!-- footer_section - end
		================================================== -->


		<!-- fraimwork - jquery include -->
		<script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
		<script src="{{ asset('assets/js/popper.min.js') }}"></script>
		<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

		<!-- animation - jquery include -->
		<script src="{{ asset('assets/js/aos.js') }}"></script>
		<script src="{{ asset('assets/js/parallaxie.js') }}"></script>

		<!-- carousel - jquery include -->
		<script src="{{ asset('assets/js/slick.min.js') }}"></script>

		<!-- popup - jquery include -->
		<script src="{{ asset('assets/js/magnific-popup.min.js') }}"></script>

		<!-- select ontions - jquery include -->
		<script src="{{ asset('assets/js/nice-select.min.js') }}"></script>

		<!-- isotope - jquery include -->
		<script src="{{ asset('assets/js/isotope.pkgd.js') }}"></script>
		<script src="{{ asset('assets/js/imagesloaded.pkgd.min.js') }}"></script>
		<script src="{{ asset('assets/js/masonry.pkgd.min.js') }}"></script>

		<!-- pricing range - jquery include -->
		<script src="{{ asset('assets/js/jquery-ui.js') }}"></script>

		<!-- counter - jquery include -->
		<script src="{{ asset('assets/js/waypoint.js') }}"></script>
		<script src="{{ asset('assets/js/counterup.min.js') }}"></script>

		<!-- contact form - jquery include -->
		<script src="{{ asset('assets/js/validate.js') }}"></script>

		<!-- mobile menu - jquery include -->
		<script src="{{ asset('assets/js/mCustomScrollbar.js') }}"></script>

		<!-- google map - jquery include (optional, loaded per page via @push('map_scripts')) -->
		@stack('map_scripts')

		<!-- custom - jquery include -->
		<script src="{{ asset('assets/js/custom.js') }}"></script>

		@stack('scripts')

	</body>
</html>
