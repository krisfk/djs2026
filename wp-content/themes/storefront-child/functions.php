<?php
session_start();
add_filter('jpeg_quality', function($arg){return 100;});

add_action("init", function () {


  add_filter( 'woocommerce_catalog_orderby', 'bbloomer_remove_sorting_option_woocommerce_shop' );

  function bbloomer_remove_sorting_option_woocommerce_shop( $options ) {
    unset( $options['rating'] );
    unset( $options['popularity'] );
    unset( $options['date'] );

     return $options;
  }


  add_filter( 'woocommerce_get_related_product_cat_terms', 'remove_related_product_categories', 10, 2 );
  function remove_related_product_categories( $terms_ids, $product_id  ){
      return array();
  }


//  remove_action( 'storefront_footer', 'storefront_credit', 20);

    remove_action('homepage', 'storefront_best_selling_products',70);
    remove_action('homepage', 'storefront_on_sale_products',60);
    remove_action('homepage', 'storefront_popular_products',50);
    remove_action('homepage', 'storefront_featured_products',40);
    remove_action('homepage', 'storefront_recent_products',30);

    remove_action( 'homepage', 'storefront_product_categories', 20 );
    add_action( 'homepage', 'storefront_product_categories', 20 );

    remove_action( 'storefront_footer', 'storefront_product_categories', 20 );
    add_action( 'storefront_footer', 'storefront_credit', 20 );


    // add_filter( 'woocommerce_coupons_enabled', 'hide_coupon_field_on_cart' );
    // add_filter( 'woocommerce_coupons_enabled', 'hide_coupon_field_on_checkout' );

    add_filter( 'woocommerce_page_title', 'custom_woocommerce_page_title');


    add_filter( 'storefront_handheld_footer_bar_links', 'remove_my_account_mobile_nav' );
    add_filter( 'woocommerce_product_tag_cloud_widget_args', 'custom_woocommerce_tag_cloud_widget' );

    add_action( 'woocommerce_product_options_pricing', 'wc_cost_product_field' );
    add_action( 'save_post', 'wc_cost_save_product',99999 );

    // add_action( 'woocommerce_product_options_general_product_data', 'cfwc_create_custom_field' );
    // add_action( 'woocommerce_process_product_meta', 'cfwc_save_custom_field' );
    add_filter( 'woocommerce_csv_product_import_mapping_options', 'add_column_to_importer' );
    add_filter( 'woocommerce_csv_product_import_mapping_default_columns', 'add_column_to_mapping_screen' );
    add_filter( 'woocommerce_product_import_pre_insert_product_object', 'process_import', 10, 2 );


    add_action('admin_head', 'admin_css');








    add_filter( 'widget_tag_cloud_args', 'change_tag_cloud_font_sizes');
    /**
     * Change the Tag Cloud's Font Sizes.
     *
     * @since 1.0.0
     *
     * @param array $args
     *
     * @return array
     */
    function change_tag_cloud_font_sizes( array $args ) {
        $args['smallest'] = '12';
        $args['largest'] = '12';

        return $args;
    }

    /**
     * Exclude products from a particular category on the shop page
     */
    function custom_pre_get_posts_query( $q ) {

        $tax_query = (array) $q->get( 'tax_query' );

        $tax_query[] = array(
               'taxonomy' => 'product_cat',
               'field' => 'slug',
               'terms' => array( 'before-publishing' ), // Don't display products in the clothing category on the shop page.
               'operator' => 'NOT IN'
        );


        $q->set( 'tax_query', $tax_query );

    }
    add_action( 'woocommerce_product_query', 'custom_pre_get_posts_query' );


///////////////////////////////////////////////////////////////////////

add_action( 'woocommerce_product_quick_edit_end', function(){

    /*
    Notes:
    Take a look at the name of the text field, '_custom_field_demo', that is the name of the custom field, basically its just a post meta
    The value of the text field is blank, it is intentional
    */

    ?>
    <br>
    <div class="custom_field_demo" style="display: block;
    float: left;
    width: 100%;">
        <label class="alignleft">
            <div class="title"><?php _e('Cost Price', 'woocommerce' ); ?></div>
            <input type="text" name="cost_price" class="text" placeholder="<?php _e( 'Cost Price', 'woocommerce' ); ?>" value="">
        </label>
    </div>
    <?php

} );


add_action('woocommerce_product_quick_edit_save', function($product){

/*
Notes:
$_REQUEST['_custom_field_demo'] -> the custom field we added above
Only save custom fields on quick edit option on appropriate product types (simple, etc..)
Custom fields are just post meta
*/

if ( $product->is_type('simple') || $product->is_type('external') ) {

    $post_id = $product->id;

    if ( isset( $_REQUEST['cost_price'] ) ) {

        $customFieldDemo = trim(esc_attr( $_REQUEST['cost_price'] ));

        // Do sanitation and Validation here
        update_post_meta( $post_id, 'cost_price', wc_clean( $customFieldDemo ) );
    }

}

}, 10, 1);



add_action( 'manage_product_posts_custom_column', function($column,$post_id){

/*
Notes:
The 99 is just my OCD in action, I just want to make sure this callback gets executed after WooCommerce's
*/

switch ( $column ) {
    case 'name' :

        ?>
        <div class="hidden custom_field_demo_inline" id="custom_field_demo_inline_<?php echo $post_id; ?>">
            <div id="_custom_field_demo"><?php echo get_post_meta($post_id,'_custom_field_demo',true); ?></div>
        </div>
        <?php

        break;

    default :
        break;
}

}, 99, 2);


//
// add_filter( 'woocommerce_get_catalog_ordering_args', 'htl_woocommerce_get_catalog_ordering_args' );
// function htl_woocommerce_get_catalog_ordering_args( $args ) {
//       $args ['orderby'] = 'menu_order' ;
//       $args ['order'] = 'asc' ;
//     return  $args ;
// }

});


