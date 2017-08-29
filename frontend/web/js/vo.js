$("#mainNav a,.intro-text a").on('click',function(event){
	if (this.hash !== ""){
		event.preventDefault();

		var hash = this.hash;

		$('html,body').animate({
			scrollTop:$(hash).offset().top
			},800,function(){
				window.location.hash = hash;
			});
		
	}
});

$('select#package').on('change', function() {
  if ( this.value == 1 ){
  	$("input:text").val(100);
  } else if ( this.value == 2 ){
  	$("input:text").val(200);
  } else if( this.value == 3 ){
  	$("input:text").val(300);
  }
});

// (function($) {
//     "use strict"; // Start of use strict

//     // jQuery for page scrolling feature - requires jQuery Easing plugin
//     $('a.page-scroll').bind('click', function(event) {
//         var $anchor = $(this);
//         $('html, body').stop().animate({
//             scrollTop: ($($anchor.attr('href')).offset().top - 50)
//         }, 1250, 'easeInOutExpo');
//         event.preventDefault();
//     });

//     //Highlight the top nav as scrolling occurs
//     $('body').scrollspy({
//         target: '.navbar-fixed-top',
//         offset: 51
//     });

//     // Closes the Responsive Menu on Menu Item Click
//     $('.navbar-collapse ul li a').click(function(){ 
//             $('.navbar-toggle:visible').click();
//     });

//     //Offset for Main Navigation
//     $('#mainNav').affix({
//         offset: {
//             top: 100
//         }
//     })

// })(jQuery); // End of use strict

