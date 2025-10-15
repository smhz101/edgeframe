<?php
/**
 * Settings registration and rendering
 *
 * @package Edgeframe
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load schema
require_once EDGEFRAME_PATH . 'inc/admin/settings-schema.php';

add_action( 'admin_init', 'edgeframe_register_settings' );
/**
 * Register settings, sections, and fields
 */
function edgeframe_register_settings() {
	register_setting(
		'edgeframe_group',
		'edgeframe_settings',
		array(
			'type'              => 'array',
			'sanitize_callback' => 'edgeframe_sanitize_settings_from_schema',
			'default'           => edgeframe_defaults_from_schema(),
		)
	);

	$schema = edgeframe_get_settings_schema();

	foreach ( $schema as $tab_key => $tab ) {
		if ( empty( $tab['sections'] ) || ! is_array( $tab['sections'] ) ) {
			continue; }

		foreach ( $tab['sections'] as $section_key => $section ) {
			$section_id = "edgeframe_{$tab_key}_{$section_key}";

			add_settings_section(
				$section_id,
				isset( $section['label'] ) ? wp_kses_post( $section['label'] ) : '',
				'__return_false',
				'edgeframe-settings'
			);

			if ( empty( $section['fields'] ) || ! is_array( $section['fields'] ) ) {
				continue; }

			foreach ( $section['fields'] as $field_key => $field ) {
				$field_id = "edgeframe_{$tab_key}_{$section_key}_{$field_key}";
				// Build label with optional tooltip
				$label_text = isset( $field['label'] ) ? (string) $field['label'] : (string) $field_key;
				$tooltip    = isset( $field['tooltip'] ) ? (string) $field['tooltip'] : ( isset( $field['desc'] ) ? (string) $field['desc'] : '' );
				$title_html = esc_html( $label_text );
				if ( $tooltip ) {
					$title_html .= ' <span class="ef-tip" tabindex="0" aria-label="' . esc_attr( wp_strip_all_tags( $tooltip ) ) . '" data-tip="' . esc_attr( wp_strip_all_tags( $tooltip ) ) . '">?</span>';
				}
				add_settings_field(
					$field_id,
					$title_html,
					'edgeframe_render_generic_field',
					'edgeframe-settings',
					$section_id,
					array(
						'tab'       => $tab_key,
						'section'   => $section_key,
						'field_key' => $field_key,
						'field'     => $field,
					)
				);
			}
		}
	}
}

/**
 * Get default values from schema
 */
function edgeframe_defaults_from_schema() {
	$schema   = edgeframe_get_settings_schema();
	$defaults = array();
	foreach ( $schema as $tab ) {
		foreach ( ( $tab['sections'] ?? array() ) as $section ) {
			foreach ( ( $section['fields'] ?? array() ) as $key => $def ) {
				$defaults[ $key ] = $def['default'] ?? '';
			}
		}
	}
	return $defaults;
}

/**
 * Sanitize settings input based on schema
 */
function edgeframe_sanitize_settings_from_schema( $input ) {
	$schema   = edgeframe_get_settings_schema();
	$clean    = array();
	$defaults = edgeframe_defaults_from_schema();

	foreach ( $schema as $tab ) {
		foreach ( ( $tab['sections'] ?? array() ) as $section ) {
			foreach ( ( $section['fields'] ?? array() ) as $key => $def ) {
				$raw  = $input[ $key ] ?? ( $defaults[ $key ] ?? null );
				$type = $def['type'] ?? 'text';
				$cb   = $def['sanitize_cb'] ?? edgeframe_sanitizer_for_type( $type );
				if ( in_array( $type, array( 'group', 'repeater', 'repeater_group' ), true ) ) {
					$clean[ $key ] = is_callable( $cb ) ? call_user_func( $cb, $raw, $def ) : $raw;
				} else {
					$clean[ $key ] = is_callable( $cb ) ? call_user_func( $cb, $raw ) : $raw;
				}
			}
		}
	}
	return $clean;
}

/**
 * Get sanitizer callback based on field type
 */
