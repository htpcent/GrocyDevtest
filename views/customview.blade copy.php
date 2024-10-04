@php require_frontend_packages(['datatables', 'summernote', 'animatecss', 'bwipjs']); @endphp

@extends('layout.default')

@section('title', $__t('Shopping list'))

@push('pageScripts')
<script src="{{ $U('/viewjs/purchase.js?v=', true) }}{{ $version }}"></script>
@endpush

@section('content')

    <div class="content">
        <div class="productForm">
            <form  method='post'>
                <div>
                    <input placeholder='Barcode eingeben' name='barcode'>
                </div>
                <button type='Submit'>Absenden</button>
            </form>
			@php
			$result = file_get_contents('https://world.openfoodfacts.net/api/v2/product/3017624010701?fields=product_name,nutriscore_data,nutriments,nutrition_grades', false, $context);
			$result = json_decode($result,false); 
			//$calories = $result->product->nutriments->energy-kcal_100g;
$carbs = $result->product->nutriments->carbohydrates_100g;
$protein = $result->product->nutriments->proteins_100g;
$fat = $result->product->nutriments->fat_100g;
			


			echo " <table>
  <tr>
    <th>Nährwerte</th>
  </tr>
  <tr>
    <td>Kalorien</td>
    <td>$calories</td>
   </tr>
   <tr>
    <td>Kohlenhydrate</td>
    <td>$carbs</td>
   </tr>
   <tr>
    <td>Eiweiß</td>
    <td>$protein</td>
   </tr>
   <tr>
    <td>Fett</td>
    <td>$fat</td>
   </tr>
</table>";
        @endphp
        </div>

    </div>


@include('components.productcard', [
'asModal' => true
])
@stop
