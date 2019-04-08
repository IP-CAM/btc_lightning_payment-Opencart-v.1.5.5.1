<?php 
class ModelPaymentBtcLightningPayment extends Model {
  	public function getMethod($address, $total) {
		$this->language->load('payment/btc_lightning_payment');
		

		$json = file_get_contents('https://api.coinmarketcap.com/v1/ticker/bitcoin/');
		$obj = json_decode($json);
		$btc_percent_change_24h = abs($obj[0]->percent_change_24h);
		$percent_change_7d = abs($obj[0]->percent_change_7d);

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



		if($this->config->get('btc_lightning_payment_price_change_amount') != null && $this->config->get('btc_lightning_payment_price_change_amount') != 0){
			if($btc_percent_change_24h > $this->config->get('btc_lightning_payment_price_change_amount') || $percent_change_7d > $this->config->get('btc_lightning_payment_price_change_amount')){
				$status = false;
			}
		}elseif ($this->config->get('btc_lightning_payment_total') > 0 && $this->config->get('btc_lightning_payment_total') > $total) {
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