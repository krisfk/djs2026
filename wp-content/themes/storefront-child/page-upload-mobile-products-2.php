<?php

ini_set("display_errors", "On"); // 設定是否顯示錯誤( On=顯示, Off=隱藏 )


require __DIR__ . '/../../../vendor/autoload.php';

use Automattic\WooCommerce\Client;

$woocommerce = new Client(
  'https://www.djs.com.hk',
  'ck_de8ae56fb0542de4713462233af0d4a727fce173',
  'cs_792f6090a1f222378942329064bfa10e386b3f4a',
  [
    'version' => 'wc/v3',
  ]
);

$allow_display=false;
if(!is_user_logged_in())
{

    ?>
<h1 class="mt-5 text-center">Please login at <br><a href="https://www.djs.com.hk/wp-login.php"
        target="_blank">https://www.djs.com.hk/wp-login.php</a> <br> then return here again</h1>
<?php
}
else
{
    $allow_display=true;
}
// simple
// $data = [
//     'name' => 'Premium Quality',
//     'type' => 'simple',
//     'regular_price' => '21.99',
//     'description' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
//     'short_description' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.',
//     'categories' => [
//         [
//             'id' => 9
//         ],
//         [
//             'id' => 14
//         ]
//     ],
//     'manage_stock' => false,
//     'images' => [
//         [
//             'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_2_front.jpg'
//         ],
//         [
//             'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_2_back.jpg'
//         ]
//     ]
// ];

// $woocommerce->post('products', $data);


//////////////////////////////////
//variation


// $prod_data = [
// 	'name'        => 'A great product',
// 	'type'        => 'variable',
// 	'description' => 'A very meaningful product description',
//     'short_description' =>'.',
// 	'images'      => [
// 		[
// 			'src'      => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_2_front.jpg',
// 			'position' => 0,
// 		],
// 	],
// 	'categories'  => [
// 		[
// 			'id' => 1,
// 		],
// 	],
// 	'attributes'  => [
// 		[
// 			'id'        => 3,
// 			'variation' => true,
// 			'visible'   => true,
// 			'options'   => [ 'S', 'M', 'L' ],
// 		],
// 	],
// ];




// $product = $woocommerce->post( 'products', $prod_data );

// $variation_data = [
// 	'regular_price' => '15.00',
// 	// 'image'         => [
// 	// 	'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_2_front.jpg',
// 	// ],
// 	'attributes'    => [
// 		[
// 			'id'     => 3,
// 			'option' => 'L',
// 		],
// 	],
// ];

// // 
// $woocommerce->post( "products/$product->id/variations", $variation_data );


///////////////////////



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mobile upload product(最新訂貨)</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="<?php echo get_site_url();?>/product-upload.css">

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

</head>

<body>


    <?php



$upload_to_cate_id = 239;


