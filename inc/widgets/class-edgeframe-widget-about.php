<?php
/**
 * EdgeFrame About Widget
 *
 * @package EdgeFrame
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

class EdgeFrame_Widget_About extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'edgeframe_widget_about',
			__( 'EdgeFrame: About', 'edgeframe' ),
			array( 'description' => __( 'About box with image and text.', 'edgeframe' ) )
		);
	}

	public function widget( $args, $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$text  = isset( $instance['text'] ) ? $instance['text'] : '';
		$img   = isset( $instance['image'] ) ? absint( $instance['image'] ) : 0;

		echo wp_kses(
			$args['before_widget'],
			array(
				'section' => array(
					'id'    => true,
					'class' => true,
				),
				'div'     => array(
					'id'    => true,
					'class' => true,
				),
			)
		);
		if ( $title ) {
			echo wp_kses(
				$args['before_title'],
				array(
					'h1' => array( 'class' => true ),
					'h2' => array( 'class' => true ),
					'h3' => array( 'class' => true ),
					'h4' => array( 'class' => true ),
				)
			) . esc_html( $title ) . wp_kses(
				$args['after_title'],
				array(
					'h1' => array(),
					'h2' => array(),
					'h3' => array(),
					'h4' => array(),
				)
			);
		}

		if ( $img ) {
			$src = wp_get_attachment_image_src( $img, 'thumbnail' );
			if ( $src ) {
				echo '<div class="ef-about-thumb"><img src="' . esc_url( $src[0] ) . '" alt=""/></div>';
			}
		}
		if ( $text ) {
			echo '<div class="ef-about-text">' . wp_kses_post( wpautop( $text ) ) . '</div>';
		}
		echo wp_kses(
			$args['after_widget'],
			array(
				'section' => array(),
				'div'     => array(),
			)
		);
	}

	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$text  = isset( $instance['text'] ) ? $instance['text'] : '';
		$img   = isset( $instance['image'] ) ? absint( $instance['image'] ) : 0;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'edgeframe' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php esc_html_e( 'Text:', 'edgeframe' ); ?></label>
			<textarea class="widefat" rows="5" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>"><?php echo esc_textarea( $text ); ?></textarea>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>"><?php esc_html_e( 'Image Attachment ID:', 'edgeframe' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" type="number" value="<?php echo esc_attr( $img ); ?>" />
			<small><?php esc_html_e( 'Paste an attachment ID (basic implementation).', 'edgeframe' ); ?></small>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = sanitize_text_field( $new_instance['title'] ?? '' );
		$instance['text']  = wp_kses_post( $new_instance['text'] ?? '' );
		$instance['image'] = isset( $new_instance['image'] ) ? absint( $new_instance['image'] ) : 0;
		return $instance;
	}
}
