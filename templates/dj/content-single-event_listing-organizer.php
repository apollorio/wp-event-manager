<?php
/**
 * Single view dj information box
 *
 * Hooked into single_event_listing_start priority 30
 * @since  3.1.6
 */

$check_user_access = wpem_checked_guest_user_access();
if($check_user_access == false && get_option('wpem_hide_data_from_guest')) {
    $field_to_hide = get_option('wpem_hide_dj_fields');
}else {
	$field_to_hide = array();
}

if (has_event_dj_ids()) : ?>
    <div class="wpem-single-event-footer" itemscope itemtype="http://data-vocabulary.org/Organization">
        <div class="wpem-row">
            <div class="wpem-col-md-12">
                <div class="wpem-dj-profile-wrapper" id="wpem_dj_profile">

                    <?php $event_content_toggle = apply_filters('event_manager_event_content_toggle', true);
                    $event_content_toggle_class = $event_content_toggle ? 'wpem-listing-accordion' : 'wpem-event-dj-info-title'; ?>

                    <div class="<?php echo esc_attr($event_content_toggle_class); ?> active">
                        <h3 class="wpem-heading-text"><?php esc_html_e('dj', 'wp-event-manager'); ?></h3>
                        <?php if ($event_content_toggle) : ?>
                            <i class="wpem-icon-minus"></i><i class="wpem-icon-plus"></i>
                        <?php endif; ?>
                    </div>

                    <div class="wpem-dj-wrapper wpem-listing-accordion-panel active" style="display: block;">
                        <div class="wpem-dj-profile">

                            <?php do_action('single_event_listing_dj_start'); 

                            $dj_ids = get_event_dj_ids(); 

                            if (!empty($dj_ids)) : 
                                foreach ($dj_ids as $key => $dj_id) : ?>

                                    <div class="wpem-dj-inner-wrapper">
                                        <div class="wpem-row">

                                            <div class="wpem-col-md-3 wpem-col-sm-12">
                                                <div class="wpem-dj-logo-wrapper">
                                                    <div class="wpem-dj-logo">
                                                    <a>
                                                        <?php 
                                                        if(!in_array('dj_logo', $field_to_hide)) {
                                                            display_dj_logo('', '', $dj_id); 
                                                        }
                                                        ?>
                                                    </a></div>
                                                </div>
                                            </div>

                                            <div class="wpem-col-md-9 wpem-col-sm-12">
                                                <div class="wpem-dj-name wpem-heading-text">
                                                <span>
                                                    <?php 
                                                    if(!in_array('dj_name', $field_to_hide)) {
                                                        display_dj_name('', '', true, $dj_id); 
                                                    } 
                                                    ?>
                                                </span></div>

                                                <?php do_action('single_event_listing_dj_description_before', $dj_id);
                                                $dj = get_post($dj_id); ?>
                                                <div class="wpem-dj-description">
                                                <?php
                                                if(!in_array('dj_description', $field_to_hide)) {
                                                    $dj_content = get_post( $dj_id );
                                                    $content = apply_filters('wpem_the_content',$dj_content->post_content);
                                                    if(!empty($content)){
                                                        echo wp_kses_post($content);
                                                    }
                                                }
                                                    ?>
                                                </div>
                         
                                                <?php do_action('single_event_listing_dj_description_after', $dj_id); ?>

                                                <div class="wpem-dj-social-links">
                                                    <div class="wpem-dj-social-lists">
                                                        <?php do_action('single_event_listing_dj_social_start', $dj_id); ?>
                                                        <?php
                                                         //get disable dj fields
                                                         $dj_fields = get_hidden_form_fields( 'event_manager_submit_dj_form_fields', 'dj');

                                                         $dj_website  = !in_array('dj_website', $dj_fields)?get_dj_website($dj_id):'';
                                                         $dj_facebook = !in_array('dj_facebook', $dj_fields)?get_dj_facebook($dj_id):'';
                                                         $dj_instagram = !in_array('dj_instagram', $dj_fields)?get_dj_instagram($dj_id):'';
                                                         $dj_twitter  = !in_array('dj_twitter', $dj_fields)?get_dj_twitter($dj_id):'';
                                                         $dj_youtube  = !in_array('dj_youtube', $dj_fields)?get_dj_youtube($dj_id):'';
                                                        
                                                        if (!empty($dj_website) && !in_array('dj_website', $field_to_hide)) { ?>
                                                            <div class="wpem-social-icon wpem-weblink"><a href="<?php echo esc_url($dj_website); ?>" title="<?php esc_attr_e('Get Connect on Website', 'wp-event-manager'); ?>" target="_blank"><?php esc_html_e('Website', 'wp-event-manager'); ?></a></div>
                                                        <?php  }
                                                        if (!empty($dj_facebook) && !in_array('dj_facebook', $field_to_hide)) { ?>
                                                            <div class="wpem-social-icon wpem-facebook"><a href="<?php echo esc_url($dj_facebook); ?>" title="<?php esc_attr_e('Get Connect on Facebook', 'wp-event-manager'); ?>" target="_blank"><?php esc_html_e('Faceboo', 'wp-event-manager'); ?></a></div>
                                                        <?php }
                                                        if (!empty($dj_instagram) && !in_array('dj_instagram', $field_to_hide)) { ?>
                                                            <div class="wpem-social-icon wpem-instagram"><a href="<?php echo esc_url($dj_instagram); ?>" title="<?php esc_attr_e('Get Connect on Instagram', 'wp-event-manager'); ?>" target="_blank"><?php esc_html_e('Instagram', 'wp-event-manager'); ?></a></div>
                                                        <?php  }
                                                        if (!empty($dj_twitter) && !in_array('dj_twitter', $field_to_hide) ) { ?>
                                                            <div class="wpem-social-icon wpem-twitter"><a href="<?php echo esc_url($dj_twitter); ?>" title="<?php esc_attr_e('Get Connect on Twitter', 'wp-event-manager'); ?>" target="_blank"><?php esc_html_e('Twitter', 'wp-event-manager'); ?></a></div>
                                                        <?php }
                                                        if (!empty($dj_youtube) && !in_array('dj_youtube', $field_to_hide)) { ?>
                                                            <div class="wpem-social-icon wpem-youtube"><a href="<?php echo esc_url($dj_youtube); ?>" title="<?php esc_attr_e('Get Connect on Youtube', 'wp-event-manager'); ?>" target="_blank"><?php esc_html_e('Youtube', 'wp-event-manager'); ?></a></div>
                                                        <?php } ?>

                                                        <?php do_action('single_event_listing_dj_single_social_end', $dj_id); ?>

                                                    </div>

                                                </div>

                                                <div class="wpem-dj-contact-actions">
                                                    <?php do_action('single_event_listing_dj_action_start', $dj_id); ?>

                                                    <?php do_action('single_event_listing_dj_action_end', $dj_id); ?>
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                <?php endforeach;
                            endif;
                            do_action('single_event_listing_dj_end'); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else : 
    if (get_dj_name()) : ?>

        <div class="wpem-single-event-footer" itemscope itemtype="http://data-vocabulary.org/Organization">
            <div class="wpem-row">
                <div class="wpem-col-md-12">
                    <div class="wpem-dj-profile-wrapper" id="wpem_dj_profile">

                        <div class="wpem-event-dj-info-title">
                            <h3 class="wpem-heading-text"><?php esc_html_e('dj', 'wp-event-manager'); ?></h3>
                        </div>
                        <div class="wpem-dj-profile">

                            <?php do_action('single_event_listing_dj_start'); ?>

                            <div class="wpem-dj-inner-wrapper">
                                <div class="wpem-row">

                                    <div class="wpem-col-md-3 wpem-col-sm-12">
                                        <div class="wpem-dj-logo-wrapper">
                                            <div class="wpem-dj-logo"><a><?php display_dj_logo(); ?></a></div>
                                        </div>
                                    </div>

                                    <div class="wpem-col-md-9 wpem-col-sm-12">
                                        <div class="wpem-dj-name wpem-heading-text"><span><?php display_dj_name(); ?></span></div>

                                        <?php do_action('single_event_listing_dj_description_before'); ?>

                                        <div class="wpem-dj-short-info"><?php printf(esc_attr('%s', 'wp-event-manager'), wp_kses_post(get_dj_description())); ?></div>

                                        <?php do_action('single_event_listing_dj_description_after'); ?>

                                        <div class="wpem-dj-social-links">
                                            <div class="wpem-dj-social-lists">
                                                <?php do_action('single_event_listing_dj_social_start');
                                                
                                                $dj_website  = get_dj_website();
                                                $dj_facebook = get_dj_facebook();
                                                $dj_instagram = get_dj_instagram();
                                                $dj_twitter  = get_dj_twitter();
                                                $dj_youtube  = get_dj_youtube();
                                                
                                                if (!empty($dj_website)) { ?>
                                                    <div class="wpem-social-icon wpem-weblink"><a href="<?php echo esc_url($dj_website); ?>" title="<?php esc_attr_e('Get Connect on Website', 'wp-event-manager'); ?>" target="_blank"><?php esc_html_e('Website', 'wp-event-manager'); ?></a></div>
                                                <?php }
                                                if (!empty($dj_facebook)) { ?>
                                                    <div class="wpem-social-icon wpem-facebook"><a href="<?php echo esc_url($dj_facebook); ?>" title="<?php esc_attr_e('Get Connect on Facebook', 'wp-event-manager'); ?>" target="_blank"><?php esc_html_e('Faceboo', 'wp-event-manager'); ?></a></div>
                                                <?php }
                                                if (!empty($dj_instagram)) { ?>
                                                    <div class="wpem-social-icon wpem-instagram"><a href="<?php echo esc_url($dj_instagram); ?>" title="<?php esc_attr_e('Get Connect on Instagram', 'wp-event-manager'); ?>" target="_blank"><?php esc_html_e('Instagram', 'wp-event-manager'); ?></a></div>
                                                <?php }
                                                if (!empty($dj_twitter)) { ?>
                                                    <div class="wpem-social-icon wpem-twitter"><a href="<?php echo esc_url($dj_twitter); ?>" title="<?php esc_attr_e('Get Connect on Twitter', 'wp-event-manager'); ?>" target="_blank"><?php esc_html_e('Twitter', 'wp-event-manager'); ?></a></div>
                                                <?php }
                                                if (!empty($dj_youtube)) { ?>
                                                    <div class="wpem-social-icon wpem-youtube"><a href="<?php echo esc_url($dj_youtube); ?>" title="<?php esc_attr_e('Get Connect on Youtube', 'wp-event-manager'); ?>" target="_blank"><?php esc_html_e('Youtube', 'wp-event-manager'); ?></a></div>
                                                <?php } ?>
                                                <?php do_action('single_event_listing_dj_single_social_end'); ?>
                                            </div>
                                        </div>

                                        <div class="wpem-dj-contact-actions">
                                            <?php do_action('single_event_listing_dj_action_start'); ?>

                                            <?php do_action('single_event_listing_dj_action_end'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php do_action('single_event_listing_dj_end'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; 
endif; ?>