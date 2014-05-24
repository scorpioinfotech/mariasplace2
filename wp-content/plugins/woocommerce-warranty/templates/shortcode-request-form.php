<form name="warranty_form" id="warranty_form" method="POST" action="<?php echo add_query_arg( array('product_id' => $product_id, 'req' => 'new_warranty', 'idx' => $idx) ); ?>" enctype="multipart/form-data" >

    <?php if ( isset($_REQUEST['error']) ): ?>
    <ul class="woocommerce_error">
        <li><?php echo $_REQUEST['error']; ?></li>
    </ul>
    <?php endif; ?>

    <?php
    $item = (isset($items[$idx])) ? $items[$idx] : false;

    if ( $item && $item['qty'] > 1 ):
        $max = warranty_get_quantity_remaining( $order_id, $product_id, $idx );
    ?>
    <p>
        <?php _e('Quantity', 'wc_warranty'); ?><br/>
        <select name="warranty_qty">
            <?php for ( $x = 1; $x <= $max; $x++ ): ?>
            <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
            <?php endfor; ?>
        </select>
    </p>
    <?php else: ?>
    <input type="hidden" name="warranty_qty" value="1" />
    <?php endif; ?>

    <?php
    $reasons = get_option('warranty_reason', '');
    $reason_array = preg_split("/(\r\n|\n|\r)/", $reasons);

    if ( !empty($reasons) && !empty($reason_array) ):
    ?>
    <p><?php _e('Select reason to request for warranty', 'wc_warranty'); ?><br/>
      <select name="warranty_reason">
        <?php
        foreach ($reason_array as $reason) {
            if ( empty($reason) ) continue;
            echo '<option value="'.trim($reason).'">'. trim($reason).'</option>';
        }
        ?>
      </select>
    </p>
    <?php
    else:
        echo '<input type="hidden" name="warranty_reason" value="" />';
    endif;

    $question   = get_option( 'warranty_question', '' );
    $required   = get_option( 'warranty_require_question', 'no' );

    if ( $question ):
    ?>
    <p><?php echo $question; ?> <?php if ($required == 'yes') echo '<b>(*)</b>'; ?><br/>
      <textarea style="width:250px;" rows="4" name="warranty_answer" id="warranty_answer"></textarea>
    </p>
    <?php endif; ?>

    <?php
    $upload = get_option( 'warranty_upload', 'no' );

    if ( $upload == 'yes' ):
        $title      = get_option( 'warranty_upload_title', 'Upload Attachment' );
        $required   = get_option( 'warranty_require_upload', 'no' );
    ?>
    <p>
        <?php echo $title; ?> <?php if ($required == 'yes') echo '<b>(*)</b>'; ?><br/>
        <input type="file" name="warranty_upload" />
    </p>
    <?php endif; ?>

    <p>
      <input type="submit" name="submit" value="Submit" class="button">
    </p>

</form>