if($_POST['submit'])
{

    if(!empty($_FILES))
    {

         $product_img_arr=[];
       
            $wordpress_upload_dir = wp_upload_dir();

                $new_file_path = $wordpress_upload_dir['path'] . '/' . $_FILES["file_upload"]["name"];
                $j=0;
            while( file_exists( $new_file_path ) ) {
                $j++;
                $new_file_path = $wordpress_upload_dir['path'] . '/' . $j . '_' . $_FILES["file_upload"]["name"];
            }

            
            if (move_uploaded_file($_FILES["file_upload"]["tmp_name"], $new_file_path)) {

                $upload_id = wp_insert_attachment( array(
                'guid'           => $new_file_path, 
                'post_mime_type' => 'image/*',
                'post_title'     => preg_replace( '/\.[^.]+$/', '', $_FILES["file_upload"]["name"] ),
                'post_content'   => '',
                'post_status'    => 'inherit'
            ), $new_file_path );
            require_once( ABSPATH . 'wp-admin/includes/image.php' );

            wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $new_file_path ) );

            array_push($product_img_arr,['id'=>$upload_id]);

            } else {
                echo "<div class='text-center mt-4'>Sorry, there was an error uploading your file.</div>";
            } 

            // array_push($product_img_arr,['src'=>str_replace('/var/www/html/djs-online-shop',get_site_url(),$new_file_path)]);

            

       
            //other image
        if($_FILES['files_upload']['name'][0])
        {

            for($i=0;$i<count($_FILES['files_upload']['name']);$i++)
                {
                            $wordpress_upload_dir = wp_upload_dir();

                            $new_file_path = $wordpress_upload_dir['path'] . '/' . $_FILES["files_upload"]["name"][$i];
                            $j=0;
                        while( file_exists( $new_file_path ) ) {
                            $j++;
                            $new_file_path = $wordpress_upload_dir['path'] . '/' . $j . '_' . $_FILES["files_upload"]["name"][$i];
                        }

                        // array_push($product_img_arr,['src'=>str_replace('/var/www/html/djs-online-shop',get_site_url(),$new_file_path)]);
                    
                        
                        
                        if (move_uploaded_file($_FILES["files_upload"]["tmp_name"][$i], $new_file_path)) {

                            $upload_id = wp_insert_attachment( array(
                            'guid'           => $new_file_path, 
                            'post_mime_type' => 'image/*',
                            'post_title'     => preg_replace( '/\.[^.]+$/', '', $_FILES["files_upload"]["name"][$i] ),
                            'post_content'   => '',
                            'post_status'    => 'inherit'
                        ), $new_file_path );
                        require_once( ABSPATH . 'wp-admin/includes/image.php' );

                        wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $new_file_path ) );
                    
                        array_push($product_img_arr,['id'=>$upload_id]);

                        
                        } else {
                            echo "Sorry, there was an error uploading your file.";
                        }  
                }

        }


    }


    $product_name=$_POST['product-name'];
    $short_product_description=$_POST['product-description'];
    $product_type=$_POST['product-type'];
    $price=$_POST['product-price'];


    $number_of_options=$_POST['number-of-options'];

    $option_arr=[];
    $option_price_arr=[];
    
    for($i=1;$i<=$number_of_options;$i++)
    {
        array_push($option_arr,$_POST['opt-'.$i]);
    }


    for($i=1;$i<=$number_of_options;$i++)
    {
        array_push($option_price_arr,$_POST['vp-price-'.$i]);
    }
    

        
    if($product_type=='simple')
    {
        $data = [
        'name' => $product_name,
        'type' => 'simple',
        'regular_price' => $price,
        'short_description' => $short_product_description,
        'categories' => [
            [
                'id' => $upload_to_cate_id
            ]
        ],
        'images' => $product_img_arr
        ];

    $woocommerce->post('products', $data);

    
    }


    if($product_type=='variable')
    {
     
        $data = [
	'name'        => $product_name,
	'type'        => 'variable',
    'short_description' =>$short_product_description,
	'images'      => $product_img_arr,
	'categories'  => [
		[
			'id' => $upload_to_cate_id,
		],
	],
	'attributes'  => [
		[
			'id'        => 3,
			'variation' => true,
			'visible'   => true,
			'options'   => $option_arr,
		],
	],
];

$product = $woocommerce->post( 'products', $data );


for($i=0;$i<$number_of_options;$i++)
{
        $variation_data = [
        	'regular_price' => $option_price_arr[$i],
        	'attributes'    => [
        		[
        			'id'     => 3,
        			'option' => $option_arr[$i],
        		],
        	],
        ];
        $woocommerce->post( "products/$product->id/variations", $variation_data );
}



    }

}
?>

    <?php

