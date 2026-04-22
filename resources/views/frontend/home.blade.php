@extends('layouts.app')

@section('title', 'WidriveU - Nous vous conduisons | Location de véhicules au Bénin')

@section('header_class', '')

@section('content')


	<!-- slider_section - start
	================================================== -->
	<section class="slider_section text-white text-center position-relative clearfix">
		<div class="main_slider clearfix">
			<div class="item has_overlay d-flex align-items-center" data-bg-image="{{ asset('assets/images/backgrounds/young-attractive-black-businessman-buys-new-car-he-holds-keys-his-hand-dreams-come-true.jpg') }}">
				<div class="overlay"></div>
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
							<div class="slider_content text-center">
								<h3 class="text-white text-uppercase" data-animation="fadeInUp" data-delay=".3s">Location avec ou sans chauffeur</h3>
								<p data-animation="fadeInUp" data-delay=".5s">
									Choisissez votre formule selon vos besoins. Disponible 7j/7 de 6h à 22h pour tous vos déplacements à Cotonou et dans tout le Bénin.
								</p>
								<div class="abtn_wrap clearfix" data-animation="fadeInUp" data-delay=".7s">
									<a class="custom_btn bg_default_red btn_width text-uppercase" href="{{ route('fleet') }}">Réserver maintenant <img src="{{ asset('assets/images/icons/icon_01.png') }}" alt="icon_not_found"></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="item has_overlay d-flex align-items-center" data-bg-image="{{ asset('assets/images/backgrounds/slide3.jpg') }}">
				<div class="overlay"></div>
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
							<div class="slider_content text-center">
								<h3 class="text-white text-uppercase" data-animation="fadeInUp" data-delay=".3s">Des tarifs adaptés à vos besoins</h3>
								<p data-animation="fadeInUp" data-delay=".5s">
									Des réductions allant jusqu'à 20% pour les locations longue durée. Profitez de nos tarifs compétitifs et de notre service de qualité supérieure.
								</p>
								<div class="abtn_wrap clearfix" data-animation="fadeInUp" data-delay=".7s">
									<a class="custom_btn bg_default_red btn_width text-uppercase" href="{{ route('fleet') }}">Voir notre flotte <img src="{{ asset('assets/images/icons/icon_01.png') }}" alt="icon_not_found"></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="item has_overlay d-flex align-items-center" data-bg-image="{{ asset('assets/images/backgrounds/young-cheerful-woman-enjoying-new-car-while-sitting-inside-black-woman-driving-car-girl-wearing-black-costume.jpg') }}">
				<div class="overlay"></div>
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
							<div class="slider_content text-center">
								<h3 class="text-white text-uppercase" data-animation="fadeInUp" data-delay=".3s">Voyagez avec style et confort</h3>
								<p data-animation="fadeInUp" data-delay=".5s">
									WidriveU, l'agence de référence pour la location de véhicules au Bénin. Chauffeurs professionnels, véhicules de qualité pour tous vos déplacements.
								</p>
								<div class="abtn_wrap clearfix" data-animation="fadeInUp" data-delay=".7s">
									<a class="custom_btn bg_default_red btn_width text-uppercase" href="{{ route('fleet') }}">Réserver maintenant <img src="{{ asset('assets/images/icons/icon_01.png') }}" alt="icon_not_found"></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="carousel_nav clearfix">
			<button type="button" class="main_left_arrow"><i class="fal fa-chevron-left"></i></button>
			<button type="button" class="main_right_arrow"><i class="fal fa-chevron-right"></i></button>
		</div>
	</section>
	<!-- slider_section - end
	================================================== -->


	<!-- search_section - start
	================================================== -->
	<section class="search_section clearfix">
		<div class="container">
			<div class="advance_search_form2" data-bg-color="#161829" data-aos="fade-up" data-aos-delay="100">
				<form action="{{ route('fleet') }}" method="GET">
					<div class="row align-items-end">
						<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
							<div class="form_item">
							<h4 class="input_title text-white">Catégorie</h4>
							<select name="category">
							<option value="">Toutes catégories</option>
							<option value="Berline">Berline</option>
							<option value="SUV">SUV</option>
							<option value="4x4">4x4 / Tout-terrain</option>
							<option value="Pick-up">Pick-up</option>
							<option value="Minibus">Minibus</option>
							<option value="Luxe">Luxe</option>
							<option value="Toyota">Toyota</option>
							<option value="Honda">Honda</option>
							<option value="Nissan">Nissan</option>
							<option value="Hyundai">Hyundai</option>
							<option value="Mercedes">Mercedes</option>
							<option value="Autre">Autre</option>
							</select>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
							<div class="form_item">
							<h4 class="input_title text-white">Nombre de places</h4>
							<select name="seats">
							<option value="">Toutes places</option>
							<option value="2">2+ places</option>
							<option value="4">4+ places</option>
							<option value="5">5+ places</option>
							<option value="7">7+ places</option>
							</select>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
							<div class="price-range-area clearfix">
							<h4 class="input_title text-white">Prix max (FCFA/Jour)</h4>
							<div id="slider-range-home" class="slider-range clearfix"></div>
							<input class="price-text" type="text" id="amount_home" name="prix_max" readonly value="{{ request('prix_max', 150000) }}">
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
							<button type="submit" class="custom_btn bg_default_red text-uppercase">Rechercher <img src="{{ asset('assets/images/icons/icon_01.png') }}" alt="icon_not_found"></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</section>
	<!-- search_section - end
	================================================== -->


	<!-- offer_section - start (serial 01 - Notre gamme)
	================================================== -->
	<section class="offer_section sec_ptb_150 clearfix">
		<div class="container">
			<div class="has_serial_number">
				<div class="row justify-content-lg-between">
					<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
						<div class="serial_number text-right" data-aos="fade-up" data-aos-delay="100">
							<span>01</span>
							<h4 class="mb-0">Notre gamme de véhicules</h4>
						</div>
					</div>

					<div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
						<div class="offer_content">
							<h2 class="item_title" data-aos="fade-up" data-aos-delay="100">
								Une flotte moderne pour tous vos besoins
							</h2>
							<p class="mb_30" data-aos="fade-up" data-aos-delay="300">
								WidriveU vous propose une gamme complète de véhicules à Cotonou et dans tout le Bénin. Berlines de ville, SUV tout-terrain, 4x4 robustes, pick-ups ou berlines de luxe — nous avons le véhicule idéal pour vos déplacements professionnels, mariages, événements et voyages touristiques.
							</p>
							<div data-aos="fade-up" data-aos-delay="500">
								<a class="text_btn text-uppercase" href="{{ route('fleet') }}"><span>Découvrir la flotte</span> <img src="{{ asset('assets/images/icons/fleche-rouge.png') }}" alt="icon_not_found"></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- offer_section - end (serial 01)
	================================================== -->


	<!-- cars_section - start (fullscreen carousel)
	================================================== -->
	<section class="cars_section clearfix">
		@if($vehicles->count())
		<div class="offers_car_carousel slideshow4_slider" data-slick='{"dots": false}' data-aos="fade-up" data-aos-delay="100">
			@foreach($vehicles as $vehicle)
			<div class="item">
				<div class="gallery_fullimage_2">
					<img src="{{ $vehicle->photo_url }}" alt="{{ $vehicle->name }}">
					<div class="item_content text-white">
						<span class="item_price bg_default_blue">{{ number_format($vehicle->price_without_driver) }} FCFA/Jour</span>
						<h3 class="item_title text-white">{{ $vehicle->name }}</h3>
						<a class="text_btn text-uppercase" href="{{ route('vehicle.show', $vehicle) }}"><span>Voir le détail</span> <img src="{{ asset('assets/images/icons/fleche-rouge.png') }}" alt="icon_not_found"></a>
					</div>
				</div>
			</div>
			@endforeach
		</div>
		@endif
	</section>
	<!-- cars_section - end
	================================================== -->


	<!-- choose_section - start (serial 02 - Choisissez votre véhicule)
	================================================== -->
	<section class="choose_section sec_ptb_150 clearfix">
		<div class="container">
			<div class="has_serial_number">
				<div class="row justify-content-lg-between">
					<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
						<div class="serial_number text-right" data-aos="fade-up" data-aos-delay="100">
							<span>02</span>
							<h4 class="mb-0">Choisissez votre véhicule</h4>
						</div>
					</div>

					<div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">

						<div class="car_choose_carousel mb_30 clearfix" data-aos="fade-up" data-aos-delay="300">
							<div class="thumbnail_carousel">
								@foreach($vehicles as $vehicle)
								<div class="item">
									<div class="item_head">
										<h4 class="item_title mb-0">{{ $vehicle->name }}</h4>
										<ul class="review_text ul_li_right clearfix">
										<li><span class="bg_default_blue">{{ $vehicle->status === 'disponible' ? 'Disponible' : ucfirst($vehicle->status) }}</span></li>
										</ul>
									</div>
									<img src="{{ $vehicle->photo_url }}" alt="{{ $vehicle->name }}">
									<ul class="btns_group ul_li_center clearfix">
										<li>
											<span class="custom_btn btn_width bg_default_blue">{{ number_format($vehicle->price_without_driver) }} FCFA/Jour</span>
										</li>
										<li>
											<a href="{{ route('vehicle.show', $vehicle) }}" class="custom_btn btn_width btn_outline_red text-uppercase">Réserver <img src="{{ asset('assets/images/icons/fleche-rouge.png') }}" alt="→"></a>
										</li>
									</ul>
								</div>
								@endforeach
							</div>

							<div class="thumbnail_carousel_nav">
								@foreach($vehicles as $vehicle)
								<div class="item">
									<img src="{{ $vehicle->photo_url }}" alt="{{ $vehicle->name }}">
								</div>
								@endforeach
							</div>
						</div>

						@if($vehicles->first())
						@php $featured = $vehicles->first(); @endphp
						<div class="car_choose_content" id="choose_vehicle_info" data-aos="fade-up" data-aos-delay="500">
							<ul class="info_list ul_li_block mb_15 clearfix">
								<li><strong>Passagers :</strong> <span id="cv_seats">{{ $featured->seats }}</span></li>
								<li><strong>Transmission :</strong> <span id="cv_transmission">{{ ucfirst($featured->transmission) }}</span></li>
								<li><strong>Carburant :</strong> <span id="cv_fuel">{{ ucfirst($featured->fuel_type) }}</span></li>
								<li><strong>Prix sans chauffeur :</strong> <span id="cv_price_without">{{ number_format($featured->price_without_driver) }}</span> FCFA/Jour</li>
								<li><strong>Prix avec chauffeur :</strong> <span id="cv_price_with">{{ number_format($featured->price_with_driver) }}</span> FCFA/Jour</li>
							</ul>
							<a class="terms_condition" id="cv_link" href="{{ route('vehicle.show', $featured) }}"><i class="fas fa-info-circle mr-1"></i> Voir tous les détails</a>
						</div>
						@endif

					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- choose_section - end (serial 02)
	================================================== -->


	<!-- feature_section - start (section distincte - Véhicules en vedette)
	================================================== -->
	<section class="feature_section sec_ptb_150 clearfix" data-bg-color="#F2F2F2">
		<div class="container">

			<div class="row justify-content-center">
				<div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
					<div class="section_title mb_60 text-center" data-aos="fade-up" data-aos-delay="100">
						<h2 class="title_text mb_15">
							<span>Véhicules en vedette</span>
						</h2>
						<p class="mb-0">
							Découvrez notre sélection de véhicules disponibles à la location à Cotonou et dans tout le Bénin
						</p>
					</div>
				</div>
			</div>

			<ul class="button-group filters-button-group ul_li_center mb_30 clearfix" data-aos="fade-up" data-aos-delay="300">
				<li><button class="button active" data-filter="*">Tous</button></li>
				<li><button class="button" data-filter=".disponible">Disponible</button></li>
			</ul>

			<div class="feature_vehicle_filter element-grid clearfix">
				@forelse($vehicles as $vehicle)
				<div class="element-item {{ $vehicle->status === 'disponible' ? 'disponible' : 'indisponible' }}" data-category="{{ $vehicle->status }}">
					<div class="feature_vehicle_item" data-aos="fade-up" data-aos-delay="100">
						<h3 class="item_title mb-0">
							<a href="{{ route('vehicle.show', $vehicle) }}">{{ $vehicle->name }}</a>
						</h3>
						<div class="item_image position-relative">
							<a class="image_wrap" href="{{ route('vehicle.show', $vehicle) }}">
								<img src="{{ $vehicle->photo_url }}" alt="{{ $vehicle->name }}">
							</a>
							<span class="item_price bg_default_blue">{{ number_format($vehicle->price_without_driver) }} FCFA/Jour</span>
						</div>
						<ul class="info_list ul_li_center clearfix">
							<li>{{ ucfirst($vehicle->transmission) }}</li>
							<li>{{ ucfirst($vehicle->fuel_type) }}</li>
							<li>{{ $vehicle->seats }} places</li>
						</ul>
					</div>
				</div>
				@empty
				<div class="col-12 text-center">
					<p>Aucun véhicule disponible pour le moment.</p>
				</div>
				@endforelse
			</div>

			<div class="abtn_wrap text-center clearfix" data-aos="fade-up" data-aos-delay="100">
				<a class="custom_btn bg_default_red btn_width text-uppercase" href="{{ route('fleet') }}">Voir toute la flotte <img src="{{ asset('assets/images/icons/icon_01.png') }}" alt="icon_not_found"></a>
			</div>

		</div>
	</section>
	<!-- feature_section - end
	================================================== -->


	<!-- offer_section - start (serial 03 - Effectuez votre réservation)
	================================================== -->
	<section class="offer_section sec_ptb_150 clearfix">
		<div class="container">
			<div class="has_serial_number">
				<div class="row justify-content-lg-between">
					<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
						<div class="serial_number text-right" data-aos="fade-up" data-aos-delay="100">
							<span>03</span>
							<h4 class="mb-0">Effectuez votre réservation</h4>
						</div>
					</div>

					<div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
						<div class="offer_content">
							<h2 class="item_title" data-aos="fade-up" data-aos-delay="100">
								Réserver en 4 étapes simples :
							</h2>
							<p class="mb-0" data-aos="fade-up" data-aos-delay="300">
								Notre processus de réservation est simple, rapide et entièrement en ligne. Payez en toute sécurité via Mobile Money.
							</p>
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
									<div class="offer_info" data-aos="fade-up" data-aos-delay="100">
										<div class="item_icon">
											<i class="fas fa-car"></i>
										</div>
										<div class="item_content">
											<h4 class="item_title">Parcourez la flotte</h4>
											<p class="mb-0">
												Explorez nos véhicules disponibles, comparez les prix et choisissez celui qui correspond à vos besoins.
											</p>
										</div>
									</div>
								</div>

								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
									<div class="offer_info" data-aos="fade-up" data-aos-delay="300">
										<div class="item_icon">
											<i class="fal fa-user-circle"></i>
										</div>
										<div class="item_content">
											<h4 class="item_title">Connectez-vous</h4>
											<p class="mb-0">
												Créez votre compte ou connectez-vous en quelques secondes pour accéder au formulaire de réservation.
											</p>
										</div>
									</div>
								</div>

								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
									<div class="offer_info" data-aos="fade-up" data-aos-delay="500">
										<div class="item_icon">
											<i class="fal fa-calendar-alt"></i>
										</div>
										<div class="item_content">
											<h4 class="item_title">Remplissez le formulaire</h4>
											<p class="mb-0">
												Indiquez vos dates, votre zone de déplacement et choisissez votre option : avec ou sans chauffeur.
											</p>
										</div>
									</div>
								</div>

								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
									<div class="offer_info" data-aos="fade-up" data-aos-delay="700">
										<div class="item_icon">
											<i class="fas fa-mobile-alt"></i>
										</div>
										<div class="item_content">
											<h4 class="item_title">Payez via Mobile Money</h4>
											<p class="mb-0">
												Finalisez votre réservation en payant en toute sécurité via MTN Mobile Money ou Moov Money (Kikiapay).
											</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- offer_section - end (serial 03)
	================================================== -->


	<!-- service_section - start (Pourquoi nous choisir)
	================================================== -->
	<section class="service_section sec_ptb_150 pb-0 mb_100 text-white clearfix" data-bg-gradient="linear-gradient(0deg, #0C0C0F, #292D45)">
		<div class="container">

			<div class="section_title mb_30 text-center" data-aos="fade-up" data-aos-delay="100">
				<h2 class="title_text text-white mb-0">
					<span>Pourquoi nous choisir ?</span>
				</h2>
			</div>

			<div class="row justify-content-center">
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="service_primary text-center text-white" data-aos="fade-up" data-aos-delay="100">
						<div class="item_icon">
							<i class="far fa-shield-alt"></i>
						</div>
						<h3 class="item_title text-white">Paiement Mobile Money Sécurisé</h3>
						<p class="mb-0">
							Payez en toute sécurité via MTN Mobile Money ou Moov Money. Transactions rapides et fiables.
						</p>
					</div>
				</div>

				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="service_primary text-center text-white" data-aos="fade-up" data-aos-delay="300">
						<div class="item_icon">
							<i class="fal fa-headset"></i>
						</div>
						<h3 class="item_title text-white">Service 7j/7 de 6h à 22h</h3>
						<p class="mb-0">
							Notre équipe est disponible tous les jours de la semaine pour vous servir de 6h du matin à 22h le soir.
						</p>
					</div>
				</div>

				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="service_primary text-center text-white" data-aos="fade-up" data-aos-delay="500">
						<div class="item_icon">
							<i class="fas fa-user-tie"></i>
						</div>
						<h3 class="item_title text-white">Chauffeurs Professionnels</h3>
						<p class="mb-0">
							Des chauffeurs qualifiés, courtois et expérimentés pour vous offrir un transport en toute sécurité.
						</p>
					</div>
				</div>

				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="service_primary text-center text-white" data-aos="fade-up" data-aos-delay="100">
						<div class="item_icon">
							<i class="fas fa-tools"></i>
						</div>
						<h3 class="item_title text-white">Véhicules Entretenus</h3>
						<p class="mb-0">
							Notre flotte est régulièrement entretenue et contrôlée pour garantir votre sécurité et confort à tout moment.
						</p>
					</div>
				</div>

				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="service_primary text-center text-white" data-aos="fade-up" data-aos-delay="300">
						<div class="item_icon">
							<i class="fas fa-mobile-alt"></i>
						</div>
						<h3 class="item_title text-white">Réservation en Ligne Simple</h3>
						<p class="mb-0">
							Réservez votre véhicule en quelques clics depuis notre site ou contactez-nous par téléphone ou WhatsApp.
						</p>
					</div>
				</div>

				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="service_primary text-center text-white" data-aos="fade-up" data-aos-delay="500">
						<div class="item_icon">
							<i class="fas fa-percent"></i>
						</div>
						<h3 class="item_title text-white">Réductions sur Long Séjour</h3>
						<p class="mb-0">
							Bénéficiez de réductions allant jusqu'à 20% pour les locations de longue durée. Plus vous louez, plus vous économisez.
						</p>
					</div>
				</div>
			</div>

			<div class="feature_carousel_wrap position-relative clearfix">
				<div class="slideshow1_slider" data-aos="fade-up" data-aos-delay="100">
					@foreach($vehicles->take(3) as $vehicle)
					<div class="item">
						<div class="feature_fullimage">
							<img src="{{ $vehicle->photo_url }}" alt="{{ $vehicle->name }}">
							<div class="item_content text-white">
								<span class="item_price bg_default_blue">{{ number_format($vehicle->price_without_driver) }} FCFA/Jour</span>
								<h3 class="item_title text-white">{{ $vehicle->name }}</h3>
								<a class="text_btn text-uppercase" href="{{ route('vehicle.show', $vehicle) }}"><span>Réserver</span> <img src="{{ asset('assets/images/icons/fleche-rouge.png') }}" alt="icon_not_found"></a>
							</div>
						</div>
					</div>
					@endforeach
				</div>

				<div class="carousel_nav">
					<button type="button" class="s1_left_arrow"><i class="fal fa-angle-left"></i></button>
					<button type="button" class="s1_right_arrow"><i class="fal fa-angle-right"></i></button>
				</div>
			</div>

		</div>
	</section>
	<!-- service_section - end
	================================================== -->


	<!-- offer_section - start (serial 04 - Suivez votre réservation)
	================================================== -->
	<section class="offer_section sec_ptb_150 clearfix">
		<div class="container">
			<div class="has_serial_number">
				<div class="row justify-content-lg-between">
					<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
						<div class="serial_number text-right" data-aos="fade-up" data-aos-delay="100">
							<span>04</span>
							<h4 class="mb-0">Suivez votre réservation</h4>
						</div>
					</div>

					<div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
						<div class="offer_content">
							<h2 class="item_title" data-aos="fade-up" data-aos-delay="100">
								Gérez tout depuis votre tableau de bord :
							</h2>
							<p class="mb_30" data-aos="fade-up" data-aos-delay="300">
								Une fois votre réservation confirmée, accédez à votre espace personnel pour suivre l'état de votre location en temps réel, consulter l'historique de vos réservations et gérer vos prochains voyages.
							</p>
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
									<div class="offer_info" data-aos="fade-up" data-aos-delay="100">
										<div class="item_icon">
											<i class="fal fa-clock"></i>
										</div>
										<div class="item_content">
											<h4 class="item_title">Compte à rebours en direct</h4>
											<p class="mb-0">
												Visualisez le temps restant avant le début et la fin de votre location directement sur votre tableau de bord.
											</p>
										</div>
									</div>
								</div>

								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
									<div class="offer_info" data-aos="fade-up" data-aos-delay="300">
										<div class="item_icon">
											<i class="fal fa-list-alt"></i>
										</div>
										<div class="item_content">
											<h4 class="item_title">Historique complet</h4>
											<p class="mb-0">
												Retrouvez toutes vos réservations passées, en cours et à venir avec leurs détails et statuts.
											</p>
										</div>
									</div>
								</div>

								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
									<div class="offer_info" data-aos="fade-up" data-aos-delay="500">
										<div class="item_icon">
											<i class="fal fa-bell"></i>
										</div>
										<div class="item_content">
											<h4 class="item_title">Statut en temps réel</h4>
											<p class="mb-0">
												Suivez l'évolution de votre réservation : en attente, active, terminée — toujours informé.
											</p>
										</div>
									</div>
								</div>

								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
									<div class="offer_info" data-aos="fade-up" data-aos-delay="700">
										<div class="item_icon">
											<i class="fal fa-sync-alt"></i>
										</div>
										<div class="item_content">
											<h4 class="item_title">Prolongation facile</h4>
											<p class="mb-0">
												Besoin de prolonger votre location ? Faites-le directement depuis votre espace client en quelques clics.
											</p>
										</div>
									</div>
								</div>
							</div>

							<div data-aos="fade-up" data-aos-delay="800" style="margin-top:30px;">
								@auth
								<a class="custom_btn bg_default_red text-uppercase" href="{{ route('dashboard') }}">
									Mon tableau de bord <img src="{{ asset('assets/images/icons/icon_01.png') }}" alt="icon_not_found">
								</a>
								@else
								<a class="custom_btn bg_default_red text-uppercase" href="{{ route('register') }}">
									Créer mon compte <img src="{{ asset('assets/images/icons/icon_01.png') }}" alt="icon_not_found">
								</a>
								@endauth
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- offer_section - end (serial 04)
	================================================== -->


	<!-- testimonial_section - start (section indépendante, sans numéro)
	================================================== -->
	<section class="testimonial_section sec_ptb_150 clearfix" data-bg-color="#F2F2F2">
		<div class="container">

			<div class="row justify-content-center">
				<div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
					<div class="section_title mb_60 text-center" data-aos="fade-up" data-aos-delay="100">
						<h2 class="title_text mb_15">
							<span>Avis de nos clients</span>
						</h2>
						<p class="mb-0">Ce que disent ceux qui nous ont fait confiance</p>
					</div>
				</div>
			</div>

			<div class="testimonial_carousel_wrap position-relative">
				<div class="testimonial_carousel" data-slick='{"dots": false}' data-aos="fade-up" data-aos-delay="300">
					<div class="item">
						<div class="testimonial_item2 text-center">
							<p class="mb_30">
								"J'ai utilisé les services de WidriveU pour mon mariage à Cotonou. Le chauffeur était ponctuel, courtois et le véhicule impeccable. Je recommande vivement cette agence pour tous vos événements spéciaux !"
							</p>
							<div class="admin_info">
								<div class="admin_image">
									<img src="{{ asset('assets/images/meta/pppp.jpg') }}" alt="image_not_found">
								</div>
								<h4 class="admin_name">Jojo le comédien</h4>
								<span style="color:#777;font-size:13px;">Client</span>
								<ul class="rating_star ul_li_center clearfix">
									<li class="active"><i class="fas fa-star"></i></li>
									<li class="active"><i class="fas fa-star"></i></li>
									<li class="active"><i class="fas fa-star"></i></li>
									<li class="active"><i class="fas fa-star"></i></li>
									<li class="active"><i class="fas fa-star"></i></li>
								</ul>
							</div>
						</div>
					</div>

					<div class="item">
						<div class="testimonial_item2 text-center">
							<p class="mb_30">
								"Excellent service ! J'ai loué un véhicule avec chauffeur pour une semaine pour mes déplacements professionnels. Très professionnel, toujours à l'heure et le tarif était très raisonnable. Je reviendrai sans hésiter."
							</p>
							<div class="admin_info">
								<div class="admin_image">
									<img src="{{ asset('assets/images/meta/images (4).jpg') }}" alt="image_not_found">
								</div>
								<h4 class="admin_name">Axel Merryl</h4>
								<span style="color:#777;font-size:13px;">Client</span>
								<ul class="rating_star ul_li_center clearfix">
									<li class="active"><i class="fas fa-star"></i></li>
									<li class="active"><i class="fas fa-star"></i></li>
									<li class="active"><i class="fas fa-star"></i></li>
									<li class="active"><i class="fas fa-star"></i></li>
									<li><i class="fas fa-star"></i></li>
								</ul>
							</div>
						</div>
					</div>

					<div class="item">
						<div class="testimonial_item2 text-center">
							<p class="mb_30">
								"WidriveU a organisé le transport pour notre événement d'entreprise avec plusieurs véhicules. Tout s'est déroulé parfaitement, coordination impeccable et équipe très réactive. Merci pour votre professionnalisme !"
							</p>
							<div class="admin_info">
								<div class="admin_image">
									<img src="{{ asset('assets/images/meta/shade.jpg') }}" alt="image_not_found">
								</div>
								<h4 class="admin_name">Shadé Store</h4>
								<span style="color:#777;font-size:13px;">Cliente</span>
								<ul class="rating_star ul_li_center clearfix">
									<li class="active"><i class="fas fa-star"></i></li>
									<li class="active"><i class="fas fa-star"></i></li>
									<li class="active"><i class="fas fa-star"></i></li>
									<li class="active"><i class="fas fa-star"></i></li>
									<li class="active"><i class="fas fa-star"></i></li>
								</ul>
							</div>
						</div>
					</div>
				</div>

				<div class="carousel_nav position_ycenter">
					<button type="button" class="ts_left_arrow"><i class="fal fa-angle-left"></i></button>
					<button type="button" class="ts_right_arrow"><i class="fal fa-angle-right"></i></button>
				</div>
			</div>

		</div>
	</section>
	<!-- testimonial_section - end
	================================================== -->


