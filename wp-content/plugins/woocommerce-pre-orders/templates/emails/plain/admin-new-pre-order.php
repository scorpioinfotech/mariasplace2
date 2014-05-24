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
 * Admin new order email (plain text)
 *
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

echo $email_heading . "\n\n";

echo sprintf( __( 'You have received a pre-order from %s. Their pre-order is as follows:', WC_Pre_Orders::TEXT_DOMAIN ), $order->billing_first_name . ' ' . $order->billing_last_name ) . "\n\n";

echo "****************************************************\n\n";

do_action( 'woocommerce_email_before_order_table', $order, true );

echo sprintf( __( 'Order number: %s', WC_Pre_Orders::TEXT_DOMAIN), $order->get_order_number() ) . "\n";
echo sprintf( __( 'Order date: %s', WC_Pre_Orders::TEXT_DOMAIN), date_i18n( __( 'jS F Y', WC_Pre_Orders::TEXT_DOMAIN ), strtotime( $order->order_date ) ) ) . "\n";

do_action( 'woocommerce_email_order_meta', $order, true, true );

echo "\n" . $order->email_order_items_table( false, true, '', '', '', true );

echo "----------\n\n";

if ( $totals = $order->get_order_item_totals() ) {
	foreach ( $totals as $total ) {
		echo $total['label'] . "\t " . $total['value'] . "\n";
	}
}

echo "\n****************************************************\n\n";

do_action( 'woocommerce_email_after_order_table', $order, true, true );

_e( 'Customer details', WC_Pre_Orders::TEXT_DOMAIN );

if ( $order->billing_email )
	echo __( 'Email:', WC_Pre_Orders::TEXT_DOMAIN ); echo $order->billing_email. "\n";

if ( $order->billing_phone )
	echo __( 'Tel:', WC_Pre_Orders::TEXT_DOMAIN ); ?> <?php echo $order->billing_phone. "\n";

woocommerce_get_template( 'emails/plain/email-addresses.php', array( 'order' => $order ) );

echo "\n****************************************************\n\n";

echo apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) );
