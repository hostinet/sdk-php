<?php
/**
 * The Hostinet API Example.
 * Update info account
 */

require_once ( "../src/HostinetAPI.php");  

define('API_KEY', '');
define('API_SECRET', '');

$api = new HostinetApi(API_KEY,API_SECRET);

$response = $api->post("profile", array(
    'email' => 'new@email.com',
    'email2' => 'secondnew@email.com'
));
print_r($response);
