<?php
/**
 * Single product short description
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/short-description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  Automattic
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;

$short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );

if ( ! $short_description ) {
	return;
}

?>



<?php

$show_covid = get_field('show-covid');
if ($show_covid === NULL || $show_covid) {
?>

<div class="show-covid">
    <b>訂貨一般貨品預計2-3星期到貨</b>
</div>

<?php
}

?>
<br>
<div class="woocommerce-product-details__short-description">
    <?php
	echo $short_description;
	// WPCS: XSS ok. ?>
</div>

<script type="text/javascript">
$(function() {
    if ($('.woocommerce-product-details__short-description p').html() == '.') {
        $('.woocommerce-product-details__short-description').fadeOut(0);
    }
})
</script>
<div class="" style="margin-top:20px;">
    <span style="font-weight:bold;">下單前請先細閱：</span> <br> <br>

    <span style="color:#d5418d;font-weight:bold;">訂貨程序：</span> <br>
    ・網站內選購貨品後Checkout , 再付款確認訂單(未入數訂單未能成立) <br>
    ・可以credit card (3.5% charge) / FPS / Online Ebanking / ATM<br>
    ・貨到後會Wts通知大家<br>
    ・兩星期內取貨 1/ 門市自取 或 2/順豐到付<br>
    ・如缺貨會通知退款<br>
    ・如太耐未收到通知 煩請聯絡我們 以免漏單<br><br>

    <span style="color:#d5418d;font-weight:bold;">😘溫提：</span><br>
    ・貨品如未到貨 恕未能每日更新 可隨時Wts查詢訂單<br>
    ・貨品會因天氣問題到貨期不穩定 請見諒 恕不接急單 <br>
    ・到貨後 如超過2星期未取貨, 並沒通知DJS, 訂單會自動動取消 不另通知 請見諒 <br><br>


    <span style="color:#d5418d;font-weight:bold;">注意：</span><br>
    因日圓浮動或日本不定期on sale，網站顯示的貨物價錢有機會隨時變動<br><br>

    <span style="color:#d5418d;font-weight:bold;">門市地址:</span><br>
    ・觀塘 62號駿業街 京貿中心 2樓E<br>
    ・Tue-Sat 3-8pm / Sun 2-6pm<br>
    ・任何查詢可聯絡 Wts: 94444920<br><br>


    <!-- <span style="color:#d5418d;font-weight:bold;">取貨方式：</span> <br><br>

[1] 順豐到付 站/櫃/便利店/上門<br>
請提供地址 + 收件人姓名<br><br>

[2] 小屋取貨 存貨期3星期🙌🏼🙌🏼<br>
❇️來前請通知方便執定貨及確認開放<br><br>

💛小屋逄星期3-6開 周一例休<br>
🎪觀塘巧明街105號 好運大廈8樓C3<br>
💛星期2/3/4/5 ｜ 4-8pm<br>
💛星期6/日 ｜ 3-7pm<br><br>

😘😘溫提：如超過3星期未取貨並沒通知DJS/貨品會取消或需再訂 -->
</div>