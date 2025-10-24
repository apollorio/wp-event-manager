<?php
/**
 * Single event dj list information box(used for elementor)
 *
 * @since  3.1.32
 */
if (has_event_dj_ids($event_id)) :
if (get_option('event_manager_form_fields')) {
    $dj_custom_fields = get_option('event_manager_form_fields', true)['dj'];
}
?>

<div class="wpem-single-event-footer" itemscope itemtype="http://data-vocabulary.org/Organization">
    <div class="wpem-row">
        <div class="wpem-col-md-12">
            <div class="wpem-dj-profile-wrapper" id="wpem_dj_profile">

                <?php $event_content_toggle = apply_filters('event_manager_event_content_toggle', true);
                $event_content_toggle_class = $event_content_toggle ? 'wpem-listing-accordion' : 'wpem-event-dj-info-title'; ?>
                <div class="<?php echo esc_attr($event_content_toggle_class); ?> active">
                    <h3 class="wpem-heading-text"><?php esc_html_e('dj', 'wp-event-manager'); ?></h3>
                </div>
                <div class="wpem-dj-wrapper wpem-listing-accordion-panel active" style="display: block;">
                    <div class="wpem-dj-profile">

                        <?php do_action('single_event_listing_dj_start'); 
                        $dj_ids = get_event_dj_ids($event_id);
                        if (!empty($dj_ids)) :
                            foreach ($dj_ids as $key => $dj_id) : 
                                $dj = get_post($dj_id);

                                if (get_option('event_manager_form_fields')) {
                                    $dj_fields = get_option('event_manager_form_fields', true)['dj'];
                                }
                                $dj_email = esc_html(get_post_meta($dj_id, '_dj_email', true));
                                
                                do_action('single_event_listing_dj_start'); ?>
                                
                                <div class="wpem-single-dj-profile-wrapper" id="wpem_dj_profile">
                                     <div class="wpem-dj-profile">
                                        <div class="wpem-row">
                                            <!-- dj logo section start-->
                                            <div class="wpem-col-md-3">
                                                <div class="wpem-dj-logo-wrapper">
                                                    <div class="wpem-dj-logo">
                                                        <a><?php display_dj_logo('', '', $dj); ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- dj logo section end-->
                                            <div class="wpem-col-md-9 wpem-col-sm-12">
                                                <div class="wpem-dj-infomation-wrapper">
                                                    <!-- dj title-->
                                                    <div class="wpem-dj-name wpem-heading-text">
                                                        <span><?php echo esc_attr($dj->post_title); ?></span>
                                                    </div>
                                                    <!-- dj description-->
                                                    <div class="wpem-dj-description"><?php 
                                                        $content = apply_filters('wpem_the_content',$dj->post_content);
                                                        if(!empty($content)){
                                                        echo wp_kses_post( $content );}?>
                                                    </div>
                                                    <!-- dj social link section start-->
                                                    <div class="wpem-dj-social-links">
                                                        <div class="wpem-dj-social-lists">
                                                            <?php do_action('single_event_listing_dj_social_start', $dj_id);
                                                            //get disable dj fields
                                                            $dj_fields = get_hidden_form_fields( 'event_manager_submit_dj_form_fields', 'dj');
                                                            $dj_website  = !in_array('dj_website', $dj_fields)?get_dj_website($dj):'';
                                                            $dj_facebook = !in_array('dj_facebook', $dj_fields)?get_dj_facebook($dj):'';
                                                            $dj_instagram = !in_array('dj_instagram', $dj_fields)?get_dj_instagram($dj):'';
                                                            $dj_twitter  = !in_array('dj_twitter', $dj_fields)?get_dj_twitter($dj):'';
                                                            $dj_youtube  = !in_array('dj_youtube', $dj_fields)?get_dj_youtube($dj):'';
                                                           
                                                            if (!empty($dj_website)) { ?>
                                                                <div class="wpem-social-icon wpem-weblink">
                                                                    <a href="<?php echo esc_url($dj_website); ?>" target="_blank" title="<?php esc_attr_e('Get Connect on Website', 'wp-event-manager'); ?>"><?php esc_html_e('Website', 'wp-event-manager'); ?></a>
                                                                </div>
                                                            <?php }

                                                            if (!empty($dj_facebook)) { ?>
                                                                <div class="wpem-social-icon wpem-facebook">
                                                                    <a href="<?php echo esc_url($dj_facebook); ?>" target="_blank" title="<?php esc_attr_e('Get Connect on Facebook', 'wp-event-manager'); ?>"><?php esc_html_e('Facebook', 'wp-event-manager'); ?></a>
                                                                </div>
                                                            <?php }

                                                            if (!empty($dj_instagram)) { ?>
                                                                <div class="wpem-social-icon wpem-instagram">
                                                                    <a href="<?php echo esc_url($dj_instagram); ?>" target="_blank" title="<?php esc_attr_e('Get Connect on Instagram', 'wp-event-manager'); ?>"><?php esc_html_e('Instagram', 'wp-event-manager'); ?></a>
                                                                </div>
                                                            <?php }

                                                            if (!empty($dj_twitter)) { ?>
                                                                <div class="wpem-social-icon wpem-twitter">
                                                                    <a href="<?php echo esc_url($dj_twitter); ?>" target="_blank" title="<?php esc_attr_e('Get Connect on Twitter', 'wp-event-manager'); ?>"><?php esc_html_e('Twitter', 'wp-event-manager'); ?></a>
                                                                </div>
                                                            <?php }
                                                            if (!empty($dj_youtube)) { ?>
                                                                <div class="wpem-social-icon wpem-youtube">
                                                                    <a href="<?php echo esc_url($dj_youtube); ?>" target="_blank" title="<?php esc_attr_e('Get Connect on Youtube', 'wp-event-manager'); ?>"><?php esc_html_e('Youtube', 'wp-event-manager'); ?></a>
                                                                </div>
                                                            <?php } ?>

                                                            <?php do_action('single_event_listing_dj_single_social_end', $dj_id); ?>

                                                        </div>
                                                    </div>
                                                    <!-- dj social link section end-->
                                                    <?php do_action('submit_dj_form_dj_fields_start'); ?>
                                                    <!-- dj additional meta section start-->
                                                    <?php
                                                    if (isset($dj_custom_fields)) {
                                                        foreach ($dj_custom_fields as $key => $field) : ?>
                                                            <?php if (!strstr($key, 'dj') && !strstr($key, 'vcv') && !strstr($key, 'submitting') && !empty(get_post_meta($dj_id, '_' . $key))) : ?>
                                                                <div class="wpem-dj-additional-information">
                                                                    <strong><?php echo esc_attr($field['label']); ?>:</strong>
                                                                    <span><?php 
                                                                        $value = get_post_meta($dj_id, '_' . $key, true);
                                                                        if($field['type'] == 'url' && !empty($value))
                                                                            echo '<a href="'.esc_url($value).'" target="_blank">'.esc_url($value).'</a>';
                                                                        else
                                                                            echo esc_attr($value); ?>
                                                                    </span>
                                                                </div>
                                                            <?php endif; ?>
                                                    <?php endforeach;
                                                    } ?>
                                                     <!-- dj additional meta section end-->
                                                    <?php do_action('dj_form_dj_fields_end'); ?>
                                                    <div class="wpem-dj-contact-actions">
                                                        <?php do_action('single_event_listing_dj_action_start', $dj_id); ?>

                                                        <?php do_action('single_event_listing_dj_action_end', $dj_id); ?>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <?php do_action('single_event_listing_dj_end');
                                endforeach;
                            endif;
                        do_action('single_event_listing_dj_end'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php else : 
    if (get_dj_name($event_id)) : ?>

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
                                     <!-- dj logo section start-->
                                    <div class="wpem-col-md-3 wpem-col-sm-12">
                                        <div class="wpem-dj-logo-wrapper">
                                            <div class="wpem-dj-logo"><a><?php display_dj_logo($event_id); ?></a></div>
                                        </div>
                                    </div>
                                    <!-- dj logo section end-->
                                    <div class="wpem-col-md-9 wpem-col-sm-12">
                                        <div class="wpem-dj-name wpem-heading-text"><span><?php display_dj_name($event_id); ?></span></div>

                                        <?php do_action('single_event_listing_dj_description_before'); ?>
						
                                        <div class="wpem-dj-short-info"><?php printf(esc_attr('%s', 'wp-event-manager'), wp_kses_post(get_dj_description($event_id))); ?></div>

                                        <?php do_action('single_event_listing_dj_description_after'); ?>
                                         <!-- dj social link section start-->
                                        <div class="wpem-dj-social-links">
                                            <div class="wpem-dj-social-lists">
                                                <?php do_action('single_event_listing_dj_social_start'); 

                                                $dj_website  = get_dj_website($event_id);
                                                $dj_facebook = get_dj_facebook($event_id);
                                                $dj_instagram = get_dj_instagram($event_id);
                                                $dj_twitter  = get_dj_twitter($event_id);
                                                $dj_youtube  = get_dj_youtube($event_id);
                                                
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
                                         <!-- dj social link section end-->
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