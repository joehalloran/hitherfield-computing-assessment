<?php
/*
Template Name: Pupil Directory
*/

if ( !is_user_logged_in() ) {  
    header('HTTP/1.0 403 Forbidden');

    get_template_part('template-part', '403');

    exit;

}
?>

<?php get_header(); ?>

<?php get_template_part('template-part', 'head'); ?>

<?php get_template_part('template-part', 'topnav'); ?>

    <!-- start content container -->
    <div class="row dmbs-content">

        <?php //left sidebar ?>
        <?php get_sidebar( 'left' ); ?>

        <div class="col-md-<?php devdmbootstrap3_main_content_width(); ?> dmbs-main">
         <h1><?php _e('Pupil directory','devdmbootstrap3'); ?></h1>
         
         <?php 

         $taxCache = 'cat_pupil_name';

         $topLevelTerms = get_terms( array(
		    'taxonomy' => $taxCache,
		    'hide_empty' => false,
		    'parent' => 0,
		) );

		foreach ($topLevelTerms as $topLevelTerm) {
			
			echo '<h2>'.$topLevelTerm->name.'</h2>';
			echo '<ul>';

			$childTerms = get_terms( array(
			    'taxonomy' => 'cat_pupil_name',
			    'hide_empty' => false,
			    'parent' => $topLevelTerm->term_id,
			) );
	
			foreach ($childTerms as $childTerm) {
				echo '<li><a href="'.site_url().'/'.$taxCache.'/'.$childTerm->slug.'">'.$childTerm->name.'</a></li>';
			
			}

			echo '</ul>';
		}
		?>

        </div>

        <?php //get the right sidebar ?>
        <?php get_sidebar( 'right' ); ?>

    </div>
    <!-- end content container -->

<?php get_footer(); ?>