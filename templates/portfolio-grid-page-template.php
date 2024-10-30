<?php
/**
 * Template Name: Portfolio Grid Template
 * If you want to override this template by your custom template in the theme folder,
 * tust create the 'lovage-templates/portfolio' folder in the theme folder,
 * then, copy this file to lovage-templates/portfolio folder.
 * @version 1.0.0
 * @package Lovage Portfolio
 */

get_header();
?>

<div class="lovage-portfolio-tax-title">
	<h1 itemprop="name"><?php the_title(); ?></h1>
	<div class="desc"><?php the_content(); ?></div>
</div>

<?php do_action( 'lovage_portfolio_before_container' ); ?>

<div class="lovage-portfolio-grid columns-3 <?php echo apply_filters( 'lovage_portfolio_grid_extra_class', '' );?>">

	<?php   
        if( ! is_front_page() ){
          $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
        }else{		       
          $paged = ( get_query_var('page') ) ? get_query_var('page') : 1;
        }

	    $params = array(
          'posts_per_page' => get_option('posts_per_page'), 
          'post_type' => 'lovage-portfolio',
          'orderby'  => 'date',
          'order' => 'desc',
          'paged'   => $paged
        );

        $portfolio_query = new WP_Query($params); 

		if ( $portfolio_query->have_posts() ) : 
	?>

		<?php
			while ( $portfolio_query->have_posts() ) : 
			$portfolio_query->the_post(); 
			
			/**
			 * Hooked Function: lovage_portfolio_grid_item
			 * @see includes/functions.php
			 */
			do_action( 'lovage_portfolio_grid_items' );
			
			endwhile;
			wp_reset_postdata(); 
		    lovage_portfolio_post_navi();
	    ?>

    <?php else: ?>

    	<p><?php esc_html_e( 'No project found.', 'lovage-portfolio' ); ?></p>

    <?php endif;?>

</div>

<?php 
do_action( 'lovage_portfolio_after_container' ); 
get_footer();