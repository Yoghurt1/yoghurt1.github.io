<?php

if ( ! class_exists( 'GFForms' ) ) {
	die();
}

/**
 * Add custom options for workflow_detail_link fields
 *
 * @copyright   Copyright (c) 2015-2017, Steven Henty S.L.
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class Gravity_Flow_GravityView_Workflow_Detail_Link extends GravityView_Field {

	var $name = 'workflow_detail_link';

	var $contexts = array( 'multiple' );

	var $is_sortable = false;

	var $is_searchable = false;

	var $group = 'meta';

	public function __construct() {
		$this->label = esc_html__( 'Link to Workflow Entry Detail', 'gravityflow' );

		$this->add_hooks();

		parent::__construct();
	}

	/**
	 * Adds hooks for GravityView.
	 *
	 * @since 1.5.1-dev
	 *
	 */
	private function add_hooks() {
		add_filter( 'gravityview_entry_default_fields', array( $this, 'add_entry_default_field' ), 10, 3 );
		add_filter( 'gravityview_field_entry_value_workflow_detail_link', array( $this, 'modify_entry_value_workflow_detail_link' ), 10, 4 );
	}

	/**
	 * Add Entry Notes to the Add Field picker in Edit View
	 *
	 * @see GravityView_Admin_Views::get_entry_default_fields()
	 *
	 * @since 1.17
	 *
	 * @param array $entry_default_fields Fields configured to show in the picker
	 * @param array $form Gravity Forms form array
	 * @param string $zone Current context: `directory`, `single`, `edit`
	 *
	 * @return array Fields array with notes added, if in Multiple Entries or Single Entry context
	 */
	public function add_entry_default_field( $entry_default_fields, $form, $zone ) {

		if ( in_array( $zone, array( 'directory', 'single' ) ) ) {
			$entry_default_fields['workflow_detail_link'] = array(
				'label' => __( 'Workflow Detail Link', 'gravityflow' ),
				'type'  => $this->name,
				'desc'  => __( 'Display a link to the workflow detail page.', 'gravityflow' ),
			);
		}

		return $entry_default_fields;
	}

	/**
	 * Generate the workflow detail link.
	 *
	 * @param string $output HTML value output
	 * @param array  $entry The GF entry array
	 * @param  array $field_settings Settings for the particular GV field
	 * @param array $field Current field being displayed
	 *
	 * @since 1.5.1-dev
	 *
	 * @return string
	 */
	function modify_entry_value_workflow_detail_link( $output, $entry, $field_settings, $field ) {

		$query_args = array(
			'page' => 'gravityflow-inbox',
			'view' => 'entry',
			'id'   => absint( $entry['form_id'] ),
			'lid'  => absint( $entry['id'] ),
		);

		$page_id = gravity_flow()->get_app_setting( 'inbox_page' );

		if ( empty( $page_id ) ) {
			$page_id = 'admin';
		}

		$url = Gravity_Flow_Common::get_workflow_url( $query_args, $page_id );

		$text = $field_settings['workflow_detail_link_text'];

		$output = sprintf( '<a href="%s">%s</a>', $url, $text );

		return $output;
	}

	/**
	 * Adds the link text field option.
	 *
	 * @param array $field_options
	 * @param string $template_id
	 * @param string $field_id
	 * @param string $context
	 * @param string $input_type
	 *
	 * @return array
	 */
	function field_options( $field_options, $template_id, $field_id, $context, $input_type ) {

		// Always a link!
		unset( $field_options['show_as_link'], $field_options['search_filter'] );

		if ( 'edit' === $context ) {
			return $field_options;
		}

		$add_options = array();
		$add_options['workflow_detail_link_text'] = array(
			'type' => 'text',
			'label' => __( 'Link Text:', 'gravityflow' ),
			'desc' => null,
			'value' => __( 'View Details', 'gravityflow' ),
			'merge_tags' => true,
		);

		return $add_options + $field_options;
	}
}

new Gravity_Flow_GravityView_Workflow_Detail_Link;