function admin_css() {
  echo '<style>
  table.wp-list-table td.column-thumb img {
    margin: 0;
    width: auto;
    height: auto;
    max-width: 150px;
    max-height: 150px;
    vertical-align: middle;
}
  </style>';
}


/**
 * Register the 'Custom Column' column in the importer.
 *
 * @param array $options
 * @return array $options
 */
function add_column_to_importer( $options ) {

	// column slug => column name
	$options['cost_price'] = 'Cost Price';
  $options['fifu_image_url'] = 'Fifu Image Url';
  $options['fifu_image_url_0'] = 'Fifu Image Url 0';
  $options['fifu_image_url_1'] = 'Fifu Image Url 1';
  $options['fifu_image_url_2'] = 'Fifu Image Url 2';
  $options['fifu_image_url_3'] = 'Fifu Image Url 3';
  $options['fifu_image_url_4'] = 'Fifu Image Url 4';
  $options['fifu_image_url_5'] = 'Fifu Image Url 5';
  $options['fifu_image_url_6'] = 'Fifu Image Url 6';
  $options['published'] = 'Published';

	return $options;
}

/**
 * Add automatic mapping support for 'Custom Column'.
 * This will automatically select the correct mapping for columns named 'Custom Column' or 'custom column'.
 *
 * @param array $columns
 * @return array $columns
 */
function add_column_to_mapping_screen( $columns ) {

	// potential column name => column slug
	$columns['Cost Price'] = 'cost_price';
	$columns['cost price'] = 'cost_price';

  // $columns['Fifu List Url'] = 'fifu_list_url';
  $columns['Fifu Image Url'] = 'fifu_image_url';
  $columns['fifu image url'] = 'fifu_image_url';

  $columns['Fifu Image Url 0'] = 'fifu_image_url_0';
  $columns['fifu image url 0'] = 'fifu_image_url_0';

    $columns['Fifu Image Url 1'] = 'fifu_image_url_1';
    $columns['fifu image url 1'] = 'fifu_image_url_1';

      $columns['Fifu Image Url 2'] = 'fifu_image_url_2';
      $columns['fifu image url 2'] = 'fifu_image_url_2';

        $columns['Fifu Image Url 3'] = 'fifu_image_url_3';
        $columns['fifu image url 3'] = 'fifu_image_url_3';

          $columns['Fifu Image Url 4'] = 'fifu_image_url_4';
          $columns['fifu image url 4'] = 'fifu_image_url_4';

            $columns['Fifu Image Url 5'] = 'fifu_image_url_5';
            $columns['fifu image url 5'] = 'fifu_image_url_5';

              $columns['Fifu Image Url 6'] = 'fifu_image_url_6';
              $columns['fifu image url 6'] = 'fifu_image_url_6';


              $columns['Published'] = 'published';
              $columns['published'] = 'published';


	return $columns;
}

