<?php
/**
 * The Hostinet API Client.
 * @package HostinetApi
 */

require_once(__DIR__ . '/HostinetAPI/HostinetApiClient.php');

/**
 * The Hostinet API Client.
 */

class HostinetApi {
    private $client = null;
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
        $this->client = new HostinetApiClient($config);
    }
    /**
     * POST data
     * @param string $path
     * @param array $params
     * @return object
     */
    public function post($path, $params = array()){
        return $this->client->request('POST', $path, $params);
    }
    /**
     * PUT data
     * @param string $path
     * @param array $params
     * @return object
     */
    public function put($path, $params = array()){
        return $this->client->request('PUT', $path, $params);
    }
    /**
     * DELETE data
     * @param string $path
     * @param array $params
     * @return object
     */
    public function delete($path, $params = array()){
        return $this->client->request('DELETE', $path, $params);
    }
    /**
     * GET data
     * @param string $path
     * @param array $params
     * @return object
     */
    public function get($path, $params = array()){
        return $this->client->request('GET', $path, $params);
    }
    /**
     * Upload a file
     * @param string $path_file
     * @return object
     */
    public function upload($path_file){
        if(!$path_file || !is_file($path_file) || !is_readable($path_file)) {
            return false;
        }
        $args = array(
            'file' => "@{$path_file}",
        );
        return $this->client->request('POST', 'tool/upload', $args);
    }
}

