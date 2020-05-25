<?php 
class ModelPaymentBtcLightningPayment extends Model {
  	public function getMethod($address, $total) {
		$this->language->load('payment/btc_lightning_payment');

		if($this->config->get('btc_lightning_payment_status') == true) {
			$status = true;
		}


    	$connection = @fsockopen($this->config->get('btc_lightning_node_ip'), $this->config->get('btc_lightning_node_port'));
	    if (is_resource($connection)){
	        fclose($connection);
	    }
	    else{
	     $status = false;
	 	}
	 	
		if ($this->config->get('btc_lightning_payment_total') > 0 && $this->config->get('btc_lightning_payment_total') > $total) {
			$status = false;
		}
		
		$method_data = array();
	
		if ($status) {  
      		$method_data = array( 
        		'code'       => 'btc_lightning_payment',
        		'title'      => $this->language->get('text_title'),
				'sort_order' => $this->config->get('btc_lightning_payment_sort_order')
      		);
    	}
   
    	return $method_data;
  	}
}
?>