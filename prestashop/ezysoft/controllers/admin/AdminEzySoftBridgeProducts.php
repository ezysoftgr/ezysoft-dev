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
class AdminEzySoftBridgeProductsController extends ModuleAdminController {

    public function __construct()
    {
        $this->table = 'ezysoft';
        $this->lang = false;
        $this->className = 'ezySoftRecords';
        $this->deleted = true;
        $this->explicitSelect = true;
        $this->allow_export= true;
        $this->_use_found_rows = true;

        if (!Tools::getValue('realedit')) {
            $this->deleted = false;
        }
        $this->bootstrap = true;
        $this->allow_export = false;
        parent::__construct();
        $this->bulk_actions = array(
            'delete' => array(
                'text' => $this->l('Delete selected'),
                'icon' => 'icon-trash',
                'confirm' => $this->l('Delete selected items?')
            ),
        );
        $this->fields_list = array(
            'id_ezysoft' => array(
                'title' => $this->l('ID'),
                'width' => 30,
                'type' => 'text',
                'remove_onclick' => true,
                 'search' => false,
            ),
            'id_source' => array(
                'title' => $this->l('ID Source'),
                'remove_onclick' => true,
            ),
            'id_product' => array(
                'title' => $this->l('Product'),
                'remove_onclick' => true,
                'callback' => 'getProduct',
                 'search' => false,
            ),
            'external' => array(
                'title' => $this->l('External'),
                'remove_onclick' => true,
                'search' => false,
                'callback' => 'getExternal'
            ),
            'status' => array(
                'title' => $this->l('Status Response'),
                'search' => false,
                'remove_onclick' => true,
            ),

            'date_add' => array(
                'title' => $this->l('Date add'),
                'search' => false,
                'remove_onclick' => true
            ),
        );
    }

    /**
     * @param $id
     * @return string
     */
    public function getExternal($id)
    {
        if($id){
            return '<span class="label-success label">'.$this->l('Yes').'</span>';
        }else{
            return '<span class="label-danger label">'.$this->l('No').'</span>';
        }
    }

    /**
     * @return void
     */
    public function initToolbar() {
        parent::initToolbar();
        unset( $this->toolbar_btn['new'] );
    }

    /**
     * @param $id
     * @return array|string
     */
    public function getProduct($id)
    {
        $product = new Product($id,null,Context::getContext()->language->id);
        return $product->name;
    }

}
