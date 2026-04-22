@extends('layouts.app')

@section('title', 'Contact - WidriveU | Nous vous conduisons')

@section('content')


		<!-- breadcrumb_section - start
		================================================== -->
		<section class="breadcrumb_section text-center clearfix">
			<div class="page_title_area has_overlay d-flex align-items-center clearfix" data-bg-image="{{ asset('assets/images/breadcrumb/Tourisme.png') }}">
				<div class="overlay"></div>
				<div class="container" data-aos="fade-up" data-aos-delay="100">
					<h1 class="page_title text-white mb-0">Contactez-nous</h1>
				</div>
			</div>
			<div class="breadcrumb_nav clearfix" data-bg-color="#F2F2F2">
				<div class="container">
					<ul class="ul_li clearfix">
						<li><a href="{{ route('home') }}">Accueil</a></li>
						<li>Contact</li>
					</ul>
				</div>
			</div>
		</section>
		<!-- breadcrumb_section - end
		================================================== -->


		<!-- google_map_section - start
		================================================== -->
		<div class="google_map_section clearfix" data-aos="fade-up" data-aos-delay="100">
			<iframe
				src="https://www.openstreetmap.org/export/embed.html?bbox=2.3612%2C6.3503%2C2.4212%2C6.3903&layer=mapnik&marker=6.3703%2C2.3912"
				width="100%" height="450" style="border:0;display:block;" allowfullscreen loading="lazy"
				title="WidriveU — Cotonou, Bénin"></iframe>
		</div>
		<!-- google_map_section - end
		================================================== -->


		<!-- contact_section - start
		================================================== -->
		<section class="contact_section clearfix">
			<div class="container">
				<div class="contact_details_wrap text-white" data-bg-color="#1F2B3E" data-aos="fade-up" data-aos-delay="100">
					<div class="row justify-content-lg-between">
						<div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
							<div class="image_area">
								
								<p class="mb_30">
									Votre agence de location de véhicules de référence à Cotonou. Avec ou sans chauffeur, nous vous conduisons partout au Bénin.
								</p>
								<div class="image_wrap">
									<img src="{{ asset('assets/images/about/Contact.png') }}" alt="WidriveU Cotonou">
								</div>
							</div>
						</div>

						<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
							<div class="content_area">
								<h3 class="item_title text-white mb_30">Nos coordonnées :</h3>
								<ul class="ul_li_block mb_30 clearfix">
									<li>
										<i class="fas fa-map-marker-alt"></i>
										Cotonou, Bénin
									</li>
									<li><i class="fas fa-clock"></i> Horaires : 6h00 - 22h00 (7j/7)</li>
									<li><i class="fas fa-phone"></i> +229 94 08 08 08</li>
									<li><i class="fas fa-envelope"></i> reservation@widriveu.com</li>
									<li>
										<i class="fab fa-facebook-f"></i>
										<a href="https://www.facebook.com/Widriveu" target="_blank" rel="noopener" style="color:inherit;">facebook.com/Widriveu</a>
									</li>
								</ul>
								<a href="{{ route('fleet') }}" class="custom_btn bg_default_red text-uppercase">
									Voir notre flotte <img src="{{ asset('assets/images/icons/icon_01.png') }}" alt="icon_not_found">
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- contact_section - end
		================================================== -->


		<!-- contact_form_section - start
		================================================== -->
		<section class="contact_form_section sec_ptb_100 clearfix">
			<div class="container">

				<div class="section_title mb_60 text-center" data-aos="fade-up" data-aos-delay="100">
					<h2 class="title_text mb-0">
						<span>Envoyez-nous un message</span>
					</h2>
				</div>

				@if(session('success'))
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
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

				<form id="contact_form" action="{{ route('contact.send') }}" method="POST">
					@csrf
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<div class="form_item" data-aos="fade-up" data-aos-delay="100">
								<input type="text" name="firstname" placeholder="Prénom" value="{{ old('firstname') }}" required>
							</div>
						</div>

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<div class="form_item" data-aos="fade-up" data-aos-delay="200">
								<input type="text" name="lastname" placeholder="Nom de famille" value="{{ old('lastname') }}" required>
							</div>
						</div>

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<div class="form_item" data-aos="fade-up" data-aos-delay="300">
								<input type="email" name="email" placeholder="E-mail" value="{{ old('email') }}" required>
							</div>
						</div>

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<div class="form_item" data-aos="fade-up" data-aos-delay="400">
								<input type="tel" name="phone" placeholder="Numéro de téléphone" value="{{ old('phone') }}">
							</div>
						</div>
					</div>
					<div class="form_item" data-aos="fade-up" data-aos-delay="500">
						<textarea name="message" placeholder="Votre message...">{{ old('message') }}</textarea>
					</div>
					<div class="abtn_wrap text-center clearfix" data-aos="fade-up" data-aos-delay="600">
						<button type="submit" value="submit" class="custom_btn btn_width bg_default_red text-uppercase">Envoyer le message <img src="{{ asset('assets/images/icons/icon_01.png') }}" alt="icon_not_found"></button>
					</div>
				</form>

			</div>
		</section>
		<!-- contact_form_section - end
		================================================== -->


@endsection

