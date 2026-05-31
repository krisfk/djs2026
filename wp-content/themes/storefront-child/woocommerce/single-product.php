<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php wc_get_template_part( 'content', 'single-product' ); ?>

		<?php endwhile; // end of the loop. ?>

	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

<?php
global $post;
$terms = get_the_terms( $post->ID, 'product_cat' );
foreach ($terms as $term) {
    $product_cat_id = $term->term_id;
    break;
}


if( $term = get_term_by( 'id', $product_cat_id, 'product_cat' ) ){
    if($term->name =='Japan Disneystore')
		{

			global $product;
			$sku=$product->get_sku();


			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://shopdisney.disney.co.jp/on/demandware.store/Sites-shopDisneyJapan-Site/ja_JP/Product-ShowQuickView?pid=".$sku);
			curl_setopt($ch, CURLOPT_HEADER, 0);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

			$result = curl_exec($ch);
			$result = json_decode($result);

echo $result->bottomBadgeLabel;
if(($result->bottomBadgeLabel!='comingsoon')&&( ($result->product->availability->messages[0]!='In Stock' &&
$result->product->availability->messages[0] !='This item is currently not available' ) || ($result->product->availability->messages[0]=='This item is currently not available')) )
{

?>
<script type="text/javascript">

// $(function(){
//
//
// 	$('.single-product div.product form.cart').html('');
// 	$('.single-product div.product form.cart').html('<span style="color:red;">日本 disneystore 暫時 Out Of Stock</span>');
//
//
// });

</script>

<?php
}
curl_close($ch);

	// global $product;
	// $sku=$product->get_sku();
	// $ch = curl_init();
	//
	// $url = 'http://www.kayli.me/djs-online-shop/check-store-stock.php';
	// curl_setopt( $ch, CURLOPT_URL, $url );
	// curl_setopt( $ch, CURLOPT_POST, true );
	//
	// 		curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( array( "uid" => $sku) ) );
	//
	// 		$output = curl_exec( $ch );
	// 		curl_close( $ch );



		};
}



 ?>



	<?php
		/**
		 * woocommerce_sidebar hook.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );

	?>

<?php get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
