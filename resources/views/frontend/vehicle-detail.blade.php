@extends('layouts.app')

@section('title', $vehicle->name . ' - WidriveU | Location de véhicules au Bénin')

@section('content')


		<!-- breadcrumb_section - start
		================================================== -->
		<section class="breadcrumb_section text-center clearfix">
			<div class="page_title_area has_overlay d-flex align-items-center clearfix" data-bg-image="{{ asset('assets/images/breadcrumb/bg_02.jpg') }}">
				<div class="overlay"></div>
				<div class="container" data-aos="fade-up" data-aos-delay="100">
					<h1 class="page_title text-white mb-0">Détails du véhicule</h1>
				</div>
			</div>
			<div class="breadcrumb_nav clearfix" data-bg-color="#F2F2F2">
				<div class="container">
					<ul class="ul_li clearfix">
						<li><a href="{{ route('home') }}">Accueil</a></li>
						<li><a href="{{ route('fleet') }}">Notre flotte</a></li>
						<li>{{ $vehicle->name }}</li>
					</ul>
				</div>
			</div>
		</section>
		<!-- breadcrumb_section - end
		================================================== -->


		<!-- details_section - start
		================================================== -->
		<div class="details_section sec_ptb_100 pb-0 clearfix">
			<div class="container">
				<div class="row justify-content-lg-between justify-content-md-center justify-content-sm-center">

					<!-- sidebar - start -->
					<div class="col-lg-4 col-md-8 col-sm-10 col-xs-12">
						<aside class="filter_sidebar sidebar_section" data-bg-color="#F2F2F2">
							<div class="sidebar_header" data-bg-gradient="linear-gradient(90deg, #0C0C0F, #292D45)">
								<h3 class="text-white mb-0">Fiche du véhicule</h3>
							</div>
							<div class="sb_widget">

								<!-- Vehicle specs -->
								<div class="sb_widget car_picking" data-aos="fade-up" data-aos-delay="100">
									<h4 class="input_title">Caractéristiques</h4>
									<ul class="info_list ul_li_block clearfix" style="font-size:14px;">
										<li><strong><i class="fas fa-car mr-1"></i> Marque :</strong> {{ $vehicle->brand ?? 'N/A' }}</li>
										<li><strong><i class="fas fa-tag mr-1"></i> Modèle :</strong> {{ $vehicle->model ?? 'N/A' }}</li>
										<li><strong><i class="fas fa-calendar mr-1"></i> Année :</strong> {{ $vehicle->year ?? 'N/A' }}</li>
										<li><strong><i class="fas fa-users mr-1"></i> Places :</strong> {{ $vehicle->seats ?? 'N/A' }}</li>
										<li><strong><i class="fas fa-gas-pump mr-1"></i> Carburant :</strong> {{ ucfirst($vehicle->fuel_type ?? 'N/A') }}</li>
										<li><strong><i class="fas fa-cog mr-1"></i> Transmission :</strong> {{ ucfirst($vehicle->transmission ?? 'N/A') }}</li>
									</ul>
								</div>

								<!-- Pricing -->
								<div class="sb_widget" data-aos="fade-up" data-aos-delay="100">
									<h4 class="input_title">Tarifs</h4>
									<ul class="info_list ul_li_block clearfix" style="font-size:14px;">
										<li>
											<strong><i class="fas fa-user-slash mr-1"></i> Sans chauffeur :</strong><br>
											<span class="bg_default_blue" style="display:inline-block;padding:3px 10px;border-radius:3px;color:#fff;margin-top:3px;">{{ number_format($vehicle->price_without_driver) }} FCFA/Jour</span>
										</li>
										@if($vehicle->price_with_driver)
										<li style="margin-top:10px;">
											<strong><i class="fas fa-user-tie mr-1"></i> Avec chauffeur :</strong><br>
											<span class="bg_default_red" style="display:inline-block;padding:3px 10px;border-radius:3px;color:#fff;margin-top:3px;">{{ number_format($vehicle->price_with_driver) }} FCFA/Jour</span>
										</li>
										@endif
									</ul>
								</div>

								<!-- Reductions -->
								<div class="sb_widget" data-aos="fade-up" data-aos-delay="100">
									<h4 class="input_title">Réductions disponibles</h4>
									<ul class="info_list ul_li_block clearfix" style="font-size:13px;">
										<li><i class="fas fa-tag mr-1" style="color:#860000;"></i> Location 7-13 jours : <strong>-15%</strong></li>
										<li><i class="fas fa-tag mr-1" style="color:#860000;"></i> Location 14-20 jours : <strong>-18%</strong></li>
										<li><i class="fas fa-tag mr-1" style="color:#860000;"></i> Location 21+ jours : <strong>-20%</strong></li>
									</ul>
								</div>

								<!-- Quick contact -->
								<div class="sb_widget" data-aos="fade-up" data-aos-delay="100">
									<h4 class="input_title">Contact rapide</h4>
									<ul class="info_list ul_li_block clearfix" style="font-size:13px;">
										<li><i class="fas fa-phone mr-1"></i> <strong>+229 94 08 08 08</strong></li>
										<li><i class="fas fa-envelope mr-1"></i> reservation@widriveu.com</li>
										<li><i class="fas fa-clock mr-1"></i> 6h00 - 22h00 (7j/7)</li>
									</ul>
								</div>

							</div>
						</aside>
					</div>
					<!-- sidebar - end -->

					<!-- main content - start -->
					<div class="col-lg-8 col-md-8 col-sm-10 col-xs-12">

						<div class="car_choose_carousel mb_30 clearfix">
							<div class="thumbnail_carousel" data-aos="fade-up" data-aos-delay="100">
								<div class="item">
									<div class="item_head">
										<h4 class="item_title mb-0">{{ $vehicle->name }}</h4>
										<ul class="review_text ul_li_right clearfix">
											@if($vehicle->status === 'disponible')
											<li><span class="bg_default_blue">Disponible</span></li>
											@else
											<li><span style="background:#999;padding:3px 8px;color:#fff;border-radius:3px;font-size:11px;">{{ ucfirst($vehicle->status) }}</span></li>
											@endif
										</ul>
									</div>
									<img src="{{ $vehicle->photo_url }}" alt="{{ $vehicle->name }}">
									<ul class="btns_group ul_li_center clearfix">
										<li>
											<span class="custom_btn btn_width bg_default_blue">{{ number_format($vehicle->price_without_driver) }} FCFA/Jour</span>
										</li>
										<li>
											@if($vehicle->status === 'disponible')
											<a href="{{ route('reservation.create', $vehicle) }}" class="custom_btn btn_width btn_outline_red text-uppercase">Réserver <img src="{{ asset('assets/images/icons/fleche-rouge.png') }}" alt="→"></a>
											@else
											<span class="custom_btn btn_width text-uppercase" style="background:#999;cursor:not-allowed;">Non disponible</span>
											@endif
										</li>
									</ul>
								</div>
							</div>
						</div>

						@php $galleryUrls = $vehicle->gallery_urls; @endphp
						@if(count($galleryUrls) > 1)
						<div class="vehicle_gallery clearfix" data-aos="fade-up" data-aos-delay="150" style="margin-bottom:30px;">
							<div style="margin-bottom:10px;">
								<img id="galleryMain" src="{{ $galleryUrls[0] }}" alt="{{ $vehicle->name }}"
								     style="width:100%;height:340px;object-fit:cover;border-radius:6px;border:2px solid #e8e8e8;cursor:pointer;transition:opacity .2s;">
							</div>
							<div style="display:flex;gap:10px;flex-wrap:nowrap;overflow-x:auto;">
								@foreach($galleryUrls as $i => $url)
								<div style="flex:0 0 auto;width:calc(25% - 8px);">
									<img src="{{ $url }}" alt="{{ $vehicle->name }} photo {{ $i + 1 }}"
									     onclick="switchGallery(this, '{{ $url }}')"
									     style="width:100%;height:75px;object-fit:cover;border-radius:5px;cursor:pointer;border:2px solid {{ $i === 0 ? '#860000' : '#e8e8e8' }};transition:border-color .2s;"
									     class="gallery_thumb {{ $i === 0 ? 'active_thumb' : '' }}">
								</div>
								@endforeach
							</div>
						</div>
						@endif

						<div class="car_choose_content" data-aos="fade-up" data-aos-delay="200">

						<!-- Description -->
						@if($vehicle->description)
						@php $descLimit = 120; $descFull = $vehicle->description; $needsTrunc = mb_strlen($descFull) > $descLimit; @endphp
						<div style="margin-bottom:25px;">
							<h4 class="list_title">Description :</h4>
							<p id="desc_short">{{ $needsTrunc ? mb_substr($descFull, 0, $descLimit) . '…' : $descFull }}
							@if($needsTrunc)
							<a href="#" onclick="toggleDesc(event)" style="color:#860000;font-weight:600;white-space:nowrap;">Lire tout</a>
							@endif
							</p>
							@if($needsTrunc)
							<p id="desc_full" style="display:none;">{{ $descFull }}
							<a href="#" onclick="toggleDesc(event)" style="color:#860000;font-weight:600;white-space:nowrap;">Réduire</a>
							</p>
							@endif
						</div>
						@endif

						</div>

					</div>
					<!-- main content - end -->

				</div>
			</div>
		</div>
		<!-- details_section - end
		================================================== -->


		<!-- cars_section - related vehicles
		================================================== -->
		<section class="cars_section sec_ptb_100 clearfix">
			<div class="container" style="margin-bottom:20px;">
				<div class="section_title text-center" data-aos="fade-up" data-aos-delay="100">
					<h2 class="title_text mb-0">
						<span>Autres véhicules disponibles</span>
					</h2>
				</div>
			</div>
			<div class="container">
				<div class="row justify-content-center">
					@foreach($related as $relVehicle)
					<div class="col-lg-4 col-md-6 col-sm-10" data-aos="fade-up" data-aos-delay="100">
						<div class="feature_vehicle_item">
							<h3 class="item_title mb-0">
							<a href="{{ route('vehicle.show', $relVehicle) }}">{{ $relVehicle->name }}</a>
							</h3>
							<div class="item_image position-relative">
							<a class="image_wrap" href="{{ route('vehicle.show', $relVehicle) }}">
							<img src="{{ $relVehicle->photo_url }}" alt="{{ $relVehicle->name }}">
							</a>
							<span class="item_price bg_default_blue">{{ number_format($relVehicle->price_without_driver) }} FCFA/Jour</span>
							</div>
							<ul class="info_list ul_li_center clearfix">
							<li>{{ ucfirst($relVehicle->transmission) }}</li>
							<li>{{ ucfirst($relVehicle->fuel_type) }}</li>
							<li>{{ $relVehicle->seats }} places</li>
							</ul>
						</div>
					</div>
					@endforeach
				</div>
				<div class="text-center" style="padding:40px 0 20px;">
					<a href="{{ route('fleet') }}" class="custom_btn bg_default_red text-uppercase">Voir toute la flotte <img src="{{ asset('assets/images/icons/icon_01.png') }}" alt="icon_not_found"></a>
				</div>
			</div>
		</section>
		<!-- cars_section - end
		================================================== -->


@endsection

@push('scripts')
<script>
function toggleDesc(e) {
    e.preventDefault();
    var short = document.getElementById('desc_short');
    var full  = document.getElementById('desc_full');
    if (full.style.display === 'none') {
        short.style.display = 'none';
        full.style.display  = 'block';
    } else {
        full.style.display  = 'none';
        short.style.display = 'block';
    }
}
function switchGallery(thumb, url) {
    // Update main image
    var main = document.getElementById('galleryMain');
    main.style.opacity = '0';
    setTimeout(function() {
        main.src = url;
        main.style.opacity = '1';
    }, 150);
    // Update active border on thumbnails
    document.querySelectorAll('.gallery_thumb').forEach(function(t) {
        t.style.borderColor = '#e8e8e8';
    });
    thumb.style.borderColor = '#860000';
}
</script>
@endpush
