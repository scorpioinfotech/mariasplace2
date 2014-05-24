<div id="primary">
    <div id="content" role="main">
        <?php
        if ( isset($_GET['updated']) ) {
            echo '<div class="woocommerce_message">'. $_GET['updated'] .'</div>';
        }

        if (! $product_id ) {
            // show products in an order
            $order      = new WC_Order( $order_id );
            $completed  = get_post_meta( $order->id, '_completed_date', true);
            $items      = $order->get_items();

            if ( empty($completed) ) {
                $completed = false;
            }

            include WC_Warranty::$base_path .'templates/shortcode-order-items.php';
        } else {
            // Request warranty on selected product
            $order = new WC_Order( $order_id );
            $items  = $order->get_items();
            $idx    = (int)$_GET['idx'];

            include WC_Warranty::$base_path .'templates/shortcode-request-form.php';
        }

        ?>
    </div>
</div>
