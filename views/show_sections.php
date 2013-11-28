<div class="pronamic_sections_add_holder">
	<div class="jPronamicSectionAddNotice"></div>
	<input type="text" class="jPronamicSectionNewTitle">
	<a class="button button-primary jPronamicSectionNewButton" data-notice-holder=".jPronamicSectionAddNotice" data-post-id="<?php echo $post_id; ?>"><?php _e( 'Add Section', 'pronamic-sections-domain' ); ?></a>
</div>
<?php if ( ! empty( $sections ) ) : ?>
	<?php foreach ( $sections as $section ) : ?>
		<div class="pronamic_sections_editor_holder postbox">
			<div class="pronamic_sections_handle handlediv" title="<?php _e( 'Click to toggle' ); ?>"><br></div>
			<h3 class="pronamic_sections_title hndle">
				<?php _e( 'Section', 'pronamic-sections-domain' ); ?> 
				<input class="jPronamicSectionName pronamic_section_name" type="text" name="pronamic_sections[<?php echo $section->ID; ?>][post_title]" value="<?php echo $section->post_title; ?>" />
			</h3>
			<div class="inside">
				<?php 
				
				// Get the section entity
				$section_class = new Pronamic_Sections_Section( $section ); 
				
				$position = $section_class->get_position();
				
				?>
				<div class="pronamic_section_holder" data-id="<?php echo $section->ID; ?>" data-position="<?php echo $position; ?>">
					<?php 
					
					wp_editor( $section->post_content, 'pronamic_section_editor_' . $section->ID, array(
						'textarea_name' => "pronamic_sections[{$section->ID}][post_content]",
						'editor_class'  => 'pronamic_section_editor',
						'editor_height' => '100'
					) ); 
					
					?>
				</div>
				<div class="pronamic_section_buttons">
					<input type="hidden" name="pronamic_sections[<?php echo $section->ID; ?>][position]" value="<?php echo $position; ?>"/>
					<span class="jPronamicSectionExistingMoveUp pronamic_section_move_up_button" data-position="<?php echo $position; ?>" data-post-id="<?php echo $post_id; ?>" data-current-id="<?php echo $section->ID; ?>"><?php _e( 'Up', 'pronamic-sections-domain' ); ?></span>
					<span class="jPronamicSectionExistingMoveDown pronamic_section_move_down_button" data-position="<?php echo $section_class->get_position(); ?>" data-post-id="<?php echo $post_id; ?>" data-current-id="<?php echo $section->ID; ?>"><?php _e( 'Down', 'pronamic-sections-domain' ); ?></span>
					<span class="jPronamicSectionExistingRemove pronamic_section_remove_button" data-post-id="<?php echo $post_id; ?>" data-current-id="<?php echo $section->ID; ?>"><?php _e( 'Remove', 'pronamic-sections-domain' ); ?></span>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
<?php endif; ?>