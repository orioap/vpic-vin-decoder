<?php namespace VpicVinDecoder;

use GuzzleHttp\Client;

class Decoder {
	public static function decode($vin){
		$client     = new Client();
		$response 	= $client->request('GET', 'https://vpic.nhtsa.dot.gov/api/vehicles/decodevinvalues/'.$vin.'?format=json');
		$result		= json_decode($response->getBody());
		return collect($result->Results);
	}

	public static function decode_batch($vins){
		if(!is_array($vins)) $vins = [$vins];

		$post_data = [
			'DATA' => implode('; ', $vins),
			'format' => 'JSON',
		];

		$client = new Client();
		$response 	= $client->post('https://vpic.nhtsa.dot.gov/api/vehicles/decodevinvaluesbatch', ['form_params' => $post_data]);
		$result		= json_decode($response->getBody());
		return collect($result->Results);
	}
}
