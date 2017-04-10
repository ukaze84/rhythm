<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	$_CONFIGS = $GLOBALS["_CONFIGS"];
	$Url = 
		"http://oauth.tenoz.asia/authorize"
		."?response_type=code"
		."&client_id=".$_CONFIGS["TenozOAuth-ClientID"]
		."&scope=nickname%20gender%20notification"
		."&redirect_uri=".urlencode($_CONFIGS["TenozOAuth-RedirectUri"])
		."&state=authorize";
	header( "Location:$Url" );
	exit;