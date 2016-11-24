<?php
require_once '../config.php';


$_POST['apWriteеText'] = (isset($_POST['apWriteеText']))?$_POST['apWriteеText']:'';
$_POST['textWr'] = (isset($_POST['textWr']))?$_POST['textWr']:'&&&';

if($_POST['apWriteеText'] != '') {

	//$_POST['apWriteеText'] = mysql_real_escape_string($_POST['apWriteеText']);
	
	$apdate = mysql_query(" UPDATE `links_wr` SET `write_text` = '".$_POST['apWriteеText']."'  WHERE `id` = ".$_POST['textWr']." ");

	$men = "777";

}

else {

	$men = "111";
}

	header('Content-Type: application/json');
	print json_encode($men);

//---------------------------------------------------------------------------