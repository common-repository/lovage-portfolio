<?php
/**
 * Lovage Portfolio setup
 *
 * @package Lovage Portfolio
 * @since   1.0.3
 */

defined( 'ABSPATH' ) || exit;

/**
 * Main Lovage_Portfolio Class.
 *
 * @class Lovage_Portfolio
 */
final class Lovage_Portfolio {

	/**
	 * Lovage Portfolio version.
	 *
	 * @var string
	 */
	public $version = '1.0.2';

	/**
	 * The single instance of the class.
	 *
	 * @var Lovage_Portfolio
	 * @since 1.0.0
	 */
	protected static $_instance = null;

	/**
	 * The arguments of lovage-portfolio post type
	 *
	 * @var Lovage_Portfolio
	 * @since 1.0.0
	 */
	public $post_type = 'lovage-portfolio';
	public $post_type_slug = 'portfolio';
	public $post_type_description;
	public $post_type_supports = array( 'title', 'editor', 'thumbnail' );
	public $post_type_labels;
	public $post_type_label;
	public $public = true;
	public $publicly_queryable = true;
	public $show_ui = true;
	public $show_in_menu = true;
	public $query_var = true;
	public $rewrite = true;
	public $capability_type = 'post';
	public $has_archive = true;
	public $hierarchical = false;
	public $menu_position = null;
	public $exclude_from_search = false;
	public $show_in_nav_menus = true;
	public $show_in_admin_bar = true;
	public $menu_icon = null;
	public $map_meta_cap = null;
	public $can_export = true;
	public $show_in_rest = true;

	/**
	 * The arguments of lovage-portfolio taxonomy
	 *
	 * @var Lovage_Portfolio
	 * @since 1.0.0
	 */
	public $register_taxonomy = true;
	public $taxonomy   = 'lovage-portfolio-type';
	public $taxonomy_slug = 'portfolio-type';
	public $taxonomy_labels;
	public $taxonomy_label;
	public $taxonomy_public = true;
	public $taxonomy_publicly_queryable = true;
	public $taxonomy_show_ui = true;
	public $taxonomy_show_in_menu = true;
	public $taxonomy_show_in_nav_menus = true;
	public $taxonomy_show_tagcloud = false;
	public $taxonomy_show_in_rest = true;
	public $taxonomy_show_in_quick_edit = true;
	public $taxonomy_show_admin_column = true;
	public $taxonomy_query_var = true;

