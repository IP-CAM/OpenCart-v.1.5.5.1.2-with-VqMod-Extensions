
<?php if ($use_scrolling_panel) { ?>
<style type="text/css">
.jcarousel-skin-opencart .jcarousel-container-vertical {
    height: 405px;
}
.jcarousel-skin-opencart .jcarousel-clip-vertical {
    height: 405px;
}
</style>
<div class="box">
  <div class="box-heading"><?php echo $heading_title; ?></div>
  <div class="box-content" style="padding:5px;">
	<div class="box_column_filter" id="box_column_filter<?php echo $module; ?>">
		<?php if(!empty($products)){?>
		<ul class="jcarousel-skin-opencart">
		  <?php foreach ($products as $product) { ?>
			<li>  <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
				<?php if ($product['thumb']) { ?>
				<div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
				<?php } ?>
				<div class="detail">
				
				<?php if ($product['price']) { ?>
        <div class="price">
          <?php if (!$product['special']) { ?>
          <?php echo $product['price']; ?>
          <?php } else { ?>
          <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
          <?php } ?>
        </div>
        <?php } ?>
        <?php if ($product['rating']) { ?>
        <div class="rating"><img src="catalog/view/theme/raspberry/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
        <?php } ?>
        <div class="cart"><input type="button" value="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button" /></div>
       	</div>
			</li>
		  <?php } ?>
		</ul>
		<?php } ?>
	</div>
  </div>
</div>
<script type="text/javascript"><!--
$('#box_column_filter<?php echo $module; ?> .jcarousel-skin-opencart').jcarousel({
	vertical: true,
	visible: <?php echo $scroll ?>,
	scroll: <?php echo $scroll ?>
});
//--></script>
 <?php } else { ?>
<div class="box">
<div class="box-heading"><?php echo $heading_title; ?></div>
<div class="box-content" id="carousel_f">
    <ul class="jcarousel-skin-opencart">
      <?php foreach ($products as $product) { ?>
      <li>
        <?php if ($product['thumb']) { ?>
        <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
        <?php } ?>
        <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
        <div class="description"><?php echo $product['description']; ?></div>
        <?php if ($product['price']) { ?>
        <div class="price">
          <?php if (!$product['special']) { ?>
          <?php echo $product['price']; ?>
          <?php } else { ?>
          <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
          <?php } ?>
        </div>
        <?php } ?>
        <?php if ($product['rating']) { ?>
        <div class="rating"><img src="catalog/view/theme/raspberry/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
        <?php } ?>
        <div class="cart"><input type="button" value="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button" /></div>
         </li>
      <?php } ?>
    </ul>
  </div>
  <script type="text/javascript"><!--
$('#carousel_f ul').jcarousel({
	vertical: false,
	visible: <?php echo $scroll ?>,
	scroll: <?php echo $scroll ?>
});
//--></script>

<?php } ?>
