<?php
/**
 * 2007-2024 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2024 PrestaShop SA
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */


if (!defined('_PS_VERSION_')) {
    exit;
}
require_once _PS_MODULE_DIR_.'ezysoft/src/DataHandler.php';
class ezysoftCallbackModuleFrontController extends ModuleFrontControllerCore
{
    public function initContent()
    {
        parent::initContent();


        if(Configuration::get('EZYSOFT_ENABLE')) {

                ini_set('max_execution_time', 0);
                set_time_limit(0);

                $input = file_get_contents('php://input');
                $data = json_decode($input, true);

                $DataHandler = new DataHandler(Configuration::get('EZYSOFT_ID_STORE'),
                Configuration::get('EZYSOFT_API_KEY'),Configuration::get('EZYSOFT_API_URL'));

                if ($data['action'] ==  'delete'){
                    $DataHandler->setAction('delete');
                    $return = $DataHandler->deleteList(true, $data);
                }elseif ($data['action'] == 'update'){

                    $DataHandler->setAction('update');
                    $return = $DataHandler->updateList(true, $data);
                }elseif ($data['action'] == 'new'){

                    $DataHandler->setAction('new');
                    $return = $DataHandler->addToList(true, $data);
                }else{
                    $return = [];
                }

        }else{
            $return =[];
        }

        // Επιστροφή της απάντησης σε JSON μορφή
        header('Content-Type: application/json');
        echo json_encode($return);
        exit;
    }
}