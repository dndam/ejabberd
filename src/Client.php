<?php

namespace Ejabberd\Rest;

use GuzzleHttp\Client as GuzzleHttpClient;

/**
 * ejabberd 26.09 REST admin API client. Works with PHP 7.2.5+ and Guzzle 7.
 */
class Client
{
    use Traits\User;
    use Traits\Roster;
    use Traits\Service;

    protected $client;
    protected $apiUrl;
    protected $host;

    public function __construct(array $options)
    {
        if (empty($options['apiUrl']) || empty($options['host'])) {
            throw new \InvalidArgumentException("'apiUrl' and 'host' are required");
        }
        if (!empty($options['apiToken']) && isset($options['apiUsername'])) {
            throw new \InvalidArgumentException('Choose apiToken OR apiUsername/apiPassword');
        }
        if (isset($options['apiUsername']) xor isset($options['apiPassword'])) {
            throw new \InvalidArgumentException('Both apiUsername and apiPassword are required for basic auth');
        }
        if (isset($options['verifyTls']) && $options['verifyTls'] === false) {
            throw new \InvalidArgumentException('Disabling TLS peer verification is not supported');
        }

        $this->apiUrl = rtrim($options['apiUrl'], '/') . '/';
        $this->host = $options['host'];
        $settings = [
            'base_uri' => $this->apiUrl,
            'timeout' => isset($options['timeout']) ? (float) $options['timeout'] : 10.0,
            'connect_timeout' => isset($options['connectTimeout']) ? (float) $options['connectTimeout'] : 3.0,
            'verify' => isset($options['caBundle']) ? $options['caBundle'] : true,
        ];
        if (isset($options['apiUsername'])) {
            $settings['auth'] = [$options['apiUsername'], $options['apiPassword']];
        }
        if (isset($options['apiToken'])) {
            $settings['headers'] = ['Authorization' => 'Bearer ' . $options['apiToken']];
        }
        $this->client = new GuzzleHttpClient($settings);
    }

    /** A success code can be numeric 0, JSON empty string, or raw string 'Success'. */
    protected function commandSucceeded($result)
    {
        return $result === 0 || $result === '0' || $result === '' || $result === 'Success';
    }

    protected function sendRequest($endpoint, $payload)
    {
        try {
            $response = $this->client->post($endpoint, ['json' => $payload]);
        } catch (\GuzzleHttp\Exception\GuzzleException $exception) {
            // Don't log payloads: they may contain account passwords.
            throw new \RuntimeException('ejabberd API request failed for ' . $endpoint, 0, $exception);
        }

        $body = (string) $response->getBody();
        if ($body === '') {
            return null;
        }
        $decoded = json_decode($body, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Invalid JSON response from ejabberd endpoint ' . $endpoint);
        }
        return $decoded;
    }
}
