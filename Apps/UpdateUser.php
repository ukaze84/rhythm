<?php

		$_SESSION["Rhythm"]["RequestNickname"] = 0;
    	$_CONFIGS = $GLOBALS["_CONFIGS"];
		Apps::run( "OAuthSDK/HTTPRequest" );

		$Endpoint = $_CONFIGS["TenozOAuth-ResoucreEndpoint"] ;
		$Query = array(
			"access_token" => $_SESSION["Rhythm"]["AccessToken"],
			"scope" => "nickname gender",
			"uid" => $_SESSION["User"]["UID"]
		);
		$result = json_decode(Request::get( $Endpoint, $Query ),1)["results"];
		// var_dump($result);exit;
		if( $uid = checkExist($result["uid"]) ){
			$SQL =
			"	UPDATE User
				SET `nickname`  = '{$result["nickname"]}',
					`gender` 	= '{$result["gender"]}'
				WHERE `tenozid` = '{$result["uid"]}'
			";
			DB::Query( $SQL );
		} else {
			$uid = date("U").sprintf("%07d", rand(0,1000000));
			$SQL =
			"	INSERT INTO User (
					`tenozid`,
					`uid`,
					`nickname`,
					`gender`
				) VALUES (
					'{$result["uid"]}',
					'{$uid}',
					'{$result["nickname"]}',
					'{$result["gender"]}'
				)
			";
			DB::Query( $SQL );
		}

		$_SESSION["Rhythm"]["UID"] = $uid;
		$_SESSION["Rhythm"]["Nickname"] = $result["nickname"];
		$_SESSION["Rhythm"]["Gender"] = $result["gender"];
		if(strlen($result["nickname"]) < 3 ){
			$_SESSION["Rhythm"]["RequestNickname"] = 1;
			Route::Location( "http://accounts.tenoz.asia/Settings?request=nickname&redirect=".urlencode("http://rhythm.tenoz.asia/update") );
		}
		Route::Location( "http://rhythm.tenoz.asia" );

		function checkExist( $id )
		{
			$SQL = 
			" SELECT COUNT(*) AS isExist,`uid` FROM User WHERE `tenozid` = '{$id}' ";
			$Result = DB::Query( $SQL )->fetch( PDO::FETCH_ASSOC );
			return $Result["isExist"]?$Result["uid"]:false;
		}

