jQuery(document).ready(function($) {
		jQuery.noConflict();

		$(".js-img-viwer").SmartPhoto();

		$('.responsiveGallery-wrapper').responsiveGallery({
			animatDuration: 400,
			$btn_prev: $('.responsiveGallery-btn_prev'),
			$btn_next: $('.responsiveGallery-btn_next')
		});

});
