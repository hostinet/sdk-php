<?php
/**
 * The Hostinet API Example.
 * Get contact info
 */

require_once ( "../src/HostinetAPI.php");

define('API_KEY', '');
define('API_SECRET', '');

$api = new HostinetApi(API_KEY,API_SECRET);

$response = $api->post("contact/info", [
  'name' => 'CONTACT1-HOSTI'
]);

print_r($response);
