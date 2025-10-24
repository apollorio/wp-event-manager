<?php
/**
 * Single view Local information box
 *
 * Hooked into single_event_listing_start priority 40
 * @since  3.2.2
 */

if (has_event_local_ids()) : 
    $local_id = get_event_local_ids();
    $local_post = get_post($local_id);
    
    if (!$local_post || $local_post->post_status !== 'publish') {
        return;
    }
    ?>
    <div class="wpem-single-event-footer" itemscope itemtype="http://schema.org/Place">
        <div class="wpem-row">
            <div class="wpem-col-md-12">
                <div class="wpem-local-profile-wrapper" id="wpem_local_profile">

                    <?php $event_content_toggle = apply_filters('event_manager_event_content_toggle', true);
                    $event_content_toggle_class = $event_content_toggle ? 'wpem-listing-accordion' : 'wpem-event-local-info-title'; ?>

                    <div class="<?php echo esc_attr($event_content_toggle_class); ?> active">
                        <h3 class="wpem-heading-text"><?php esc_html_e('Local/Venue', 'wp-event-manager'); ?></h3>
                        <?php if ($event_content_toggle) : ?>
                            <i class="wpem-icon-minus"></i><i class="wpem-icon-plus"></i>
                        <?php endif; ?>
                    </div>

                    <div class="wpem-local-wrapper wpem-listing-accordion-panel active" style="display: block;">
                        <div class="wpem-local-profile">

                            <?php do_action('single_event_listing_local_start'); ?>

                            <div class="wpem-local-inner-wrapper">
                                <div class="wpem-row">

                                    <div class="wpem-col-md-3 wpem-col-sm-12">
                                        <div class="wpem-local-logo-wrapper">
                                            <div class="wpem-local-logo">
                                                <a href="<?php echo esc_url(get_permalink($local_id)); ?>">
                                                    <?php 
                                                    if (has_post_thumbnail($local_id)) {
                                                        echo get_the_post_thumbnail($local_id, 'thumbnail');
                                                    } else {
                                                        echo '<img src="' . esc_url(EVENT_MANAGER_PLUGIN_URL . '/assets/images/wpem-placeholder.jpg') . '" alt="' . esc_attr($local_post->post_title) . '" />';
                                                    }
                                                    ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="wpem-col-md-9 wpem-col-sm-12">
                                        <div class="wpem-local-name wpem-heading-text">
                                            <span>
                                                <a href="<?php echo esc_url(get_permalink($local_id)); ?>">
                                                    <?php echo esc_html($local_post->post_title); ?>
                                                </a>
                                            </span>
                                        </div>

                                        <?php do_action('single_event_listing_local_description_before', $local_id); ?>

                                        <div class="wpem-local-description">
                                            <?php
                                            $content = apply_filters('wpem_the_content', $local_post->post_content);
                                            if (!empty($content)) {
                                                echo wp_kses_post($content);
                                            }
                                            ?>
                                        </div>
                 
                                        <?php do_action('single_event_listing_local_description_after', $local_id); ?>

                                        <div class="wpem-local-info">
                                            <?php
                                            // Display local address
                                            $local_address = get_post_meta($local_id, '_local_address', true);
                                            if (!empty($local_address)) { ?>
                                                <div class="wpem-local-address">
                                                    <strong><?php esc_html_e('Address:', 'wp-event-manager'); ?></strong> 
                                                    <?php echo esc_html($local_address); ?>
                                                </div>
                                            <?php }
                                            
                                            // Display local phone
                                            $local_phone = get_post_meta($local_id, '_local_phone', true);
                                            if (!empty($local_phone)) { ?>
                                                <div class="wpem-local-phone">
                                                    <strong><?php esc_html_e('Phone:', 'wp-event-manager'); ?></strong> 
                                                    <a href="tel:<?php echo esc_attr($local_phone); ?>"><?php echo esc_html($local_phone); ?></a>
                                                </div>
                                            <?php }
                                            
                                            // Display local email
                                            $local_email = get_post_meta($local_id, '_local_email', true);
                                            if (!empty($local_email)) { ?>
                                                <div class="wpem-local-email">
                                                    <strong><?php esc_html_e('Email:', 'wp-event-manager'); ?></strong> 
                                                    <a href="mailto:<?php echo esc_attr($local_email); ?>"><?php echo esc_html($local_email); ?></a>
                                                </div>
                                            <?php } ?>
                                        </div>

                                        <div class="wpem-local-social-links">
                                            <div class="wpem-local-social-lists">
                                                <?php do_action('single_event_listing_local_social_start', $local_id); ?>
                                                <?php
                                                // Get Local meta fields
                                                $local_website = get_post_meta($local_id, '_local_website', true);
                                                $local_facebook = get_post_meta($local_id, '_local_facebook', true);
                                                $local_instagram = get_post_meta($local_id, '_local_instagram', true);
                                                $local_twitter = get_post_meta($local_id, '_local_twitter', true);
                                                
                                                if (!empty($local_website)) { ?>
                                                    <div class="wpem-social-icon wpem-weblink"><a href="<?php echo esc_url($local_website); ?>" title="<?php esc_attr_e('Get Connect on Website', 'wp-event-manager'); ?>" target="_blank"><?php esc_html_e('Website', 'wp-event-manager'); ?></a></div>
                                                <?php  }
                                                if (!empty($local_facebook)) { ?>
                                                    <div class="wpem-social-icon wpem-facebook"><a href="<?php echo esc_url($local_facebook); ?>" title="<?php esc_attr_e('Get Connect on Facebook', 'wp-event-manager'); ?>" target="_blank"><?php esc_html_e('Facebook', 'wp-event-manager'); ?></a></div>
                                                <?php }
                                                if (!empty($local_instagram)) { ?>
                                                    <div class="wpem-social-icon wpem-instagram"><a href="<?php echo esc_url($local_instagram); ?>" title="<?php esc_attr_e('Get Connect on Instagram', 'wp-event-manager'); ?>" target="_blank"><?php esc_html_e('Instagram', 'wp-event-manager'); ?></a></div>
                                                <?php  }
                                                if (!empty($local_twitter)) { ?>
                                                    <div class="wpem-social-icon wpem-twitter"><a href="<?php echo esc_url($local_twitter); ?>" title="<?php esc_attr_e('Get Connect on Twitter', 'wp-event-manager'); ?>" target="_blank"><?php esc_html_e('Twitter', 'wp-event-manager'); ?></a></div>
                                                <?php } ?>

                                                <?php do_action('single_event_listing_local_single_social_end', $local_id); ?>

                                            </div>

                                        </div>

                                        <div class="wpem-local-contact-actions">
                                            <?php do_action('single_event_listing_local_action_start', $local_id); ?>

                                            <?php do_action('single_event_listing_local_action_end', $local_id); ?>
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
