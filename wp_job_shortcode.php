<?php 
// function dwwp_sample_shortcode($atts, $content = null){
// 	$atts = shortcode_atts(
// 		array(
// 			'title' => 'Default title',
// 			'src' => 'www.google.com'
// 			), $atts
// 		);
// 	return '<h1>'. $atts['title'] . '</h1>';
// 	//return print_r($atts);
// }

function dwwp_job_texonomy_list( $atts, $content = null){
	$atts= shortcode_atts(
		array(
			'title' => 'Currnet job openings in ...'
			), $atts
		);
	 $locations = get_terms('location', 'orderby=count&hide_empty=0' );
	 
	if(!empty($locations) && ! is_wp_error($locations)){
		$displaylist='<div>';
		$displaylist .='<h4>'. esc_html__( $atts['title']). '</h4>';
		$displaylist .= '<ul class="list-group">';
		
		foreach ($locations as $location) {
			# code...
			$displaylist .='<li class="list-group-item">';
			$displaylist .='<a href="'. esc_url(get_term_link($location)).'">';
			$displaylist .= esc_html__( $location->name ).'</a></li>';
		}
		$displaylist .='</ul>';
		$displaylist.='</div>';

	}
	// var_dump($locations);
	return $displaylist;
}


add_shortcode('job_location_list', 'dwwp_job_texonomy_list');

function dwwp_list_job_by_location( $atts, $content = null){
	if(! isset($atts['location'])){
		return '<span>You must provide a location for this shortcode.</span>';
	}

	$atts = shortcode_atts(
		array(
			'title' => 'Currnet Job Openings in',
			'count'	=> 2,
			'location'=>'',
			'pagination' => 'off'
			), $atts
		);
	$pagination = $atts['pagination'] == 'off'?false : true;
	$paged = get_query_var('paged')? get_query_var('paged'):1;

	$args= array(
		'post_type' => 'job',
		'post_status' =>'publish',
		'no_found_rows' => $pagination,
		'posts_per_page'=> $atts['count'],
		'paged'=>$paged,
		'tax_query'=> array(
			array(
				'taxonomy' => 'location',
				'field' => 'slug',
				'terms' => $atts['location'],
				),
			)
		);
	$jobs_by_location = new WP_Query($args);
	$display_by_location='';
	//var_dump($jobs_by_location->get_posts());
	if($jobs_by_location->have_posts()):
		$location = str_replace('-',' ', $atts['location']);

		$display_by_location .= '<div>';
		$display_by_location .= '<h4>'.esc_html__($atts['title']).'</h4>';
		$display_by_location .= '<ul>';
		while($jobs_by_location->have_posts()): $jobs_by_location->the_post();
			global $posts;

			$deadline = get_post_meta(get_the_ID(),'application_deadline',true);
			$title = get_the_title();
			$slug = get_permalink();
			$display_by_location .= '<li>'.sprintf('<a href="%s">%s</a>&nbsp&nbsp', esc_url($slug), esc_html__($title)).'<span>'.esc_html($deadline).'</span></li>';
		endwhile;
		$display_by_location .= '</ul></div>';
	endif;
	wp_reset_postdata();
	
// 	echo '<pre>';
// print_r($jobs_by_location);
// echo '</pre>';
	if($jobs_by_location->max_num_pages >1){
		$display_by_location .= '<nav><div>';
		$display_by_location .= get_next_posts_link(__('<span>&rarr;<span>Previous'), $jobs_by_location->max_num_pages);
		$display_by_location .= '</div><div>';
		$display_by_location .= get_previous_posts_link(__('<span>&rarr;</span> Next'));
		$display_by_location .= '</div></nav>';
	}
	
//var_dump($display_by_location);
	return $display_by_location;
}

add_shortcode('jobs_by_location','dwwp_list_job_by_location');
?>