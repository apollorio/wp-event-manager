<?php
/**
 * Single view DJ information box
 *
 * Hooked into single_event_listing_start priority 35
 * @since  3.2.2
 */

if (has_event_dj_ids()) : ?>
    <div class="wpem-single-event-footer" itemscope itemtype="http://schema.org/Person">
        <div class="wpem-row">
            <div class="wpem-col-md-12">
                <div class="wpem-dj-profile-wrapper" id="wpem_dj_profile">

                    <?php $event_content_toggle = apply_filters('event_manager_event_content_toggle', true);
                    $event_content_toggle_class = $event_content_toggle ? 'wpem-listing-accordion' : 'wpem-event-dj-info-title'; ?>

                    <div class="<?php echo esc_attr($event_content_toggle_class); ?> active">
                        <h3 class="wpem-heading-text"><?php esc_html_e('DJ', 'wp-event-manager'); ?></h3>
                        <?php if ($event_content_toggle) : ?>
                            <i class="wpem-icon-minus"></i><i class="wpem-icon-plus"></i>
                        <?php endif; ?>
                    </div>

                    <div class="wpem-dj-wrapper wpem-listing-accordion-panel active" style="display: block;">
                        <div class="wpem-dj-profile">

                            <?php do_action('single_event_listing_dj_start'); 

                            $dj_ids = get_event_dj_ids(); 

                            if (!empty($dj_ids) && is_array($dj_ids)) : 
                                foreach ($dj_ids as $key => $dj_id) :
                                    $dj_post = get_post($dj_id);
                                    if (!$dj_post || $dj_post->post_status !== 'publish') {
                                        continue;
                                    }
                                    ?>

                                    <div class="wpem-dj-inner-wrapper">
                                        <div class="wpem-row">

                                            <div class="wpem-col-md-3 wpem-col-sm-12">
                                                <div class="wpem-dj-logo-wrapper">
                                                    <div class="wpem-dj-logo">
                                                        <a href="<?php echo esc_url(get_permalink($dj_id)); ?>">
                                                            <?php 
                                                            if (has_post_thumbnail($dj_id)) {
                                                                echo get_the_post_thumbnail($dj_id, 'thumbnail');
                                                            } else {
                                                                echo '<img src="' . esc_url(EVENT_MANAGER_PLUGIN_URL . '/assets/images/wpem-placeholder.jpg') . '" alt="' . esc_attr($dj_post->post_title) . '" />';
                                                            }
                                                            ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="wpem-col-md-9 wpem-col-sm-12">
                                                <div class="wpem-dj-name wpem-heading-text">
                                                    <span>
                                                        <a href="<?php echo esc_url(get_permalink($dj_id)); ?>">
                                                            <?php echo esc_html($dj_post->post_title); ?>
                                                        </a>
                                                    </span>
                                                </div>

                                                <?php do_action('single_event_listing_dj_description_before', $dj_id); ?>

                                                <div class="wpem-dj-description">
                                                    <?php
                                                    $content = apply_filters('wpem_the_content', $dj_post->post_content);
                                                    if (!empty($content)) {
                                                        echo wp_kses_post($content);
                                                    }
                                                    ?>
                                                </div>
                     
                                                <?php do_action('single_event_listing_dj_description_after', $dj_id); ?>

                                                <div class="wpem-dj-social-links">
                                                    <div class="wpem-dj-social-lists">
                                                        <?php do_action('single_event_listing_dj_social_start', $dj_id); ?>
                                                        <?php
                                                        // Get DJ meta fields
                                                        $dj_website = get_post_meta($dj_id, '_dj_website', true);
                                                        $dj_facebook = get_post_meta($dj_id, '_dj_facebook', true);
                                                        $dj_instagram = get_post_meta($dj_id, '_dj_instagram', true);
                                                        $dj_twitter = get_post_meta($dj_id, '_dj_twitter', true);
                                                        $dj_youtube = get_post_meta($dj_id, '_dj_youtube', true);
                                                        
                                                        if (!empty($dj_website)) { ?>
                                                            <div class="wpem-social-icon wpem-weblink"><a href="<?php echo esc_url($dj_website); ?>" title="<?php esc_attr_e('Get Connect on Website', 'wp-event-manager'); ?>" target="_blank"><?php esc_html_e('Website', 'wp-event-manager'); ?></a></div>
                                                        <?php  }
                                                        if (!empty($dj_facebook)) { ?>
                                                            <div class="wpem-social-icon wpem-facebook"><a href="<?php echo esc_url($dj_facebook); ?>" title="<?php esc_attr_e('Get Connect on Facebook', 'wp-event-manager'); ?>" target="_blank"><?php esc_html_e('Facebook', 'wp-event-manager'); ?></a></div>
                                                        <?php }
                                                        if (!empty($dj_instagram)) { ?>
                                                            <div class="wpem-social-icon wpem-instagram"><a href="<?php echo esc_url($dj_instagram); ?>" title="<?php esc_attr_e('Get Connect on Instagram', 'wp-event-manager'); ?>" target="_blank"><?php esc_html_e('Instagram', 'wp-event-manager'); ?></a></div>
                                                        <?php  }
                                                        if (!empty($dj_twitter)) { ?>
                                                            <div class="wpem-social-icon wpem-twitter"><a href="<?php echo esc_url($dj_twitter); ?>" title="<?php esc_attr_e('Get Connect on Twitter', 'wp-event-manager'); ?>" target="_blank"><?php esc_html_e('Twitter', 'wp-event-manager'); ?></a></div>
                                                        <?php }
                                                        if (!empty($dj_youtube)) { ?>
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
<?php endif; ?>
