<!-- local Counter -->
<div class="wpem-local-connter">
    <?php if (count($locals) > 0) : ?>
        <div class="local-related-data-counter">
            <div class="local-counter-number-icon">
                <div class="local-counter-upper-wrap">
                    <div class="local-counter-icon-wrap"><i class="wpem-icon-location2"></i></div>
                    <div class="local-counter-number-wrap"><?php echo esc_attr(count($locals)); ?></div>
                </div>
                <div class="local-counter-bottom-wrap"><?php esc_html_e('locals', 'wp-event-manager'); ?></div>
            </div>
            <div class="wpem-available-events-number-icon">
                <a href="<?php echo esc_url(get_the_permalink(get_option('event_manager_events_page_id'))); ?>" class="wpem-list-group-item" title="<?php esc_attr_e('Browse events', 'wp-event-manager'); ?>">
                    <div class="local-counter-upper-wrap">
                        <div class="local-counter-icon-wrap"><i class="wpem-icon-calendar"></i></div>
                        <div class="local-counter-number-wrap"><?php echo esc_attr($countAllEvents); ?></div>
                    </div>
                    <div class="local-counter-bottom-wrap"><?php esc_html_e('Available events', 'wp-event-manager'); ?></div>
                </a>
            </div>
        </div>
        <!-- end local Counter -->

        <!-- shows numbers and alphabet -->
        <div class="wpem-main local-letters local-letters">
            <div class="local-letters-list">
                <a id="ALL" href="#All"><?php esc_html_e('All', 'wp-event-manager'); ?></a>
            </div>
            <?php
            foreach (range('0', '9') as $letter) :?>
                <div class="local-letters-list"><a id="<?php echo esc_attr($letter);?>" href="#<?php echo esc_attr($letter);?>"><?php echo esc_attr($letter);?></a></div> <?php
            endforeach;
            foreach (range('A', 'Z') as $letter) : ?>
                <div class="local-letters-list"><a id="<?php echo esc_attr($letter);?>" href="#<?php echo esc_attr($letter);?>"><?php echo esc_attr($letter);?></a></div>
            <?php endforeach; ?>
        </div>

        <!-- shows local related data -->
        <div class="wpem-main wpem-row local-related-data-wrapper">
            <div class="wpem-col-md-12 local-related-info-wrapper">
                <div class="wpem-row">
                    <?php
                    foreach ($locals_array as $letter => $locals) : ?>
                        <div id="show_<?php echo esc_attr($letter); ?>" class="show-local-info show-local-info wpem-col-sm-12 wpem-col-md-6 wpem-col-lg-4">
                            <div class="wpem-list-group">
                                <div class="local-group-header wpem-list-group-item wpem-list-group-item-success">
                                    <div><?php echo esc_attr($letter); ?></div>
                                </div>
                                <div class="local-name-list">
                                    <?php foreach ($locals as $local_id => $local_name) :
                                        $count = get_event_local_count($local_id); ?>
                                        <div class="local-list-items">
                                            <a href="<?php echo esc_url(get_the_permalink($local_id)) ?>" class="wpem-list-group-item list-color" title="<?php esc_attr_e('Click here, for more info.', 'wp-event-manager'); ?>">
                                                <?php $local = get_post($local_id); ?>
                                                <?php if ($show_thumb && $show_thumb == 'true') : ?>
                                                    <div class="wpem-local-logo"><?php display_local_logo('', '', $local); ?></div>
                                                <?php endif; ?>

                                                <div class="wpem-local-name"><?php echo esc_attr($local_name); ?></div>

                                                <?php if ($count != 0 && $show_count && $show_count == 'true') : ?>
                                                    <div class="wpem-event-local-conunt-number"><?php echo esc_attr($count); ?></div>
                                                <?php endif; ?>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="no-local wpem-d-none">
                    <div class="wpem-alert wpem-alert-info">
                        <?php esc_html_e('There are no locals.', 'wp-event-manager'); ?>
                    </div>
                </div>
            </div>
            <!-- ends class col-md-12 -->
        </div>
    <?php else : ?>
        <div class="wpem-alert wpem-alert-info">
            <?php esc_html_e('There are no locals.', 'wp-event-manager'); ?>
        </div>
    <?php endif; ?>
</div>
<!-- end local Counter -->