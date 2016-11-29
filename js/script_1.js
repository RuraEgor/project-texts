$(document).ready(function(){


//------------  КОНЕЦ КОДА----------
});


//-- введение новых символов
$('#wr_form .textWind').keydown(function(){
  $("#wr_form").addClass('css_change');
  $("#wr_form").removeClass('css_saveChange');
});

//-- сохранение введ. знач
$('#wr_form .but_send.but_send_wr').click(function(){
  $("#wr_form").addClass('css_saveChange');
  $("#wr_form").removeClass('css_change');
});


//-- возврат в первоночальное состояние окна отобр. текста
$('#wr_form .close').click(function(){
  $("#wr_form").removeClass('css_change css_saveChange');
	$("#wr_form").removeClass('fulSz');
	$("#up, #down").removeClass('css_vis');
	hdWrWind();  
});



//---- Ползунок для увеличения шрифта текста

$("#scrlFon").slider({
  // orientation: "vertical",
  value:18,
  min: 5,
  max: 50,
  step: 1,
  slide: function( event, ui ) {
    $( "#wr_form .textWind").css( "fontSize", ui.value );
    $( "#hidTxPl .hidBl").css( "fontSize", ui.value );
    $( "#scrlFon span.ui-slider-handle").text( ui.value );

	if( $("#wr_form").hasClass("fulSz") ){
		setTimeout("oprSizHdWn()",2000);
	}

  }
});


//-----  функция определния размера окна отображения и записи текста
hdWrWind();

function hdWrWind(){
	var doc_h = $(window).height();
	doc_h = doc_h - 230;
	$("#wr_form .textWind").css("height", doc_h);
}


//-----  функция открытия полноразмерного окна
$("#wr_form .opFlSize").click(function(){


	if( $("#wr_form").hasClass("fulSz") ){

		$("#wr_form").removeClass('fulSz');
		$("#up, #down").removeClass('css_vis');
		$('#wr_form .but_send_wr').die('click.siz_wind');
		// $("#wr_form .but_send_wr").off('click'); 
		// $("#wr_form .but_send_wr").bind('click'); 
		// wrt_text_wind();
		hdWrWind();

	} else {

		$("#wr_form").addClass('fulSz');

		$('html,body').animate({scrollTop:0}, 'slow');  //----  прокрутка вверх к началу страницы

		if( oprIfGrWn() ) {  //--- фун. проверки изменения окна редактир. текста

			$("#up, #down").addClass('css_vis');

			// $("#wr_form .but_send_wr").live("click", function(){ alert(55555); } );

			flyRsSizeWn();  //----  функция увеличения окна при сохранении (навешивание события)

			oprSizHdWn();  //-----  функция определния размера БОЛЬШОГО окна отображения и записи текста
		}
	}
});


//----  функция увеличения окна при сохранении
function flyRsSizeWn(){

$("#wr_form.fulSz .but_send_wr").live("click.siz_wind", function(){

	var znTxtWind = $("#wr_form .textWind").val();  //----  копирование изменённого текста
	$("#hidTxPl .hidBl").html(znTxtWind);  //----  вставка изменённого текста в нужную область для оп. разм.

	setTimeout("oprSizHdWn()",700);
})
//-----
}


//-----  функция определния размера БОЛЬШОГО окна отображения и записи текста
function oprSizHdWn(){
	var jsHeigh = $("#wr_form .hidBl").outerHeight();
	
	if(jsHeigh < 1500) { var jsHeigh_d = jsHeigh + (jsHeigh/15); } 
	else { var jsHeigh_d = jsHeigh + (jsHeigh/150); }
	
	$("#wr_form .textWind").css("height", jsHeigh_d );
}

function oprIfGrWn (){  //--- фун. проверки изменения окна редактир текста
	var jsHeigh_1 =$("#wr_form .textWind").outerHeight();
	var jsHeigh_2 = $("#wr_form .hidBl").outerHeight();
	if(jsHeigh_2 < jsHeigh_1) {return false;} else {return true;}
}



//-----  СОЧЕТАНИЕ КЛАВИШ ДЛЯ ПОИСКОВОГО ПОЛЯ
var flag_push = false;