@endsection

@push('scripts')
<script>
$(function() {
	if (typeof $.fn.slider !== 'undefined') {
		$("#slider-range-home").slider({
			range: "min",
			min: 5000,
			max: 300000,
			step: 5000,
			value: parseInt($("#amount_home").val()) || 150000,
			slide: function(event, ui) {
				$("#amount_home").val(ui.value);
			}
		});
		if (!$("#amount_home").val()) {
			$("#amount_home").val($("#slider-range-home").slider("value"));
		}
	}

	// Sync vehicle info panel with thumbnail carousel
	var vehiclesData = @php
		$vData = $vehicles->map(fn($v) => [
			'seats'         => $v->seats,
			'transmission'  => ucfirst($v->transmission),
			'fuel_type'     => ucfirst($v->fuel_type),
			'price_without' => number_format($v->price_without_driver),
			'price_with'    => number_format($v->price_with_driver),
			'url'           => route('vehicle.show', $v),
		])->values();
		echo json_encode($vData);
	@endphp;

	function updateVehicleInfo(index) {
		var v = vehiclesData[index];
		if (!v) return;
		$('#cv_seats').text(v.seats);
		$('#cv_transmission').text(v.transmission);
		$('#cv_fuel').text(v.fuel_type);
		$('#cv_price_without').text(v.price_without);
		$('#cv_price_with').text(v.price_with);
		$('#cv_link').attr('href', v.url);
	}

	$('.thumbnail_carousel').on('afterChange', function(e, slick, currentSlide) {
		updateVehicleInfo(currentSlide);
	});
});
</script>
@endpush
