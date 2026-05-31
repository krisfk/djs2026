<?php


// update_post_meta( $product_id, 'cost_price', sanitize_text_field( $_REQUEST['_cost_price'] ) );
$product_id=$_POST['product_id'];
$product_cost_price = $_POST['cost_price'];

update_post_meta( $product_id, 'cost_price', $product_cost_price);


 ?>