function edgeframe_sanitizer_for_type( string $type ) {
	switch ( $type ) {
		case 'toggle':
			return 'rest_sanitize_boolean';
		case 'number':
			return 'edgeframe_sanitize_number';
		case 'color':
			return 'sanitize_hex_color';
		case 'color_palette':
			return 'edgeframe_sanitize_color_palette';
		case 'date':
			return 'edgeframe_sanitize_date';
		case 'time':
			return 'edgeframe_sanitize_time';
		case 'textarea':
			return 'wp_kses_post';
		case 'select':
			return 'edgeframe_sanitize_text';
		case 'radio_image':
			return 'edgeframe_sanitize_text';
		case 'media':
			return 'absint';
		case 'group':
			return 'edgeframe_sanitize_group';
		case 'repeater':
		case 'repeater_group':
			return 'edgeframe_sanitize_repeater';
		case 'text':
		default:
			return 'edgeframe_sanitize_text';
	}
}

/**
 * Basic sanitizers
 */
function edgeframe_sanitize_number( $v ) {
	return is_numeric( $v ) ? 0 + $v : 0;
}

/**
 * Text sanitizer
 */
function edgeframe_sanitize_text( $v ) {
	return sanitize_text_field( (string) $v );
}

/**
 * Sanitize a color palette selection (hex color only)
 */
function edgeframe_sanitize_color_palette( $v ) {
	$hex = sanitize_hex_color( (string) $v );
	return $hex ? $hex : '';
}

/**
 * Sanitize a date value (YYYY-MM-DD)
 */
function edgeframe_sanitize_date( $v ) {
	$v = (string) $v;
	if ( preg_match( '/^\d{4}-\d{2}-\d{2}$/', $v ) ) {
		list( $y, $m, $d ) = array_map( 'intval', explode( '-', $v ) );
		if ( checkdate( $m, $d, $y ) ) {
			return sprintf( '%04d-%02d-%02d', $y, $m, $d );
		}
	}
	return '';
}

/**
 * Sanitize a time value (HH:MM 24-hour)
 */
function edgeframe_sanitize_time( $v ) {
	$v = (string) $v;
	if ( preg_match( '/^(?:([01]\d|2[0-3])):([0-5]\d)$/', $v, $m ) ) {
		return sprintf( '%02d:%02d', (int) $m[1], (int) $m[2] );
	}
	return '';
}

/**
 * Sanitize group field based on subfields schema.
 */
function edgeframe_sanitize_group( $raw, $field_def ) {
	$raw   = is_array( $raw ) ? $raw : array();
	$clean = array();
	$subs  = $field_def['fields'] ?? array();
	foreach ( $subs as $sub_key => $sub_def ) {
		$cb                = edgeframe_sanitizer_for_type( $sub_def['type'] ?? 'text' );
		$val               = $raw[ $sub_key ] ?? ( $sub_def['default'] ?? '' );
		$clean[ $sub_key ] = is_callable( $cb ) ? call_user_func( $cb, $val, $sub_def ) : $val;
	}
	return $clean;
}

/**
 * Sanitize repeater (array of items or array of groups)
 */
function edgeframe_sanitize_repeater( $raw, $field_def ) {
	$raw      = is_array( $raw ) ? array_values( $raw ) : array();
	$item_def = $field_def['item'] ?? array( 'type' => 'text' );
	$max      = isset( $field_def['max'] ) ? (int) $field_def['max'] : 0;
	$out      = array();
	foreach ( $raw as $i => $val ) {
		if ( ( $max > 0 ) && ( count( $out ) >= $max ) ) {
			break; }
		$cb    = edgeframe_sanitizer_for_type( $item_def['type'] ?? 'text' );
		$out[] = is_callable( $cb ) ? call_user_func( $cb, $val, $item_def ) : $val;
	}
	return $out;
}

/**
 * Generic field renderer based on schema
 */
