<?php
class ControllerModuleCauruselAll extends Controller {
	protected function index($setting) {
		static $module = 0;

		$this->document->addScript('catalog/view/javascript/jquery/jquery.jcarousel.min.js');
		if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/carousel.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/carousel.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/carousel.css');
		}
		if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/caurusel_all.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/caurusel_all.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/caurusel_all.css');
		}
		
		$this->load->model('caurusel_all/model');
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		
		$this->data['use_scrolling_panel'] = $setting['use_scrolling_panel'];
		$this->data['scroll'] = $setting['scroll'];
		$this->data['button_cart'] = $this->language->get('button_cart');
		
		$results = array();
		$filter_type = $setting['filter_type'];
		switch($filter_type)
		{
		case "popular":
			$results = $this->model_catalog_product->getPopularProducts($setting['limit']);
			break;
		case "special":
			$data = array(
			'sort'  => 'pd.name',
			'order' => 'ASC',
			'start' => 0,
			'limit' => $setting['limit']
			);
			$results = $this->model_catalog_product->getProductSpecials($data);
			break;
		case "bestseller":
			$results = $this->model_catalog_product->getBestSellerProducts($setting['limit']);
			break;
		case "latest":
			$results = $this->model_catalog_product->getLatestProducts($setting['limit']);
			break;
		case "latestreview":		
			$results_data = $this->model_caurusel_all_model->getLatestReviewProducts($setting['limit']);
			foreach($results_data as $products_data){
				$results[] = $this->model_catalog_product->getproduct($products_data['product_id']);
			}
			break;
		case "category":	
			$data = array(
			'filter_category_id' => $setting['filter_type_category'],
			'sort'  => 'pd.name',
			'order' => 'ASC',
			'start' => 0,
			'limit' => $setting['limit']
			);
			$results = $this->model_catalog_product->getProducts($data);
			break;
		}
		
		$this->data['heading_title'] = $setting['title'][$this->config->get('config_language_id')];
		$this->data['products'] = array();
		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $setting['image_width'], $setting['image_height']);
			} else {
				$image = false;
			}
			
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = false;
			}
					
			if ((float)$result['special']) {
				$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$special = false;
			}	
			
			if ($this->config->get('config_review_status')) {
				$rating = $result['rating'];
			} else {
				$rating = false;
			}
							
			$this->data['products'][] = array(
				'product_id' => $result['product_id'],
				'thumb'   	 => $image,
				'name'    	 => $result['name'],
				'price'   	 => $price,
				'special' 	 => $special,
				'rating'     => $rating,
				'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 300) . '..',
				'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
				'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id']),
			);
		}
		
		$this->data['module'] = $module++;
		$this->data['template'] = $this->config->get('config_template');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/caurusel_all.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/caurusel_all.tpl';
		} else {
			$this->template = 'default/template/module/caurusel_all.tpl';
		}

		$this->render();
	}
}
?>