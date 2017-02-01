<?php
class ModelCatalogAttributeToText extends Model {

  public function getDefaultOptions() {
  
    return array( 
      'show_catalog_attributes' => 1,  
      'show_product_attributes' => 1,  
      'show_attributes_name' => 0, 
      'show_attributes_tags' => 0,   
      'attributes_count' => 7,  
      'attributes_cut' => 50,
      'attributes_separator' => '/'
     );
  }

}