<?php
/**
 * The Hostinet API Example.
 * Send SMS
 */

require_once ( "../src/HostinetAPI.php");  

define('API_KEY', '');
define('API_SECRET', '');

$api = new HostinetApi(API_KEY,API_SECRET);

$response = $api->post("sms", array(
    'to' => '+34.123456789',
    'from' => 'Sara',
    'text' => 'This is a test SMS',
));

print_r($response);
