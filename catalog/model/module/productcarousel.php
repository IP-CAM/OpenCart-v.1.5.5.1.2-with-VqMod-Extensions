<?php
class ModelModuleProductCarousel extends Model {	
	
  public function getProduct($product_id) {
    if ($this->customer->isLogged()) {
        $customer_group_id = $this->customer->getCustomerGroupId();
    } else {
        $customer_group_id = $this->config->get('config_customer_group_id');
    }	
				
    $query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$customer_group_id . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, (SELECT points FROM " . DB_PREFIX . "product_reward pr WHERE pr.product_id = p.product_id AND customer_group_id = '" . (int)$customer_group_id . "') AS reward, (SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "') AS stock_status, (SELECT wcd.unit FROM " . DB_PREFIX . "weight_class_description wcd WHERE p.weight_class_id = wcd.weight_class_id AND wcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS weight_class, (SELECT lcd.unit FROM " . DB_PREFIX . "length_class_description lcd WHERE p.length_class_id = lcd.length_class_id AND lcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS length_class, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r2 WHERE r2.product_id = p.product_id AND r2.status = '1' GROUP BY r2.product_id) AS reviews FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");
		
    if ($query->num_rows) {
        return array(
          'product_id'       => $query->row['product_id'],
          'name'             => $query->row['name'],
          'description'      => $query->row['description'],
          'meta_description' => $query->row['meta_description'],
          'meta_keyword'     => $query->row['meta_keyword'],
          'model'            => $query->row['model'],
          'model'            => $query->row['model'],
          'sku'              => $query->row['sku'],
          'upc'              => $query->row['upc'],
          'location'         => $query->row['location'],
          'quantity'         => $query->row['quantity'],
          'stock_status'     => $query->row['stock_status'],
          'image'            => $query->row['image'],
          'manufacturer_id'  => $query->row['manufacturer_id'],
          'manufacturer'     => $query->row['manufacturer'],
          'price'            => ($query->row['discount'] ? $query->row['discount'] : $query->row['price']),
          'special'          => $query->row['special'],
          'reward'           => $query->row['reward'],
          'points'           => $query->row['points'],
          'tax_class_id'     => $query->row['tax_class_id'],
          'date_available'   => $query->row['date_available'],
          'weight'           => $query->row['weight'],
          'weight_class_id'  => $query->row['weight_class_id'],
          'length'           => $query->row['length'],
          'width'            => $query->row['width'],
          'height'           => $query->row['height'],
          'length_class_id'  => $query->row['length_class_id'],
          'subtract'         => $query->row['subtract'],
          'rating'           => (int)$query->row['rating'],
          'reviews'          => $query->row['reviews'],
          'minimum'          => $query->row['minimum'],
          'sort_order'       => $query->row['sort_order'],
          'status'           => $query->row['status'],
          'date_added'       => $query->row['date_added'],
          'date_modified'    => $query->row['date_modified'],
          'viewed'           => $query->row['viewed']
        );
      } else {
        return false;
      }
  }
	
