<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/news.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="location = '<?php echo $insert; ?>'" class="button"><span><?php echo $button_insert; ?></span></a><a onclick="$('form').submit();" class="button"><span><?php echo $button_delete; ?></span></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="center"><?php if ($sort == 'n.date_start') { ?>
                <a href="<?php echo $sort_date_start; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_start; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_date_start; ?>"><?php echo $column_date_start; ?></a>
                <?php } ?></td>
    		<td class="center"><?php echo $column_date_end; ?></td>
              <td class="left"><?php if ($sort == 'nd.caption') { ?>
                <a href="<?php echo $sort_caption; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_caption; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_caption; ?>"><?php echo $column_caption; ?></a>
                <?php } ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($newss) { ?>
            <?php foreach ($newss as $news) { ?>
            <?php 
            if(!$news['status']) { 
        		$style = 'style="color:grey;"';
            } else {
        		$style = '';
            }
            ?>
            <tr>
              <td style="text-align: center;"><?php if ($news['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $news['news_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $news['news_id']; ?>" />
                <?php } ?></td>
              <td class="center" <?php echo $style;?> width="120"><?php echo $news['date_start']; ?></td>
              <td class="center" <?php echo $style;?> width="120"><?php echo $news['date_end']; ?></td>
              <td class="left" <?php echo $style;?>><?php foreach ($news['action'] as $action) { ?>
                <a<?php if(!$news['status'])echo ' style="color:#999999;"';?> href="<?php echo $action['href']; ?>"><b><?php echo $news['caption']; ?></b></a> 
                <?php } ?></td>
              <td class="right"><?php foreach ($news['action'] as $action) { ?>
                [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                <?php } ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<?php echo $footer; ?>