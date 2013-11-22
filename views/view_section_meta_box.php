<div class="pronamic_sections_order_holder">
	<div class="pronamic_sections_order_existing_holder">
		<?php if ( ! empty( $sections ) ) : ?>
			<ul class="pronamic_sections_order_existing_list">
				<?php foreach ( $sections as $section ) : ?>
					<li>
						<?php echo $section->post_title; ?> 
						
						<span class="jPronamicSectionExistingMoveUp pronamic_section_move_up_button"><?php _e( 'Up', 'pronamic-sections-domain' ); ?></span>
						<span class="jPronamicSectionExistingMoveDown pronamic_section_move_down_button"><?php _e( 'Down', 'pronamic-sections-domain' ); ?></span>
						<span class="jPronamicSectionExistingRemove pronamic_section_remove_button"><?php _e( 'Remove', 'pronamic-sections-domain' ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
	<div class="pronamic_sections_order_add">
		<input type="text" class="jPronamicSectionNewTitle">
		<a class="button button-primary jPronamicSectionNewButton" data-post-id="<?php echo $post_id; ?>"><?php _e( 'Add Section', 'pronamic-sections-domain' ); ?></a>
	</div>
</div>