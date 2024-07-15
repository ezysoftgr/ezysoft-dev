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

class ezysoftConnectModuleFrontController extends ModuleFrontControllerCore
{
    public function initContent()
    {

        header('Content-Type: application/json');

        if (Module::isEnabled('ezysoft')){
            if (Configuration::get('EZYSOFT_ENABLE')){
                echo json_encode([
                    'status' => true,
                    'message' => $this->l('Module is enabled'),
                ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            }else{
                http_response_code(540);
                echo json_encode([
                    'status' => false,
                    'message' => $this->l('Module is disabled'),
                ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                return;
            }
        }else{
            http_response_code(540);
            echo json_encode([
                'is_successful' => false,
                'message' => $this->l('Module is disabled'),
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            return;
        }

        exit;

    }
}