<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2016 osCommerce

  Released under the GNU General Public License
*/
@setlocale(LC_ALL, array('en_US.UTF-8', 'en_US.UTF8', 'enu_usa'));
define('DATE_FORMAT_LONG', '%A %d %B, %Y'); // this is used for strftime()

define('LOC_EMAIL_SEPARATOR', '------------------------------------------------------');
define('LOC_EMAIL_TEXT_SUBJECT', 'Order Update');
define('LOC_EMAIL_TEXT_ORDER_NUMBER', 'Order Number:');
define('LOC_EMAIL_TEXT_INVOICE_URL', 'Detailed Invoice:');
define('LOC_EMAIL_TEXT_DATE_ORDERED', 'Date Ordered:');
define('LOC_EMAIL_TEXT_STATUS_UPDATE', 'Your order has been updated to the following status.' . "\n\n" . 'New status: %s' . "\n\n" . 'Please reply to this email if you have any questions.' . "\n");
define('LOC_EMAIL_TEXT_COMMENTS_UPDATE', 'The comments for your order are' . "\n\n%s\n\n");