function edgeframe_render_generic_field( array $args ) {
	$opts      = get_option( 'edgeframe_settings', array() );
	$key       = $args['field_key'];
	$field     = $args['field'];
	$type      = $field['type'] ?? 'text';
	$value     = $opts[ $key ] ?? ( $field['default'] ?? '' );
	$attrs     = $field['attrs'] ?? array();
	$desc      = $field['desc'] ?? '';
	$name_attr = 'edgeframe_settings[' . esc_attr( $key ) . ']';

	// Conditional visibility support: wrap field in a container with data-show-if
	$container_attrs = array(
		'class'      => 'ef-field',
		'data-field' => $key,
	);
	if ( ! empty( $field['show_if'] ) && is_array( $field['show_if'] ) ) {
		$container_attrs['data-show-if'] = wp_json_encode( $field['show_if'] );
	}
	echo '<div ' . edgeframe_html_attrs( $container_attrs ) . '>';

	switch ( $type ) {
		case 'toggle':
			// Pretty toggle (checkbox wrapped by JS). Keep pure markup here.
			echo '<div class="ef-field-toggle">';
			printf(
				'<input type="checkbox" name="%1$s" value="1" %2$s %3$s />',
				$name_attr,
				checked( ! empty( $value ), true, false ),
				edgeframe_html_attrs( $attrs )
			);
			echo '</div>';
			break;

		case 'radio_image':
			$opts = $field['options'] ?? array();
			echo '<div class="ef-radio-image-group">';
			foreach ( $opts as $opt_val => $opt_label ) {
				$label = is_array( $opt_label ) ? ( $opt_label['label'] ?? (string) $opt_val ) : (string) $opt_label;
				$img   = is_array( $opt_label ) ? ( $opt_label['image'] ?? '' ) : '';
				$id    = esc_attr( $key . '_' . $opt_val );
				echo '<label class="ef-radio-image' . ( (string) $value === (string) $opt_val ? ' is-checked' : '' ) . '" for="' . $id . '">';
				printf( '<input type="radio" id="%1$s" name="%2$s" value="%3$s" %4$s />', $id, $name_attr, esc_attr( (string) $opt_val ), checked( (string) $value, (string) $opt_val, false ) );
				if ( $img ) {
					echo '<span class="ef-ri-thumb"><img alt="" src="' . esc_url( $img ) . '" /></span>';
				} else {
					echo '<span class="ef-ri-thumb ef-ri-thumb--label">' . esc_html( $label ) . '</span>';
				}
				echo '<span class="ef-ri-check" aria-hidden="true"></span>';
				echo '</label>';
			}
			echo '</div>';
			break;

		case 'group':
			$sub_fields = $field['fields'] ?? array();
			$vals       = is_array( $value ) ? $value : array();
			echo '<div class="ef-group">';
			echo '<table class="ef-form-table form-table"><tbody>';
			foreach ( $sub_fields as $sk => $sdef ) {
				$sub_label = isset( $sdef['label'] ) ? (string) $sdef['label'] : (string) $sk;
				$sub_tip   = isset( $sdef['tooltip'] ) ? (string) $sdef['tooltip'] : ( $sdef['desc'] ?? '' );
				$sub_name  = $name_attr . '[' . esc_attr( $sk ) . ']';
				$sub_val   = $vals[ $sk ] ?? ( $sdef['default'] ?? '' );
				$tr_attrs  = array();
				if ( ! empty( $sdef['show_if'] ) && is_array( $sdef['show_if'] ) ) {
					$tr_attrs['data-show-if'] = wp_json_encode( $sdef['show_if'] );
					$tr_attrs['class']        = 'ef-conditional';
				}
				echo '<tr ' . edgeframe_html_attrs( $tr_attrs ) . '>';
				echo '<th><label>' . esc_html( $sub_label ) . ( $sub_tip ? ' <span class="ef-tip" tabindex="0" aria-label="' . esc_attr( wp_strip_all_tags( $sub_tip ) ) . '" data-tip="' . esc_attr( wp_strip_all_tags( $sub_tip ) ) . '">?</span>' : '' ) . '</label></th>';
				echo '<td>';
				// Render subfield simply based on type (subset supported here)
				$stype = $sdef['type'] ?? 'text';
				switch ( $stype ) {
					case 'number':
						printf( '<input type="number" name="%1$s" value="%2$s" %3$s />', $sub_name, esc_attr( (string) $sub_val ), edgeframe_html_attrs( $sdef['attrs'] ?? array() ) );
						break;
					case 'color':
						printf( '<input type="text" class="ef-color" name="%1$s" value="%2$s" %3$s />', $sub_name, esc_attr( (string) $sub_val ), edgeframe_html_attrs( $sdef['attrs'] ?? array() ) );
						break;
					case 'color_palette':
						$pal = $sdef['palette'] ?? array( '#111827', '#6b7280', '#4f46e5', '#10b981', '#ef4444', '#f59e0b' );
						echo '<div class="ef-color-palette" role="radiogroup">';
						foreach ( $pal as $pi => $phex ) {
							$phex    = (string) $phex;
							$pid     = esc_attr( $sk . '_pal_' . $pi );
							$checked = ( strtolower( (string) $sub_val ) === strtolower( $phex ) );
							echo '<label class="ef-color-swatch" style="--swatch:' . esc_attr( $phex ) . '">';
							printf( '<input type="radio" id="%1$s" name="%2$s" value="%3$s" %4$s />', $pid, $sub_name, esc_attr( $phex ), checked( $checked, true, false ) );
							echo '<span class="ef-color-swatch__chip" aria-hidden="true"></span>';
							echo '<span class="screen-reader-text">' . esc_html( $phex ) . '</span>';
							echo '</label>';
						}
						echo '</div>';
						break;
					case 'textarea':
						printf( '<textarea class="large-text" rows="4" name="%1$s" %3$s>%2$s</textarea>', $sub_name, esc_textarea( (string) $sub_val ), edgeframe_html_attrs( $sdef['attrs'] ?? array() ) );
						break;
					case 'select':
						echo '<select name="' . esc_attr( $sub_name ) . '" ' . edgeframe_html_attrs( $sdef['attrs'] ?? array() ) . '>';
						foreach ( ( $sdef['options'] ?? array() ) as $ov => $ol ) {
							printf( '<option value="%1$s" %2$s>%3$s</option>', esc_attr( (string) $ov ), selected( (string) $sub_val, (string) $ov, false ), esc_html( is_array( $ol ) ? ( $ol['label'] ?? (string) $ov ) : (string) $ol ) );
						}
						echo '</select>';
						break;
					case 'toggle':
						printf( '<label class="ef-toggle"><input type="checkbox" name="%1$s" value="1" %2$s %3$s /><span class="track"></span><span class="thumb"></span></label>', $sub_name, checked( ! empty( $sub_val ), true, false ), edgeframe_html_attrs( $sdef['attrs'] ?? array() ) );
						break;
					case 'date':
						printf( '<input type="date" name="%1$s" value="%2$s" %3$s />', $sub_name, esc_attr( (string) $sub_val ), edgeframe_html_attrs( $sdef['attrs'] ?? array() ) );
						break;
					case 'time':
						printf( '<input type="time" name="%1$s" value="%2$s" %3$s />', $sub_name, esc_attr( (string) $sub_val ), edgeframe_html_attrs( $sdef['attrs'] ?? array() ) );
						break;
					default:
						printf( '<input type="text" class="regular-text" name="%1$s" value="%2$s" %3$s />', $sub_name, esc_attr( (string) $sub_val ), edgeframe_html_attrs( $sdef['attrs'] ?? array() ) );
				}

				if ( ! empty( $sdef['desc'] ) ) {
					echo '<p class="description">' . wp_kses_post( $sdef['desc'] ) . '</p>';
				}
				echo '</td></tr>';
			}
			echo '</tbody></table>';
			echo '</div>';
			break;

		case 'repeater':
			$item_def = $field['item'] ?? array( 'type' => 'text' );
			$vals     = is_array( $value ) ? array_values( $value ) : array();
			$max      = isset( $field['max'] ) ? (int) $field['max'] : 0;
			$min      = isset( $field['min'] ) ? (int) $field['min'] : 0;
			echo '<div class="ef-repeater" data-name="' . esc_attr( $name_attr ) . '" data-max="' . esc_attr( (string) $max ) . '" data-min="' . esc_attr( (string) $min ) . '">';
			echo '<div class="ef-repeater-items">';
			$index = 0;
			foreach ( $vals as $idx => $ival ) {
				echo edgeframe_render_repeater_item( $name_attr, $item_def, $ival, $index );
				++$index;
			}
			echo '</div>';
			echo '<button type="button" class="button ef-repeater-add">' . esc_html__( 'Add Item', 'edgeframe' ) . '</button>';
			// Template
			$template_html = edgeframe_render_repeater_item( $name_attr, $item_def, ( $item_def['type'] ?? '' ) === 'group' ? array() : '', '__i__' );
			echo '<script type="text/template" class="ef-repeater-tpl">' . $template_html . '</script>';
			echo '</div>';
			break;

		case 'color':
			printf(
				'<input type="text" class="ef-color regular-text" name="%1$s" value="%2$s" %3$s />',
				$name_attr,
				esc_attr( $value ),
				edgeframe_html_attrs( $attrs )
			);
			break;

		case 'color_palette':
			$palette = $field['palette'] ?? array( '#111827', '#6b7280', '#4f46e5', '#10b981', '#ef4444', '#f59e0b' );
			$cur     = (string) $value;
			echo '<div class="ef-color-palette" role="radiogroup">';
			foreach ( $palette as $i => $hex ) {
				$hex     = (string) $hex;
				$id      = esc_attr( $key . '_pal_' . $i );
				$checked = ( strtolower( $cur ) === strtolower( $hex ) );
				echo '<label class="ef-color-swatch" style="--swatch:' . esc_attr( $hex ) . '">';
				printf( '<input type="radio" id="%1$s" name="%2$s" value="%3$s" %4$s />', $id, $name_attr, esc_attr( $hex ), checked( $checked, true, false ) );
				echo '<span class="ef-color-swatch__chip" aria-hidden="true"></span>';
				echo '<span class="screen-reader-text">' . esc_html( $hex ) . '</span>';
				echo '</label>';
			}
			echo '</div>';
			break;

		case 'date':
			printf( '<input type="date" name="%1$s" value="%2$s" %3$s />', $name_attr, esc_attr( (string) $value ), edgeframe_html_attrs( $attrs ) );
			break;

		case 'time':
			printf( '<input type="time" name="%1$s" value="%2$s" %3$s />', $name_attr, esc_attr( (string) $value ), edgeframe_html_attrs( $attrs ) );
			break;

		case 'textarea':
			printf(
				'<textarea class="large-text" rows="5" name="%1$s" %3$s>%2$s</textarea>',
				$name_attr,
				esc_textarea( (string) $value ),
				edgeframe_html_attrs( $attrs )
			);
			break;

		case 'select':
			echo '<select name="' . esc_attr( $name_attr ) . '" ' . edgeframe_html_attrs( $attrs ) . '>';
			foreach ( ( $field['options'] ?? array() ) as $opt_val => $opt_label ) {
				printf(
					'<option value="%1$s" %2$s>%3$s</option>',
					esc_attr( $opt_val ),
					selected( (string) $value, (string) $opt_val, false ),
					esc_html( $opt_label )
				);
			}
			echo '</select>';
			break;

		case 'number':
			printf(
				'<input type="number" name="%1$s" value="%2$s" %3$s />',
				$name_attr,
				esc_attr( (string) $value ),
				edgeframe_html_attrs( $attrs )
			);
			break;

		case 'media':
			$img = $value ? wp_get_attachment_image( (int) $value, array( 60, 60 ) ) : '';
			printf(
				'<div class="ef-media"><input type="hidden" name="%1$s" value="%2$s" /><button type="button" class="button ef-media-upload">%3$s</button> <span class="ef-media-preview">%4$s</span></div>',
				$name_attr,
				esc_attr( (string) $value ),
				esc_html__( 'Choose Image', 'edgeframe' ),
				$img
			);
			break;

		case 'text':
		default:
			printf(
				'<input type="text" class="regular-text" name="%1$s" value="%2$s" %3$s />',
				$name_attr,
				esc_attr( (string) $value ),
				edgeframe_html_attrs( $attrs )
			);
			break;
	}

	if ( $desc ) {
		echo '<p class="description">' . wp_kses_post( $desc ) . '</p>';
	}

	echo '</div>'; // .ef-field container end
}