	/**
	 * Main Lovage_Portfolio Instance.
	 *
	 * Ensures only one instance of Lovage_Portfolio is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see Lovage_Portfolio()
	 * @return Lovage_Portfolio - Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone() {
		wc_doing_it_wrong( __FUNCTION__, __( 'Cloning is forbidden.', 'lovage-portfolio' ), '1.0.3' );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup() {
		wc_doing_it_wrong( __FUNCTION__, __( 'Unserializing instances of this class is forbidden.', 'lovage-portfolio' ), '1.0.3' );
	}

	/**
	 * LovagePro Constructor.
	 */
	public function __construct() {

		$this->define_constants();
		$this->includes();
		$this->init_hooks();

		add_image_size( 'lovage-portfolio-3-columns', 600, 600 );

	    $this->post_type_labels = array( 
	    	'name'               => esc_html__( 'Projects', 'lovage-portfolio' ),
			'singular_name'      => esc_html__( 'Project', 'lovage-portfolio' ),
			'menu_name'          => esc_html__( 'Portfolio', 'lovage-portfolio' ),
			'name_admin_bar'     => esc_html__( 'Portfolio', 'lovage-portfolio' ),
			'add_new'            => esc_html__( 'Add New', 'lovage-portfolio' ),
			'add_new_item'       => esc_html__( 'Add New Project', 'lovage-portfolio' ),
			'new_item'           => esc_html__( 'New Project', 'lovage-portfolio' ),
			'edit_item'          => esc_html__( 'Edit Project', 'lovage-portfolio' ),
			'view_item'          => esc_html__( 'View Project', 'lovage-portfolio' ),
			'all_items'          => esc_html__( 'All Projects', 'lovage-portfolio' ),
			'search_items'       => esc_html__( 'Search Projects', 'lovage-portfolio' ),
			'parent_item_colon'  => esc_html__( 'Parent Projects:', 'lovage-portfolio' ),
			'not_found'          => esc_html__( 'No project found.', 'lovage-portfolio' ),
			'not_found_in_trash' => esc_html__( 'No project found in Trash.', 'lovage-portfolio' )
	    );
		$this->post_type_label = esc_html__( 'Portfolio', 'lovage-portfolio' );

		$this->taxonomy_labels = array( 
	    	'name'               => esc_html__( 'Project Types', 'lovage-portfolio' ),
			'singular_name'      => esc_html__( 'Project Type', 'lovage-portfolio' ),
			'search_items'       => esc_html__( 'Search Project Types', 'lovage-portfolio' ),
			'all_items'          => esc_html__( 'All Project Types', 'lovage-portfolio' ),
			'parent_item'        => esc_html__( 'Parent Project Types', 'lovage-portfolio' ),
			'parent_item_colon'  => esc_html__( 'Parent Project Type:', 'lovage-portfolio' ),
			'edit_item'          => esc_html__( 'Edit Project Type', 'lovage-portfolio' ),
			'update_item'        => esc_html__( 'Update Project Type', 'lovage-portfolio' ),
			'add_new_item'       => esc_html__( 'Add New Project Type', 'lovage-portfolio' ),
			'new_item_name'      => esc_html__( 'New Genre Project Type', 'lovage-portfolio' ),
			'menu_name'          => esc_html__( 'Project Types', 'lovage-portfolio' ),
	    );
		$this->taxonomy_label = esc_html__( 'Project Types', 'lovage-portfolio' );
	}

	public function settings( $post_type_slug, $taxonomy_slug ){
		$this->post_type_slug = $post_type_slug;
		$this->taxonomy_slug = $taxonomy_slug;
	}

	/**
	 * Init Hooks
	 */
	public function init_hooks(){
		add_action( 'init', array( $this,'textdomain' ) ); 
		add_action( 'init', array( $this, 'post_type' ) );
		add_action( 'init', array( $this, 'taxonomy' ), 0 );
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
		add_filter( 'single_template', array( $this, 'portfolio_single_template') );
		add_filter( 'template_include', array( $this, 'portfolio_taxonomy_template' ) );
		add_filter( 'template_include', array( $this, 'portfolio_grid_template' ) );
		add_filter( 'register_post_type_args', array( $this, 'post_type_args'), 10, 2 );
		add_filter( 'register_taxonomy_args',  array( $this, 'taxonomy_args' ), 10, 2 );
	}

	/**
	 * Define Lovage Portfolio Constants.
	 */
	private function define_constants() {
		$this->define( 'LPT_DEBUG', FALSE );
		$this->define( 'LPT_ABSPATH', dirname( LOVAGE_PORTFOLIO_FILE ) . '/' );
		$this->define( 'LPT_PLUGIN_BASENAME', plugin_basename( LOVAGE_PORTFOLIO_FILE ) );
		$this->define( 'LPT_DIR', plugin_dir_path( dirname(__FILE__) ) );
		$this->define( 'LPT_DIR_URI', plugins_url( __FILE__ ) );
      	$this->define( 'LPT_ROOT_DIR', plugins_url().'/'.plugin_basename( LPT_DIR ).'/' );
		$this->define( 'LPT_VERSION', $this->version );
	}

	/**
	 * Define constant if not already set.
	 *
	 * @param string      $name  Constant name.
	 * @param string|bool $value Constant value.
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
     * Localize
     */
	public function textdomain() {
	   load_plugin_textdomain( 'lovage-portfolio', FALSE, dirname( plugin_basename( LOVAGE_PORTFOLIO_FILE ) ).'/languages/' );
	}

