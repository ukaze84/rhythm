<?php	

	Models::Load( "ForteHelpers" );
	Models::Load( "NavbarHelpers" );
	//include class named"ForteHelpers"
	
	Page::Title( "Rhythm" );
	//Set the web title to "Home"
	
	Page::Init(function(){

		Assets::Import("jquery");
		Assets::Import("materialize");
		Assets::Style("/Resource/css/main.css");
		//load resource data.

	});


	Page::TagOn( "body" );
	//set a HTML body.
		Navbar::Render();

		
		Page::HTML( "SlideTest" );
		Page::Item( "Home/Fortes", 
			array(
				"Fortes" => Fortes()
			)
		);
		
		Assets::Script("/Resource/js/home.js");
	Page::TagOff( "body" );
	//end body.

	function Fortes(){

		foreach ( ForteHelpers::ListFortes() as $Row ) {
			//return all the names of bulletins
			@$Fortes.=
			" 
			<a href=\"/forte/{$Row["b_name"]}\">
			<div class=\"col s12 m3\">
				<div class=\"card-panel teal\">
					<span class=\"white-text\">{$Row["b_c_name"]}</span>
				</div>
			</div>
    		</a>
			";
		}

		return $Fortes;
	}