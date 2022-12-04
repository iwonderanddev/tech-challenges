<?php
//Lib source : https://github.com/chroder/youtrack-to-clubhouse/blob/master/src/App/Clubhouse/Api.php

namespace API;

class RequestManager
{
    /** Shortcut API root URL */
    private $url = 'https://api.app.shortcut.com/api/v3';
    /** Shortcut API token */
    private $token;
    private $cooldownTime = 60;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function request($method, $path, array $data = null)
    {
        while (true) {
            $result = $this->rawRequest($method, $path, $data);
            if ($result['httpCode'] !== 429) {
                return $result;
            }
            echo '(rate limit, waiting)';
            sleep($this->cooldownTime);
            echo '(resume)';
        }
    }

    public function rawRequest($method, $path, array $data = null)
    {
        $startMs = microtime(true);
        $method = strtoupper($method);

        $headers = [
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
            'Shortcut-Token' => "$this->token",
        ];

        $url = $this->url . '/' . ltrim($path, '/');

        if ($data && ($method === 'GET' || $method === 'DELETE' || $method === 'HEAD' || $method === 'OPTIONS')) {
            $query = http_build_query($data, null, '&');
            $url .= '?' . $query;
        }

        if (strpos('?', $url)) {
            $url .= '&token=' . $this->token;
        } else {
            $url .= '?token=' . $this->token;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if ($method === 'POST' || $method === 'PUT' || $method === 'PATCH') {
            if (!$data) {
                $data = [];
            }
            $payload = json_encode($data, \JSON_PRETTY_PRINT);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        }
        curl_setopt($ch, CURLOPT_TIMEOUT, 15000);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $h = [];
        foreach ($headers as $k => $v) {
            $h[] = "{$k}: {$v}";
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $h);
        $http_result = curl_exec($ch);
        $error = curl_error($ch);
        $http_code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $json = json_decode($http_result, true) ?: null;
        curl_close($ch);

        $totalMs = microtime(true) - $startMs;

        return [
            'result'    => $http_result,
            'data'      => $json,
            'error'     => $error,
            'httpCode'  => $http_code,
            'totalTime' => $totalMs
        ];
    }
}