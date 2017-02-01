<?php
class ModelShippingcitycenter extends Model {
	function getQuote($address) {
		$this->load->language('shipping/citycenter');
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('citycenter_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
	
		if (!$this->config->get('citycenter_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();
	
		if ($status) {
			$quote_data = array();
			
      		$quote_data['citycenter'] = array(
        		'code'         => 'citycenter.citycenter',
        		'title'        => $this->language->get('text_description'),
        		'cost'         => $this->config->get('citycenter_cost'),
        		'tax_class_id' => $this->config->get('citycenter_tax_class_id'),
				'text'         => $this->currency->format($this->tax->calculate($this->config->get('citycenter_cost'), $this->config->get('citycenter_tax_class_id'), $this->config->get('config_tax')))
      		);

      		$method_data = array(
        		'code'       => 'citycenter',
        		'title'      => $this->language->get('text_title'),
        		'quote'      => $quote_data,
				'sort_order' => $this->config->get('citycenter_sort_order'),
        		'error'      => false
      		);
		}
	
		return $method_data;
	}
}
?>