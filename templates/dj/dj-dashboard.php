<?php
/**
 * DJ Dashboard
 *
 * @since 3.2.2
 */

if (!defined('ABSPATH')) {
    exit;
}

do_action('event_manager_dj_dashboard_before');
?>

<div class="wpem-dashboard-main-content">
    <div class="wpem-dashboard-main-header">
        <div class="wpem-dashboard-main-title">
            <h3 class="wpem-theme-text"><?php esc_html_e('DJ Dashboard', 'wp-event-manager'); ?></h3>
            <div class="wpem-d-inline-block wpem-dashboard-i-block-btn">
                <?php do_action('event_manager_dj_dashboard_button_action_start'); ?>
                <?php $submit_dj = get_option('event_manager_submit_dj_form_page_id');
                if (!empty($submit_dj)) : ?>
                    <a class="wpem-dashboard-header-btn wpem-dashboard-header-add-btn" title="<?php esc_attr_e('Add DJ', 'wp-event-manager'); ?>" href="<?php echo esc_url(get_permalink($submit_dj)); ?>"><i class="wpem-icon-plus"></i></a>
                <?php endif; ?>
                <?php do_action('event_manager_dj_dashboard_button_action_end'); ?>
            </div>
        </div>
    </div>

    <div class="wpem-dashboard-djs-block-wrap">
        <div class="wpem-dashboard-dj-list-wrapper" id="wpem-dashboard-dj-list-wrapper">
            <div class="wpem-dashboard-dj-list-body">

                <?php if (!$djs) : ?>
                    <div class="wpem-alert wpem-alert-info"><?php esc_html_e('You do not have any DJs yet.', 'wp-event-manager'); ?></div>
                <?php else :
                    foreach ($djs as $dj) : ?>
                        <div class="wpem-dashboard-dj-list">
                            <div class="wpem-dashboard-dj-inner-list-wrap">
                                <div class="wpem-dashboard-dj-detail-front-block">
                                    <div class="wpem-dashboard-dj-thumbnail">
                                        <?php 
                                        if (has_post_thumbnail($dj->ID)) {
                                            echo get_the_post_thumbnail($dj->ID, 'thumbnail');
                                        } else {
                                            echo '<img src="' . esc_url(EVENT_MANAGER_PLUGIN_URL . '/assets/images/wpem-placeholder.jpg') . '" alt="' . esc_attr($dj->post_title) . '" />';
                                        }
                                        ?>
                                    </div>
                                    <div class="wpem-dashboard-dj-name">
                                        <?php if ($dj->post_status == 'publish') : ?>
                                            <a href="<?php echo esc_url(get_permalink($dj->ID)); ?>"><?php echo esc_html($dj->post_title); ?></a>
                                        <?php else : ?>
                                            <?php echo esc_html($dj->post_title); ?> 
                                            <small class="wpem-dj-status-<?php echo esc_attr($dj->post_status); ?>"><?php echo esc_html(ucfirst($dj->post_status)); ?></small>
                                        <?php endif; ?>
                                    </div>
                                    <div class="wpem-dashboard-dj-events-count">
                                        <?php 
                                        $event_count = get_event_dj_count($dj->ID);
                                        // translators: %d is the number of events
                                        echo esc_html(sprintf(_n('%d Event', '%d Events', $event_count, 'wp-event-manager'), $event_count));
                                        ?>
                                    </div>
                                </div>
                                <div class="wpem-dboard-dj-action">
                                    <?php
                                    $actions = [];
                                    switch ($dj->post_status) {
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

                                    $actions = apply_filters('event_manager_dj_dashboard_actions', $actions, $dj);

                                    foreach ($actions as $action => $value) {
                                        $action_url = '';
                                        if ($action == 'edit') {
                                            $page_id = get_option('event_manager_submit_dj_form_page_id');
                                            $action_url = add_query_arg(array('action' => 'edit', 'dj_id' => $dj->ID), get_permalink($page_id));
                                        } elseif ($action == 'view') {
                                            $action_url = get_permalink($dj->ID);
                                        } else {
                                            $action_url = add_query_arg(array('action' => $action, 'dj_id' => $dj->ID), event_manager_get_permalink('event_dashboard'));
                                            if ($value['nonce']) {
                                                $action_url = wp_nonce_url($action_url, 'event_manager_my_dj_actions');
                                            }
                                        }

                                        printf(
                                            '<a href="%s" class="wpem-dashboard-action-%s" title="%s">%s</a> ',
                                            esc_url($action_url),
                                            esc_attr($action),
                                            esc_attr($value['label']),
                                            esc_html($value['label'])
                                        );
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

<?php do_action('event_manager_dj_dashboard_after'); ?>
