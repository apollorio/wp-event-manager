<?php

/**
 * Event Submission Form
 */
if(!defined('ABSPATH')) exit;
global $event_manager; 
do_action('wp_event_manager_event_submit_before');
$allowed_field_types = array_keys(wpem_get_form_field_types()); ?>

<form action="<?php echo esc_url($action); ?>" method="post" id="submit-event-form" class="wpem-form-wrapper wpem-main event-manager-form" enctype="multipart/form-data">
	<?php if(apply_filters('submit_event_form_show_signin', true)) : 
		get_event_manager_template('account-signin.php'); 
	 endif; 
	if(event_manager_user_can_post_event() || event_manager_user_can_edit_event($event_id)) : ?>
		<!-- Event Information Fields -->
		<h2 class="wpem-form-title wpem-heading-text"><?php esc_html_e('Event Details', 'wp-event-manager'); ?></h2>
		<?php
		if(isset($resume_edit) && $resume_edit) {
			/* translators: %s is the link to create a new event, and %s is the resume edit link */
			printf(
				'<p class="wpem-alert wpem-alert-info"><strong>%s</strong></p>',
				sprintf(
					esc_html__('You are editing an existing event. %s', 'wp-event-manager'),
					'<a href="?new=1&key=' . esc_attr($resume_edit) . '">' . esc_html__('Create A New Event', 'wp-event-manager') . '</a>'
				)
			);
		}

		do_action('submit_event_form_event_fields_start'); 

		//Show Hide event thumbnail field on front end
		$thumbnail_key = 'event_thumbnail'; 
		$show_thumbnail_field = get_option('event_manager_upload_custom_thumbnail', false); 

		foreach($event_fields as $key => $field) : 
			if(isset($field['visibility']) && ($field['visibility'] == 0 || $field['visibility'] = false)) :
				continue;
			endif; 
			if (isset($field['type']) && $field['type'] === 'media-library-image' && !is_user_logged_in()) {
				continue;
			}
			if ($key === $thumbnail_key && $show_thumbnail_field != 1) {
				continue;
			} ?>
			<fieldset class="wpem-form-group fieldset-<?php echo esc_attr($key); ?>">
				<label for="<?php echo esc_attr($key); ?>">
					<?php echo esc_html($field['label'], 'wp-event-manager');
					echo wp_kses_post(apply_filters('submit_event_form_required_label', $field['required'] ? '<span class="require-field">*</span>' : ' <small>' . __('(optional)', 'wp-event-manager') . '</small>', $field)); ?>
				</label>
				<div class="field <?php echo esc_attr($field['required'] ? 'required-field' : ''); ?>">
					<?php if(isset($field['addon']) && !empty($field['addon'])) : 
						do_action('wpem_submit_event_form_addon_before', $field, $key);	
					else : 
						$field_type = in_array($field['type'], $allowed_field_types, true) ? $field['type'] : 'text';
						get_event_manager_template('form-fields/' . $field_type . '-field.php', array('key' => $key, 'field' => $field)); 
					endif; ?>
				</div>
			</fieldset>
		<?php endforeach; 
		do_action('submit_event_form_event_fields_end'); ?>

		<!-- dj Information Fields -->
		<?php if(get_option('enable_event_dj')) :
			if($dj_fields) :
				do_action('submit_event_form_dj_fields_start');
				foreach($dj_fields as $key => $field) :
					if (isset($field['type']) && $field['type'] === 'media-library-image' && !is_user_logged_in()) {
						continue;
					}
					if(isset($field['visibility']) && ($field['visibility'] == 0 || $field['visibility'] == false)) :
						continue;
					endif;?>
					<fieldset class="wpem-form-group fieldset-<?php echo esc_attr($key); ?>">
						<h2 class="wpem-form-title wpem-heading-text"><?php esc_html_e('dj Details', 'wp-event-manager'); ?></h2>
						<label for="<?php echo esc_attr($key); ?>">
							<?php echo esc_html($field['label'], 'wp-event-manager');
							echo wp_kses_post(apply_filters('submit_event_form_required_label', $field['required'] ? '<span class="require-field">*</span>' : ' <small>' . __('(optional)', 'wp-event-manager') . '</small>', $field)); ?>
						</label>
						<div class="field <?php echo esc_attr($field['required'] ? 'required-field' : ''); ?>">
							<?php $field_type = in_array($field['type'], $allowed_field_types, true) ? $field['type'] : 'text';
							get_event_manager_template('form-fields/' . $field_type . '-field.php', array('key' => $key, 'field' => $field)); ?>
						</div>
					</fieldset>
				<?php endforeach;
				do_action('submit_event_form_dj_fields_end'); 
			 endif; 
		endif; ?>

		<!-- local Information Fields -->
		<?php if(get_option('enable_event_local')) :
			if($local_fields) :
				 do_action('submit_event_form_local_fields_start'); 
				foreach($local_fields as $key => $field) :
					if (isset($field['type']) && $field['type'] === 'media-library-image' && !is_user_logged_in()) {
						continue;
					}
					if(isset($field['visibility']) && ($field['visibility'] == 0 || $field['visibility'] == false)) :
						continue;
					endif;?>
					<fieldset class="wpem-form-group fieldset-<?php echo esc_attr($key); ?>">
						<h2 class="wpem-form-title wpem-heading-text"><?php esc_html_e('local Details', 'wp-event-manager'); ?></h2>
						<label for="<?php echo esc_attr($key); ?>">
							<?php echo esc_html($field['label'], 'wp-event-manager');
							echo wp_kses_post(apply_filters('submit_event_form_required_label', $field['required'] ? '<span class="require-field">*</span>' : ' <small>' . __('(optional)', 'wp-event-manager') . '</small>', $field)); ?>
						</label>
						<div class="field <?php echo esc_attr($field['required'] ? 'required-field' : ''); ?>">
							<?php $field_type = in_array($field['type'], $allowed_field_types, true) ? $field['type'] : 'text';
							get_event_manager_template('form-fields/' . $field_type . '-field.php', array('key' => $key, 'field' => $field)); ?>
						</div>
					</fieldset>
				<?php endforeach;
				do_action('submit_event_form_local_fields_end');
			endif;
		endif; ?>

		<div class="wpem-form-footer">
			<input type="hidden" name="event_manager_form" value="<?php echo esc_attr($form); ?>" />
			<input type="hidden" name="event_id" value="<?php echo esc_attr($event_id); ?>" />
			<input type="hidden" name="step" value="<?php echo esc_attr($step); ?>" />
			<input type="submit" name="submit_event" class="wpem-theme-button" value="<?php echo esc_attr($submit_button_text); ?>" />
		</div>
	<?php else :
		do_action('submit_event_form_disabled');
	endif; ?>
