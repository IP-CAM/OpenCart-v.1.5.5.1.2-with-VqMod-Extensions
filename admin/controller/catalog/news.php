<?php
class ControllerCatalogNews extends Controller { 
	private $error = array();

	public function index() {
		$this->load->language('catalog/news');

		$this->document->setTitle($this->language->get('heading_title'));
		 
		$this->load->model('catalog/news');

		$this->getList();
	}

	public function insert() {
		$this->load->language('catalog/news');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/news');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_news->addNews($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url =  (isset($this->request->get['sort'])) ? '&sort=' . $this->request->get['sort'] : '';
			$url .=  (isset($this->request->get['order'])) ? '&order=' . $this->request->get['order'] : '';
			$url .=  (isset($this->request->get['page'])) ? '&page=' . $this->request->get['page'] : '';
			
			$this->redirect($this->url->link('catalog/news', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->load->language('catalog/news');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/news');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_news->editNews($this->request->get['news_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url =  (isset($this->request->get['sort'])) ? '&sort=' . $this->request->get['sort'] : '';
			$url .=  (isset($this->request->get['order'])) ? '&order=' . $this->request->get['order'] : '';
			$url .=  (isset($this->request->get['page'])) ? '&page=' . $this->request->get['page'] : '';

			$this->redirect($this->url->link('catalog/news', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}
 
	public function delete() {
		$this->load->language('catalog/news');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/news');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $news_id) {
				$this->model_catalog_news->deleteNews($news_id);
			}
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url =  (isset($this->request->get['sort'])) ? '&sort=' . $this->request->get['sort'] : '';
			$url .=  (isset($this->request->get['order'])) ? '&order=' . $this->request->get['order'] : '';
			$url .=  (isset($this->request->get['page'])) ? '&page=' . $this->request->get['page'] : '';
			
			$this->redirect($this->url->link('catalog/news', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'n.date_start';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		$url =  (isset($this->request->get['sort'])) ? '&sort=' . $this->request->get['sort'] : '';
		$url .=  (isset($this->request->get['order'])) ? '&order=' . $this->request->get['order'] : '';
		$url .=  (isset($this->request->get['page'])) ? '&page=' . $this->request->get['page'] : '';

  		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/news', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['insert'] = $this->url->link('catalog/news/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('catalog/news/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	

		$this->data['newss'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$news_total = $this->model_catalog_news->getTotalNewss();
	
		$results = $this->model_catalog_news->getNewss($data);
 
		foreach ($results as $result) {
			$action = array();
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/news/update', 'token=' . $this->session->data['token'] . '&news_id=' . $result['news_id'] . $url, 'SSL')
			);
			
			
			$this->data['newss'][] = array(
				'news_id'	=> $result['news_id'],
				'caption'		=> $result['caption'],
				//'image'		=> $result['image'],
				'date_start'	=> (date("d-m-Y H:i",$result['date_start'])),
				'date_end'	=> ( ( $result['date_end'] != 0) ? date("d-m-Y H:i",$result['date_end']) :  $this->language->get('text_date_never') ),
				'status'	=> $result['status'],
				'selected'	=> isset($this->request->post['selected']) && in_array($result['news_id'], $this->request->post['selected']),
				'action'	=> $action
			);
		}	
	
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_caption'] = $this->language->get('column_caption');
		$this->data['column_date_start'] = $this->language->get('column_date_start');
		$this->data['column_date_end'] = $this->language->get('column_date_end');
		$this->data['column_action'] = $this->language->get('column_action');		
		$this->data['column_status'] = $this->language->get('column_status');
		
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
 
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$this->data['sort_caption'] = $this->url->link('catalog/news', 'token=' . $this->session->data['token'] . '&sort=nd.caption' . $url, 'SSL');
		$this->data['sort_date_start'] = $this->url->link('catalog/news', 'token=' . $this->session->data['token'] . '&sort=n.date_start' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $news_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('catalog/news', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/news_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

	private function getForm() {
		$this->setDatepickerLanguage();

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_date_never'] = $this->language->get('text_date_never');
		$this->data['text_browse'] = $this->language->get('text_browse');
		
		$this->data['text_fancybox'] = $this->language->get('text_fancybox');
		$this->data['text_colorbox'] = $this->language->get('text_colorbox');
		
		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_h1'] = $this->language->get('entry_h1');
		$this->data['entry_caption'] = $this->language->get('entry_caption');
		$this->data['entry_meta_keywords'] = $this->language->get('entry_meta_keywords');
		$this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
		
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_store'] = $this->language->get('entry_store');
		$this->data['entry_keyword'] = $this->language->get('entry_keyword');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_fancybox'] = $this->language->get('entry_fancybox');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_content'] = $this->language->get('entry_content');
		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->data['entry_date_end'] = $this->language->get('entry_date_end');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_remove'] = $this->language->get('button_remove');

		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_data'] = $this->language->get('tab_data');
		$this->data['tab_design'] = $this->language->get('tab_design');
		
		$this->data['token'] = $this->session->data['token'];

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['title'])) {
			$this->data['error_title'] = $this->error['title'];
		} else {
			$this->data['error_title'] = array();
		}
		
	 	if (isset($this->error['description'])) {
			$this->data['error_description'] = $this->error['description'];
		} else {
			$this->data['error_description'] = array();
		}
		
		if (isset($this->error['content'])) {
			$this->data['error_content'] = $this->error['content'];
		} else {
			$this->data['error_content'] = array();
		}
		
		if (isset($this->error['date_start'])) {
			$this->data['error_date_start'] = $this->error['date_start'];
		} else {
			$this->data['error_date_startt'] = array();
		}

		$url =  (isset($this->request->get['sort'])) ? '&sort=' . $this->request->get['sort'] : '';
		$url .=  (isset($this->request->get['order'])) ? '&order=' . $this->request->get['order'] : '';
		$url .=  (isset($this->request->get['page'])) ? '&page=' . $this->request->get['page'] : '';

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('text_home'),
			'href'		=> $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),     		
			'separator'	=> false
		);

		$this->data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('heading_title'),
			'href'		=> $this->url->link('catalog/news', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator'	=> ' :: '
		);

		if (!isset($this->request->get['news_id'])) {
			$this->data['action'] = $this->url->link('catalog/news/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/news/update', 'token=' . $this->session->data['token'] . '&news_id=' . $this->request->get['news_id'] . $url, 'SSL');
		}
		$this->data['cancel'] = $this->url->link('catalog/news', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['news_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$news_info = $this->model_catalog_news->getNews($this->request->get['news_id']);
			/* Format DateTime */
			if(isset($news_info['date_start'])) {
				$news_info['date_start'] = date("d-m-Y H:i",$news_info['date_start']);
				$news_info['date_end'] = ($news_info['date_end'] != 0) ? date("d-m-Y H:i",$news_info['date_end']) : 0;
			}
		}
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['news_description'])) {
			$this->data['news_description'] = $this->request->post['news_description'];
		} elseif (isset($this->request->get['news_id'])) {
			$this->data['news_description'] = $this->model_catalog_news->getNewsDescriptions($this->request->get['news_id']);
		} else {
			$this->data['news_description'] = array();
		}
		
		
		// Image
		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} elseif (isset($news_info)) {
			$this->data['image'] = $news_info['image'];
		} else {
		    $this->data['image'] = '';
		}
		
		$this->load->model('tool/image');
		if (isset($news_info) && $news_info['image'] && file_exists(DIR_IMAGE . $news_info['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($news_info['image'], 100, 100);
		} else {
			$this->data['preview'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		
		$this->data['no_image'] =  $this->model_tool_image->resize('no_image.jpg', 100, 100);
		
		if (isset($this->request->post['fancybox'])) {
			$this->data['fancybox'] = $this->request->post['fancybox'];
		} elseif (isset($news_info)) {
			$this->data['fancybox'] = $news_info['fancybox'];
		} else {
			$this->data['fancybox'] = 0;
		}
		
		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (isset($news_info)) {
			$this->data['status'] = $news_info['status'];
		} else {
			$this->data['status'] = 1;
		}
		
		
		if (isset($this->request->post['date_start'])) {
			$this->data['date_start'] = $this->request->post['date_start'];
		} elseif (isset($news_info['date_start'])) {
			$this->data['date_start'] = $news_info['date_start'];
		} else {
			$this->data['date_start'] = date('d-m-Y H:i', time());
		}
		if ( isset($this->request->post['date_end']) ) {
			$this->data['date_end'] = $this->request->post['date_end'];
		} elseif ( isset($news_info['date_end']) ) {
			$this->data['date_end'] = $news_info['date_end'];
		} else {
			$this->data['date_end'] = 0;
		}
		
		
		$this->load->model('setting/store');
		
		$this->data['stores'] = $this->model_setting_store->getStores();
		
		if (isset($this->request->post['news_store'])) {
			$this->data['news_store'] = $this->request->post['news_store'];
		} elseif (isset($news_info)) {
			$this->data['news_store'] = $this->model_catalog_news->getNewsStores($this->request->get['news_id']);
		} else {
			$this->data['news_store'] = array(0);
		}		
		
		if (isset($this->request->post['keyword'])) {
			$this->data['keyword'] = $this->request->post['keyword'];
		} elseif (isset($news_info)) {
			$this->data['keyword'] = $news_info['keyword'];
		} else {
			$this->data['keyword'] = '';
		}
		
		if (isset($this->request->post['news_layout'])) {
                        $this->data['news_layout'] = $this->request->post['news_layout'];
                } elseif (isset($this->request->get['news_id'])) {
                        $this->data['news_layout'] = $this->model_catalog_news->getNewsLayouts($this->request->get['news_id']);
                } else {
                        $this->data['news_layout'] = array();
                }

		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
				
		$this->template = 'catalog/news_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/news')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		/* BEGIN Check Date & Time */
		if  ( ! preg_match('/\d{2}-\d{2}-\d{4} \d{1,2}:\d{1,2}/', $this->request->post['date_start'] ) ) {
			$this->error['warning'] = $this->language->get('error_date_start');
		}
		
		if ( isset($this->request->post['date_never']) AND $this->request->post['date_never'] == 'on' ) {
			$this->request->post['date_end'] = 0;
		} elseif ( ! preg_match('/\d{2}-\d{2}-\d{4} \d{1,2}:\d{1,2}/', $this->request->post['date_end'])  ) {
			$this->error['warning'] = $this->language->get('error_date_end');
		}
		/* END Check Date & Time */
		
		foreach ($this->request->post['news_description'] as $language_id => $value) {
			if ((strlen(utf8_decode($value['caption'])) < 3) || (strlen(utf8_decode($value['caption'])) > 254)) {
				$this->error['caption'][$language_id] = $this->language->get('error_caption');
			}
		
			if (strlen(utf8_decode($value['description'])) < 3) {
				$this->error['description'][$language_id] = $this->language->get('error_description');
			}
			if (strlen(utf8_decode($value['content'])) < 3) {
				$this->error['content'][$language_id] = $this->language->get('error_content');
			}
		}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
			
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	
	private function setDatepickerLanguage() {
		if ( isset($this->session->data['language']) ) {
			 if (file_exists(DIR_APPLICATION . 'view/javascript/jquery/ui/i18n/jquery.ui.datepicker-'. $this->session->data['language'] . '.js')) {
				$this->document->addScript('view/javascript/jquery/ui/i18n/jquery.ui.datepicker-'. $this->session->data['language'] . '.js');
			}
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/news')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		//$this->load->model('setting/store');
		/*
		foreach ($this->request->post['selected'] as $news_id) {
		}*/

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>