/**
 * Convert associative array of attributes to HTML attributes string
 */
function edgeframe_html_attrs( array $attrs ): string {
	$out = array();
	foreach ( $attrs as $k => $v ) {
		if ( $v === true ) {
			$out[] = esc_attr( $k );
			continue; }
		if ( $v === false ) {
			continue; }
		$out[] = sprintf( '%s="%s"', esc_attr( $k ), esc_attr( (string) $v ) );
	}
	return implode( ' ', $out );
}

/**
 * Render a single repeater item row (supports group or primitive item types)
 *
 * @param string       $base_name Base name attribute for items (edgeframe_settings[key]).
 * @param array<mixed> $item_def  Item field definition: either {type:text|number|color|...} or {type:group, fields: {...}}.
 * @param mixed        $val       Current value for this item.
 * @param int|string   $index     Numeric index or template placeholder.
 * @return string HTML
 */
function edgeframe_render_repeater_item( string $base_name, array $item_def, $val, $index ): string {
	ob_start();
	$is_group = ( $item_def['type'] ?? 'text' ) === 'group';
	$name     = $base_name . '[' . $index . ']';
	echo '<div class="ef-repeater-item">';
	echo '<div class="ef-ri-controls">';
	echo '<button type="button" class="button ef-ri-move" aria-label="' . esc_attr__( 'Move', 'edgeframe' ) . '">≡</button>';
	echo '<button type="button" class="button ef-ri-remove" aria-label="' . esc_attr__( 'Remove', 'edgeframe' ) . '">×</button>';
	echo '</div>';

	if ( $is_group ) {
		$subs = $item_def['fields'] ?? array();
		$vals = is_array( $val ) ? $val : array();
		echo '<div class="ef-ri-group"><table class="ef-form-table form-table"><tbody>';
		foreach ( $subs as $sk => $sdef ) {
			$sub_name = $name . '[' . esc_attr( $sk ) . ']';
			$sub_val  = $vals[ $sk ] ?? ( $sdef['default'] ?? '' );
			$label    = isset( $sdef['label'] ) ? (string) $sdef['label'] : (string) $sk;
			echo '<tr><th><label>' . esc_html( $label ) . '</label></th><td>';
			$stype = $sdef['type'] ?? 'text';
			switch ( $stype ) {
				case 'number':
					printf( '<input type="number" name="%1$s" value="%2$s" %3$s />', $sub_name, esc_attr( (string) $sub_val ), edgeframe_html_attrs( $sdef['attrs'] ?? array() ) );
					break;
				case 'color':
					printf( '<input type="text" class="ef-color" name="%1$s" value="%2$s" %3$s />', $sub_name, esc_attr( (string) $sub_val ), edgeframe_html_attrs( $sdef['attrs'] ?? array() ) );
					break;
				case 'color_palette':
					$pal = $sdef['palette'] ?? array( '#111827', '#6b7280', '#4f46e5', '#10b981', '#ef4444', '#f59e0b' );
					echo '<div class="ef-color-palette" role="radiogroup">';
					foreach ( $pal as $pi => $phex ) {
						$phex    = (string) $phex;
						$pid     = esc_attr( $sk . '_pal_' . $pi );
						$checked = ( strtolower( (string) $sub_val ) === strtolower( $phex ) );
						echo '<label class="ef-color-swatch" style="--swatch:' . esc_attr( $phex ) . '">';
						printf( '<input type="radio" id="%1$s" name="%2$s" value="%3$s" %4$s />', $pid, $sub_name, esc_attr( $phex ), checked( $checked, true, false ) );
						echo '<span class="ef-color-swatch__chip" aria-hidden="true"></span>';
						echo '<span class="screen-reader-text">' . esc_html( $phex ) . '</span>';
						echo '</label>';
					}
					echo '</div>';
					break;
				case 'textarea':
					printf( '<textarea class="large-text" rows="3" name="%1$s" %3$s>%2$s</textarea>', $sub_name, esc_textarea( (string) $sub_val ), edgeframe_html_attrs( $sdef['attrs'] ?? array() ) );
					break;
				case 'select':
					echo '<select name="' . esc_attr( $sub_name ) . '" ' . edgeframe_html_attrs( $sdef['attrs'] ?? array() ) . '>';
					foreach ( ( $sdef['options'] ?? array() ) as $ov => $ol ) {
						printf( '<option value="%1$s" %2$s>%3$s</option>', esc_attr( (string) $ov ), selected( (string) ( $sub_val ?? '' ), (string) $ov, false ), esc_html( is_array( $ol ) ? ( $ol['label'] ?? (string) $ov ) : (string) $ol ) );
					}
					echo '</select>';
					break;
				case 'toggle':
					printf( '<label class="ef-toggle"><input type="checkbox" name="%1$s" value="1" %2$s %3$s /><span class="track"></span><span class="thumb"></span></label>', $sub_name, checked( ! empty( $sub_val ), true, false ), edgeframe_html_attrs( $sdef['attrs'] ?? array() ) );
					break;
				case 'date':
					printf( '<input type="date" name="%1$s" value="%2$s" %3$s />', $sub_name, esc_attr( (string) $sub_val ), edgeframe_html_attrs( $sdef['attrs'] ?? array() ) );
					break;
				case 'time':
					printf( '<input type="time" name="%1$s" value="%2$s" %3$s />', $sub_name, esc_attr( (string) $sub_val ), edgeframe_html_attrs( $sdef['attrs'] ?? array() ) );
					break;
				default:
					printf( '<input type="text" class="regular-text" name="%1$s" value="%2$s" %3$s />', $sub_name, esc_attr( (string) $sub_val ), edgeframe_html_attrs( $sdef['attrs'] ?? array() ) );
			}
			echo '</td></tr>';
		}
		echo '</tbody></table></div>';
	} else {
		$t = $item_def['type'] ?? 'text';
		switch ( $t ) {
			case 'number':
				printf( '<input type="number" name="%1$s" value="%2$s" %3$s />', $name, esc_attr( (string) $val ), edgeframe_html_attrs( $item_def['attrs'] ?? array() ) );
				break;
			case 'color':
				printf( '<input type="text" class="ef-color" name="%1$s" value="%2$s" %3$s />', $name, esc_attr( (string) $val ), edgeframe_html_attrs( $item_def['attrs'] ?? array() ) );
				break;
			case 'color_palette':
				$pal = $item_def['palette'] ?? array( '#111827', '#6b7280', '#4f46e5', '#10b981', '#ef4444', '#f59e0b' );
				echo '<div class="ef-color-palette" role="radiogroup">';
				foreach ( $pal as $pi => $phex ) {
					$phex    = (string) $phex;
					$pid     = esc_attr( 'rep_pal_' . $index . '_' . $pi );
					$checked = ( strtolower( (string) $val ) === strtolower( $phex ) );
					echo '<label class="ef-color-swatch" style="--swatch:' . esc_attr( $phex ) . '">';
					printf( '<input type="radio" id="%1$s" name="%2$s" value="%3$s" %4$s />', $pid, $name, esc_attr( $phex ), checked( $checked, true, false ) );
					echo '<span class="ef-color-swatch__chip" aria-hidden="true"></span>';
					echo '<span class="screen-reader-text">' . esc_html( $phex ) . '</span>';
					echo '</label>';
				}
				echo '</div>';
				break;
			case 'date':
				printf( '<input type="date" name="%1$s" value="%2$s" %3$s />', $name, esc_attr( (string) $val ), edgeframe_html_attrs( $item_def['attrs'] ?? array() ) );
				break;
			case 'time':
				printf( '<input type="time" name="%1$s" value="%2$s" %3$s />', $name, esc_attr( (string) $val ), edgeframe_html_attrs( $item_def['attrs'] ?? array() ) );
				break;
			default:
				printf( '<input type="text" class="regular-text" name="%1$s" value="%2$s" %3$s />', $name, esc_attr( (string) $val ), edgeframe_html_attrs( $item_def['attrs'] ?? array() ) );
		}
	}

	echo '</div>';
	return (string) ob_get_clean();
}
