<?php

use Grocy\Helpers\BaseBarcodeLookupPlugin;

/*
	This class must extend BaseBarcodeLookupPlugin (in namespace Grocy\Helpers)
*/
class DemoBarcodeLookupPlugin extends BaseBarcodeLookupPlugin
{
	/*
		To use this plugin, configure it in data/config.php like this:
		Setting('STOCK_BARCODE_LOOKUP_PLUGIN', 'DemoBarcodeLookupPlugin');
	*/

	/*
		To try it:

		Call the API function at /api/stock/barcodes/external-lookup/{barcode}

		Or use the product picker workflow "External barcode lookup (via plugin)"

		When you also add ?add=true as a query parameter to the API call,
		on a successful lookup the product is added to the database and in the output
		the new product id is included (automatically, nothing to do here in the plugin)
	*/

	/*
		Provided references:

		$this->Locations contains all locations
		$this->QuantityUnits contains all quantity units
	*/

	/*
		Useful hints:

		Get a quantity unit by name:
		$quantityUnit = FindObjectInArrayByPropertyValue($this->QuantityUnits, 'name', 'Piece');

		Get a location by name:
		$location = FindObjectInArrayByPropertyValue($this->Locations, 'name', 'Fridge');
	*/

	/*
		This class must implement the protected abstract function ExecuteLookup($barcode),
		which is called with the barcode that needs to be looked up and must return an
		associative array of the product model or null, when nothing was found for the barcode.

		The returned array must contain at least these properties:
		array(
			'name' => '',
			'location_id' => 1, // A valid id of a location object, check against $this->Locations
			'qu_id_purchase' => 1, // A valid id of quantity unit object, check against $this->QuantityUnits
			'qu_id_stock' => 1, // A valid id of quantity unit object, check against $this->QuantityUnits
			'qu_factor_purchase_to_stock' => 1, // Normally 1 when quantity unit stock and purchase is the same
			'barcode' => $barcode // The barcode of the product, maybe just pass through $barcode or manipulate it if necessary
		)
	*/
			

	protected function ExecuteLookup($barcode)
	{
		
		$result = file_get_contents('https://world.openfoodfacts.net/api/v2/product/' . $barcode . '?fields=product_name,nutriscore_data,nutriments,nutrition_grades', false, $context);
		//$result = json_decode($result,false); 
		$getBarcode = $result;
		$errorCode = $result->status;
		$errorMsg = $result->status_verbose;



		if ($barcode === 'nothing')
		{
			// Demonstration when nothing is found
			return null;
		}
		elseif ($barcode === 'dssfd')
		{
			// Demonstration when an error occurred
			throw new \Exception('This is the error message from the plugin...');
		}
		else
		{
			return [
				'name' => 'LookedUpProduct_' . RandomString(5),
				'location_id' => $this->Locations[0]->id,
				'qu_id_purchase' => $this->QuantityUnits[0]->id,
				'qu_id_stock' => $this->QuantityUnits[0]->id,
				'qu_factor_purchase_to_stock' => 1,
				'barcode' => $barcode,
				'description' => 'Grocy Barcode: ' 	. $getBarcode
				];
		}
		
	}
}
?>