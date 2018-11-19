<?php
/**
 * The Hostinet API Client.
 * @package HostinetApi
 */

class HostinetApiClient {
    private $appKey, $appSecret;
    private $host = 'https://www.hostinet.com/api/';
    private $useragent = 'hostinet-api v0.3-beta';
    private $http_info = array();
    private $timeout = 30;
    private $connecttimeout = 30;
    private $ssl_verifypeer = false;
    private $format = 'json';
    private $version = 1.1;
    private $token = null;
    /**
     * Constructor
     * @param array $config
     */
    public function __construct($config) {
        if(func_num_args() == 2) {
            $config = array();
            $config['appKey'] = func_get_arg(0);
            $config['appSecret'] = func_get_arg(1);
        }
        if($config) {
            $this->appKey = $config['appKey'];
            $this->appSecret = $config['appSecret'];
        }
    }
    /**
     * REQUEST data
     * @param string $method
     * @param string $path
     * @param array $params
     * @return object
     */
    public function request($method, $path, $params = ''){
        $path = parse_url($path, PHP_URL_PATH);
        $args = parse_url($path, PHP_URL_QUERY);
        $p = explode("/", trim($path, '/'));
        $path = implode("/", $p) .'/';
        if($args) {
            $path .= "?{$args}";
        }
        $params['version'] = $this->version;
        $response = $this->http($method, $path, $params);
        if($response && $this->format == 'json') {
            $response = json_decode($response);
        }
        return $response;
    }
    /**
     * Send request
     * @param string $method
     * @param string $path
     * @param array $params
     * @return object
     */
    private function http($method, $path, $params){
        $this->http_info = array();
        if($this->token === false) {
            return false;
        }
        if(is_null($this->token) && $this->auth() == false){
            return false;
        }
        return $this->connect($method, $path, $params);
    }
    /**
     * Get the token
     * @return string token
     */
    private function auth(){
        $this->token = false;
        if(!$this->appKey || !$this->appSecret) {
            return $this->token;
        }
        $this->http_info = array();
        $headers = array();
        $headers[] = 'Expect: ';
        $params = array(
            'appkey' => $this->appKey,
            'appsecret' => $this->appSecret,
        );
        $response = $this->connect('POST', "auth/", $params);
        if($response) {
            $json = json_decode($response);
            $this->token = ($json && $json->success && $json->token) ? $json->token : false;
        }
        return $this->token;
    }
    /**
     * Connect and send request
     * @param string $method
     * @param string $path
     * @param array $params
     * @return string response
     */
    private function connect($method, $path, $params){
        $url = $this->host . $path;
        $time = time();
        $headers = array();
        if($this->token) {
            $headers[] = 'token: ' . $this->token;
        }
        $headers[] = 'Expect: ';
        $so = php_uname( 's' );
        $sov = php_uname( 'v' );
        if(empty($so)){
            $so = PHP_OS;
        }
        $useragent = "{$this->useragent};";
        $useragent .= " Platform/PHP;";
        $useragent .= " PlatformVersion/{$this->version};";
        if($so)  $useragent .= " OS/{$so};";
        if($sov) $useragent .= " OSV/{$sov};";

        $ci = curl_init();
        /* Curl settings */
        curl_setopt($ci, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, $this->connecttimeout);
        curl_setopt($ci, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, $this->ssl_verifypeer);
        curl_setopt($ci, CURLOPT_HEADER, FALSE);
        curl_setopt($ci, CURLOPT_VERBOSE, FALSE);
        curl_setopt($ci, CURLOPT_FOLLOWLOCATION, TRUE);


        if($method != 'POST' && $params) {
            $params = self::build_http_query($params);
        }

        switch ($method) {
          case 'GET':
                if (!empty($params)) {
                  $url = "{$url}?{$params}";
                }
              break;
          case 'POST':
            curl_setopt($ci, CURLOPT_POST, TRUE);
            if (!empty($params)) {
              curl_setopt($ci, CURLOPT_POSTFIELDS, $params);
            }
            break;
        case 'DELETE':
            curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'DELETE');
            if (!empty($params)) {
              $url = "{$url}?{$params}";
            }
            break;
        case 'PUT':
            curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'PUT');
            if (!empty($params)) {
              $url = "{$url}?{$params}";
            }
            break;
        }

        curl_setopt($ci, CURLOPT_URL, $url);
        $response = curl_exec($ci);
        $this->http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
        $this->http_info = array_merge($this->http_info, curl_getinfo($ci));
        $this->url = $url;
        curl_close ($ci);
        return $response;
    }
    /**
     * Encode the data
     * @param array/string $input
     * @return string
     */
    private static function urlencode_rfc3986($input) {
        if (is_array($input)) {
            return array_map(array(__CLASS__, 'urlencode_rfc3986'), $input);
        } else if (is_scalar($input)) {
            return str_replace('+', ' ', str_replace('%7E', '~', rawurlencode($input)));
        }
        return '';
    }
    /**
     * Encode and convert the data in string
     * @param string $input
     * @return string
     */
    private static function build_http_query($params) {
        if (!$params)
            return '';
        $keys = self::urlencode_rfc3986(array_keys($params));
        $values = self::urlencode_rfc3986(array_values($params));
        $params = array_combine($keys, $values);
        uksort($params, 'strcmp');
        $pairs = array();
        foreach ($params as $parameter => $value) {
            if (is_array($value)) {
                natsort($value);
                foreach ($value as $duplicate_value) {
                    $pairs[] = $parameter . '[]=' . $duplicate_value;
                }
            } else {
                $pairs[] = $parameter . '=' . $value;
            }
        }
        return implode('&', $pairs);
    }
}
