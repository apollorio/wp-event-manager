<?php
/**
 * Single view dj information box
 *
 * Hooked into single_event_listing_start priority 30
 *
 * @since  3.1.6
 */
if (has_event_local_ids() && !is_event_online()) : ?>
    <div class="wpem-single-event-footer" itemscope itemtype="http://data-vocabulary.org/Organization">
        <div class="wpem-row">
            <div class="wpem-col-md-12">
                <div class="wpem-local-profile-wrapper" id="wpem_local_profile">
                    <?php $event_content_toggle = apply_filters('event_manager_event_content_toggle', true);
                    $event_content_toggle_class = $event_content_toggle ? 'wpem-listing-accordion' : 'wpem-event-local-info-title'; ?>

                    <div class="<?php echo esc_attr($event_content_toggle_class); ?> active">
                        <h3 class="wpem-heading-text"><?php esc_html_e('local', 'wp-event-manager'); ?></h3>
                        <?php if ($event_content_toggle) : ?>
                            <i class="wpem-icon-minus"></i><i class="wpem-icon-plus"></i>
                        <?php endif; ?>
                    </div>

                    <div class="wpem-local-wrapper wpem-listing-accordion-panel active" style="display: block;">
                        <div class="wpem-local-profile">
                            <?php do_action('single_event_listing_local_start'); ?>

                            <?php $local_id = get_event_local_ids(); ?>

                            <div class="wpem-local-inner-wrapper">
                                <div class="wpem-row">
                                    <div class="wpem-col-md-3 wpem-col-sm-12">
                                        <div class="wpem-local-logo-wrapper">
                                            <div class="wpem-local-logo">
                                                <a href="<?php echo esc_url(get_the_permalink($local_id)); ?>">
                                                    <?php display_local_logo('', '', $local_id); ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wpem-col-md-9 wpem-col-sm-12">
                                        <div class="wpem-local-name wpem-heading-text">
                                            <a href="<?php echo esc_attr(get_the_permalink($local_id)); ?>"><span><?php display_event_local_name('', '', true, $local_id); ?></span></a>
                                        </div>
                                        <?php do_action('single_event_listing_local_description_before', $local_id);
                                         $local = get_post($local_id);  ?>
                                        <div class="wpem-local-description"><?php
                                            $local_content = get_post( $local_id );
                                            $content = apply_filters('wpem_the_content',$local_content->post_content);
                                            if(!empty($content)){
                                            echo wp_kses_post( $content );}?>
                                        </div>

                                         <?php do_action('single_event_listing_local_description_after', $local_id); ?>

                                        <div class="wpem-local-social-links">
                                            <div class="wpem-local-social-lists">

                                                <?php do_action('single_event_listing_local_social_start', $local_id); 
                                                
                                                 //get disable local fields
                                                 $local_fields = get_hidden_form_fields( 'event_manager_submit_local_form_fields', 'local');

                                                 $local_website  = !in_array('local_website', $local_fields)?get_local_website($local_id):'';
                                                 $local_facebook = !in_array('local_facebook', $local_fields)?get_local_facebook($local_id):'';
                                                 $local_instagram = !in_array('local_instagram', $local_fields)?get_local_instagram($local_id):'';
                                                 $local_twitter  = !in_array('local_twitter', $local_fields)?get_local_twitter($local_id):'';
                                                 $local_youtube  = !in_array('local_youtube', $local_fields)?get_local_youtube($local_id):'';

                                                if (!empty($local_website)) {  ?>
                                                    <div class="wpem-social-icon wpem-weblink">
                                                        <a href="<?php echo esc_url($local_website); ?>" target="_blank" title="<?php esc_attr_e('Get Connect on Website', 'wp-event-manager'); ?>"><?php esc_html_e('Website', 'wp-event-manager'); ?></a>
                                                    </div>
                                                <?php   }

                                                if (!empty($local_facebook)) {   ?>
                                                    <div class="wpem-social-icon wpem-facebook">
                                                        <a href="<?php echo esc_url($local_facebook); ?>" target="_blank" title="<?php esc_attr_e('Get Connect on Facebook', 'wp-event-manager'); ?>"><?php esc_html_e('Facebook', 'wp-event-manager'); ?></a>
                                                    </div>
                                                <?php  }

                                                if (!empty($local_instagram)) { ?>
                                                    <div class="wpem-social-icon wpem-instagram">
                                                        <a href="<?php echo esc_url($local_instagram); ?>" target="_blank" title="<?php esc_attr_e('Get Connect on Instagram', 'wp-event-manager'); ?>"><?php esc_html_e('Instagram', 'wp-event-manager'); ?></a>
                                                    </div>
                                                <?php   }

                                                if (!empty($local_twitter)) {  ?>
                                                    <div class="wpem-social-icon wpem-twitter">
                                                        <a href="<?php echo esc_url($local_twitter); ?>" target="_blank" title="<?php esc_attr_e('Get Connect on Twitter', 'wp-event-manager'); ?>"><?php esc_html_e('Twitter', 'wp-event-manager'); ?></a>
                                                    </div>
                                                <?php }

                                                if (!empty($local_youtube)) { ?>
                                                    <div class="wpem-social-icon wpem-youtube">
                                                        <a href="<?php echo esc_url($local_youtube); ?>" target="_blank" title="<?php esc_attr_e('Get Connect on Youtube', 'wp-event-manager'); ?>"><?php esc_html_e('Youtube', 'wp-event-manager'); ?></a>
                                                    </div>
                                                <?php } ?>

                                                <?php do_action('single_event_listing_local_social_end', $local_id); ?>

                                            </div>
                                        </div>
                                    </div>
                                    <?php do_action('single_event_listing_local_map'); ?>
                                </div>
                            </div>
                            <?php do_action('single_event_listing_local_end'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php elseif (get_event_local_name() != '' && !is_event_online()) : ?>
    <div class="wpem-single-event-footer" itemscope itemtype="http://data-vocabulary.org/Organization">
        <div class="wpem-row">
            <div class="wpem-col-md-12">
                <div class="wpem-local-profile-wrapper" id="wpem_local_profile">
                    <?php $event_content_toggle = apply_filters('event_manager_event_content_toggle', true);
                    $event_content_toggle_class = $event_content_toggle ? 'wpem-listing-accordion' : 'wpem-event-local-info-title'; ?>
                    <div class="<?php echo esc_attr($event_content_toggle_class); ?> active">
                        <h3 class="wpem-heading-text"><?php esc_html_e('local', 'wp-event-manager'); ?></h3>
                        <?php if ($event_content_toggle) : ?>
                            <i class="wpem-icon-minus"></i><i class="wpem-icon-plus"></i>
                        <?php endif; ?>
                    </div>
                    <div class="wpem-local-wrapper wpem-listing-accordion-panel active" style="display: block;">
                        <div class="wpem-local-profile">
                            <?php do_action('single_event_listing_local_start'); ?>
                            <div class="wpem-local-inner-wrapper">
                                <div class="wpem-row">
                                    <div class="wpem-col-md-12 wpem-col-sm-12">
                                        <div class="wpem-local-name wpem-heading-text">
                                            <?php display_event_local_name(); ?></span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php do_action('single_event_listing_local_end'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>