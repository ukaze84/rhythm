<?php

/**
* 
*/

class Apps{
	
	

	public static function run( $app ){
		
		//check if the site exists.
		if( file_exists("Apps/{$app}.php") ){
			require_once( "Apps/{$app}.php" );
		} else {
			
			Util::Debug(
				"Apps",
					"/Config/Apps.php",
					array(
						"DebugEnabled" =>
							"<h2>The {$app} app is not exists /Apps </h2>",
						"DebugDisabled" =>
							"<h2>Application not properly installed </h2>"
					),
					true,	//Clean Screen
					true 	//php OFF
			);
		}

	}
	

}