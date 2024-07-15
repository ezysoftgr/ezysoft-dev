<?php
/**
 * 2023 codePresta.com
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
 *  @copyright 2023 codepresta.com
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
 *  @version   1.0.0
 *  @created   14 November 2023
 *  @last updated 14 November 2023
 */
$sql = array();


$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ezysoft_source_logs` (
    `id_ezysoft_source_logs` int(11) NOT NULL AUTO_INCREMENT,
    `id_entry` TEXT NOT NULL,
    `table` TEXT NOT NULL,
    `action` TEXT NOT NULL,
    `response_status` TEXT NOT NULL,
    `message` TEXT NOT NULL,
    `status` TEXT NOT NULL,
	`date_add` TEXT NOT NULL,
    PRIMARY KEY  (`id_ezysoft_source_logs`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';



foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}
