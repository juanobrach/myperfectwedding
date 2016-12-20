(function($){

  $(window).load(function(){
    // init Masonry
  $(".fancybox").fancybox();


    if( true ){
      var $grid = $('.grid').masonry({
            itemSelector: '.grid-item',
            columnWidth: '.grid-sizer',
      });
      $grid.imagesLoaded().progress( function() {
  			$grid.masonry('layout');
			});
    }

  })
})(jQuery)
