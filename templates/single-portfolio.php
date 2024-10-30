<?php
/**
 * The single portfolio post template
 * If you want to override this template by your custom template in the theme folder,
 * tust create the 'lovage-templates/portfolio' folder in the theme folder,
 * then, copy this file to lovage-templates/portfolio folder.
 * @version 1.0.0
 * @package Lovage Portfolio
 */

get_header();
?>

<?php  while ( have_posts() ) : the_post(); ?>
<div class="lovage-portfolio-post columns-2">
	
	<div class="lovage-portfolio-media">
		<?php 
		  /**
		   * Show the portfolio media section
		   * Hooked function: lovage_portfolio_media()
		   * @see includes/functions.php
		   */
		  do_action( 'lovage_portfolio_media' );
		?>
	</div>

	<div class="lovage-portfolio-content">
		<h1><?php the_title(); ?></h1>
	
		<div class="lovage-portfolio-entry">
			<?php the_content(); ?>
		</div>
		
		<ul class="lovage-portfolio-info">
			<?php
		  	  /**
			   * Show the portfolio info section
			   * Hooked function: lovage_portfolio_info()
			   * @see includes/functions.php
			   */
			  do_action( 'lovage_portfolio_info' );
			?>
		</ul>
	</div>

</div>
<?php endwhile;?>

<?php
get_footer();