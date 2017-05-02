<?php

/**
* Sets up the HTML, including forms, around the calendar
*
*/

function sc_get_events_calendar($template=null) {
	global $wpdb;
	ob_start();
	do_action('sc_before_calendar');
	//$interval_date = $wpdb->get_row("SELECT MAX(meta_value) as max_date, MIN(meta_value) as min_date FROM wp_postmeta WHERE meta_key='sc_event_date'");
	$intr_date_max = $wpdb->get_row("SELECT pm.meta_value as max_date FROM wp_postmeta pm
					     INNER JOIN wp_posts p ON p.id=pm.post_id
					     WHERE pm.meta_key='sc_event_date' AND p.post_status='publish' 
					     GROUP BY p.id
					     ORDER BY pm.meta_value DESC");
	$intr_date_min = $wpdb->get_row("SELECT pm.meta_value as min_date FROM wp_postmeta pm
					    INNER JOIN wp_posts p ON p.id=pm.post_id
					     WHERE pm.meta_key='sc_event_date' AND p.post_status='publish' 
					     GROUP BY p.id
					     ORDER BY pm.meta_value ASC");
	
	$time = current_time('timestamp');
	// default month and year
	$month_count = round(abs($intr_date_max->max_date - $intr_date_min->min_date) / 60 / 1440 / 31);

	$today_month = date('n', $time);
	$today_year  = date('Y', $time);	


	$months = array(
		1  => sc_month_num_to_name(1),
		2  => sc_month_num_to_name(2),
		3  => sc_month_num_to_name(3),
		4  => sc_month_num_to_name(4),
		5  => sc_month_num_to_name(5),
		6  => sc_month_num_to_name(6),
		7  => sc_month_num_to_name(7),
		8  => sc_month_num_to_name(8),
		9  => sc_month_num_to_name(9),
		10 => sc_month_num_to_name(10),
		11 => sc_month_num_to_name(11),
		12 => sc_month_num_to_name(12)
	);
	$args = array(
			'numberposts' => -1,
			'post_type' => 'sc_event',
			'post_status' => 'publish',
			'orderby' => 'meta_value_num',
			'order' => 'asc',
		);

	$events = get_posts( apply_filters( 'sc_calendar_query_args', $args ) );
	for($i=0; $i <= $month_count; $i++){
		if( $i == 0 ){
			$today_month = date('n', $intr_date_min->min_date);
			$today_year = date('Y', $intr_date_min->min_date);
		}else{
			$today_month = date('n', strtotime( '+'.$i.' month', $intr_date_min->min_date ));
			$today_year = date('Y', strtotime( '+'.$i.' month', $intr_date_min->min_date ));
		}
	if(is_null($template)):
	?>
		<div class="slick-slide">
	<?php endif;?>		
			<div id="sc_events_calendar_<?php echo uniqid(); ?>" class="calendar-holder">
				<div class="calendar-box">
					<div class="title-holder">
						<h2>UPCOMING EVENTS  <span><?php echo esc_html( $months[$today_month] . ' ' . $today_year ); ?></span></h2>
					</div><!--end #sc_events_calendar_head-->
					<?php echo sc_draw_calendar( $today_month, $today_year, $events ); ?>
				</div>
			</div><!-- end #sc_events_calendar -->
	<?php if(is_null($template)):?>	
		</div>
	<?php
		endif;
	}
	do_action('sc_after_calendar');
	return ob_get_clean();
}