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

class Ezysoft extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'ezysoft';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'ezySoft';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('ezySoft Bridge ');
        $this->description = $this->l('Sync with ezySoft software');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
     
		include(dirname(__FILE__).'/sql/install.php');
		$this->installTab();
        return parent::install() &&
            $this->registerHook('displayBackOfficeHeader') &&
            $this->registerHook('actionObjectProductUpdateBefore');
    }

    public function uninstall()
    {
       include(dirname(__FILE__).'/sql/uninstall.php');
	   		$this->unistallTab();
        return parent::uninstall();
    }
	
	public function unistallTab(){
	
        $idtabs = array();
        $idtabs[] = Tab::getIdFromClassName("AdminEzySoftBridgeParent");
        $idtabs[] = Tab::getIdFromClassName("AdminEzySoftBridgeSettings");
        $idtabs[] = Tab::getIdFromClassName("AdminEzySoftBridge");
        $idtabs[] = Tab::getIdFromClassName("AdminEzySoftBridgeSync");
        $idtabs[] = Tab::getIdFromClassName("AdminEzySoftBridgeProducts");
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
        $tab->class_name = 'AdminEzySoftBridgeParent';
        $tab->module = $this->name;
        $tab->id_parent = $parent_id;
        $languages = Language::getLanguages(false);

        foreach ($languages as $language) {
            $tab->name[$language['id_lang']] = $this->l('ezySoft Bridge');
        }

        if (!$tab->save()) {
            return false;
        }

        $tabvaluees =  array(

            array(
                'class_name' => 'AdminEzySoftBridgeSettings',
                'id_parent'  => $tab->id,
                'module'     => $this->name,
                'name'       => $this->l('Settings')
            ),

            array(
                'class_name' => 'AdminEzySoftBridgeSync',
                'id_parent'  => $tab->id,
                'module'     => $this->name,
                'name'       => $this->l('Sync')
            ),

            array(
                'class_name' => 'AdminEzySoftBridgeProducts',
                'id_parent'  => $tab->id,
                'module'     => $this->name,
                'name'       => $this->l('Products')
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
            $tab->class_name = "AdminEzySoftBridge";
            $tab->module = $this->name;
            $tab->id_parent = 0;
            foreach ($languages as $language){
                $tab->name[$language['id_lang']] = $this->l('ezySoft Bridge');
            }
            $tab->save();

            return  $tab->id;
        }
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        /**
         * If values have been submitted in the form, process.
         */
        if (((bool)Tools::isSubmit('submitEzysoftModule')) == true) {
            $this->postProcess();
            $this->_html .= $this->displayConfirmation($this->l('Settings updated'));
        }


        $this->context->smarty->assign(
            [
                'callback' => $this->context->link->getModuleLink('ezysoft', 'callback'),
                'connect'  => $this->context->link->getModuleLink('ezysoft', 'connect'),
                'newProducts' => Tools::getHttpHost(true)._MODULE_DIR_.$this->name.'/new.php?token='.substr(Tools::encrypt('newProducts'), 0, 30),
                'updateProducts' => Tools::getHttpHost(true)._MODULE_DIR_.$this->name.'/update.php?token='.substr(Tools::encrypt('updateProducts'), 0, 30),
                'deleteProducts' => Tools::getHttpHost(true)._MODULE_DIR_.$this->name.'/delete.php?token='.substr(Tools::encrypt('deleteProducts'), 0, 30),
                'external' => Tools::getHttpHost(true)._MODULE_DIR_.$this->name.'/external.php?token='.substr(Tools::encrypt('external'), 0, 30),
            ]
        );

        $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');
        $this->_html .= $this->renderForm().$output;

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
        $helper->submit_action = 'submitEzysoftModule';
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
                        'name' => 'EZYSOFT_ENABLE',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Yes')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('No')
                            )
                        ),
                    ),

                    array(
                        'col' => 3,
                        'type' => 'text',
                        'name' => 'EZYSOFT_API_URL',
                        'label' => $this->l('API URL'),
                    ),
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'desc' => $this->l('You find from ezySoft'),
                        'name' => 'EZYSOFT_API_KEY',
                        'label' => $this->l('API KEY'),
                    ),
                    array(
                        'type' => 'text',
                        'col' => 1,
                        'name' => 'EZYSOFT_ID_STORE',
                        'label' => $this->l('Store ID'),
                    ),

                    array(
                        'type' => 'text',
                        'col' => 1,
                        'name' => 'EZYSOFT_DESTINATION_ID',
                        'label' => $this->l('DESTINATION ID'),
                    ),

                    array(
                        'col' => 3,
                        'type' => 'text',

                        'name' => 'EZYSOFT_SKU_PREFIX',
                        'label' => $this->l('SKU Prefix'),
                    ),

                    array(
                        'col' => 3,
                        'type' => 'text',

                        'name' => 'EZYSOFT_DEFAULT_CATEGORY',
                        'label' => $this->l('Default category'),
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
            'EZYSOFT_ENABLE'     => Configuration::get('EZYSOFT_ENABLE'),
            'EZYSOFT_ID_STORE'   => Configuration::get('EZYSOFT_ID_STORE'),
            'EZYSOFT_API_KEY'    => Configuration::get('EZYSOFT_API_KEY'),
            'EZYSOFT_SKU_PREFIX' => Configuration::get('EZYSOFT_SKU_PREFIX'),
            'EZYSOFT_DEFAULT_CATEGORY' => Configuration::get('EZYSOFT_DEFAULT_CATEGORY'),
            'EZYSOFT_DESTINATION_ID' => Configuration::get('EZYSOFT_DESTINATION_ID'),
            'EZYSOFT_API_URL'        => Configuration::get('EZYSOFT_API_URL')
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
        $controller_name = Tools::getValue('controller');
        if ($controller_name === 'AdminEzySoftBridgeSync' || Tools::getValue('configure') == $this->name) {

            Media::addJsDef(array(
                'ezySoft ' => array(
                    'api'           => $this->context->link->getAdminLink('AdminEzySoftBridgeSync', true),
                    'trans'         => $this->getTranslations()
                )
            ));

            $this->context->controller->addJS($this->_path.'views/js/loadingoverlay.min.js');
            $this->context->controller->addJS($this->_path.'views/js/sweetalert2.js');
            $this->context->controller->addJS($this->_path.'views/js/clipboard.min.js');
            $this->context->controller->addJS($this->_path.'views/js/back.js');
            $this->context->controller->addCSS($this->_path.'views/css/back.css');

        }
    }


    public function getTranslations(){

        return array(
            'start'     => $this->l('Start'),
            'yes'       => $this->l('Yes'),
            'no'        => $this->l('No'),
            'coffee'    => $this->l('Take coffee'),
            'wait'      => $this->l('Wait'),
            'copy'      => $this->l('Copied')
        );
    }
}
