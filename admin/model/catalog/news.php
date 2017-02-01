<?php
class ModelCatalogNews extends Model {
	
	public function addNews($data) {
		/* Format date & time */
		$data['date_start'] = strtotime( preg_replace('|^([0-9]{2})-([0-9]{2})-([0-9]{4})|', "\\3-\\2-\\1", $data['date_start']) . ':00' );
		
		if ($data['date_end'] != 0) {
			$data['date_end'] = strtotime( preg_replace('|^([0-9]{2})-([0-9]{2})-([0-9]{4})|', "\\3-\\2-\\1", $data['date_end']). ':00' );
		}
		
		$this->db->query("INSERT INTO `" . DB_PREFIX . "news` SET 
			`image` = '" . (string)$data['image'] . "', 
			`status` = '" . (int)$data['status'] . "',
			`fancybox` = '".(int)$data['fancybox']."',
			`date_start` = '".(int)$data['date_start']."',
			`date_end` = '".(int)$data['date_end']."'
			");

		$news_id = $this->db->getLastId(); 
		$this->updateNewsDescription($news_id, $data['news_description']);
		
		if (isset($data['news_store'])) {
			foreach ($data['news_store'] as $store_id) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "news_to_store` SET `news_id` = '" . (int)$news_id . "', `store_id` = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['news_layout'])) {
			foreach ($data['news_layout'] as $store_id => $layout) {
				if ($layout) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "news_to_layout` SET `news_id` = '" . (int)$news_id . "', `store_id` = '" . (int)$store_id . "', `layout_id` = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}

		if ($data['keyword']) {
			$this->updateNewsKeyword($news_id, $data['keyword']);
		}
		
		$this->cache->delete('news_content');
	}
	
	private function updateNewsKeyword($news_id, $keyword) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "url_alias` WHERE `query` = 'news_id=" . (int)$news_id. "'");
		$query = $this->db->query("SELECT `keyword` FROM `" . DB_PREFIX . "url_alias` WHERE `keyword` = '" . $this->db->escape($keyword) . "'");
		if ( count($query->rows) > 0 ){
			$keyword = 'n' . (int)$news_id . '-' .  $keyword;
		}
		$this->db->query("INSERT INTO `" . DB_PREFIX . "url_alias` SET `query` = 'news_id=" . (int)$news_id . "', `keyword` = '" . $this->db->escape($keyword) . "'");
	}
	
	private function updateNewsDescription($news_id, $data) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "news_description` WHERE `news_id` = '" . (int)$news_id . "'");
		foreach ($data as $language_id => $value) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "news_description` SET 
				`news_id` = '" . (int)$news_id . "', 
				`language_id` = '" . (int)$language_id . "', 
				`title` = '" . $this->db->escape($value['title']) . "',
				`h1` = '" . $this->db->escape($value['h1']) . "',
				`caption` = '" . $this->db->escape($value['caption']) . "',
				`meta_keywords` = '" . $this->db->escape($value['meta_keywords']) . "',
				`meta_description` = '" . $this->db->escape($value['meta_description']) . "',
				`description` = '" . $this->db->escape($value['description']) . "', 
				`content` = '" . $this->db->escape($value['content']) . "'");
		}
	}
	public function editNews($news_id, $data) {
		/* Format date & time */
		$data['date_start'] = strtotime( preg_replace('|^([0-9]{2})-([0-9]{2})-([0-9]{4})|', "\\3-\\2-\\1", $data['date_start']) . ':00' );
		
		if ($data['date_end'] != 0) {
			$data['date_end'] = strtotime( preg_replace('|^([0-9]{2})-([0-9]{2})-([0-9]{4})|', "\\3-\\2-\\1", $data['date_end']) . ':00' );
		}

		$this->db->query("UPDATE `" . DB_PREFIX . "news` SET
			`image` = '" . (string)$data['image'] . "',
			`date_start` = '" . (int)$data['date_start'] . "',
			`date_end` = '" . (int)$data['date_end'] . "',
			`status` = '" . (int)$data['status'] . "',
			`fancybox` = '" . (int)$data['fancybox'] . "'
			WHERE `news_id` = '" . (int)$news_id . "'");

		$this->updateNewsDescription($news_id, $data['news_description']);

		$this->db->query("DELETE FROM `" . DB_PREFIX . "news_to_store` WHERE `news_id` = '" . (int)$news_id . "'");
		
		if (isset($data['news_store'])) {
			foreach ($data['news_store'] as $store_id) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "news_to_store` SET `news_id` = '" . (int)$news_id . "', `store_id` = '" . (int)$store_id . "'");
			}
		}
		
		$this->db->query("DELETE FROM `" . DB_PREFIX . "news_to_layout` WHERE `news_id` = '" . (int)$news_id . "'");

		if (isset($data['news_layout'])) {
			foreach ($data['news_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "news_to_layout` SET news_id = '" . (int)$news_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}
		
		
		
		if ($data['keyword']) {
			$this->updateNewsKeyword($news_id, $data['keyword']);
		}
		
		$this->cache->delete('news_content');
	}
	
	public function deleteNews($news_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "news` WHERE `news_id` = '" . (int)$news_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "news_description` WHERE `news_id` = '" . (int)$news_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "news_to_store` WHERE `news_id` = '" . (int)$news_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "url_alias` WHERE `query` = 'news_id=" . (int)$news_id . "'");

		$this->cache->delete('news_content');
	}	

	public function getNews($news_id) {
		$query = $this->db->query(
			"SELECT DISTINCT *, (
			    SELECT keyword FROM `" . DB_PREFIX . "url_alias` WHERE `query` = 'news_id=" . (int)$news_id . "') AS keyword 
			    FROM `" . DB_PREFIX . "news` WHERE `news_id` = '" . (int)$news_id . "'");
		return $query->row;
	}
		
	public function getNewss($data = array()) {
		/*  Update news ofline status */
		$this->db->query("UPDATE `" . DB_PREFIX . "news` n SET n.status = 0 WHERE n.date_end < '".(int)(time())."' AND n.date_end <> 0");
		
		if ($data) {
			$sql = "SELECT * FROM `" . DB_PREFIX . "news` n 
				LEFT JOIN `" . DB_PREFIX . "news_description` nd ON (n.news_id = nd.news_id) 
				WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
			$sort_data = array(
				'n.date_start', 
				'nd.title'
			);		
		
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY n.date_start";
			}
			
			if (isset($data['order']) && ($data['order'] == 'ASC')) {
				$sql .= " ASC";
			} else {
				$sql .= " DESC";
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
			
			$news_data = $query->rows;
		} else {
			$news_data = $this->cache->get('news.' . $this->config->get('config_language_id'));
		
			if (!$news_data) {
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "news` n LEFT JOIN `" . DB_PREFIX . "news_description` nd ON (n.news_id = nd.news_id) WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY n.date_start");
	
				$news_data = $query->rows;
			
				$this->cache->set('news.' . $this->config->get('config_language_id'), $news_data);
			}	
			
		}
		
		/* Format date & time */
		/*$news_data['date_start'] = date('d-m-Y H:i', $news_data['date_start']);
		
		if ($news_data['date_end'] != 0) {
			$news_data['date_end'] = date('d-m-Y H:i', $news_data['date_end']);
		}*/
		
		return $news_data;
	}
	
	public function getNewsDescriptions($news_id) {
		$news_description_data = array();
		
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "news_description` WHERE news_id = '" . (int)$news_id . "'");

		foreach ($query->rows as $result) {
			$news_description_data[$result['language_id']] = array(
				'title'			=> $result['title'],
				'h1'			=> $result['h1'],
				'caption'		=> $result['caption'],
				'meta_keywords'		=> $result['meta_keywords'],
				'meta_description'      => $result['meta_description'],
				'description'		=> $result['description'],
				'content'		=> $result['content']
			);
		}
		
		return $news_description_data;
	}
	
	public function getNewsStores($news_id) {
		$news_store_data = array();
		
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "news_to_store` WHERE news_id = '" . (int)$news_id . "'");

		foreach ($query->rows as $result) {
			$news_store_data[] = $result['store_id'];
		}
		
		return $news_store_data;
	}
		
	public function getTotalNewss() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "news`");
		return $query->row['total'];
	}	
	
	public function getNewsLayouts($news_id) {
		$news_layout_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_to_layout WHERE news_id = '" . (int)$news_id . "'");
		
		foreach ($query->rows as $result) {
			$news_layout_data[$result['store_id']] = $result['layout_id'];
		}
		
		return $news_layout_data;
	}
	
	public function getTotalNewssByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "news_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}	

	public function install() {
		$sql_news = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "news` (
		  `news_id` int(11) NOT NULL AUTO_INCREMENT,
		  `image` varchar(255) NULL, 
		  `image_size` int(1) NOT NULL default '0', 
		  `date_start` int(11) NOT NULL DEFAULT '0',
		  `date_end` int(11) NOT NULL DEFAULT '0',
		  `status` int(1) NOT NULL DEFAULT '0',
		  `fancybox` int(1) NOT NULL DEFAULT '0',
		  PRIMARY KEY (`news_id`)
		) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";

		$sql_news_description = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "news_description` (
		  `news_id` int(11) NOT NULL,
		  `language_id` int(11) NOT NULL,
		  `title` varchar(255) NOT NULL DEFAULT '',
		  `meta_keywords` varchar(255) NOT NULL DEFAULT '',
		  `meta_description` varchar(255) NOT NULL DEFAULT '',
		  `h1` varchar(255) NOT NULL DEFAULT '',
		  `caption` varchar(255) NOT NULL DEFAULT '',
		  `description` text NOT NULL DEFAULT '',
		  `content` text NOT NULL DEFAULT '',
		  PRIMARY KEY (`news_id`,`language_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";

		$sql_news_to_layout = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "news_to_layout` (
		  `news_id` int(11) NOT NULL,
		  `store_id` int(11) NOT NULL,
		  `layout_id` int(11) NOT NULL,
		  PRIMARY KEY (`news_id`,`store_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";

		$sql_news_to_store = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "news_to_store` (
		  `news_id` int(11) NOT NULL,
		  `store_id` int(11) NOT NULL,
		  PRIMARY KEY (`news_id`,`store_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";
		
		$this->db->query($sql_news);
		$this->db->query($sql_news_description);
		$this->db->query($sql_news_to_layout);
		$this->db->query($sql_news_to_store);
		$this->db->query("INSERT INTO " . DB_PREFIX . "layout SET name = 'News'");
		$layout_id = $this->db->getLastId();
		$this->db->query("INSERT INTO " . DB_PREFIX . "layout_route SET layout_id = '" . (int)$layout_id . "', store_id = '0', route = '" . $this->db->escape('information/news') . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "url_alias` WHERE `query` LIKE 'news_id=%';");
		return TRUE;
	}
        public function uninstall() {
                $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "news`;");
                $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "news_description`;");
                $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "news_to_layout`;");
                $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "news_to_store`;");
                $this->db->query("DELETE FROM `" . DB_PREFIX . "url_alias` WHERE `query` LIKE 'news_id=%';");
                $this->cache->delete('news_content');
        }
}
?>