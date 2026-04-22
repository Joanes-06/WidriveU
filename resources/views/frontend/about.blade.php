@extends('layouts.app')

@section('title', 'A propos - WidriveU | Nous vous conduisons')

@section('content')


		<!-- breadcrumb_section - start
		================================================== -->
		<section class="breadcrumb_section text-center clearfix">
			<div class="page_title_area has_overlay d-flex align-items-center clearfix" data-bg-image="{{ asset('assets/images/breadcrumb/Tourisme.png') }}">
				<div class="overlay"></div>
				<div class="container" data-aos="fade-up" data-aos-delay="100">
					<h1 class="page_title text-white mb-0">A propos de WidriveU</h1>
				</div>
			</div>
			<div class="breadcrumb_nav clearfix" data-bg-color="#F2F2F2">
				<div class="container">
					<ul class="ul_li clearfix">
						<li><a href="{{ route('home') }}">Accueil</a></li>
						<li>A propos</li>
					</ul>
				</div>
			</div>
		</section>
		<!-- breadcrumb_section - end
		================================================== -->


		<!-- about_story_section - start
		================================================== -->
		<section class="sec_ptb_100 clearfix" style="background:#fff;">
			<div class="container">
				<div class="row align-items-center justify-content-between">

					<!-- Image gauche -->
					<div class="col-lg-6 col-md-12" data-aos="fade-right" data-aos-delay="100">
						<div style="position:relative;">
							<img src="{{ asset('assets/images/blog/quiSommes.jpg') }}" alt="WidriveU - Location de véhicules au Bénin"
							     style="width:100%;height:480px;object-fit:cover;border-radius:8px;">
							<div style="position:absolute;bottom:30px;left:-20px;background:#860000;color:#fff;padding:18px 28px;border-radius:6px;box-shadow:0 8px 30px rgba(234,0,30,.25);">
								<span style="font-size:32px;font-weight:800;display:block;line-height:1;">2019</span>
								<span style="font-size:13px;font-weight:600;letter-spacing:1px;text-transform:uppercase;">Année de création</span>
							</div>
						</div>
					</div>

					<!-- Contenu droit -->
					<div class="col-lg-6 col-md-12" data-aos="fade-left" data-aos-delay="200" style="margin-top:40px;">
						<p style="font-size:12px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:#860000;margin-bottom:12px;">WIDRIVEU</p>
						<h2 class="title_text" style="font-size:48px;font-weight:500;line-height:1.2;color:#0A0F1E;margin-bottom:24px;">
							Une mobilité fiable, <br>née pour le Bénin
						</h2>
					
						<p style="font-size:18px;color:#555;line-height:1.8;margin-bottom:16px;">
							WidriveU est née d'une conviction simple : chaque trajet mérite un véhicule sûr, propre et une expérience irréprochable. Fondée à Cotonou, notre agence a été créée pour répondre aux besoins croissants de mobilité au Bénin avec des standards élevés.
						</p>
						<p style="font-size:18px;color:#555;line-height:1.8;margin-bottom:16px;">
							Que vous soyez professionnel en déplacement, touriste souhaitant explorer le pays, ou famille cherchant un véhicule spacieux pour un événement, WidriveU vous offre une flotte diversifiée — berlines, SUV, 4x4, pick-up et minibus — disponible avec ou sans chauffeur.
						</p>
						<p style="font-size:18px;color:#555;line-height:1.8;margin-bottom:30px;">
							Basée à Cotonou et opérant sur l'ensemble du territoire béninois, notre équipe est joignable 7j/7 de 6h à 22h. Nous acceptons les paiements via MTN Mobile Money et Moov Money pour une expérience simple et sans friction, du premier contact à la remise des clés.
						</p>
						<div style="display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
							<a href="{{ route('fleet') }}" class="custom_btn bg_default_red text-uppercase">
								Voir notre flotte <img src="{{ asset('assets/images/icons/icon_01.png') }}" alt="icon_not_found">
							</a>
						</div>
					</div>

				</div>
			</div>
		</section>
		<!-- about_story_section - end
		================================================== -->


		<!-- service_section - start
		================================================== -->
		<section class="service_section sec_ptb_150 clearfix">
			<div class="container">

				<div class="section_title mb_30 text-center" data-aos="fade-up" data-aos-delay="100">
					<h2 class="title_text mb-0">
						<span>Pourquoi choisir WidriveU ?</span>
					</h2>
				</div>

				<div class="row justify-content-center">
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
						<div class="service_primary text-center" data-aos="fade-up" data-aos-delay="100">
							<div class="item_icon">
								<i class="far fa-shield-alt"></i>
							</div>
							<h3 class="item_title">Paiement Mobile Money Sécurisé</h3>
							<p class="mb-0">
								Payez en toute sécurité via MTN Mobile Money ou Moov Money. Transactions rapides et fiables pour votre tranquillité.
							</p>
						</div>
					</div>

					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
						<div class="service_primary text-center" data-aos="fade-up" data-aos-delay="300">
							<div class="item_icon">
								<i class="fal fa-headset"></i>
							</div>
							<h3 class="item_title">Service 7j/7 de 6h à 22h</h3>
							<p class="mb-0">
								Notre équipe est disponible tous les jours de la semaine pour vous servir de 6h du matin à 22h le soir.
							</p>
						</div>
					</div>

					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
						<div class="service_primary text-center" data-aos="fade-up" data-aos-delay="500">
							<div class="item_icon">
								<i class="fas fa-user-tie"></i>
							</div>
							<h3 class="item_title">Chauffeurs Professionnels</h3>
							<p class="mb-0">
								Des chauffeurs qualifiés, formés et expérimentés pour vous offrir un transport sécurisé et confortable.
							</p>
						</div>
					</div>

					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
						<div class="service_primary text-center" data-aos="fade-up" data-aos-delay="100">
							<div class="item_icon">
								<i class="fas fa-tools"></i>
							</div>
							<h3 class="item_title">Véhicules Entretenus</h3>
							<p class="mb-0">
								Notre flotte est régulièrement entretenue et contrôlée pour garantir votre sécurité et votre confort à tout moment.
							</p>
						</div>
					</div>

					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
						<div class="service_primary text-center" data-aos="fade-up" data-aos-delay="300">
							<div class="item_icon">
								<i class="fas fa-mobile-alt"></i>
							</div>
							<h3 class="item_title">Réservation en Ligne Simple</h3>
							<p class="mb-0">
								Réservez votre véhicule en quelques clics depuis notre site ou contactez-nous directement par téléphone ou WhatsApp.
							</p>
						</div>
					</div>

					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
						<div class="service_primary text-center" data-aos="fade-up" data-aos-delay="500">
							<div class="item_icon">
								<i class="fas fa-percent"></i>
							</div>
							<h3 class="item_title">Réductions sur Long Séjour</h3>
							<p class="mb-0">
								Bénéficiez de réductions allant jusqu'à 20% pour les locations de longue durée. Plus vous louez, plus vous économisez.
							</p>
						</div>
					</div>
				</div>

			</div>
		</section>
		<!-- service_section - end
		================================================== -->


		<!-- gallery_section - start
		================================================== -->
		<section class="gallery_section clearfix">
			<div class="updown_style_wrap minus_bottom">
				<div class="updown_style">
					<div class="gallery_fullimage" data-aos="fade-up" data-aos-delay="100">
						<img src="{{ asset('assets/images/blog/ChauffeurPro.png') }}" alt="Location avec chauffeur">
						<div class="item_content text-white">
							<h3 class="item_title text-white">Location avec chauffeur</h3>
							<p>
								Profitez de la tranquillité d'esprit avec notre service de location avec chauffeur. Nos conducteurs professionnels vous emmènent à destination en toute sécurité, que ce soit pour vos réunions d'affaires, vos visites touristiques ou vos événements.
							</p>
							<a class="text_btn text-uppercase" href="{{ route('fleet') }}"><span>Voir notre flotte</span> <img src="{{ asset('assets/images/icons/fleche-rouge.png') }}" alt="icon_not_found"></a>
						</div>
					</div>

					<div class="gallery_fullimage" data-aos="fade-up" data-aos-delay="300">
						<img src="{{ asset('assets/images/blog/SansChauffeur.png') }}" alt="Location sans chauffeur">
						<div class="item_content text-white">
							<h3 class="item_title text-white">Location sans chauffeur</h3>
							<p>
								Vous préférez conduire vous-même ? Choisissez parmi notre large sélection de véhicules disponibles à la location sans chauffeur. Des berlines aux SUV, nous avons le véhicule parfait pour votre liberté de mouvement.
							</p>
							<a class="text_btn text-uppercase" href="{{ route('fleet') }}"><span>Voir notre flotte</span> <img src="{{ asset('assets/images/icons/fleche-rouge.png') }}" alt="icon_not_found"></a>
						</div>
					</div>
				</div>

				<div class="updown_style">
					<div class="gallery_fullimage" data-aos="fade-up" data-aos-delay="100">
						<img src="{{ asset('assets/images/blog/Mariage.png') }}" alt="Transport pour mariages et événements">
						<div class="item_content text-white">
							<h3 class="item_title text-white">Mariages et événements</h3>
							<p>
								Faites de votre jour spécial un moment inoubliable avec WidriveU. Nous proposons des services de transport luxueux pour les mariages, baptêmes, cérémonies et tous types d'événements avec une flotte de véhicules élégants.
							</p>
							<a class="text_btn text-uppercase" href="{{ route('contact') }}"><span>Nous contacter</span> <img src="{{ asset('assets/images/icons/fleche-rouge.png') }}" alt="icon_not_found"></a>
						</div>
					</div>

					<div class="gallery_fullimage" data-aos="fade-up" data-aos-delay="300">
						<img src="{{ asset('assets/images/blog/Decouverte.png') }}" alt="Tourisme et découverte du Bénin">
						<div class="item_content text-white">
							<h3 class="item_title text-white">Tourisme et découverte</h3>
							<p>
								Découvrez les merveilles du Bénin avec WidriveU. Que vous souhaitiez visiter Ouidah, Abomey, Pendjari ou les plages de Grand-Popo, nous organisons vos circuits touristiques avec des chauffeurs-guides expérimentés.
							</p>
							<a class="text_btn text-uppercase" href="{{ route('contact') }}"><span>Planifier un circuit</span> <img src="{{ asset('assets/images/icons/fleche-rouge.png') }}" alt="icon_not_found"></a>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- gallery_section - end
		================================================== -->


		<!-- funfact_section - start
		================================================== -->
		<section class="funfact_section sec_ptb_150 clearfix" data-bg-gradient="linear-gradient(0deg, #0C0C0F, #292D45)">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<div class="funfact_item text-center text-white" data-aos="fade-up" data-aos-delay="100">
							<h3 class="counter_text text-white mb-0"><span class="counter">500</span>+</h3>
							<small class="line bg_default_red"></small>
							<p class="item_title mb-0">Clients satisfaits</p>
						</div>
					</div>

					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<div class="funfact_item text-center text-white" data-aos="fade-up" data-aos-delay="300">
							<h3 class="counter_text text-white mb-0"><span class="counter">1000</span>+</h3>
							<small class="line bg_default_red"></small>
							<p class="item_title mb-0">Réservations effectuées</p>
						</div>
					</div>

					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<div class="funfact_item text-center text-white" data-aos="fade-up" data-aos-delay="500">
							<h3 class="counter_text text-white mb-0"><span class="counter">50</span>+</h3>
							<small class="line bg_default_red"></small>
							<p class="item_title mb-0">Véhicules disponibles</p>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- funfact_section - end
		================================================== -->


		<!-- testimonial_section - start
		================================================== -->
		<section class="testimonial_section sec_ptb_150 clearfix">
			<div class="container">

				<div class="section_title mb_60 text-center" data-aos="fade-up" data-aos-delay="100">
					<h2 class="title_text mb-0">
						<span>Avis de nos clients</span>
					</h2>
				</div>

				<div class="testimonial_carousel_wrap position-relative">
					<div class="testimonial_carousel" data-slick='{"dots": false}' data-aos="fade-up" data-aos-delay="300">
						<div class="item">
							<div class="testimonial_item2 text-center">
								<p class="mb_30">
									"J'ai utilisé les services de WidriveU pour mon mariage à Cotonou. Le chauffeur était ponctuel, courtois et le véhicule absolument impeccable. Je recommande vivement cette agence pour tous vos événements spéciaux !"
								</p>
								<div class="admin_info">
									<div class="admin_image">
										<img src="{{ asset('assets/images/meta/pppp.jpg') }}" alt="image_not_found">
									</div>
									<h4 class="admin_name">Jojo le comédien</h4>
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
									"WidriveU a géré le transport pour notre événement d'entreprise avec plusieurs véhicules. Tout s'est déroulé parfaitement, coordination impeccable et équipe très réactive. Merci pour votre professionnalisme !"
								</p>
								<div class="admin_info">
									<div class="admin_image">
										<img src="{{ asset('assets/images/meta/shade.jpg') }}" alt="image_not_found">
									</div>
									<h4 class="admin_name">Shadé Store</h4>
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
