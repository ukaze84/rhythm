<?php

	Page::Title("Test");

	Page::Init(function(){

		Assets::Import("jquery");
		Assets::Import("materialize");
		//LOAD RESOURCE
	});

	Page::TagOn( "body" );
		
	$SQL = 
	"	SELECT *
		FROM `Posts`
		WHERE `p_bid` = 3
		LIMIT 30
	";
	$Result = DB::Query( $SQL );

<<<<<<< HEAD


	while( $Fetch = $Result -> fetch( PDO::FETCH_ASSOC ) ){
		$Articles .= "<tr><td>{$Fetch["p_uid"]}</td><td>{$Fetch["p_post_time"]}</td></tr>";
	}

	Page::Item( "test", 
		array(
			"Articles" => $Articles
		)
	);
=======
		Page::Item(
			"Navbar"
			// ,
			 // array(
			// 		"Logo" => ForteHelpers::GetDescription()["b_c_name"]
					//override the string "Logo" with the name .
			//)
		);
		Page::HTML("test");
		
>>>>>>> 060fcff6c12b1f3809388d3ab3f4c5959b40660d

	Page::TagOff("body");