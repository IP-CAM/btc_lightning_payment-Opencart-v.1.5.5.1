<h2 class="btc_lightning_payment_title"><?php echo $text_instruction; ?></h2>
<div class="content" id="lightning_instructions" style="text-align:center">
	<?php if($r_hash): ?>
	  <p class="btc_lightning_payment_top_description"><?php echo $text_description; ?></p>
	  <p class="btc_lightning_payment_wallet_address" style="word-break: break-all;"><?php echo $payment_request; ?></p>
	  <p class="btc_lightning_payment_qr_code"><img src="https://api.qrserver.com/v1/create-qr-code/?data=lightning:<?php echo $payment_request; ?>&amp;size=200x200"></p>
	  <p class="btc_lightning_payment_order_time"><?php echo $text_time_request .' <span id="btc_lightning_payment_countdown"></span>' ?> </p>
	  <p class="btc_lightning_payment_pubkey"><?php echo $text_pubkey_full; ?></p>
	  <p class="btc_lightning_payment_bottom_description"><?php echo $text_payment; ?></p>
	<?php else: ?>
	<p class="btc_lightning_payment_wallet_address" style="word-break: break-all;"><?php echo $payment_request; ?></p>
	<?php endif; ?>
  <p><?php // echo $order_payment_timelimit.' - '.time(). ' = ' .$sec_left; ?> </p>
</div>
<div class="buttons">
  <div class="right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="button" />
  </div>
</div>
<script type="text/javascript"><!--
$('#button-confirm').bind('click', function() {
	$.ajax({ 
		type: 'get',
		url: 'index.php?route=payment/btc_lightning_payment/confirm',
		success: function() {
			location = '<?php echo $continue; ?>';
		}		
	});
});
//--></script> 
<?php if($r_hash): ?>
<script type="text/javascript"><!--
	var paymentstatus = setInterval(checkpaymentstatus, 5000);
	$(function() {
	    checkpaymentstatus();
	});

function checkpaymentstatus(){
		$.ajax({
			type: 'get',
			url: 'index.php?route=payment/btc_lightning_payment/getPaymentStatus',
			cache: false,
			success: function(result){
				if(result == true){
					$('.btc_lightning_payment_title').text('Thank you, payment received');
					$('#lightning_instructions').html('');
					clearInterval(paymentstatus);
				}else if(result == false){
					console.log('not received');
				}
				},
		});
	}
//--></script>
<?php endif; ?>
<script>
    function countdown(seconds) {
		var counter = document.getElementById("btc_lightning_payment_countdown");
		counter.innerHTML = Math.floor(seconds / 60) + ':' + ('0' + seconds % 60).slice(-2);
		var timerinterval = setInterval(function(){
			if( seconds > 0 ) {
					seconds--;
					counter.innerHTML = Math.floor(seconds / 60) + ':' + ('0' + seconds % 60).slice(-2);
			}else{counter.innerHTML = '<?php echo $text_timeleft ?>';clearInterval(timerinterval);}
		}, 1000);
    }
    countdown(<?php echo $sec_left ?>);
</script>