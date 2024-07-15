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
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2024 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}
require_once _PS_MODULE_DIR_.'ezysoft_source/EzySoft_Connector.php';
class Ezysoft_source extends Module
{

    public static $executed = false;
    public function __construct()
    {
        $this->name = 'ezysoft_source';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'ezySoft';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('EzySoft source connector ');
        $this->description = $this->l('With this module you can add your products, customers and orders  to ezysoft');
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        include(dirname(__FILE__).'/sql/install.php');
		$this->installField();
        $this->installTab();
        return parent::install() &&
            $this->registerHook('actionProductDelete') &&
			$this->registerHook('actionValidateOrder') &&
			$this->registerHook('displayAdminProductsMainStepLeftColumnMiddle') &&
            $this->registerHook('displayBackOfficeHeader') &&
            $this->registerHook('actionObjectProductUpdateBefore') &&
            $this->registerHook('actionAdminControllerSetMedia') &&
            $this->registerHook('actionProductSave');
    }

    public function hookActionAdminControllerSetMedia($params)
    {



    }
    public function hookActionDisabledProductGridDataModifier($params)
    {


    }
    public function hookActionProductSave($params)
    {
        $product = $params['product'];
        $productId = (int)$product->id;

        $executed = self::$executed;
        if ($executed) {
            return;
        }
        self::$executed = true;

        $ezysoft = Tools::getValue('ezysoft');
        $v = ($ezysoft == 'on') ? true :false;
        self::addEzySoft($v, $productId);
    }

    public static function addEzySoft($ezysoft, $id)
    {
        return Db::getInstance()->update('product', [
            'ezysoft' => $ezysoft,
        ],'id_product='.(int)$id);
    }
    public function hookDisplayAdminProductsMainStepLeftColumnMiddle($params) {

        $id_product = $params['id_product'];
        $ezysoft = self::getEzySoftFieldDB($id_product);


        $this->context->smarty->assign(array(
                'ezysoft' => $ezysoft,

            )
        );
        return $this->display(__FILE__, 'field.tpl');
    }


    public static function getEzySoftFieldDB($id_product)
    {
        $sql = 'SELECT `ezysoft` FROM `'._DB_PREFIX_.'product` WHERE `id_product`='.(int)$id_product;
        return Db::getInstance()->getValue($sql);
    }
	
	

    public function uninstall()
    {
        include(dirname(__FILE__).'/sql/uninstall.php');
         $this->unistallField();
		$this->unistallTab();
		
        return parent::uninstall();
    }

	
	public function installField(){
		$sql = 'ALTER TABLE `'._DB_PREFIX_.'product` ADD `ezysoft` int(11)  NULL';
        $rs = Db::getInstance()->execute($sql);
        return $rs;
	}
	
	public function unistallField(){
        $sql = 'ALTER TABLE `'._DB_PREFIX_.'product` DROP `ezysoft` int(11)  NULL';
        $rs = Db::getInstance()->execute($sql);
        return $rs;
	}
	
