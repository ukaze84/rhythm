<?php

	if( !empty($_SESSION["User"]["UID"]) && empty($_SESSION["Rhythm"]["Logout"]) &&
	  empty($_SESSION["Rhythm"]["AccessToken"]) && empty($_SESSION["Rhythm"]["RequestOAuth"]) ){
			$_SESSION["Rhythm"]["RequestOAuth"] = 1;
			Apps::run("Authentication");
	} else if (!empty($_SESSION["Rhythm"]["RequestNickname"]) && $_SESSION["Rhythm"]["RequestNickname"] > 0 && Route::GetURI() !== "/update") {
		$_SESSION["Rhythm"]["RequestNickname"] = 0;
		Route::Location( "http://accounts.tenoz.asia/Settings?request=nickname&redirect=".
		urlencode("http://rhythm.tenoz.asia/update") );	
	}
	Route::Add("/",function(){

		Apps::run( "Home" );
		
	},"Route" );

	Route::Add("/debug",function(){
		echo "<pre>";
		print_r($_SESSION);
		
	},"Route" );

	Route::Add("/oauth/redirect",function(){
		if( Route::GetQuery()["state"] === "authorize"){
			Apps::run("OAuthSDK/ReceiveOAuthCode");
		} else {
			echo "NO";
			
		}
		
	},"Route" );

	// add 
	Route::Add("/forte/([A-Za-z_0-9]+)",function(){

		$_GET["Forte"] = Route::GetPath()[0];
		Apps::run( "Forte" );
	
	},"Route");
	
	// add 
	Route::Add("/forte",function(){

		header( "location:http://{$_SERVER["HTTP_HOST"]}");
		exit;
	
	},"Route");

	// add 
	Route::Add("/forte/([A-Za-z_0-9]+)/publish",function(){
		if ($_SERVER['REQUEST_METHOD'] == 'GET'){
			$_GET["Forte"] = Route::GetPath()[0];
			Apps::run("Publish");
		} else if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$_POST["Forte"] = Route::GetPath()[0];
			Apps::run("API/Publish");
		}
	},"Route");

	Route::Add("/forte/([A-Za-z_0-9]+)/([0-9]+)",function(){

		$_GET["Forte"] = Route::GetPath()[0];
		$_GET["Article"]["ID"] = Route::GetPath()[1];
		Apps::run( "Article" );
	
	},"Route");

	Route::Add("/update",function(){
		
		Apps::run( "UpdateUser" );

	},"Route");



	Route::Submit( "Route" );
	echo "No Match";
