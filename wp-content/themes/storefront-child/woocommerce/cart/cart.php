<?php
session_start();
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>


<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
		<thead>
			<tr>
				<th class="product-remove">&nbsp;</th>
				<th class="product-thumbnail">&nbsp;</th>
				<th class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
				<th class="product-price"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
				<th class="product-quantity"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
				<th class="product-subtotal"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php do_action( 'woocommerce_before_cart_contents' ); ?>

			<?php
			// $have_mask_item = false;
			$have_mask_item = true;

			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
				// echo '.';
				$terms = get_the_terms( $cart_item['product_id'], 'product_cat' );
				// $term = get_term_by( 'id', $cart_item['product_id'], 'product_cat' );
				if($terms[0]->slug =='against-sari')
				{
					$have_mask_item=true;
				}


				// echo '<div style="display:none;">';
			// echo $terms[0]->slug;
				// echo'</div>';

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
					<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

						<td class="product-remove">
							<?php
								// @codingStandardsIgnoreLine
								echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
									'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
									esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
									__( 'Remove this item', 'woocommerce' ),
									esc_attr( $product_id ),
									esc_attr( $_product->get_sku() )
								), $cart_item_key );
							?>
						</td>

						<td class="product-thumbnail">
						<?php

						$product_img_url = $_product->get_meta('fifu_image_url');
						// echo 1;
						$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

						if ( ! $product_permalink ) {
							echo $thumbnail; // PHPCS: XSS ok.
						} else {
							//printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), '<img src="'.$product_img_url.'">' );


							?>
							<?php


							if($product_img_url)
							{
								// echo $product_img_url;
								printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), '<img src="'.$product_img_url.'">' );

							}
							else {
								echo $thumbnail;


							}
							// if($thumbnail=='https://www.djs.com.hk/wp-content/uploads/woocommerce-placeholder.png')
							// 	{
							//
							// 	}
							// 	else {
							// 		// code...
							// 	}

							?>
							<!-- <a href="<?php echo $product_permalink; ?>"><img src="<?php echo $thumbnail;?>"></a> -->
							<?

							// PHPCS: XSS ok.
						}
						?>
						</td>

						<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
						<?php
						if ( ! $product_permalink ) {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
						} else {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
						}

						do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

						// Meta data.
						echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

						// Backorder notification.
						if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
						}
						?>
						</td>

						<td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
							<?php
								echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
							?>
						</td>

						<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
						<?php
						if ( $_product->is_sold_individually() ) {
							$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
						} else {
							$product_quantity = woocommerce_quantity_input( array(
								'input_name'   => "cart[{$cart_item_key}][qty]",
								'input_value'  => $cart_item['quantity'],
								'max_value'    => $_product->get_max_purchase_quantity(),
								'min_value'    => '0',
								'product_name' => $_product->get_name(),
							), $_product, false );
						}

						echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
						?>
						</td>

						<td class="product-subtotal" data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>">
							<?php
								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
							?>
						</td>
					</tr>
					<?php
				}
			}
			?>

			<?php do_action( 'woocommerce_cart_contents' ); ?>

			<tr>
				<td colspan="6" class="actions">

					<?php if ( wc_coupons_enabled() ) { ?>
						<div class="coupon">
							<label for="coupon_code"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?></button>
							<?php do_action( 'woocommerce_cart_coupon' ); ?>
						</div>
					<?php } ?>

					<button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

					<?php do_action( 'woocommerce_cart_actions' ); ?>

					<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
				</td>
			</tr>

			<?php do_action( 'woocommerce_after_cart_contents' ); ?>
		</tbody>
	</table>
	<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>



<div class="cart-djsfans-blk" style="<?php if($have_mask_item) {echo 'display:none;'; } ?>" >
	<span class="use-djsfans-point-title">使用 DJS FANs 積分:</span><br/>



<div class="before-login" <?php  if ($_SESSION['member_id']){
	?>
	style="display:none;"
	<?php
} ?>>

<div class="login-member-title"> - DJS FANS 登入 - </div>
<div class="error-msg"></div>


 <form class="login-form" action="#" method="post">

<div class="login-form-input-div-1">

		<input type="text" name="login_email" value="" placeholder="登入電郵">
    <input type="password" name="login_password" value="" placeholder="登入密碼">

		</div>
		<div class="login-form-input-div-2">

		<input type="button" id="login_submit_btn" name="submit" value="登入">
    <input type="reset" id="reset_btn" name="reset" value="重填">
</div>
 </form>

<a href="http://www.djsfans.com/" target="_blank"  class="join-djsfans-btn">還未申請會員嗎？按此加入DJS FANS</a>
 </div>



 <div class="after-login" <?php if(!$_SESSION['member_id']){
	 ?>
	 style="display:none";
 <?php
} ?>>
 <div class="fans-welcome-msg">
<?php
if($_SESSION['member_id'])
{
	echo $_SESSION['full_name']."(".$_SESSION['member_id'].")"." 目前有效DJS分：".$_SESSION['points'].'pts';


}
 ?>
 </div>


<form class="use-pts-form" action="#" method="post">



	 <div class="use-pts-div-2" <?php if(!$_SESSION['use_pts']) {

		 ?>
style="display:none;"		 <?php
	 }  ?>  >
	 	使用 <?php echo $_SESSION['use_pts']; ?><span class="use_pts-span"></span>  pts <a href="javascript:void(0);" id="cancel-pts-btn">取消</a>
	 </div>


	 <div class="use-pts-div" <?php if($_SESSION['use_pts']) {

		 ?>
style="display:none;"		 <?php
	 }  ?>>
		 使用pts(<span class="min-input">0</span> - <span class="max-input"><?php echo $_SESSION['points']; ?></span>): <input type="number" name="use_pt_input"  id="use_pt_input" max="<?php echo $_SESSION['points']; ?>" min="0">    <input type="submit" id="use-pts-btn" name="submit" value="送出"><input type="button" id="logout_pts_btn" name="submit" value="登出">
	 </div>

 </form>


