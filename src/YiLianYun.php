<?php

namespace Woody\YiLianYun;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Woody\YiLianYun\Enum\ApiEnum;

class YiLianYun
{
    private $host;
    private $clientId;
    private $clientSecret;

    public function __construct()
    {
        $this->host = config('yilianyun.host');
        $this->clientId = config('yilianyun.client_id');
        $this->clientSecret = config('yilianyun.client_secret');
    }


    // 获取 Access Token
    public function accessToken()
    {
        $accessTokenKey = 'yilianyun:access_token';
        $accessToken = Cache::get($accessTokenKey);
        if ($accessToken) {
            return $accessToken;
        }
        Log::info('重新获取 ACCESS_TOKEN');
        $api = $this->host . ApiEnum::ACCESS_TOKEN;
        $timestamp = time();
        $response = Http::post($api, [
            'client_id' => $this->clientId,
            'grant_type' => 'client_credentials',
            'sign' => $this->sign($timestamp),
            'scope' => 'all',
            'timestamp' => $timestamp,
            'id' => Str::uuid(),
        ]);
        if (!$response->ok()) {
            throw new \Exception('获取 Access Token 接口调用失败', $response->status());
        }
        /*
        $response->json()
        array:3 [
          "error" => "0"
          "error_description" => "success"
          "body" => array:5 [
            "access_token" => "b494d0a1cd4e433f907297e8ccefda13"
            "refresh_token" => "d078e363b3884e9a88a97b253832b194"
            "machine_code" => null
            "expires_in" => 2592000
            "scope" => "all"
          ]
        ]
        */
        $result = $response->json();
        $accessToken = $result['body']['access_token'];
        Cache::put($accessTokenKey, $accessToken, 25 * 24 * 3600);
        return $accessToken;
    }

    // 终端授权
    public function addPrinter($machineCode, $machineSign, $phone = '', $printName = '')
    {
        $api = $this->host . ApiEnum::ADD_PRINTER;
        $timestamp = time();
        $response = Http::post($api, [
            'client_id' => $this->clientId,
            'machine_code' => $machineCode,
            'msign' => $machineSign,
            'access_token' => $this->accessToken(),
            'sign' => $this->sign($timestamp),
            'id' => Str::uuid()->toString(),
            'timestamp' => $timestamp,
            'phone' => $phone,
            'print_name' => $printName,

        ]);
        if (!$response->ok()) {
            throw new \Exception('获取终端授权接口调用失败', $response->status());
        }
        /*
        $response->json()
        array:3 [
          "error" => "0"
          "error_description" => "success"
        ]
        */
        $result = $response->json();
        if (!isset($result['error']) || $result['error'] != 0) {
            return false;
        }
        return true;
    }

    // 终端授权删除
    public function deletePrinter($machineCode)
    {
        $accessToken = $this->accessToken();
        $api = $this->host . ApiEnum::DELETE_PRINTER;
        $timestamp = time();
        $response = Http::post($api, [
            'client_id' => $this->clientId,
            'access_token' => $accessToken,
            'machine_code' => $machineCode,
            'sign' => $this->sign($timestamp),
            'id' => Str::uuid()->toString(),
            'timestamp' => $timestamp,
        ]);
        if (!$response->ok()) {
            throw new \Exception('删除终端授权接口调用失败', $response->status());
        }
        /*
        $response->json()
        array:3 [
          "error" => "0"
          "error_description" => "success"
        ]
        */
        $result = $response->json();
        if (!isset($result['error']) || !in_array($result['error'], [0, 8])) {
            return false;
        }
        return true;
    }

    // 终端状态
    public function printerStatus($machineCode)
    {
        $accessToken = $this->accessToken();
        $api = $this->host . ApiEnum::PRINTER_STATUS;
        $timestamp = time();
        $response = Http::post($api, [
            'client_id' => $this->clientId,
            'access_token' => $accessToken,
            'machine_code' => $machineCode,
            'sign' => $this->sign($timestamp),
            'id' => Str::uuid()->toString(),
            'timestamp' => $timestamp,
        ]);
        if (!$response->ok()) {
            throw new \Exception('删除终端授权接口调用失败', $response->status());
        }
        /*
        $response->json()
        array:3 [
          "error" => "0"
          "error_description" => "success"
        ]
        */
        return $response->json()['body'];
    }

    // 声音设置
    public function setSound($machineCode, $responseType = 'horn', $voice = 1, $accessToken = null)
    {
        $api = $this->host . ApiEnum::SET_SOUND;
        $timestamp = time();
        $response = Http::post($api, [
            'client_id' => $this->clientId,
            'access_token' => $accessToken,
            'machine_code' => $machineCode,
            'response_type' => $responseType,
            'voice' => $voice,
            'sign' => $this->sign($timestamp),
            'id' => Str::uuid()->toString(),
            'timestamp' => $timestamp,
        ]);
        if (!$response->ok()) {
            throw new \Exception('声音调节接口调用失败', $response->status());
        }
        /*
        $response->json()
        array:3 [
          "error" => "0"
          "error_description" => "success"
        ]
        */
        $result = $response->json();
        if (!isset($result['error']) || $result['error'] != 0) {
            return false;
        }
        return true;
    }

    // 面单打印
    public function textPrint($machineCode, $content = '', $idempotence = 1, $originId = '', $accessToken = null)
    {
        $api = $this->host . ApiEnum::TEXT_PRINT;
        $timestamp = time();
        $response = Http::post($api, [
            'client_id' => $this->clientId,
            'access_token' => $accessToken,
            'machine_code' => $machineCode,
            'content' => $content,
            'idempotence' => $idempotence,
            'origin_id' => $originId,
            'sign' => $this->sign($timestamp),
            'id' => Str::uuid()->toString(),
            'timestamp' => $timestamp,
        ]);
        if (!$response->ok()) {
            throw new \Exception('文本打印接口调用失败', $response->status());
        }
        dd($response->json());
        /*
        $response->json()
        array:3 [
          "error" => "0"
          "error_description" => "success"
        ]
        */
        $result = $response->json();
        if (!isset($result['error']) || $result['error'] != 0) {
            return false;
        }
        return true;
    }


    // 加密
    public function sign($timestamp)
    {
        return md5($this->clientId . $timestamp . $this->clientSecret);
    }
}
