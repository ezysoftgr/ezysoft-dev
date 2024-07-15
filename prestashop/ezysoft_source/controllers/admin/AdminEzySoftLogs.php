<?php
require_once _PS_MODULE_DIR_.'ezysoft_source/classes/ezySoftLogs.php';

class AdminEzySoftLogsController extends ModuleAdminController {


    public function __construct()
    {
        $this->table = 'ezysoft_source_logs';
        $this->className = 'ezySoftLogs';
        $this->lang = false;

        $this->deleted = true;

        $this->explicitSelect = true;
        $this->addRowAction('delete');
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
            'id_ezysoft_source_logs' => array(
                'title' => $this->l('ID'),
                'width' => 30,
                'type' => 'text',
                'remove_onclick' => true
            ),
            'id_entry' => array(
                'title' => $this->l('Entry'),
                'remove_onclick' => true,
                'search' => false,

            ),

            'table' => array(
                'title' => $this->l('Table'),
                'remove_onclick' => true,
                'search' => false,
            ),


            'response_status' => array(
                'title' => $this->l('Response Status'),
                'remove_onclick' => true,
                'search' => false,
                'callback' => 'getResponseStatus'
            ),
            'message' => array(
                'title' => $this->l('Message'),
                'remove_onclick' => true,
                'search' => false
            ),

            'action' => array(
                'title' => $this->l('Action'),
                'remove_onclick' => true,
                'search' => false,

            ),
            'status' => array(
                'title' => $this->l('Status'),
                'remove_onclick' => true,
                'search' => false,
                'callback' => 'getStatus'
            ),

            'date_add' => array(
                'title' => $this->l('Date'),
                'remove_onclick' => true,
                'type' => 'datetime',
            ),


        );
    }




    public function getProduct($id)
    {
        return Db::getInstance()->getValue('SELECT `name` 
            FROM `'._DB_PREFIX_.'product_lang` 
            WHERE `id_product`='.(int)$id.'
             AND `id_lang`='.(int)Context::getContext()->language->id);
    }



    public function getStatus($status)
    {
        $render = '';
        if ($status){
            $render.= '<span class="label label-success">'.$status.'</span>';
        }elsE{
            $render.= '<span class="label label-danger">'.$status.'</span>';
        }
        return $render;
    }

    public function getResponseStatus($status)
    {
        $render = '';
        if ($status==200){
            $render.= '<span class="label label-success">'.$status.'</span>';
        }elsE{
            $render.= '<span class="label label-danger">'.$status.'</span>';
        }

        return $render;
    }

    public function initToolbar() {
        parent::initToolbar();

        unset( $this->toolbar_btn['new'] );
    }

}
