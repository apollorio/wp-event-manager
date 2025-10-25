<?php
$check_user_access = wpem_checked_guest_user_access();
if($check_user_access == false && get_option('wpem_hide_data_from_guest')) {
    $field_to_hide = get_option('wpem_hide_dj_fields');
}else {
	$field_to_hide = array();
}
?>
<!-- DJ Counter -->
<div class="wpem-dj-connter">

    <?php if (count($djs) > 0) : ?>

        <div class="dj-related-data-counter">
            <div class="dj-counter-number-icon">
                <div class="dj-counter-upper-wrap">
                    <div class="dj-counter-icon-wrap"><i class="wpem-icon-users"></i></div>
                    <div class="dj-counter-number-wrap"><?php echo esc_attr(count($djs)); ?></div>
                </div>
                <div class="dj-counter-bottom-wrap"><?php esc_html_e('DJs', 'wp-event-manager'); ?></div>
            </div>
            <div class="wpem-available-events-number-icon">
                <a href="<?php echo esc_url(get_the_permalink(get_option('event_manager_events_page_id'))); ?>" class="wpem-list-group-item" title="<?php esc_attr_e('Browse events', 'wp-event-manager'); ?>">
                    <div class="dj-counter-upper-wrap">
                        <div class="dj-counter-icon-wrap"><i class="wpem-icon-calendar"></i></div>
                        <div class="dj-counter-number-wrap"><?php echo esc_attr($countAllEvents); ?></div>
                    </div>
                    <div class="dj-counter-bottom-wrap"><?php esc_html_e('Available events', 'wp-event-manager'); ?></div>
                </a>
            </div>
        </div>
        <!-- end DJ Counter -->

        <!-- shows numbers and alphabet -->
        <div class="wpem-main dj-letters">
            <div class="dj-letters-list">
                <a id="ALL" href="#All"><?php esc_html_e('All', 'wp-event-manager'); ?></a>
            </div>

            <?php
            foreach (range('0', '9') as $letter) : ?>
                <div class="dj-letters-list"><a id="<?php echo esc_attr($letter);?>" href="#<?php echo esc_attr($letter);?>"><?php echo esc_attr($letter);?></a></div>
            <?php endforeach;

            foreach (range('A', 'Z') as $letter) : ?>
                <div class="dj-letters-list"><a id="<?php echo esc_attr($letter);?>" href="#<?php echo esc_attr($letter);?>"><?php echo esc_attr($letter);?></a></div>
            <?php endforeach;  ?>

        </div>

        <!-- shows dj related data -->
        <div class="wpem-main wpem-row dj-related-data-wrapper">
            <div class="wpem-col-md-12 dj-related-info-wrapper">
                <div class="wpem-row">
                    <?php
                    foreach ($djs_array as $letter => $djs) : ?>
                        <div id="show_<?php echo esc_attr($letter); ?>" class="show-dj-info wpem-col-sm-12 wpem-col-md-6 wpem-col-lg-4">
                            <div class="wpem-list-group">
                                <div class="dj-group-header wpem-list-group-item wpem-list-group-item-success">
                                    <div><?php echo esc_attr($letter); ?></div>
                                </div>
                                <div class="dj-name-list">
                                    <?php foreach ($djs as $dj_id => $dj_name) :
                                        $count = get_event_dj_count($dj_id); ?>
                                        <div class="dj-list-items">
                                            <a href="<?php echo esc_url(get_the_permalink($dj_id)); ?>" class="wpem-list-group-item list-color" title="<?php esc_attr_e('Click here, for more info.', 'wp-event-manager'); ?>">
                                                <?php $dj = get_post($dj_id); if(!in_array('dj_logo', $field_to_hide)){?>
                                                <?php if ($show_thumb && $show_thumb == 'true') : ?>
                                                    <div class="wpem-dj-logo"><?php display_dj_logo('', '', $dj); ?></div>
                                                <?php endif;} ?>

                                                <div class="wpem-dj-name"><?php if(!in_array('dj_name', $field_to_hide)){echo esc_attr($dj_name); }?></div>

                                                <?php if ($count != 0 && $show_count && $show_count == 'true') : ?>
                                                    <div class="wpem-event-dj-conunt-number"><?php echo esc_attr($count); ?></div>
                                                <?php endif; ?>
                                            </a>
                                        </div>

                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="no-dj wpem-d-none">
                    <div class="wpem-alert wpem-alert-info">
                        <?php esc_html_e('There are no djs.', 'wp-event-manager'); ?>
                    </div>
                </div>
            </div>
            <!-- ends class col-md-12 -->
        </div>

    <?php else : ?>
        <div class="wpem-alert wpem-alert-info">
            <?php esc_html_e('There are no djs.', 'wp-event-manager'); ?>
        </div>
    <?php endif; ?>
</div>
<!-- end DJ Counter -->