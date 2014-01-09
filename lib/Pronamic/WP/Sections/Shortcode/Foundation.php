<?php

class Pronamic_WP_Sections_Shortcode_Foundation extends Pronamic_WP_Sections_Shortcode_Shortcode {
	
	public function return_defaults() {
		return array(
			'type'      => '',
			'contained' => false,
			'classes'   => '',
		);
	}
	
	public function render() {
		// Get all sections
		$sections = $this->get_sections();
		
		?>
		<dl class="<?php echo $this->get_attribute( 'type' ); ?> tabs <?php echo $this->get_attribute( 'classes' ); ?> <?php if ( $this->is_attribute( 'contained' ) ) : ?>contained<?php endif; ?>">
			<?php foreach ( $sections as $section ) : ?>
				<dd <?php if ( 0 === $section->get_position() ) : ?>class="active"<?php endif; ?>><a href="<?php $section->the_slug(); ?>"><?php $section->the_title(); ?></a></dd>
			<?php endforeach; ?>
		</dl>
		<ul class="tabs-content">
			<?php foreach ( $sections as $section ) : ?>
			<li <?php if ( 0 === $section->get_position() ) : ?>class="active"<?php endif; ?> id="<?php $section->the_slug(); ?>Tab">
				<?php $section->the_content(); ?>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php
	}
}