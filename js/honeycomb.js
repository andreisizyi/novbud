jQuery(function($){
    //Показываем соты
    $(document).ready(function() {
        $(".row-honeycomb").addClass('honeycomb-load');
	});
});
//Меняем фон при наведении на соту
//Ожидаем завершение наведения
function hoverhoneycomb() {
	if (jQuery(window).width() < 992) {
	   jQuery('.honeycomb-in').click(
		function() {
			var href = $(this).attr('href');
			event.preventDefault()
			var url = jQuery(this).attr('data-thumbnail');
			var bg = 'url(' + url + ')';
			if  (url) {
				jQuery("<img />").attr("src", url).load(function() {
					if (!url == '') {
						jQuery('body.home').css('background-image', bg);
						document.location.href = href;
					}
				});
			} else {
				document.location.href = href;
			}
		}
	);
	}
	else {
		var timeoutIn;
		jQuery('.honeycomb-in').hover(
			function() {
				var url = jQuery(this).attr('data-thumbnail');
				var bg = 'url(' + url + ')';
				timeoutIn = setTimeout(function(){
					jQuery("<img />").attr("src", url).load(function() {
						if (!url == '') {
							jQuery('body.home').css('background-image', bg);
						}
					});
				}, 600);
			},
			function() {
				if (timeoutIn){
					clearTimeout(timeoutIn);
				}
			}
		);
	}
}
hoverhoneycomb();
//Размещаем соты в нужных контейнерах
jQuery(window).resize(function() {
  if (!allredy) {
    honeycomb(0)
  } else {
    honeycomb(1)
  }
});
function honeycomb(i) {
  //Обнуляем верстку сот
  if (jQuery('.honeycomb').parent('.col-7').length) {
    jQuery('.honeycomb').unwrap();
  }
  jQuery('.honeycomb').removeClass('x2').removeClass('x22').removeClass('x23');
  //Выполняем проверку для разрешений экрана
  if (jQuery(window).width() < 992) {
    //Размещаем соты в 3 столбца
    var a = 3 + i;
    var b = i + 4;
    var c = i + 7;
    var d = i + 8;
    var f = i + 10;
    jQuery('.honeycomb:nth-child(-n+' + a + ')').addClass("x2");
    jQuery('.honeycomb:nth-child(n+' + b + '):nth-child(-n+' + c + ')').addClass("x22");
    jQuery('.honeycomb:nth-child(n+' + d + '):nth-child(-n+' + f + ')').addClass("x23");
    var col = '<div class="col-7"></div>';
    jQuery(".x2").wrapAll(col);
    jQuery(".x22").wrapAll(col);
    jQuery(".x23").wrapAll(col);
  } else {
    //Размещаем соты в 7 столбцов
    var a = i + 1;
    var b = i + 2;
    var c = i + 5;
    var d = i + 8;
    var e = i + 3;
    var f = i + 6;
    var m = i + 9;
    jQuery('.honeycomb:nth-child(3n+' + a + ')').wrap('<div class="col-7"></div>');
    jQuery('.honeycomb:nth-child(' + b + '), .honeycomb:nth-child(' + e + ')').addClass("x2");
    jQuery('.honeycomb:nth-child(' + c + '), .honeycomb:nth-child(' + f + ')').addClass("x22");
    jQuery('.honeycomb:nth-child(' + d + '), .honeycomb:nth-child(' + m + ')').addClass("x23");
    var col = '<div class="col-7"></div>';
    jQuery(".x2").wrapAll(col);
    jQuery(".x22").wrapAll(col);
    jQuery(".x23").wrapAll(col);
  }
}
//Переменная помогает узнать о совершении первого действия
var allredy = false;
//Добавляем css стиль 0 opacity
function addcss() {
	if (!allredy) {
		allredy = true;
        var ss = document.createElement("link");
		ss.rel = "stylesheet";
		ss.href = "//macroproject.dev.cc/wp-content/themes/macroproject/css/appendstyle.css";
		ss.type = "text/css";
		ss.media = "all";
		document.getElementsByTagName("head")[0].appendChild(ss);
		//console.log('CSS файл добавлен');
    }
}
//Проверка кнопок на отображение
function arrowdisplay(pagenumber,pagemax,_this) {
	if (_this.hasClass('btn-next-clients')) { ;
		if (pagenumber == pagemax - 1) {
			_this.removeClass('visible-nav');
		}
		if (pagenumber <= pagemax && pagenumber > 0) {
			jQuery('.btn-back-clients').addClass('visible-nav');
		}
	} else {
		if (pagenumber == 2 ) {
			_this.removeClass('visible-nav');
		}
		if (pagenumber < pagemax + 1) {
			jQuery('.btn-next-clients').addClass('visible-nav');
		}
	}
}
jQuery(function($) {
	//Узнаем, сколько страниц чтобы знать, показывать кнопки или нет
	if ($('.a-btn').attr('data-page-max') < 1 ) {
		$('.a-btn').removeClass('visible-nav');
	};
	honeycomb(0);
	var tpl = $('.btn-next-clients').attr('data-tpl');
	$('.btn-next-clients').on('click', function click() {
		$(this).unbind('click');
		let _this = $(this);
		let pagenumber = Number(_this.attr('data-page-number'));
		let pagemax = Number(_this.attr('data-page-max')) + 1;
		//console.log(pagenumber);
		//console.log(pagemax);
		//Выполнять если количество страниц до последней
		if (pagenumber < pagemax) {
			//Инверсный обход элементов
			var invertelements = jQuery('.honeycomb').get().reverse();
				$(invertelements).each($).wait(50, function(index) {
				jQuery(this).css('opacity','0');
			});
			setTimeout( function() {
				addcss();
				let data = {
					'action': 'loadmore',
					'query': _this.attr('data-param-posts'),
					'tpl': _this.attr('data-tpl'),
					'page-number': _this.attr('data-page-number'),
					'other-posts': _this.attr('data-other-posts'),
					'direction': _this.attr('data-direction')
				}
				var countpage = _this.attr('data-max-pages');
				$.ajax({
					url: '/wp-admin/admin-ajax.php',
					data: data,
					type: 'POST',
					success: function(data) {
						if (data != 0) {
							$('.loop-portfolio-clients').html(data);
							tpl++;
							$('.btn-back-clients').attr('data-tpl',tpl);
							$('.btn-next-clients').attr('data-tpl',tpl);
							honeycomb(1);
							//Инверсный обход элементов
							var invertelements = jQuery('.honeycomb').get().reverse();
							jQuery('.honeycomb').css('opacity','0');
							$(invertelements).each($).wait(50, function(index) {
								jQuery(this).css('opacity','1');
							});
							_this.bind('click', click);
							arrowdisplay(pagenumber,pagemax,_this);
							hoverhoneycomb();
						}
					}
				});
			}, 300)
		}  else {
			_this.bind('click', click);
		}
	});
	$('.btn-back-clients').on('click', function click() {
		$(this).unbind('click');
		let _this = $(this);
		let pagenumber = Number(_this.attr('data-page-number'));
		let pagemax = Number(_this.attr('data-page-max')) + 1;
		//console.log(pagenumber2);
		//console.log(pagemax2);
		//Выполнять если количество страниц в пределах от 1 до последней
		if (pagenumber <= pagemax && pagenumber > 1) {
			jQuery('.honeycomb').each($).wait(50, function(index) {
				jQuery(this).css('opacity','0');
			});
			setTimeout( function() {
				let data = {
					'action': 'loadmore',
					'query': _this.attr('data-param-posts'),
					'tpl': _this.attr('data-tpl'),
					'elements': _this.attr('data-elements'),
					'page-number': _this.attr('data-page-number'),
					'other-posts': _this.attr('data-other-posts'),
					'direction': _this.attr('data-direction')
				}
				var countpage = _this.attr('data-max-pages');
				$.ajax({
					url: '/wp-admin/admin-ajax.php',
					data: data,
					type: 'POST',
					success: function(data) {
						if (data != 0) {
							$('.loop-portfolio-clients').html(data);
							tpl -= 1;
							$('.btn-back-clients').attr('data-tpl',tpl);
							$('.btn-next-clients').attr('data-tpl',tpl);
							honeycomb(1);
							jQuery('.honeycomb').css('opacity','0');
							jQuery('.honeycomb').each($).wait(50, function(index) {
								jQuery(this).css('opacity','1');
							});
							_this.bind('click', click);
							arrowdisplay(pagenumber,pagemax,_this);
							hoverhoneycomb();
						}
					}
				});
			}, 300)
		} else {
			_this.bind('click', click);
		}
	});
});