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
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table id="module" class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $entry_limit; ?></td>
            <td class="left"><?php echo $entry_image; ?></td>
			<td class="left"><?php echo $entry_title; ?></td>
			<td class="left"><?php echo $tab_get_products_from; ?></td>
			<td class="left"><?php echo $entry_use_scrolling_panel; ?></td>   
            <td class="left"><?php echo $entry_layout; ?></td>
            <td class="left"><?php echo $entry_position; ?></td>
            <td class="left"><?php echo $entry_status; ?></td>
            <td class="right"><?php echo $entry_sort_order; ?></td>
            <td></td>
          </tr>
        </thead>
        <?php $module_row = 0; ?>
        <?php foreach ($modules as $module) { ?>
        <tbody id="module-row<?php echo $module_row; ?>">
          <tr>
            <td class="left"><input type="text" name="caurusel_all_module[<?php echo $module_row; ?>][limit]" value="<?php echo $module['limit']; ?>" size="1" />
			  <?php if (isset($error_numproduct[$module_row])) { ?>
                <span class="error"><?php echo $error_numproduct[$module_row]; ?></span>
                <?php } ?></td>
            <td class="left"><input type="text" name="caurusel_all_module[<?php echo $module_row; ?>][image_width]" value="<?php echo $module['image_width']; ?>" size="3" />
              <input type="text" name="caurusel_all_module[<?php echo $module_row; ?>][image_height]" value="<?php echo $module['image_height']; ?>" size="3" />
              <?php if (isset($error_image[$module_row])) { ?>
              <span class="error"><?php echo $error_image[$module_row]; ?></span>
              <?php } ?></td>
			<td class="left"><?php foreach ($languages as $language) { ?>
				<input name="caurusel_all_module[<?php echo $module_row; ?>][title][<?php echo $language['language_id']; ?>]" value="<?php echo isset($module['title'][$language['language_id']]) ? $module['title'][$language['language_id']] : ''; ?>" />
				<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
			<?php } ?></td>
			<td class="left"><select name="caurusel_all_module[<?php echo $module_row; ?>][filter_type]"  onchange="showCategories(this,<?php echo $module_row; ?>)">
                  <?php if ($module['filter_type'] == 'popular') { ?>
                  <option value="popular" selected="selected"><?php echo $tab_popular_products; ?></option>
                  <?php } else { ?>
                  <option value="popular"><?php echo $tab_popular_products; ?></option>
                  <?php } ?>
				  <?php if ($module['filter_type'] == 'special') { ?>
                  <option value="special" selected="selected"><?php echo $tab_special_products; ?></option>
                  <?php } else { ?>
                  <option value="special"><?php echo $tab_special_products; ?></option>
                  <?php } ?>
				  <?php if ($module['filter_type'] == 'bestseller') { ?>
                  <option value="bestseller" selected="selected"><?php echo $tab_bestSeller_products; ?></option>
                  <?php } else { ?>
                  <option value="bestseller"><?php echo $tab_bestSeller_products; ?></option>
                  <?php } ?>
				  <?php if ($module['filter_type'] == 'latest') { ?>
                  <option value="latest" selected="selected"><?php echo $tab_latest_products; ?></option>
                  <?php } else { ?>
                  <option value="latest"><?php echo $tab_latest_products; ?></option>
                  <?php } ?>	
				  <?php if ($module['filter_type'] == 'latestreview') { ?>
                  <option value="latestreview" selected="selected"><?php echo $tab_lastestreview_products; ?></option>
                  <?php } else { ?>
                  <option value="latestreview"><?php echo $tab_lastestreview_products; ?></option>
                  <?php } ?>
				 <?php if ($module['filter_type'] == 'category') { ?>
                  <option value="category" selected="selected"><?php echo $tab_choose_a_category; ?></option>
                  <?php } else { ?>
                  <option value="category"><?php echo $tab_choose_a_category; ?></option>
                  <?php } ?>
                </select>
				<?php if ($module['filter_type'] == 'category') { ?>
				<?php if (isset($error_category[$module_row])) { ?>
                <span class="error"><?php echo $error_category[$module_row]; ?></span>
                <?php } ?>
				<div class="scrollbox" id="scrollbox<?php echo $module_row; ?>">
					<?php $class = 'odd'; ?>
					<?php foreach ($categories as $category) { ?>
					<?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
					<div class="<?php echo $class; ?>">
					  <?php if (isset($module['filter_type_category']) && $category['category_id'] == $module['filter_type_category']) { ?>
					  <input type="radio" name="caurusel_all_module[<?php echo $module_row; ?>][filter_type_category]" value="<?php echo $category['category_id']; ?>" checked="checked" />
					  <?php echo $category['name']; ?>
					  <?php } else { ?>
					  <input type="radio" name="caurusel_all_module[<?php echo $module_row; ?>][filter_type_category]" value="<?php echo $category['category_id']; ?>" />
					  <?php echo $category['name']; ?>
					  <?php } ?>
					</div>
					<?php } ?>
				  </div>
				<?php } ?>
			</td>
			<td class="left"><select name="caurusel_all_module[<?php echo $module_row; ?>][use_scrolling_panel]">
				<?php if ($module['use_scrolling_panel']) { ?>
				<option value="1" selected="selected"><?php echo $text_vertical; ?></option>
				<option value="0"><?php echo $text_gorizontal; ?></option>
				<?php } else { ?>
				<option value="1"><?php echo $text_vertical; ?></option>
				<option value="0" selected="selected"><?php echo $text_gorizontal; ?></option>
				<?php } ?>
			</select>
				<?php echo $entry_scroll; ?><input type="text" name="caurusel_all_module[<?php echo $module_row; ?>][scroll]" value="<?php echo $module['scroll']; ?>" size="3" />
				<?php if (isset($scroll[$module_row])) { ?>
				<span class="error"><?php echo $scroll[$module_row]; ?></span>
				<?php } ?>
			</td>	
			<td class="left"><select name="caurusel_all_module[<?php echo $module_row; ?>][layout_id]">
                <?php foreach ($layouts as $layout) { ?>
                <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
                <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
            <td class="left"><select name="caurusel_all_module[<?php echo $module_row; ?>][position]">
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
              </select></td>
            <td class="left"><select name="caurusel_all_module[<?php echo $module_row; ?>][status]">
                <?php if ($module['status']) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
            <td class="right"><input type="text" name="caurusel_all_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
            <td class="left"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a></td>
          </tr>
        </tbody>
        <?php $module_row++; ?>
        <?php } ?>
        <tfoot>
          <tr>
            <td colspan="9"></td>
            <td class="left"><a onclick="addModule();" class="button"><?php echo $button_add_module; ?></a></td>
          </tr>
        </tfoot>
      </table>
    </form>
      <div>Разработано <a href="http://opencartforum.ru/user/18299-einshtein/" target="_blank">Einshtein</a> <br /> <a href="http://opencartforum.ru/topic/26213-%D0%BC%D0%BE%D0%B4%D1%83%D0%BB%D0%B8-%D0%B2-%D0%BA%D0%B0%D1%80%D1%83%D1%81%D0%B5%D0%BB%D0%B8/" target="_blank">Техподдержка модуля</a></div>
  </div>

</div>
  <script type="text/javascript"><!--
    function showCategories(select, row) {
	  if (select.options[select.selectedIndex].value == 'category') {
		divclass = 'odd';
		html  = '<div class="scrollbox" id="scrollbox' + row + '">';
		<?php foreach ($categories as $category) { ?>
		  divclass = divclass == 'even' ? 'odd' : 'even';
		  html += '<div class="' + divclass + '">';
		  html += '<input type="radio" name="caurusel_all_module[' + row + '][filter_type_category]" value="<?php echo $category['category_id']; ?>" />';
		  html += '<?php echo $category['name']; ?>'
		  html += '</div>';
		<?php } ?>
		html += '</div>';
		  
		$(select).after(html);
	  }
	  else {
		$('#scrollbox' + row).slideUp("normal", function() { $(this).remove(); } );
	  }
    }
  //--></script>


<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {	
	html  = '<tbody id="module-row' + module_row + '">';
	html += '  <tr>';
	html += '    <td class="left"><input type="text" name="caurusel_all_module[' + module_row + '][limit]" value="10" size="1" /></td>';
	html += '    <td class="left"><input type="text" name="caurusel_all_module[' + module_row + '][image_width]" value="80" size="3" /> <input type="text" name="caurusel_all_module[' + module_row + '][image_height]" value="80" size="3" /></td>';	
	html += '    <td class="left">';
	<?php foreach ($languages as $language) { ?>
	html += '      <input name="caurusel_all_module[' + module_row + '][title][<?php echo $language['language_id']; ?>]" />';
	html += '      <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />';
	<?php } ?>
	html += '    </td>';
	html += '    <td class="left"><select name="caurusel_all_module[' + module_row + '][filter_type]" onchange="showCategories(this,'+ module_row+')">';
	html += '      <option value="popular"><?php echo $tab_popular_products; ?></option>';
	html += '      <option value="special"><?php echo $tab_special_products; ?></option>';
	html += '      <option value="bestseller"><?php echo $tab_bestSeller_products; ?></option>';
	html += '      <option value="latest"><?php echo $tab_latest_products; ?></option>';
	html += '      <option value="latestreview"><?php echo $tab_lastestreview_products; ?></option>';
	html += '      <option value="category"><?php echo $tab_choose_a_category; ?></option>';
	html += '    </select></td>';
	html += '    <td class="left"><select name="caurusel_all_module[' + module_row + '][use_scrolling_panel]">';
    html += '      <option value="1" selected="selected"><?php echo $text_vertical; ?></option>';
    html += '      <option value="0"><?php echo $text_gorizontal; ?></option>';
    html += '    </select>';
	html += '	   <?php echo $entry_scroll; ?><input type="text" name="caurusel_all_module[' + module_row + '][scroll]" value="3" size="3" />';
	html += '	   </td>';
	html += '    <td class="left"><select name="caurusel_all_module[' + module_row + '][layout_id]">';
	<?php foreach ($layouts as $layout) { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><select name="caurusel_all_module[' + module_row + '][position]">';
		html += '      <option value="content_top"><?php echo $text_content_top; ?></option>';
	html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
	html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
	html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
	
	html += '    </select></td>';
	html += '    <td class="left"><select name="caurusel_all_module[' + module_row + '][status]">';
    html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
    html += '      <option value="0"><?php echo $text_disabled; ?></option>';
    html += '    </select></td>';
	html += '    <td class="right"><input type="text" name="caurusel_all_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    <td class="left"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#module tfoot').before(html);
	
	module_row++;
}
//--></script>
<?php echo $footer; ?>