if($allow_display)
{


?>
    <div class="loading-lightbox">


        <div class="loading-lightbox-center text-center">
            <img src="https://www.djs.com.hk/wp-content/uploads/2022/11/spin.gif" alt="">
            <h2>Uploading...</h2>
        </div>
    </div>

    <form action="" method="post" enctype="multipart/form-data">


        <div class="container mt-3">


            <?php
        if($_POST['submit'])
        {
            ?>
            <div class="msg text-center">Product was uploaded to <a target="_blank"
                    href="https://www.djs.com.hk/product-category/live-new-product/">here</a>
                <br>

                You can edit the products <a
                    href="https://www.djs.com.hk/wp-admin/edit.php?s&post_status=all&post_type=product&seo_filter&readability_filter&layout=5e79e06013ad4&product_cat=live-new-product&product_type&stock_status&filter_action=Filter&paged=1"
                    target="_blank">here</a> if make any mistake.
            </div>

            <?php
        }

        ?>


            <div class="text-center">
                <img src="https://www.djs.com.hk/wp-content/uploads/2022/11/photo.png" alt="">
            </div>
            <h4 class="text-center">Djs Web Product Upload Via Mobile(最新訂貨)</h4>

            <div class="mt-4">
                <label class="label-bold" for="product-name">*Product Name:</label>
                <input type="text" class="form-control" name="product-name" id="product-name">
            </div>


            <div class="mt-3">
                <div>
                    <label class="label-bold" for="file-upload-1">*Product Image(Cover Image):</label>
                </div>
                <input type="file" name="file_upload" id="file-upload-1" accept=".jpg">
            </div>
            <div class="mt-3">
                <div>
                    <label class="label-bold" for="file-upload-2">Product Images(Other Images):</label>
                </div>
                <input type="file" name="files_upload[]" id="file-upload-2" accept=".jpg" multiple>
            </div>

            <div class="mt-3">
                <label class="label-bold" for="product-description">*Product Description:<br>(如用default文字留返一點係度)</label>
                <textarea type="text" class="form-control" name="product-description" rows="4" cols="50"
                    id="product-description">.</textarea>
            </div>

            <div class="mt-3">

                <div class="label-bold">*Product Type:</div>
                <div class="margin:0.2rem 0 0 0;">
                    <input value="simple" class="form-check-input" type="radio" name="product-type" id="product-type-1"
                        checked>
                    <label class="form-check-label" for="product-type-1">
                        Simple
                    </label>
                    <input value="variable" class="form-check-input ms-2" type="radio" name="product-type"
                        id="product-type-2">
                    <label class="form-check-label" for="product-type-2">
                        Variable
                    </label>
                </div>

            </div>

            <div class="simple-div">
                <div class="mt-3">
                    <label class="label-bold" for="product-price">*Product Price:</label>
                    <input type="number" pattern="\d*" class="form-control" name="product-price" id="product-price">
                </div>
            </div>

            <div class="variable-div">
                <div class="mt-3">
                    <label class="label-bold" for="number-of-options">*Number of Option(s):</label>
                    <select id="number-of-options" class="form-select" aria-label="Default" name="number-of-options">
                        <option selected value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>





                </div>



                <div class="mt-3">
                    <label class="label-bold" for="number-of-options">Same Price For All Options:</label>
                    <div class="margin:0.2rem 0 0 0;">
                        <input value="yes" class="form-check-input" type="radio" name="is-same-price"
                            id="is-same-price-1" checked>
                        <label class="form-check-label" for="is-same-price-1">
                            Yes
                        </label>
                        <input value="no" class="form-check-input  ms-2" type="radio" name="is-same-price"
                            id="is-same-price-2">
                        <label class="form-check-label" for="is-same-price-2">
                            No
                        </label>
                    </div>

                    <div class="opt-rows-div mt-3">

                        <?php
                
                for($k=1;$k<=10;$k++)
                {
                    ?>

                        <div class="row mb-2">
                            <div class="col-6">
                                <label for="opt-<?php echo $k;?>" class="label-bold">*Option <?php echo $k;?></label>
                                <input class="form-control" id="opt-<?php echo $k;?>" name="opt-<?php echo $k;?>"
                                    type="text">
                            </div>
                            <div class="col-6">
                                <label for="vp-price-<?php echo $k;?>" class="label-bold">*Price</label>
                                <input class="form-control wp-price" id="vp-price-<?php echo $k;?>"
                                    name="vp-price-<?php echo $k;?>" type="number" pattern="\d*">
                            </div>
                        </div>
                        <?php
                }
                ?>

                    </div>




                </div>

            </div>

            <div class="mt-3 mb-5 text-center submit-div">
                <input class="submit-btn" type="submit" value="submit" name="submit">
            </div>


        </div>

    </form>
    <?php
}
    ?>

    <script type="text/javascript">
    $(function() {


        $('.opt-rows-div .row').fadeOut(0);
        $('.opt-rows-div .row').eq(0).fadeIn(0);
        $('.variable-div').fadeOut(0);

        $('input[name="product-type"]').change(function() {

            var type = $("input[name='product-type']:checked").val();

            console.log(type);
            if (type == "simple") {
                $('.variable-div').fadeOut(0);
                $('.simple-div').fadeIn(0);
            }

            if (type == "variable") {
                $('.variable-div').fadeIn(0);
                $('.simple-div').fadeOut(0);
            }
        })

        $('#number-of-options').change(function() {

            var num = $('#number-of-options').val();


            $('.opt-rows-div .row').fadeOut(0);

            for (i = 0; i < num; i++) {
                $('.opt-rows-div .row').eq(i).fadeIn(0);
            }






        })

        $('.wp-price').keyup(function() {

            var is_same_price = $('input[name="is-same-price"]:checked').val();

            if (is_same_price == 'yes') {


                $('.wp-price').val($(this).val());
            }
        })




        // $('.submit-btn').click(function() {

        $('form').submit(function() {

            $('.loading-lightbox').fadeIn(0);

            // $('.submit-btn').attr('disabled', 'disabled');

        })

        // alert(9);
        // $('.loading-lightbox').fadeIn(200);
        // })
    })
    </script>
