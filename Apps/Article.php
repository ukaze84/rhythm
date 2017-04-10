<?php


	/* Loading Helpers "ForteHelpers" */
	Models::Load( "ForteHelpers" );
	Models::Load( "NavbarHelpers" );
	
	/* For debugging :
		var_dump(ForteHelpers::CheckForteIsExist( $_GET["Forte"] ));
	*/

	$_GET["Article"] = array_merge( $_GET["Article"], ForteHelpers::getArticle($_GET["Article"]["ID"]) );
	
	if( $_GET["Forte"] == "all" || !ForteHelpers::CheckForteIsExist( $_GET["Forte"] ) ){
		header( "location:http://{$_SERVER["HTTP_HOST"]}/");
		exit;
	}// Redirect to home , if the forte doesn't exist
	
	// if( )	

	// Set the title .
	// ForteHelpers::GetDescription()["b_c_name"]
	// call GetDescription in the ForteHelpers class,
	// which returns the whole info_array of forte
	// get the board_chinese_name from array["b_c_name"]
	Page::Title( $_GET["Article"]["Title"]. " - Tenoz Rhythm" );
	
	Page::Init(function(){

		/* Loading Assets */
		Assets::Import("jquery");
		Assets::Import("materialize");
		Assets::Import("tinymce");
		Assets::Import("sweetalert");
		Assets::Style("/Resource/semantic/components/segment.min.css");
		Assets::Style("/Resource/css/main.css");
	});

	Page::TagOn( "body" );
	/* START OF body */


		//set navbar
		Page::TagOn( "header" );
			
			Navbar::Render();

			//set sidebar
			Page::Item(
				"SideBar",
				array(
					"Forte" => ForteHelpers::getFortesToHTMLList()
				)
			);
		Page::TagOff( "header" );

		Page::TagOn( "main");

			Page::Item( 
				"Article/Article",
				$_GET["Article"]
			);
			
		Page::TagOff( "main" );

		//call function "FortesToBtns()"at body.


		

	Page::TagOff( "body" );
	//END OF body


