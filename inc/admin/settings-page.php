<?php
/**
 * Settings page renderer (ThemeForest-grade UI)
 *
 * @package Edgeframe
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load schema and actions
require_once EDGEFRAME_PATH . 'inc/admin/settings-schema.php';
require_once EDGEFRAME_PATH . 'inc/admin/settings-actions.php';

/**
 * Render the settings page
 */
function edgeframe_render_settings_page() {
	// New snake_case filter for schema
	$schema = apply_filters( 'edgeframe_admin_schema', edgeframe_get_settings_schema() );
	// Back-compat: slash-named filter
	if ( has_filter( 'edgeframe/admin/schema' ) ) {
		$schema = apply_filters( 'edgeframe/admin/schema', $schema );
	}
	/**
	 * Allow child themes to modify tabs order or locals.
	 */
	$schema = apply_filters( 'edgeframe_admin_schema_after', $schema );
	if ( has_filter( 'edgeframe/admin/schema/after' ) ) {
		$schema = apply_filters( 'edgeframe/admin/schema/after', $schema );
	}

	// Before render action
	do_action( 'edgeframe_admin_before_render', $schema );
	if ( has_action( 'edgeframe/admin/before_render' ) ) {
		do_action( 'edgeframe/admin/before_render', $schema );
	}

	?>
	<div class="wrap edgeframe-wrap">
		<h1 class="ef-title"><?php esc_html_e( 'EdgeFrame Settings', 'edgeframe' ); ?></h1>

		<?php
		$status = isset( $_GET['ef_status'] ) ? sanitize_key( wp_unslash( $_GET['ef_status'] ) ) : '';
		if ( $status ) {
			$messages = array(
				'imported'     => array(
					'class' => 'updated',
					'text'  => __( 'Settings imported successfully.', 'edgeframe' ),
				),
				'reset'        => array(
					'class' => 'updated',
					'text'  => __( 'Settings reset to defaults.', 'edgeframe' ),
				),
				'no_file'      => array(
					'class' => 'error',
					'text'  => __( 'No file selected for import.', 'edgeframe' ),
				),
				'invalid_json' => array(
					'class' => 'error',
					'text'  => __( 'The uploaded file is not valid JSON.', 'edgeframe' ),
				),
			);
			if ( isset( $messages[ $status ] ) ) {
				$m = $messages[ $status ];
				echo '<div class="notice ' . esc_attr( $m['class'] ) . ' is-dismissible"><p>' . esc_html( $m['text'] ) . '</p></div>';
			}
		}
		?>

		<div class="ef-toolbar">
			<div class="ef-toolbar__search">
				<input type="search" id="ef-search" placeholder="<?php echo esc_attr__( 'Search settings…', 'edgeframe' ); ?>" />
			</div>

			<?php
			do_action( 'edgeframe_admin_toolbar' );
			if ( has_action( 'edgeframe/admin/toolbar' ) ) {
				do_action( 'edgeframe/admin/toolbar' );
			}
			?>
		</div>

		<div class="ef-layout">
			<aside class="ef-sidebar">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Settings Navigation', 'edgeframe' ); ?></h2>
				<div class="nav-tab-wrapper ef-nav" id="edgeframe-tabs">
						<?php
						foreach ( $schema as $tab_key => $tab ) :
							$icon_html = '';
							if ( ! empty( $tab['icon'] ) ) {
								$icon_class = sanitize_html_class( $tab['icon'] );
								$icon_html  = '<span class="dashicons ' . esc_attr( $icon_class ) . '"></span>';
							}
							?>
							<a href="#ef-<?php echo esc_attr( $tab_key ); ?>" class="nav-tab" data-tab="<?php echo esc_attr( $tab_key ); ?>"><?php echo wp_kses( $icon_html, array( 'span' => array( 'class' => array() ) ) ); ?><?php echo esc_html( $tab['label'] ?? $tab_key ); ?></a>
					<?php endforeach; ?>
					<?php
					do_action( 'edgeframe_admin_tabs_after', $schema );
					if ( has_action( 'edgeframe/admin/tabs_after' ) ) {
						do_action( 'edgeframe/admin/tabs_after', $schema );
					}
					?>
				</div>
			</aside>

			<section class="ef-content" aria-live="polite">
				<?php foreach ( $schema as $tab_key => $tab ) : ?>
					<div id="ef-<?php echo esc_attr( $tab_key ); ?>" class="ef-tab" style="display:none;">
						<?php if ( ! empty( $tab['desc'] ) ) : ?>
							<p class="ef-tab-desc"><?php echo wp_kses_post( $tab['desc'] ); ?></p>
						<?php endif; ?>

						<?php if ( 'tools' === $tab_key ) : ?>
							<section class="ef-section">
								<h2 class="ef-section-title"><?php esc_html_e( 'Import / Export', 'edgeframe' ); ?></h2>
								<div class="ef-tools">
									<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="ef-toolbar__group">
										<input type="hidden" name="action" value="edgeframe_export" />
										<?php wp_nonce_field( 'edgeframe_export' ); ?>
										<button type="submit" class="button button-secondary"><?php esc_html_e( 'Export Settings', 'edgeframe' ); ?></button>
									</form>

									<form method="post" enctype="multipart/form-data" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="ef-toolbar__group">
										<input type="hidden" name="action" value="edgeframe_import" />
										<?php wp_nonce_field( 'edgeframe_import' ); ?>
										<input type="file" name="edgeframe_import_file" accept="application/json" />
										<button type="submit" class="button button-primary"><?php esc_html_e( 'Import Settings', 'edgeframe' ); ?></button>
									</form>

									<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="ef-toolbar__group">
										<input type="hidden" name="action" value="edgeframe_reset" />
										<?php wp_nonce_field( 'edgeframe_reset' ); ?>
										<button type="submit" class="button button-link-delete" onclick="return confirm('<?php echo esc_js( __( 'Reset all settings to defaults?', 'edgeframe' ) ); ?>');"><?php esc_html_e( 'Reset to Defaults', 'edgeframe' ); ?></button>
									</form>
								</div>
							</section>
						<?php endif; ?>

						<form method="post" action="options.php" class="ef-form" data-tab="<?php echo esc_attr( $tab_key ); ?>">
							<?php
							settings_fields( 'edgeframe_group' );
							do_action( 'edgeframe_admin_before_sections', $tab, $tab_key );
							if ( has_action( 'edgeframe/admin/before_sections' ) ) {
								do_action( 'edgeframe/admin/before_sections', $tab, $tab_key );
							}

							$rendered = false;
							foreach ( ( $tab['sections'] ?? array() ) as $section_key => $section ) {
								$rendered   = true;
								$section_id = "edgeframe_{$tab_key}_{$section_key}";
								echo '<section class="ef-section" data-section="' . esc_attr( $section_key ) . '">';
								if ( ! empty( $section['label'] ) ) {
									echo '<h2 class="ef-section-title">' . esc_html( $section['label'] ) . '</h2>';
								}
								if ( ! empty( $section['desc'] ) ) {
									echo '<p class="ef-section-desc">' . wp_kses_post( $section['desc'] ) . '</p>';
								}

								do_action( 'edgeframe_admin_section_before', $tab_key, $section_key, $section );
								if ( has_action( 'edgeframe/admin/section/before' ) ) {
									do_action( 'edgeframe/admin/section/before', $tab_key, $section_key, $section );
								}

								echo '<table class="ef-form-table form-table" role="presentation"><tbody>';
								do_settings_fields( 'edgeframe-settings', $section_id );
								echo '</tbody></table>';

								do_action( 'edgeframe_admin_section_after', $tab_key, $section_key, $section );
								if ( has_action( 'edgeframe/admin/section/after' ) ) {
									do_action( 'edgeframe/admin/section/after', $tab_key, $section_key, $section );
								}

								echo '</section>';
							}

							if ( ! $rendered && 'tools' !== $tab_key ) {
								echo '<div class="notice notice-info"><p>' . esc_html__( 'No settings in this tab yet.', 'edgeframe' ) . '</p></div>';
							}

							do_action( 'edgeframe_admin_after_sections', $tab, $tab_key );
							if ( has_action( 'edgeframe/admin/after_sections' ) ) {
								do_action( 'edgeframe/admin/after_sections', $tab, $tab_key );
							}
							submit_button();
							?>
						</form>
					</div>
				<?php endforeach; ?>
			</section>
		</div>

		<?php
		do_action( 'edgeframe_admin_after_render', $schema );
		if ( has_action( 'edgeframe/admin/after_render' ) ) {
			do_action( 'edgeframe/admin/after_render', $schema );
		}
		?>
	</div>
	<?php
}