<?php
/**
 * The main template file.
 *
 * Full width homepage template for storefront child (customized).
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
        $('body,html').stop().animate({
            scrollTop: $('.home-cate-' + idx).offset().top - 10
        }, {
            duration: 500,
            complete: function() {}
        });
    })
});
</script>

<div class="home-page-shortcut-blk"><?php $query = new WP_Query(array('post_type'=> 'hp_products_grp', 'posts_per_page' => -1));
if ($query->have_posts()) {
    echo '<ul class="home-page-shortcut-ul">';
    echo '<li><a class="home-cate-shortcut-link" data-link="10" href="javascript:void(0);">最新系列</a></li>';
    echo '<li><a class="home-cate-shortcut-link" data-link="11" href="javascript:void(0);">角色分類</a></li>';
    while ($query->have_posts()) {
        $query->the_post();
        echo '<li>';
        echo '<a href="javascript:void(0);" class="home-cate-shortcut-link" data-link="'.get_the_ID().'">'.get_the_title().'</a>';
        echo '</li>';
    }
    echo '</ul>';
}
?><a href="#" class="home-page-shortcut-btn">首頁捷徑</a></div>

<!-- Make full-width: remove #primary/content-area wrappers, add full-width container -->
<div class="home-fullwidth-container" style="width:100vw; max-width:100vw; margin-left:calc(50% - 50vw); margin-right:calc(50% - 50vw); background:white;">
    <main id="main" class="site-main" role="main" style="width:100%;">

        <style>
            .home-banner-slider {
                width: 100vw;
                margin-bottom: 24px;
                overflow: visible;
                max-width: 100vw;
                position: relative;
                left: 50%;
                right: 50%;
                transform: translateX(-50%);
            }
            .banner-list {
                display: grid;
                grid-template-columns: repeat(6, 1fr);
                gap: 16px;
                list-style: none;
                padding: 0 32px;
                margin: 0 auto;
                width: 100%;
                max-width: 1600px;
                justify-items: center;
            }
            .banner-list .banner-slide {
                width: 100%;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .banner-list .banner-slide img {
                display: block;
                width: 100%;
                max-width: 220px;
                height: auto;
                border-radius: 8px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            }

            @media (max-width: 1200px) {
                .banner-list { grid-template-columns: repeat(5, 1fr); }
            }
            @media (max-width: 900px) {
                .banner-list { grid-template-columns: repeat(3, 1fr); }
            }
            @media (max-width: 600px) {
                .banner-list {
                    grid-template-columns: repeat(2, 1fr);
                    gap: 10px;
                }
                .banner-list .banner-slide img {
                    max-width: 100px;
                }
            }

            .clear-line {
                width: 100vw;
                max-width: 100vw;
                margin: 40px 0;
                border: none;
                border-top: 2px solid #eee;
                height: 0;
                background: none;
            }
            .page-title {
                text-align: center;
                margin-top: 48px;
                margin-bottom: 32px;
                font-size: 2.2em;
                letter-spacing: 1px;
                width: 100vw;
                max-width: 100vw;
            }
            .product-tags {
                text-align: center;
                margin-bottom: 28px;
                margin-top: -10px;
                width: 100vw;
                max-width: 100vw;
            }
            .product-tags a {
                display: inline-block;
                margin: 0 7px 10px 7px;
                padding: 7px 14px;
                background: #f9f9f9;
                border-radius: 15px;
                border: 1px solid #ddd;
                color: #b81c62;
                font-size: 1em;
                transition: background 0.15s, color 0.15s;
                text-decoration: none;
            }
            .product-tags a:hover {
                background: #f2e7ee;
                color: #d70053;
            }
        </style>

        <div class="home-banner-slider">
            <ul class="banner-list">
                <?php
                $banner_img_url = 'https://djs.com.hk/wp-content/uploads/2022/08/genie-banner.jpg';
                for ($i = 1; $i <= 12; $i++) {
                    echo '<li class="banner-slide"><img src="' . esc_url($banner_img_url) . '" alt="Banner ' . $i . '" /></li>';
                }
                ?>
            </ul>
        </div>

        <?php
        echo '<div class="clear-line"></div>';
        echo '<h2 class="page-title home-cate-10">- 最新訂貨 - <a href="https://www.djs.com.hk/product-category/live-new-product/" style="color:#b81c62; text-decoration:underline;">View all</a> -</h2>';
        echo do_shortcode('[products category="live-new-product" limit="18" columns="6" visibility="visible" orderby="post_date" order="DESC"]');
        ?>

        <?php $terms = get_terms(array('taxonomy'=> 'product_tag', 'hide_empty'=> false)); ?>
        <h2 class="page-title home-cate-11">- 角色分類 - </h2>
        <div class="product-tags">
            <?php
            foreach ($terms as $term) {
                echo '<a href="' . esc_url(get_term_link($term->term_id, 'product_tag')) . '" rel="tag">' . esc_html($term->name) . '</a>';
            }
            ?>
        </div>

        <?php 
        $query = new WP_Query(array('post_type'=> 'hp_products_grp','posts_per_page' => -1));
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                echo '<div class="clear-line"></div>';
                echo '<h2 class="page-title home-cate-'.get_the_ID().'">- '.get_the_title().' - <a href="'.esc_url(get_field('link_to')).'" style="color:#b81c62; text-decoration:underline;">View all</a> -</h2>';
                $group_tag = get_field('group_tag') ? get_field('group_tag')->slug : '';
                $group_category = get_field('group_category') ? get_field('group_category')->slug : '';
                echo do_shortcode('[products tag="'.$group_tag.'" category="'.$group_category.'" limit="18" columns="6" visibility="visible" orderby="post_date" order="DESC"]');
            }
        }
        ?>
    </main>
</div>
<?php do_action('storefront_sidebar');
get_footer();