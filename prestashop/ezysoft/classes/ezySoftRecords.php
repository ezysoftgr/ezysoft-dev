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

class ezySoftRecords extends ObjectModel
{

    public $id_ezysoft;
    public $id_source;
    public $id_product;
    public $external;
    public $status;
    public $date_add;



    public static $definition = array(
        'table' => 'ezysoft',
        'primary' => 'id_ezysoft',
        'multilang' => false,
        'fields' => array(
            'id_source' => array('type' => self::TYPE_INT),
            'id_product' => array('type' => self::TYPE_INT),
            'external' => array('type' => self::TYPE_INT),
            'status' => array('type' => self::TYPE_STRING),
            'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDateFormat'),
        )
    );

    public static function getRowByIdSource($id_source)
    {
        $sql ='SELECT `id_ezysoft` FROM `'._DB_PREFIX_.'ezysoft` WHERE `id_source`='.(int)$id_source;
        $res = Db::getInstance()->getValue($sql);
        return ($res)  ? $res : false;
    }

    public static function verifyProductId($id)
    {
        $sql = 'SELECT `id_product` FROM `'._DB_PREFIX_.'ezysoft` WHERE `id_product`='.(int)$id;
        $r = Db::getInstance()->getValue($sql);

        return ($r) ? $r : false;
    }
    public static function verifySource($id)
    {
        $sql = 'SELECT `id_source` FROM `'._DB_PREFIX_.'ezysoft` WHERE `id_source`='.(int)$id;
        $r = Db::getInstance()->getValue($sql);

        return ($r) ? $r : false;
    }

    public static function getIdProduct($id_ezysoft)
    {
        $sql = 'SELECT `id_product` FROM `'._DB_PREFIX_.'ezysoft` WHERE `id_source`='.(int)$id_ezysoft;
        $r = Db::getInstance()->getValue($sql);

        return ($r) ? $r : false;
    }


    public static function getExternals()
    {
        $sql ='SELECT * FROM `'._DB_PREFIX_.'ezysoft` WHERE `external`=1';
        return Db::getInstance()->executeS($sql);
    }




}
