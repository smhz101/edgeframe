<?php
/**
 * EdgeFrame Recent Posts with Thumbnails Widget
 *
 * @package EdgeFrame
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

class EdgeFrame_Widget_Recent_Posts extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'edgeframe_widget_recent_posts',
			__( 'EdgeFrame: Recent Posts', 'edgeframe' ),
			array( 'description' => __( 'Recent posts with thumbnails.', 'edgeframe' ) )
		);
	}

	public function widget( $args, $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$count = isset( $instance['count'] ) ? absint( $instance['count'] ) : 5;
		$count = $count > 0 && $count <= 10 ? $count : 5;

		// before_widget and after_widget come from theme markup; allow only basic tags/attributes.
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

		$q = new WP_Query(
			array(
				'posts_per_page'      => $count,
				'no_found_rows'       => true,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true,
			)
		);
		if ( $q->have_posts() ) {
			echo '<ul class="ef-recent-posts">';
			while ( $q->have_posts() ) {
				$q->the_post();
				echo '<li class="ef-recent-item">';
				if ( has_post_thumbnail() ) {
					echo '<a class="ef-thumb" href="' . esc_url( get_permalink() ) . '" aria-hidden="true" tabindex="-1">';
					the_post_thumbnail( 'edgeframe-thumb', array( 'alt' => the_title_attribute( array( 'echo' => false ) ) ) );
					echo '</a>';
				}
				echo '<div class="ef-meta">';
				echo '<a class="ef-title" href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a>';
				echo '<time class="ef-date" datetime="' . esc_attr( get_the_date( DATE_W3C ) ) . '">' . esc_html( get_the_date() ) . '</time>';
				echo '</div>';
				echo '</li>';
			}
			echo '</ul>';
			wp_reset_postdata();
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
		$count = isset( $instance['count'] ) ? absint( $instance['count'] ) : 5;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'edgeframe' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Number of posts to show:', 'edgeframe' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" step="1" min="1" max="10" value="<?php echo esc_attr( $count ); ?>" />
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = sanitize_text_field( $new_instance['title'] ?? '' );
		$instance['count'] = isset( $new_instance['count'] ) ? absint( $new_instance['count'] ) : 5;
		return $instance;
	}
}
