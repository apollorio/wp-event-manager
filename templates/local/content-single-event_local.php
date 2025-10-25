<?php $local = get_post($local_id); 
if (get_option('event_manager_form_fields') && is_array(get_option('event_manager_form_fields'))) {
    $local_custom_fields = get_option('event_manager_form_fields', true)['local'];
} else {
    $GLOBALS['event_manager']->forms->get_form( 'submit-local', array() );
    $form_submit_local_instance = call_user_func( array( 'WP_Event_Manager_Form_Submit_Local', 'instance' ) );
    $local_custom_fields = $form_submit_local_instance->merge_with_custom_fields( 'backend' );
} ?>

<div class="wpem-single-local-profile-wrapper" id="wpem_local_profile">
    <div class="wpem-local-profile">
        <?php do_action('single_event_listing_local_start'); ?>
        <div class="wpem-row">
            <div class="wpem-col-md-3">
                <div class="wpem-local-logo-wrapper">
                    <div class="wpem-local-logo">
                        <a><?php display_local_logo('', '', $local); ?></a>
                    </div>
                </div>
            </div>
            <div class="wpem-col-md-9 wpem-col-sm-12">
                <div class="wpem-local-infomation-wrapper">
                    <div class="wpem-local-name wpem-heading-text">
                        <span><?php echo esc_attr($local->post_title); ?></span>
                    </div>
                    <div class="wpem-local-description">
                    <?php $content = apply_filters('wpem_the_content',$local->post_content);
                    if(!empty($content)){
                        echo wp_kses_post( $content );}?>
                    </div>
                    <div class="wpem-local-social-links">
                        <div class="wpem-local-social-lists">
                            <?php do_action('single_event_listing_local_social_start'); ?>
                            <?php
                             //get disable local fields
                             $local_fields = get_hidden_form_fields( 'event_manager_submit_local_form_fields', 'local');

                             $local_website  = !in_array('local_website', $local_fields)?get_local_website($local):'';
                             $local_facebook = !in_array('local_facebook', $local_fields)?get_local_facebook($local):'';
                             $local_instagram = !in_array('local_instagram', $local_fields)?get_local_instagram($local):'';
                             $local_twitter  = !in_array('local_twitter', $local_fields)?get_local_twitter($local):'';
                             $local_youtube  = !in_array('local_youtube', $local_fields)?get_local_youtube($local):'';
                            
                            if (!empty($local_website)) { ?>
                                <div class="wpem-social-icon wpem-weblink">
                                    <a href="<?php echo esc_url($local_website); ?>" target="_blank" title="<?php esc_attr_e('Get Connect on Website', 'wp-event-manager'); ?>"><?php esc_html_e('Website', 'wp-event-manager'); ?></a>
                                </div>
                            <?php  }
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
                            <?php do_action('single_event_listing_local_single_social_end', $local_id); ?>
                        </div>
                    </div>
                    <?php do_action('custom_local_fields_start'); 
                    if (isset($local_custom_fields)) {
                        foreach ($local_custom_fields as $key => $field) :?>
                            <?php if (!strstr($key, 'local') && !strstr($key, 'vcv') && !strstr($key, 'submitting') && !empty(get_post_meta($local_id, '_' . $key))) : ?>
                                <div class="wpem-dj-additional-information">
                                    <strong><?php echo esc_attr($field['label']); ?>:</strong>
                                    <span><?php 
                                        $value = get_post_meta($local_id, '_' . $key, true);
                                        if($field['type'] == 'url' && !empty($value))
                                            echo '<a href="'.esc_url($value).'" target="_blank">'.esc_url($value).'</a>';
                                        else
                                            echo esc_attr($value); ?>
                                    </span>
                                </div>
                            <?php endif;
                        endforeach;
                    } 
                    do_action('custom_local_fields_end'); ?>
                </div>
            </div>
        </div>
        <div class="wpem-local-contact-actions">
            <?php do_action('single_event_listing_local_action_start', $local_id); ?>

            <?php do_action('single_event_listing_local_action_end', $local_id); ?>
        </div>
        <?php do_action('single_event_listing_local_end'); ?>
    </div>
</div>