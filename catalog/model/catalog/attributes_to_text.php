<?php
class ModelCatalogAttributesToText extends Model {

  public function getText($product_id, $options) {
    
    $text = "";
    $this->load->model('catalog/product');
		
		$attribute_groups = $this->model_catalog_product->getProductAttributes($product_id);
    
    $show_attributes_name  = isset($options['show_attributes_name']) ? $options['show_attributes_name'] : 0; 
		$show_attributes_tags = isset($options['show_attributes_tags']) ? $options['show_attributes_tags'] : 0;
    $attributes_count = isset($options['attributes_count']) ? $options['attributes_count'] : 0;
    $attributes_cut = isset($options['attributes_cut']) ? $options['attributes_cut'] : 0;
    
		$attr_arr = array();
    $attributes_text_length = '';
    
		foreach ($attribute_groups as $group) {
		  foreach ($group['attribute'] as $attribute) {
  		  if (isset($options['attributes'][$attribute['attribute_id']])) { 
          
          $attribute_text = '';
          $attribute_text_length = 0;
	  	    
          if ($options['attributes'][$attribute['attribute_id']]['show'] == 1) {
	  	      $attribute_text = $attribute['text']; 
	  	    }
          // show with replace 
	  	    else if ($options['attributes'][$attribute['attribute_id']]['show'] == 2 
            && !$show_attributes_name      
	  	      && in_array($attribute['text'], explode(',', $options['attributes'][$attribute['attribute_id']]['replace']))) {
	  	      $attribute_text = $attribute['name']; 
	  	    }
          
          if ($attribute_text) {
            
            $attribute_text_length = strlen($attribute_text);
            
            if ($show_attributes_name) {
              
              $attribute_text_length += strlen($attribute['name']) + 2; // 2 - ': '
              
              if ($show_attributes_tags) {
                $attribute_text = '<span class="attribute-name">' . $attribute['name'] . ':</span> ' . $attribute_text;
              }
              else {
                $attribute_text = $attribute['name'] . ': ' . $attribute_text;
              }
            }
            
            if ($attributes_cut) {
              $attributes_text_length += $attribute_text_length;
              if ($attributes_text_length > $attributes_cut) {
                break 2;
              }
            }                        
            
            if ($show_attributes_tags) {
              $attribute_text = '<span class="attribute-text attribute-id-' . $attribute['attribute_id'] . '">' . $attribute_text . '</span>';
            }
            
            $attr_arr[] = $attribute_text;
            
            if ($attributes_count) {
              if (count($attr_arr) >= $attributes_count) {
                break 2;
              }
            }
                        
          }
          
	  	  }
	  	}  
		}
		
		if ($attr_arr) {
		  $separator = isset($options['attributes_separator']) ? $options['attributes_separator'] : "/";
      $separator = html_entity_decode($separator, ENT_QUOTES, 'UTF-8');
		  $text .= implode($attr_arr, $separator);
		}
		
    if ($show_attributes_tags) {
      $text = '<span class="attributes-text">' . $text . '</span>';
    }  
    
    return $text;
    
	}
	
}
