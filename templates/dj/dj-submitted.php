<?php
global $wp_post_types;
//print appropriate message accroding to post status or post description
$dj_dashboard_page_id = get_option('event_manager_dj_dashboard_page_id');

switch ($dj->post_status) :
	case 'publish' :
		printf(
			wp_kses_post('<p class="post-submitted-success-green-message wpem-alert wpem-alert-success">%s listed successfully. To view your dj list <a href="%s">click here</a>.</p>'),
			esc_html($wp_post_types['event_dj']->labels->singular_name),
			esc_url(get_permalink($dj_dashboard_page_id))
		);
		break;
	case 'pending' :
		printf(
			wp_kses_post('<p class="post-submitted-success-green-message wpem-alert wpem-alert-success">%s submitted successfully. Your dj will be visible once approved.</p>'),
			esc_html($wp_post_types['event_dj']->labels->singular_name)
		);
		break;
	default :
		do_action('event_manager_dj_submitted_content_' . str_replace('-', '_', sanitize_title($dj->post_status)), $dj);
		break;
endswitch;

do_action('event_manager_dj_submitted_content_after', sanitize_title($dj->post_status), $dj);