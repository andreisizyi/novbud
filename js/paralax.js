jQuery(function($) {
    function paralax(value) {
		var $el = $('.parallax-background');
		$(window).on('scroll', function () {
			var scroll = $(document).scrollTop();
			$el.css({
				'background-position':'50% '+(value*scroll)+'px'
			});
		});
		var $el2 = $('.parallax-shadow');
		$(window).on('scroll', function () {
			var scroll = $(document).scrollTop();
			$el2.css({
				'background-position':'50% '+(-1*value*scroll)+'px'
			});
		});
	}
	
	$(window).resize(function() {
	  if ($(window).width() < 992) {
			paralax(-.12);
	  }
	 else {
		paralax(-.5);
	 }
	});
	  if ($(window).width() < 992) {
			paralax(-.12);
	  }
	 else {
		paralax(-.5);
	 }
});