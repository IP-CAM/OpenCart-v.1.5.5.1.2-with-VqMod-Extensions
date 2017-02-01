<?php
class ControllerModuleProductCarousel extends Controller {
  private $error = array(); 
	
  public function index() {   
    $this->load->language('module/productcarousel');

    $this->document->setTitle($this->language->get('heading_title'));
		
    $this->load->model('setting/setting');
				
    if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
        $this->model_setting_setting->editSetting('productcarousel', $this->request->post);		

        $this->session->data['success'] = $this->language->get('text_success');

        $this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
    }
				
    $this->data['heading_title'] = $this->language->get('heading_title');

    $this->data['text_enabled'] = $this->language->get('text_enabled');
    $this->data['text_disabled'] = $this->language->get('text_disabled');
    $this->data['text_source_custom'] = $this->language->get('text_source_custom');
		$this->data['note_source_custom'] = $this->language->get('note_source_custom');
		$this->data['text_source_special'] = $this->language->get('text_source_special');
    $this->data['text_source_bestseller'] = $this->language->get('text_source_bestseller');
    $this->data['text_source_latest'] = $this->language->get('text_source_latest');
    $this->data['text_source_category'] = $this->language->get('text_source_category');
    $this->data['text_source_category_product'] = $this->language->get('text_source_category_product');
    $this->data['text_source_product_related'] = $this->language->get('text_source_product_related');
		$this->data['text_source_multicategory'] = $this->language->get('text_source_multicategory');
		$this->data['text_source_manufacturer'] = $this->language->get('text_source_manufacturer');
    $this->data['text_source_current_manufacturer'] = $this->language->get('text_source_current_manufacturer');
    $this->data['text_all_category'] = $this->language->get('text_all_category');

    $this->data['text_axis_orizzontal'] = $this->language->get('text_axis_orizzontal');
    $this->data['text_axis_vertical'] = $this->language->get('text_axis_vertical');
    $this->data['text_yes'] = $this->language->get('text_yes');
    $this->data['text_no'] = $this->language->get('text_no');
    $this->data['text_content_top'] = $this->language->get('text_content_top');
    $this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
    $this->data['text_column_left'] = $this->language->get('text_column_left');
    $this->data['text_column_right'] = $this->language->get('text_column_right');

    $this->data['entry_caption'] = $this->language->get('entry_caption');
    $this->data['entry_source'] = $this->language->get('entry_source');
    $this->data['entry_category'] = $this->language->get('entry_category');
		$this->data['entry_categories'] = $this->language->get('entry_categories');
		$this->data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
    $this->data['entry_show_name'] = $this->language->get('entry_show_name');
    $this->data['entry_show_price'] = $this->language->get('entry_show_price');
    $this->data['entry_show_cart'] = $this->language->get('entry_show_cart');
    $this->data['entry_enabled_popup'] = $this->language->get('entry_enabled_popup');
    $this->data['entry_popup_detail'] = $this->language->get('entry_popup_detail');
    $this->data['entry_popup_detail_no'] = $this->language->get('entry_popup_detail_no');
    $this->data['entry_popup_detail_name'] = $this->language->get('entry_popup_detail_name');
    $this->data['entry_popup_detail_price'] = $this->language->get('entry_popup_detail_price');
    $this->data['entry_popup_detail_name_price'] = $this->language->get('entry_popup_detail_name_price');
    $this->data['entry_zoom_factor'] = $this->language->get('entry_zoom_factor');
    $this->data['entry_product'] = $this->language->get('entry_product');
    $this->data['entry_random'] = $this->language->get('entry_random');
    $this->data['entry_display_view_all'] = $this->language->get('entry_display_view_all');
    $this->data['entry_cache_enabled'] = $this->language->get('entry_cache_enabled');
    $this->data['entry_limit'] = $this->language->get('entry_limit');
    $this->data['entry_scroll_limit'] = $this->language->get('entry_scroll_limit');
    $this->data['entry_scroll'] = $this->language->get('entry_scroll');
    $this->data['entry_image'] = $this->language->get('entry_image');
    $this->data['entry_axis'] = $this->language->get('entry_axis');
    $this->data['entry_autostart'] = $this->language->get('entry_autostart');
    $this->data['entry_animation'] = $this->language->get('entry_animation');
    $this->data['entry_layout'] = $this->language->get('entry_layout');
    $this->data['entry_position'] = $this->language->get('entry_position');
    $this->data['entry_status'] = $this->language->get('entry_status');
    $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

