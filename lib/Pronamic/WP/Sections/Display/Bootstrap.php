<?php

class Pronamic_WP_Sections_Display_Bootstrap extends Pronamic_WP_Sections_Display_Display {
	
	/**
	 * Holds all the classes to be used in the UL display of the bootstrap
	 * tabs.
	 * 
	 * @var array
	 */
	private $classes = array( 'nav' );
	
	public function __construct() {
		$id      = 'bootstrap';
		$name    = __( 'Bootstrap', 'pronamic-sections-domain' );
		$options = array(
			'description' => __( 'Style your sections to look like Bootstrap tabs', 'pronamic-sections-domain' )
		);
		
		parent::__construct( $id, $name, $options );
	}
	
	/**
	 * Sets the type of display that the bootstrap tabs should look like.
	 * Valid options are tabs and pills
	 * 
	 * @access public
	 * @param string $type
	 * @return void
	 */
	public function set_type( $type ) {
		$valid_types = array(
			'tabs',
			'pills'
		);
		
		if ( in_array( $type, $valid_types ) ) {
			$this->add_class( 'nav-' . $type );
		}
	}
	
	/**
	 * Adds another class to be used in the wrapping UL of the bootstrap
	 * tabs.
	 * 
	 * Can be passed an array and will merge with the existing classes.
	 * 
	 * @access public
	 * @param string|array $classes
	 * @return void
	 */
	public function add_class( $classes ) {
		if ( is_array( $classes ) ) {
			$this->classes + $classes;
		} else {
			$this->classes[] = $classes;
		}
	}
	
	/**
	 * Handles the display of the Bootstrap tabs.
	 * Will output the result straight away.
	 * 
	 * @access public
	 * @return void
	 */
	public function output() {
		
		// Get the sections for the display
		$sections = $this->get_sections();
		
		if ( empty( $sections ) )
			return;
		
		?>
		<ul class="<?php echo implode( ' ', $this->classes ); ?>">
			<?php foreach ( $sections as $section ) : ?>
			<li <?php if ( 0 === $section->get_position() ) : ?>class="active"<?php endif; ?>>
				<a data-toggle="tab" href="#<?php $section->the_slug(); ?>"><?php $section->the_title(); ?></a>
			</li>
			<?php endforeach; ?>
		</ul>
		<div class="tab-content">
			<?php foreach ( $sections as $section ) : ?>
			<div id="<?php $section->the_slug(); ?>" class="tab-pane <?php if ( 0 === $section->get_position() ) : ?>active<?php endif; ?>">
				<?php $section->the_content(); ?>
			</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
	
	public function save( $new_instance, $old_instance ) {
		
	}
	
	public function form( $instance ) {
		
	}
}