	/**
	 * Register Portfolio Post Type
	 */
	public function post_type() {
		/**
		 * Register a book post type.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/register_post_type
		 */
		
		$args = apply_filters( 'lovage_portfolio_post_type_args', array(
			'labels'             => $this->post_type_labels,
			'label'				 => $this->post_type_label,
	        'description'        => $this->post_type_description,
			'public'             => $this->public,
			'publicly_queryable' => $this->publicly_queryable,
			'show_ui'            => $this->show_ui,
			'show_in_menu'       => $this->show_in_menu,
			'show_in_nav_menus'  => $this->show_in_nav_menus,
			'show_in_admin_bar'  => $this->show_in_admin_bar,
			'query_var'          => $this->query_var,
			'capability_type'    => $this->capability_type,
			'has_archive'        => $this->has_archive,
			'hierarchical'       => $this->hierarchical,
			'menu_position'      => $this->menu_position,
			'menu_icon'			 => $this->menu_icon,
			'supports'           => $this->post_type_supports,
			'exclude_from_search'=> $this->exclude_from_search,
			'map_meta_cap'		 => $this->map_meta_cap,
			'can_export'		 => $this->can_export,
			'show_in_rest'		 => $this->show_in_rest,
			'rest_base'          => $this->post_type,
    		'rest_controller_class' => 'WP_REST_Posts_Controller',
			'taxonomies'		 => array( $this->taxonomy )
		));

		if( $this->rewrite ){
			$args['rewrite'] = array( 'slug' => $this->post_type_slug );
		}else{
			$args['rewrite'] = $this->rewrite;
		}

		register_post_type( $this->post_type, $args );
	}

	/**
	 * Register Portfolio Category Taxonomy
	 */
	public function taxonomy() {
		if(!$this->register_taxonomy){
			return;
		}

		$args = apply_filters( 'lovage_portfolio_taxonomy_labels', array(
			'hierarchical'       => true,
			'label'              => $this->taxonomy_label,
			'labels'             => $this->taxonomy_labels,
			'public'             => $this->taxonomy_public,
			'publicly_queryable' => $this->taxonomy_publicly_queryable,
			'show_ui'            => $this->taxonomy_show_ui,
			'show_in_menu'       => $this->taxonomy_show_in_menu,
			'show_in_nav_menus'  => $this->taxonomy_show_in_nav_menus,
			'show_admin_column'  => $this->taxonomy_show_admin_column,
			'show_tagcloud'      => $this->taxonomy_show_tagcloud,
			'show_in_rest'  	 => $this->taxonomy_show_in_rest,
			'rest_base'          => $this->taxonomy,
    		'rest_controller_class' => 'WP_REST_Terms_Controller',
			'show_in_quick_edit' => $this->taxonomy_show_in_quick_edit,
			'query_var'  		 => $this->taxonomy_query_var,
			'rewrite'            => array( 'slug' => $this->taxonomy_slug ),
		) );

		register_taxonomy( $this->taxonomy, $this->post_type, $args );
		register_taxonomy_for_object_type( $this->taxonomy, $this->post_type );
	}

	/**
	 * Add REST API support to an already registered post type.
	 */
	public function post_type_args( $args, $post_type ) {
 
	    if ( $this->post_type === $post_type ) {
	        $args['show_in_rest'] = true;
	 
	        // Optionally customize the rest_base or rest_controller_class
	        $args['rest_base']             = $this->post_type;
	        $args['rest_controller_class'] = 'WP_REST_Posts_Controller';
	    }
	 
	    return $args;
	}

	/**
	 * Add REST API support to an already registered taxonomy.
	 */
	public function taxonomy_args( $args, $taxonomy_name ) {
	 
	    if ( $this->taxonomy === $taxonomy_name ) {
	        $args['show_in_rest'] = true;
	 
	        // Optionally customize the rest_base rest_controller_class
	        $args['rest_base']             =  $this->taxonomy;
	        $args['rest_controller_class'] = 'WP_REST_Terms_Controller';
	    }
	 
	    return $args;
	}

