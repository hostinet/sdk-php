<?php
/**
 * The Hostinet API Example.
 * Check connection
 */

require_once ( "../src/HostinetAPI.php");  

define('API_KEY', '');
define('API_SECRET', '');

$api = new HostinetApi(API_KEY,API_SECRET);

$response = $api->get("tool/hello");

print_r($response);