</body>

</html>


<!-- 

<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="files_upload[]" id="file_upload" accept=".jpg" multiple>
    <input type="submit" value="submit">
</form> -->
<?php





if(!empty($_FILES))
{
    // echo $_FILES['files_upload']['name'];

    // $total = count($_FILES['files_upload']['name']);

    // echo $total;
    // print_r($_FILES);
    // print_r()
    // if($_FILES["files_upload"]['size'])
    // {
            // $wordpress_upload_dir = wp_upload_dir();


            // $new_file_path = $wordpress_upload_dir['path'] . '/' . $_FILES["file_upload"]["name"];

            //     $i=0;
            // while( file_exists( $new_file_path ) ) {
            //     $i++;
            //     $new_file_path = $wordpress_upload_dir['path'] . '/' . $i . '_' . $_FILES["file_upload"]["name"];
            // }
            
            // if (move_uploaded_file($_FILES["file_upload"]["tmp_name"], $new_file_path)) {

            //     $upload_id = wp_insert_attachment( array(
            //     'guid'           => $new_file_path, 
            //     'post_mime_type' => 'image/*',
            //     //$_FILES["file_upload"]["tmp_name"],
            //     'post_title'     => preg_replace( '/\.[^.]+$/', '', $_FILES["file_upload"]["name"] ),
            //     'post_content'   => '',
            //     'post_status'    => 'inherit'
            // ), $new_file_path );
            // require_once( ABSPATH . 'wp-admin/includes/image.php' );

            // wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $new_file_path ) );
            // //  conclude Image

            // update_field( 'conclude_image', $upload_id, $school_id );
            
            // // conclusion_content
        
            // } else {
            //     echo "Sorry, there was an error uploading your file.";
            // }        
    // }

    // echo $new_file_path;
}


?>