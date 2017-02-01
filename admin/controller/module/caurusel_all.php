<?php
class ControllerModuleCauruselAll extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->language->load('module/caurusel_all');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('caurusel_all', $this->request->post);		
			
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_vertical'] = $this->language->get('text_vertical');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_gorizontal'] = $this->language->get('text_gorizontal');
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');
		
		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_limit'] = $this->language->get('entry_limit');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_use_scrolling_panel'] = $this->language->get('entry_use_scrolling_panel');	
		$this->data['entry_scroll'] = $this->language->get('entry_scroll');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
		
		$this->data['tab_lastestreview_products'] = $this->language->get('tab_lastestreview_products');
		$this->data['tab_popular_products'] = $this->language->get('tab_popular_products');
		$this->data['tab_special_products'] = $this->language->get('tab_special_products');
		$this->data['tab_latest_products'] = $this->language->get('tab_latest_products');
		$this->data['tab_bestSeller_products'] = $this->language->get('tab_bestSeller_products');
		$this->data['tab_choose_a_category'] = $this->language->get('tab_choose_a_category');
		$this->data['tab_get_products_from'] = $this->language->get('tab_get_products_from');
 		
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		if (isset($this->error['category'])) {
			$this->data['error_category'] = $this->error['category'];
		} else {
			$this->data['error_category'] = array();
		}
		if (isset($this->error['numproduct'])) {
			$this->data['error_numproduct'] = $this->error['numproduct'];
		} else {
			$this->data['error_numproduct'] = array();
		}
		if (isset($this->error['scroll'])) {
			$this->data['scroll'] = $this->error['scroll'];
		} else {
			$this->data['scroll'] = array();
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
			'href'      => $this->url->link('module/caurusel_all', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/caurusel_all', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		//list category	
		$boss_category_check = array();
		if (isset($this->request->post['caurusel_all_module'])) {
			$boss_category_check = $this->request->post['caurusel_all_module'];
		} elseif ($this->config->get('caurusel_all_module')) { 
			$boss_category_check = $this->config->get('caurusel_all_module');
		}
		
		$this->load->model('catalog/category');
		
		$this->data['categories'] = array();
		
		$results = $this->model_catalog_category->getCategories(0);

		foreach ($results as $result) {
			$select = 0;
			if(in_array($result['category_id'], $boss_category_check )){
				$select = 1;
			}
			$this->data['categories'][] = array(
				'category_id' => $result['category_id'],
				'name'        => $result['name'],
				'selected'    => $select
			);
		}
		
		//module
		$this->data['modules'] = array();
		
		if (isset($this->request->post['caurusel_all_module'])) {
			$this->data['modules'] = $this->request->post['caurusel_all_module'];
		} elseif ($this->config->get('caurusel_all_module')) { 
			$this->data['modules'] = $this->config->get('caurusel_all_module');
		}				
		
		$this->load->model('design/layout');
		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->load->model('localisation/language');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		$this->template = 'module/caurusel_all.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/caurusel_all')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (isset($this->request->post['caurusel_all_module'])) {
			foreach ($this->request->post['caurusel_all_module'] as $key => $value) {
				if (!$value['image_width'] || !$value['image_height']) {
					$this->error['image'][$key] = $this->language->get('error_image');
				}
				if ($value['filter_type'] == 'category' && !isset($value['filter_type_category'])) {
					$this->error['category'][$key] = $this->language->get('error_category');
				}
				if (!$value['limit']) {
					$this->error['numproduct'][$key] = $this->language->get('error_numproduct');
				}
				if (!$value['scroll']) {
					$this->error['scroll'][$key] = $this->language->get('error_scroll');
				}				
			}
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	
	
	
	
}
?>