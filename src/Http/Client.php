<?php

declare(strict_types=1);

namespace RofiqDev\DurianPay\Http;

use GuzzleHttp\Client as GuzzleClient;
use Exception;

class Client
{
    /**
     * Turn debugging on/off.
     *
     * @var bool
     */
    public $debug = false;

    /**
     * Debug messages bag.
     *
     * @var array
     */
    public $debugs = [];

    /**
     * Error messages bag.
     *
     * @var array
     */
    public $errors = [];

    /**
     * Constructor.
     *
     * @param string $clientSecret
     * @param bool   $debug
     */
    public function __construct(string $clientSecret, bool $debug = false)
    {
        $this->clientSecret = $clientSecret;
        $this->debug = $debug;

        $configs = [
            'base_uri' => 'https://api.durianpay.id/v1',
            'http_errors' => false,
            'auth' => [$this->clientSecret, ''],
            'headers' => [
                'Accept' => 'application/json',
            ]
        ];

        $this->connector = new GuzzleClient($configs);
    }

    /**
     * Add a debug message.
     *
     * @param string $message
     */
    public function addDebug(string $message)
    {
        if ($this->debug) {
            $this->debugs[] = $message;
        }

        return $this;
    }

    /**
     * Add an error message.
     *
     * @param string $message
     */
    public function addError(string $message)
    {
        $this->errors[] = [
            'message' => $message
        ];

        return $this;
    }

    /**
     * Check if there is error message exists.
     *
     * @return bool
     */
    public function hasError()
    {
        return count($this->errors) > 0;
    }

    public function resetError()
    {
        $this->errors = [];
        return $this;
    }

    /**
     * Reset debug messages.
     *
     * @return self
     */
    public function resetDebug()
    {
        $this->debugs = [];
        return $this;
    }

    /**
     * Do a POST request.
     *
     * @param string $endpoint
     * @param array  $params
     * @param array  $headers
     *
     * @return \stdClass|false
     */
    public function post(string $endpoint, array $params = [], array $headers = [])
    {
        return $this->request('post', $endpoint, $params, $headers);
    }

    /**
     * Do a GET request.
     *
     * @param string $endpoint
     * @param array  $params
     * @param array  $headers
     *
     * @return \stdClass|false
     */
    public function get($endpoint, array $params = [], array $headers = [])
    {
        return $this->request('get', $endpoint, $params, $headers);
    }

    /**
     * Do a DELETE request.
     *
     * @param string $endpoint
     * @param array  $params
     * @param array  $headers
     *
     * @return \stdClass|false
     */
    public function delete(string $endpoint, array $params = [], array $headers = [])
    {
        return $this->request('delete', $endpoint, $params, $headers);
    }

    /**
     * Do a PATCH request.
     *
     * @param string $endpoint
     * @param array  $params
     * @param array  $headers
     *
     * @return \stdClass|false
     */
    public function patch(string $endpoint, array $params = [], array $headers = [])
    {
        return $this->request('patch', $endpoint, $params, $headers);
    }

    /**
     * Do a PUT request.
     *
     * @param string $endpoint
     * @param array  $params
     * @param array  $headers
     *
     * @return \stdClass|false
     */
    public function put(string $endpoint, array $params = [], array $headers = [])
    {
        return $this->request('put', $endpoint, $params, $headers);
    }

    /**
     * Do a http request.
     *
     * @param string $endpoint
     * @param array  $params
     * @param array  $headers
     *
     * @return \stdClass|false
     */
    private function request(string $method, string $endpoint, array $params = [], array $headers = [])
    {
        try {
            $this->resetError();
            $this->resetDebug();

            $this->addDebug('URL: '.$this->connector->getConfig('base_uri').'/'.$endpoint);
            $this->addDebug('Request Method: '.strtoupper($method));
            $this->addDebug('Request Params: '.json_encode($params));
            $this->addDebug('Request Headers: '.json_encode(array_merge($this->connector->getConfig('headers'), $headers)));

            $method = strtolower($method);
            $payloads = ['headers' => $headers, 'json' => $params];

            if ($method === 'get') {
                $endpoint = $endpoint . '?' . http_build_query($params);
                $payloads = [];
            }

            $response = $this->connector->{$method}(ltrim($endpoint, '/'), $payloads);

            $body = $response->getBody()->getContents();

            $this->addDebug('Response HTTP Code: '.$response->getStatusCode());
            $this->addDebug('Response Header: '.json_encode($response->getHeaders()));
            $this->addDebug('Response Body: '.$body);

            $data = json_decode($body);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->addError('Unable to parse: invalid JSON response');
                return false;
            }

            return $data;
        } catch (Exception $e) {
            $this->addError($e->getMessage());
            return false;
        }
    }

    /**
     * Get http client instance.
     *
     * @return [type]
     */
    public function getInstance()
    {
        return $this;
    }
}
