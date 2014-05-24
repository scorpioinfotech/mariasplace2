<?php
/**
 * WooCommerce Pre-Orders
 *
 * @package     WC-Pre-Orders/Templates/Email
 * @author      WooThemes
 * @copyright   Copyright (c) 2013, WooThemes
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

/**
 * Customer pre-order cancelled notification email
 *
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

echo $email_heading . "\n\n";

echo __( "Your pre-order has been cancelled. Your order details are shown below for your reference.", WC_Pre_Orders::TEXT_DOMAIN ) . "\n\n";

if ( $message ) :

echo "----------\n\n";
echo wptexturize( $message ) . "\n\n";
echo "----------\n\n";

endif;

echo "****************************************************\n\n";

do_action( 'woocommerce_email_before_order_table', $order, false );

echo sprintf( __( 'Order number: %s', WC_Pre_Orders::TEXT_DOMAIN ), $order->get_order_number() ) . "\n";
echo sprintf( __( 'Order date: %s', WC_Pre_Orders::TEXT_DOMAIN ), date_i18n( woocommerce_date_format(), strtotime( $order->order_date ) ) ) . "\n";

do_action( 'woocommerce_email_order_meta', $order, false, true );

echo "\n" . $order->email_order_items_table( false, true, false, '', '', true );

echo "----------\n\n";

if ( $totals = $order->get_order_item_totals() ) {
	foreach ( $totals as $total ) {
		echo $total['label'] . "\t " . $total['value'] . "\n";
	}
}

echo "\n****************************************************\n\n";

do_action( 'woocommerce_email_after_order_table', $order, false, true );

echo __( 'Your details', WC_Pre_Orders::TEXT_DOMAIN ) . "\n\n";

if ( $order->billing_email )
	echo __( 'Email:', WC_Pre_Orders::TEXT_DOMAIN ); echo $order->billing_email. "\n";

if ( $order->billing_phone )
	echo __( 'Tel:', WC_Pre_Orders::TEXT_DOMAIN ); ?> <?php echo $order->billing_phone. "\n";

woocommerce_get_template( 'emails/plain/email-addresses.php', array( 'order' => $order ) );

echo "\n****************************************************\n\n";

echo apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) );
