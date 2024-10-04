@extends('layout.default')

@section('title', $__t('Information'))

@push('pageScripts')
<script src="{{ $U('/js/grocy_uisound.js?v=', true) }}{{ $version }}"></script>
@endpush

@section('content')
<script>
	Grocy.QuantityUnits = {!! json_encode($quantityUnits) !!};
	Grocy.QuantityUnitConversionsResolved = {!! json_encode($quantityUnitConversionsResolved) !!};
	Grocy.DefaultMinAmount = '{{ $DEFAULT_MIN_AMOUNT }}';
</script>

<div class="row">
	<div class="col-12 col-md-6 col-xl-4 pb-3">
		<div class="title-related-links">
			<h2 class="title">@yield('title')</h2>
			<button class="btn btn-outline-dark d-md-none mt-2 float-right order-1 order-md-3 hide-when-embedded"
				type="button"
				data-toggle="collapse"
				data-target="#related-links">
				<i class="fa-solid fa-ellipsis-v"></i>
			</button>
			<div class="related-links collapse d-md-flex order-2 width-xs-sm-100"
				id="related-links">
				@if(!$embedded)
				<button id="scan-mode-button"
					class="btn @if(boolval($userSettings['scan_mode_purchase_enabled'])) btn-success @else btn-danger @endif m-1 mt-md-0 mb-md-0 float-right"
					data-toggle="tooltip"
					title="{{ $__t('When enabled, after changing/scanning a product and if all fields could be automatically populated (by product and/or barcode defaults), the transaction is automatically submitted') }}">{{ $__t('Scan mode') }} <span id="scan-mode-status">@if(boolval($userSettings['scan_mode_purchase_enabled'])) {{ $__t('on') }} @else {{ $__t('off') }} @endif</span></button>
				<input id="scan-mode"
					type="checkbox"
					class="d-none user-setting-control"
					data-setting-key="scan_mode_purchase_enabled"
					@if(boolval($userSettings['scan_mode_purchase_enabled']))
					checked
					@endif>
				@else
				<script>
					Grocy.UserSettings.scan_mode_purchase_enabled = false;
				</script>
				@endif
			</div>
		</div>

		<hr class="my-2">

		<form id="purchase-form"
			novalidate>

			@include('components.productpicker', array(
			'products' => $products,
			'barcodes' => $barcodes,
			'nextInputSelector' => '#display_amount'
			))
            @include('components.customproductcard')
			

			
			

			

			

			

			

			

			
		</form>
	</div>

	<div class="col-12 col-md-6 col-xl-4 hide-when-embedded">
		
	</div>
</div>
@stop
