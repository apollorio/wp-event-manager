<?php
/**
 * Local Dashboard
 *
 * @since 3.2.2
 */

if (!defined('ABSPATH')) {
    exit;
}

do_action('event_manager_local_dashboard_before');
?>

<div class="wpem-dashboard-main-content">
    <div class="wpem-dashboard-main-header">
        <div class="wpem-dashboard-main-title">
            <h3 class="wpem-theme-text"><?php esc_html_e('Local Dashboard', 'wp-event-manager'); ?></h3>
            <div class="wpem-d-inline-block wpem-dashboard-i-block-btn">
                <?php do_action('event_manager_local_dashboard_button_action_start'); ?>
                <?php $submit_local = get_option('event_manager_submit_local_form_page_id');
                if (!empty($submit_local)) : ?>
                    <a class="wpem-dashboard-header-btn wpem-dashboard-header-add-btn" title="<?php esc_attr_e('Add Local', 'wp-event-manager'); ?>" href="<?php echo esc_url(get_permalink($submit_local)); ?>"><i class="wpem-icon-plus"></i></a>
                <?php endif; ?>
                <?php do_action('event_manager_local_dashboard_button_action_end'); ?>
            </div>
        </div>
    </div>

    <div class="wpem-dashboard-locals-block-wrap">
        <div class="wpem-dashboard-local-list-wrapper" id="wpem-dashboard-local-list-wrapper">
            <div class="wpem-dashboard-local-list-body">

                <?php if (!$locals) : ?>
                    <div class="wpem-alert wpem-alert-info"><?php esc_html_e('You do not have any Locals/Venues yet.', 'wp-event-manager'); ?></div>
                <?php else :
                    foreach ($locals as $local) : ?>
                        <div class="wpem-dashboard-local-list">
                            <div class="wpem-dashboard-local-inner-list-wrap">
                                <div class="wpem-dashboard-local-detail-front-block">
                                    <div class="wpem-dashboard-local-thumbnail">
                                        <?php 
                                        if (has_post_thumbnail($local->ID)) {
                                            echo get_the_post_thumbnail($local->ID, 'thumbnail');
                                        } else {
                                            echo '<img src="' . esc_url(EVENT_MANAGER_PLUGIN_URL . '/assets/images/wpem-placeholder.jpg') . '" alt="' . esc_attr($local->post_title) . '" />';
                                        }
                                        ?>
                                    </div>
                                    <div class="wpem-dashboard-local-name">
                                        <?php if ($local->post_status == 'publish') : ?>
                                            <a href="<?php echo esc_url(get_permalink($local->ID)); ?>"><?php echo esc_html($local->post_title); ?></a>
                                        <?php else : ?>
                                            <?php echo esc_html($local->post_title); ?> 
                                            <small class="wpem-local-status-<?php echo esc_attr($local->post_status); ?>"><?php echo esc_html(ucfirst($local->post_status)); ?></small>
                                        <?php endif; ?>
                                    </div>
                                    <div class="wpem-dashboard-local-events-count">
                                        <?php 
                                        $event_count = get_event_local_count($local->ID);
                                        // translators: %d is the number of events
                                        printf(esc_html(_n('%d Event', '%d Events', $event_count, 'wp-event-manager')), esc_html($event_count));
                                        ?>
                                    </div>
                                    <div class="wpem-dashboard-local-address">
                                        <?php 
                                        $local_address = get_post_meta($local->ID, '_local_address', true);
                                        if (!empty($local_address)) {
                                            echo esc_html($local_address);
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="wpem-dboard-local-action">
                                    <?php
                                    $actions = [];
                                    switch ($local->post_status) {
                                        case 'publish':
                                            $actions['view'] = array(
                                                'label' => __('View', 'wp-event-manager'),
                                                'nonce' => false
                                            );
                                            $actions['edit'] = array(
                                                'label' => __('Edit', 'wp-event-manager'),
                                                'nonce' => false
                                            );
                                            $actions['duplicate'] = array(
                                                'label' => __('Duplicate', 'wp-event-manager'),
                                                'nonce' => true
                                            );
                                            $actions['delete'] = array(
                                                'label' => __('Delete', 'wp-event-manager'),
                                                'nonce' => true
                                            );
                                            break;
                                        case 'pending':
                                            $actions['edit'] = array(
                                                'label' => __('Edit', 'wp-event-manager'),
                                                'nonce' => false
                                            );
                                            break;
                                        default:
                                            $actions['delete'] = array(
                                                'label' => __('Delete', 'wp-event-manager'),
                                                'nonce' => true
                                            );
                                            break;
                                    }

                                    $actions = apply_filters('event_manager_local_dashboard_actions', $actions, $local);

                                    foreach ($actions as $action => $value) {
                                        $action_url = '';
                                        if ($action == 'edit') {
                                            $page_id = get_option('event_manager_submit_local_form_page_id');
                                            $action_url = add_query_arg(array('action' => 'edit', 'local_id' => $local->ID), get_permalink($page_id));
                                        } elseif ($action == 'view') {
                                            $action_url = get_permalink($local->ID);
                                        } else {
                                            $action_url = add_query_arg(array('action' => $action, 'local_id' => $local->ID), event_manager_get_permalink('event_dashboard'));
                                            if ($value['nonce']) {
                                                $action_url = wp_nonce_url($action_url, 'event_manager_my_local_actions');
                                            }
                                        }

                                        echo '<a href="' . esc_url($action_url) . '" class="wpem-dashboard-action-' . esc_attr($action) . '" title="' . esc_attr($value['label']) . '">' . esc_html($value['label']) . '</a> ';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

            </div>
        </div>

        <?php if ($max_num_pages > 1) : ?>
            <nav class="wpem-pagination">
                <?php
                echo paginate_links(array(
                    'base'    => str_replace(999999, '%#%', esc_url(get_pagenum_link(999999))),
                    'format'  => '?paged=%#%',
                    'current' => max(1, get_query_var('paged')),
                    'total'   => $max_num_pages,
                ));
                ?>
            </nav>
        <?php endif; ?>
    </div>
</div>

<?php do_action('event_manager_local_dashboard_after'); ?>
