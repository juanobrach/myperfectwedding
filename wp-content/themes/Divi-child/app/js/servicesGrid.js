(function($){
  $(document).ready(function(){

    function toggleImageOpacity(container){
      var velocity = [1500,2000,1700,1800];
      var inteval = 2000;
      //var container = container;
      var $container = $("#grid_categories");
  

      var $picture_container = $container.children().find('.pictures');
      $picture_container.each(function(i, pictures){
        var randVelocity = velocity[ Math.floor(Math.random()*velocity.length )];
        // Options
        var photoLeave = {
         opacity:0,
        };
        var photoEnter = {
         opacity:1, 
        };

        if( ($(pictures).children() ).length > 1 ){
          console.log("a")
          var actualPhoto = $ ( $(pictures).find('.showMe') );
          $(actualPhoto).removeClass('showMe').animate(photoLeave,randVelocity)

          if( actualPhoto.next().length > 0 ){
            actualPhoto.next().addClass('showMe').animate(photoEnter,randVelocity)
          }else{
            console.log( $(pictures).children().first() )
            $(pictures).children().first().addClass('showMe').animate(photoEnter,randVelocity)
          }

        }



       
      })
    }
    toggleImageOpacity();
    setInterval( toggleImageOpacity , 4000);
     
  })
  
})(jQuery)