/**
 * Process the data read from the CSV file.
 * This just saves the value in meta data, but you can do anything you want here with the data.
 *
 * @param WC_Product $object - Product being imported or updated.
 * @param array $data - CSV data read for the product.
 * @return WC_Product $object
 */
function process_import( $object, $data ) {

	if ( ! empty( $data['cost_price'] ) ) {
		$object->update_meta_data( 'cost_price', $data['cost_price'] );
	}

  if ( ! empty( $data['fifu_image_url'] ) ) {
		$object->update_meta_data( 'fifu_image_url', $data['fifu_image_url'] );
	}

  if ( ! empty( $data['fifu_image_url_0'] ) ) {
		$object->update_meta_data( 'fifu_image_url_0', $data['fifu_image_url_0'] );
	}
  if ( ! empty( $data['fifu_image_url_1'] ) ) {
		$object->update_meta_data( 'fifu_image_url_1', $data['fifu_image_url_1'] );
	}
  if ( ! empty( $data['fifu_image_url_2'] ) ) {
		$object->update_meta_data( 'fifu_image_url_2', $data['fifu_image_url_2'] );
	}
  if ( ! empty( $data['fifu_image_url_3'] ) ) {
		$object->update_meta_data( 'fifu_image_url_3', $data['fifu_image_url_3'] );
	}
  if ( ! empty( $data['fifu_image_url_4'] ) ) {
		$object->update_meta_data( 'fifu_image_url_4', $data['fifu_image_url_4'] );
	}
  if ( ! empty( $data['fifu_image_url_5'] ) ) {
		$object->update_meta_data( 'fifu_image_url_5', $data['fifu_image_url_5'] );
	}
  if ( ! empty( $data['fifu_image_url_6'] ) ) {
		$object->update_meta_data( 'fifu_image_url_6', $data['fifu_image_url_6'] );
	}

  if ( ! empty( $data['published'] ) ) {
		$object->update_meta_data( 'published', $data['published'] );
	}


  //
  // if ( ! empty( $data['fifu_list_url'] ) ) {
  //   $object->update_meta_data( 'fifu_list_url', $data['fifu_list_url'] );
  // }


	return $object;
}




function cfwc_create_custom_field() {
 $args = array(
 'id' => 'custom_text_field_title',
 'label' => __( 'Custom Text Field Title', 'cfwc' ),
 'class' => 'cfwc-custom-field',
 'desc_tip' => true,
 'description' => __( 'Enter the title of your custom text field.', 'ctwc' ),
 );
 woocommerce_wp_text_input( $args );
}

function cfwc_save_custom_field( $post_id ) {
 $product = wc_get_product( $post_id );
 $title = isset( $_POST['custom_text_field_title'] ) ? $_POST['custom_text_field_title'] : '';
 $product->update_meta_data( 'custom_text_field_title', sanitize_text_field( $title ) );
 $product->save();
}


function wc_cost_save_product( $product_id ) {

     // stop the quick edit interferring as this will stop it saving properly, when a user uses quick edit feature
     // if (wp_verify_nonce($_POST['_inline_edit'], 'inlineeditnonce'))
     //    return;

    // If this is a auto save do nothing, we only save when update button is clicked
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
    return;
  if ( isset( $_POST['cost_price'] ) ) {
    if ( is_numeric( $_POST['cost_price'] ) )
      update_post_meta( $product_id, 'cost_price', $_POST['cost_price'] );
  } else
{

//  update_post_meta( $product_id, 'cost_price', $_POST['cost_price'] );

// echo 'haha';
// exit();
// delete_post_meta( $product_id, 'cost_price' );

}
}


function wc_cost_product_field() {
    woocommerce_wp_text_input( array( 'id' => 'cost_price', 'class' => 'wc_input_price short', 'label' => __( 'Cost Price', 'woocommerce' ) . ' (' . get_woocommerce_currency_symbol() . ')' ) );
}


function custom_woocommerce_tag_cloud_widget() {
    $args = array(
        'taxonomy' => 'product_tag',
        'smallest' => 14,
        'largest' => 14
    );
    return $args;
}