    /**
     * Load the configuration form
     */
    public function getContent()
    {
        /**
         * If values have been submitted in the form, process.
         */
        if (((bool)Tools::isSubmit('submitEzysoft_sourceModule')) == true) {
            $this->postProcess();
            $this->_html .= $this->displayConfirmation($this->l('Settings updated'));
        }
        if (Tools::getValue('ajax')) {
            $id_product = (int) Tools::getValue('id_product');
            $this->ajaxAction($id_product);
        }


        $this->_html .= $this->renderForm();
        return $this->_html;
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitEzysoft_sourceModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {
        return array(
            'form' => array(
                'legend' => array(
                'title' => $this->l('Settings'),
                'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable'),
                        'name' => 'EZYSOFT_SOURCE_ENABLE',
                        'is_bool' => true,
                        'desc' => $this->l('Use this module in live mode'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'col' => 5,
                        'type' => 'text',
                        'desc' => $this->l('You will find in the EzySoft'),
                        'name' => 'EZYSOFT_SOURCE_API_KEY',
                        'label' => $this->l('API KEY'),
                    ),
                    array(
                        'col' => 5,
                        'type' => 'text',
                        'desc' => $this->l('You will find in the EzySoft'),
                        'name' => 'EZYSOFT_SOURCE_STORE_ID',
                        'label' => $this->l('Store ID'),
                    ),

                    array(
                        'type' => 'select',
                        'name' => 'EZYSOFT_SOURCE_ID_LANG',
                        'class' => 'chosen',
                        'col' => 5,
                        'options' => array(
                            'query' => $this->getLangs(),
                            'id' => 'id',
                            'name' => 'name'
                        ),
                        'label' => $this->l('Language'),
                    ),

                    array(
                        'type' => 'switch',
                        'label' => $this->l('Send order & customer to ezySoft'),
                        'name' => 'EZYSOFT_SEND_ORDER_AND_CUSTOMER',
                        'is_bool' => true,

                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),

                    array(
                        'type' => 'switch',
                        'label' => $this->l('You want the quantity updated when an order is placed'),
                        'name' => 'EZYSOFT_UPD_QTY_ORDER',
                        'is_bool' => true,

                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        return array(
            'EZYSOFT_SOURCE_ENABLE' => Configuration::get('EZYSOFT_SOURCE_ENABLE'),
            'EZYSOFT_SOURCE_API_KEY' => Configuration::get('EZYSOFT_SOURCE_API_KEY'),
            'EZYSOFT_SOURCE_ID_LANG' => Configuration::get('EZYSOFT_SOURCE_ID_LANG'),
            'EZYSOFT_SOURCE_STORE_ID' => Configuration::get('EZYSOFT_SOURCE_STORE_ID'),
            'EZYSOFT_SEND_ORDER_AND_CUSTOMER' => Configuration::get('EZYSOFT_SEND_ORDER_AND_CUSTOMER'),
            'EZYSOFT_UPD_QTY_ORDER' => Configuration::get('EZYSOFT_UPD_QTY_ORDER'),

        );
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    /**
    * Add the CSS & JavaScript files you want to be loaded in the BO.
    */
    public function hookDisplayBackOfficeHeader()
    {
        if (Tools::getValue('controller') == 'AdminProducts') {
            $ajax_path = 'index.php?controller=AdminModules&configure='.$this->name.
                '&token='.Tools::getAdminTokenLite('AdminModules').'&ajax=1';
            Media::addJsDef(['ezysoft_source' => $ajax_path
            ]);
            $this->context->controller->addJS($this->_path.'back.js');
        }
    }

    public function ajaxAction($id_product)
    {
        if (Configuration::get('EZYSOFT_SOURCE_ENABLE')) {
            $id_lang = (int)Configuration::get('EZYSOFT_SOURCE_ID_LANG');
            $ezysoft = self::getEzySoftFieldDB($id_product);


            if ($ezysoft){
                EzySoft_Connector::updateOrCreateProduct($id_product, $id_lang);
            }else{
                EzySoft_Connector::excludeEzySoft($id_product);
            }

        }
    }

	
	public function hookActionObjectProductUpdateBefore($params)
    {
        if ($this->context->controller instanceof AdminProductsController) {
        }else{
            if (Configuration::get('EZYSOFT_SOURCE_ENABLE')) {
                $executed = self::$executed;
                if ($executed) {
                    return;
                }
                self::$executed = true;
                EzySoft_Connector::changeStatus($params['object']);
            }
        }
    }
	
	public function hookActionProductDelete($params)
    {

        if (Configuration::get('EZYSOFT_SOURCE_ENABLE')){
            EzySoft_Connector::toDeleteList($params['id_product']);
        }
    }

    public function getLangs()
    {
        $langs = Language::getLanguages(true);
        $return = [];
        foreach ($langs as $lang){
            $return[] = array(
                'id'    => $lang['id_lang'],
                'name' => $lang['name']
            );
        }

        return $return;
    }


		public function unistallTab(){
	
        $idtabs = array();
        $idtabs[] = Tab::getIdFromClassName("AdminEzySoftParent");
        $idtabs[] = Tab::getIdFromClassName("AdminEzySoftSettings");
        $idtabs[] = Tab::getIdFromClassName("AdminEzySoftLogs");
   
		
		

        foreach ($idtabs as $tabId) {
            if ($tabId) {
                $tab = new Tab($tabId);
                $tab->delete();
            }
        }
   
	}

    public function installTab(){

        //AdminCatalog

        $parent_id = $this->getIDtab();
        $tab = new Tab();
        $tab->class_name = 'AdminEzySoftParent';
        $tab->module = $this->name;
        $tab->id_parent = $parent_id;
        $languages = Language::getLanguages(false);

        foreach ($languages as $language) {
            $tab->name[$language['id_lang']] = $this->l('ezySoft');
        }

        if (!$tab->save()) {
            return false;
        }

        $tabvaluees =  array(

            array(
                'class_name' => 'AdminEzySoftSettings',
                'id_parent'  => $tab->id,
                'module'     => $this->name,
                'name'       => $this->l('Settings')
            ),

            array(
                'class_name' => 'AdminEzySoftLogs',
                'id_parent'  => $tab->id,
                'module'     => $this->name,
                'name'       => $this->l('Logs')
            ),
        );



        foreach ($tabvaluees as $newTab){

            $newtab 			= new Tab();
            $newtab->class_name = $newTab['class_name'];
            $newtab->id_parent  = $tab->id;
            $newtab->module     = $newTab['module'];
            foreach ($languages as $l){
                $newtab->name[$l['id_lang']] = $this->l($newTab['name']);
            }
            $newtab->save();

        }

        return true;
    }

    public  function getIDtab(){

        $parent_id = Tab::getIdFromClassName('AdminEzySoft'); // get parent_id

        if ($parent_id){
            return $parent_id; /// parent_id
        }else{

            $languages = Language::getLanguages(true);
            $tab = new Tab();
            $tab->class_name = "AdminEzySoft";
            $tab->module = $this->name;
            $tab->id_parent = 0;
            foreach ($languages as $language){
                $tab->name[$language['id_lang']] = $this->l('ezySoft');
            }
            $tab->save();

            return  $tab->id;
        }
    }

    public function hookActionValidateOrder($params)
    {



        if (Configuration::get('EZYSOFT_SOURCE_ENABLE')) {


                EzySoft_Connector::updateOrCreateOrder($params['order']);


        }
    }

}
