<?php  
class ThemeControlHelper extends Controller {
	private $layout_id = 0;
	private $theme = '';
	private $positions = array();
	private $positions_load = array();
	private $modulesList = array();
	/**
	getInstance
	**/
	public static function getInstance($registry,$theme='default'){
		static $_instance;
		if( !$_instance ){
			$_instance = new ThemeControlHelper($registry,$theme);
		}
		return $_instance;
	}
	
	/**
	__construct
	**/
	public function __construct($registry,$theme){
		$this->positions = array(
			'header',
			'mainmenu',
			'slideshow',
			'footer' );
			
		parent::__construct( $registry );
		$this->modules = $this->loadModules();
	}
	
	/**
	getModulesByPosition
	**/
	public function getModulesByPosition( $position ){
		if( isset($this->modulesList[$position]) ){
			return $this->modulesList[$position];
		}
		return ;
	}
	
	public function loadModules (){ 
		$this->load->model('setting/extension');
		$extensions = $this->model_setting_extension->getExtensions('module');		
		$module_data = array();
		$layout_id = $this->getLayoutId();
		foreach ($extensions as $extension) {
			$modules = $this->config->get($extension['code'] . '_module');
			if ($modules) {
				foreach ($modules as $module) {
					if (($module['layout_id'] == $layout_id || $module['layout_id'] == '9999' ) && in_array(trim($module['position']), $this->positions) && $module['status']) {
						$module_data[$module['position']][] = array(
							'code'       => $extension['code'],
							'setting'    => $module,
							'sort_order' => $module['sort_order']
						);				
					}
				}
			}
		}

		foreach( $module_data as $position => $modules ){
			$sort_order = array(); 
			foreach ($modules as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}
			array_multisort($sort_order, SORT_ASC, $module_data[$position]);
		}

		$this->data['modules'] = array();
		$output = array();
		foreach( $module_data as $position => $modules ){
			foreach ($modules as $module) {
				$module = $this->getChild('module/' . $module['code'], $module['setting']);
				
				if ($module) {
					$output[$position][] = $module;
				}
			} 
		} 
		$this->modulesList = $output;
	}
	
	/**
	getLayoutId();
	**/
	public function getLayoutId(){	
		if(!$this->layout_id) {
			if (isset($this->request->get['route'])) {
				$route = (string)$this->request->get['route'];
			} else {
				$route = 'common/home';
			}
			
			$layout_id = 0;
			
			if ($route == 'product/category' && isset($this->request->get['path'])) {
				$path = explode('_', (string)$this->request->get['path']);
					
				$layout_id = $this->model_catalog_category->getCategoryLayoutId(end($path));			
			}
			
			if ($route == 'product/product' && isset($this->request->get['product_id'])) {
				$layout_id = $this->model_catalog_product->getProductLayoutId($this->request->get['product_id']);
			}
			
			if ($route == 'module/eagency_quick_shop_product') {
				$layout_id = 1;
			}
			
			if ($route == 'information/information' && isset($this->request->get['information_id'])) {
				$layout_id = $this->model_catalog_information->getInformationLayoutId($this->request->get['information_id']);
			}
			
			if (!$layout_id) {
				$layout_id = $this->model_design_layout->getLayout($route);
			}
							
			if (!$layout_id) {
				$layout_id = $this->config->get('config_layout_id');
			}
			
			$this->layout_id = $layout_id;
		}
		return $this->layout_id;
	}
}
?>