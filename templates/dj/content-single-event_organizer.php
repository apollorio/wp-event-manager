<?php 
$dj = get_post($dj_id);
$dj_email = esc_html(get_post_meta($dj_id, '_dj_email', true)); 
if (get_option('event_manager_form_fields') && is_array(get_option('event_manager_form_fields'))) {
    $dj_custom_fields = get_option('event_manager_form_fields', true)['dj'];
} else {
    $GLOBALS['event_manager']->forms->get_form( 'submit-dj', array() );
    $form_submit_dj_instance = call_user_func( array( 'WP_Event_Manager_Form_Submit_dj', 'instance' ) );
    $dj_custom_fields = $form_submit_dj_instance->merge_with_custom_fields( 'backend' );
} 
// Check user is loggedin or not.
$check_user_access 	 = wpem_checked_guest_user_access();

// If user not logged in hide some fields from that
if($check_user_access == false && get_option('wpem_hide_data_from_guest')) {
    $field_to_hide = get_option('wpem_hide_dj_fields');
}else {
	$field_to_hide = array();
}
?>

<div class="wpem-single-dj-profile-wrapper" id="wpem_dj_profile">
    <div class="wpem-dj-profile">
        <?php do_action('single_event_listing_dj_start'); ?>
        <div class="wpem-row">

            <div class="wpem-col-md-3">
                <div class="wpem-dj-logo-wrapper">
                    <div class="wpem-dj-logo">
                        <a><?php
                            if(!in_array('dj_logo', $field_to_hide)) {
                                display_dj_logo('', '', $dj); 
                            }
                            ?></a>
                    </div>
                </div>
            </div>

            <div class="wpem-col-md-9 wpem-col-sm-12">
                <div class="wpem-dj-infomation-wrapper">
                    <div class="wpem-dj-name wpem-heading-text">
                        <span><?php 
                        if(!in_array('dj_name', $field_to_hide)) {
                            echo esc_attr($dj->post_title); 
                        }
                        ?></span>
                    </div>
                    <div class="wpem-dj-description">
                        <?php 
                        if(!in_array('dj_description', $field_to_hide)) {
                            $content = apply_filters('wpem_the_content',$dj->post_content);
                            if(!empty($content)){
                                echo wp_kses_post($content);
                            }
                        }
                        ?>
                     </div>
                    <div class="wpem-dj-social-links">
                        <div class="wpem-dj-social-lists">
                            <?php do_action('single_event_listing_dj_social_start', $dj_id); ?>
                            <?php
                            //get disable dj fields
                            $dj_fields = get_hidden_form_fields( 'event_manager_submit_dj_form_fields', 'dj');
                            $dj_website  = !in_array('dj_website', $dj_fields)?get_dj_website($dj):'';
                            $dj_facebook = !in_array('dj_facebook', $dj_fields)?get_dj_facebook($dj):'';
                            $dj_instagram = !in_array('dj_instagram', $dj_fields)?get_dj_instagram($dj):'';
                            $dj_twitter  = !in_array('dj_twitter', $dj_fields)?get_dj_twitter($dj):'';
                            $dj_youtube  = !in_array('dj_youtube', $dj_fields)?get_dj_youtube($dj):'';
                          
                            if (!empty($dj_website) && !in_array('dj_website', $field_to_hide) ) { ?>
                                <div class="wpem-social-icon wpem-weblink">
                                    <a href="<?php echo esc_url($dj_website); ?>" target="_blank" title="<?php esc_attr_e('Get Connect on Website', 'wp-event-manager'); ?>"><?php esc_html_e('Website', 'wp-event-manager'); ?></a>
                                </div>
                            <?php }

                            if (!empty($dj_facebook) && !in_array('dj_facebook', $field_to_hide) ) { ?>
                                <div class="wpem-social-icon wpem-facebook">
                                    <a href="<?php echo esc_url($dj_facebook); ?>" target="_blank" title="<?php esc_attr_e('Get Connect on Facebook', 'wp-event-manager'); ?>"><?php esc_html_e('Facebook', 'wp-event-manager'); ?></a>
                                </div>
                            <?php  }

                            if (!empty($dj_instagram) && !in_array('dj_instagram', $field_to_hide) ) { ?>
                                <div class="wpem-social-icon wpem-instagram">
                                    <a href="<?php echo esc_url($dj_instagram); ?>" target="_blank" title="<?php esc_attr_e('Get Connect on Instagram', 'wp-event-manager'); ?>"><?php esc_html_e('Instagram', 'wp-event-manager'); ?></a>
                                </div>
                            <?php }

                            if (!empty($dj_twitter) && !in_array('dj_twitter', $field_to_hide) ) { ?>
                                <div class="wpem-social-icon wpem-twitter">
                                    <a href="<?php echo esc_url($dj_twitter); ?>" target="_blank" title="<?php esc_attr_e('Get Connect on Twitter', 'wp-event-manager'); ?>"><?php esc_html_e('Twitter', 'wp-event-manager'); ?></a>
                                </div>
                            <?php  }
                            if (!empty($dj_youtube) && !in_array('dj_youtube', $field_to_hide)) { ?>
                                <div class="wpem-social-icon wpem-youtube">
                                    <a href="<?php echo esc_url($dj_youtube); ?>" target="_blank" title="<?php esc_attr_e('Get Connect on Youtube', 'wp-event-manager'); ?>"><?php esc_html_e('Youtube', 'wp-event-manager'); ?></a>
                                </div>
                            <?php } 
                            
                            do_action('single_event_listing_dj_single_social_end', $dj_id); ?>

                        </div>
                    </div>
                    <?php do_action('submit_dj_form_dj_fields_start'); 
                    if (isset($dj_custom_fields)) {
                        foreach ($dj_custom_fields as $key => $field) :
                            if (!in_array($key, $field_to_hide) && 
                                !strstr($key, 'dj') && 
                                !strstr($key, 'vcv') && 
                                !strstr($key, 'submitting') && 
                                !empty(get_post_meta($dj_id, '_' . $key))) : ?>
                                <div class="wpem-dj-additional-information">
                                    <strong><?php echo esc_attr($field['label']); ?>:</strong>
                                    <span>
                                        <?php 
                                            $value = get_post_meta($dj_id, '_' . $key, true);
                                            if ($field['type'] == 'url' && !empty($value)) {
                                                echo '<a href="'.esc_url($value).'" target="_blank">'.esc_url($value).'</a>';
                                            } else {
                                                echo esc_attr($value);
                                            }
                                        ?>
                                    </span>
                                </div>
                            <?php endif;
                        endforeach;
                    }                     
                    do_action('dj_form_dj_fields_end'); ?>
                    <div class="wpem-dj-contact-actions">
                        <?php do_action('single_event_listing_dj_action_start', $dj_id); ?>

                        <?php do_action('single_event_listing_dj_action_end', $dj_id); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php do_action('single_event_listing_dj_end'); ?>
    </div>
</div>

<?php
get_event_manager_template(
    'dj-event_listing.php',
    array(
        'dj_id'    => $dj_id,
        'per_page'        => $per_page,
        'show_pagination' => $show_pagination,
        'upcomingEvents'  => $upcomingEvents,
        'currentEvents'   => $currentEvents,
        'pastEvents'      => $pastEvents,
        'current_page'    => $current_page,
    ),
    'wp-event-manager/dj',
    EVENT_MANAGER_PLUGIN_DIR . '/templates/dj/'
);