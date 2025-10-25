<?php do_action('event_manager_local_dashboard_before'); ?>
<!-- Local dashboard title section start-->
<div class="wpem-dashboard-main-title wpem-dashboard-main-filter">
    <h3 class="wpem-theme-text"><?php esc_html_e('Local Dashboard', 'wp-event-manager'); ?></h3>

    <div class="wpem-d-inline-block wpem-dashboard-i-block-btn">

        <?php do_action('event_manager_local_dashboard_button_action_start');
        $submit_local = get_option('event_manager_submit_local_form_page_id');
        if (!empty($submit_local)) : ?>
            <a class="wpem-dashboard-header-btn wpem-dashboard-header-add-btn" title="<?php esc_html_e('Add local', 'wp-event-manager'); ?>" href="<?php echo esc_url(get_permalink($submit_local)); ?>"><i class="wpem-icon-plus"></i></a>
        <?php endif;
        do_action('event_manager_local_dashboard_button_action_end'); ?>

    </div>
</div>
<!-- Local dashboard title section end-->

<!-- Local list section start-->
<div id="event-manager-event-dashboard">
    <div class="wpem-responsive-table-block">
        <table class="wpem-main wpem-responsive-table-wrapper">
            <thead>
                <tr>
                    <?php foreach ($local_dashboard_columns as $key => $column) : ?>
                        <th class="wpem-heading-text <?php echo esc_attr($key); ?>"><?php echo esc_html($column); ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($locals)) : ?>
                    <tr>
                        <td colspan="4" class="wpem_data_td_empty"><?php esc_html_e('There are no locals.', 'wp-event-manager'); ?></td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($locals as $local) : ?>
                        <tr>
                            <?php foreach ($local_dashboard_columns as $key => $column) : ?>
                                <td data-title="<?php echo esc_html($column); ?>" class="<?php echo esc_attr($key); ?>">
                                    <?php if ('local_name' === $key) : ?>
                                        <div class="wpem-local-logo"><?php display_local_logo('', '', $local); ?></div>
                                        <a href="<?php echo esc_url(get_permalink($local->ID)); ?>"><?php echo esc_html($local->post_title); ?></a>
                                    <?php elseif ('local_details' === $key) : 
                                        do_action('single_event_listing_local_social_start', $local->ID);

                                        //get disable local fields
                                        $local_fields = get_hidden_form_fields( 'event_manager_submit_local_form_fields', 'local');
                                        $local_website  = !in_array('local_website', $local_fields)?get_local_website($local):'';
                                        $local_facebook = !in_array('local_facebook', $local_fields)?get_local_facebook($local):'';
                                        $local_instagram = !in_array('local_instagram', $local_fields)?get_local_instagram($local):'';
                                        $local_twitter  = !in_array('local_twitter', $local_fields)?get_local_twitter($local):'';
                                        $local_youtube  = !in_array('local_youtube', $local_fields)?get_local_youtube($local):'';

                                        if (empty($local_website) && empty($local_facebook) && empty($local_instagram) && empty($local_twitter) && empty($local_youtube)) {
                                            ?><span class="no-social-links">-</span><?php
                                        } else { ?>
                                            <div class="wpem-local-social-links">
                                                <div class="wpem-local-social-lists">
                                                    <?php if (!empty($local_website)) {  ?>
                                                        <div class="wpem-social-icon wpem-weblink">
                                                            <a href="<?php echo esc_url($local_website); ?>" target="_blank" title="<?php esc_attr_e('Get Connect on Website', 'wp-event-manager'); ?>"><?php esc_html_e('Website', 'wp-event-manager'); ?></a>
                                                        </div>
                                                    <?php }
                                                    if (!empty($local_facebook)) { ?>
                                                        <div class="wpem-social-icon wpem-facebook">
                                                            <a href="<?php echo esc_url($local_facebook); ?>" target="_blank" title="<?php esc_attr_e('Get Connect on Facebook', 'wp-event-manager'); ?>"><?php esc_html_e('Facebook', 'wp-event-manager'); ?></a>
                                                        </div>
                                                    <?php }
                                                    if (!empty($local_instagram)) { ?>
                                                        <div class="wpem-social-icon wpem-instagram">
                                                            <a href="<?php echo esc_url($local_instagram); ?>" target="_blank" title="<?php esc_attr_e('Get Connect on Instagram', 'wp-event-manager'); ?>"><?php esc_html_e('Instagram', 'wp-event-manager'); ?></a>
                                                        </div>
                                                    <?php }
                                                    if (!empty($local_twitter)) { ?>
                                                        <div class="wpem-social-icon wpem-twitter">
                                                            <a href="<?php echo esc_url($local_twitter); ?>" target="_blank" title="<?php esc_attr_e('Get Connect on Twitter', 'wp-event-manager'); ?>"><?php esc_html_e('Twitter', 'wp-event-manager'); ?></a>
                                                        </div>
                                                    <?php }
                                                    if (!empty($local_youtube)) { ?>
                                                        <div class="wpem-social-icon wpem-youtube">
                                                            <a href="<?php echo esc_url($local_youtube); ?>" target="_blank" title="<?php esc_attr_e('Get Connect on Youtube', 'wp-event-manager'); ?>"><?php esc_html_e('Youtube', 'wp-event-manager'); ?></a>
                                                        </div>
                                                    <?php } ?>

                                                    <?php do_action('single_event_listing_local_single_social_end', $local->ID); ?>
                                                </div>
                                            </div>
                                        <?php } ?>

                                    <?php elseif ('local_events' === $key) : 

                                        $local_events = get_event_by_local_id($local->ID); ?>
                                        <div class="event-local-count wpem-tooltip wpem-tooltip-bottom"><a href="javaScript:void(0)"><?php echo esc_html(count($local_events)); ?></a>
                                            <?php if (!empty($local_events)) : ?>
                                                <span class="local-events-list wpem-tooltiptext">
                                                    <?php foreach ($local_events as $local_event) : ?>
                                                        <span><a href="<?php echo esc_url(get_the_permalink($local_event->ID)); ?>"><?php  echo wp_kses_post(get_the_title($local_event->ID)); ?></a></span>
                                                    <?php endforeach; ?>
                                                </span>
                                            <?php else : ?>
                                                <span class="local-events-list wpem-tooltiptext"><span><a href="#"><?php esc_html_e('There is no event.', 'wp-event-manager'); ?></a></span></span>
                                            <?php endif; ?>
                                        </div>
                                    <?php elseif ('local_action' === $key) : ?>
                                        <div class="wpem-dboard-event-action">
                                            <?php
                                            $actions = array();
                                            switch ($local->post_status) {
                                                case 'publish':
                                                    $actions['edit']      = array(
                                                        'label' => __('Edit', 'wp-event-manager'),
                                                        'nonce' => false
                                                    );
                                                    $actions['duplicate'] = array(
                                                        'label' => __('Duplicate', 'wp-event-manager'),
                                                        'nonce' => true
                                                    );
                                                    break;
                                            }
                                            $actions['delete'] = array(
                                                'label' => __('Delete', 'wp-event-manager'),
                                                'nonce' => true
                                            );
                                            $actions            = apply_filters('event_manager_my_local_actions', $actions, $local);
                                            foreach ($actions as $action => $value) {
                                                $action_url = add_query_arg(array(
                                                    'action'   => $action,
                                                    'local_id' => $local->ID
                                                ));
                                                if (sanitize_key($value['nonce'])) {
                                                    $action_url = wp_nonce_url($action_url, 'event_manager_my_local_actions');
                                                }
                                                echo wp_kses_post('<div class="wpem-dboard-event-act-btn"><a href="' . esc_url($action_url) . '" class="event-dashboard-action-' . esc_attr($action) . '" title="' . esc_html($value['label']) . '" >' . esc_html($value['label']) . '</a></div>');
                                            }
                                            ?>
                                        </div>
                                    <?php else : ?>
                                        <?php do_action('event_manager_local_dashboard_column_' . $key, $local); ?>
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php get_event_manager_template('pagination.php', array('max_num_pages' => $max_num_pages)); ?>
</div>
<!-- Local list section end-->
<?php do_action('event_manager_local_dashboard_after'); ?>