$(document).keyup(function(e){ 	if(e.which == 17) { flag_push = false; } } ).keyup(function (e) {

	if(e.which == 17 ) flag_push = true;
	if(e.which == 91 && flag_push == true ) {
	
		$("#search").select();
	}
});



	
//------  ВЫВОД ДИНАМИЧЕСКОГО СПИСКА ВАРИАНТОВ В ПОИСКОВОМ ОКНЕ
	$("#search").keyup(function(w){
		var znSrch = $(this).val();

		if(znSrch != ""){


			$(this).addClass('css_zn');


			if( !!$(".glob_search").attr("checked") ) {

				//var znSrch_1 = new RegExp(znSrch,'i');

				//---- ВЫВОД ВСЕХ ВОЗМОЖНЫХ СОВПАДЕНИЙ
				if( w.which == 13 ){

					$.ajax({

							url: "ajax/gl_search.php",
							type: 'post',
							dataType: 'json',
							data: { QUERY_ENTER: znSrch },
							success: function(data) {
									

									$("#wrapper ul.bom").empty();  //-- очистка списка								
									
								
									for(var i = 0; i < data.length; i++) {
									
									if(data[i]['choise'] == 1) {data[i]['icon'] = data[i]['screen'];}
									
									$("#wrapper ul.bom").append(
										"<li id_number = '" + data[i]['id'] + "' title = '" + data[i]['data'] + "' data-sec = '" + data[i]['timeCreat'] + "'>\
											<div class='item' title='" + data[i]['title'] + "' style ='background: " + data[i]['background'] + "' ><a href='" + data[i]['links'] + "' rel='" + data[i]['group'] + "' target='_blank' style ='background: url(" + data[i]['icon'] + ") no-repeat center/87% 82%;' ></a> <input type='checkbox' class='delMany'  title='Позваляет отметить ссылки для удаления' />\
											\
												<div class='view_link' title='' style ='background: url(" + data[i]['screen'] + ") no-repeat center/100% 100%;' ></div> \
												\
												<div class='screen' title='Показывает полный скриншот страницы'><a href='" + data[i]['full_screen'] + "' target='_blank'></a></div> \
												\
												<div class='apdate'  title='Позваляет изменить параметры ссылки'></div>\
												\
												<div class='del'  title='Удаляет данную ссылку'></div>\
												\
												<div class='number'>" + data[i]['number'] + "</div> \
											\
											</div>\
											\
											<h3>\
												<a href='" + data[i]['links'] + "' target='_blank'>" + data[i]['name'] + "</a>\
											</h3>\
										</li>");
									}
									
								$('#all_group').slideUp(100);
								$('#modal_wind').slideUp(100);
								$('#wrap_form').slideUp(100);
								$("#all_group ul").empty();

								$("#sel_ch").slideUp("fast");  //--- скрытие списка вариантов поиска

							}	
						});  //---- КОНЕЦ АЯКС ЗАПРОСА

				} else {



				 // отправка данных
				 $.ajax({
					url: "ajax/gl_search.php",
					type: 'post',
					dataType: 'json',
					data: { QUERY: znSrch },
					success: function(data) {
						
						// alert(data);
						// console.log(data);
						$("#sel_ch").slideDown("slow");

						$("#sel_ch").html("");

						
						for(var ii = 0; ii < data['id'].length; ii++){
							$("#sel_ch").append("<li data-sp_id='"+data["id"][ii]+"' id_number='"+data["id"][ii]+"' ><a href='"+data["links"][ii]+"'  target='blank' title='"+data["group"][ii]+"'>"+data["name"][ii]+"</a></li>");
						}

					}
				});  //-- конец аякса


			}		

			} else {

				var znSrch_1 = new RegExp(znSrch,'i');

				$("#wrapper ul li h3 a").each(function(){
					var znLin = $(this).html();
					if( !znSrch_1.test(znLin) ) { $(this).closest("li").hide(500); } else { $(this).closest("li").show(500); }
				});

			}


		} else {
			$(this).removeClass('css_zn');
			$("#wrapper ul li").show(500);
		}
	});

//------ КОНЕЦ -- ВЫВОД ДИНАМИЧЕСКОГО СПИСКА ВАРИАНТОВ В ПОИСКОВОМ ОКНЕ


//-------- отключение hover при прокрутки страницы
var body = document.body,
    timer;

window.addEventListener('scroll', function() {
  clearTimeout(timer);
  if(!body.classList.contains('disable-hover')) {
    body.classList.add('disable-hover')
  }
  
  timer = setTimeout(function(){
    body.classList.remove('disable-hover')
  },500);
}, false);