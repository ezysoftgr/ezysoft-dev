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



if (!defined('_PS_VERSION_')) {
    exit;
}

class ezySoftLogs extends ObjectModel
{

    public $ezysoft_source_logs;
    public $id_entry;
    public $table;
    public $action;
    public $response_status;
    public $message;
    public $status;
    public $date_add;



    public static $definition = array(
        'table' => 'ezysoft_source_logs',
        'primary' => 'id_ezysoft_source_logs',
        'multilang' => false,
        'fields' => array(
            'id_entry' => array('type' => self::TYPE_STRING),
            'table' => array('type' => self::TYPE_STRING),
            'action' => array('type' => self::TYPE_STRING),
            'response_status' => array('type' => self::TYPE_STRING),
            'message' => array('type' => self::TYPE_STRING),
            'status' => array('type' => self::TYPE_BOOL),
            'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat'),

        )
    );





}
