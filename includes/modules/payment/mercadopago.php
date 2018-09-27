<?php
/*
$Id: mercadopago.php,v 1.00 2004/08/12 19:57:15 hpdl Exp $

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

Copyright (c) 2003 osCommerce

Released under the GNU General Public License
*/

class mercadopago {
var $code, $title, $description, $enabled;


function mercadopago() {
global $order;

$this->code = 'mercadopago';
$this->title = MODULE_PAYMENT_MERCADOPAGO_TEXT_TITLE;
$this->description = MODULE_PAYMENT_MERCADOPAGO_TEXT_DESCRIPTION;
$this->sort_order = MODULE_PAYMENT_MERCADOPAGO_SORT_ORDER;

$this->enabled = ((MODULE_PAYMENT_MERCADOPAGO_STATUS == 'True') ? true : false);


if ((int)MODULE_PAYMENT_MERCADOPAGO_ORDER_STATUS_ID > 0) {
$this->order_status = MODULE_PAYMENT_MERCADOPAGO_ORDER_STATUS_ID;
}

if (is_object($order)) $this->update_status();

$this->form_action_url = 'https://www.mercadopago.com/mla/buybutton';
}

function update_status() {
global $order;

if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_MERCADOPAGO_ZONE > 0) ) {
$check_flag = false;
$check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_MERCADOPAGO_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
while ($check = tep_db_fetch_array($check_query)) {
if ($check['zone_id'] < 1) {
$check_flag = true;
break;
} elseif ($check['zone_id'] == $order->billing['zone_id']) {
$check_flag = true;
break;
}
}

if ($check_flag == false) {
$this->enabled = false;
}
}
}

function javascript_validation() {
return false;
}

function selection() {
return array('id' => $this->code,
'module' => $this->title);
}

function pre_confirmation_check() {
return false;
}

function confirmation() {
return false;
}

function process_button() {
global $order, $currencies, $currency;

$my_currency = $currency;

$a = $order->info['total'];
$b = $order->info['shipping_cost'];
$c = $currencies->get_value($my_currency);
$d = $currencies->get_decimal_places($my_currency);
$total = $a * $c;
$precio = number_format($total, 2, '.', '');

/*$productos = "Productos de " . STORE_NAME . ": ";*/
$productos = "";

for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
    $productos .= "- " . $order->products[$i]['name'] . " ";
    }
$productos = substr($productos,0,70) . '...';

if ($my_currency == 'USD'){ 
	$TipoMoneda = 'DOL';}else{
	$TipoMoneda = 'ARG';}

$process_button_string = tep_draw_hidden_field('name', $productos) .
tep_draw_hidden_field('currency', $TipoMoneda) .
tep_draw_hidden_field('price', $precio) .
tep_draw_hidden_field('url_cancel', tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL')) .
tep_draw_hidden_field('item_id', MODULE_PAYMENT_MERCADOPAGO_ID) .
tep_draw_hidden_field('acc_id', MODULE_PAYMENT_MERCADOPAGO_ID) .
tep_draw_hidden_field('shipping_cost', '' ) .
tep_draw_hidden_field('url_process', '') .
tep_draw_hidden_field('url_succesfull', tep_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL')) . 
tep_draw_hidden_field('enc', MODULE_PAYMENT_MERCADOPAGO_CODE);

return $process_button_string;
}

function before_process() {
return false;
}

function after_process() {
return false;
}

function output_error() {
return false;
}

function check() {
if (!isset($this->_check)) {
$check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_MERCADOPAGO_STATUS'");
$this->_check = tep_db_num_rows($check_query);
}
return $this->_check;
}

function install() {
tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Habilitar módulo MercadoPago', 'MODULE_PAYMENT_MERCADOPAGO_STATUS', 'True', 'Desea aceptar pagos a traves de MercadoPago?', '6', '3', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('ID CUENTA', 'MODULE_PAYMENT_MERCADOPAGO_ID', '', 'Código de Comercio', '6', '4', now())");	
tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('CODIGO DE VERIFICACION', 'MODULE_PAYMENT_MERCADOPAGO_CODE', '', 'Código de su Verificacion', '6', '4', now())");	
tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort order of display.', 'MODULE_PAYMENT_MERCADOPAGO_SORT_ORDER', '0', 'Order de despliegue. El mas bajo se despliega primero.', '6', '0', now())");

}

function remove() {
tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
}

function keys() {
return array('MODULE_PAYMENT_MERCADOPAGO_STATUS', 'MODULE_PAYMENT_MERCADOPAGO_ID', 'MODULE_PAYMENT_MERCADOPAGO_CODE', 'MODULE_PAYMENT_MERCADOPAGO_SORT_ORDER');
}
}
?>