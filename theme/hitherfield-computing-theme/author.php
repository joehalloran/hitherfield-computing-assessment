<?php 
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


            <?php // theloop
               

                $args = array(  
                    'post_type' => 'pupil_work',
                    'post_status' => array( 'publish', 'private' ),
                    'author' => get_queried_object_id(), // this will be the author ID on the author page
                    'showposts' => 10
                );

                $the_query = new WP_Query( $args );


                // The Loop
                if ( $the_query->have_posts() ) :
                    while ( $the_query->have_posts() ) : $the_query->the_post();

                    ?>
                    <div <?php post_class(); ?>>

                        <h2 class="page-header">
                            <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'devdmbootstrap3' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
                        </h2>

                        <?php if ( has_post_thumbnail() ) : ?>
                           <?php the_post_thumbnail(); ?>
                            <div class="clear"></div>
                        <?php endif; ?>
                        <?php the_content(); ?>
                        <?php wp_link_pages(); ?>
                        <?php get_template_part('template-part', 'postmeta'); ?>
                        <?php  if ( comments_open() ) : ?>
                               <div class="clear"></div>
                              <p class="text-right">
                                  <a class="btn btn-success" href="<?php the_permalink(); ?>#comments"><?php comments_number(__('Leave a Comment','devdmbootstrap3'), __('One Comment','devdmbootstrap3'), '%' . __(' Comments','devdmbootstrap3') );?> <span class="glyphicon glyphicon-comment"></span></a>
                              </p>
                        <?php endif; ?>
                   </div>


                <?php endwhile; ?>
                <?php posts_nav_link(); ?>
                <?php else: ?>

                    <?php get_404_template(); ?>

            <?php endif; ?>

   </div>

   <?php //get the right sidebar ?>
   <?php get_sidebar( 'right' ); ?>

</div>
<!-- end content container -->

<?php get_footer(); ?>

