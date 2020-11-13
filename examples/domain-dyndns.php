<?php
/**
 * The Hostinet API Example.
 * Set IP dynamicaly
*/

require_once ( "../src/HostinetAPI.php");

define('API_KEY', '');
define('API_SECRET', '');

$api = new HostinetApi(API_KEY,API_SECRET);

$response = $api->post("domain/dyndns", [
  'ip' => 'xxx.xxx.xxx.xxx',
  'domain' => 'mydomain.com',
  'host' => 'www',
]);

print_r($response);
