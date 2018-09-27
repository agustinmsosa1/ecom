<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
*/

////
// Class to handle currencies
// TABLES: currencies
  class currencies {
    var $currencies;

// class constructor
    function __construct() {
      $this->currencies = array();
      $currencies_query = tep_db_query("select code, title, symbol_left, symbol_right, decimal_point, thousands_point, decimal_places, value from " . TABLE_CURRENCIES);
      while ($currencies = tep_db_fetch_array($currencies_query)) {
	    $this->currencies[$currencies['code']] = array('title' => $currencies['title'],
                                                       'symbol_left' => $currencies['symbol_left'],
                                                       'symbol_right' => $currencies['symbol_right'],
                                                       'decimal_point' => $currencies['decimal_point'],
                                                       'thousands_point' => $currencies['thousands_point'],
                                                       'decimal_places' => $currencies['decimal_places'],
                                                       'value' => $currencies['value']);
      }
    }

// class methods
    function format($number, $calculate_currency_value = true, $currency_type = DEFAULT_CURRENCY, $currency_value = '') {
      if ($calculate_currency_value) {
        $rate = ($currency_value) ? $currency_value : $this->currencies[$currency_type]['value'];
    		$format_string = '<span style="padding-right: 5px;">' . $this->currencies[$currency_type]['symbol_left'] . '</span>' . number_format(tep_round($number * $rate, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']) . '<span style="padding-left: 5px;">' . $this->currencies[$currency_type]['symbol_right'] . '</span>';
    	} else {
    		$format_string = '<span style="padding-right: 5px;">' . $this->currencies[$currency_type]['symbol_left'] . '</span>' . number_format(tep_round($number, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']) . '<span style="padding-left: 5px;">' . $this->currencies[$currency_type]['symbol_right'] . '</span>';
      }

      return $format_string;
    }

    function get_value($code) {
      return $this->currencies[$code]['value'];
    }

    function display_price($products_price, $products_tax, $quantity = 1, $currency_type = DEFAULT_CURRENCY) {
      return $this->format(tep_round(tep_add_tax($products_price, $products_tax), $this->currencies[$currency_type]['decimal_places']) * $quantity);
    }
  }
?>
