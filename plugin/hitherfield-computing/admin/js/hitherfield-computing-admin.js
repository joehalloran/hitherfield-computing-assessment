/*
 * Attaches the image uploader to the input field
 */
jQuery(document).ready(function($){
    
    // Add files / images to additional resources
    $('#insert-media-button').on('click', function(e){
        alert("Remember, these images will go online. Try and include a photo that does not show your face.");
    });

    //Create list to be populated with pupil names.
    var pupilNamesList = [];

    // Populate list with pupil names. 
    // These values come from class-hitherfield-computing-admin.php enqueue_scripts();
    // Values are transfered to JS using wp_localize_script hack
    pupil_names.forEach(function(item) {
    	pupilNamesList.push(item);
	});

    // Set up autocomplete on pupil names.
    $( "#pupil-name-input" ).autocomplete({
        source: pupilNamesList
    });


    //TODO Define this as a fucntion to avoid repetition.

    $( "#pupil-name-input" ).keydown(function() {
    	console.log($("#pupil-name-input").val());
    	console.log($.inArray( $("#pupil-name-input").val(), pupilNamesList));
	 	if ( ($.inArray( $("#pupil-name-input").val(), pupilNamesList )) ) {
      		$("#pupil-name-input-help").text('Not in list');
      	} else {
      		$("#pupil-name-input-help").text('');
      	}
	});

	$(  "#pupil-name-input" ).on( "autocompleteselect", function( event, ui ) {
		console.log($("#pupil-name-input").val());
    	console.log($.inArray( $("#pupil-name-input").val(), pupilNamesList));
	 	if ( ($.inArray( $("#pupil-name-input").val(), pupilNamesList )) ) {
      		$("#pupil-name-input-help").text('Not in list');
      	} else {
      		$("#pupil-name-input-help").text('');
      	}
	} );


});