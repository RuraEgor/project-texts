<?php
require_once '../config.php';


//-----  ДИНАМИЧЕСКИЙ ПОИСК ПО БУКВЕ С ВЫВОДО СПИСКА

$_POST['QUERY'] = (isset($_POST['QUERY']))?$_POST['QUERY']:'&&&';

if($_POST['QUERY'] != '&&&') {

	$per = mysql_query(" SELECT `id`,`name`,`links`,`group` FROM `links_wr` ORDER BY `id` ASC ");

	$mes = array();

	$i = 1;
	while ($row = mysql_fetch_assoc($per)) 
	{
		
		$mystring = $row["name"];
		$findme = $_POST['QUERY'];

		$pos = stripos($mystring, $findme);

		if ($pos === false) {

			//$mes[] = "nope";

		} else {

			$mes["id"][] = $row["id"];
			$mes["name"][] = $row["name"];
			$mes["links"][] = $row["links"];
			$mes["group"][] = $row["group"];

			if( $i > 10 ) { break; }
			$i++;
		}
		
	}

	header('Content-Type: application/json');
	print json_encode( $mes );
}


//---------------------------------------------------------
//---------------------------------------------------------

//-----  ДИНАМИЧЕСКИЙ ПОИСК С ВЫВОДОМ ВСЕХ РЕЗУЛЬТАТОВ

$_POST['QUERY_ENTER'] = (isset($_POST['QUERY_ENTER']))?$_POST['QUERY_ENTER']:'&&&';

if($_POST['QUERY_ENTER'] != '&&&') {

	$per = mysql_query(" SELECT * FROM `links_wr` ORDER BY `id` ASC ");

	$mes = array();


	while ($row = mysql_fetch_assoc($per)) 
	{
		
		$mystring = $row["name"];
		$findme = $_POST['QUERY_ENTER'];

		$pos = stripos($mystring, $findme);

		if ($pos === false) {


		} else {

			$mes[] = $row;

		}
		
	}

	header('Content-Type: application/json');
	print json_encode( $mes );
}


//---------------------------------------------------------
