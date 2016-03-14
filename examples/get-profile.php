<?php
/**
 * The Hostinet API Example.
 * Get info account
 */

require_once ( "../src/HostinetAPI.php");  

define('API_KEY', '');
define('API_SECRET', '');

$api = new HostinetApi(API_KEY,API_SECRET);

$response = $api->get("profile");

print_r($response);
