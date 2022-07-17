<?php

require 'php-binance-api.php';
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

$bucket = "order-ticket-api";
$access_key_id = 'AKIAUFRQLGMBDGCKOXM2';
$secret_key = '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';
                        
$s3 = new S3Client([
  "accessKeyId" => $access_key_id,
  "secretAccessKey" => $secret_key,
  "region"  => "ap-northeast-1",
  "version" => "2006-03-01"
]);

// @see home_directory_config.php
// use config from ~/.confg/jaggedsoft/php-binance-api.json
$api = new Binance\API("PSxGmJaZYnZabIx1c66peOV2vucR6jLuOQVIpoV1jMjPU0yGLMRey2V0t5QyhDrn", "UD0jnVLSBRnKqIcBHg1d6trC5PKqsu7DNdNKcXHrR9U6lKXLEbt6Gj78UHfFKA6A");

// Ticker Updates via WebSocket
$api->bookTicker(function($api, $ticker) {
  // print_r($ticker);
  global $s3, $bucket;
  $keyname = "ticker";

  try {
    // Upload data.
    $result = $s3->putObject([
        "Bucket" => $bucket,
        "Key"    => $keyname,
        "Body"   => "Hello world",
        "ACL"    => "public-read"
    ]);

    // Print the URL to the object.
    echo $result['ObjectURL'] . PHP_EOL;
  } catch (S3Exception $e) {
      echo $e->getMessage() . PHP_EOL;
  }
});
