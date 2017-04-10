<?php
/**
* 
*/
class Request
{
	
	public static function get($url, $params) {
		if( is_null($url) ){
			Util::Debug(
				"SDK",
					"/OAuth/HTTPRequest.php",
					array(
						"DebugEnabled" =>
							"invaild get path.",
					),
					true,	//Clean Screen
					true 	//php OFF
			);
		}
		if(!empty($params)){
			$url .="?".http_build_query($params) ;
			print_r($url);
		}
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
		    CURLOPT_URL => $url
		));
		$resp = curl_exec($curl);
		$erro = curl_error($curl);
		curl_close($curl);
		if( $erro ){
			return $erro;
		}
		return $resp;

	}

	public static function post($url, $params) {
		if( is_null($url) ){
			Util::Debug(
				"SDK",
					"/OAuth/HTTPRequest.php",
					array(
						"DebugEnabled" =>
							"invaild url.",
					),
					true,	//Clean Screen
					true 	//php OFF
			);
		}
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
		    CURLOPT_URL => $url,
		    CURLOPT_POST => 1,
		    CURLOPT_POSTFIELDS => $params,
		));
		$resp = curl_exec($curl);
		$erro = curl_error($curl);
		curl_close($curl);
		if( $erro ){
			// var_dump($erro);
			return $erro;
		}
		return $resp;
	}

}