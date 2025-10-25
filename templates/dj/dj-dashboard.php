<?php do_action('event_manager_dj_dashboard_before'); ?>
<!-- dj dashboard title section start-->
<div class="wpem-dashboard-main-title wpem-dashboard-main-filter">
	<h3 class="wpem-theme-text"><?php esc_html_e('DJ Dashboard', 'wp-event-manager'); ?></h3>

	<div class="wpem-d-inline-block wpem-dashboard-i-block-btn">

		<?php do_action('event_manager_dj_dashboard_button_action_start'); 
		
		$submit_dj = get_option('event_manager_submit_dj_form_page_id');
		if (!empty($submit_dj)) : ?>
			<a class="wpem-dashboard-header-btn wpem-dashboard-header-add-btn" title="<?php esc_attr_e('Add dj', 'wp-event-manager'); ?>" href="<?php echo esc_url(get_permalink($submit_dj)); ?>"><i class="wpem-icon-plus"></i></a>
		<?php endif;
		
		do_action('event_manager_dj_dashboard_button_action_end'); ?>

	</div>
</div>
<!-- dj dashboard title section start-->

<!-- dj list section start-->
<div id="event-manager-event-dashboard">
	<div class="wpem-responsive-table-block">
		<table class="wpem-main wpem-responsive-table-wrapper">
			<thead>
				<tr>
					<?php foreach ($dj_dashboard_columns as $key => $column) : ?>
						<th class="wpem-heading-text <?php echo esc_attr($key); ?>"><?php echo esc_html($column); ?></th>
					<?php endforeach; ?>
				</tr>
			</thead>
			<tbody>
				<?php if (empty($djs)) : ?>
					<tr>
						<td class="wpem_data_td_empty" colspan="<?php echo esc_attr(count($dj_dashboard_columns)); ?>"><?php esc_html_e('There are no djs.', 'wp-event-manager'); ?></td>
					</tr>
				<?php else :
					foreach ($djs as $dj) : ?>
						<tr>
							<?php foreach ($dj_dashboard_columns as $key => $column) : ?>
								<td data-title="<?php echo esc_html($column); ?>" class="<?php echo esc_attr($key); ?>">
									<?php if ('dj_name' === $key) : ?>
										<div class="wpem-dj-logo"><?php display_dj_logo('', '', $dj); ?></div>
										<a href="<?php echo esc_url(get_permalink($dj->ID)); ?>"><?php echo esc_html($dj->post_title); ?></a>

									<?php elseif ('dj_details' === $key) : 

										do_action('single_event_listing_dj_social_start', $dj->ID);

										//get disable dj fields
										$dj_fields = get_hidden_form_fields( 'event_manager_submit_dj_form_fields', 'dj');
										$dj_website  = !in_array('dj_website', $dj_fields)?get_dj_website($dj):'';
										$dj_facebook = !in_array('dj_facebook', $dj_fields)?get_dj_facebook($dj):'';
										$dj_instagram = !in_array('dj_instagram', $dj_fields)?get_dj_instagram($dj):'';
										$dj_twitter  = !in_array('dj_twitter', $dj_fields)?get_dj_twitter($dj):'';
										$dj_youtube  = !in_array('dj_youtube', $dj_fields)?get_dj_youtube($dj):'';

										if (empty($dj_website) && empty($dj_facebook) && empty($dj_instagram) && empty($dj_twitter) && empty($dj_youtube)) {
											?><h1 class="text-left" style="font-weight: 200;">-</h1><?php
										} else { ?>
											<div class="wpem-dj-social-links">
												<div class="wpem-dj-social-lists">

													<?php if (!empty($dj_website)) { ?>
														<div class="wpem-social-icon wpem-weblink">
															<a href="<?php echo esc_url($dj_website); ?>" target="_blank" title="<?php esc_attr_e('Get Connect on Website', 'wp-event-manager'); ?>"><?php esc_html_e('Website', 'wp-event-manager'); ?></a>
														</div>
													<?php }

													if (!empty($dj_facebook)) { ?>
														<div class="wpem-social-icon wpem-facebook">
															<a href="<?php echo esc_url($dj_facebook); ?>" target="_blank" title="<?php esc_attr_e('Get Connect on Facebook', 'wp-event-manager'); ?>"><?php esc_html_e('Facebook', 'wp-event-manager'); ?></a>
														</div>
													<?php }

													if (!empty($dj_instagram)) { ?>
														<div class="wpem-social-icon wpem-instagram">
															<a href="<?php echo esc_url($dj_instagram); ?>" target="_blank" title="<?php esc_attr_e('Get Connect on Instagram', 'wp-event-manager'); ?>"><?php esc_html_e('Instagram', 'wp-event-manager'); ?></a>
														</div>
													<?php }

													if (!empty($dj_twitter)) { ?>
														<div class="wpem-social-icon wpem-twitter">
															<a href="<?php echo esc_url($dj_twitter); ?>" target="_blank" title="<?php esc_attr_e('Get Connect on Twitter', 'wp-event-manager'); ?>"><?php esc_html_e('Twitter', 'wp-event-manager'); ?></a>
														</div>
													<?php }

													if (!empty($dj_youtube)) { ?>
														<div class="wpem-social-icon wpem-youtube">
															<a href="<?php echo esc_url($dj_youtube); ?>" target="_blank" title="<?php esc_attr_e('Get Connect on Youtube', 'wp-event-manager'); ?>"><?php esc_html_e('Youtube', 'wp-event-manager'); ?></a>
														</div>
													<?php } ?>

													<?php do_action('single_event_listing_dj_single_social_end', $dj->ID); ?>
												</div>
											</div>
										<?php } 
									elseif ('dj_events' === $key) : 
										$dj_events = get_event_by_dj_id($dj->ID); ?>

										<div class="event-dj-count wpem-tooltip wpem-tooltip-bottom"><a href="javaScript:void(0)"><?php echo esc_attr(sizeof($dj_events)); ?></a>
											<?php if (!empty($dj_events)) : ?>
												<span class="dj-events-list wpem-tooltiptext">
													<?php foreach ($dj_events as $dj_event) : ?>
														<span><a href="<?php echo esc_url(get_the_permalink($dj_event->ID)); ?>"><?php echo esc_html(get_the_title($dj_event->ID)); ?></a></span>
													<?php endforeach; ?>
												</span>
											<?php else : ?>
												<span class="dj-events-list wpem-tooltiptext"><span><a href="#" onclick="return false;"><?php esc_html_e('There is no event.', 'wp-event-manager'); ?></a></span></span>
											<?php endif; ?>
										</div>

									<?php elseif ('dj_action' === $key) : ?>
										<div class="wpem-dboard-event-action">
											<?php
											$actions = array();
											switch ($dj->post_status) {
												case 'publish':
													$actions['edit'] = array(
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
											$actions = apply_filters('event_manager_my_dj_actions', $actions, $dj);
											foreach ($actions as $action => $value) {
												$action_url = add_query_arg(array(
													'action' => $action,
													'dj_id' => $dj->ID
												));
												if (sanitize_key($value['nonce'])) {
													$action_url = wp_nonce_url($action_url, 'event_manager_my_dj_actions');
												}
												echo wp_kses_post('<div class="wpem-dboard-event-act-btn"><a href="' . esc_url($action_url) . '" class="event-dashboard-action-' . esc_attr($action) . '" title="' . esc_html($value['label']) . '" >' . esc_html($value['label']) . '</a></div>');
											} ?>
										</div>

									<?php else : 
										do_action('event_manager_dj_dashboard_column_' . $key, $dj); ?>
									<?php endif; ?>
								</td>
							<?php endforeach; ?>
						</tr>
					<?php endforeach;
				endif; ?>
			</tbody>
		</table>
	</div>
	<?php get_event_manager_template('pagination.php', array('max_num_pages' => $max_num_pages)); ?>
<!-- dj list section end-->
</div>
<?php do_action('event_manager_dj_dashboard_after'); ?>