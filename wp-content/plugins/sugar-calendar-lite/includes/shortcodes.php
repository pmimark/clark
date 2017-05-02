<?php
function sc_events_calendar_shortcode( $atts, $content = null ) {
	global $wpdb;
	$calendar  = '';
	$calendar = get_option( 'event_calendar' );

	$current_slide = 0;
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

	$month_count = round(abs($intr_date_max->max_date - $intr_date_min->min_date) / 60 / 1440 / 31);
	$time = current_time('timestamp');
	$current_month = date('n', $time);
	$current_year  = date('Y', $time);
	for($i=0; $i <= $month_count; $i++){
		if( $i == 0 ){
			$today_month = date('n', $intr_date_min->min_date);
			$today_year = date('Y', $intr_date_min->min_date);
		}else{
			$today_month = date('n', strtotime( '+'.$i.' month', $intr_date_min->min_date ));
			$today_year = date('Y', strtotime( '+'.$i.' month', $intr_date_min->min_date ));
		}
		if($current_month == $today_month && $current_year == $today_year){
			$current_slide = $i;
		}
	}
	if( empty($calendar) ){
	$calendar .= '<div class="calendar-wrapper"><div class="calendar-box">
		<a href="/events-list/" class="view-all">VIEW FULL <span>SCHEDULE</span></a>
		<div class="calendar-slider">' ;
	$calendar .= sc_get_events_calendar() ;
	$calendar .= '</div>
	</div></div>';
	
	update_option('event_calendar',$calendar);
	echo $calendar;	
	}else{
		echo $calendar;	
	}
?>
	<script>
	jQuery(document).ready(function($) {
		$('.calendar-slider').slick({adaptiveHeight: true, initialSlide: <?php echo $current_slide;?>});
	});
	</script>
<?php
}
add_shortcode( 'sc_events_calendar', 'sc_events_calendar_shortcode' );

function sc_events_calendar_shortcode_list( $atts, $content = null ) {
	$calendar  = '';
	$calendar = get_option( 'event_calendar_list' );

	if( empty($calendar) ){
	$calendar .= '<div class="calendar-box">
		     <div>';
	$calendar .= sc_get_events_calendar('list');
	$calendar .= '</div>
	</div>';
	
	update_option('event_calendar_list',$calendar);
	echo $calendar;
	}else{
		echo $calendar;	
	}
}
add_shortcode( 'sc_events_calendar_list', 'sc_events_calendar_shortcode_list' );