	/**
	 * The single post template
	 */
	public function portfolio_single_template( $single ) {

	    global $post;

	    $single_template_file = 'single-portfolio.php';

	    /* Checks for single template by post type */
	    if ( get_post_type( $post->ID ) == $this->post_type ) {
	    	if( file_exists( trailingslashit( get_stylesheet_directory() ) . 'lovage-templates/portfolio/' . $single_template_file ) ) {
	    		 return trailingslashit( get_stylesheet_directory() ) . 'lovage-templates/portfolio/' . $single_template_file;
	    	}else{
		        if ( file_exists( LPT_ABSPATH . 'templates/' . $single_template_file ) ) {
		            return LPT_ABSPATH . 'templates/' . $single_template_file;
		        } else {
		        	return new WP_Error( 'broke', esc_html__( "The portfolio post template doesn't exist.", "lovage-portfolio" ) );
		        }
	    	}
	    }else{
	    	return $single;
	    }
	}


	/**
	 * The taxonomy template
	 */
	public function portfolio_taxonomy_template( $template ){

		$taxonomy_template_file = 'taxonomy-portfolio-type.php';

	    if( is_tax( $this->taxonomy ) ) {
	        if( file_exists( trailingslashit( get_stylesheet_directory() ) . 'lovage-templates/portfolio/' . $taxonomy_template_file ) ) {
	            $template = trailingslashit( get_stylesheet_directory()) . 'lovage-templates/portfolio/' . $taxonomy_template_file;
	        } else {
	        	if ( file_exists( LPT_ABSPATH . 'templates/' . $taxonomy_template_file ) ) {
	            	$template = LPT_ABSPATH . 'templates/' . $taxonomy_template_file;
	        	}else{
	        		return new WP_Error( 'broke', esc_html__( "The portfolio taxonomy template doesn't exist.", "lovage-portfolio" ) );
	        	}
	        }
	    }

	    return $template;
	}

	/**
	 * The protfolio grid page template
	 */
	public function portfolio_grid_template( $template ){

		$grid_page_template_file = 'portfolio-grid-page-template.php';

	    if( is_page_template( 'lovage-portfolio-grid-page-template' ) ) {
	        if( file_exists( trailingslashit( get_stylesheet_directory() ) . 'lovage-templates/portfolio/' . $grid_page_template_file ) ) {
	            $template = trailingslashit( get_stylesheet_directory()) . 'lovage-templates/portfolio/' . $grid_page_template_file;
	        } else {
	        	if ( file_exists( LPT_ABSPATH . 'templates/' . $grid_page_template_file ) ) {
	            	$template = LPT_ABSPATH . 'templates/' . $grid_page_template_file;
	        	}else{
	        		return new WP_Error( 'broke', esc_html__( "The portfolio grid page template doesn't exist.", "lovage-portfolio" ) );
	        	}
	        }
	    }

	    return $template;
	}

	/**
	 * Styles / Scripts
	 */
	public function scripts(){
		$min = ! LPT_DEBUG ? 'min.' : '';
		wp_enqueue_style( 'lovage-portfolio', plugins_url( 'assets/css/lovage-portfolio.' . esc_html( $min ) . 'css', LOVAGE_PORTFOLIO_FILE ), '', null );
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 */
	public function includes() {
		require_once LPT_ABSPATH . 'includes/lovage-metabox/class-lovage-metabox.php';
		require_once LPT_ABSPATH . 'includes/metabox.php';
		require_once LPT_ABSPATH . 'includes/functions.php';
		require_once LPT_ABSPATH . 'includes/class-lovage-plugin-page-template-loader.php';
		require_once LPT_ABSPATH . 'includes/class-lovage-portfolio-page-template.php';
	}

}