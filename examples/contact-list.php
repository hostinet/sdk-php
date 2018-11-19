<?php
/**
 * The Hostinet API Example.
 * List contacts in our account
 */

require_once ( "../src/HostinetAPI.php");

define('API_KEY', '');
define('API_SECRET', '');

$api = new HostinetApi(API_KEY,API_SECRET);

$response = $api->get("contact/list");

print_r($response);


$response = $api->get("contact/list", array(
    'page' => 2,
    'limit' => 25
));

print_r($response);
