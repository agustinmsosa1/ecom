<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  function quote_oanda_currency($code, $base = DEFAULT_CURRENCY) {
    $page = file('http://www.oanda.com/convert/fxdaily?value=1&redirected=1&exch=' . $code .  '&format=CSV&dest=Get+Table&sel_list=' . $base);
    ini_set("allow_url_fopen","1");
    $match = array();

    preg_match('/(.+),(\w{3}),([0-9.]+),([0-9.]+)/i', implode('', $page), $match);

    if (sizeof($match) > 0) {
      return $match[3];
    } else {
      return false;
    }
  }

  function quote_xe_currency($to, $from = DEFAULT_CURRENCY) {
    $page = file('http://www.xe.com/currencyconverter/convert/?Amount=1&From=' . $from . '&To=' . $to); 

    $match = array();

    preg_match('/[0-9.]+\s*' . $from . '\s*=\s*([0-9.]+)\s*' . $to . '/', implode('', $page), $match);

    if (sizeof($match) > 0) {
      return $match[1];
    } else {
      return false;
    }
  }

  function quote_fixer_currency($to, $from = DEFAULT_CURRENCY) {
    if ($to == $from) return 1;
    
    $ch = curl_init('http://data.fixer.io/api/latest?access_key=' . FIXER_ACCESS_KEY . '&base=' . $from . '&symbols=' . $to);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch); 
    curl_close($ch); 

    $currencies = json_decode($data, true);
    
    if (isset($currencies['rates'][$to])) {
      return $currencies['rates'][$to];
    } else {
      return false;
    }
  }
  