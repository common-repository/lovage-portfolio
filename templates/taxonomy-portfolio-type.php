<?php
/**
 * The portfolio type taxonomy template
 * If you want to override this template by your custom template in the theme folder,
 * tust create the 'lovage-templates/portfolio' folder in the theme folder,
 * then, copy this file to lovage-templates/portfolio folder.
 * @version 1.0.0
 * @package Lovage Portfolio
 */

get_header();
?>

<div class="lovage-portfolio-tax-title text-align-center">
	<h1 itemprop="name"><?php echo apply_filters( 'lovage_portfolio_tax_title', single_term_title( '', false ) ); ?></h1>
	<div class="desc"><?php echo get_the_archive_description(); ?></div>
</div>

<div class="lovage-portfolio-grid columns-3 <?php echo apply_filters( 'lovage_portfolio_grid_extra_class', '' );?>">

	<?php if ( have_posts() ) : ?>

		<?php  
			while ( have_posts() ) : 
			the_post(); 
			
			/**
			 * Hooked Function: lovage_portfolio_grid_item
			 * @see includes/functions.php
			 */
			do_action( 'lovage_portfolio_grid_items' );
			
			endwhile;
		    lovage_portfolio_post_navi();
	    ?>

    <?php else: ?>

    	<p><?php esc_html_e( 'No project found.', 'lovage-portfolio' ); ?></p>

    <?php endif;?>

</div>

<?php
get_footer();