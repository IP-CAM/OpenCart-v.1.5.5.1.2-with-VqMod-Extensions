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
<div class="box">
  <div class="heading">
    <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
	  <div class="vtabs">
	      <?php $module_row = 1; ?>
	      <?php foreach ($modules as $module) { ?>
	      <a href="#tab-module-<?php echo $module_row; ?>" onclick="$('#languages-<?php echo $module_row; ?> a:first').trigger('click')" id="module-<?php echo $module_row; ?>"><?php echo $tab_module . ' ' . $module_row; ?>&nbsp;<img src="view/image/delete.png" alt="" onclick="$('.vtabs a:first').trigger('click'); $('#module-<?php echo $module_row; ?>').remove(); $('#tab-module-<?php echo $module_row; ?>').remove(); return false;" /></a>
	      <?php $module_row++; ?>
	      <?php } ?>
	      <span id="module-add"><?php echo $button_add_module; ?>&nbsp;<img src="view/image/add.png" alt="" onclick="addModule();" /></span> 
	  </div>
	  <?php $module_row = 1; ?>
    <?php foreach ($modules as $module) { ?>
	  <div id="tab-module-<?php echo $module_row; ?>" class="vtabs-content">
      <div id="languages-<?php echo $module_row; ?>" class="htabs">
        <?php foreach ($languages as $language) { ?>
        <a href="#tab-module-<?php echo $module_row; ?>-language-<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
        <?php } ?>
      </div>
      <?php foreach($languages as $language) { ?>
      <div id="tab-module-<?php echo $module_row; ?>-language-<?php echo $language['language_id']; ?>">
        <table class="form">
          <tr>
            <td class="left"><?php echo $entry_caption; ?></td>
            <td class="left">
              <input type="text" name="productcarousel_module[<?php echo $module_row; ?>][language][<?php echo $language['language_id']; ?>][caption]" value="<?php echo $module['language'][$language['language_id']]['caption']; ?>" size="40" />
            </td>
          </tr>
        </table>
      </div>
      <?php } ?>
      <table class="form">
      <tr>
        <td class="left"><?php echo $entry_source; ?></td>
        <td class="left">
        <select name="productcarousel_module[<?php echo $module_row; ?>][source_id]" onchange="ProductSourceChange(this, <?php echo $module_row; ?>);">
          <?php foreach ($sources as $source) { ?>
          <?php if ($source['source_id'] == $module['source_id']) { ?>
          <option value="<?php echo $source['source_id']; ?>" selected="selected"><?php echo $source['name']; ?></option>
          <?php } else { ?>
          <option value="<?php echo $source['source_id']; ?>"><?php echo $source['name']; ?></option>
          <?php } ?>
          <?php } ?>
        </select>
        </td>
      </tr>
      <tr id="productcarousel_module_sourcecustom_<?php echo $module_row; ?>" <?php if ($module['source_id'] != '1') {?>style="display:none"<?php }?> >
        <td class="left"><?php echo $text_source_custom; ?></td>
        <td class="left">
          <table class="form">
          <tr>
            <td colspan="2"><p><?php echo $note_source_custom; ?></p></td> 
          </tr>	
          <tr>
		        <td><?php echo $entry_product; ?></td>
		        <td><input type="text" row="<?php echo $module_row; ?>" class="product-autocomplete" value="" size="50" /></td>
          </tr>
          <tr>
		       <td>&nbsp;</td>
		       <td>
            <div class="scrollbox" id="source-products-<?php echo $module_row; ?>">
		          <?php $class = 'odd'; ?>
		          <?php foreach ($module['products'] as $product) { ?>
		          <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
		          <div id="source-products-<?php echo $module_row; ?>-<?php echo $product['product_id']; ?>" class="<?php echo $class; ?>"><?php echo $product['name']; ?> <img src="view/image/delete.png" row="<?php echo $module_row; ?>" />
		            <input type="hidden" value="<?php echo $product['product_id']; ?>" />
		          </div>
		          <?php } ?>
		        </div>
		        <input type="hidden" name="productcarousel_module[<?php echo $module_row; ?>][source_products]" value="<?php echo $module['source_products']; ?>" />
           </td>
          </tr>
  	  		</table>
        </td>		
      </tr>
      <tr id="productcarousel_module_sourcecategory_<?php echo $module_row; ?>" <?php if ($module['source_id'] != '5') {?>style="display:none"<?php }?>>
        <td class="left"><?php echo $entry_category; ?></td>
        <td class="left">
						<input type="hidden" name="productcarousel_module[<?php echo $module_row; ?>][category_id]" value="<?php echo $module['category_id']; ?>" />
            <select name="productcarousel_module[<?php echo $module_row; ?>][category]" <?php if ($module['category_id'] == '-1'){ ?>disabled="disabled"<?php } ?> onchange="var inp = document.getElementsByName('productcarousel_module[<?php echo $module_row; ?>][category_id]'); inp[0].value = this.value;" >
							<option value="-1" <?php if ($module['category_id'] == '-1'){ ?>selected="selected"<?php } ?>></option>
              <option value="0" <?php if ($module['category_id'] == '0'){ ?>selected="selected"<?php } ?>><?php echo $text_all_category; ?></option>
              <?php foreach ($categories as $category) { ?>
              <?php if ($category['category_id'] == $module['category_id']) { ?>
              <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
              <?php } ?>
              <?php } ?>
          </select>
        </td>
      </tr>
			<tr id="productcarousel_module_sourcemulticategory_<?php echo $module_row; ?>" <?php if ($module['source_id'] != '9') {?>style="display:none"<?php }?>>
        <td class="left"><?php echo $entry_categories; ?></td>
        <td class="left">
            <div class="scrollbox">
              <?php $class = 'odd'; ?>
              <?php foreach ($categories as $category) { ?>
              <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
              <?php if (in_array($category['category_id'],$module['category'])) { ?>
							<input type="checkbox" name="productcarousel_module[<?php echo $module_row; ?>][category][]" value="<?php echo $category['category_id']; ?>" checked="checked" /><?php echo $category['name'];?><br/>
              <?php } else { ?>
							<input type="checkbox" name="productcarousel_module[<?php echo $module_row; ?>][category][]" value="<?php echo $category['category_id']; ?>" /><?php echo $category['name'];?><br/>
              <?php } ?>
							<?php } ?>
            </div>
        </td>
      </tr>
			<tr id="productcarousel_module_manufacturer_<?php echo $module_row; ?>" <?php if ($module['source_id'] != '10') {?>style="display:none"<?php }?>>
        <td class="left"><?php echo $entry_manufacturer; ?></td>
        <td class="left">
            <div class="scrollbox">
              <?php $class = 'odd'; ?>
              <?php foreach ($manufacturers as $manufacturer) { ?>
              <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
              <?php if (in_array($manufacturer['manufacturer_id'],$module['manufacturer'])) { ?>
							<input type="checkbox" name="productcarousel_module[<?php echo $module_row; ?>][manufacturer][]" value="<?php echo $manufacturer['manufacturer_id']; ?>" checked="checked" /><?php echo $manufacturer['name'];?><br/>
              <?php } else { ?>
							<input type="checkbox" name="productcarousel_module[<?php echo $module_row; ?>][manufacturer][]" value="<?php echo $manufacturer['manufacturer_id']; ?>" /><?php echo $manufacturer['name'];?><br/>
              <?php } ?>
							<?php } ?>
            </div>
        </td>
      </tr>
      <tr>
        <td class="left"><?php echo $entry_show_name; ?></td>
        <td class="left">	
          <select name="productcarousel_module[<?php echo $module_row; ?>][show_name]">
            <?php if ($module['show_name'] == "0") { ?>
            <option value="0" selected="selected"><?php echo $text_no; ?></option>
            <option value="1"><?php echo $text_yes; ?></option>
            <?php } else { ?>
            <option value="0"><?php echo $text_no; ?></option>
            <option value="1" selected="selected"><?php echo $text_yes; ?></option>
            <?php } ?>
          </select>
        </td>
      </tr>	
      <tr>	
        <td class="left"><?php echo $entry_show_price; ?></td>
        <td class="left">
          <select name="productcarousel_module[<?php echo $module_row; ?>][show_price]">
            <?php if ($module['show_price'] == "0") { ?>
            <option value="0" selected="selected"><?php echo $text_no; ?></option>
            <option value="1"><?php echo $text_yes; ?></option>
            <?php } else { ?>
            <option value="0"><?php echo $text_no; ?></option>
            <option value="1" selected="selected"><?php echo $text_yes; ?></option>
            <?php } ?>
          </select>
        </td>
      </tr>	
      <tr>
        <td class="left"><?php echo $entry_show_cart; ?></td>
        <td class="left">	
          <select name="productcarousel_module[<?php echo $module_row; ?>][show_cart]">
            <?php if ($module['show_cart'] == "0") { ?>
            <option value="0" selected="selected"><?php echo $text_no; ?></option>
            <option value="1"><?php echo $text_yes; ?></option>
            <?php } else { ?>
            <option value="0"><?php echo $text_no; ?></option>
            <option value="1" selected="selected"><?php echo $text_yes; ?></option>
            <?php } ?>
          </select>
        </td>
      </tr>			
      <tr>
        <td class="left"><?php echo $entry_enabled_popup; ?></td>
        <td class="left">	
          <select name="productcarousel_module[<?php echo $module_row; ?>][enabled_popup]">
            <?php if (isset($module['enabled_popup']) && $module['enabled_popup'] == "1") { ?>
            <option value="1" selected="selected"><?php echo $text_yes; ?></option>
            <option value="0"><?php echo $text_no; ?></option>
            <?php } else { ?>
            <option value="1"><?php echo $text_yes; ?></option>
            <option value="0" selected="selected"><?php echo $text_no; ?></option>
            <?php } ?>
          </select>
        </td>
      </tr>		
      <tr>	
        <td class="left"><?php echo $entry_popup_detail; ?></td>
        <td class="left">
          <select name="productcarousel_module[<?php echo $module_row; ?>][popup_detail]">
            <option value="0" <?php if (isset($module['popup_detail']) && $module['popup_detail'] == "0") { ?>selected="selected"<?php } ?>><?php echo $entry_popup_detail_no; ?></option>
            <option value="1" <?php if (isset($module['popup_detail']) && $module['popup_detail'] == "1") { ?>selected="selected"<?php } ?>><?php echo $entry_popup_detail_name; ?></option>
            <option value="2" <?php if (isset($module['popup_detail']) && $module['popup_detail'] == "2") { ?>selected="selected"<?php } ?>><?php echo $entry_popup_detail_price; ?></option>
            <option value="3" <?php if (isset($module['popup_detail']) && $module['popup_detail'] == "3") { ?>selected="selected"<?php } ?>><?php echo $entry_popup_detail_name_price; ?></option>		
          </select>
        </td>
      </tr>	
      <tr>
        <td class="left"><?php echo $entry_zoom_factor; ?></td>
        <td class="left">
          <select name="productcarousel_module[<?php echo $module_row; ?>][zoom_factor]">
		       <option value="0.0" <?php if (isset($module['zoom_factor']) && $module['zoom_factor'] == "0.0") { ?>selected="selected"<?php } ?>>0</option>
		       <option value="0.1" <?php if (isset($module['zoom_factor']) && $module['zoom_factor'] == "0.1") { ?>selected="selected"<?php } ?>>10%</option>
		       <option value="0.2" <?php if (isset($module['zoom_factor']) && $module['zoom_factor'] == "0.2") { ?>selected="selected"<?php } ?>>20%</option>
		       <option value="0.3" <?php if (isset($module['zoom_factor']) && $module['zoom_factor'] == "0.3") { ?>selected="selected"<?php } ?>>30%</option>
		       <option value="0.4" <?php if (isset($module['zoom_factor']) && $module['zoom_factor'] == "0.4") { ?>selected="selected"<?php } ?>>40%</option>
           <option value="0.5" <?php if (isset($module['zoom_factor']) && $module['zoom_factor'] == "0.5") { ?>selected="selected"<?php } ?>>50%</option>
		       <option value="0.6" <?php if (isset($module['zoom_factor']) && $module['zoom_factor'] == "0.6") { ?>selected="selected"<?php } ?>>60%</option>
		       <option value="0.7" <?php if (isset($module['zoom_factor']) && $module['zoom_factor'] == "0.7") { ?>selected="selected"<?php } ?>>70%</option>
           <option value="0.8" <?php if (isset($module['zoom_factor']) && $module['zoom_factor'] == "0.8") { ?>selected="selected"<?php } ?>>80%</option>
	         <option value="0.9" <?php if (isset($module['zoom_factor']) && $module['zoom_factor'] == "0.9") { ?>selected="selected"<?php } ?>>90%</option>
			     <option value="1.0" <?php if (isset($module['zoom_factor']) && $module['zoom_factor'] == "1.0") { ?>selected="selected"<?php } ?>>100%</option>
			     <option value="1.1" <?php if (isset($module['zoom_factor']) && $module['zoom_factor'] == "1.1") { ?>selected="selected"<?php } ?>>110%</option>
			     <option value="1.2" <?php if (isset($module['zoom_factor']) && $module['zoom_factor'] == "1.2") { ?>selected="selected"<?php } ?>>120%</option>
		       <option value="1.3" <?php if (isset($module['zoom_factor']) && $module['zoom_factor'] == "1.3") { ?>selected="selected"<?php } ?>>130%</option>
			     <option value="1.4" <?php if (isset($module['zoom_factor']) && $module['zoom_factor'] == "1.4") { ?>selected="selected"<?php } ?>>140%</option>	
			     <option value="1.5" <?php if (isset($module['zoom_factor']) && $module['zoom_factor'] == "1.5") { ?>selected="selected"<?php } ?>>150%</option>
			     <option value="2.0" <?php if (isset($module['zoom_factor']) && $module['zoom_factor'] == "2.0") { ?>selected="selected"<?php } ?>>200%</option>	 
			     <option value="2.5" <?php if (isset($module['zoom_factor']) && $module['zoom_factor'] == "2.5") { ?>selected="selected"<?php } ?>>250%</option>
			     <option value="3.0" <?php if (isset($module['zoom_factor']) && $module['zoom_factor'] == "3.0") { ?>selected="selected"<?php } ?>>300%</option>
			     <option value="4.0" <?php if (isset($module['zoom_factor']) && $module['zoom_factor'] == "4.0") { ?>selected="selected"<?php } ?>>400%</option>
			     <option value="5.0" <?php if (isset($module['zoom_factor']) && $module['zoom_factor'] == "5.0") { ?>selected="selected"<?php } ?>>500%</option>	
		      </select>
	      </td>
	    </tr>
      <tr>
        <td class="left"><?php echo $entry_random; ?></td>
        <td class="left">
          <select name="productcarousel_module[<?php echo $module_row; ?>][random]">
            <?php if (isset($module['random']) && $module['random'] == "1") { ?>
            <option value="1" selected="selected"><?php echo $text_yes; ?></option>
            <option value="0"><?php echo $text_no; ?></option>
            <?php } else { ?>
            <option value="1"><?php echo $text_yes; ?></option>
            <option value="0" selected="selected"><?php echo $text_no; ?></option>
            <?php } ?>
          </select>
        </td>
      </tr>
      <tr>
        <td class="left"><?php echo $entry_cache_enabled; ?></td>
        <td class="left">
          <select name="productcarousel_module[<?php echo $module_row; ?>][cache_enabled]">
            <?php if (isset($module['cache_enabled']) && $module['cache_enabled'] == "1") { ?>
            <option value="1" selected="selected"><?php echo $text_yes; ?></option>
            <option value="0"><?php echo $text_no; ?></option>
            <?php } else { ?>
            <option value="1"><?php echo $text_yes; ?></option>
            <option value="0" selected="selected"><?php echo $text_no; ?></option>
            <?php } ?>
          </select>
        </td>
      </tr>
      <tr>
        <td class="left"><?php echo $entry_display_view_all; ?></td>
        <td class="left">
          <select name="productcarousel_module[<?php echo $module_row; ?>][display_view_all]">
            <?php if (isset($module['display_view_all']) && $module['display_view_all'] == "1") { ?>
            <option value="1" selected="selected"><?php echo $text_yes; ?></option>
            <option value="0"><?php echo $text_no; ?></option>
            <?php } else { ?>
            <option value="1"><?php echo $text_yes; ?></option>
            <option value="0" selected="selected"><?php echo $text_no; ?></option>
            <?php } ?>
          </select>
        </td>
      </tr>
      <tr>
        <td class="left"><?php echo $entry_limit; ?></td>
        <td class="left">
          <input type="text" name="productcarousel_module[<?php echo $module_row; ?>][limit]" value="<?php echo $module['limit']; ?>" size="2" />
        </td>
      </tr>
      <tr>
        <td class="left"><?php echo $entry_scroll_limit; ?></td>
        <td class="left">
          <input type="text" name="productcarousel_module[<?php echo $module_row; ?>][scroll_limit]" value="<?php echo $module['scroll_limit']; ?>" size="2" />
        </td>
      </tr>
      <tr>
        <td class="left"><?php echo $entry_image; ?></td>
        <td class="left">
          <input type="text" name="productcarousel_module[<?php echo $module_row; ?>][image_width]" value="<?php echo $module['image_width']; ?>" size="3" />
          <input type="text" name="productcarousel_module[<?php echo $module_row; ?>][image_height]" value="<?php echo $module['image_height']; ?>" size="3" />
          <?php if (isset($error_image[$module_row])) { ?>
          <span class="error"><?php echo $error_image[$module_row]; ?></span>
          <?php } ?>
        </td>
      </tr>
      <tr>
        <td class="left"><?php echo $entry_scroll; ?></td>
        <td class="left">
          <input type="text" name="productcarousel_module[<?php echo $module_row; ?>][scroll]" value="<?php echo $module['scroll']; ?>" size="3" />
        </td>
      </tr>	
      <tr>
        <td class="left"><?php echo $entry_axis; ?></td>
        <td class="left">
          <select name="productcarousel_module[<?php echo $module_row; ?>][axis]">
            <?php if ($module['axis'] == "0") { ?>
            <option value="0" selected="selected"><?php echo $text_axis_orizzontal; ?></option>
            <option value="1"><?php echo $text_axis_vertical; ?></option>
            <?php } else { ?>
            <option value="0"><?php echo $text_axis_orizzontal; ?></option>
            <option value="1" selected="selected"><?php echo $text_axis_vertical; ?></option>
          <?php } ?>
          </select>
        </td>
      </tr>
      <tr>
        <td class="left"><?php echo $entry_autostart; ?></td>
        <td class="left">
          <select name="productcarousel_module[<?php echo $module_row; ?>][autostart]">
            <?php if ($module['autostart'] == "0") { ?>
            <option value="0" selected="selected"><?php echo $text_no; ?></option>
            <option value="1"><?php echo $text_yes; ?></option>
            <?php } else { ?>
            <option value="0"><?php echo $text_no; ?></option>
            <option value="1" selected="selected"><?php echo $text_yes; ?></option>
            <?php } ?>
          </select>
        </td>
      </tr>
      <tr>
        <td class="left"><?php echo $entry_animation; ?></td>
        <td class="left">
          <input type="text" name="productcarousel_module[<?php echo $module_row; ?>][animation]" value="<?php echo $module['animation']; ?>" size="5" />
        </td>
      </tr>
      <tr>
        <td class="left"><?php echo $entry_layout; ?></td>
        <td class="left">
          <select name="productcarousel_module[<?php echo $module_row; ?>][layout_id]">
            <?php foreach ($layouts as $layout) { ?>
            <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
            <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select>
        </td>
      </tr>
      <tr>
        <td class="left"><?php echo $entry_position; ?></td>
        <td class="left">
          <select name="productcarousel_module[<?php echo $module_row; ?>][position]">
            <?php if ($module['position'] == 'content_top') { ?>
            <option value="content_top" selected="selected"><?php echo $text_content_top; ?></option>
            <?php } else { ?>
            <option value="content_top"><?php echo $text_content_top; ?></option>
            <?php } ?>
            <?php if ($module['position'] == 'content_bottom') { ?>
            <option value="content_bottom" selected="selected"><?php echo $text_content_bottom; ?></option>
            <?php } else { ?>
            <option value="content_bottom"><?php echo $text_content_bottom; ?></option>
            <?php } ?>
            <?php if ($module['position'] == 'column_left') { ?>
            <option value="column_left" selected="selected"><?php echo $text_column_left; ?></option>
            <?php } else { ?>
            <option value="column_left"><?php echo $text_column_left; ?></option>
            <?php } ?>
            <?php if ($module['position'] == 'column_right') { ?>
            <option value="column_right" selected="selected"><?php echo $text_column_right; ?></option>
            <?php } else { ?>
            <option value="column_right"><?php echo $text_column_right; ?></option>
            <?php } ?>
          </select>
        </td>
      </tr>	
      <tr>
        <td class="left"><?php echo $entry_status; ?></td>
        <td class="left">
          <select name="productcarousel_module[<?php echo $module_row; ?>][status]">
            <?php if ($module['status']) { ?>
            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
            <option value="0"><?php echo $text_disabled; ?></option>
            <?php } else { ?>
            <option value="1"><?php echo $text_enabled; ?></option>
            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
            <?php } ?>
          </select>
        </td>
      </tr>	
      <tr>
        <td class="left"><?php echo $entry_sort_order; ?></td>
        <td class="left">
          <input type="text" name="productcarousel_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" />
        </td>
      </tr>				
	  </table>	
	  </div>
	  <?php $module_row++; ?>
    <?php } ?>
    </form>
  </div>
</div>
</div>
<script type="text/javascript">

	//$('div.vtabs-content').length; //
	var module_row = <?php echo $module_row; ?>;
	
	function addModule() {	

		html  = '<div id="tab-module-' + module_row + '" class="vtabs-content">';	
    html += '<div id="languages-' + module_row + '" class="htabs">';
    <?php foreach ($languages as $language) { ?>
    html += ' <a href="#tab-module-' + module_row + '-language-<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>';
    <?php } ?>
    html += '</div>';
    <?php foreach($languages as $language) { ?>
    html += '<div id="tab-module-' + module_row + '-language-<?php echo $language['language_id']; ?>">';
    html += ' <table class="form">';
    html += ' <tr>';
    html += '   <td class="left"><?php echo $entry_caption; ?></td>';
    html += '   <td class="left">';
    html += '     <input type="text" name="productcarousel_module[' + module_row + '][language][<?php echo $language['language_id']; ?>][caption]" value="" size="40" />';
    html += '   </td>';
    html += ' </tr>';
    html += ' </table>';
    html += '</div>';
    <?php } ?>
		html += '  <table class="form">';
		html += '  <tr>';
		html += '  <td class="left"><?php echo $entry_source; ?></td>';
		html += '  <td class="left">';
		html += '  	<select name="productcarousel_module[' + module_row + '][source_id]" onchange="ProductSourceChange(this, ' + module_row + ');">';
    <?php foreach ($sources as $source) { ?>
    html += '   <option value="<?php echo $source['source_id']; ?>"><?php echo $source['name']; ?></option>';
    <?php } ?>
		html += '  	</select>';
	  html += '  </td>';
	  html += '  </tr>';
		html += '  <tr id="productcarousel_module_sourcecustom_' + module_row + '">';
	  html += '  <td class="left"><?php echo $text_source_custom; ?></td>';
		html += '  <td class="left">';
		html += '  	   <table class="form">';
		html += '  	   <tr>';
		html += '  		   <td colspan="2"><?php echo $note_source_custom; ?></td>'; 
		html += '  	   </tr>';	
		html += '  	   <tr>';
		html += '          <td><?php echo $entry_product; ?></td>';
		html += '          <td><input type="text" row="' + module_row + '" class="product-autocomplete" value="" size="50" /></td>';
		html += '      </tr>';
		html += '      <tr>';
		html += '          <td>&nbsp;</td>';
		html += '          <td>';
		html += '  		 	  <div class="scrollbox" id="source-products-' + module_row + '"></div>';
		html += '             <input type="hidden" name="productcarousel_module[' + module_row + '][source_products]" value="" />';
		html += '  	       </td>';
		html += '      </tr>';
    html += '  	</table>';
		html += '  </td>';		
    html += '  </tr>';
		html += '  <tr id="productcarousel_module_sourcecategory_' + module_row + '">';
		html += '  <td class="left"><?php echo $entry_category; ?></td>';
		html += '  <td class="left">';
    html += '      <input type="hidden" name="productcarousel_module[' + module_row + '][category_id]" value="-1" />';
		html += '      <select name="productcarousel_module[' + module_row + '][category]" disabled="disabled" onchange="var inp = document.getElementsByName(\'productcarousel_module[' + module_row + '][category_id]\'); inp[0].value = this.value;" >';
		html += ' 	   <option value="-1" selected="selected"></option>';
									 <?php foreach ($categories as $category) { ?>
    html += '      <option value="<?php echo $category['category_id']; ?>"><?php echo addslashes($category['name']); ?></option>';
									 <?php } ?>
 		html += '      </select>';
		html += '  </td>';
    html += '  </tr>';
		html += '  <tr id="productcarousel_module_sourcemulticategory_' + module_row + '">';
		html += '  <td class="left"><?php echo $entry_categories; ?></td>';
		html += '  <td class="left">';
		html += '      <div class="scrollbox">';
									 <?php $class = 'odd'; ?>
							     <?php foreach ($categories as $category) { ?>
								   <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
    html += '      <input type="checkbox" name="productcarousel_module[<?php echo $module_row; ?>][category][]" value="<?php echo $category['category_id']; ?>" /><?php echo addslashes($category['name']); ?><br/>';
									 <?php } ?>
    html += '      </div>';
    html += '  </td>';
    html += '  </tr>';
		html += '  <tr id="productcarousel_module_manufacturer_' + module_row + '">';
		html += '  <td class="left"><?php echo $entry_manufacturer; ?></td>';
		html += '  <td class="left">';
		html += '      <div class="scrollbox">';
									 <?php $class = 'odd'; ?>
							     <?php foreach ($manufacturers as $manufacturer) { ?>
								   <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
    html += '      <input type="checkbox" name="productcarousel_module[<?php echo $module_row; ?>][manufacturer][]" value="<?php echo $manufacturer['manufacturer_id']; ?>" /><?php echo addslashes($manufacturer['name']); ?><br/>';
									 <?php } ?>
    html += '      </div>';
    html += '  </td>';
    html += '  </tr>';
		html += '  <tr>';
		html += '  <td class="left"><?php echo $entry_show_name; ?></td>';
		html += '  <td class="left">';
		html += '  	   <select name="productcarousel_module[' + module_row + '][show_name]">';
		html += '  	   <option value="0"><?php echo $text_no; ?></option>';
		html += '      <option value="1" selected="selected"><?php echo $text_yes; ?></option>';
		html += '      </select>';
    html += '  </td>';
    html += '  </tr>';			
    html += '  <tr>';
		html += '  <td class="left"><?php echo $entry_show_price; ?></td>';
		html += '  <td class="left">';
		html += '  	   <select name="productcarousel_module[' + module_row + '][show_price]">';
		html += '  	   <option value="0"><?php echo $text_no; ?></option>';
		html += '  	   <option value="1" selected="selected"><?php echo $text_yes; ?></option>';
		html += '  	   </select>';
		html += '  </td>';
    html += '  </tr>';
		html += '  <tr>';
		html += '  <td class="left"><?php echo $entry_show_cart; ?></td>';
		html += '  <td class="left">';
		html += '  	   <select name="productcarousel_module[' + module_row + '][show_cart]">';
		html += '  	   <option value="0"><?php echo $text_no; ?></option>';
		html += '  	   <option value="1" selected="selected"><?php echo $text_yes; ?></option>';
		html += '  	   </select>';
		html += '  </td>';
    html += '  </tr>';	
		html += '  <tr>';
		html += '  <td class="left"><?php echo $entry_enabled_popup; ?></td>';
		html += '  <td class="left">';
		html += '  	   <select name="productcarousel_module[' + module_row + '][enabled_popup]">';
		html += '      <option value="1"><?php echo $text_yes; ?></option>';
		html += '      <option value="0" selected="selected"><?php echo $text_no; ?></option>';
		html += '      </select>';
    html += '  </td>';
    html += '  </tr>';
    html += '  <tr>';
		html += '  <td class="left"><?php echo $entry_popup_detail; ?></td>';
		html += '  <td class="left">';
		html += '  	   <select name="productcarousel_module[' + module_row + '][popup_detail]">';
		html += '      <option value="0" selected="selected"><?php echo $entry_popup_detail_no; ?></option>';
		html += '      <option value="1"><?php echo $entry_popup_detail_name; ?></option>';
		html += '      <option value="2"><?php echo $entry_popup_detail_price; ?></option>';
		html += '      <option value="3"><?php echo $entry_popup_detail_name_price; ?></option>';
		html += '      </select>';
    html += '  </td>';
    html += '  </tr>';
		html += '  <tr>';
		html += '  <td class="left"><?php echo $entry_zoom_factor; ?></td>';
		html += '  <td class="left">';
		html += '  	   <select name="productcarousel_module[' + module_row + '][zoom_factor]">';
		html += '      <option value="0.0" selected="selected">0</option>';
		html += '      <option value="0.1">10%</option>';
		html += '      <option value="0.2">20%</option>';
		html += '      <option value="0.3">30%</option>';
		html += '      <option value="0.4">40%</option>';
    html += '      <option value="0.5">50%</option>';
		html += '      <option value="0.6">60%</option>';
		html += '      <option value="0.7">70%</option>';
    html += '      <option value="0.8">80%</option>';
    html += '      <option value="0.9">90%</option>';
		html += '      <option value="1.0">100%</option>';
		html += '      <option value="1.1">110%</option>';
		html += '      <option value="1.2">120%</option>';
		html += '      <option value="1.3">130%</option>';
		html += '      <option value="1.4">140%</option>';
		html += '      <option value="1.5">150%</option>';
		html += '      <option value="2.0">200%</option>';
		html += '      <option value="2.5">250%</option>';
		html += '      <option value="3.0">300%</option>';
		html += '      <option value="4.0">400%</option>';
		html += '      <option value="5.0">500%</option>';
		html += '      </select>';
    html += '  </td>';
    html += '  </tr>';
		html += '  <tr>';
		html += '  <td class="left"><?php echo $entry_random; ?></td>';
		html += '  <td class="left">';
		html += '    	<select name="productcarousel_module[' + module_row + '][random]">';
		html += '  		<option value="1" selected="selected"><?php echo $text_yes; ?></option>';
		html += '  		<option value="0"><?php echo $text_no; ?></option>';
		html += '  		</select>';
    html += '  </td>';
    html += '  </tr>';
    html += '  <tr>';
    html += '  <td class="left"><?php echo $entry_cache_enabled; ?></td>';
		html += '  <td class="left">';
		html += '    	<select name="productcarousel_module[' + module_row + '][cache_enabled]">';
		html += '  		<option value="1"><?php echo $text_yes; ?></option>';
		html += '  		<option value="0" selected="selected"><?php echo $text_no; ?></option>';
		html += '  		</select>';
    html += '  </td>';
    html += '  </tr>';
    html += '  <tr>';
    html += '  <td class="left"><?php echo $entry_display_view_all; ?></td>';
		html += '  <td class="left">';
		html += '    	<select name="productcarousel_module[' + module_row + '][display_view_all]">';
		html += '  		<option value="1"><?php echo $text_yes; ?></option>';
		html += '  		<option value="0" selected="selected"><?php echo $text_no; ?></option>';
		html += '  		</select>';
    html += '  </td>';
    html += '  </tr>';
    html += '  <tr>';
		html += '  <td class="left"><?php echo $entry_limit; ?></td>';
		html += '  <td class="left">';
		html += '  	   <input type="text" name="productcarousel_module[' + module_row + '][limit]" value="99" size="2" />';
		html += '  </td>';
    html += '  </tr>';
    html += '  <tr>';
		html += '  <td class="left"><?php echo $entry_scroll_limit; ?></td>';
		html += '  <td class="left">';
		html += '  	   <input type="text" name="productcarousel_module[' + module_row + '][scroll_limit]" value="3" size="2" />';
		html += '  </td>';
    html += '  </tr>';
    html += '  <tr>';
		html += '  <td class="left"><?php echo $entry_image; ?></td>';
		html += '  <td class="left">';
		html += '  	   <input type="text" name="productcarousel_module[' + module_row + '][image_width]" value="170" size="3" />';
    html += '      <input type="text" name="productcarousel_module[' + module_row + '][image_height]" value="170" size="3" />';
		html += '  </td>';
    html += '  </tr>';
    html += '  <tr>';
		html += '  <td class="left"><?php echo $entry_scroll; ?></td>';
		html += '  <td class="left">';
		html += '  	   <input type="text" name="productcarousel_module[' + module_row + '][scroll]" value="3" size="3" />';
		html += '  </td>';
    html += '  </tr>';
    html += '  <tr>';
		html += '  <td class="left"><?php echo $entry_axis; ?></td>';
		html += '  <td class="left">';
		html += '      <select name="productcarousel_module[' + module_row + '][axis]">';
		html += '  	   <option value="0" selected="selected"><?php echo $text_axis_orizzontal; ?></option>';
		html += '  	   <option value="1"><?php echo $text_axis_vertical; ?></option>';
		html += '      </select>';
		html += '  </td>';
    html += '  </tr>';
    html += '  <tr>';
		html += '  <td class="left"><?php echo $entry_autostart; ?></td>';
		html += '  <td class="left">';
		html += '      <select name="productcarousel_module[' + module_row + '][autostart]">';
		html += '  	   <option value="0" selected="selected"><?php echo $text_no; ?></option>';
		html += '  	   <option value="1"><?php echo $text_yes; ?></option>';
		html += '  	   </select>';
		html += '  </td>';
    html += '  </tr>';
    html += '  <tr>';
		html += '  <td class="left"><?php echo $entry_animation; ?></td>';
		html += '  <td class="left">';
		html += '  	   <input type="text" name="productcarousel_module[' + module_row + '][animation]" value="2000" size="5" />';
		html += '  </td>';
    html += '  </tr>';
    html += '  <tr>';
		html += '  <td class="left"><?php echo $entry_layout; ?></td>';
		html += '  <td class="left">';
		html += '  	   <select name="productcarousel_module[<?php echo $module_row; ?>][layout_id]">';
    <?php foreach ($layouts as $layout) { ?>
    html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>';
    <?php } ?>
    html += '      </select>';
		html += '  </td>';
    html += '  </tr>';
    html += '  <tr>';
		html += '  <td class="left"><?php echo $entry_position; ?></td>';
		html += '  <td class="left">';
		html += '  	   <select name="productcarousel_module[' + module_row + '][position]">';
    html += '      <option value="content_top" selected="selected"><?php echo $text_content_top; ?></option>';
    html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
    html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
    html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
    html += '      </select>';
		html += '  </td>';
    html += '  </tr>';	
    html += '  <tr>';
		html += '  <td class="left"><?php echo $entry_status; ?></td>';
		html += '  <td class="left">';
		html += '  	   <select name="productcarousel_module[' + module_row + '][status]">';
    html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
    html += '      <option value="0"><?php echo $text_disabled; ?></option>';
    html += '      </select>';
		html += '  </td>';
    html += '  </tr>';
    html += '  <tr>';
		html += '  <td class="left"><?php echo $entry_sort_order; ?></td>';
		html += '  <td class="left">';
		html += '  	   <input type="text" name="productcarousel_module[' + module_row + '][sort_order]" value="0" size="3" />';
		html += '  </td>';
    html += '  </tr>';
		html += '  </table>';
		html += '</div>';

		$('#form').append(html);
		
		$('#module-add').before('<a href="#tab-module-' + module_row + '" id="module-' + module_row + '"><?php echo $tab_module; ?> ' + module_row + '&nbsp;<img src="view/image/delete.png" alt="" onclick="$(\'.vtabs a:first\').trigger(\'click\'); $(\'#module-' + module_row + '\').remove(); $(\'#tab-module-' + module_row + '\').remove(); return false;" /></a>');
	
		$('.vtabs a').tabs();
    
    $('#languages-' + module_row + ' a').tabs();
    
    $('#languages-' + module_row + ' a:first').trigger('click');
	
		$('input.product-autocomplete').autocomplete({
			delay: 0,
			source: function(request, response) {
			$.ajax({
				url: 'index.php?route=module/productcarousel/autocomplete&token=<?php echo $token; ?>',
				type: 'POST',
				dataType: 'json',
				data: 'filter_name=' +  encodeURIComponent(request.term),
				success: function(data) {		
					response($.map(data, function(item) {
						return {
							label: item.name,
							value: item.product_id
						}
					}));
				}
			});
			
		}																, 
		select: function(event, ui) {
			
			$(this).val('');

			$('#source-products-' + $(this).attr('row') + '-' + ui.item.value).remove();
			
			$('#source-products-' + $(this).attr('row')).append('<div id="source-products-' + $(this).attr('row') + '-' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" row="' + $(this).attr('row') + '" /><input type="hidden" value="' + ui.item.value + '" /></div>');
	
			$('#source-products-' + $(this).attr('row') + ' div:odd').attr('class', 'odd');
			$('#source-products-' + $(this).attr('row') + ' div:even').attr('class', 'even');
			
			data = $.map($('#source-products-' + $(this).attr('row') + ' input'), function(element){
				return $(element).attr('value');
			});
							
			$('input[name=\'productcarousel_module[' + $(this).attr('row') + '][source_products]\']').attr('value', data.join());
						
			return false;
		}
		});

		$('#module-' + module_row).trigger('click');
	
		var source = document.getElementsByName('productcarousel_module[' + module_row + '][source_id]');	
		
		$(source).trigger('change');
		
		module_row++;
	}

	function ProductSourceChange(ddlsource, module_row) {

		var category_id = document.getElementsByName('productcarousel_module[' + module_row + '][category_id]'); 
		category_id[0].value = '-1'; 
		var category = document.getElementsByName('productcarousel_module[' + module_row + '][category]'); 
		
		switch (ddlsource.value)
		{
			case '1':
			  $('#productcarousel_module_sourcecustom_' + module_row).css('display','');
			  $('#productcarousel_module_sourcecategory_' + module_row).css('display','none');	
				$('#productcarousel_module_sourcemulticategory_' + module_row).css('display','none');
				$('#productcarousel_module_manufacturer_' + module_row).css('display','none');
			  product_source.style.display = '';
			  category[0].value = '-1'; 
        category[0].disabled = 'disabled';	
			  break;

			case '2':
			case '3':
			case '4':
      case '6':
      case '7':
      case '8':
        $('#productcarousel_module_sourcecustom_' + module_row).css('display','none');
			  $('#productcarousel_module_sourcecategory_' + module_row).css('display','none');
			  category[0].value = '-1'; 
        category[0].disabled = 'disabled';
				$('#productcarousel_module_sourcemulticategory_' + module_row).css('display','none');
				$('#productcarousel_module_manufacturer_' + module_row).css('display','none');
			  break;

			case '5':
			  $('#productcarousel_module_sourcecustom_' + module_row).css('display','none');
				$('#productcarousel_module_sourcemulticategory_' + module_row).css('display','none');
				$('#productcarousel_module_sourcecategory_' + module_row).css('display','');
				category[0].disabled = '';	
				$('#productcarousel_module_manufacturer_' + module_row).css('display','none');
        break;
			
			case '9':
			  $('#productcarousel_module_sourcecustom_' + module_row).css('display','none');
				$('#productcarousel_module_sourcecategory_' + module_row).css('display','none');
				category[0].disabled = '';	
        $('#productcarousel_module_sourcemulticategory_' + module_row).css('display','');
				$('#productcarousel_module_manufacturer_' + module_row).css('display','none');
			  break;	
				
			case '10':
			  $('#productcarousel_module_sourcecustom_' + module_row).css('display','none');
				$('#productcarousel_module_sourcecategory_' + module_row).css('display','none');
				category[0].disabled = '';	
        $('#productcarousel_module_sourcemulticategory_' + module_row).css('display','none');
				$('#productcarousel_module_manufacturer_' + module_row).css('display','');
			  break;
				
			case '11':
			  $('#productcarousel_module_sourcecustom_' + module_row).css('display','none');
				$('#productcarousel_module_sourcecategory_' + module_row).css('display','none');
				category[0].disabled = '';	
        $('#productcarousel_module_sourcemulticategory_' + module_row).css('display','none');
				$('#productcarousel_module_manufacturer_' + module_row).css('display','none');
				break;
		}
		
	}
</script>
<script type="text/javascript">

    $(document).ready(function() {
	
      $('input.product-autocomplete').autocomplete({
			delay: 0,
			source: function(request, response) {
				$.ajax({
					url: 'index.php?route=module/productcarousel/autocomplete&token=<?php echo $token; ?>',
					type: 'POST',
					dataType: 'json',
					data: 'filter_name=' +  encodeURIComponent(request.term),
					success: function(data) {		
						response($.map(data, function(item) {
							return {
								label: item.name,
								value: item.product_id
							}
						}));
					}
				});
			
		}																, 
		select: function(event, ui) {
			
			$(this).val('');

			$('#source-products-' + $(this).attr('row') + '-' + ui.item.value).remove();
			
			$('#source-products-' + $(this).attr('row')).append('<div id="source-products-' + $(this).attr('row') + '-' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" row="' + $(this).attr('row') + '" /><input type="hidden" value="' + ui.item.value + '" /></div>');
	
			$('#source-products-' + $(this).attr('row') + ' div:odd').attr('class', 'odd');
			$('#source-products-' + $(this).attr('row') + ' div:even').attr('class', 'even');
			
			data = $.map($('#source-products-' + $(this).attr('row') + ' input'), function(element){
				return $(element).attr('value');
			});
							
			$('input[name=\'productcarousel_module[' + $(this).attr('row') + '][source_products]\']').attr('value', data.join());
						
			return false;
		}
		});

	  $('div[id^=source-products-] div img').live('click', function() {
	    $(this).parent().remove();
		
		$('#source-products-' + $(this).attr('row') + ' div:odd').attr('class', 'odd');
		$('#source-products-' + $(this).attr('row') + ' div:even').attr('class', 'even');
	
		data = $.map($('#source-products-' + $(this).attr('row') + ' input'), function(element){
			return $(element).attr('value');
		});

		$('input[name=\'productcarousel_module[' + $(this).attr('row') + '][source_products]\']').attr('value', data.join());
	  });
	
	});

</script>
<script type="text/javascript"><!--
	$('.vtabs a').tabs();
	$('.htabs a').tabs(); 
//--></script> 
<?php echo $footer; ?>