</form>

<?php if(get_option('enable_event_dj')) : 

	$dj_fields =	$GLOBALS['event_manager']->forms->get_fields('submit-dj');
	if(is_user_logged_in()) {
		$current_user = wp_get_current_user();
		if(isset($dj_fields['dj']['dj_name']))
			$dj_fields['dj']['dj_name']['value'] =  $current_user->display_name;
		if(isset($dj_fields['dj']['dj_email']))
			$dj_fields['dj']['dj_email']['value'] =  $current_user->user_email;
	}
	?>

	<div id="wpem_add_dj_popup" class="wpem-modal" role="dialog" aria-labelledby="<?php echo esc_attr__('Add dj', 'wp-event-manager'); ?>">
		<div class="wpem-modal-content-wrapper">
			<div class="wpem-modal-header">
				<div class="wpem-modal-header-title">
					<h3 class="wpem-modal-header-title-text"><?php esc_html_e('Add dj', 'wp-event-manager'); ?></h3>
				</div>
				<div class="wpem-modal-header-close"><a href="javascript:void(0)" class="wpem-modal-close" id="wpem-modal-close">x</a></div>
			</div>
			<div class="wpem-modal-content">
				<form method="post" id="submit-dj-form" class="wpem-form-wrapper wpem-main event-manager-form" enctype="multipart/form-data">
					<h2 class="wpem-form-title wpem-heading-text"><?php esc_html_e('dj Details', 'wp-event-manager'); ?></h2>

					<?php do_action('submit_dj_form_dj_fields_start'); ?>

					<?php if(isset($dj_fields['dj']) && is_array($dj_fields['dj'])): ?>
						<?php foreach($dj_fields['dj'] as $key => $field) : ?>
							<?php if(isset($field['visibility']) && ($field['visibility'] == 0 || $field['visibility'] == false)) : ?>
								<?php continue; ?>
							<?php endif; ?>
							<fieldset class="wpem-form-group fieldset-<?php echo esc_attr($key); ?>">
								<label for="<?php echo esc_attr($key, 'wp-event-manager'); ?>">
								<?php echo esc_html($field['label'], 'wp-event-manager');
								 echo wp_kses_post(apply_filters('submit_event_form_required_label', $field['required'] ? '<span class="require-field">*</span>' : ' <small>' . __('(optional)', 'wp-event-manager') . '</small>', $field)); ?>
								</label>
								<div class="field <?php echo esc_attr($field['required'] ? 'required-field' : ''); ?>">
									<?php $field_type = in_array($field['type'], $allowed_field_types, true) ? $field['type'] : 'text';
									get_event_manager_template('form-fields/' . $field_type . '-field.php', array('key' => $key, 'field' => $field)); ?>
								</div>
							</fieldset>
						<?php endforeach; ?>
					<?php else: ?>
						<div class="wpem-error">Nenhum campo DJ disponível. Contate o administrador.</div>
					<?php endif; ?>
					<?php do_action('submit_dj_form_dj_fields_end'); ?>

					<div class="wpem-form-footer">
						<?php wp_nonce_field( 'wpem_add_dj_action', 'wpem_add_dj_nonce' ); ?>
						<input type="hidden" name="dj_id" value="0">
						<input type="hidden" name="step" value="0">
						<input type="button" name="submit_dj" class="wpem-theme-button wpem_add_dj" value="<?php esc_html_e('Add dj', 'wp-event-manager'); ?>" />
						<div id="oragnizer_message"></div>
					</div>
				</form>
			</div>
		</div>
		<a href="#">
			<div class="wpem-modal-overlay"></div>
		</a>
	</div>
