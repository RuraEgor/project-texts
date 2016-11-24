<?php

require_once '../config.php';

$_POST['nameLinks'] = (isset($_POST['nameLinks']))?$_POST['nameLinks']:'&&&';

if($_POST['nameLinks'] != '&&&') {

$nameLinks = $_POST['nameLinks'];
$flag = 0;


	for($i = 0; $i < count($nameLinks); $i++){
		
	
		//------  ОПРЕЛЕЛЕНИЕ НОМЕРА ЭЛЕМЕНТА  ---------
		$nomElem = mysql_query(" SELECT `number`,`group` FROM `links_wr` WHERE `id` = '".$nameLinks[$i]."' ");

		while( $roww = mysql_fetch_assoc($nomElem)) {
			$nomEl[0] = $roww['number'];  //-- номер удаляемой ссылки
			$nomEl[1] = $roww['group'];  //-- группа удаляемой ссылки
		}


		//------  УДАЛЕНИЕ НУЖНОГО ЭЛЕМЕНТА  ----------
			$prov = mysql_query(" DELETE FROM `links_wr` WHERE ( `id` = '".$nameLinks[$i]."' ) ");

		
		if($prov){	//------  ПРОВЕРКА СУЩЕСТВОВАНИЯ УДАЛЁННОГО ЭЛЕМЕНТА  ----------

			//-- БЛОК ОПРЕДЕЛЕНИЯ КОЛИЧ. ССЫЛОК В КАТЕГОРИИ
			$pes = mysql_query(" SELECT COUNT(*) FROM `links_wr` WHERE `group` = '".$nomEl[1]."' ");
			$row = mysql_fetch_row($pes);
			$count = $row[0];
			mysql_query(" UPDATE `group_wr` SET `kol` = '".$count."' WHERE `name` = '".$nomEl[1]."' ");
		/**/
			//------ ФОРМИРОВАНИЕ НОВОГО ПОРЯДКА НОМЕРОВ  ---------
			for($j = $nomEl[0]; $j < ($count + 1); $j++){
				$x = $j + 1;
				
				mysql_query(" UPDATE `links_wr` SET `number`='".$j."' WHERE `group` = '".$nomEl[1]."' AND `number` = '".$x."' ");
			}
		}
		
	}
	
	
//if($prov) {
	header('Content-Type: application/json; charset=utf-8');	
	print json_encode("yes");
//}

}