</div>


</div>

<div class="cart-collaterals">
	<?php
		/**
		 * Cart collaterals hook.
		 *
		 * @hooked woocommerce_cross_sell_display
		 * @hooked woocommerce_cart_totals - 10
		 */
		do_action( 'woocommerce_cart_collaterals' );
	?>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>



<script type="text/javascript">

$(function(){


//	$('.use-pts-div').fadeOut(0);

$('#use_pt_input').change(function(){

	round_use_pt_input($(this).val())
//alert(7);

});

$('#cancel-pts-btn').click(function(e){
	e.preventDefault();

	$.post("<?php echo get_site_url() ?>/user_session.php",
  {"cancel_pts": 1},function(){
		location.reload();
	});
});



$('#use-pts-btn').click(function(e){
	e.preventDefault();
//	alert($('#use_pt_input').val());
	round_use_pt_input($('#use_pt_input').val());

	var use_pts = $('#use_pt_input').val();
	// localStorage.setItem('use_pts', use_pts);
	$.post("<?php echo get_site_url() ?>/user_session.php",
	{"use_pts": use_pts},function(){ location.reload();});


	// $('.use-pts-div').fadeOut(0);
	// $('.use-pts-div-2').fadeIn(0);
	$('.use_pts-span').html(use_pts);

});

	$('#logout_pts_btn').click(function(e){
			e.preventDefault();
			$.post("<?php echo get_site_url() ?>/user_session.php",
      {"logout": 1},function(){ location.reload();});

	});

// var token='';


function login(email,password)
{
	$.ajax({
					url: 'https://www.djsfans.com/api/v1/user/login',
					data: {email:email,password:password},
					type: 'POST',
					success: function(data){
						// token = data.success.token;

		if(data.error)
		{
			var  msg = "登入失敗，輸入電郵或密碼不正確";
								 $('.error-msg').html(msg);
		}
		else {
			var tk = data.success.token;

				$.post("<?php echo get_site_url() ?>/user_session.php",
				{"token": tk},function(){
					get_info(tk);
				});


		}
											////
					}
				});
}

function get_info(tk)
{
	$.ajax({
  url: 'https://www.djsfans.com/api/v1/user/get_info',
  type: 'POST',
  beforeSend: function (xhr) {
 		 xhr.setRequestHeader('Authorization', 'Bearer '+tk);
  },
  data: {},
  success: function (data) {

 	 console.log(data);
 	 appearPtsForm(data.full_name,data.member_code,data.points);
 	 // $('.use-pts-div-2').fadeOut(0);

	 $.post("<?php echo get_site_url() ?>/user_session.php",
					{"member_id": data.member_code,
					"points": data.points,
					"full_name": data.full_name
					});
					location.reload();
  },
  error: function () { },
  });
}


	$('#login_submit_btn').click(function(e){
		// console.log(123);

			e.preventDefault();

				var email = $('input[name=login_email]').val();
				var password = $('input[name=login_password]').val();
				console.log(email+' '+password);

				login(email,password);

				//
				// $.post("http://www.djsfans.com/api/v1/user/login",
				// 			{email:email,password:password},
				// 			 function(json){
				// 				 // var login = json.code;
				// 				 console.log(json);
				// 			 }
				// 		 );





					// $.ajax({
					//   method: "POST",
					//   url: "http://www.djsfans.com/api/v1/user/login",
					//   data: { email: email, password:password }
					// })
					//   .done(function( msg ) {
					// 		console.log(msg);
					//     // alert( "Data Saved: " + msg );
					//   });


				 // $.post("http://www.djsfans.com/api/v1/user/login")
				// $.post("http://www.djsfans.com/wp-json/api/memberLogin",
				// 			{login_email:login_email,login_password:login_password},
				// 			 function(json){
				// 				 var login = json.code;
				// 				 console.log(json);
				// 				 if(login==1)
				// 				 {
				//
				// 					 var full_name = json.data.full_name;
				// 					 var member_id = json.data.member_id;
				// 					 var pts = json.data.points;
				// 					 appearPtsForm(full_name,member_id,pts);
				//
				// 					 $.post("<?php echo get_site_url() ?>/user_session.php",
				// 					 {"member_id": member_id,
				// 					 "points": pts,
				// 					 "full_name": full_name
				// 				 	 });
				//
				//
				// 				 }
				// 				 else {
	  		// 						var  msg = "登入失敗，輸入電郵或密碼不正確";
	  		// 						 $('.error-msg').html(msg);
				//
				// 				 }
				//
				//
				// 			 }
				// 		 );
				 	});


});
function round_use_pt_input(value)
{
//	var value= $(this).val();
	var max = $('#use_pt_input').attr('max');
	if(Number(value) >Number(max)){
		value = max;
	}

	if(Number(value) < 0){
		value = 0;
	}
//	alert(Math.round(value));
	$('#use_pt_input').val(Math.round(value));


}
function appearPtsForm(full_name,member_id,pts)
{
	var msg='';
	msg = full_name+"("+member_id+")" +" 目前有效DJS分："+pts+'pts';
  $('.fans-welcome-msg').html(msg);
  $('.after-login').fadeIn(0);
  $('.before-login').fadeOut(0);
  $('#use_pt_input').attr('max',pts);
  $('#use_pt_input').attr('min',0);
	$('.min-input').html(0);
	$('.max-input').html(pts);

}


</script>
