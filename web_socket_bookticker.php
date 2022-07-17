<?php

require 'php-binance-api.php';
require 'vendor/autoload.php';
require_once('aws-credentials.php');

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

$bucket = "order-ticket-api";
                        
$s3 = new S3Client([
  "region"  => "ap-northeast-1",
  "version" => "2006-03-01",
  "credentials" => [
    "key"    => $IAM_KEY,
    "secret" => $IAM_SECRET ,
  ],
]);

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
    // echo $result['ObjectURL'] . PHP_EOL;
    echo implode("|", $ticker);
    echo "\n";
  } catch (S3Exception $e) {
      echo $e->getMessage() . PHP_EOL;
  }
});
