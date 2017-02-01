<?php 
class ControllerInformationNews extends Controller {
	private $error = array();
	
	public function index() {  
		$this->language->load('information/news');
		
		$this->load->model('catalog/news');
		
		$this->data['text_date_added'] = $this->language->get('text_date_added');
		
		$this->data['breadcrumbs'] = array();
		
		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
			'separator' => ''
		);
		
		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_news'),
			'href'      => $this->url->link('information/news'),
			'separator' => $this->language->get('text_separator')
		);
		
		if (isset($this->request->get['news_id'])) {
			$this->getNews($this->request->get['news_id']);
		} else {
			$this->getList();
		}
		
		
		if ($this->error && isset($this->error['error'])) {
				
	  			$this->document->setTitle($this->error['error']);

				$news_all = NULL;

				$this->data['heading_title'] = $this->language->get('text_error');
				$this->data['text_error'] = $this->language->get('text_error');
				$this->data['button_continue'] = $this->language->get('button_continue');
				$this->data['continue'] = $this->url->link('common/home');

				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
						$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
				} else {
						$this->template = 'default/template/error/not_found.tpl';
				}
			
		} else {
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/stylesheet-news.css')) {
						$css = 'catalog/view/theme/'.$this->config->get('config_template') . '/stylesheet/stylesheet-news.css'; 
				} else {
						$css = 'catalog/view/theme/default/stylesheet/stylesheet-news.css';
				}
		
				$this->document->addStyle($css);
		
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/news.tpl')) {
						$this->template = $this->config->get('config_template') . '/template/information/news.tpl';
				} else {
						$this->template = 'default/template/information/news.tpl';
				}
		
		}
		
		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'
		);
				
 		$this->response->setOutput($this->render());
  	}
	
	/* Get one news by news_id */
	public function getNews($news_id) {

			$date_format = $this->language->get('date_long_format');

			$news = $this->model_catalog_news->getNews($news_id);
			if (!$news) {
					$this->error['error'] = $this->language->get('text_error');
					return;
			}
			
			$this->data['breadcrumbs'][] = array(
				'text'      => $news['caption'],
				'href'      => $this->url->link('information/news', 'news_id=' .  $news_id),
				'separator' => $this->language->get('text_separator')
			);

			
			/* Add Document:Title  */
			if($news['title']) {
				$this->document->setTitle($news['title']);
			} else {
				$this->document->setTitle($news['caption']);
			}
			/* Add Document:Link-Canonical */
			$this->document->addLink($this->url->link('information/news','news_id=' . $news_id), 'canonical');
			
			/* Add Document:Meta-Description */
			if ($news['meta_description']) {
				$this->document->setDescription($news['meta_description']);
			}
			
			/* Add Document:Meta-Keywords */
			if ($news['meta_keywords']) {
				$this->document->setKeywords($news['meta_keywords']);
			}
			
			/* Add Document:H1 */
			if ($news['h1']) {
				$this->data['h1'] = $news['h1'];
			} else {
				$this->data['h1'] = $news['caption'];
			}
			$this->data['caption']		= $news['caption'];
			$this->data['news_id']		= $news['news_id'];
			$this->data['date']		= date( $date_format, $news['date_start'] );
			$this->data['lightbox']		= NULL;
			
			/* Content Caching */
			$news_content = $this->cache->get('news_content.' . $this->config->get('config_language_id'). '.' . $news['news_id']);

			if ( !$news_content ) {

				$this->data['content'] = html_entity_decode($news['content'], ENT_QUOTES, 'UTF-8');
				
				/* BEGIN colorBox robot */
				if ( $news['fancybox'] ) {
					$this->load->model('tool/image');
				
					if ( preg_match_all("/<img .*? src=[\'\"](.*?)[\'\"].*?height: (\d{1,4})px.*?width: (\d{1,4})px.*?\/>/s", $this->data['content'], $img) ){
						
						$pattern = "/<img alt=[\'\"](.*?)[\'\"] src=[\'\"](.*?)[\'\"].*?\/>/s";
						$replacement = '<a class="colorbox cboxElement" href="$2" title="$1">$0</a>';
						$this->data['content'] =  preg_replace($pattern, $replacement, $this->data['content']);

						for ($i = 0; $i < count($img[0]); $i++ ) {
							// Create Image
							$img_url = str_replace(HTTP_SERVER . 'image/', '', $img[1][$i]);
							 $new_img_url = $this->model_tool_image->resize($img_url, $img[3][$i],$img[2][$i] );
							$pattern = "/(<img .*?src=[\'\"])(" . addcslashes(HTTP_SERVER . 'image/'. $img_url,'/.') . ")([\'\"].*?height: (\d{1,4})px.*?width: (\d{1,4})px.*?\/>)/s";
							$replacement = '$1'. $new_img_url . '$3';
							$this->data['content'] =  preg_replace($pattern, $replacement, $this->data['content']);
						}
					}
					$this->data['lightbox'] = TRUE;
				} 
				/* END colorBox robot */
				$this->cache->set('news_content.' . $this->config->get('config_language_id'). '.' . $news['news_id'], $this->data['content']);
			} else {
				$this->data['content']  = $news_content;
				if ( $news['fancybox'] ) {
					$this->data['lightbox'] = TRUE;
				}
			}
			
			$this->data['button_continue'] = $this->language->get('button_all_news');
			$this->data['continue'] = $this->url->link('information/news');

			$this->document->addStyle('catalog/view/javascript/jquery/colorbox/colorbox.css');
			$this->document->addScript('catalog/view/javascript/jquery/colorbox/jquery.colorbox-min.js');

	}
	
	/* Get news list */
	public function getList() {
			$this->load->model('tool/image');
			
			$this->document->setTitle($this->language->get('text_news_title'));
			
			$this->data['h1'] = $this->language->get('text_news');

			$this->data['text_read_more'] = $this->language->get('text_read_more');
			
			$date_format = $this->language->get('date_long_format');
			$this->data['text_limit'] = $this->language->get('text_limit');
			
			if (isset($this->request->get['page'])) {
					$page = $this->request->get['page'];
			} else { 
					$page = 1;
			}
							
			if (isset($this->request->get['limit'])) {
					$limit = $this->request->get['limit'];
			} else {
					$limit = 5;
			}
			
			$url = 'limit=' . $limit;

			$news_total = $this->model_catalog_news->getNewsTotal(); 
			
			$results = $this->model_catalog_news->getNewsAll( ($page - 1) * $limit, $limit);
			
			$this->data['news_all'] = array();
			foreach ($results as $result) {
				
					if ($result['image']) {
							$image = $this->model_tool_image->resize($result['image'], 200, 50);
					} else {
							$image = FALSE;
					}
			
					$this->data['news_all'][] = array(
							'caption'	=> $result['caption'],
							'date'		=> date( $date_format, $result['date_start'] ),
							'thumb'		=> $image,
							'description'	=> html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'),
							'href'		=> $this->url->link('information/news', 'news_id=' . $result['news_id'])
					);					
			}
			
			$this->data['limits'] = array();
			
			$this->data['limits'][] = array(
				'text'  => 5,
				'value' => 5,
				'href'  => $this->url->link('information/news', 'limit=5')
			);

			$this->data['limits'][] = array(
				'text'  => 10,
				'value' => 10,
				'href'  => $this->url->link('information/news', 'limit=10')
			);
			
			$this->data['limits'][] = array(
				'text'  => 15,
				'value' => 15,
				'href'  => $this->url->link('information/news', 'limit=15')
			);
		
			$pagination = new Pagination();
			$pagination->total = $news_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('information/news', 'page={page}&limit=' .$limit);
		
			$this->data['pagination'] = $pagination->render();

			$this->data['limit'] = $limit;
	
	}
	
	public function info() {
		$this->load->model('catalog/news');
		
		if (isset($this->request->get['news_id'])) {
			$news_id = $this->request->get['news_id'];
		} else {
			$news_id = 0;
		}      
		
		$news_info = $this->model_catalog_news->getNews($news_id);

		if ($news_info) {
			$output  = '<html dir="ltr" lang="en">' . "\n";
			$output .= '<head>' . "\n";
			$output .= '  <title>' . $news_info['title'] . '</title>' . "\n";
			$output .= '  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' . "\n";
			$output .= '</head>' . "\n";
			$output .= '<body>' . "\n";
			$output .= '  <br /><br /><h1>' . $news_info['title'] . '</h1>' . "\n";
			$output .= html_entity_decode($news_info['description'], ENT_QUOTES, 'UTF-8') . "\n";
			$output .= '  </body>' . "\n";
			$output .= '</html>' . "\n";

			$this->response->setOutput($output);
		}
	}
}
?>