    $this->data['tab_module'] = $this->language->get('tab_module');

    $this->data['button_save'] = $this->language->get('button_save');
    $this->data['button_cancel'] = $this->language->get('button_cancel');
    $this->data['button_add_module'] = $this->language->get('button_add_module');
    $this->data['button_remove'] = $this->language->get('button_remove');

    $this->data['token'] = $this->session->data['token'];

    if (isset($this->error['warning'])) {
        $this->data['error_warning'] = $this->error['warning'];
    } else {
        $this->data['error_warning'] = '';
    }

    if (isset($this->error['image'])) {
        $this->data['error_image'] = $this->error['image'];
    } else {
        $this->data['error_image'] = array();
    }
		
    $this->data['breadcrumbs'] = array();

    $this->data['breadcrumbs'][] = array(
      'text'      => $this->language->get('text_home'),
      'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      'separator' => false
    );

    $this->data['breadcrumbs'][] = array(
      'text'      => $this->language->get('text_module'),
      'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      'separator' => ' :: '
    );

    $this->data['breadcrumbs'][] = array(
      'text'      => $this->language->get('heading_title'),
      'href'      => $this->url->link('module/productcarousel', 'token=' . $this->session->data['token'], 'SSL'),
      'separator' => ' :: '
    );
		
    $this->data['action'] = $this->url->link('module/productcarousel', 'token=' . $this->session->data['token'], 'SSL');

    $this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

    $this->load->model('catalog/product');
    $this->load->model('catalog/category');
    
    $modules = array();
		
    if (isset($this->request->post['productcarousel_module'])) {
        $modules = $this->request->post['productcarousel_module'];
    } elseif ($this->config->get('productcarousel_module')) { 
        $modules = $this->config->get('productcarousel_module');
    }

    $this->data['modules'] = array();		
								
    foreach($modules as $module) {
		
      if (isset($module['source_products'])) {
          $source_products = explode(',', $module['source_products']);
      } else {
          $source_products = array();
      }	
			
      $products = array();
		
      foreach ($source_products as $source_product_id) {
        $product_info = $this->model_catalog_product->getProduct($source_product_id);

        if ($product_info) {
            $products[] = array(
                'product_id' => $product_info['product_id'],
                'name'       => $product_info['name']
            );
        }
      }
			
      if (isset($module['source_categories'])) {
          $source_categories = explode(',', $module['source_categories']);
      } else {
          $source_categories = array();
      }	
      
      $categories = array();
		
      foreach ($source_categories as $source_category_id) {
        $category_info = $this->model_catalog_category->getCategory($source_category_id);

        if ($category_info) {
            $categories[] = array(
              'category_id' => $category_info['category_id'],
              'name'        => $category_info['name']
            );
        }
      }
      
      $this->data['modules'][] = array(
        'language'              =>  $module['language'],
        'source_id'             =>  $module['source_id'],
        'source_products'       =>  $module['source_products'],
        'products'              =>  $products,
        'categories'            =>  $categories,
				'category'						  =>  (isset($module['category']) ? $module['category'] : array()),
				'manufacturer'					=>  (isset($module['manufacturer']) ? $module['manufacturer'] : array()),
        'category_id'           =>  $module['category_id'],
        'show_name'             =>  $module['show_name'],
        'show_price'            =>  $module['show_price'],
        'show_cart'             =>  $module['show_cart'],
        'enabled_popup'         =>  (isset($module['enabled_popup'])) ? $module['enabled_popup'] : '0',
        'popup_detail'          =>  (isset($module['popup_detail'])) ? $module['popup_detail'] : '0',
        'zoom_factor'           =>  (isset($module['zoom_factor'])) ? $module['zoom_factor'] : '0.0',
        'random'                =>  (isset($module['random'])) ? $module['random'] : '0',
        'cache_enabled'         =>  (isset($module['cache_enabled'])) ? $module['cache_enabled'] : '0',
        'display_view_all'      =>  (isset($module['display_view_all'])) ? $module['display_view_all'] : '0',
        'limit'                 =>  $module['limit'],
        'scroll_limit'          =>  $module['scroll_limit'],
        'image_width'           =>  $module['image_width'],
        'image_height'          =>  $module['image_height'],
        'scroll'                =>  $module['scroll'],
        'axis'                  =>  $module['axis'],
        'autostart'             =>  $module['autostart'],
        'animation'             =>  $module['animation'],
        'layout_id'             =>  $module['layout_id'],
        'position'              =>  $module['position'],
        'status'                =>  $module['status'],	
        'sort_order'            =>  $module['sort_order']					
      );	
    }

