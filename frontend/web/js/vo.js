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


//javascript for display package price once package is selected from dropdown.
$('select#package').on('change', function() {
  if ( this.value == 1 ){
  	$("input:text").val(100);
  } else if ( this.value == 2 ){
  	$("input:text").val(200);
  } else if( this.value == 3 ){
  	$("input:text").val(300);
  }
});



//javascript for alert fade.
window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 4000);



// javascript for user profile sidemenu in mobile view.
$(document).ready(function () {
    $('#slide-nav.navbar .container').append($('<div id="navbar-height-col"></div>'));
    var toggler = '.navbar-toggle';
    var pagewrapper = '#page-content';
    var navigationwrapper = '.navbar-header';
    var menuwidth = '100%'; 
    var slidewidth = '40%';
    var menuneg = '-100%';
    var slideneg = '-40%';
    $("#slide-nav").on("click", toggler, function (e) {
        var selected = $(this).hasClass('slide-active');
        $('#slidemenu').stop().animate({
            left: selected ? menuneg : '0px'
        });
        $('#navbar-height-col').stop().animate({
            left: selected ? slideneg : '0px'
        });
        $(pagewrapper).stop().animate({
            left: selected ? '0px' : slidewidth
        });
        $(navigationwrapper).stop().animate({
            left: selected ? '0px' : slidewidth
        });
        $(this).toggleClass('slide-active', !selected);
        $('#slidemenu').toggleClass('slide-active');
        $('#page-content, .navbar, body, .navbar-header').toggleClass('slide-active');
    });
    var selected = '#slidemenu, #page-content, body, .navbar, .navbar-header';
    $(window).on("resize", function () {
        if ($(window).width() > 991 && $('.navbar-toggle').is(':hidden')) {
            $(selected).removeClass('slide-active');
        }
    });
});

$(document).ready(function(){
    $('.img-slider').bxSlider();
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

