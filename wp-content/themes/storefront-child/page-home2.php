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

$(function(){

$('.home-page-shortcut-btn').click(function(e){
e.preventDefault();
$(this).toggleClass('active');

if($(this).hasClass('active'))
{
	$('.home-page-shortcut-ul').fadeIn(300);
}
else{
	$('.home-page-shortcut-ul').fadeOut(0);
}



});

$('.home-cate-shortcut-link').click(function(e){

	e.preventDefault();
	$('.home-page-shortcut-btn').removeClass('active');
	$('.home-page-shortcut-ul').fadeOut(0);
	var idx=$(this).attr('data-link');
	// alert(idx);
	$('body,html').stop().animate({scrollTop: $('.home-cate-'+idx).offset().top-10},{duration:500,complete:function(){}} );




})
});
</script>
<div class="home-page-shortcut-blk"><?php $query=new WP_Query(array('post_type'=> 'hp_products_grp'));

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

?><a href="#"class="home-page-shortcut-btn">首頁捷徑</a></div><div id="primary"class="content-area"><main id="main"class="site-main"role="main"><?php if (have_posts()) : get_template_part('loop');
else : get_template_part('content', 'none');
endif;
?><?php //echo do_shortcode( '[instagram-feed hashtag="#alice"]' );
//[instagram-feed user="djsshopping" id="1297773553" includewords="#alice" num=1 cols=1]
// echo do_shortcode('[instagram-feed user="djsshopping" id="1297773553" includewords="#妙妙貓" cols=4 num=4 media=photos showheader=false showcaption=false]');
?><h2 class="page-title home-cate-10">- 最新系列 - </h2><?php echo do_shortcode('[slick-carousel-slider category="148" design="design-6" slidestoshow="3"]');
echo do_shortcode('[slick-carousel-slider category="146" design="design-6" slidestoshow="3"]');
echo do_shortcode('[slick-carousel-slider category="147" design="design-6" slidestoshow="3"]');
?><?php $terms=get_terms(array('taxonomy'=> 'product_tag', 'hide_empty'=> false));

?><h2 class="page-title home-cate-11">- 角色分類 - </h2><div class="product-tags"><?php foreach ($terms as $term) {
  ?><a href="<?php echo get_term_link($term->term_id, 'product_tag'); ?> "rel="tag"><?php echo $term->name;
  ?></a><?php
}

?></div>

<?php $query=new WP_Query(array('post_type'=> 'hp_products_grp'));

if ($query->have_posts()) {
  while ($query->have_posts()) {
    $query->the_post();
    echo '	<div class="clear-line"></div>';
    //				$slug = basename( get_permalink() );
    //					echo get_the_ID();
    echo'<h2 class="page-title home-cate-'.get_the_ID().'">- '.get_the_title().' - <a href="'.get_field('link_to').'">View all </a> -</h2>';
    $group_tag=get_field('group_tag')->slug;
    $group_category=get_field('group_category')->slug;
    echo do_shortcode('[products tag="'.$group_tag.'" category="'.$group_category.'" limit="18" columns="6" visibility="visible" orderby="menu_order" order="ASC"]');
  }
}

?></main></div>
<img src="https://cdns7.shopdisney.disney.co.jp/is/image/ShopDisneyJPPI/4936313903980-3" alt="">
<?php do_action('storefront_sidebar');
get_footer();
