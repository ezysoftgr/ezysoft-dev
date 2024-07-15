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
class AdminEzySoftBridgeSettingsController extends AdminController
{
    public function __construct(){

        Tools::redirectAdmin('index.php?controller=AdminModules&configure=ezysoft&token=' . Tools::getAdminTokenLite('AdminModules'));
    }
}
