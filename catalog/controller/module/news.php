<?php  
class ControllerModuleNews extends Controller {
	private $_name = 'news';

	protected function index($module) {

		$this->language->load('module/news');
    	
		$this->data['text_read_more'] = $this->language->get('text_read_more');
		$this->data['text_date_added'] = $this->language->get('text_date_added');
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		if ( $module['date'] != '' ) {
				$date_format = $module['date'];
		} else {
				$date_format = 'd.m.Y';
		}

		if ( isset($module['limit']) ) {
			$news_limit = $module['limit'];
		} else {
			$news_limit = 4;
		}

		$this->data['col_width'] = (int)(100 / $news_limit);	 
		
		$this->data['style'] = $module['style'];
		
		$this->load->model('catalog/news');
		$this->load->model('tool/image');
				
		$this->data['news_all'] = array();
		
		foreach ($this->model_catalog_news->getNewsAll(0, $news_limit) as $result ) {
				if ($result['image']) {
						$image = $this->model_tool_image->resize($result['image'], 226, 48);
						$image_small = $this->model_tool_image->resize($result['image'], 70, 70);
				} else {
						$image = FALSE;
						$image_small = FALSE;
				}
			$this->data['news_all'][] = array(
				'date'			=> date( $date_format, $result['date_start'] ),
				'caption'		=> $result['caption'],
				'thumb'			=> $image,
				'thumb_small'	=> $image_small,
				'description'	=> html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'),
				'href'			=> $this->url->link('information/news', 'news_id=' . $result['news_id'])
			);
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/stylesheet-news.css')) {
			$css = 'catalog/view/theme/'.$this->config->get('config_template') . '/stylesheet/stylesheet-news.css'; 
		} else {
			$css = 'catalog/view/theme/default/stylesheet/stylesheet-news.css';
		}
		
		$this->document->addStyle($css);
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/news.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/news.tpl';
		} else {
			$this->template = 'default/template/module/news.tpl';
		}
		$this->render();
	}
}
?>