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

	/*public static function models($make){
		$client     = new Client();
		$res = collect();
		$response 	= $client->request('GET', 'https://vpic.nhtsa.dot.gov/api/vehicles/getmodelsformake/'.$make.'?format=json');

		$result		= json_decode($response->getBody());

		if(isset($result->Results)){
			foreach($result->Results AS $key => $data){
				if($data->Model_ID){
					$res->push((object)[
						'id' => $data->Model_ID,
						'name' => $data->Model_Name,
					]);
				}
			}
		}
		return $res;
	}

	public static function variables(){
		$client     = new Client();
		$res = collect();
		$response 	= $client->request('GET', 'https://vpic.nhtsa.dot.gov/api/vehicles/getvehiclevariablelist?format=json');

		$result		= json_decode($response->getBody());

		if(isset($result->Results)){
			foreach($result->Results AS $key => $data){
				if($data->ID){
					$res->push((object)[
						'id' => $data->ID,
						'name' => $data->Name,
						'desc' => $data->Description,
						'type' => $data->DataType,
					]);
				}
			}
		}
		return $res;
	}*/
}
