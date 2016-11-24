$(document).ready(function(){


//---------- КНОПКА ВЫВОДА ВСЕХ ИМЕЮЩИХСЯ ССЫЛОК -----	
//---------- КНОПКА ВЫВОДА ССЫЛОК КАТЕГОРИИ "ГЛАВНЫЕ" -----	
//---------- ВЫВОД СПИСКА ИЗ ДВАДЦАТИ ПОСЛЕДНИХ СОЗДАННЫХ ССЫЛОК  ---
//---------- ВЫВОД СПИСКА КАТЕГОРИЙ ВКЛАДОК ---------
//---------- ОБНОВЛЕНИЕ ЭЛЕМЕНТА  ------------------------
//---------- ОБНОВЛЕНИЕ ЭЛЕМЕНТА 2 ------------------------

//---------- ФУНКЦИИ  -----


//------------  УДАЛЕНИЕ ССЫЛКИ  --------------
$('#all_group .del').live('click', function(){
/*
	var nom = $(this).closest('li').attr('id_number');
	var elemNom = $(this).closest('li').index();
	var elemNomName = $(this).closest('li').find('h3').text();
*/
	var nom = $(this).closest('li').attr('id_number');
	var elemNomName = $(this).closest('li').find('h3 a').text();

	
	if(confirm("Вы действительно хотите удалить данную категорию со всеми относящимеся к ней ссылками \"" + 
	elemNomName + "\" ?")) {
	
	//alert(nom);
	//alert(elemNomName);
		
		$.ajax({

			url: 'ajax/add_del_group.php',
			type: 'post',
			dataType: 'json',
			data: { nameDelCat: nom },
			success: function(data) {				
				
				//--  ВНЕШНЕЕ УДАЛЕНИЕ ЭЛЕМЕНТА ИЗ СИСТЕМЫ
				$("#all_group ul li").each(function(){
					if( $(this).attr('id_number') == nom ) {$(this).remove();}
				});
				
				//--  НУМЕРОВАНИЕ ЭЛЕМЕНТОВ
				$("#all_group .number").each(function(indx, element){
				  $(element).text(indx + 1);	  
				});				
				
				//--  ВЫВОД ВСПЛЫВАЮЩЕГО ОКНА
				$(".alert_mess").text('Категория \"'+ elemNomName +'\" и все её ссылки были удалены!').fadeIn(500).delay(1500).fadeOut(500);	
				
			}
		});
		
		vent.stopImmediatePropagation(); 
		return false;
	}
	
});

//--------------


//------------  РЕДКАТИРОВАНИЕ КАТЕГОРИИ  --------------
$('#all_group .apdate').live('click', function(){

	$('#modal_wind').show(100);
	$('#wrap_form').show(100);
	$('#group_apdate').slideDown(300);
	$('#all_group').slideUp(150);

	
	// $('#apdate_form select').html('');
	

		//$.ajax({


	return false;
});



//------------------

//------------  РЕДКАТИРОВАНИЕ КАТЕГОРИИ  --------------
$('#all_group .apdate').live('click', function(){

	$('#modal_wind').show(100);
	$('#wrap_form').show(100);
	$('#group_apdate').slideDown(300);
	$('#all_group').slideUp(150);

	var ar_clElemDt = [];

	var clElemDt = $(this).closest('li');

	ar_clElemDt[0] = clElemDt.attr("id_number");

	
    $.ajax({
		url: "ajax/add_del_group.php",
		type: 'post',
		dataType: 'json',
		data: { UPDATE_GROUP: ar_clElemDt[0] },
		success: function(data) {

			//-- вывод номера категории
			$('#group_apdate').attr("data-id", data[0]);

			//-- вывод имени категории
			$('#group_apdate #name_group').val(data[1]);

			//-- вывод фона
			$('#group_apdate #backg_group_color').val(data[2]);

			//-- вывод описания
			$('#group_apdate #title_group').val(data[3]);		
			
		}
	});
	

	return false;
});


//------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------

$('#group_apdate #but_send_group').live('click', function(){
	
	var ar_clElemDt = [];

	//-- вывод номера категории
	ar_clElemDt[0] = $('#group_apdate').attr("data-id");

	//-- вывод имени категории
	ar_clElemDt[1] = $('#group_apdate #name_group').val();

	//-- вывод фона
	ar_clElemDt[2] = $('#group_apdate #backg_group_color').val();

	//-- вывод описания
	ar_clElemDt[3] = $('#group_apdate #title_group').val();

	//-- отправка данных редактируемой категории
    $.ajax({
		url: "ajax/add_del_group.php",
		type: 'post',
		dataType: 'json',
		data: { UPDATE_GROUP_FULL: ar_clElemDt },
		success: function(data) {

			$(".alert_mess").text('Название категории "' + data[2] + '" изменена на "' + data[1] + '" ').fadeIn(500).delay(1500).fadeOut(500);	
		}
	});


});




//------------------------------------
//------------------------------------
});