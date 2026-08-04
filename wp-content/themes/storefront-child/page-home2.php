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




        <style>
        .home-banner-grid {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .home-banner-row {
            display: flex;
            width: 100%;
            gap: 16px;
        }
        .home-banner-item {
            flex: 1 1 0px;
            min-width: 0;
            text-align: center;
        }
        /* Desktop: 5 per row */
        @media (min-width: 901px) {
            .home-banner-item {
                flex: 0 0 19%;
                max-width: 19%;
            }
        }
        /* Tablet: 3 per row for width between 600px and 900px */
        @media (max-width: 900px) and (min-width:601px) {
            .home-banner-row {
                gap: 12px;
            }
            .home-banner-item {
                flex: 0 0 32%;
                max-width: 32%;
            }
        }
        /* Mobile: 3 per row for width <= 600px */
        @media (max-width: 600px) {
            .home-banner-grid
            {
                gap: 8px;
            }
            .home-banner-row {
                gap: 8px;
            }
            .home-banner-item {
                flex: 0 0 32%;
                max-width: 32%;
            }
        }
        </style>

        <div class="home-banner-grid">
        <?php
        $banner_img_url = "https://djs.com.hk/wp-content/uploads/2022/08/genie-banner.jpg";
        $total_banners = 12;

        // Rows are 5 items wide by default (desktop), 3 on mobile/tablet via CSS.
        $banners_per_row_desktop = 5;

        for ($i = 1; $i <= $total_banners; $i++) {
            // Open a row every 5 banners for desktop
            if (($i - 1) % $banners_per_row_desktop === 0) {
                echo '<div class="home-banner-row">';
            }

            echo '<div class="home-banner-item">';
            echo '<img src="' . esc_url($banner_img_url) . '" alt="Banner ' . $i . '" style="width:100%; max-width:100%; height:auto; border-radius: 8px;">';
            echo '</div>';

            // Close the row after 5 banners, or at the end
            if ($i % $banners_per_row_desktop === 0) {
                echo '</div>';
            }
        }
        // Close the last row if it wasn't closed (i.e., if $total_banners is not a multiple of $banners_per_row_desktop)
        // For mobile (<=600px), max 3 in a row is handled by CSS, 
        // but to make semantic rows for accessibility and consistency, also close rows at 3 per row if on mobile.
        // However, in PHP this is difficult without JS/CSS detection, so we handle 5 per row, visually 3 per row on mobile.
        // If $total_banners is not a multiple of 5, close the last row here:
        if (($i - 1) % $banners_per_row_desktop !== 0) {
            echo '</div>';
        }
        if (($i - 1) % $banners_per_row_desktop !== 0) {
            echo '</div>';
        }
        ?>
        </div>
  


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