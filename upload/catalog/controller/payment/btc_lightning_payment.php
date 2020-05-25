<?php
class ControllerPaymentBtcLightningPayment extends Controller {
	protected function index() {
        $this->load->model('checkout/order');

        $order_id = $this->session->data['order_id'];		
		$order_info = $this->model_checkout_order->getOrder($order_id);


		$add_percent = $this->config->get('btc_lightning_payment_add_percent');
		$total_order_usd = ($add_percent != 0 ? ($order_info['total'] * (1 + $add_percent/100)) : $order_info['total']);
		

		if(!isset($this->session->data['order_time']) || !isset($this->session->data['r_hash']) || $this->session->data['r_hash'] == false || ($this->session->data['order_time']+900 < time()) || $total_order_usd != $this->session->data['total_usd']){
			$btc_value = file_get_contents('https://blockchain.info/tobtc?currency=USD&value='.$total_order_usd);
			$this->session->data['order_time'] = time();
			$this->session->data['total_btc'] = $btc_value;
			$this->session->data['total_usd'] = $total_order_usd;

			if($btc_value > 0.043){
				$this->session->data['payment_request'] = sprintf($this->language->get('text_lightning_limit'), 4300000);
				$this->session->data['r_hash'] = false;
			}else{
				$invoice = $this->getPaymentRequest($this->config->get('config_name') . ' - ' . sprintf($this->language->get('invoice_text'),$order_id), $this->session->data['total_btc'] * 100000000);
				$this->session->data['payment_request'] = $invoice->payment_request;
				$this->session->data['r_hash'] = $invoice->r_hash;
				$this->session->data['payment_status'] = 'waiting_for_payment';
			}

			$this->data['order_payment_timelimit'] = $this->session->data['order_time']+900;
		}else{
			$this->data['order_payment_timelimit'] = $this->session->data['order_time']+900;
		}

		//date('Y-m-d h:i:s',time());

		$this->language->load('payment/btc_lightning_payment');

		$this->data['text_instruction'] = $this->language->get('text_instruction');
		$this->data['text_description'] = sprintf($this->language->get('text_description'),$this->session->data['total_btc'] * 100000000);
		$this->data['text_payment'] = $this->language->get('text_payment');
		$this->data['text_time_request'] = $this->language->get('text_time_request');
		$this->data['text_timeleft'] = $this->language->get('text_timeleft');
		$this->data['button_confirm'] = $this->language->get('button_confirm');
		$this->data['continue'] = $this->url->link('checkout/success');

		$this->data['total_btc'] = $this->session->data['total_btc'];
		$this->data['total_order_usd'] = $order_info['total'];
		$this->data['text_pubkey_full'] = sprintf($this->language->get('text_pubkey'), $this->config->get('btc_lightning_payment_node_pubkey'));
		$this->data['payment_request'] = $this->session->data['payment_request'];
		$this->data['r_hash'] = $this->session->data['r_hash'];
		$this->data['sec_left'] = $this->data['order_payment_timelimit'] - time();


		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/btc_lightning_payment.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/btc_lightning_payment.tpl';
		} else {
			$this->template = 'default/template/payment/btc_lightning_payment.tpl';
		}	
		
		$this->render(); 
	}

	public function getPaymentRequest($memo='',$satoshi=0){
		$lnd_ip         = $this->config->get('btc_lightning_node_ip');
		$lnd_port       = $this->config->get('btc_lightning_node_port');
		$macaroon_base64= $this->config->get('btc_lightning_node_invoice_macaroon_hex');
		 
		 $data = json_encode(array("memo"  => $memo,
		                           "value" => "$satoshi"
		                         )     
		                    );            
		                    
		 $ch = curl_init("https://$lnd_ip:$lnd_port/v1/invoices");
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		 curl_setopt($ch, CURLOPT_POST, 1);
		 curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		 curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    "Grpc-Metadata-macaroon: $macaroon_base64"
		    ));
		 $response = curl_exec($ch);
		 curl_close($ch);
		 $PR = json_decode($response);
		 return $PR;
	}
	public function getPaymentStatus(){ 
		$lnd_ip         = $this->config->get('btc_lightning_node_ip');
		$lnd_port       = $this->config->get('btc_lightning_node_port');
		$macaroon_base64= $this->config->get('btc_lightning_node_invoice_macaroon_hex');
		$r_hash = $this->session->data['r_hash'];
		$r_hash_hex =  bin2hex(base64_decode($r_hash));


		 $ch = curl_init("https://$lnd_ip:$lnd_port/v1/invoice/$r_hash_hex");
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		 curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    "Grpc-Metadata-macaroon: $macaroon_base64"
		    ));
		 $response = curl_exec($ch);
		 curl_close($ch);
		 $PR = json_decode($response);

		if(isset($PR->settled) && $PR->settled == 1){
			$this->session->data['payment_status'] = 'payment_received';
			echo 1;
		}else{
			echo 0;
		}
	}
	
	public function confirm() {
		$this->language->load('payment/btc_lightning_payment');
		
		$this->load->model('checkout/order');
		
		$comment  = $this->language->get('text_title') . "\n\n";
		$comment .= $this->session->data['total_btc'] * 100000000 . "sat \n\n";
		$comment .= "Payment Status: " . $this->session->data['payment_status'] . " \n\n";
		$comment .= sprintf($this->language->get('text_paymenttime'), $this->session->data['order_time'], $this->session->data['order_time']);
		
		$this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('btc_lightning_payment_order_status_id'), $comment, true);
	}
}
?>