<?php endif;

if(get_option('enable_event_local')) :

	$GLOBALS['event_manager']->forms->get_form('submit-local', array());
	$form_submit_local_instance = call_user_func(array('WP_Event_Manager_Form_Submit_local', 'instance'));
	$local_fields =	$form_submit_local_instance->merge_with_custom_fields('backend'); ?>

	<div id="wpem_add_local_popup" class="wpem-modal" role="dialog" aria-labelledby="<?php echo esc_attr__('Add local', 'wp-event-manager'); ?>">
		<div class="wpem-modal-content-wrapper">
			<div class="wpem-modal-header">
				<div class="wpem-modal-header-title">
					<h3 class="wpem-modal-header-title-text"><?php esc_html_e('Add local', 'wp-event-manager'); ?></h3>
				</div>
				<div class="wpem-modal-header-close"><a href="javascript:void(0)" class="wpem-modal-close" id="wpem-modal-close">x</a></div>
			</div>
			<div class="wpem-modal-content">
				<form method="post" id="submit-local-form" class="wpem-form-wrapper wpem-main event-manager-form" enctype="multipart/form-data">
					<h2 class="wpem-form-title wpem-heading-text"><?php esc_html_e('local Details', 'wp-event-manager'); ?></h2>

					<?php do_action('submit_local_form_local_fields_start'); ?>

					<?php foreach($local_fields['local'] as $key => $field) : 
						if(isset($field['visibility']) && ($field['visibility'] == 0 || $field['visibility'] = false)) :
							continue;
						endif; ?>
						<fieldset class="wpem-form-group fieldset-<?php echo esc_attr($key); ?>">
							<label for="<?php echo esc_attr($key, 'wp-event-manager'); ?>">
								<?php echo esc_html($field['label'], 'wp-event-manager');
								echo wp_kses_post(apply_filters('submit_event_form_required_label', $field['required'] ? '<span class="require-field">*</span>' : ' <small>' . __('(optional)', 'wp-event-manager') . '</small>', $field)); ?>
							</label>
							
							<div class="field <?php echo esc_attr($field['required'] ? 'required-field' : ''); ?>">
								<?php $field_type = in_array($field['type'], $allowed_field_types, true) ? $field['type'] : 'text';
								get_event_manager_template('form-fields/' . $field_type . '-field.php', array('key' => $key, 'field' => $field)); ?>
							</div>
						</fieldset>
					<?php endforeach; ?>
					<?php do_action('submit_local_form_local_fields_end'); ?>

					<div class="wpem-form-footer">
						<?php wp_nonce_field( 'wpem_add_local_action', 'wpem_add_local_nonce' ); ?>
						<input type="hidden" name="local_id" value="0">
						<input type="hidden" name="step" value="0">
						<input type="button" name="submit_local" class="wpem-theme-button wpem_add_local" value="<?php esc_html_e('Add local', 'wp-event-manager'); ?>" />
						<div id="local_message"></div>
					</div>
				</form>
			</div>
		</div>
		<a href="#">
			<div class="wpem-modal-overlay"></div>
		</a>
	</div>
<?php endif; ?>