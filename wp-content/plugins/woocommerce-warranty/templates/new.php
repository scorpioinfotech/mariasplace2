<div id="search_form" <?php if ($searched || $form_view) echo 'style="display:none;"'; ?>>
    <form action="admin.php" method="get">
        <h4><?php _e('Search for an Order', 'wc_warranty'); ?></h4>

        <input type="hidden" name="page" value="warranty_requests" />
        <input type="hidden" name="tab" value="new" />

        <p>
            <select name="search_key">
                <option value="order_id"><?php _e('Order Number', 'wc_warranty'); ?></option>
                <option value="email"><?php _e('Customer Email', 'wc_warranty'); ?></option>
                <option value="name"><?php _e('Customer Name', 'wc_warranty'); ?></option>
            </select>

            <input type="text" name="search_term" id="search_term" value="<?php if (isset($_GET['search_term'])) echo esc_attr($_GET['search_term']); ?>" class="short" />

            <input type="submit" id="order_search_button" class="button-primary" value="<?php _e('Search', 'wc_warranty'); ?>" />
        </p>
    </form>
</div>
<?php if ($searched || $form_view): ?>
<p><input type="button" class="toggle_search_form button" value="Show Search Form" /></p>
<?php endif; ?>

<?php if ( $searched && empty($orders) ): ?>
<div class="error"><p><?php _e('No orders found', 'wc_warranty'); ?></p></div>
<?php endif; ?>

