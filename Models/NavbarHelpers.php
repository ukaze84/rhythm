<?php 


class Navbar{








	public static function Render(){

		if( $_SERVER['REQUEST_URI'] == "/" ){
			if( @is_null($_SESSION["User"]["Account"]) ){
				Page::HTML( "Home/HomeNavbar" );
			} else {
				Page::Item(
					"Home/HomeLogonNavbar",
					array(
						"User" => $_SESSION["Rhythm"]["Nickname"]
					)
				);
			}



		} else {

			

			if( is_null($_SESSION["User"]["Account"]) ) {
				Page::Item(
					"Forte/ForteNavbar",
					array(
						"Logo" => ForteHelpers::GetDescription()["b_c_name"]
					)
				);
			} else {
				Page::Item(
					"Forte/ForteLogonNavbar",
					array(
						"User" => $_SESSION["Rhythm"]["Nickname"],
						"Logo" => ForteHelpers::GetDescription()["b_c_name"]
					)
				);
			}

		}
	}

}




	