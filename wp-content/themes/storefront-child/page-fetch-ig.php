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

get_header(); ?>

<?php
echo do_shortcode( '[instagram-feed num=8 followcolor=#d5418d cols=4 colsmobile=1 showcaption=false imageres=full carouselarrows=true width=100 widthunit=% imagepadding=0 showheader=true layout=carousel carouselrows=1 carouselautoplay=true carouseltime=4000]');

 ?>


<style media="screen">
  #masthead,
  #sb_instagram .sb_instagram_header,
  .storefront-breadcrumb,
  .site-footer,
  #sb_instagram #sbi_load
  {
    display: none;
  }

  .site-content .col-full {
    max-width: 100%;
    /* max-width: 66.4989378333em; */
    padding: 0px;
  }

  @media (max-width: 66.4989378333em)
{
  .col-full
  {
      margin: 0px;
  }

  }
</style>
<?php
//do_action( 'storefront_sidebar' );
get_footer();
?>
