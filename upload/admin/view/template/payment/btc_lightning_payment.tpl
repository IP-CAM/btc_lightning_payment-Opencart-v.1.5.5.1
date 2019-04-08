<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/payment/btc_lightning_payment.png" alt="bitcoin logo" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <p><?php echo $test_mode; ?></p>
          <tr>
            <td><?php echo $entry_lightning_node_ip; ?></td>
            <td><input type="text" name="btc_lightning_node_ip" value="<?php echo $btc_lightning_node_ip; ?>" size="16" /></td>
              <?php if (isset(${'error_ip'})) { ?>
              <span class="error"><?php echo ${'error_ip'}; ?></span>
              <?php } ?></td>
          </tr> 
          <tr>
            <td><?php echo $entry_lightning_node_port; ?></td>
            <td><input type="text" name="btc_lightning_node_port" value="<?php echo $btc_lightning_node_port; ?>" size="10" /></td>
              <?php if (isset(${'error_port'})) { ?>
              <span class="error"><?php echo ${'error_port'}; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_lightning_node_invoice_macaroon_hex; ?></td>
            <td><textarea name="btc_lightning_node_invoice_macaroon_hex" rows="6" cols="60"/><?php echo $btc_lightning_node_invoice_macaroon_hex; ?></textarea></td>
              <?php if (isset(${'error_macaroon'})) { ?>
              <span class="error"><?php echo ${'error_macaroon'}; ?></span>
              <?php } ?></td>
          </tr>   
          <tr>
            <td><?php echo $entry_lightning_node_pubkey; ?></td>
            <td><input type="text" name="btc_lightning_node_pubkey" value="<?php echo $btc_lightning_node_pubkey; ?>" size="135" /></td>
              <?php if (isset(${'error_port'})) { ?>
              <span class="error"><?php echo ${'error_port'}; ?></span>
              <?php } ?></td>
          </tr>    
          <tr>
            <td><?php echo $entry_total; ?></td>
            <td><input type="text" name="btc_lightning_payment_total" value="<?php echo $btc_lightning_payment_total; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_add_percent; ?></td>
            <td><input type="number" max="100" min="0" style="width:50px" name="btc_lightning_payment_add_percent" value="<?php echo $btc_lightning_payment_add_percent; ?>" /></td>
          </tr>
          <tr>
            <td><?php echo $entry_price_change_amount; ?></td>
            <td><input type="number" max="100" min="0" style="width:50px" name="btc_lightning_payment_price_change_amount" value="<?php echo $btc_lightning_payment_price_change_amount; ?>" /></td>
          </tr>
          <!--<tr>
            <td><?php echo $entry_timezone; ?></td>
            <td><?php
              function select_Timezone($selected = '') {
                  $OptionsArray = timezone_identifiers_list();
                      $select= '<select name="btc_lightning_payment_timezone">';
                      foreach($OptionsArray as $key => $row){
                          $select .='<option value="'.$row.'"';
                          $select .= ($row == $selected ? ' selected' : '');
                          $select .= '>'.$row.'</option>';
                      }
                      $select.='</select>';
              return $select;
              }
              echo select_Timezone($btc_lightning_payment_timezone);
            ?>
            </td>
          </tr> -->          
          <tr>
            <td><?php echo $entry_order_status; ?></td>
            <td><select name="btc_lightning_payment_order_status_id">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $btc_lightning_payment_order_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="btc_lightning_payment_status">
                <?php if ($btc_lightning_payment_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_sort_order; ?></td>
            <td><input type="text" name="btc_lightning_payment_sort_order" value="<?php echo $btc_lightning_payment_sort_order; ?>" size="1" /></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>