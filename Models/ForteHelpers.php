<?php

	/**
	* 
	*/
	class ForteHelpers {
		
		public static function CheckForteIsExist( $Name ){
			
			 $SQL =
			 "	SELECT  COUNT(*) AS IsExist , Boards.*
			 	FROM 	Boards
			 	WHERE 	b_name = '{$Name}'
			 	LIMIT 1
			 ";

			$Result 	= DB::Query( $SQL )->fetch( PDO::FETCH_ASSOC );
		 	$IsExist 	= $Result["IsExist"];
		 	if( $IsExist ){
		 		unset($Result["IsExist"]);
		 		$GLOBALS["Rhythm"]["Model"]["ForteHelpers"]["CurrentForte"] = $Result;
		 	}
			return ($IsExist)?true:false;
		}

		public static function ListFortes( $Board_Father = 1, $Order = "b_bid" ){
			
			 $SQL =
			 "	SELECT  *
			 	FROM 	Boards
			 	WHERE 	b_bid_f = '{$Board_Father}'
			 	ORDER BY {$Order}
			 ";

			return DB::Query( $SQL )->fetchAll( PDO::FETCH_ASSOC );
		}


		public static function GetDescription( ){
			if( !is_null($GLOBALS["Rhythm"]["Model"]["ForteHelpers"]["CurrentForte"]) ){
				return $GLOBALS["Rhythm"]["Model"]["ForteHelpers"]["CurrentForte"];
			}
			return null;
		}
		//return input if it's not null.
		//else:return null.



		public static function getFortesToHTMLList(){
			$this_forte = ForteHelpers::GetDescription();
			foreach ( ForteHelpers::ListFortes() as $Row ) {
				//return all the names of bulletins
				unset($active);
				if( $Row["b_name"] == $this_forte["b_name"] ){
					$active = "class=\"active purple lighten-3 white-text\"";
				}
				$Fortes.= 
				" 
	    		<li $active><a href=\"/forte/{$Row["b_name"]}\" style=\"color:inherit\">
					{$Row["b_c_name"]}
	    		</a></li>
				";
			}

			return $Fortes;
		}


		public static function getArticlesToTableRow($offset = 0, $limit = 30, $forte ){
			if( is_null($forte) ){
				$forte = ForteHelpers::GetDescription()["b_bid"];
			}
			if( $forte == "1" ){
				$SQL=
				"
					SELECT 		p.*,b.b_name,b.b_c_name
					FROM 		`Posts` as p
					LEFT JOIN 	`Boards` as b 
					ON 			b.b_bid = p.p_b
					WHERE 		1
					LIMIT 		$offset, $limit
				";
			} else {
				$SQL=
				"
					SELECT 		p.*,b.b_name,b.b_c_name
					FROM 		`Posts` as p
					LEFT JOIN 	`Boards` as b 
					ON 			b.b_bid = p.p_b
					WHERE 		`p_b` 	= '{$forte}'
					LIMIT 		$offset, $limit
				";
			}
			$Result = DB::Query( $SQL );
			unset($Article);
			while($Fetch = $Result->fetch(PDO::FETCH_ASSOC)) {
				$Article.=
				"
					<tr>
					
					<td>
					<a href=\" /forte/{$Fetch["b_name"]}/{$Fetch["id"]} \">
					{$Fetch["p_title"]}
					</a>
					</td>
					<td> {$Fetch["p_create_time"]}</td>
					</tr>
				";
			}
			return $Article;
		}
		public static function InsertContent(){
			$forte = ForteHelpers::GetDescription()["b_bid"];
			$title = trim($_POST['title']);
			$content = trim(addslashes($_POST['text']));

			$SQL=
			" INSERT INTO `Posts`(
					`p_b`,
					`p_uid`,
					`p_title`,
					`p_content`
				) VALUES (
					'{$forte}',
					'{$_SESSION["Rhythm"]["UID"]}',
					'{$title}',
					'{$content}'

				)
			";
			$Result = DB::Prepare( $SQL )->lastInsertId();
			$Result = $Result?$Result:false;
			return $Result;
		}
		public static function getArticle( $id ){

			$SQL=
			"
				SELECT 		P.`id`,
							P.`p_title` 	as Title,
							P.`p_content` 	as Article,
							P.`p_visible` 	as Visible,
							U.`nickname` 	as Author,
							B.`b_name` 		as Board,
							B.`b_c_name` 	as BoardName,
							P.`p_create_time` as DetailTime 
				FROM 		`Posts` AS P
				LEFT JOIN 	`User` as U
				ON 			U.`uid` = P.`p_uid`
				LEFT JOIN 	`Boards` as B
				ON 			B.`b_bid` = P.`p_b`
				WHERE 		`id` 	= '{$id}'
				LIMIT 		1
			";
			$Result = DB::Query( $SQL )->fetch( PDO::FETCH_ASSOC );
			$Result["Time"] = Util::ShortTime( $Result["DetailTime"] );
			$Result["Article"] = Util::HTMLnl2br( $Result["Article"] );
			return $Result;
		}
	}

