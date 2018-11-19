<?php
/**
 * The Hostinet API Example.
 * List domains in our account
 */

require_once ( "../src/HostinetAPI.php");

define('API_KEY', '');
define('API_SECRET', '');

$api = new HostinetApi(API_KEY,API_SECRET);

$response = $api->post("domain/list");

print_r($response);


$response = $api->post("domain/list", array(
    'page' => 2,
    'limit' => 25
));

print_r($response);