//
// function change_tag_cloud_font_sizes( array $args ) {
//     $args['smallest'] = '14';
//     $args['largest'] = '14';
//
//     return $args;
// }



function storefront_credit() {
  ?>
  <div class="site-info">
    <?php echo esc_html( apply_filters( 'storefront_copyright_text', $content = '&copy; ' . get_bloginfo( 'name' ) . ' ' . date( 'Y' ) ) ); ?>
    <?php if ( apply_filters( 'storefront_credit_link', true ) ) { ?>
    <br />
      <?php
      if ( apply_filters( 'storefront_privacy_policy_link', true ) && function_exists( 'the_privacy_policy_link' ) ) {
        the_privacy_policy_link( '', '<span role="separator" aria-hidden="true"></span>' );
      }
      ?>
      <?php  //echo '<a href="https://woocommerce.com" target="_blank" title="' . esc_attr__( 'WooCommerce - The Best eCommerce Platform for WordPress', 'storefront' ) . '" rel="author">' . esc_html__( 'Built with Storefront &amp; WooCommerce', 'storefront' ) . '</a>.'; ?>
    <?php } ?>
  </div><!-- .site-info -->
  <?php
}


function remove_my_account_mobile_nav( $links ){

    unset( $links['my-account'] );
    return $links;
}


function custom_woocommerce_page_title( $page_title ) {

if (get_query_var('taxonomy') == 'product_tag' || get_query_var('taxonomy') == 'product_cat')
{
    $term_id = get_queried_object()->term_id;
    $term_name =get_queried_object()->name;

    return '- '.$term_name.' Items -';


  //  print_r(get_queried_object());
//echo 999;
    // Name
//    echo $term->name;

  //  $term = get_term_by( 'id', $term_id, 'products' );
    //echo $term->name;

    //  if (function_exists('get_wp_term_image'))
    //  {
    //      $meta_image = get_wp_term_image($term_id);
          //It will give category/term image url
    //  }

    //  echo $meta_image; // category/term image url


//    return '<img src="'.$meta_image.'">';
// $shop_page_id = wc_get_page_id( 'shop' );
//   $page_title   = get_the_title( $shop_page_id );


}
else if (get_query_var('taxonomy') == 'product_cat')
{
  $term_id = get_queried_object()->term_id;
  $term_name =get_queried_object()->name;

  return '- '.$term_name.' Items -';

}
else {
        $shop_page_id = wc_get_page_id( 'shop' );
          $page_title   = get_the_title( $shop_page_id );
          return $page_title;
}

//  if( $page_title == 'Shop' ) {
  //  return "WooCommerce Demo Products";
//  }

}

// hide coupon field on cart page
function hide_coupon_field_on_cart( $enabled ) {

	if ( is_cart() ) {
		$enabled = false;
	}

	return $enabled;
}

// hide coupon field on checkout page
function hide_coupon_field_on_checkout( $enabled ) {

	if ( is_checkout() ) {
		$enabled = false;
	}

	return $enabled;
}



function storefront_product_categories( $args ) {

 $args = apply_filters(
   'storefront_product_categories_args', array(
     'limit'            => 3,
     'columns'          => 3,
     'child_categories' => 0,
     'orderby'          => 'name',
     'title'            => __( '貨品分類', 'storefront' ),
   )
 );

 $shortcode_content = storefront_do_shortcode(
   'product_categories', apply_filters(
     'storefront_product_categories_shortcode_args', array(
       'number'  => intval( $args['limit'] ),
       'columns' => intval( $args['columns'] ),
       'orderby' => esc_attr( $args['orderby'] ),
       'parent'  => esc_attr( $args['child_categories'] ),
     )
   )
 );

 /**
  * Only display the section if the shortcode returns product categories
  */
 if ( false !== strpos( $shortcode_content, 'product-category' ) ) {
   echo '<section class="storefront-product-section storefront-product-categories" aria-label="' . esc_attr__( 'Product Categories', 'storefront' ) . '">';
   do_action( 'storefront_homepage_before_product_categories' );

   echo '<h2 class="section-title">' . wp_kses_post( $args['title'] ) . '</h2>';

   do_action( 'storefront_homepage_after_product_categories_title' );

   echo $shortcode_content; // WPCS: XSS ok.

   do_action( 'storefront_homepage_after_product_categories' );

   echo '</section>';
 }
}



 ?>

