<?php 
function dwwp_add_custom_metabox(){
	add_meta_box(
		'dwwp_meta',
		'Job Listing',
		'dwwp_meta_callback',
		'job',
		'normal',
		'core'
		);
}
add_action('add_meta_boxes','dwwp_add_custom_metabox');

function dwwp_meta_callback( $post )
{
	wp_nonce_field( basename( __FILE__ ), 'dwwp_jobs_nonce');
	$dwwp_stored_meta = get_post_meta( $post->ID );
	//var_dump($dwwp_stored_meta);
?>
	<div>
		<div class="meta-row">
			<div class="meta-th">
				<label for="job_id" class='dwwp-row-title'>Job ID</label>
			</div>
			<div class="meta-td">
				<input type="text" name="job_id" id="job_id" value="<?php if(!empty($dwwp_stored_meta['job_id'])){ echo esc_attr($dwwp_stored_meta['job_id'][0]);}?>"/>
			</div>
		</div>
		<div class="meta-row">
			<div class="meta-th">
				<label for="date_listed" class='dwwp-row-title'>Date Listed</label>
			</div>
			<div class="meta-td">
				<input type="text" name="date_listed" class="datepicker" id="date_listed" value="<?php if(!empty($dwwp_stored_meta['date_listed'])){ echo esc_attr($dwwp_stored_meta['date_listed'][0]);}?>"/>
			</div>
		</div>
		<div class="meta-row">
			<div class="meta-th">
				<label for="application_deadline" class='dwwp-row-title'>Application Deadline</label>
			</div>
			<div class="meta-td">
				<input type="text" name="application_deadline" class="datepicker" id="application_deadline" value="<?php if(!empty($dwwp_stored_meta['application_deadline'])){ echo esc_attr($dwwp_stored_meta['application_deadline'][0]);}?>"/>
			</div>
		</div>

	</div>
	<div class="meta">
		<div class="meta-th">
			<span>Principle Duties</span>
		</div>
	</div>
	<div class="meta-editor">
		<?php

		$content = get_post_meta( $post->ID, 'principle_duties', true);
		$editor = 'principle_duties';
		$settings= array(
			'textarea_rows' => 8,
			'media_buttons' => false,
			);

		wp_editor($content,$editor,$settings);
		?>
	</div>
<?php

}

function dwwp_meta_save( $post_id ){
	//Checks save status
	
	// $is_autosave =wp_is_post_autosave( $post_id );
	// $is_revision =wp_is_post_revision( $post_id );
	// $is_valid_nonce = ( isset( $_POST[ 'dwwp_jobs_nonce' ]) AND wp_verify_nonce( $_POST[ 'dwwp_jobs_nonce' ], basename( __FILE__ )))? 'true':'false';
	// //Exits script depending on save status
	// if( $is_autosave || $is_revision || $is_valid_nonce){
	// 	return;
	// }
	if( isset( $_POST['job_id'])){
		update_post_meta($post_id , 'job_id' ,sanitize_text_field( $_POST['job_id']));
	}
	if( isset( $_POST['date_listed'])){
		update_post_meta($post_id , 'date_listed' ,sanitize_text_field( $_POST['date_listed']));
	}
	if( isset( $_POST['application_deadline'])){
		update_post_meta($post_id , 'application_deadline' ,sanitize_text_field( $_POST['application_deadline']));
	}
	if( isset( $_POST['principle_duties'])){
		update_post_meta($post_id , 'principle_duties' ,sanitize_text_field( $_POST['principle_duties']));
	}
}
add_action( 'save_post', 'dwwp_meta_save');

function dwwp_add_submenu_page(){
	add_submenu_page( 
		'edit.php?post_type=job',
		'Reorder Jobs',
		'Reorder Jobs',
		'manage_options',
		'reorer_jobs',
		'reorder_admin_jobs_callback' 
	);
}
add_action('admin_menu', 'dwwp_add_submenu_page');

function reorder_admin_jobs_callback(){
	$args = array(
		'post_type' => job,
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'post_status' => 'publish',
		'no_found_rows' => true,
		'update_post_term_cache' => false,
		'post_per_page' => 50
	 );

	$job_listing = new WP_Query($args);
	?>
	<div>
		<div>
			<h2>Sort Job Positions</h2>
			<?php if($job_listing->have_posts()):?>
			<p><?php _e('<strong> Note:</strong> This is only valid for authenticated users','wp-job-listing');?></p>
			<ul>
				<?php while($job_listing->have_posts()): $job_listing->the_post();?>
				<li><?php the_title();?></li>
			<?php endwhile;?>
			</ul>
		<?php else:?>
		<p><?php _e('you have no Jobs to sort.', 'wp-job-listing');?></p>
	<?php endif;?>
		</div>
	</div>

	<?php
}