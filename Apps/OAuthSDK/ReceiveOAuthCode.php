<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $_CONFIGS = $GLOBALS["_CONFIGS"];
    Apps::run( "OAuthSDK/HTTPRequest" );
    
    $config = array(
    	'client_id' => $_CONFIGS["TenozOAuth-ClientID"],
    	'client_secret' => $_CONFIGS["TenozOAuth-ClientSecret"],
    	'authorize_redirect' => $_CONFIGS["TenozOAuth-RedirectUri"]
    );
  
    if( empty(Route::GetQuery()["code"]) ){
        $_SESSION["Rhythm"]["Logout"] = 1;
        Route::Location("http://rhythm.tenoz.asia/");
    }
    $code = Route::GetQuery()["code"];

    $query = array(
        'grant_type'    => 'authorization_code',
        'code'          => $code,
        'client_id'     => $_CONFIGS["TenozOAuth-ClientID"],
        'client_secret' => $_CONFIGS["TenozOAuth-ClientSecret"],
        'redirect_uri'  => urlencode( $config['authorize_redirect'] ),
        'state'         => "request_token",
        'scope'         => "nickname gender notification"
    );

    $result = json_decode(Request::post( $_CONFIGS["TenozOAuth-TokenEndpoint"], $query ),1);
    // print_r($result);exit;
    $_SESSION["Rhythm"]["AccessToken"] = $result["access_token"];
    $_SESSION["Rhythm"]["RefreshToken"] = $result["refresh_token"];
    // unset($_SESSION["Rhythm"]["RequestOAuth"]);
    // Route::Location("http://rhythm.tenoz.asia/");
    Apps::run( "UpdateUser" );
    exit;


/*
    // // determine the token endpoint to call based on our config
    // $endpoint = $config['token_route'];
    // if (0 !== strpos($endpoint, 'http')) {
    //     // if PHP's built in web server is being used, we cannot continue
    //     $this->testForBuiltInWebServer();

    //     // generate the route
    //     $endpoint = $urlgen->generate($endpoint, array(), true);
    // }

    // // make the token request via http and decode the json response
    // $response = $http->post($endpoint, null, $query, $config['http_options'])->send();
    // $json = json_decode((string) $response->getBody(), true);

    // // if it is succesful, display the token in our app
    // if (isset($json['access_token'])) {
    //     if ($app['request']->get('show_refresh_token')) {
    //         return $twig->render('client/show_refresh_token.twig', array('response' => $json));
    //     }

    //     return $twig->render('client/show_access_token.twig', array('response' => $json));
    // }
*/