<?php

function custom_admin_js() {
    $url = get_bloginfo('template_directory') . '/js/wp-admin.js';
    echo '<script type="text/javascript">
    jQuery(function(){
    jQuery("#the-list").on("click", ".editinline", function(){

      inlineEditPost.revert();

      var post_id = jQuery(this).closest("tr").attr("id");

      post_id = post_id.replace("post-", "");

      var $cfd_inline_data = jQuery("#custom_field_demo_inline_" + post_id),
          $wc_inline_data = jQuery("#woocommerce_inline_" + post_id );

console.log($cfd_inline_data.find("#cost_price").text());
  //        jQuery("input[name=\'cost_price\']", ".inline-edit-row").val(999999);

//          jQuery("input[name=\'cost_price\']", ".inline-edit-row").val($cfd_inline_data.find("#cost_price").text());

var $clicked_post_tr = jQuery("tr.post-"+post_id);
jQuery("input[name=\'cost_price\']", ".inline-edit-row").val($clicked_post_tr.find("td[data-colname=\'Cost Price\']").text());


      var product_type = $wc_inline_data.find(".product_type").text();

      if (product_type=="simple" || product_type=="external") {
          jQuery(".custom_field_demo", ".inline-edit-row").show();
      } else {
          jQuery(".custom_field_demo", ".inline-edit-row").hide();
      }

    });
    });

    </script>';
}
add_action('admin_footer', 'custom_admin_js');































    // Add a custom field to product bulk edit special page
    add_action( 'woocommerce_product_bulk_edit_start', 'custom_field_product_bulk_edit', 10, 1 );
    function custom_field_product_bulk_edit() {
        ?>
            <div class="inline-edit-group">
                <label class="alignleft">
                    <span class="title"><?php _e('Cost Price', 'woocommerce'); ?></span>
                    <span class="input-text-wrap">
                        <select class="change_cost_price change_to" name="change_cost_price">
                        <?php
                            $options = array(
                                ''  => __( '— No change —', 'woocommerce' ),
                                '1' => __( 'Change to:', 'woocommerce' ),
                            );
                            foreach ( $options as $key => $value ) {
                                echo '<option value="' . esc_attr( $key ) . '">' . $value . '</option>';
                            }
                        ?>
                        </select>
                    </span>
                </label>
                <label class="change-input">
                    <input type="text" name="cost_price" class="text cost_price" placeholder="<?php _e( 'Enter Cost Price', 'woocommerce' ); ?>" value="" />
                </label>
            </div>
        <?php
    }

    // Save the custom fields data when submitted for product bulk edit
//    add_action('woocommerce_product_bulk_edit_save', 'save_custom_field_product_bulk_edit', 10, 1);
//remove_action( 'woocommerce_product_bulk_edit_save', 'save_custom_field_product_bulk_edit', 10, 1 );

//    add_action('woocommerce_product_bulk_edit_save', 'save_custom_field_product_bulk_edit', 10,1);
add_action('woocommerce_product_bulk_edit_save', 'save_custom_field_product_bulk_edit', 10,1);

