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

<style>

  .home2-banner-image-list{
    margin-top:2em;
  }
    .home2-banner-image-list ul {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        padding: 0;
        list-style: none;
        margin: 0;
    }
    .home2-banner-image-list li {
        flex: 1 0 22%;
        max-width: 24%;
        box-sizing: border-box;
    }
    @media (max-width: 768px) {
        .home2-banner-image-list li {
            flex: 1 0 30%;
            max-width: 32%;
        }
    }
    @media (max-width: 480px) {
        .home2-banner-image-list li {
            flex: 1 0 30%;
            max-width: 33%;
        }
    }
</style>


<div style="text-align:center; margin-top:1em;">
    長期誠接 各大品牌 日本長期代購 可Whatsapp 
    <a href="http://wa.me/85294444920" target="_blank" class="home-wa-btn" style="display:inline-block;padding:0.6em 1.2em;background:#25D366;color:#fff;border:none;border-radius:4px;font-weight:bold;text-decoration:none;font-size:1.1em;box-shadow:0 2px 6px rgba(0,0,0,0.09);transition:background 0.2s;">Whatsapp 報價：94444920</a>
</div>

<div class="home2-banner-image-list">
    <ul>
        <?php
        // WP_Query: Fetch posts from the custom post type 'banners'
        $args = array(
            'post_type'      => 'banner',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
        );
        $banner_query = new WP_Query($args);

        if ($banner_query->have_posts()) :
            while ($banner_query->have_posts()) : $banner_query->the_post();
                $banner_img = get_field('banner_img');
                $banner_url = get_field('banner_url');

                if (!empty($banner_img)) {
                    // Add 'class="home2-banner-img"' to the img tag via the $attr array.
                    $img_html = wp_get_attachment_image($banner_img, 'full', false, array(
                        'alt' => esc_attr(get_the_title()),
                        'class' => 'home2-banner-img',
                        'style' => 'width:100%;height:auto;display:block;border-radius:6px;box-shadow:0 2px 8px rgba(0,0,0,0.08);'
                    ));

                    echo '<li>';
                    if (!empty($banner_url)) {
                        echo '<a href="' . esc_url($banner_url) . '" rel="noopener noreferrer">' . $img_html . '</a>';
                    } else {
                        echo $img_html;
                    }
                    echo '</li>';
                }
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </ul>
</div>
<style>
.home2-banner-img {
    transition: opacity 0.2s;
}
.home2-banner-img:hover {
    opacity: 0.85;
}
</style>


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

?>

<a href="#" class="home-page-shortcut-btn">首頁捷徑</a></div>
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">



  


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