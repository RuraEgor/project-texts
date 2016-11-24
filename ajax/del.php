<?php
require_once '../config.php';

$_POST['name'] = (isset($_POST['name']))?$_POST['name']:'&&&';


if($_POST['name'] != '&&&') {

$nameDel = $_POST['name'];
$nomEl = array();

//------  ОПРЕЛЕЛЕНИЕ НОМЕРА ЭЛЕМЕНТА  ---------
$nomElem = mysql_query(" SELECT `number`,`group` FROM `links_wr` WHERE `id` = '".$nameDel."' ");

while( $roww = mysql_fetch_assoc($nomElem)) {
	$nomEl[0] = $roww['number'];  //-- номер удаляемой ссылки
	$nomEl[1] = $roww['group'];  //-- группа удаляемой ссылки
}



//------  УДАЛЕНИЕ НУЖНОГО ЭЛЕМЕНТА  ----------
	$prov = mysql_query(" DELETE FROM `links_wr` WHERE ( `id` = '".$nameDel."' ) ");

//------  ПРОВЕРКА СУЩЕСТВОВАНИЯ УДАЛЁННОГО ЭЛЕМЕНТА  ----------
if($prov) {$mes[0] = "Ссылка \"".$_POST['name']."\" не была удалена!"; $mes[1] = 2;}


//-- БЛОК ОПРЕДЕЛЕНИЯ КОЛИЧ. ССЫЛОК В КАТЕГОРИИ
$pes = mysql_query(" SELECT COUNT(*) FROM `links_wr` WHERE `group` = '".$nomEl[1]."' ");
$row = mysql_fetch_row($pes);
$count = $row[0];
mysql_query(" UPDATE `group_wr` SET `kol` = '".$count."' WHERE `name` = '".$nomEl[1]."' ");


//------ ФОРМИРОВАНИЕ НОВОГО ПОРЯДКА НОМЕРОВ  ---------
for($i = $nomEl[0]; $i < ($count + 1); $i++){
	$x = $i + 1;
	
	mysql_query(" UPDATE `links_wr` SET `number`='".$i."' WHERE `group` = '".$nomEl[1]."' AND `number` = '".$x."' ");
}


	if($prov){
		header('Content-Type: application/json;charset=utf-8');		
		print json_encode($nomEl[1]);
	}

}


//---------------------------------------------------------------------