    $this->data['sources'] = array();

    $this->data['sources'][] = array(
      'source_id'   	=> '1',
      'name'          => $this->language->get('text_source_custom')						
    );

    $this->data['sources'][] = array(
      'source_id'   	=> '2',
      'name'          => $this->language->get('text_source_special')					
    );

    $this->data['sources'][] = array(
      'source_id'   	=> '3',
      'name'          => $this->language->get('text_source_bestseller')					
    );

    $this->data['sources'][] = array(
      'source_id'   	=> '4',
      'name'          => $this->language->get('text_source_latest')					
    );

    $this->data['sources'][] = array(
      'source_id'   	=> '5',
      'name'          => $this->language->get('text_source_category')					
    );

    $this->data['sources'][] = array(
      'source_id'   	=> '6',
      'name'          => $this->language->get('text_source_category_product')					
    );

    $this->data['sources'][] = array(
      'source_id'   	=> '7',
      'name'          => $this->language->get('text_source_current_category')					
    );
    
    $this->data['sources'][] = array(
      'source_id'   	=> '8',
      'name'          => $this->language->get('text_source_product_related')					
    );
    
		$this->data['sources'][] = array(
      'source_id'   	=> '9',
      'name'          => $this->language->get('text_source_multicategory')					
    );
		
		$this->data['sources'][] = array(
      'source_id'   	=> '10',
      'name'          => $this->language->get('text_source_manufacturer')					
    );
		
		$this->data['sources'][] = array(
      'source_id'   	=> '11',
      'name'          => $this->language->get('text_source_current_manufacturer')					
    );
		
    $this->load->model('catalog/category');

    $this->data['categories'] = $this->model_catalog_category->getCategories(0);

		$this->load->model('catalog/manufacturer');

    $this->data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers();
		
    $this->load->model('design/layout');

    $this->data['layouts'] = $this->model_design_layout->getLayouts();
		
    $this->load->model('localisation/language');

    $this->data['languages'] = $this->model_localisation_language->getLanguages();
    
    $this->template = 'module/productcarousel.tpl';
    $this->children = array(
      'common/header',
      'common/footer',
    );
				
    $this->response->setOutput($this->render());
  }
	
  private function validate() {
    if (!$this->user->hasPermission('modify', 'module/productcarousel')) {
        $this->error['warning'] = $this->language->get('error_permission');
    }

    if (!$this->error) {
        return true;
    } else {
        return false;
    }	
  }

  public function autocomplete() {
    $json = array();

    $filter_name = '%';		
    $filter_model = '%';

    if (isset($this->request->post['filter_name'])) {
        $filter_name = $this->request->post['filter_name'];
    }

    if (isset($this->request->post['filter_model'])) {
        $filter_model = $this->request->post['filter_model'];
    }

    $data = array(
      'filter_name'  => $filter_name,
      'filter_model' => $filter_model,
      'start'        => 0,
      'limit'        => 20
    );

    $this->load->model('catalog/product');

    $results = $this->model_catalog_product->getProducts($data);

    foreach ($results as $result) {
      $json[] = array(
          'product_id' 	=> $result['product_id'],
          'name'       	=> html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'),	
          'model'      	=> $result['model'],
          'price'      	=> $result['price']
      );	
    }

    if (VERSION	>= '1.5.1.3') {
        $this->response->setOutput(json_encode($json));
    } else {
        $this->load->library('json');
        $this->response->setOutput(Json::encode($json));
    }
  }
}
?>