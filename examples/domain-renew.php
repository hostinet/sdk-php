<?php
/**
 * The Hostinet API Example.
 * Renew a domain in our account
 */

require_once ( "../src/HostinetAPI.php");

define('API_KEY', '');
define('API_SECRET', '');

$api = new HostinetApi(API_KEY,API_SECRET);

$response = $api->post("domain/renew", [
  'domain' => 'yourdomaintorenew.com',
  'year' => 1
]);

print_r($response);
