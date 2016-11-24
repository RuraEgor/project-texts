<?php
require_once '../config.php';



$_POST['apWrite'] = (isset($_POST['apWrite']))?$_POST['apWrite']:'&&&';

if($_POST['apWrite'] != '&&&') {
	
	$per = mysql_query(" SELECT * FROM `links_wr` WHERE `id` = ".$_POST['apWrite']." ");
	$mes = array();

	while ($row = mysql_fetch_assoc($per)) 
	{
		
		//$row['write_text'] = htmlspecialchars($row['write_text']);
		$mes = $row;
	}

	header('Content-Type: application/json');
	print json_encode($mes);
}

//---------------------------------------------------------------------------

