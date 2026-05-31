<?php

$args = array( 'post_type' => 'product', 'post_status' => 'publish',
'posts_per_page' => -1 );
$products = new WP_Query( $args );
echo $products->found_posts;

 ?>
