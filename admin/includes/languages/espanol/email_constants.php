<?php
/*
  $Id:$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2016 osCommerce

  Released under the GNU General Public License
*/
@setlocale(LC_ALL, array('es_ES.UTF-8', 'es_ES.UTF8', 'esp_es'));
define('DATE_FORMAT_LONG_LOCALIZE', '%A %d de %B del %Y'); // this is used for strftime()

define('LOC_EMAIL_SEPARATOR', '------------------------------------------------------');
define('LOC_EMAIL_TEXT_SUBJECT', 'Actualización del Pedido');
define('LOC_EMAIL_TEXT_ORDER_NUMBER', 'Número de Pedido:');
define('LOC_EMAIL_TEXT_INVOICE_URL', 'Pedido Detallado:');
define('LOC_EMAIL_TEXT_VIEW_MY_ORDER', 'Historial de mi Pedido');
define('LOC_EMAIL_TEXT_DATE_ORDERED', 'Fecha del Pedido:');
define('LOC_EMAIL_TEXT_STATUS_TITLE', 'Estado de Pedido');
define('LOC_EMAIL_TEXT_STATUS_UPDATE', 'Su pedido ha sido cambiado al siguiente estado.' . "\n\n" . 'Nuevo estado: %s' . "\n\n" . 'Por favor responda a este correo electrónico si tiene alguna pregunta.' . "\n");
define('LOC_EMAIL_TEXT_COMMENTS_UPDATE', 'Los comentarios sobre su pedido son:' . "\n" . '%s' . "\n");
define('LOC_EMAIL_TEXT_REPLY', 'Por favor, responda a este correo electrónico si tiene cualquier pregunta.' . "\n");
