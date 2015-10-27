(function ($, Drupal, window, document, undefined) {

Drupal.behaviors.utexasPromoListResponsive = {
  attach: function(context, settings) {
  	$.fn.equalHeights = function(px) {
		$(this).each(function(){
			var currentTallest = 0;
			$(this).children().each(function(i){
				if ($(this).height() > currentTallest) { currentTallest = $(this).height(); }
			});
			if (!px && Number.prototype.pxToEm) currentTallest = currentTallest.pxToEm(); //use ems unless px is specified
			// for ie6, set height since min-height isn't supported
				if ($.browser.msie && $.browser.version == 6.0) { $(this).children().css({'height': currentTallest}); }
				$(this).children().css({'min-height': currentTallest});
			});
		return this;
	};
	$(window).on("load resize", function () {
		var screen_width = $(window).width();
	 	if (screen_width < 1010){
	 		$('.field_utexas_promo_list .one-column-full-width .promo-list-li').css('width','90%');
			$('.field_utexas_promo_list .one-column').css('width','100%');
			$('.field_utexas_promo_list .two-column .utexas-promo-list-wrapper .promo-list-li').css('min-height','100px');
			$('.field_utexas_promo_list .two-column .promo-list-li').css({ 'margin':'0 5%', 'width':'90%' });
			$('.field_utexas_promo_list .two-column .promo-list-li:nth-child(odd)').css('padding-left', '0px');
		}
		else {
			$('.field_utexas_promo_list .one-column-full-width .promo-list-li').css('width','95%');
			$('.field_utexas_promo_list .one-column').css('width','50%');
			$('.field_utexas_promo_list .two-column .utexas-promo-list-wrapper').equalHeights();
			$('.field_utexas_promo_list .two-column .promo-list-li').css({ 'margin':'0 2.5%', 'width':'45%' });
			$('.field_utexas_promo_list .two-column .utexas-promo-list-wrapper .post-headline').css('min-height','0px');
			$('.field_utexas_promo_list .two-column .promo-list-li:nth-child(odd)').css('padding-left', '7px');
		}
	}).resize();
  }
};

})(jQuery, Drupal, this, this.document);
