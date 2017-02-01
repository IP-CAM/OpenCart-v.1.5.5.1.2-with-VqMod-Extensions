<?php
class ModelCatalogNews extends Model {
	public function getNews($news_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM `" . DB_PREFIX . "news` n LEFT JOIN `" . DB_PREFIX . "news_description` nd ON (n.news_id = nd.news_id) LEFT JOIN `" . DB_PREFIX . "news_to_store` n2s ON (n.news_id = n2s.news_id) WHERE n.news_id = '" . (int)$news_id . "' AND nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND n.status = '1'");
		return $query->row;
	}

	public function getNewsAll($start = 0, $limit = 5) {
		$query = $this->db->query("SELECT
				n.news_id,
				n.image,
				n.date_start,
				n.date_end,
				nd.caption,
				nd.description
			FROM `" . DB_PREFIX . "news` n 
				LEFT JOIN `" . DB_PREFIX . "news_description` nd ON (n.news_id = nd.news_id)
				LEFT JOIN `" . DB_PREFIX . "news_to_store` n2s ON (n.news_id = n2s.news_id)
			WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "'  
				AND n2s.store_id = '" . (int)$this->config->get('config_store_id') . "'
				AND n.status = '1'
				AND n.date_start <= UNIX_TIMESTAMP()
				AND ( n.date_end >= UNIX_TIMESTAMP() OR n.date_end = 0 )
				ORDER BY n.date_start DESC LIMIT " . (int)$start . "," . (int)$limit);
		return $query->rows;
	}
	public function getNewsLayoutId($news_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_to_layout WHERE news_id = '" . (int)$news_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");
		 
		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return $this->config->get('config_layout_news');
		}
	}
	public function getNewsTotal() {
		$query = $this->db->query("SELECT COUNT(n.news_id) AS total FROM `" . DB_PREFIX . "news` n WHERE n.status = '1' AND UNIX_TIMESTAMP(n.date_start) <= UNIX_TIMESTAMP() AND ( n.date_end >= UNIX_TIMESTAMP() OR n.date_end = 0 )");
	        return $query->row['total'];
	}
}
?>