<?php
class ModelCauruselAllModel extends Model {
	
	public function getHighestRatingProducts($limit) { 
        $query = $this->db->query("SELECT *, AVG(rating) AS total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "review r ON (p.product_id = r.product_id ) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' and r.status = '1' GROUP BY r.product_id ORDER BY total DESC LIMIT " . (int)$limit);	
		
		return $query->rows;
	}
	
	public function getLatestReviewProducts($limit) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "review r ON (p.product_id = r.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND r.status = '1' ORDER BY r.date_added DESC LIMIT " . (int)$limit);
		
		return $query->rows;
	}
}
?>