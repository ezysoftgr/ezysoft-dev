<?php
/**
 * 2024 ezySoft
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the General Public License (GPL 2.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/GPL-2.0
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the module to newer
 * versions in the future.
 *
 *  @author    codepresta.com <hello@codepresta.com>
 *  @copyright 2024 ezySoft.gr
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
 *  @version   1.0.0
 *  @created   14 July 2024
 *  @last updated 14 July 2024
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class  RestApiHandler
{
    private $baseUrl;
    private $headers;
    private $version_api;
    private $api_key;
    private $user_id;

    /**
     * @param $baseUrl
     * @param $headers
     */
    public function __construct($baseUrl, $version_api,$api_key, $user_id, $headers = []) {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->headers = $headers;
        $this->version_api = rtrim($version_api, '/');
        $this->user_id = $user_id;
        $this->api_key = $api_key;
    }

    /**
     * @param $method
     * @param $endpoint
     * @param $data
     * @return array
     * @throws Exception
     */
    private function request($method, $endpoint, $data = []) {

        $url = $this->baseUrl.'/api/'.$this->version_api.'/' . $endpoint;
        $curl = curl_init($url);

        switch ($method) {
            case 'GET':
                if (!empty($data)) {
                    $url .= '?' . http_build_query($data);
                }
                $type = 'application/json';
                break;
            case 'POST':
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
               $type = 'application/x-www-form-urlencoded';
                break;
            case 'PUT':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                $type = 'application/x-www-form-urlencoded';
                break;
            case 'DELETE':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
                $type = 'application/x-www-form-urlencoded';
                break;
            default:
                throw new Exception('Invalid HTTP method');
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            $type,
            'api_key: ' .$this->api_key,
        ]);


        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if (curl_errno($curl)) {
            throw new Exception(curl_error($curl));
        }

        curl_close($curl);

        return ['code' => $httpCode, 'response' => json_decode($response, true)];
    }

    /**
     * @param $endpoint
     * @param $data
     * @return array
     * @throws Exception
     */
    public function get($endpoint, $data = []) {
        return $this->request('GET', $endpoint, $data);
    }


    /**
     * @param $endpoint
     * @param $data
     * @return array
     * @throws Exception
     */
    public function post($endpoint, $data = []) {
        return $this->request('POST', $endpoint, $data);
    }

    /**
     * @param $endpoint
     * @param $data
     * @return array
     * @throws Exception
     */
    public function put($endpoint, $data = []) {
        return $this->request('PUT', $endpoint, $data);
    }

    /**
     * @param $endpoint
     * @param $data
     * @return array
     * @throws Exception
     */
    public function delete($endpoint, $data = []) {
        return $this->request('DELETE', $endpoint, $data);
    }
}