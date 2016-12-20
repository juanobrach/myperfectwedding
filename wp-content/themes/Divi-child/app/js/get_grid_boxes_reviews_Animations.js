(function($){
	$(document).ready(function(){
		if( $("body").hasClass('home')){
			var scrollLock = false;
			$(window).scroll( change_opacity )
			function change_opacity(){
				console.log("change opacity");
				if( !scrollLock ){
					var review_title = $("#review_title").offset().top;
					if( ( review_title - $(window).scrollTop()-142) <=  230 ){
						scrollLock = true;
						var $contentBoxex =  $("#grid_reviews section").children();
				    $contentBoxex.each(function(i,e){
				   	 	if( $(e).hasClass('content-box')){
				   	 		$(e).addClass('scale_and_opacity_fx')
				   	 	}
				   	})
					}
				}
			}	
		}
		if( $("body").hasClass("page-testimonials")){
			var $contentBoxex =  $("#grid_reviews section").children();
	    $contentBoxex.each(function(i,e){
	   	 	if( $(e).hasClass('content-box')){
	   	 		$(e).addClass('scale_and_opacity_fx')
	   	 	}
	   	})
		}
	})
})(jQuery)
