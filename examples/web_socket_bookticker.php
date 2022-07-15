<?php

require 'php-binance-api.php';
require 'vendor/autoload.php';


// @see home_directory_config.php
// use config from ~/.confg/jaggedsoft/php-binance-api.json
$api = new Binance\API();

// Ticker Updates via WebSocket
$api->bookTicker(function($api, $ticker) {
  print_r($ticker);
});