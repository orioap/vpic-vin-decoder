<?php namespace VpicVinDecoder;

use GuzzleHttp\Client;

class Decoder {
	public static function decode($vin){
		$client     = new Client();
		$res = collect();
		$response 	= $client->request('GET', 'https://vpic.nhtsa.dot.gov/api/vehicles/DecodeVin/'.$vin.'?format=json');

		$result		= json_decode($response->getBody());
		//echo get_class($result);exit;
		if(isset($result->Results)){
			foreach($result->Results AS $key => $data){
				if($data->Value){
					$res->push((object)[
						'nameid' => $data->VariableId,
						'name' => $data->Variable,
						'valueid' => $data->ValueId,
						'value' => $data->Value,
					]);
				}
			}
		}
		return $res;
	}

	public static function getModels($make){
		$client     = new Client();
		$res = collect();
		$response 	= $client->request('GET', 'https://vpic.nhtsa.dot.gov/api/vehicles/getmodelsformake/'.$make.'?format=json');

		$result		= json_decode($response->getBody());
		//echo get_class($result);exit;
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
}
