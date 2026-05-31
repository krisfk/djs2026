<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */

?>

		</div><!-- .col-full -->
	</div><!-- #content -->
<?

// echo 121;
// echo is_front_page();
// echo is_home();

if(is_front_page())
{
	// echo do_shortcode( '[instagram-feed id="1297773553" type="mixed" showlikes=false showcaption=false layout=carousel carouselrows=2 cols=8 colsmobile=4 disablelightbox=false]' );
//	echo do_shortcode( '[instagram-feed id="1297773553" showlikes=false showcaption=false layout=carousel carouselrows=2 cols=8 colsmobile=4 disablelightbox=false]' );

}

 ?>



 <?php do_action( 'storefront_before_footer' ); ?>



 <footer id="colophon" class="site-footer" role="contentinfo">
 	<div class="col-full">

 		<?php
 		/**
 		 * Functions hooked in to storefront_footer action
 		 *
 		 * @hooked storefront_footer_widgets - 10
 		 * @hooked storefront_credit         - 20
 		 */
 		do_action( 'storefront_footer' );
 		?>

 	</div><!-- .col-full -->
 </footer><!-- #colophon -->

 <?php do_action( 'storefront_after_footer' ); ?>

 <?php


 wp_footer();

  ?>



</div><!-- #page -->

<?php
// echo 999;
// $categories = get_the_category();
// $category_id = $categories[0]->cat_ID;
// echo $category_id;
 ?>

</body>
</html>
