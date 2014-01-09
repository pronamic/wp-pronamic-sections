<?php

class Pronamic_WP_Sections_Shortcode_Bootstrap extends Pronamic_WP_Sections_Shortcode_Shortcode {
	
	/**
	 * {@inheritdoc}
	 */
	public function return_defaults() {
		return array(
			'type'      => 'tabs',
			'stacked'   => false,
			'justified' => false,
		);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function render() {
		// Get all sections
		$sections = $this->get_sections();
		
		?>
		<ul class="nav nav-<?php echo $this->get_attribute( 'type' ); ?> <?php if ( $this->is_attribute( 'stacked' ) ) : ?>nav-stacked<?php endif; ?><?php if ( $this->is_attribute( 'justified' ) ) : ?>nav-justified<?php endif; ?>">
			<?php foreach ( $sections as $section ) : ?>
				<li <?php if ( 0 == $section->get_position() ) : ?>class="active"<?php endif; ?>>
					<a data-toggle="tab" href="#<?php $section->the_slug(); ?>"><?php $section->the_title(); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
		<div class="tab-content">
			<?php foreach ( $sections as $section ) : ?>
				<div id="<?php $section->the_slug(); ?>" class="tab-pane <?php if ( 0 == $section->get_position() ): ?>active<?php endif; ?>">
					<?php $section->the_content(); ?>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
}