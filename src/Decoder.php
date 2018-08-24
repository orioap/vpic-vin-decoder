<?php namespace VpicVinDecoder;

use GuzzleHttp\Client;

class Decoder {
	public static function decode($vin){
		$client     = new Client();
		$res = collect();
		$response 	= $client->request('GET', 'https://vpic.nhtsa.dot.gov/api/vehicles/DecodeVin/'.$vin.'?format=json');

		$result		= json_decode($response->getBody());

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

	public static function models($make){
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
	}
}