  public function getProducts($data = array()) {
    $cache = md5(http_build_query($data));
		
    $product_data = $this->cache->get('productcarousel.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $cache);
   		
    if (!$product_data) {
        switch ((int)$data['source']) {
          case 2: //Products Special
            $sql = "SELECT DISTINCT ps.product_id, (SELECT AVG(rating) FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = ps.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating FROM " . DB_PREFIX . "product_special ps LEFT JOIN " . DB_PREFIX . "product p ON (ps.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$data['customer_group_id'] . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) GROUP BY ps.product_id";
            break;
          
          case 3: //Products Bestseller
            $sql = "SELECT * FROM (SELECT op.product_id, COUNT(*) AS total FROM " . DB_PREFIX . "order_product op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) LEFT JOIN `" . DB_PREFIX . "product` p ON (op.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE o.order_status_id > '0' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' GROUP BY op.product_id ORDER BY total DESC) as tmp";
            break;
          
          case 4: //Latest Products
            $sql = "select * FROM (SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.date_added DESC) as tmp";
            break;
          
          case 5: //Category
          case 6: //Category Product
          case 7: //Category Current
            $sql = "SELECT p.product_id, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'"; 
      
            if (isset($data['filter_name']) && $data['filter_name']) {
                if (isset($data['filter_description']) && $data['filter_description']) {
                    $sql .= " AND (LCASE(pd.name) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_name'], 'UTF-8')) . "%' OR p.product_id IN (SELECT pt.product_id FROM " . DB_PREFIX . "product_tag pt WHERE pt.language_id = '" . (int)$this->config->get('config_language_id') . "' AND LCASE(pt.tag) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_name'], 'UTF-8')) . "%') OR LCASE(pd.description) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_name'], 'UTF-8')) . "%')";
                } else {
                    $sql .= " AND (LCASE(pd.name) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_name'], 'UTF-8')) . "%' OR p.product_id IN (SELECT pt.product_id FROM " . DB_PREFIX . "product_tag pt WHERE pt.language_id = '" . (int)$this->config->get('config_language_id') . "' AND LCASE(pt.tag) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_name'], 'UTF-8')) . "%'))";
                }
            }
			
            if (isset($data['filter_tag']) && $data['filter_tag']) {
                $sql .= " AND p.product_id IN (SELECT pt.product_id FROM " . DB_PREFIX . "product_tag pt WHERE pt.language_id = '" . (int)$this->config->get('config_language_id') . "' AND LCASE(pt.tag) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_tag'], 'UTF-8')) . "%')";
            }
						
            if (isset($data['filter_category_id']) && $data['filter_category_id']) {
                if (isset($data['filter_sub_category']) && $data['filter_sub_category']) {
                    $implode_data = array();

                    $this->load->model('catalog/category');

                    $categories = $this->model_catalog_category->getCategoriesByParentId($data['filter_category_id']);

                    foreach ($categories as $category_id) {
                        $implode_data[] = "p2c.category_id = '" . (int)$category_id . "'";
                    }

                    $sql .= " AND p.product_id IN (SELECT p2c.product_id FROM " . DB_PREFIX . "product_to_category p2c WHERE " . implode(' OR ', $implode_data) . ")";			
                } else {
                    $sql .= " AND p.product_id IN (SELECT p2c.product_id FROM " . DB_PREFIX . "product_to_category p2c WHERE p2c.category_id = '" . (int)$data['filter_category_id'] . "')";
                }
            }
			
            if (isset($data['filter_manufacturer_id'])) {
                $sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
            }

            $sql .= " GROUP BY p.product_id";
            
            break;
						
					case 8: //Products Related
            $sql = "select * FROM (SELECT pr.related_id product_id FROM " . DB_PREFIX . "product_related pr INNER JOIN " . DB_PREFIX . "product p ON (pr.related_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pr.product_id = '" . (int)$data['product_id'] . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "') as tmp";
            break;	
						
					case 9: //Multi Category
            $sql = "SELECT p.product_id, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'"; 
						
						if (isset($data['filter_categories_id']) && $data['filter_categories_id']) {
								$implode_data = array();

								foreach ($data['filter_categories_id'] as $category_id) {
									$implode_data[] = "p2c.category_id = '" . (int)$category_id . "'";
								}

								$sql .= " AND p.product_id IN (SELECT p2c.product_id FROM " . DB_PREFIX . "product_to_category p2c WHERE " . implode(' OR ', $implode_data) . ")";			
						}
						
            break;
						
					case 10: //Product Manufacturer
					case 11: //Current Manufacturer 
            $sql = "SELECT p.product_id, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'"; 
						
						if (isset($data['filter_manufacturers_id']) && $data['filter_manufacturers_id']) {
								$implode_data = array();

								foreach ($data['filter_manufacturers_id'] as $manufacturer_id) {
									$implode_data[] = "p.manufacturer_id = '" . (int)$manufacturer_id . "'";
								}

								$sql .= " AND (" . implode(' OR ', $implode_data) . ") ";			
						}
						
            break;
        }
              			
        $sort_data = array(
          'pd.name',
          'p.model',
          'p.quantity',
          'p.price',
          'rating',
          'p.sort_order',
          'p.date_added'
        );	
			
        if (isset($data['random']) && $data['random'] == '1') {
            $sql .= " ORDER BY RAND()";
        } else {
            if ($data['has_sort']) {
                if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
                    if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
                        $sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
                    } else {
                        $sql .= " ORDER BY " . $data['sort'];
                    }
                } else {
                    $sql .= " ORDER BY p.sort_order";
                }

                if (isset($data['order']) && ($data['order'] == 'DESC')) {
                    $sql .= " DESC";
                } else {
                    $sql .= " ASC";
                }
            }
        }
		
        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }				

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }	

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }
			
        $product_data = array();

        $query = $this->db->query($sql);

        foreach ($query->rows as $result) {
          $product_data[$result['product_id']] = $this->getProduct($result['product_id']);
        }
			
        if ($data['cache_enabled']) {
            $this->cache->set('productcarousel.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $cache, $product_data);
        }
        
    } else {
        if ($data['random']) {
            shuffle($product_data);
        }
    }
		
    return $product_data;
  }
	
  public function getProductSpecials($data = array()) {
    if ($this->customer->isLogged()) {
        $customer_group_id = $this->customer->getCustomerGroupId();
    } else {
        $customer_group_id = $this->config->get('config_customer_group_id');
    }	

    $cache = md5(http_build_query($data));
    
    $product_data = $this->cache->get('productcarousel.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$customer_group_id . '.' . $cache);
    
    if (!$product_data) {
    
        $sql = "SELECT DISTINCT ps.product_id, (SELECT AVG(rating) FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = ps.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating FROM " . DB_PREFIX . "product_special ps LEFT JOIN " . DB_PREFIX . "product p ON (ps.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) GROUP BY ps.product_id";

        $sort_data = array(
          'pd.name',
          'p.model',
          'ps.price',
          'rating',
          'p.sort_order'
        );

        if (isset($data['random']) && $data['random'] == '1') {
            $sql .= " ORDER BY RAND()";
        } else {
            if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
                if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
                    $sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
                } else {
                    $sql .= " ORDER BY " . $data['sort'];
                }
            } else {
                $sql .= " ORDER BY p.sort_order";
            }

            if (isset($data['order']) && ($data['order'] == 'DESC')) {
                $sql .= " DESC";
            } else {
                $sql .= " ASC";
            }
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }				

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }	

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $product_data = array();

        $query = $this->db->query($sql);

        foreach ($query->rows as $result) { 		
          $product_data[$result['product_id']] = $this->getProduct($result['product_id']);
        }
        
        if ($data['cache_enabled']) {
            $this->cache->set('productcarousel.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$customer_group_id . '.' . $cache, $product_data);
        }
        
    } else {
        if ($data['random']) {
            shuffle($product_data);
        }
    }
        
    return $product_data;
  }

  public function getLatestProducts($data = array()) {
    $cache = md5(http_build_query($data));
    
    $product_data = $this->cache->get('productcarousel.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $cache);
    
    if (!$product_data) {
        $sql = "select * FROM (SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.date_added DESC) as tmp";

        if (isset($data['random']) && $data['random'] == '1') {
            $sql .= " ORDER BY RAND()";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }				

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }	

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);

        foreach ($query->rows as $result) {
          $product_data[$result['product_id']] = $this->getProduct($result['product_id']);
        }
        
        if ($data['cache_enabled']) {
            $this->cache->set('productcarousel.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $cache, $product_data);
        }
        
    } else {
        if ($data['random']) {
            shuffle($product_data);
        }
    }
    
    return $product_data;
  }
	
  public function getProductsRelated($data = array()) {
    $cache = md5(http_build_query($data));
    
    $product_data = $this->cache->get('productcarousel.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $cache);
    
    if (!$product_data) {
        $sql = "select * FROM (SELECT pr.related_id FROM " . DB_PREFIX . "product_related pr INNER JOIN " . DB_PREFIX . "product p ON (pr.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pr.product_id = '" . (int)$data['product_id'] . "' p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "') as tmp";

        if (isset($data['random']) && $data['random'] == '1') {
            $sql .= " ORDER BY RAND()";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }				

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }	

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);

        foreach ($query->rows as $result) {
          $product_data[$result['product_id']] = $this->getProduct($result['related_id']);
        }
        
        if ($data['cache_enabled']) {
            $this->cache->set('productcarousel.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $cache, $product_data);
        }
        
    } else {
        if ($data['random']) {
            shuffle($product_data);
        }
    }
    
    return $product_data;
  }
  
  public function getPopularProducts($data = array()) {
    $cache = md5(http_build_query($data));
    
    $product_data = $this->cache->get('productcarousel.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $cache);
    
    if (!$product_data) {
		
        $sql = "select * FROM (SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.viewed, p.date_added DESC) as tmp";

        if (isset($data['random']) && $data['random'] == '1') {
            $sql .= " ORDER BY RAND()";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }				

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }	

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);

        foreach ($query->rows as $result) { 		
          $product_data[$result['product_id']] = $this->getProduct($result['product_id']);
        }
        
        if ($data['cache_enabled']) {
            $this->cache->set('productcarousel.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $cache, $product_data);
        }
        
		} else {
        if ($data['random']) {
            shuffle($product_data);
        }
    }
    
    return $product_data;
  }

  public function getBestSellerProducts($data = array()) {
    $cache = md5(http_build_query($data));
    
    $product_data = $this->cache->get('productcarousel.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $cache);
    
    if (!$product_data) {
			
        $sql = "SELECT *FROM (SELECT op.product_id, COUNT(*) AS total FROM " . DB_PREFIX . "order_product op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) LEFT JOIN `" . DB_PREFIX . "product` p ON (op.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE o.order_status_id > '0' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' GROUP BY op.product_id ORDER BY total DESC) as tmp";

        if (isset($data['random']) && $data['random'] == '1') {
            $sql .= " ORDER BY RAND()";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }				

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }	

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);

        foreach ($query->rows as $result) { 		
          $product_data[$result['product_id']] = $this->getProduct($result['product_id']);
        }
        
        if ($data['cache_enabled']) {
            $this->cache->set('productcarousel.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $cache, $product_data);
        }
        
    } else {
        if ($data['random']) {
            shuffle($product_data);
        }
    }
    
    return $product_data;
  }

  public function getCategoryProducts($product_id, $data = array()) {
    $cache = md5(http_build_query($data));
    
    $product_data = $this->cache->get('productcarousel.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $cache);
    
    if (!$product_data) {
        $sql = "select pc.product_id FROM (SELECT DISTINCT product_id FROM `". DB_PREFIX . "product_to_category` WHERE category_id IN (SELECT DISTINCT category_id FROM `". DB_PREFIX . "product_to_category` WHERE product_id = '" . (int)$product_id . "')) pc INNER JOIN `". DB_PREFIX . "product` p ON (pc.product_id = p.product_id) LEFT JOIN `". DB_PREFIX . "product_to_store` p2s ON (pc.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ";

        if (isset($data['random']) && $data['random'] == '1') {
            $sql .= " ORDER BY RAND()";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }				

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }	

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);

        foreach ($query->rows as $result) {
          if ($result['product_id'] != $product_id) {
              $product_data[$result['product_id']] = $this->getProduct($result['product_id']);
          }
        }
        
        if ($data['cache_enabled']) {
            $this->cache->set('productcarousel.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $cache, $product_data);
        }
        
		} else {
        if ($data['random']) {
            shuffle($product_data);
        }
    }
    
    return $product_data;
  }
}
?>