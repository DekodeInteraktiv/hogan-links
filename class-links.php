<?php
/**
 * Links module class.
 *
 * @package Hogan
 */

declare( strict_types = 1 );
namespace Dekode\Hogan;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( '\\Dekode\\Hogan\\Links' ) && class_exists( '\\Dekode\\Hogan\\Module' ) ) {

	/**
	 * Links module class.
	 *
	 * @extends Modules base class.
	 */
	class Links extends Module {

		/**
		 * List of links
		 *
		 * @var array $list
		 */
		public $list;

		/**
		 * Module constructor.
		 */
		public function __construct() {

			$this->label             = __( 'Links', 'hogan-links' );
			$this->template          = __DIR__ . '/assets/template.php';
			$this->inner_wrapper_tag = 'nav';

			add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_assets' ] );

			parent::__construct();
		}

		/**
		 * Enqueue module admin assets
		 *
		 * @return void
		 */
		public function enqueue_admin_assets() {
			$_version = defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ? time() : false;
			wp_enqueue_style( 'links-admin-style', plugins_url( '/assets/admin-style.css', __FILE__ ), [], $_version );
		}

		/**
		 * Field definitions for module.
		 *
		 * @return array $fields Fields for this module
		 */
		public function get_fields() : array {

			$fields = [
				[
					'key'          => $this->field_key . '_flex',
					'label'        => '',
					'name'         => 'list_flex',
					'type'         => 'flexible_content',
					'button_label' => esc_html__( 'Add links', 'hogan-links' ),
					'wrapper'      => [
						'class' => 'links-layouts',
					],
					'layouts'      => [
						[
							'key'        => $this->field_key . '_flex_manual',
							'name'       => 'manual',
							'label'      => esc_html__( 'Manual', 'hogan-links' ),
							'display'    => 'block',
							'sub_fields' => [
								[
									'key'          => $this->field_key . '_manual_list',
									'label'        => 'Lenker',
									'name'         => 'manual_list',
									'type'         => 'repeater',
									'min'          => 1,
									'layout'       => 'block',
									'button_label' => esc_html__( 'Add another link', 'hogan-links' ),
									'min'          => 1,
									'sub_fields'   => [
										[
											'key'      => $this->field_key . '_manual_link',
											'label'    => esc_html__( 'Select link and set text', 'hogan-links' ),
											'name'     => 'link',
											'type'     => 'link',
											'required' => 1,
											'return_format' => 'array',
											'wrapper'  => [
												'width' => '50',
											],
										],
										[
											'key'     => $this->field_key . '_manual_link_description',
											'label'   => esc_html__( 'Short description', 'hogan-links' ),
											'name'    => 'link_description',
											'type'    => 'text',
											'wrapper' => [
												'width' => '50',
											],
										],
									],
								],
							],
						],
						[
							'key'        => $this->field_key . '_flex_predefined',
							'name'       => 'predefined',
							'label'      => esc_html__( 'Predefined menu', 'hogan-links' ),
							'display'    => 'block',
							'sub_fields' => [
								[
									'key'           => $this->field_key . '_flex_predefined_list',
									'label'         => esc_html__( 'Select predefined menu', 'hogan-links' ),
									'name'          => 'predefined_links',
									'type'          => 'select',
									'allow_null'    => 1,
									// Translators: %s: Url to navigation menu page.
									'instructions'  => sprintf( __( 'A predefined menu must be created <a href="%s">here</a> in order to show up in this dropdown.', 'hogan-links' ), admin_url() . 'nav-menus.php' ),
									'choices'       => [],
									'ui'            => 1,
									'ajax'          => 1,
									'return_format' => 'value',
									'placeholder'   => esc_html__( 'Select', 'hogan-links' ),
									'required'      => 1,
								],
							],
						],
					],
				],
			];

			return $fields;
		}

		/**
		 * Map raw fields from acf to object variable.
		 *
		 * @param array $raw_content Content values.
		 * @param int   $counter Module location in page layout.
		 * @return void
		 */
		public function load_args_from_layout_content( array $raw_content, int $counter = 0 ) {

			$this->list = $this->get_list_items( $raw_content['list_flex'] );

			parent::load_args_from_layout_content( $raw_content, $counter );
		}

		/**
		 * Validate module content before template is loaded.
		 *
		 * @return bool Whether validation of the module is successful / filled with content.
		 */
		public function validate_args() : bool {
			return ! empty( $this->list );
		}

		/**
		 * Get list items.
		 *
		 * @param array $raw_list The list.
		 * @return array Two dimensional array with keys href, target, title and description.
		 */
		public function get_list_items( array $raw_list ) : array {

			if ( ! is_array( $raw_list ) ) {
				return '';
			}

			$items = [];
			foreach ( $raw_list as $list ) {

				switch ( $list['acf_fc_layout'] ) {

					case 'predefined':
						$menu = $list['predefined_links'];
						foreach ( wp_get_nav_menu_items( $menu ) as $link ) {
							$items[] = [
								'href'        => $link->url,
								'target'      => $link->target,
								'title'       => $link->title,
								'description' => $link->description,
							];
						}
						break;
					case 'manual':
						foreach ( $list['manual_list'] as $item ) {

							if ( empty( $item['link']['url'] ) ) {
								break;
							}

							$items[] = [
								'href'        => $item['link']['url'],
								'target'      => $item['link']['target'],
								'title'       => hogan_get_link_title( $item['link'] ),
								'description' => $item['link_description'],
							];
						}
						break;
					default:
						break;
				}
			}
			return $items;
		}
	}
}
