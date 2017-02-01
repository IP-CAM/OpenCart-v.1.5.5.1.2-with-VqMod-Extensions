<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $h1; ?></h1>
  <?php if(isset($news_id)) { ?>
<div id="news-date"><?php echo $text_date_added; ?><?php echo $date; ?></div>
  <?php echo $content; ?>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><span><?php echo $button_continue; ?></span></a></div>
  </div>
<!-- lightbox -->
<?php if($lightbox) { ?>
<script type="text/javascript"><!--
$(document).ready(function() {
    $('.colorbox').colorbox({
	overlayClose: true,
	opacity: 0.5
    });
});
//--></script> 
<?php } ?>

  <?php } else {?>
  	
  <?php if ($news_all) { ?>
  
  <div class="product-filter">

    <div class="limit"><b><?php echo $text_limit; ?> </b>
      <select onchange="location = this.value;">
        <?php foreach ($limits as $limits) { ?>
        <?php if ($limits['value'] == $limit) { ?>
        <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
        <?php } ?>
        <?php } ?>
      </select>
    </div>
  </div>
  <div>&nbsp;</div>
  
  <div class="news-view-list">
 	<?php foreach ($news_all as $news) { ?>
      	<div class="news-view-row">
      	
      	<div class="news-view-cell">
      	<?php if ($news['thumb']) { ?><a href="<?php echo $news['href']; ?>"><img src="<?php echo $news['thumb']; ?>" title="<?php echo $news['caption']; ?>" alt="<?php echo $news['caption']; ?>" /></a><?php } ?>
      	</div>
      	<div class="news-view-cell">
		<div class="news-caption"><a href="<?php echo $news['href']; ?>"><?php echo $news['caption']; ?></a></div>
		
		<div class="news-description"><?php echo $news['description']; ?></div>
		<div class="news-date"><?php echo $text_date_added; ?> <?php echo $news['date']; ?></div>
		</div>
		</div>
		
    <?php } ?>
    </div>
  
  <?php } ?>	
  <div class="pagination"><?php echo $pagination; ?></div>	
  <?php } ?>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>