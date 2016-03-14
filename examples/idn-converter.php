<?php
/**
 * The Hostinet API Example.
 * IDN converter
 */

require_once ( "../src/HostinetAPI.php");  

define('API_KEY', '');
define('API_SECRET', '');

$api = new HostinetApi(API_KEY,API_SECRET);

$response = $api->post("tool/idnconverter", array(
    'domain' => 'exámple.com'
));

print_r($response);
