@extends('layouts.app')

@section('title', 'Notre Flotte - WidriveU | Location de véhicules au Bénin')

@push('styles')
<style>
	.item_shorting .nice-select .list {
		z-index: 999 !important;
	}
	/* Fix dropdown overlap in sidebar */
	.filter_sidebar,
	.filter_sidebar .sb_widget,
	.filter_sidebar aside {
		overflow: visible !important;
	}
	.filter_sidebar .sb_widget {
		position: relative;
	}
	.filter_sidebar .sb_widget:nth-child(1) { z-index: 50; }
	.filter_sidebar .sb_widget:nth-child(2) { z-index: 40; }
	.filter_sidebar .sb_widget:nth-child(3) { z-index: 30; }
	.filter_sidebar .sb_widget:nth-child(4) { z-index: 20; }
	.filter_sidebar .sb_widget:nth-child(5) { z-index: 10; }
	.filter_sidebar .nice-select .list {
		z-index: 9999 !important;
		position: absolute;
	}
</style>
@endpush

@section('content')


	<!-- breadcrumb_section - start
	================================================== -->
	<section class="breadcrumb_section text-center clearfix">
		<div class="page_title_area has_overlay d-flex align-items-center clearfix" data-bg-image="{{ asset('assets/images/breadcrumb/Tourisme.png') }}">
			<div class="overlay"></div>
			<div class="container" data-aos="fade-up" data-aos-delay="100">
				<h1 class="page_title text-white mb-0">Notre Flotte</h1>
			</div>
		</div>
		<div class="breadcrumb_nav clearfix" data-bg-color="#F2F2F2">
			<div class="container">
				<ul class="ul_li clearfix">
					<li><a href="{{ route('home') }}">Accueil</a></li>
					<li>Notre flotte</li>
				</ul>
			</div>
		</div>
	</section>
	<!-- breadcrumb_section - end
	================================================== -->


	<!-- car_section - start
	================================================== -->
	<div class="car_section sec_ptb_100 clearfix">
		<div class="container">
			<div class="row justify-content-lg-between justify-content-md-center justify-content-sm-center">

				<!-- sidebar - start -->
				<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
					<aside class="filter_sidebar sidebar_section" data-bg-color="#F2F2F2">
						<div class="sidebar_header" data-bg-gradient="linear-gradient(90deg, #0C0C0F, #292D45)">
							<h3 class="text-white mb-0">Filtrer les véhicules</h3>
						</div>
						<div class="sb_widget">
							<form action="{{ route('fleet') }}" method="GET" id="filter-form">

								<div class="sb_widget price-range-area clearfix" data-aos="fade-up" data-aos-delay="100">
									<h4 class="input_title">Prix max (FCFA/Jour)</h4>
									<div id="slider-range" class="slider-range clearfix"></div>
									<span class="price-text" id="amount_display"></span>
									<input type="hidden" id="amount" name="prix_max" value="{{ request('prix_max', 150000) }}">
								</div>

								<div class="sb_widget car_picking" data-aos="fade-up" data-aos-delay="100">
									<div class="form_item">
										<h4 class="input_title">Rechercher par nom</h4>
										<input type="text" name="search" placeholder="Nom du véhicule..." value="{{ request('search') }}">
									</div>
								</div>


								<div class="sb_widget" data-aos="fade-up" data-aos-delay="100">
									<div class="form_item">
									<h4 class="input_title">Catégorie</h4>
									<select name="category">
									<option value="">Toutes catégories</option>
									<option value="Berline" {{ request('category') == 'Berline' ? 'selected' : '' }}>Berline</option>
									<option value="SUV" {{ request('category') == 'SUV' ? 'selected' : '' }}>SUV</option>
									<option value="4x4" {{ request('category') == '4x4' ? 'selected' : '' }}>4x4 / Tout-terrain</option>
									<option value="Pick-up" {{ request('category') == 'Pick-up' ? 'selected' : '' }}>Pick-up</option>
									<option value="Minibus" {{ request('category') == 'Minibus' ? 'selected' : '' }}>Minibus</option>
									<option value="Luxe" {{ request('category') == 'Luxe' ? 'selected' : '' }}>Luxe</option>
									<option value="Autre" {{ request('category') == 'Autre' ? 'selected' : '' }}>Autre</option>
									</select>
									</div>
								</div>

														{{-- Filtre marque --}}
								<div class="sb_widget" data-aos="fade-up" data-aos-delay="100">
									<div class="form_item">
									<h4 class="input_title">Marque</h4>
									<select name="brand">
									<option value="">Toutes les marques</option>
									@foreach($brands as $b)
									<option value="{{ $b }}" {{ request('brand') == $b ? 'selected' : '' }}>{{ $b }}</option>
									@endforeach
									</select>
									</div>
								</div>
								<div class="sb_widget" data-aos="fade-up" data-aos-delay="100">
									<h4 class="input_title">Nombre de places :</h4>
									<div class="row">
										<div class="col-lg-6">
											<div class="checkbox_input">
												<label for="seats_all"><input type="radio" id="seats_all" name="seats" value="" {{ !request('seats') ? 'checked' : '' }}> Toutes</label>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="checkbox_input">
												<label for="seats_5"><input type="radio" id="seats_5" name="seats" value="5" {{ request('seats') == '5' ? 'checked' : '' }}> 5</label>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="checkbox_input">
												<label for="seats_4"><input type="radio" id="seats_4" name="seats" value="4" {{ request('seats') == '4' ? 'checked' : '' }}> 4</label>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="checkbox_input">
												<label for="seats_7"><input type="radio" id="seats_7" name="seats" value="7" {{ request('seats') == '7' ? 'checked' : '' }}> 7 ou +</label>
											</div>
										</div>
									</div>
								</div>

								<div class="sb_widget" data-aos="fade-up" data-aos-delay="100">
									<div class="form_item">
										<select name="transmission">
											<option data-display="Transmission" value="">Toutes transmissions</option>
											<option value="manuelle" {{ request('transmission') == 'manuelle' ? 'selected' : '' }}>Manuelle</option>
											<option value="automatique" {{ request('transmission') == 'automatique' ? 'selected' : '' }}>Automatique</option>
										</select>
									</div>

									<div class="form_item">
										<select name="fuel_type">
											<option data-display="Carburant" value="">Tous carburants</option>
											<option value="essence" {{ request('fuel_type') == 'essence' ? 'selected' : '' }}>Essence</option>
											<option value="diesel" {{ request('fuel_type') == 'diesel' ? 'selected' : '' }}>Diesel</option>
											<option value="electrique" {{ request('fuel_type') == 'electrique' ? 'selected' : '' }}>Électrique</option>
											<option value="hybride" {{ request('fuel_type') == 'hybride' ? 'selected' : '' }}>Hybride</option>
										</select>
									</div>
								</div>

								<hr data-aos="fade-up" data-aos-delay="100">

								<div data-aos="fade-up" data-aos-delay="100">
									<button type="submit" class="custom_btn bg_default_red text-uppercase" style="width:100%;margin-bottom:12px;">Appliquer les filtres <img src="{{ asset('assets/images/icons/icon_01.png') }}" alt="icon_not_found"></button>
									<a href="{{ route('fleet') }}" style="display:block;text-align:center;color:#999;font-size:13px;font-weight:600;letter-spacing:1px;padding:8px 0;text-transform:uppercase;"><i class="fal fa-times" style="margin-right:5px;"></i> Effacer les filtres</a>
								</div>

							</form>
						</div>
					</aside>
				</div>
				<!-- sidebar - end -->

				<!-- main content - start -->
				<div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">

					<div class="item_shorting clearfix" data-aos="fade-up" data-aos-delay="100" style="position:relative;z-index:100;">
						<div class="row align-items-center justify-content-lg-between">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<span class="item_available">
									{{ $vehicles->total() }} véhicule(s) disponible(s)
									@if(request()->hasAny(['search', 'transmission', 'fuel_type', 'seats', 'prix_max', 'category', 'brand']))
									— <a href="{{ route('fleet') }}" style="color:#860000;font-size:13px;"><i class="fas fa-times"></i> Effacer les filtres</a>
									@endif
								</span>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<form action="{{ route('fleet') }}" method="GET" id="sort-form">
									@foreach(request()->except('sort') as $key => $val)
									<input type="hidden" name="{{ $key }}" value="{{ $val }}">
									@endforeach
									<div class="form_item mb-0">
										<select name="sort" onchange="document.getElementById('sort-form').submit()">
											<option data-display="Trier par" value="">Tri par défaut</option>
											<option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
											<option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
											<option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nom A-Z</option>
										</select>
									</div>
								</form>
							</div>
						</div>
					</div>

					<div class="row">
						@forelse($vehicles as $vehicle)
						<div class="col-lg-6 col-md-6">
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
									<li>{{ $vehicle->year }}</li>
								</ul>
							</div>
						</div>
						@empty
						<div class="col-12 text-center" style="padding:60px 0;">
							<i class="fas fa-car" style="font-size:60px;color:#ddd;margin-bottom:20px;display:block;"></i>
							<p class="mb-0">Aucun véhicule trouvé.</p>
							<a href="{{ route('fleet') }}" class="text_btn text-uppercase" style="margin-top:15px;display:inline-block;"><span>Voir tous les véhicules</span> <img src="{{ asset('assets/images/icons/icon_02.png') }}" alt="icon"></a>
						</div>
						@endforelse
					</div>

					@if($vehicles->hasPages())
					<div class="pagination_wrap clearfix" data-aos="fade-up" data-aos-delay="100">
						<div class="row align-items-center justify-content-lg-between">
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<span class="page_number">Page {{ $vehicles->currentPage() }} sur {{ $vehicles->lastPage() }}</span>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<ul class="pagination_nav ul_li_right clearfix">
									@if($vehicles->onFirstPage())
									<li class="disabled"><span><i class="fal fa-angle-double-left"></i></span></li>
									@else
									<li><a href="{{ $vehicles->appends(request()->query())->previousPageUrl() }}"><i class="fal fa-angle-double-left"></i></a></li>
									@endif

									@foreach($vehicles->getUrlRange(1, $vehicles->lastPage()) as $page => $url)
									<li class="{{ $page == $vehicles->currentPage() ? 'active' : '' }}">
										<a href="{{ $vehicles->appends(request()->query())->url($page) }}">{{ $page }}</a>
									</li>
									@endforeach

									@if($vehicles->hasMorePages())
									<li><a href="{{ $vehicles->appends(request()->query())->nextPageUrl() }}"><i class="fal fa-angle-double-right"></i></a></li>
									@else
									<li class="disabled"><span><i class="fal fa-angle-double-right"></i></span></li>
									@endif
								</ul>
							</div>
						</div>
					</div>
					@endif

				</div>
				<!-- main content - end -->

			</div>
		</div>
	</div>
	<!-- car_section - end
	================================================== -->


@endsection

@push('scripts')
<script>
$(function() {
	if (typeof $.fn.slider !== 'undefined' && $("#slider-range").length) {
		try { $("#slider-range").slider("destroy"); } catch(e) {}
		var initVal = parseInt("{{ request('prix_max', 150000) }}") || 150000;
		$("#slider-range").slider({
			range: "min",
			min: 5000,
			max: 300000,
			step: 5000,
			value: initVal,
			slide: function(event, ui) {
				$("#amount").val(ui.value);
				$("#amount_display").text(ui.value.toLocaleString('fr-FR') + ' FCFA');
			}
		});
		$("#amount").val(initVal);
		$("#amount_display").text(initVal.toLocaleString('fr-FR') + ' FCFA');
	}
});
</script>
@endpush
