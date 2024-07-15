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
 * @author    codepresta.com <info@ezysoft.gr>
 * @copyright 2024 ezysoft.gr
 * @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
 * @version   1.0.0
 * @created   16 July 2024
 * @last updated 16 July 2024
 */

use src\ezySoftApp;

include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../init.php');
require_once _PS_MODULE_DIR_.'ezysoft/src/DataHandler.php';
//substr(Tools::encrypt('external'), 0, 30)
if (substr(Tools::encrypt('external'), 0, 30) != Tools::getValue('token'))
    die('Ohhh......What happened.. Bad token');

$isInstall = Module::getInstanceByName('ezysoft');
if ($isInstall->active) {
    $isEnabled    = Configuration::get('EZYSOFT_ENABLE');
    if ($isEnabled) {
        $app = new DataHandler(Configuration::get('EZYSOFT_ID_STORE'), Configuration::get('EZYSOFT_API_KEY'),Configuration::get('EZYSOFT_API_URL'));
        $app->updExternal();
        die('Updated external....');
    }
}
