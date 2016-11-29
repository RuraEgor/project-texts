<?php

require_once '../config.php';

$_POST['vodca'] = (isset($_POST['vodca']))?$_POST['vodca']:'&&&';

if($_POST['vodca'] != '&&&') {

$mes = array();
$per = mysql_query(" SELECT `name`,`view` FROM `group_wr` ORDER BY `number` ASC ");

while ($row = mysql_fetch_assoc($per)) 
{
	$mes['name'][] = $row['name'];
	$mes['view'][] = $row['view'];
}

/*   загатовка для вывода 

 $res = mysql_query("SELECT COUNT(*) FROM table_name");
 $row = mysql_fetch_row($res);
 $total = $row[0];
*/

header('Content-Type: application/json');
print json_encode($mes);

}

//------------  СОЗДАНИЕ НОВОЙ КАТЕГОРИИ  ---------
$_POST['name'] = (isset($_POST['name']))?$_POST['name']:'&&&';

$_POST['background'] = (isset($_POST['background']))?$_POST['background']:'&&&';

$_POST['context'] = (isset($_POST['context']))?$_POST['context']:'&&&';


	if(isset($_POST['background'])) {
		if($_POST['background'] == '#000000') {$_POST['background'] = '#74AAF6';}
	} else {
		$_POST['background'] ='#74AAF6';
	}

if($_POST['name'] != '&&&') {
	
$root = false;
$mes = array();
$per = mysql_query(" SELECT `name` FROM `group_wr` ORDER BY `id` ");

while ($row = mysql_fetch_assoc($per)){
	if($row['name'] == $_POST['name']) { $root = true; }
}

	if($root != true){
		$myq = "INSERT INTO `group_wr` (`name`,`background`,`context`) VALUES ('".$_POST['name']."','".$_POST['background']."','".$_POST['context']."')";
		$prov = mysql_query($myq);
		
		$id_link = mysql_insert_id();  //--  ОПРЕДЕЛЕНИЕ "ID" ПОСЛЕДНЕГО СОЗДАННОГО ЭЛЕМЕНТА
		
		//--  ОПРЕДЕЛЕНИЕ ОБЩЕГО КОЛИЧЕСТВА КАТЕГОРИЙ
		$pes = mysql_query(" SELECT COUNT(`id`) FROM `group_wr` ");
		$row = mysql_fetch_row($pes);
		$count = $row[0];
		
		//-- ВСТАВКА НОМЕРА ССЫЛКИ В ГРУППЕ
		mysql_query(" UPDATE `group_wr` SET `number` = '".$count."' WHERE `id` = '".$id_link."' ");
	
		if($prov)$mes = 1; else $mes = 0;
		
		header('Content-Type: application/json');
		print json_encode($mes);
	}
}

//----------------------------------------------------------------------------------------------------------------

//------  СОЗДАНИЕ НОВОЙ КАТЕГОРИИ  ---------
$nameDelCat = (isset($_POST['nameDelCat']))?$_POST['nameDelCat']:'&&&';


if($nameDelCat != '&&&') {

$nomEl = array();

//------  ОПРЕЛЕЛЕНИЕ ИМЕНИ КАТЕГОРИИ  ---------
$nomElem = mysql_query(" SELECT `name`,`kol`,`number` FROM `group_wr` WHERE `id` = '".$nameDelCat."' ");
$paramGr = mysql_fetch_row($nomElem);

	

//------  УДАЛЕНИЕ ВСЕХ ССЫЛОК СВЯЗАННЫХ С КАТЕГОРИЕЙ
for($i = 0; $i < $paramGr[1]; $i++){
	$provLin = mysql_query(" DELETE FROM `links_wr` WHERE ( `group` = '".$paramGr[0]."' ) ");
}

//------  УДАЛЕНИЕ САМОЙ КАТЕГОРИИ  ---------
$provLin = mysql_query(" DELETE FROM `group_wr` WHERE `id` = '".$nameDelCat."' ");


//-- БЛОК ОПРЕДЕЛЕНИЯ КОЛИЧ. КАТЕГОРИЙ
$pess = mysql_query(" SELECT COUNT(*) FROM `group_wr` ");
$roww = mysql_fetch_row($pess);
$count = $roww[0];


//------ ФОРМИРОВАНИЕ НОВОГО ПОРЯДКА НОМЕРОВ КАТЕГОРИЙ  ---------
for($i = $paramGr[2]; $i < ($count + 1); $i++){
	$x = $i + 1;
	
	mysql_query(" UPDATE `group_wr` SET `number`='".$i."' WHERE `number` = '".$x."' ");
}

	if($provLin){
		header('Content-Type: application/json; charset=utf-8');		
		//print json_encode($nomEl[1]);
		print json_encode('4');
	}

}



//----------------------------------------------------------------------------------------------------------------

//------  ОБНОВЛЕНИЕ КАТЕГОРИИ  ---------

//----- взятие данных
$UPDATE_GROUP = (isset($_POST['UPDATE_GROUP']))?$_POST['UPDATE_GROUP']:'&&&&';

$mes = array();

if($UPDATE_GROUP != '&&&&') {

	$per = mysql_query(" SELECT * FROM `group_wr` WHERE `id` = $UPDATE_GROUP ");

	while ($row = mysql_fetch_assoc($per)) 
	{
		$mes[0] = $row["id"];
		$mes[1] = $row["name"];
		$mes[2] = $row["background"];
		$mes[3] = $row["context"];
		$mes[4] = $row["data"];
	}

	header('Content-Type: application/json; charset=utf-8');
	print json_encode($mes);
} 


//----- замена данных
$UPD_GR_F = (isset($_POST['UPDATE_GROUP_FULL']))?$_POST['UPDATE_GROUP_FULL']:'&&&&';

$mes = array();
$nameCat = "";

if($UPD_GR_F != '&&&&') {


	$per = mysql_query(" SELECT `name` FROM `group_wr` WHERE `id` = '".$UPD_GR_F[0]."' ");

	while ($row = mysql_fetch_assoc($per)) 
	{
		$nameCat = $row['name'];
	}


	$per = mysql_query(" SELECT `name` FROM `group_wr` WHERE `id` NOT IN ('".$UPD_GR_F[0]."')");

	$povt_cat = 1;

	//--  проверка на одинаковость имён
	while ($row = mysql_fetch_assoc($per)) 
	{

		if( $UPD_GR_F[1] == $row["name"] ) {
			$povt_cat = 0;
		}
	}

	$apdate = 0;  //--  флаг

	if($povt_cat) {
		//--  обновление элемента
		$apdate = mysql_query(" UPDATE `group_wr` SET `name` = '".$UPD_GR_F[1]."', `background` = '".$UPD_GR_F[2]."',  `context` = '".$UPD_GR_F[3]."',  `view` = '".$UPD_GR_F[4]."' WHERE id = '".$UPD_GR_F[0]."' ");

	//-----


		if($apdate) { $apdate = mysql_query(" UPDATE `links_wr` SET `group` = '".$UPD_GR_F[1]."'  WHERE `group` = '".$nameCat."' "); }
	}


	//--  проверка выполнения обновления
	if($apdate) { $mes[0] = 1;	} else { $mes[0] = 0;	}

	if( $mes[0] == 1 ) {

		$mes[1] = $UPD_GR_F[1];
		$mes[2] = $nameCat;
	}


	header('Content-Type: application/json; charset=utf-8');
	print json_encode($mes);
} 

//------  КОНЕЦ ОБНОВЛЕНИЕ КАТЕГОРИИ  -------------------------------------------------