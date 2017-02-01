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
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $l->get('button_save'); ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $l->get('button_cancel'); ?></a></div>
    </div>
    <div class="content">
      
      <div id="tabs" class="htabs">
        <a href="#tab-general"><?php echo $l->get('tab_general'); ?></a>
        <a href="#tab-attributes"><?php echo $l->get('tab_attributes'); ?></a>
      </div>
    
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        
        <div id="tab-general">  

        <table id="general" class="list">
          
          <tbody >
            <tr>
              <td class="left"><?php echo $l->get('text_show_catalog_attributes'); ?></td>              
              <td width="1" style="text-align: center;">
                <input type="checkbox" name="attribute_to_text_options[show_catalog_attributes]" value="1" <?php echo (isset($options['show_catalog_attributes']) && $options['show_catalog_attributes']) ? "checked=checked" : "" ;?> />
              </td>
            </tr>
            <tr>
              <td class="left"><?php echo $l->get('text_show_product_attributes'); ?></td>              
              <td width="1" style="text-align: center;">
                <input type="checkbox" name="attribute_to_text_options[show_product_attributes]" value="1" <?php echo (isset($options['show_product_attributes']) && $options['show_product_attributes']) ? "checked=checked" : "" ;?> />
              </td>
            </tr>
            <tr>
              <td class="left"><?php echo $l->get('text_show_attributes_name'); ?></td>              
              <td width="1" style="text-align: center;">
                <input type="checkbox" name="attribute_to_text_options[show_attributes_name]" value="1" <?php echo (isset($options['show_attributes_name']) && $options['show_attributes_name']) ? "checked=checked" : "" ;?> />
              </td>
            </tr>
            <tr>
              <td class="left"><?php echo $l->get('text_show_attributes_tags'); ?></td>              
              <td width="1" style="text-align: center;">
                <input type="checkbox" name="attribute_to_text_options[show_attributes_tags]" value="1" <?php echo (isset($options['show_attributes_tags']) && $options['show_attributes_tags']) ? "checked=checked" : "" ;?> />
              </td>
            </tr>
            <tr>
              <td class="left"><?php echo $l->get('text_attributes_separator'); ?></td>              
              <td width="1" style="text-align: center;">
                <input type="text" name="attribute_to_text_options[attributes_separator]" value="<?php echo isset($options['attributes_separator']) ? $options['attributes_separator'] : '/';?>">
              </td>
            </tr>
            <tr>
              <td class="left"><?php echo $l->get('text_attributes_count'); ?></td>              
              <td width="1" style="text-align: center;">
                <input type="text" name="attribute_to_text_options[attributes_count]" value="<?php echo isset($options['attributes_count']) ? $options['attributes_count'] : 0;?>">
              </td>
            </tr>
            <tr>
              <td class="left"><?php echo $l->get('text_attributes_cut'); ?></td>              
              <td width="1" style="text-align: center;">
                <input type="text" name="attribute_to_text_options[attributes_cut]" value="<?php echo isset($options['attributes_cut']) ? $options['attributes_cut'] : 0;?>">
              </td>
            </tr>
          
          </tbody>
        </table>

        </div>
        
        <div id="tab-attributes">

        <table id="attributes" class="list">
          <thead>
            <tr>
              <td class="left"><?php echo $l->get('attributes_group'); ?></td>                            
              <td class="left"><?php echo $l->get('attributes'); ?></td>              
              <td class="left"><?php echo $l->get('attributes_show'); ?></td>
              <td class="left"><?php echo $l->get('attributes_replace_text'); ?></td>  
            </tr>
          </thead>
          <tbody>
          
          <?php foreach($attributes as $attribute) {?>
            <tr>
              <td class="left"><?php echo $attribute['attribute_group']; ?></td>              
              <td class="left"><?php echo $attribute['name']; ?></td>              
              <td>
              
                <select name="attribute_to_text_options[attributes][<?php echo $attribute['attribute_id']; ?>][show]">

                  <option value="0" <?php echo (isset($options['attributes'][$attribute['attribute_id']]['show']) && $options['attributes'][$attribute['attribute_id']]['show'] == '0') ? 'selected="selected"' : "" ;?>><?php echo $l->get('attributes_hide'); ?></option>
                  <option value="1" <?php echo (isset($options['attributes'][$attribute['attribute_id']]['show']) && $options['attributes'][$attribute['attribute_id']]['show'] == '1') ? 'selected="selected"' : "" ;?>><?php echo $l->get('attributes_show'); ?></option>
                  <option value="2" <?php echo (isset($options['attributes'][$attribute['attribute_id']]['show']) && $options['attributes'][$attribute['attribute_id']]['show'] == '2') ? 'selected="selected"' : "" ;?>><?php echo $l->get('attributes_replace'); ?></option>

                </select>

              </td>
              
              <td class="left">
                <input type="text" name="attribute_to_text_options[attributes][<?php echo $attribute['attribute_id']; ?>][replace]" value="<?php echo isset($options['attributes'][$attribute['attribute_id']]['replace']) ? $options['attributes'][$attribute['attribute_id']]['replace'] : '';?>">
              </td>  
              
            </tr>
          <?php } ?>
          </tbody>
        </table>
        </div>

      </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script> 
<?php echo $footer; ?>
