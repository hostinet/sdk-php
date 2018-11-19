<?php
/**
 * The Hostinet API Example.
 * Create a contact in our account
 */

require_once ( "../src/HostinetAPI.php");

define('API_KEY', '');
define('API_SECRET', '');

$api = new HostinetApi(API_KEY,API_SECRET);

$response = $api->post("contact/create", [
    'address' => 'Your address',
    'city' => 'Your city',
    'province' => 'Your province',
    'postal_code' => 'Your postal code',
    'country' => 'Your country',
    'phone' => 'Your phone number',
    'company' => 'Your company',
    'email' => 'Your email address',
    'vat' => 'Your VAT',
    'first_name' => 'Your Name',
    'last_name' => 'Your Surname',

]);

print_r($response);
