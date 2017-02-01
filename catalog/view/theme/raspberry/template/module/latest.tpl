<div class="box">
  <div class="box-heading"><?php echo $heading_title; ?></div>
  <div class="box-content1" id="carousel_f">
    <ul class="jcarousel-skin-opencart">
      <?php foreach ($products as $product) { ?>
      <li>
        <?php if ($product['thumb']) { ?>
        <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
        <?php } ?>
        <!-- <div class="rating"><img src="catalog/view/theme/raspberry/image/stars-<?= (int)$product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div> -->
        <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
        <?php if ($product['price']) { ?>
        <div class="price">
          <?php if (!$product['special']) { ?>
          <?php echo $product['price']; ?>
          <?php } else { ?>
          <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
          <?php } ?>
        </div>
        <?php } ?>
        <div class="cart"><input type="button" value="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button" /></div>
         <div class="wish-comp"><span class="wishlist"><a onclick="addToWishList('<?php echo $product['product_id']; ?>');" title="<?php echo $this->language->get('button_wishlist'); ?>">В закладки</a></span>
       <span class="compare"><a onclick="addToCompare('<?php echo $product['product_id']; ?>');" title="<?php echo $this->language->get('button_compare'); ?>">В сравнение</a></span></div>
           </li>
      <?php } ?>
    </ul>
  </div>
</div>
<script type="text/javascript"><!--
$('#carousel_f ul').jcarousel({
  vertical: false,
  visible: <?php echo $limit; ?>,
//  scroll: <?php //echo $scroll; ?>//,
  visible: 5,
  circular: true,
  auto: 2,
  wrap: 'last'
});
//--></script>
