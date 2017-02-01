<?php
class ControllerModuleProductCarousel extends Controller {
  protected function index($setting) {
    static $module = 0;
    
		$this->language->load('module/productcarousel');
    
    $this->load->model('tool/image');

    $this->document->addScript('catalog/view/javascript/jquery/productcarousel/productcarousel.js');
    //$this->document->addStyle('catalog/view/javascript/jquery/productcarousel/productcarousel.css');
    
    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/productcarousel.css')) {
        $this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/productcarousel.css');
    } else {
        $this->document->addStyle('catalog/view/theme/default/stylesheet/productcarousel.css');
    }
    		
    $this->data['button_cart'] = $this->language->get('button_cart');		
    $this->data['caption'] = $setting['language'][$this->config->get('config_language_id')]['caption'];
    $this->data['category_id'] = $setting['category_id'];
    $this->data['show_name'] = $setting['show_name'];
    $this->data['show_price'] = $setting['show_price'];
    $this->data['show_cart'] = $setting['show_cart'];
    $this->data['enabled_popup'] = $setting['enabled_popup'];
    $this->data['popup_detail'] = $setting['popup_detail'];
    $this->data['zoom_factor'] = $setting['zoom_factor'];
    $this->data['limit'] = $setting['limit'];
    $this->data['scroll_limit'] = $setting['scroll_limit'];
    $this->data['scroll'] = $setting['scroll'];
    $this->data['animation'] = ((isset($setting['animation']) && $setting['animation'] > 0) ? $setting['animation'] : 1500);
    $this->data['image_width'] = $setting['image_width'];
    $this->data['image_height'] = $setting['image_height'];
    $this->data['axis'] = $setting['axis'];
    $this->data['autostart'] = $setting['autostart'];
    $this->data['display_view_all'] = (isset($setting['display_view_all']) ? $setting['display_view_all'] : '0');
    $this->data['href_view_all'] = '';
    $this->data['text_view_all'] = $this->language->get('text_view_all');
        
    $this->data['products'] = array();

    $this->load->model('catalog/product');
    $this->load->model('catalog/category');
    $this->load->model('module/productcarousel');

    $products = array();
    $path = '';
    $data = array();
    
    if ($this->customer->isLogged()) {
        $customer_group_id = $this->customer->getCustomerGroupId();
    } else {
        $customer_group_id = $this->config->get('config_customer_group_id');
    }	
            
