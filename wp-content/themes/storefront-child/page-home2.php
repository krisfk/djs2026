<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package storefront
 */
get_header();
?>

<script type="text/javascript">
$(function() {

    $('.home-page-shortcut-btn').click(function(e) {
        e.preventDefault();
        $(this).toggleClass('active');

        if ($(this).hasClass('active')) {
            $('.home-page-shortcut-ul').fadeIn(300);
        } else {
            $('.home-page-shortcut-ul').fadeOut(0);
        }



    });

    $('.home-cate-shortcut-link').click(function(e) {

        e.preventDefault();
        $('.home-page-shortcut-btn').removeClass('active');
        $('.home-page-shortcut-ul').fadeOut(0);
        var idx = $(this).attr('data-link');
        // alert(idx);
        $('body,html').stop().animate({
            scrollTop: $('.home-cate-' + idx).offset().top - 10
        }, {
            duration: 500,
            complete: function() {}
        });




    })
});
</script>
<div class="home-page-shortcut-blk"><?php $query=new WP_Query(array('post_type'=> 'hp_products_grp', 'posts_per_page'   => -1));

if ($query->have_posts()) {
  echo'<ul class="home-page-shortcut-ul">';
	echo '<li><a class="home-cate-shortcut-link" data-link="10" href="javascript:void(0);">最新系列</a></li>';
	echo '<li><a class="home-cate-shortcut-link" data-link="11" href="javascript:void(0);">角色分類</a></li>';
  while ($query->have_posts()) {
    $query->the_post();
    echo '<li>';
    echo '<a href="javascript:void(0);" class="home-cate-shortcut-link" data-link="'.get_the_ID().'">'.get_the_title().'</a>';
    echo'</li>';
    //					echo'<h2 class="page-title home-cate-'.get_the_ID().'">- '.get_the_title().' - <a href="'.get_field('link_to').'">View all </a> -</h2>';
  }

  echo'</ul>';
}

