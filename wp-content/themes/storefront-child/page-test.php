
<?php
//key ck_3783040287d27a800c5505b33f72ed59a9650cb0
//secret cs_e984f0ed294b3690b4a1f0d42d09aa3acc56041f


// $api_response = wp_remote_post( 'https://www.djs.com.hk/wp-json/wc/v2/products', array(
//  	'headers' => array(
// 		'Authorization' => 'Basic ' . base64_encode( 'ck_3783040287d27a800c5505b33f72ed59a9650cb0:cs_e984f0ed294b3690b4a1f0d42d09aa3acc56041f' )
// 	),
// 	'body' => array(
// 		'name' => 'My test2', // product title
//     'type' => 'variable', // just update the product type
//
// 		'status' => 'publish', // product status, default: publish
// 		'slug'          => 'hahahaha',
// 		'categories' => array(
// 			array(
// 				'id' => 239 // each category in a separate array
// 			)
// 		),
// 		'attributes' => array(
// 				array(
// 	      				'name' => 'Color', // parameter for custom attributes
// 	      				'visible' => true, // default: false
//                 'variation'=>true,
// 	      				'options' => array(
// 	        				'black',
// 	        				'blue'
// 					)
// 				)
// 			),
//     'variations' => array(
//         array(  'regular_price' => '29.98',
//         'attributes' => array(
//             array( 'name'=>'Color', 'options'=>'black' )
//              )
//             ),
//         array(  'regular_price' => '29.98',
//           'attributes' => array(
//               array( 'name'=>'Color', 'options'=>'blue' )
//               )
//               )
//             ),
//
// 		'regular_price' => '30'
// 	)
// ) );
//
// // Used for variations
//
// $body = json_decode( $api_response['body'] );
// //print_r( $body );
//
// if( wp_remote_retrieve_response_message( $api_response ) === 'Created' ) {
// 	echo 'The product ' . $body->name . ' has been created';
// }

$article_name ='test p';
$post_id = wp_insert_post( array(
    'post_author' => 1,
    'post_title' => $article_name,
    'post_content' => 'Lorem ipsum',
    'post_status' => 'publish',
    'post_type' => "product",
) );
wp_set_object_terms( $post_id, 'variable', 'product_type' );

$attr_label = 'Test attribute';
$attr_slug = sanitize_title($attr_label);

$attributes_array[$attr_slug] = array(
    'name' => $attr_label,
    'value' => 'alternative 1 | alternative 2',
    'is_visible' => '1',
    'is_variation' => '1',
    'is_taxonomy' => '0' // for some reason, this is really important
);
update_post_meta( $post_id, '_product_attributes', $attributes_array );

$parent_id = $post_id;
$variation = array(
    'post_title'   => $article_name . ' (variation)',
    'post_content' => '',
    'post_status'  => 'publish',
    'post_parent'  => $parent_id,
    'post_type'    => 'product_variation'
);

$variation_id = wp_insert_post( $variation );
update_post_meta( $variation_id, '_regular_price', 2 );
update_post_meta( $variation_id, '_price', 2 );
update_post_meta( $variation_id, '_stock_qty', 10 );
update_post_meta( $variation_id, 'attribute_' . $attr_slug, 'alternative 1' );
WC_Product_Variable::sync( $parent_id );

$variation_id = wp_insert_post( $variation );
update_post_meta( $variation_id, '_regular_price', 2 );
update_post_meta( $variation_id, '_price', 2 );
update_post_meta( $variation_id, '_stock_qty', 10 );
update_post_meta( $variation_id, 'attribute_' . $attr_slug, 'alternative 2' );
WC_Product_Variable::sync( $parent_id );

?>
