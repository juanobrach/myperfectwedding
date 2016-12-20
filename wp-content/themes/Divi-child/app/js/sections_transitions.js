(function($){
	$(document).ready(function(){
		$("#et_mobile_nav_menu").click(function(){
			console.log("s");
			$("#nav #top-menu").toggleClass("mobile-display");
		})

		$("#menu-item-287").hover(function(e){
			e.preventDefault();
			return false;
		})


	})
})(jQuery)
