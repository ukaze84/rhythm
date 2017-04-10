<?php

	Models::Load( "ForteHelpers" );

	if( $_POST["Forte"] == "all" || !ForteHelpers::CheckForteIsExist( $_POST["Forte"] ) ){
		Util::Status403("forte_NOTFOUND");
	}

	$_POST['title'] = trim($_POST['title']);
	if(  mb_strlen($_POST['title'], "UTF-8") < 3 ){
		Util::Status403("title_EMPTY");
	}

	if(  mb_strlen(trim($_POST['text']), "UTF-8") < 10 ){
		Util::Status403("text_EMPTY");
	}
	if( $LastID = ForteHelpers::InsertContent() ){

		Util::StatusTrue("/forte/{$_POST["Forte"]}/{$LastID}");

	} else {
		Util::Status403();
	}