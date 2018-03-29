<?php 
function dwwp_register_post_type(){
	$singular='Job Listing';
	$plural='Job Listings';

	$labels=array(
		'name'               =>	$plural,
        'singular_name'      => $singular,
        'add_name'           => 'Add New',
        'add_new_item'       => 'Add New '.$singular,
        'edit'          	 => 'Edit',
        'edit_item'          => 'Edit' .$singular,
        'new_item'           => 'New' . $singular,
        'all_items'          => 'All ' .$plural,
        'view'          	 => 'View' .$singular,
        'view_item'          => 'View' .$singular,
        'search_items'       => 'Search '.$plural,
        'parent'			 => 'Parent' .$singular,
        'not_found'          => 'No' .$plural.'found',
        'not_found_in_trash' => 'No '.$plural.'in Trash',
        'parent_item_colon'  => '',
        'menu_name'          => $singular
        );
	$args=array(
		'labels'				=>$labels,
		'description'   		=> 'Holds our Service and Services specific data',
        'query_var'     		=> true,
        'public'        		=> true,
        'publicly_queryable'  	=> true,
        'exclude_from_search' 	=> false,
        'show_in_nav_menus' 	=> true,
        'show_ui'				=> true,
        'show_in_menu'			=> true,
        'show_in_admin_bar'		=> true,
        'menu_position'			=> 10,
        'can_export'			=> true,
        'delete_with_user'		=> false,
        'menu_icon'   			=> 'dashicons-admin-site',
        'has_archive'   		=> true,
        'hierarchical'  		=> false,
        'capability_type'  		=> 'page',
        'map_meta_cap'			=>true,
        'rewrite'				=> array(
						        	'slug'=>'jobs',
						        	'with_front'=>true,
						        	'pages'=>true,
						        	'feeds'=>true
						        	),
        'supports'				=> array(
						        	'title',
						        	// 'editor',
						        	// 'author',
						        	// 'custom-fields',
						        	// 'thumbnail'
						        	)
        	);
	register_post_type('job',$args);
}

add_action('init','dwwp_register_post_type');

function dwwp_register_taxonomy()
{
	$singular='Location';
	$plural='Location';

	$labels=array(
		'name'							=> $plural,
		'singular_name'					=> $singular,
		'search_items'					=> 'Search ' . $plural,
		'popular_items'					=> 'Popular ' . $plural,
		'all_items'						=> 'All ' . $plural,
		'parent_item'					=> null,
		'parent_item_colon'				=> null,
		'edit_item'						=> 'Edit ' . $singular,
		'update_item'					=> 'Update ' . $singular,
		'add_new_item'					=> 'Add New '. $singular,
		'new_item_name'					=> 'New ' .$singular .' Name',
		'separate_items_with_commas'	=> 'Separate ' . $plural . ' with commas',
		'add_or_remove_items' 			=> 'Add or remove '. $plural,
		'choose_from_most_used'			=> 'Choose from the most used ' . $plural,
		'not_found'						=> 'No ' .$plural . ' found.',
		'menu_name' 					=> $plural,
		);
	$args=array(
		'hierarchical'			=> true,
		'labels'				=> $labels,
		'show_ui'				=> true,
		'show_admin_column'		=> true,
		'update_count_callback'	=> '_update_post_term_count',
		'query_var'				=> true,
		'rewrite'				=> array('slug'=>location),
		);

	register_taxonomy('location','job',$args);
}

add_action('init','dwwp_register_taxonomy');

?>