?><a href="#" class="home-page-shortcut-btn">首頁捷徑</a></div>
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">


        <!-- Slick Slider Banner Start -->
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
        <style>
        .slick-banner-wrapper {
            width: 92vw;
            margin: 0;
            max-width: none;
            position: relative;
            left: 0;
            right: 0;
            transform: none;
            box-sizing: border-box;
        }
        .slick-banner, .slick-banner-extra {
            width: 100%;
        }
        .slick-banner img, .slick-banner-extra img {
            width: 100%;
            display: block;
        }
        </style>
        <div class="slick-banner-wrapper">
            <div class="slick-banner">
                <div>
                    <img src="https://djs.com.hk/wp-content/uploads/2022/08/genie-banner.jpg" alt="Genie Banner 1">
                </div>
                <div>
                    <img src="https://djs.com.hk/wp-content/uploads/2022/08/genie-banner.jpg" alt="Genie Banner 2">
                </div>
                <div>
                    <img src="https://djs.com.hk/wp-content/uploads/2022/08/genie-banner.jpg" alt="Genie Banner 3">
                </div>
                <div>
                    <img src="https://djs.com.hk/wp-content/uploads/2022/08/genie-banner.jpg" alt="Genie Banner 4">
                </div>
            </div>
            <?php
            // Define banners as an array for dynamism or fetch dynamically. For demo, we'll statically declare them.
            $banner_imgs = [
                "https://djs.com.hk/wp-content/uploads/2022/08/genie-banner.jpg",
                "https://djs.com.hk/wp-content/uploads/2022/08/genie-banner.jpg",
                "https://djs.com.hk/wp-content/uploads/2022/08/genie-banner.jpg",
                "https://djs.com.hk/wp-content/uploads/2022/08/genie-banner.jpg",
                "https://djs.com.hk/wp-content/uploads/2022/08/genie-banner.jpg",
                // Add more image URLs if there are more banners
            ];
            // Only print the extra slider if more than 4 banners
            if (count($banner_imgs) > 4) {
                echo '<div class="slick-banner-extra" style="margin-top:16px;">';
                // Output slides after the first four
                for ($i = 4; $i < count($banner_imgs); $i++) {
                    echo '<div><img src="'.$banner_imgs[$i].'" alt="Genie Banner '.($i+1).'"></div>';
                }
                echo '</div>';
            }
            ?>
        </div>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
        <script>
        jQuery(document).ready(function($){
            // Main banner (first 4)
            $('.slick-banner').slick({
                dots: true,
                infinite: true,
                speed: 500,
                slidesToShow: 4,
                slidesToScroll: 1,
                arrows: true,
                autoplay: true,
                autoplaySpeed: 4000,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: { slidesToShow: 3 }
                    },
                    {
                        breakpoint: 768,
                        settings: { slidesToShow: 2 }
                    },
                    {
                        breakpoint: 480,
                        settings: { 
                            slidesToShow: 1 
                        }
                    }
                ]
            });
            // Extra banner (if exists), show max 4 slides on mobile
            if ($('.slick-banner-extra').length > 0) {
                $('.slick-banner-extra').slick({
                    dots: true,
                    infinite: true,
                    speed: 500,
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    arrows: true,
                    autoplay: true,
                    autoplaySpeed: 4000,
                    responsive: [
                        {
                            breakpoint: 1200,
                            settings: { slidesToShow: 3 }
                        },
                        {
                            breakpoint: 768,
                            settings: { slidesToShow: 2 }
                        },
                        {
                            breakpoint: 480,
                            settings: { 
                                slidesToShow: 1 
                            }
                        }
                    ]
                });

                // Hide extra slides on mobile so never more than 4, even if slick would allow more
                function limitExtraSlidesMobile() {
                    var isMobile = window.innerWidth <= 480;
                    if (isMobile) {
                        $('.slick-banner-extra .slick-slide').each(function(idx, el){
                            if(idx >= 4){
                                $(el).hide();
                            } else {
                                $(el).show();
                            }
                        });
                    } else {
                        $('.slick-banner-extra .slick-slide').show();
                    }
                }
                // Run on load and resize
                $(window).on('resize', function(){
                    limitExtraSlidesMobile();
                });
                limitExtraSlidesMobile();

                // Also after slick changes slides
                $('.slick-banner-extra').on('setPosition', function(){
                    limitExtraSlidesMobile();
                });
            }
        });
        </script>
        <!-- Slick Slider Banner End -->


        <?php
echo '	<div class="clear-line"></div>';
echo'<h2 class="page-title hosme-cate-'.get_the_ID().'">- 最新訂貨 - <a href="https://www.djs.com.hk/product-category/live-new-product/">View all </a> -</h2>';
echo do_shortcode('[products category="live-new-product" limit="18" columns="4" visibility="visible" orderby="post_date" order="DESC"]');
?>




<?php $terms=get_terms(array('taxonomy'=> 'product_tag', 'hide_empty'=> false));



?><h2 class="page-title home-cate-11">- 角色分類 - </h2>
        <div class="product-tags"><?php foreach ($terms as $term) {
  ?><a href="<?php echo get_term_link($term->term_id, 'product_tag'); ?> " rel="tag"><?php echo $term->name;
  ?></a><?php
}

?></div>

        <?php $query=new WP_Query(array('post_type'=> 'hp_products_grp','posts_per_page'   => -1));

if ($query->have_posts()) {
  while ($query->have_posts()) {
    $query->the_post();
    echo '	<div class="clear-line"></div>';
    //				$slug = basename( get_permalink() );
    //					echo get_the_ID();
    echo'<h2 class="page-title home-cate-'.get_the_ID().'">- '.get_the_title().' - <a href="'.get_field('link_to').'">View all </a> -</h2>';
    $group_tag=get_field('group_tag')->slug;
    $group_category=get_field('group_category')->slug;
    echo do_shortcode('[products tag="'.$group_tag.'" category="'.$group_category.'" limit="18" columns="6" visibility="visible" orderby="post_date" order="DESC"]');
  }
}

?>
    </main>
</div><?php do_action('storefront_sidebar');

get_footer();