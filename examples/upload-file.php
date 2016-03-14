<?php
/**
 * The Hostinet API Example.
 * Upload a file
 */

require_once ( "../src/HostinetAPI.php");  

define('API_KEY', '');
define('API_SECRET', '');

$api = new HostinetApi(API_KEY,API_SECRET);

$response = $api->upload('/absolute/path/to/file.txt');

print_r($response);
