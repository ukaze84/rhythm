$('.slider').slider({full_width: true});


$('.button-collapse').sideNav({
      menuWidth: 300, // Default is 240
      edge: 'left', // Choose the horizontal origin
      closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
      left: 0
    }
);

      // Show sideNav
$('.sidebar icon').click(function(){

	$('.button-collapse').sideNav('show');
	//$('.fixed-action-btn').closeFAB();

});


  // Hide sideNav
$('.button-collapse').sideNav('hide');


$('.parallax').parallax();


    
