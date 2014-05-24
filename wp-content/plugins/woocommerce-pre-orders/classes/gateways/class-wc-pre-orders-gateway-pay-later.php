<?php
/**
 * WooCommerce Pre-Orders
 *
 * @package     WC-Pre-Orders/Pay-Later-Gateway
 * @author      WooThemes
 * @copyright   Copyright (c) 2013, WooThemes
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Pre-Orders "Pay Later" Payment Gateway class
 *
 * Extends the WC_Payment_Gateway class to provide a generic "Pay Later" payment gateway for pre-orders
 *
 * @since 1.0
 * @extends \WC_Payment_Gateway
 */
class WC_Pre_Orders_Gateway_Pay_Later extends WC_Payment_Gateway {


	/**
	 * Loads settings and hooks for saving
	 *
	 * @since 1.0
	 * @return \WC_Pre_Orders_Gateway_Pay_Later
	 */
	public function __construct() {

		// load defaults
		$this->id                 = 'pre_orders_pay_later';
		$this->method_title       = __( 'Pay Later', WC_Pre_Orders::TEXT_DOMAIN );
		$this->method_description = __( 'This payment method replaces all other methods that do not support pre-orders when the pre-order is charged upon release.', WC_Pre_Orders::TEXT_DOMAIN );
		$this->icon               = apply_filters( 'wc_pre_orders_pay_later_icon', '' );
		$this->has_fields         = false;

		// Load the settings
		$this->init_form_fields();
		$this->init_settings();

		$this->title       = $this->get_option( 'title' );
		$this->description = $this->get_option( 'description' );

		// support pre-orders
		$this->supports = array( 'products', 'pre-orders' );

		// always enabled
		$this->enabled = true;

		// Save settings
		if ( is_admin() )
			add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );

		// pay page fallback
		add_action( 'woocommerce_receipt_' . $this->id, create_function( '$order', 'echo "<p>" . __( "Thank you for your order.", WC_Pre_Orders::TEXT_DOMAIN ) . "</p>";' ) );
	}


	/**
	 * Disables the gateway under any of these conditions:
	 * 1) If the cart does not contain a pre-order
	 * 2) If the pre-order amount is charged upfront
	 * 3) On the pay page
	 *
	 * @since 1.0
	 * @return bool
	 */
	public function is_available() {

		$is_available = parent::is_available();

		// on checkout page
		if ( ! is_page( woocommerce_get_page_id( 'pay' ) ) || ( defined( 'WOOCOMMERCE_CHECKOUT' ) && WOOCOMMERCE_CHECKOUT ) ) {

			// not available if the cart does not contain a pre-order
			if ( WC_Pre_Orders_Cart::cart_contains_pre_order() ) {

				// not available when the pre-order amount is charged upfront
				if ( WC_Pre_Orders_Product::product_is_charged_upfront( WC_Pre_Orders_Cart::get_pre_order_product() ) )
					$is_available = false;

			} else {

				$is_available = false;
			}

		} else {

			// not available on the pay page (for now)
			$is_available = false;
		}

		return $is_available;
	}


	/**
	 * Setup gateway form fields
	 *
	 * @since 1.0
	 */
	public function init_form_fields() {

		$this->form_fields = array(

			'title'       => array(
				'title'       => __( 'Title', WC_Pre_Orders::TEXT_DOMAIN ),
				'type'        => 'text',
				'description' => __( 'This controls the title which the user sees during checkout.', WC_Pre_Orders::TEXT_DOMAIN ),
				'default'     => __( 'Pay Later', WC_Pre_Orders::TEXT_DOMAIN ),
				'desc_tip'    => true,
			),

			'description' => array(
				'title'       => __( 'Customer Message', WC_Pre_Orders::TEXT_DOMAIN ),
				'type'        => 'textarea',
				'description' => __( 'Let the customer know how they will be able to pay for their pre-order.', WC_Pre_Orders::TEXT_DOMAIN ),
				'default'     => __( 'You will receive an email when the pre-order is available along with instructions on how to complete your order.', WC_Pre_Orders::TEXT_DOMAIN ),
			)
		);
	}


	/**
	 * Process the payment and return the result
	 *
	 * @since 1.0
	 * @param int $order_id
	 * @return array
	 */
	public function process_payment( $order_id ) {
		global $woocommerce;

		$order = new WC_Order( $order_id );

		// Reduce stock levels
		$order->reduce_order_stock();

		// Remove cart
		$woocommerce->cart->empty_cart();

		// Update status
		$order->update_status( 'pre-ordered' );

		// Redirect to thank you page
		return array(
			'result'   => 'success',
			'redirect' => $this->get_return_url( $order ),
		);
	}


} // end \WC_Pre_Orders_Gateway_Pay_Later class
