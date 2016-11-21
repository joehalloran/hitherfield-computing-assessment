<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://londonclc.org.uk/
 * @since      1.0.0
 *
 * @package    Hitherfield_Computing
 * @subpackage Hitherfield_Computing/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="ui-widget pupil-name-widget">
  <label for="pupil-name-input">Pupil name: </label>
  <input id="pupil-name-input" name="pupil-name">
</div>
<p id="pupil-name-input-help" style="color: red;"></p>


<?
foreach($pupilNames as $name) {
	$cat_id = get_cat_ID ( $name );
	echo $cat_id.'<br />';
}
?>