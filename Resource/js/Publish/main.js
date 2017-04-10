
		tinymce.init({
			selector: '#text'
		});
$('.slider').slider({full_width: true});

 // Initialize collapse button
//$('.fixed-action-btn').openFAB();

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
    
$("#art").submit(function(e){
  e.preventDefault();
var editor = tinymce.EditorManager.get('text');
  $.ajax({
    type:"POST",
    data:{
      title:$("#title").val(),
      text:editor.getContent(),
    },
    success:function(data) {
      window.location.href=data.results;
    },
    error:function(data) {
      
      if( data.statusText == "title_EMPTY"){
        sweetAlert("Oops...", "標題請超過三個字", "error"); 
      }
      if( data.statusText == "text_EMPTY"){ 
        sweetAlert("Oops...", "內文請超過十個字", "error");
      }
    }

  })

});