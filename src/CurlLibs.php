<?php

namespace SsoClient;

/**
 * This is the curllibs class.
 * 
 * It's responsible for handling curl function
 */
class CurlLibs
{
    /**
     * The url storage
     *
     * @var string
     */
    private $url;    

    /**
     * The curl instance
     *
     * @var curl_init()
     */
    private $curl;    

    /**
     * The data storage
     *
     * @var array
     */
    private $data;    

    /**
     * The config storage
     *
     * @var array
     */
    private $config;

    /**
     * The method filter
     *
     * @var array
     */
    private $method = ['GET', 'POST'];

    /**
     * Create curl instance
     * 
     * @return void
     */
    public function __construct()
    {   
        $this->curl = curl_init();
    }

    /**
     * Setting curl option
     *
     * @param array $options
     * @return CurlLibs
     */
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

    /**
     * generate url endpoints with method
     *
     * @param string $uri
     * @return string
     */
    public function getUrl(string $uri = '')
    {
        return sprintf('%s/%s', getenv('API_ENDPOINT'), $uri);
    }

    /**
     * Execute curl function
     *
     * @return CurlLibs
     */
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

    /**
     * Make a curl request
     *
     * @param string $method
     * @param string $uri
     * @param array $data
     * @return CurlLibs
     */
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
