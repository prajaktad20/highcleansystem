<?php

date_default_timezone_set("Australia/Victoria");

$yii = dirname(__FILE__).'/framework/yii.php';
$config = dirname(__FILE__).'/protected/config/main.php';
  
// Remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
  
require_once($yii);
Yii::createWebApplication($config)->run();
