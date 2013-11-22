<div class="pronamic_sections_order_holder">
	<div class="pronamic_sections_order_existing_holder">
		<?php if ( ! empty( $sections ) ) : ?>
			<ul class="pronamic_sections_order_existing_list">
				<?php foreach ( $sections as $section ) : ?>
					<?php $section_class = new Pronamic_Sections_Section( $section ); ?>
					<li>
						<?php echo $section->post_title; ?> 
						<?php echo $section_class->get_position(); ?>
						<div class="pronamic_section_buttons">
							<span class="jPronamicSectionExistingMoveUp pronamic_section_move_up_button" data-position="<?php echo $section_class->get_position(); ?>" data-post-id="<?php echo $post_id; ?>" data-current-id="<?php echo $section->ID; ?>"><?php _e( 'Up', 'pronamic-sections-domain' ); ?></span>
							<span class="jPronamicSectionExistingMoveDown pronamic_section_move_down_button" data-position="<?php echo $section_class->get_position(); ?>" data-post-id="<?php echo $post_id; ?>" data-current-id="<?php echo $section->ID; ?>"><?php _e( 'Down', 'pronamic-sections-domain' ); ?></span>
							<span class="jPronamicSectionExistingRemove pronamic_section_remove_button" data-post-id="<?php echo $post_id; ?>" data-current-id="<?php echo $section->ID; ?>"><?php _e( 'Remove', 'pronamic-sections-domain' ); ?></span>
						</div>
					</li>
					<?php if ( 'Second Section' === $section->post_title ) : ?>
						<?php //$section_class->move_up( Pronamic_Sections_SectionFactory::get_above_section( $post_id, $section_class->get_position() ) ); ?>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
	<div class="pronamic_sections_order_add">
		<input type="text" class="jPronamicSectionNewTitle">
		<a class="button button-primary jPronamicSectionNewButton" data-post-id="<?php echo $post_id; ?>"><?php _e( 'Add Section', 'pronamic-sections-domain' ); ?></a>
	</div>
</div>