<?php if(count($news_all) > 0 ) { ?>
<div class="box box-main-news">
  <div class="box-heading2"><?php echo $heading_title; ?></div>
  <div class="box-content2">
     <?php if ($style == 'short') {?>
          <?php foreach ($news_all as $news) { ?>
            <div class="news-view-short">
                <div class="news-date"><?php echo $news['date']; ?></div>
                <div class="news-caption"><a href="<?php echo $news['href']; ?>"><?php echo $news['caption']; ?></a></div>
            </div>
          <?php } ?>
     <?php } elseif ( $style == 'list' ) {?>
        <div class="news-view-list">
        <?php foreach ($news_all as $news) { ?>
            <div class="news-view-row">
                <div class="news-view-cell"></div>
                <div class="news-view-cell">
                    <?php if ($news['thumb']) { ?><a href="<?php echo $news['href']; ?>"><img src="<?php echo $news['thumb']; ?>" title="<?php echo $news['caption']; ?>" alt="<?php echo $news['caption']; ?>" /></a><?php } ?>
                        <div class="news-caption"><a href="<?php echo $news['href']; ?>"><?php echo $news['caption']; ?></a></div>
                        <div class="news-description"><?php echo $news['description']; ?></div>
                </div>
            </div>
        <?php } ?>
        </div>
    <?php } else {?>
        <div class="news-view-table">
        <?php foreach ($news_all as $news) { ?>
            <div class="news-view-cell" style="width: <?php echo $col_width; ?>%">
            <?php if ($news['thumb_small']) { ?><a href="<?php echo $news['href']; ?>"><img src="<?php echo $news['thumb_small']; ?>" title="<?php echo $news['caption']; ?>" alt="<?php echo $news['caption']; ?>" /></a><?php } ?>
            <div class="news-date"><?php echo $news['date']; ?></div>
            <div class="news-caption"><a href="<?php echo $news['href']; ?>"><?php echo $news['caption']; ?></a></div>
            </div>
        <?php } ?>
        </div>
    <?php } ?>
  </div>
</div>
<?php } ?>