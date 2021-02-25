<?php
/**
 * A simple widget for displaying active WooCommerce shipping methods
 * @extends \WP_Widget
 */

class WC_Active_Shipping_Widget extends WP_Widget {
	 // * Setup the widget options
	public function __construct() {
	
		// set widget options
		$options = array(
			'classname'   => 'widget_wc_active_shipping', // CSS class name
			'description' => __( 'Displays a list of active shipping methods for your shop.', 'wc-active-shipping-widget' ),
		);
		
		// instantiate the widget
		parent::__construct( 'WC_Active_Shipping_Widget', __( 'WooCommerce Active Shipping Methods', 'wc-active-shipping-widget' ), $options );
	}
	
    // Render the widget
	public function widget( $args, $instance ) {
		// Get the active methods and bail if there are none
		$methods = $this->get_active_shipping_methods();
		if ( empty( $methods ) ) {
			return;
		}
		
		// get the widget configuration
		$title = $instance['title'];
		$added_text = $instance['text'];
		
		echo $args['before_widget'];
		
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		
		// Show the additional text if set
		if ( $added_text ) {
			echo '<p>' . wp_kses_post( $added_text ) . '</p>';
		}
		
		// Output list of shipping methods
		echo '<ul>';
		
		foreach ( $methods as $method ) {
			echo '<li>' . $method . '</li>';
		}
		
		echo '</ul>';
		
		echo $args['after_widget'];
	}
	

	// Update the widget title & selected product
	public function update( $new_instance, $old_instance ) {
	
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['text'] = strip_tags( $new_instance['text'] );
		
		return $instance;
	}
	
	 //  Render the admin form for the widget
	public function form( $instance ) {
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title', 'wc-active-shipping-widget' ) ?>:</label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( isset( $instance['title'] ) ? $instance['title'] : '' ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php _e( 'Additional text', 'wc-active-shipping-widget' ) ?>:</label>
			<textarea class="widefat" rows="3" cols="20" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>"><?php echo esc_textarea( $instance['text'] ); ?></textarea>
		</p>
		<?php
	}
	
 // * Gets the shipping methods enabled in the shop
	private function get_active_shipping_methods() {

		$shipping_methods = WC()->shipping->load_shipping_methods();
		$active_methods = array();	

		foreach ( $shipping_methods as $id => $shipping_method ) {
			if ( isset( $shipping_method->enabled ) && 'yes' === $shipping_method->enabled ) {
				$method_title = $shipping_method->title;
				if ( 'international_delivery' === $id ) {
					$method_title .= ' (International)';
				}
				array_push( $active_methods, $method_title );
			}
		}

		return $active_methods;
	}
	
} // end \WC_Active_Shipping_Widget class

 // Registers the new widget to add it to the available widgets

function wc_active_shipping_register_widget() {
	register_widget( 'WC_Active_Shipping_Widget' );
}
add_action( 'widgets_init', 'wc_active_shipping_register_widget' );