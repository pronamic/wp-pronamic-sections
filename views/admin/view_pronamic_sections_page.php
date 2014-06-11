<div class="wrap">
	<h2><i style="margin-top:4px;" class="dashicons dashicons-list-view"></i> <?php echo get_admin_page_title(); ?></h2>
	<h2 class="nav-tab-wrapper">
		<a href="<?php echo add_query_arg( array( 'group' => 'pronamic-sections-general' ) ); ?>" class="nav-tab <?php if ( 'pronamic-sections-general' === $section ) : ?>nav-tab-active<?php endif; ?>"><i class="dashicons dashicons-admin-tools"></i> <?php _e( 'General', 'pronamic-sections-domain' ); ?></a>
		<a href="<?php echo add_query_arg( array( 'group' => 'pronamic-sections-look' ) ); ?>" class="nav-tab <?php if ( 'pronamic-sections-look' === $section ) : ?>nav-tab-active<?php endif; ?>"><i class="dashicons dashicons-art"></i> <?php _e( 'Look and feel', 'pronamic-sections-domain' ); ?></a>
		<a href="<?php echo add_query_arg( array( 'group' => 'pronamic-sections-examples' ) ); ?>" class="nav-tab <?php if ( 'pronamic-sections-examples' === $section ) : ?>nav-tab-active<?php endif; ?>"><i class="dashicons dashicons-screenoptions"></i> <?php _e( 'Examples', 'pronamic-sections-domain' ); ?></a>
	</h2>

	<!-- Settings Form -->
	<form action="options.php" method="POST">
		<?php if ( 'pronamic-sections-examples' === $section ) : ?>
			<?php include 'partials/pronamic-sections-examples.php'; ?>
		<?php else : ?>
			<?php settings_fields( $section ); ?>
			<table class="form-table">
				<?php do_settings_fields( 'pronamic-sections', $section ); ?>
			</table>
			<?php submit_button( __( 'Save settings', 'pronamic-sections-domain' ) ); ?>
		<?php endif; ?>
	</form>
	<!-- // Settings Form -->
</div>

