<?php

/*
 * Component Version: 1.0
 * Class Version: 1.0
 */
class Pronamic_WP_Sections_View
{
	/**
	 * Full root location to folder that holds this
	 * versions views
	 *
	 * @var string
	 */
	private $directory;

	/**
	 * The view name
	 *
	 * @var string
	 */
	private $view;

	/**
	 * All data for the view
	 * @var array
	 */
	private $data = array();

	/**
	 * The file extension
	 *
	 * @var string
	 */
	private $file_extension = '.php';

	public function __construct( $directory = null, $view = null ) {
		$this->directory = $directory;
		$this->view = $view;
	}

	/**
	 * Sets directory
	 * @param string | $directory | The full root location
	 */
	public function set_directory( $directory ) {
		$this->directory = $directory;
		return $this;
	}

	/**
	 * Gets the directory set
	 * @return string | The full root location
	 */
	public function get_directory() {
		return $this->directory;
	}

	/**
	 * Sets the view
	 * @param string | $view | The view file
	 */
	public function set_view( $view ) {
		$this->view = $view;
		return $this;
	}

	/**
	 * Gets the set view
	 * @return string | The set view file
	 */
	public function get_view() {
		return $this->view;
	}

	/**
	 * Sets file extension
	 * @param string | $file_extension | The extension including .
	 */
	public function set_file_extension( $file_extension ) {
		$this->file_extension = $file_extension;
		return $this;
	}

	/**
	 * Gets the set file extension
	 * @return string | The set extension
	 */
	public function get_file_extension() {
		return $this->file_extension;
	}

	/**
	 * Sets data for the view
	 * @param string | $variable | The name of the variable in the view
	 * @param string | $value	| The value of that variable
	 */
	public function set( $variable, $value ) {
		$this->data[ $variable ] = $value;
		return $this;
	}

	/**
	 * Loads the view to the browser
	 *
	 * @return void
	 */
	public function render() {
		// Checks class requirements and is valid file
		if ( ! $file = $this->determine_file() ) {
			return false;
		}

		// Determines if data to extract
		if ( ! empty( $this->data ) ) {
			extract( $this->data );
		}

		ob_start();

		include( $file );

		ob_get_contents();
	}

	/**
	 * Returns the view
	 *
	 * @return string | The view file
	 */
	public function retrieve() {
		// Check class requirements and is valid file
		if ( ! $file = $this->determine_file() ) {
			return false;
		}

		// Determines if data to extract
		if ( ! empty( $this->data ) ) {
			extract( $this->data );
		}

		ob_start();

		include( $file );

		$buffer = ob_get_contents();
		@ob_end_clean();

		return $buffer;
	}

	/**
	 * Determines the full file name, and if it exists
	 * @return string OR bool | The full file path or false
	 */
	private function determine_file() {
		// Check directory exists
		if ( empty( $this->directory ) ) {
			return false;
		}

		// Check view exists
		if ( empty( $this->view ) ) {
			return false;
		}

		// Get the file
		$file = $this->directory . '/' . $this->view . $this->file_extension;

		// Check file exists
		if ( file_exists( $file ) ) {
			return $file;
		} else {
			return false;
		}
	}
}