<?php if ( !empty($orders) ): ?>
<form method="get" action="admin.php">
    <table class="wp-list-table widefat fixed" cellspacing="0">
        <thead>
            <tr>
                <th scope="col" id="order_id" class="manage-column column-order_id" style="width: 100px;"><?php _e('Order ID', 'wc_warranty'); ?></th>
                <th scope="col" id="order_customer" class="manage-column column-order_customer" style="width: 200px;"><?php _e('Customer', 'wc_warranty'); ?></th>
                <th scope="col" id="order_status" class="manage-column column-status" style="width: 100px;"><?php _e('Order Status', 'wc_warranty'); ?></th>
                <th scope="col" id="order_items" class="manage-column column-order_items"><?php _e('Order Items', 'wc_warranty'); ?></th>
                <th scope="col" id="order_items" class="manage-column column-order_items" style="width: 100px;"><?php _e('Date', 'wc_warranty'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ( $orders as $order_row):
                $order = new WC_Order( $order_row->id );
            ?>
            <tr class="alternate">
                <td class="order_id column-order_id"><?php echo $order_row->id; ?></td>
                <td class="order_id column-order_customer"><?php echo $order->billing_first_name .' '. $order->billing_last_name; ?></td>
                <td class="order_status column-status"><?php echo $order->status; ?></td>
                <td class="order_items column-order_items">
                    <ul class="order-items">
                    <?php
                    foreach ( $order->get_items() as $item_idx => $item ):
                        $item_id = (isset($item['product_id'])) ? $item['product_id'] : $item['id'];
                        $product = (function_exists('get_product')) ? get_product( $item_id ) : new WC_Product($item_id);
                    ?>
                        <li>
                            <?php echo $product->get_title(); ?>
                            <?php if (isset($item['Warranty'])): ?>
                            <span class="description">(Warranty: <?php echo $item['Warranty']; ?>)</span>
                            <?php endif; ?>
                            &times;
                            <?php echo $item['qty']; ?>
                            &mdash;
                            <a href="admin.php?page=warranty_requests&amp;tab=new&amp;order_id=<?php echo $order->id; ?>&amp;product_id=<?php echo $item_id; ?>&amp;idx=<?php echo $item_idx; ?>" class="button"><?php _e('Create Request', 'wc_warranty'); ?></a>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                </td>
                <td class="order_id column-order_date"><?php echo $order->order_date; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</form>
<?php endif; ?>

<?php if ( isset($_GET['order_id'], $_GET['product_id'], $_GET['idx']) ): ?>
<form method="post" action="admin-post.php">
    <table class="form-table">
        <tbody>
    <?php

    if ( isset($_GET['error']) ) {
        echo '<div class="error"><p>'. $_GET['error'] .'</p></div>';
    }
    //echo '<pre>'. print_r(get_post_meta($_GET['order_id'], '_warranties', true), true) .'</pre>';
    global $wc_warranty;

    $order          = new WC_Order( $_GET['order_id'] );
    $has_warranty   = $this->order_has_warranty($order);
    $items          = $order->get_items();
    $item           = (isset($items[$_GET['idx']])) ? $items[$_GET['idx']] : false;
    $max            = 0;

    if ( $item ) {
        if ( $has_warranty && $item['qty'] > 1 ) {
            $max = warranty_get_quantity_remaining( $_GET['order_id'], $_GET['product_id'], $_GET['idx'] );
        } else {
            $max = $item['qty'] - warranty_count_quantity_used( $_GET['order_id'], $_GET['product_id'], $_GET['idx'] );
        }
    }

    if ( $max < 1 ) {
    ?>
    <tr valign="top">
        <th scope="row" colspan="2">
            <strong><?php _e('No available warranties for products in this order.', 'wc_warranty'); ?></strong>
        </th>
    </tr>
    <?php
    } else {
    ?>
    <tr valign="top">
        <th scope="row">
            <label for="warranty_qty"><?php _e('Quantity', 'wc_warranty'); ?></label>
        </th>
        <td>
            <select name="warranty_qty" id="warranty_qty">
                <?php for ( $x = 1; $x <= $max; $x++ ): ?>
                <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                <?php endfor; ?>
            </select>
        </td>
    </tr>

    <?php
        $reasons = get_option('warranty_reason', '');
        $reason_array = preg_split("/(\r\n|\n|\r)/", $reasons);

        if ( !empty($reasons) && !empty($reason_array) ):
    ?>
    <tr valign="top">
        <th scope="row"><label for="warranty_reason"><?php _e('Select customer reason for requesting a warranty or return', 'wc_warranty'); ?></label></th>
        <td>
            <select name="warranty_reason" id="warranty_reason">
                <?php
                foreach ($reason_array as $reason) {
                    if ( empty($reason) ) continue;
                    echo '<option value="'.trim($reason).'">'. trim($reason).'</option>';
                }
                ?>
            </select>
        </td>
    </tr>
    <?php
        else:
            echo '<input type="hidden" name="warranty_reason" value="" />';
        endif;

        $question   = get_option( 'warranty_question', '' );
        $required   = get_option( 'warranty_require_question', 'no' );

        if ( $question ):
    ?>
    <tr valign="top">
        <th scope="row"><label for="warranty_answer"><?php echo $question; ?> <?php if ($required == 'yes') echo '<b>(*)</b>'; ?></label></th>
        <td><textarea style="width:250px;" rows="4" name="warranty_answer" id="warranty_answer"></textarea></td>
    </tr>
    <?php
        endif;
    ?>

    <?php
        $upload = get_option( 'warranty_upload', 'no' );

        if ( $upload == 'yes' ):
            $title      = get_option( 'warranty_upload_title', 'Upload Attachment' );
            $required   = get_option( 'warranty_require_upload', 'no' );
    ?>
    <tr valign="top">
        <th scope="row"><label for="warranty_upload"><?php echo $title; ?> <?php if ($required == 'yes') echo '<b>(*)</b>'; ?></label></th>
        <td><input type="file" name="warranty_upload" id="warranty_upload" /></td>
    </tr>
    <?php
        endif;
    ?>
        </tbody>
    </table>
    <input type="hidden" name="order_id" value="<?php echo $_GET['order_id']; ?>" />
    <input type="hidden" name="product_id" value="<?php echo $_GET['product_id']; ?>" />
    <input type="hidden" name="index" value="<?php echo $_GET['idx']; ?>" />
    <input type="hidden" name="action" value="warranty_create" />
    <input type="submit" name="submit" value="Submit" class="button">
</form>
<?php
    }
endif;
?>
<script type="text/javascript">
jQuery(document).ready(function($) {
    $(".toggle_search_form").click(function() {
        if ( $("#search_form").is(":visible") ) {
            $(this).val("Show Search Form");
            $("#search_form").hide();
        } else {
            $(this).val("Hide Search Form");
            $("#search_form").show();
        }
    });

    jQuery(".help_tip").tipTip();
});
</script>
