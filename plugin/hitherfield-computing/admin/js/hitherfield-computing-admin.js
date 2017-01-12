/*
 * Attaches the image uploader to the input field
 */
jQuery(document).ready(function($){

    // Defines pupil name help text. Checks whether name exists.
    function pupilNameHelp(pupilNamesList) {
      if ($("#pupil-name-input").val() == "") {
          $("#pupil-name-input-help").text('Please write your name');
      } else if ( ($.inArray( $("#pupil-name-input").val(), pupilNamesList )) ) {
          $("#pupil-name-input-help").text('This name does not exist.');
      } else {
        $("#pupil-name-input-help").text('');
      }
    }
    
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

    // Set up autocomplete on pupil names. Using jQuery UI
    $( "#pupil-name-input" ).autocomplete({
        source: pupilNamesList
    });

    // set initial pupil name help text
    pupilNameHelp(pupilNamesList);

    //When typing pupil name set help text
    $( "#pupil-name-input" ).keydown( function() {
         pupilNameHelp(pupilNamesList);
    });
    //When selected pupil name set help text	 	
	  $( "#pupil-name-input" ).on( "autocompleteselect",  function() {
      pupilNameHelp(pupilNamesList);
    });


});