//$idx = 0;
    function save_custom_field_product_bulk_edit( $product ){
//$idx ++;
        if ( $product->is_type('simple') || $product->is_type('external') ){
            $product_id = method_exists( $product, 'get_id' ) ? $product->get_id() : $product->id;


            if ( isset( $_REQUEST['cost_price'] ) ) {
              if ( is_numeric( $_REQUEST['cost_price'] ) )
                update_post_meta( $product_id, 'cost_price', $_REQUEST['cost_price'] );
            } else {
//              delete_post_meta( $product_id, 'cost_price' );
            }
        }

    }



    // Hook before calculate fees
    add_action('woocommerce_cart_calculate_fees' , 'add_custom_fees');

    /**
     * Add custom fee if more than three article
     * @param WC_Cart $cart
     */
    function add_custom_fees( WC_Cart $cart ){

      if($_SESSION['member_id'])
      {

        if($_SESSION['use_pts']) {

          $use_pts = $_SESSION['use_pts'];
          $discount = $cart->subtotal - $use_pts;
          $cart->add_fee( '使用djsfans pts ('.$use_pts.'pts)('.$_SESSION['member_id'].')', -$use_pts);

        }

        // if( $cart->cart_contents_count < 3 ){
        //     return;
        // }

      }
    }

    // if(is_order_received_page())
    // {
    // 	echo 99999;
    // }
    //


    add_action('woocommerce_thankyou', 'order_complete', 10, 1);

    function order_complete( $order_id ) {

//echo $_SESSION['points'].' '.$_SESSION['use_pts'];

      // $response = wp_remote_post( "http://www.djsfans.com/wp-json/api/shopCheckoutUpdatePts", array(
      // 	'method' => 'POST',
      // 	'timeout' => 45,
      // 	'redirection' => 5,
      // 	'httpversion' => '1.0',
      // 	'blocking' => true,
      // 	'headers' => array(
      //       'Authorization' => 'Bearer '.$_SESSION['token'],
      //       'Content-Type'  => 'application/json',
      //   ),
      // 	'body' =>
      //   array( 'member_id' => $_SESSION['member_id'],
      //           'from_point' => $_SESSION['points'],
      //           'to_point' => $_SESSION['points']-$_SESSION['use_pts']),
      // 	'cookies' => array()
      //     )
      // );

      $response = wp_remote_post( "https://www.djsfans.com/api/v1/user/update_pts", array(
      	'method' => 'POST',
      	'timeout' => 45,
      	'redirection' => 5,
      	'httpversion' => '1.0',
      	'blocking' => true,
      	'headers' => array(
            'Authorization' => 'Bearer '.$_SESSION['token'],
            'Content-Type'  => 'application/json'
        ),
      	'body' =>
        array( 'points' => ((int)$_SESSION['points']- (int)$_SESSION['use_pts']),
                'remark' => 'djs online shop 消費使用pts',
      	        'cookies' => array()
          )
      ));

      ?>
      <!-- <script type="text/javascript">
        console.log('<?php  echo $_SESSION['token']; ?>');
        console.log('<?php  echo $_SESSION['points']; ?>');
        console.log('<?php  echo $_SESSION['use_pts']; ?>');
        console.log('<?php echo ((int)$_SESSION['points']- (int)$_SESSION['use_pts']); ?>');
        $(function () {
        	$.ajax({
          url: 'http://www.djsfans.com/api/v1/user/update_pts',
          type: 'POST',
          beforeSend: function (xhr) {
         		 xhr.setRequestHeader('Authorization', 'Bearer '+'<?php echo $_SESSION['token']; ?>');
          },
          data: {points:<?php echo ((int)$_SESSION['points']- (int)$_SESSION['use_pts']); ?>,remark:'djs online shop 消費使用pts'},
          success: function (data) {
       	 console.log(data);
          },
          error: function (data) {
            console.log('error');
          console.log(data); },
          });

        });

      </script> -->
      <?php



      if ( is_wp_error( $response ) ) {
         $error_message = $response->get_error_message();
         echo "Something went wrong: $error_message";
      } else {
        $_SESSION["use_pts"]='';
        $_SESSION["member_id"]='';

         // echo 'Response:<pre>';
         // print_r( $response );
         // echo '</pre>';
      }


    //  $_SESSION["use_pts"]='';


    }


    /**
    * Change View cart text
    *
    */
    function my_text_strings( $translated_text, $text, $domain ) {
    switch ( $translated_text ) {
      case 'View cart' :
      $translated_text = __( '前往購物車結帳', 'woocommerce' );
      break;
      case 'Our bank details' :
      $translated_text = __( 'Our bank details(入數後請傳收據🧾whatsapp 94444920)', 'woocommerce' );
      break;

    }
    return $translated_text;
    }
    add_filter( 'gettext', 'my_text_strings', 20, 3 );



    function md_custom_woocommerce_checkout_fields( $fields )
{
    $fields['order']['order_comments']['placeholder'] = 'Special notes';
    $fields['order']['order_comments']['label'] = 'Add Special Notes:<br/>如需順豐到付<br/>請在備注填寫(收件人,電話,順豐站/櫃/便利店編號/上門地址)';

    return $fields;
}
add_filter( 'woocommerce_checkout_fields', 'md_custom_woocommerce_checkout_fields' );


 ?>
