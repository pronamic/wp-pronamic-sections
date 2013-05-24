<?php echo $nonce; ?>

<input type="hidden" name="pronamic_section_quantity" value="<?php echo $quantity; ?>" class="js-pronamic-sections-quantity"/>

<div class="pct-tabs-holder js-pronamic-sections-holder" style="padding-top:10px;padding-bottom:10px;">
	<?php for ( $i = 0; $i <= $quantity; $i ++  ) : ?>

		<?php $title   = ( isset( $tabs[ $i ][ 'title' ] ) ? $tabs[ $i ][ 'title' ] : '' ); ?>
		<?php $content = ( isset( $tabs[ $i ][ 'content' ] ) ? $tabs[ $i ][ 'content' ] : '' ); ?>
		<div class="pct-tab" style="margin-bottom:10px;border:1px solid #ccc;padding:10px;">
			<input type="hidden" name="pct_content[<?php echo $i; ?>][order]" value="<?php echo esc_attr( $i ); ?>" class="js-pronamic-sections-order"/>
			<div class="post-tab-title">
				<h3><?php _e( 'Section Title', 'pronamic-ct-domain' ); ?></h3> 
				<input type="text" name="pct_content[<?php echo esc_attr( $i ); ?>][title]" class="widefat" value="<?php echo esc_attr( $title ); ?>"/>
			</div>
			<div class="post-tab-content js-pronamic-sections-collapse">
				<?php wp_editor( $content, "pct_content_editor[{$i}]", array( 'textarea_name' => "pct_content[{$i}][content]" ) ); ?>
			</div>
			<br/>
			<a href="#" class="button button-secondary js-pronamic-section-delete" data-id="<?php echo esc_attr( $i ); ?>"><?php _e( 'Delete' ); ?></a>
		</div>

	<?php endfor; ?>
</div>

<a href="#" class="button button-primary js-pronamic-sections-add-tab"><?php _e( 'Add new section', 'pronamic-ct-domain' ); ?></a>