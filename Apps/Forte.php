<?php
	
	
	
	/* Loading Helpers "ForteHelpers" */
	Models::Load( "ForteHelpers" );
	Models::Load( "NavbarHelpers" );
	
	
	/* For debugging :
		var_dump(ForteHelpers::CheckForteIsExist( $_GET["Forte"] ));
	*/

	if( !ForteHelpers::CheckForteIsExist( $_GET["Forte"] ) ){
		header( "location:http://{$_SERVER["HTTP_HOST"]}/");
		exit;
	}// Redirect to home , if the forte doesn't exist


	
	// Set the title .
	// ForteHelpers::GetDescription()["b_c_name"]
	// call GetDescription in the ForteHelpers class,
	// which returns the whole info_array of forte
	// get the board_chinese_name from array["b_c_name"]
	Page::Title( ForteHelpers::GetDescription()["b_c_name"]. " - Tenoz Rhythm" );
	
	Page::Init(function(){

		/* Loading Assets */
		Assets::Import("jquery");
		Assets::Import("materialize");

	// 	//LOAD RESOURCE
	// });

	// Page::TagOn( "body");
	// //set HTML body
	// 	Page::TagOn( "header");
			
	// 		Page::Item(
	// 			"ForteNavbar",
	// 			array(
	// 					"Logo" => ForteHelpers::GetDescription()["b_c_name"]
	// 					//override the string "Logo" with the name .
	// 			)
	// 		);

	// 		Page::Item(
	// 			"SideBar",
	// 			array(
	// 					"Forte" => Fortes()
			
	// 			)
	// 		);

	// 	Page::TagOff( "header");
		

	// 	Page::TagOn( "main",array(
	// 	"style" => "padding-left:240px"
	// 	));


	// 	//////test part!!!!
	// 		Page::HTML("Parallax");
		
	// 	//////end test part!!!!

	// 	$SQL=
	// 	"
	// 		  SELECT * 
	// 		  FROM `Posts`
	// 		  WHERE `p_bid`=3
	// 		  LIMIT 30
	// 	";

	// 	$Result=DB:: Query( $SQL );
		
	// 	while($Fetch = $Result->fetch(PDO::FETCH_ASSOC))
	// 	{
	// 			$Article.=
	// 			"<tr>
	// 			<td> {$Fetch["p_uid"]} </td>
	// 			<td> {$Fetch["p_post_time"]} </td>
	// 			</tr>";
	// 	}
		
	// 	Page::Item( "Forte" ,array(
	// 		"Articles" => $Article

	// 		));
	// 	//load page "Forte"


	// 	Page::HTML("Fab");

	// 	Page::TagOff( "main");

	// 	//test part
	// 	Assets::Import("Forte/main");

		
		
		Assets::Style("/Resource/css/main.css");
	});


	Page::TagOn( "body" );
	/* START OF body */

		/* START OF header */
		Page::TagOn( "header" );

			Navbar::Render();
			Page::Item(
				"SideBar",
				array(
					"Forte" => ForteHelpers::getFortesToHTMLList()
				)
			);
		Page::TagOff( "header" );
		/* END OF header */

		/* START OF main */
		Page::TagOn( "main" );

			/* START OF test part!!!! */
			Page::HTML("Parallax");
			/* END OF test part!!!! */

			Page::Item( 
				"Forte/ArticleList",
				array(
					"Articles" => ForteHelpers::getArticlesToTableRow()
				)
			);
			//load page "Forte"
		Page::TagOff( "main" );
		/* END OF main */

		if( $_GET["Forte"] != "all" && $_SESSION["User"]["Account"])
		Page::Item(
			"RightBottomBtn",
			array(
				"Forte" => ForteHelpers::GetDescription()["b_name"]
			)
		);
		
		Assets::Script("/Resource/js/Forte/main.js");
	Page::TagOff( "body" );
	//END OF body
