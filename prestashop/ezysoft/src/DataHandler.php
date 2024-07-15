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
 * @author    codepresta.com <hello@codepresta.com>
 * @copyright 2024 ezySoft.gr
 * @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
 * @version   1.0.0
 * @created   14 July 2024
 * @last updated 14 July 2024
 */




if (!defined('_PS_VERSION_')) {
    exit;
}
require_once _PS_MODULE_DIR_ . 'ezysoft/src/DataCollector.php';
require_once _PS_MODULE_DIR_ . 'ezysoft/src/RestApiHandler.php';

class DataHandler
{


    public $user_id;
    public $action;
    public $api;


    /**
     * @param $user_id
     * @param $api_key
     */
    public function __construct($user_id, $api_key, $api_url)
    {
        $this->user_id = $user_id;
        $this->api = new RestApiHandler($api_url, 'v1', $api_key, $user_id);
    }

    /**
     * @param $type
     * @return mixed
     * @throws Exception
     */
    public function countData($type)
    {
        $http_response = $this->api->get('store/' . $this->user_id . '/product/list/' . $type);
        return count($http_response['response']);
    }

    /**
     * @param $action
     * @return void
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function getGetResponse()
    {
        $http_response = $this->api->get('store/' . $this->user_id . '/product/list/' . $this->getAction());
        return $http_response['response'];
    }

    /**
     * @param $isExternal
     * @param $posData
     * @return array
     * @throws Exception
     */
    public function addToList($isExternal = false, $posData = false)
    {
        $response = [];
        $data = (!$isExternal) ? $this->getGetResponse() : $posData;

        if ($isExternal) {
            if (!ezySoftRecords::verifySource($data['id'])) {
                $DataCollector = new DataCollector($data);
                $DataCollector->setIdSource($data['id']);
                $DataCollector->toPrestashop();
                if ($data['id']) {
                    $DataCollector->setApiResponseStatus(array('status' => 200));
                    $DataCollector->setExternal(true);
                    $DataCollector->toList();
                    $status = true;
                    $message =  'Product added to list. Product ID: ' . $DataCollector->getIdProduct();
                }
            }else{
                $status = false;
                $message = 'Product already exists.';
            }

            return [
                'status' => $status,
                'message' => $message,
                'action' => 'new',
                'id' => $DataCollector->getIdProduct()
            ];

        } else {

            if (is_array($data)) {
                foreach ($data as $item) {
                    $DataCollector = new DataCollector($item);
                    $DataCollector->setIdSource($item['id']);
                    $DataCollector->setExternal(false);
                    $DataCollector->toPrestashop();
                    if ($item['id']) {
                        $res = $this->api->post('product/callback/new', [
                            'id' => $item['id'],
                            'id_destination' => (int)Configuration::get('EZYSOFT_DESTINATION_ID'),
                            'id_entry' => $DataCollector->getIdProduct(),
                        ]);



                        $DataCollector->setApiResponseStatus($res['response']);
                        $id = $DataCollector->toList();
                        $response [] = $id;
                    }
                }
            }
        }

        return $response;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function updateList($isExternal = false, $posData = false)
    {
        $data = (!$isExternal) ? $this->getGetResponse() : $posData;
        $ids = [];
        if ($isExternal) {
            if ($id_ezysoft = ezySoftRecords::verifySource($data['id'])) {
                $find_product_id = ezySoftRecords::getIdProduct($id_ezysoft);
                if (ezySoftRecords::verifyProductId($find_product_id)) {
                    $DataCollector = new DataCollector($data);
                    $DataCollector->setIdSource($data['id']);
                    $DataCollector->toPrestashop($find_product_id);
                    $status = true;
                    $message = 'Product updated.';
                }else{
                    $status = true;
                    $message = 'Product prestashop not found.';
                }

            }else{
                $status = false;
                $message = 'Product not found';
            }

            return [
                'status' => $status,
                'message' => $message,
                'action' => 'update'
            ];
        }else{

            foreach ($data as $item) {
                if ($id_ezysoft = ezySoftRecords::verifySource($item['id'])) {
                    $find_product_id = ezySoftRecords::getIdProduct($id_ezysoft);

                        $DataCollector = new DataCollector($item);
                        $DataCollector->setIdSource($item['id']);
                        $DataCollector->toPrestashop($find_product_id);
                       $d =  $this->api->post('product/callback/update', [
                            'id' => $item['id'],
                           'id_destination' => (int)Configuration::get('EZYSOFT_DESTINATION_ID'),
                        ]);

                       print_r($d);die;

                        $ids [] = $find_product_id;

                }
            }
        }

        return $ids;
    }

    /**
     * @return false|void
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function deleteList($isExternal = false, $posData = false)
    {


        $data_response = (!$isExternal) ? $this->getGetResponse() : $posData;

        if ($isExternal) {


            $id_row = ezySoftRecords::getRowByIdSource($data_response['id']);
            if ($id_row) {

                $id_prestashop = ezySoftRecords::getIdProduct($data_response['id']);
                if ($id_prestashop) {
                    $prod = new Product($id_prestashop);
                    if (!$prod->delete()) {
                        return false;
                    }
                }

                $ezy = new ezySoftRecords($id_row);
                if (!$ezy->delete()) {
                    return false;
                }
                $status = true;
                $message = 'Product deleted.';
            }else{
                $status = false;
                $message = 'Product not found';
            }

            return [
                'status' => $status,
                'message' => $message,
                'action' => 'update'
            ];
        }else{
            if ($data_response) {
                $data = array_column($data_response, 'id');
                foreach ($data as $id) {
                    $res = $this->api->post('product/callback/delete', [
                        'id' => $id,
                        'id_destination' => (int)Configuration::get('EZYSOFT_DESTINATION_ID'),
                    ]);;

                    if ($res['response']['status'] == 200) {
                        $id_prestashop = ezySoftRecords::getIdProduct($id);
                        $id_row = ezySoftRecords::getRowByIdSource($id);
                        if ($id_prestashop) {
                            $prod = new Product($id_prestashop);
                            if (!$prod->delete()) {
                                return false;
                            }
                            $ezy = new ezySoftRecords($id_row);
                            if (!$ezy->delete()) {
                                return false;
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * @return false|void
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function updExternal()
    {
        $records = ezySoftRecords::getExternals();
        foreach ($records as $record) {
            $res = $this->api->post('product/callback/new', [
                'id' => $record['id_source'],
                'id_destination' => (int)Configuration::get('EZYSOFT_DESTINATION_ID'),
                'id_entry' => $record['id_product'],
            ]);

            $up = new ezySoftRecords($record['id_ezysoft']);
            $up->status = $res['response']['status'];
            $up->external = false;
            if (!$up->update()) {
                return false;
            }

        }
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function checkBridge()
    {
        $res = $this->api->get('check/'.Configuration::get('EZYSOFT_API_KEY'));
        return $res['response'];
    }
}