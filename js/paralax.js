jQuery(function($) {
    function paralax(v1, v2 = v1) {
		var $el = $('.parallax-background');
		$(window).on('scroll', function () {
			var scroll = $(document).scrollTop();
			$el.css({
				'background-position':'50% '+(v1*scroll)+'px'
			});
		});
		var $el2 = $('.parallax-shadow');
		$(window).on('scroll', function () {
			var scroll = $(document).scrollTop();
			$el2.css({
				'background-position':'50% '+(v2*scroll)+'px'
			});
		});
	}

	$(window).resize(function() {
	  if ($(window).width() < 992) {
			paralax(.2);
	  }
	 else {
		paralax(-.7, .7);
	 }
	});
	  if ($(window).width() < 992) {
			paralax(.2);
	  }
	 else {
		paralax(-.7, .7);
	 }
});