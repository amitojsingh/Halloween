<?php
/*
   Plugin Name: Boo admin
  a plugin to create awesomeness and spread joy
   Version: 1.2
   Author: Amitoj Singh
   License: GPL2
   */
if ( ! function_exists( 'hide_woocommerce_page_title' ) ) {
/**
* Hide WooCommerce page title
*/
function hide_woocommerce_page_title() {
return false;
}
add_filter( 'woocommerce_page_title', 'hide_woocommerce_page_title' );
}

function add_summary(){
    ?>
    <?php echo " <p>".the_excerpt()."</p>" ?>
<?php
}


add_action('woocommerce_after_shop_loop_item_title',add_summary,10,0);


function beforeloop(){
    echo "<h4> Save upto 50%off</h4>";
}
add_action('woocommerce_before_shop_loop',beforeloop,10,0);


function add_custom_options($options){
    $options['title']='Sort Alphabetically';
    $options['in-stock']='Sort by stock';
    return $options;
}
add_filter('woocommerce_catalog_orderby','add_custom_options');


add_filter( 'woocommerce_get_catalog_ordering_args', 'custom_product_sorting' );
 
function custom_product_sorting( $args ) {
 
	// Sort alphabetically
	if ( isset( $_GET['orderby'] ) && 'title' === $_GET['orderby'] ) {
		$args['orderby'] = 'title';
		$args['order'] = 'asc';
	}
 
	// Show products in stock first
	if( isset( $_GET['orderby'] ) && 'in-stock' === $_GET['orderby'] ) {
		$args['meta_key'] = '_stock_status';
		$args['orderby'] = array( 'meta_value' => 'ASC' );
	}
 
	return $args;
 
}

add_action('woocommerce_single_product_summary',add_title);
function add_title(){
    ?><h1>
				<?php the_title(); ?>
			</h1>
<?php
}
function boo_admin(){
    add_menu_page('Boo Widget','Boo','manage_options','boo_admin','boo_admin_contents','dashicons-schedule',11);
}


add_action('admin_menu','boo_admin');
function boo_admin_contents() {
		?>
			<h1>
				<?php esc_html_e( 'Welcome to my custom admin page.', 'my-plugin-textdomain' ); ?>
			</h1>
		<?php
	}
function register_my_plugin_scripts() {

wp_register_style( 'my-plugin', plugins_url( 'css/style.css' ) );

wp_register_script( 'my-plugin', plugins_url( 'js/plugin.js' ) );

}



add_action( 'admin_enqueue_scripts', 'register_my_plugin_scripts' );



function load_my_plugin_scripts( $hook ) {

// Load only on ?page=sample-page

if( $hook != 'toplevel_page_sample-page' ) {

return;

}

// Load style & scripts.

wp_enqueue_style( 'my-plugin' );

wp_enqueue_script( 'my-plugin' );

}



add_action( 'admin_enqueue_scripts', 'load_my_plugin_scripts' );
?>