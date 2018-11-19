<?php
/**
 * The Hostinet API Example.
 * Create a domain in our account
 */

require_once ( "../src/HostinetAPI.php");

define('API_KEY', '');
define('API_SECRET', '');

$api = new HostinetApi(API_KEY,API_SECRET);

$response = $api->post("domain/create", [
    'domain' => 'yourdomaintoregister.com',
    'admin' => 'CONTACT1-HOSTI',
    'tech' => 'CONTACT1-HOSTI',
    'billing' => 'CONTACT1-HOSTI',
    'registrant' => 'CONTACT1-HOSTI',
    'dns1' => 'dns1.hostinet.com',
    'dns2' => 'dns2.hostinet.com',
    'years' => '1',
]);

print_r($response);