    //In base al source, determino i prodotti...
    switch($setting['source_id']) {
      case 1: //Custom Source
        $results = explode(',', $setting['source_products']);	

        if ($setting['random']) {
            shuffle($results);
        }
        
        foreach ($results as $product_id) {
          $product_info = $this->model_module_productcarousel->getProduct($product_id);

          if ($product_info) {
              $products[] = $product_info;
          }
        }	
        break;
			
      case 2: //Products Special
        $data = array(
          'source'             => '2',
          'module_id'          => $module,
          'has_sort'           => 0,
          'cache_enabled'      => $setting['cache_enabled'],
          'customer_group_id'  => $customer_group_id,
          'product_id'         => 0,
          'filter_category_id' => 0,
          'random'             => $setting['random'],
          'start'              => 0,
          'limit'              => $setting['limit']
        );
        //$products = $this->model_module_productcarousel->getProductSpecials($data);
        break;

      case 3: //Products Bestseller
        $data = array (
          'source'             => '3',
          'module_id'          => $module,
          'has_sort'           => 0,
          'cache_enabled'      => $setting['cache_enabled'],
          'customer_group_id'  => 0,
          'product_id'         => 0,
          'filter_category_id' => 0,  
          'random'             => $setting['random'],
          'start'              => 0,
          'limit'              => $setting['limit']
        );
        //$products = $this->model_module_productcarousel->getBestSellerProducts($data);
        break;

      case 4: //Products Latest
        $data = array (
          'source'             => '4',
          'module_id'          => $module,
          'has_sort'           => 0,  
          'cache_enabled'      => $setting['cache_enabled'],
          'customer_group_id'  => 0,  
          'product_id'         => 0,
          'filter_category_id' => 0,  
          'random'             => $setting['random'],
          'start'              => 0,
          'limit'              => $setting['limit']
        );	
        //$products = $this->model_module_productcarousel->getLatestProducts($data);
        break;
	
      case 5: //Category Setting
        $data = array(
          'source'             => '5',
          'module_id'          => $module,
          'has_sort'           => 1,  
          'cache_enabled'      => $setting['cache_enabled'],
          'customer_group_id'  => 0,
          'product_id'         => 0,
          'filter_category_id' => $setting['category_id'],
          'random'             => $setting['random'],
          'start'              => 0,
          'limit'              => $setting['limit']
        );
        $this->data['href_view_all'] = $this->url->link('product/category', 'path=' . $setting['category_id']);
        //$products = $this->model_module_productcarousel->getProducts($data);
        break;

      case 6: //Category Product...
        if (isset($this->request->get['path'])) {
            $parts = explode('_', (string)$this->request->get['path']);
            $category_id = array_pop($parts);

            $category_info = $this->model_catalog_category->getCategory($category_id);

            if ($category_info) {
                $data = array(
                  'source'             => '6',
                  'module_id'          => $module,
                  'has_sort'           => 1,
                  'cache_enabled'      => $setting['cache_enabled'],
                  'customer_group_id'  => 0,
                  'product_id'         => 0,
                  'filter_category_id' => $category_id,
                  'random'             => $setting['random'],
                  'start'              => 0,
                  'limit'              => $setting['limit']
                );
                $this->data['href_view_all'] = $this->url->link('product/category', 'path=' . $this->request->get['path']);
                //$products = $this->model_module_productcarousel->getProducts($data);
            }
            $path = '&path=' . $this->request->get['path'];
            
        } else if (isset($this->request->get['product_id'])) {
            $data = array(
              'source'             => '6',
              'module_id'          => $module,
              'has_sort'           => 0,
              'cache_enabled'      => $setting['cache_enabled'],
              'customer_group_id'  => 0,
              'product_id'         => $this->request->get['product_id'],
              'filter_category_id' => 0,
              'random'             => $setting['random'],
              'start'              => 0,
              'limit'              => $setting['limit']
            );
            //$products = $this->model_module_productcarousel->getCategoryProducts($this->request->get['product_id'], $data);
        }
        break;
        
      case 7: //Category Current
        if (isset($this->request->get['path'])) {
            $parts = explode('_', (string)$this->request->get['path']);
            $category_id = array_pop($parts);
            
            $data = array(
              'source'             => '7',
              'module_id'          => $module,
              'has_sort'           => 1,  
              'cache_enabled'      => $setting['cache_enabled'],
              'customer_group_id'  => 0,
              'product_id'         => 0,
              'filter_category_id' => $category_id,
              'random'             => $setting['random'],
              'start'              => 0,
              'limit'              => $setting['limit']
            );
            
            $this->data['href_view_all'] = $this->url->link('product/category', 'path=' . $this->request->get['path']);
            
            //$products = $this->model_module_productcarousel->getProducts($data);
        }
        break;
        
      case 8: //Products Related
        if (isset($this->request->get['product_id'])) {
            $data = array (
              'source'             => '8',
              'module_id'          => $module,
              'has_sort'           => 0,
              'cache_enabled'      => $setting['cache_enabled'],
              'customer_group_id'  => 0,
              'product_id'         => $this->request->get['product_id'],
              'filter_category_id' => 0,
              'random'             => $setting['random'],
              'start'              => 0,
              'limit'              => $setting['limit']
            );	
            //$products = $this->model_module_productcarousel->getProductsRelated($data);
        }
        break;
				
			case 9: //MultiCategory
				$data = array (
          'source'             => '9',
          'module_id'          => $module,
          'has_sort'           => 0,
          'cache_enabled'      => $setting['cache_enabled'],
          'customer_group_id'  => 0,
          'product_id'         => 0,
          'filter_categories_id' => $setting['category'],
          'random'             => $setting['random'],
          'start'              => 0,
          'limit'              => $setting['limit']
        );	
				break;
				
			case 10: //Product Manufactuter
				$data = array (
          'source'             => '10',
          'module_id'          => $module,
          'has_sort'           => 0,
          'cache_enabled'      => $setting['cache_enabled'],
          'customer_group_id'  => 0,
          'product_id'         => 0,
          'filter_categories_id' => 0,
					'filter_manufacturers_id' => $setting['manufacturer'],
          'random'             => $setting['random'],
          'start'              => 0,
          'limit'              => $setting['limit']
        );	
				break;
				
			case 11: //Current Manufactuter
				$data = array (
          'source'             => '11',
          'module_id'          => $module,
          'has_sort'           => 0,
          'cache_enabled'      => $setting['cache_enabled'],
          'customer_group_id'  => 0,
          'product_id'         => 0,
          'filter_categories_id' => 0,
					'filter_manufacturers_id' => array(isset($this->request->get['manufacturer_id']) ? $this->request->get['manufacturer_id'] : 999999),
          'random'             => $setting['random'],
          'start'              => 0,
          'limit'              => $setting['limit']
        );	
				break;
    }

    if ($data) {
        $products = $this->model_module_productcarousel->getProducts($data);
    }    
        
    if ($products) {
        foreach ($products as $product_info) {
          if ($product_info['image']) {
              $image = $this->model_tool_image->resize($product_info['image'], $setting['image_width'], $setting['image_height']);
          } else {
              $image = $this->model_tool_image->resize('no_image.jpg', $setting['image_width'], $setting['image_height']);
          }

          $image_popup = false;

          if ($setting['enabled_popup']) {
              if ($product_info['image']) {
                  $image_popup = $this->model_tool_image->resize($product_info['image'], ((int)$setting['image_width'] + ((int)$setting['image_width'] * (float)$setting['zoom_factor'])), ((int)$setting['image_height'] + ((int)$setting['image_height'] * (float)$setting['zoom_factor'])));
              } else {
                  $image_popup = $this->model_tool_image->resize('no_image.jpg', ((int)$setting['image_width'] + ((int)$setting['image_width'] * (float)$setting['zoom_factor'])), ((int)$setting['image_height'] + ((int)$setting['image_height'] * (float)$setting['zoom_factor'])));
              }
          }

          if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
              $price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
          } else {
              $price = false;
          }

          if ((float)$product_info['special']) {
              $special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
          } else {
              $special = false;
          }

          if ($this->config->get('config_tax')) {
              $tax = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price']);
          } else {
              $tax = false;
          }

          if ($this->config->get('config_review_status')) {
              $rating = $product_info['rating'];
          } else {
              $rating = false;
          }

          $this->data['products'][] = array(
            'product_id'            => $product_info['product_id'],
            'thumb'                 => $image,
            'thumb_popup'           => $image_popup,
            'name'                  => $product_info['name'],
            'description'           => substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
            'price'                 => $price,
            'tax'                   => $tax,
            'special'               => $special,
            'rating'                => $rating,
            'reviews'               => sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']),
            'href'                  => $this->url->link('product/product', 'product_id=' . $product_info['product_id'] . $path),
          );
        }
    }
        
    $this->data['module'] = $module++;
		
    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/productcarousel.tpl')) {
        $this->template = $this->config->get('config_template') . '/template/module/productcarousel.tpl';
    } else {
        $this->template = 'default/template/module/productcarousel.tpl';
    }
		
    $this->render(); 
  }
}
?>