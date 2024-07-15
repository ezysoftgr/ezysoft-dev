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
require_once _PS_MODULE_DIR_.'ezysoft/classes/ezySoftRecords.php';
require_once _PS_MODULE_DIR_.'ezysoft/src/DataHandler.php';
require_once _PS_MODULE_DIR_.'ezysoft/src/RestApiHandler.php';
class AdminEzySoftBridgeSyncController extends ModuleAdminController
{
    public function __construct()
    {
        $this->bootstrap = true;
        $this->ajax = true;
        parent::__construct();
    }
    public function initContent()
    {
        $this->show_toolbar = false;
        $this->display = 'view';
        parent::initContent();
    }

    public function renderView()
    {

        $module = Module::getInstanceByName('ezysoft');
        $version = $module->version;

        $app = new DataHandler(Configuration::get('EZYSOFT_ID_STORE'), Configuration::get('EZYSOFT_API_KEY'),Configuration::get('EZYSOFT_API_URL'));
        $new_products  = $app->countData('new');
        $upd_products  = $app->countData('update');
        $delete_products  = $app->countData('delete');
        //$excluded = $app->countData('exclude');

        $active = Configuration::get('EZYSOFT_ENABLE');
        $status = $app->checkBridge();


        $this->tpl_view_vars = array(
            'active'            => $active,
            'deletedProducts'   => $delete_products,
        //    'excluded'          => $excluded,
            'status_api'        => $status['status'],
            'newProducts'       => $new_products,
            'updProducts'       => $upd_products,
            'link_configuration' => Context::getContext()->link->getAdminLink(
                    'AdminModules').'&configure=ezysoft',
            'version'           => $version,
            'catalog'           => Tools::getHttpHost(true)._MODULE_DIR_.'ezysoft/views/img/catalog.webp',
             'happy'            => Tools::getHttpHost(true)._MODULE_DIR_.'ezysoft/views/img/hp.gif',
            'logo'              => Tools::getHttpHost(true)._MODULE_DIR_.'ezysoft/views/img/logo.png',
            'settings'          => Tools::getHttpHost(true)._MODULE_DIR_.'ezysoft/views/img/settings.svg',
            'support'           => Tools::getHttpHost(true)._MODULE_DIR_.'ezysoft/views/img/support.svg',
            'doc'               => Tools::getHttpHost(true)._MODULE_DIR_.'ezysoft/views/img/doc.svg',
            'coffee'            => Tools::getHttpHost(true)._MODULE_DIR_.'ezysoft/views/img/coffee.gif',
            'check'             => Tools::getHttpHost(true)._MODULE_DIR_.'ezysoft/views/img/check.gif',
        );

        return parent::renderView();
    }


    public function displayAjaxAddToList(){

        ini_set('max_execution_time', 0);
        set_time_limit(0);

        $app = new DataHandler(Configuration::get('EZYSOFT_ID_STORE'), Configuration::get('EZYSOFT_API_KEY'),Configuration::get('EZYSOFT_API_URL'));
        $app->setAction('new');
        $app->addToList(false);

        header('Content-Type: application/json');
        echo json_encode(
            [
                'error' => false,
                'messages' => $this->l('The imported has been completed'),
            ]
        );
        exit;


    }

    public function displayAjaxUpdateList()
    {
        ini_set('max_execution_time', 0);
        set_time_limit(0);

        $app = new DataHandler(Configuration::get('EZYSOFT_ID_STORE'), Configuration::get('EZYSOFT_API_KEY'),Configuration::get('EZYSOFT_API_URL'));
        $app->setAction('update');
        $app->updateList(false);
        header('Content-Type: application/json');
        echo json_encode(
            [
                'error' => false,
                'messages' => $this->l('The updated has been completed'),
            ]
        );
        exit;
    }

    public function displayAjaxExcludeList()
    {
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        $app = new DataHandler(Configuration::get('EZYSOFT_ID_STORE'), Configuration::get('EZYSOFT_API_KEY'),Configuration::get('EZYSOFT_API_URL'));
        $app->setAction('exclude');
        $app->deleteList();

        header('Content-Type: application/json');
        echo json_encode(
            [
                'error' => false,
                'messages' => $this->l('The deleted has been completed'),
            ]
        );
        exit;
    }

    public function displayAjaxDeleteList()
    {
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        $app = new DataHandler(Configuration::get('EZYSOFT_ID_STORE'), Configuration::get('EZYSOFT_API_KEY'),Configuration::get('EZYSOFT_API_URL'));
        $app->setAction('delete');
        $app->deleteList();

        header('Content-Type: application/json');
        echo json_encode(
            [
                'error' => false,
                'messages' => $this->l('The deleted has been completed'),
            ]
        );
        exit;
    }
}