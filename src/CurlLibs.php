<?php

namespace SsoClient;

class CurlLibs
{
    private $url;    
    private $curl;    
    private $data;    
    private $config;
    private $method = ['GET', 'POST', 'PUT', 'DELETE'];

    public function __construct()
    {   
        $this->curl = curl_init();
    }

    public function setOptions(array $options = [])
    {
        if (getenv('USE_PROXY')) $default['CURLOPT_PROXY'] = getenv('HTTP_PROXY');
        $default['CURLOPT_TIMEOUT'] = 15;
        $default['CURLOPT_RETURNTRANSFER'] = TRUE;
        $default['CURLOPT_POST'] = 1;
        $default['CURLOPT_SSL_VERIFYPEER'] = 0;

        $this->config = array_merge($default, $options);
        return $this;
    }

    public function getUrl(string $uri = '')
    {
        return sprintf('%s/%s', getenv('API_ENDPOINT'), $uri);
    }

    public function run()
    {
        try {
            foreach ($this->config as $key => $value) {
                curl_setopt($this->curl, constant($key), $value);
            }
            $response = curl_exec($this->curl);
            curl_close($this->curl);
            return $response;
        } catch (\RuntimeException $e) {
            die(sprintf('Http error %s with code %d', $e->getMessage(), $e->getCode()));
        }
    }

    public function request(string $method, string $uri, array $data = [])
    {
        if (in_array($method, $this->method)) {
            if (!empty($data)) $this->config['CURLOPT_POSTFIELDS'] = $data;
            $this->config['CURLOPT_URL'] = $this->getUrl($uri);
            return $this;
        } else {
            die('Invalid Request Method');
        }
    }
}
