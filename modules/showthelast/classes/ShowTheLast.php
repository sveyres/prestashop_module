<?php

class ShowTheLast extends Module
{
    public function __construct()
    {
        $this->name = 'showthelast';
        $this->tab = 'front_office_features';
        $this->version = '1.1u';
        $this->author = 'Moi même aussi';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('show the last');
        $this->description = $this->l('show the last product added');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        if (!Configuration::get('SHOWTHELAST_NAME')) {
            $this->warning = $this->l('No name provided');
        }
    }
    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }

        return parent::install() &&
            $this->registerHook('leftColumn') &&
            $this->registerHook('header') &&
            Configuration::updateValue('SHOWTHELAST_NAME', 'my friend');

    }
    public function hookDisplayLeftColumn($params)
    {
        $productObj = new Product();
        $product = $productObj->getProducts(Context::getContext()->language->id, 0, 0, 'id_product', 'DESC', false, true)[0];
        

        $this->context->smarty->assign(
            array(
            'my_module_name' => Configuration::get('SHOWTHELAST_NAME'),
            'my_module_link' => $this->context->link->getModuleLink('showthelast', 'display'),
            'my_module_message' => $this->l('This is a simple text message'),
            'last_article' => $product
            )
        );
        return $this->display(_PS_MODULE_DIR_.$this->name, 'showthelast.tpl');
    }

    public function hookDisplayRightColumn($params)
    {
        return $this->hookDisplayLeftColumn($params);
    }

    public function hookDisplayHeader()
    {
        $this->context->controller->addCSS($this->_path.'css/showthelast.css', 'all');
    }
    public function uninstall()
    {
        if (!parent::uninstall() ||
            !Configuration::deleteByName('SHOWTHELAST_NAME')
        ) {
            return false;
        }

        return true;
    }

    // public static function getLastProduct()
    // {
    //     $productObj = new Product();
    //     $products = $productObj->getProducts(Context::getContext()->language->id, 0, 0, 'id_product', 'DESC', false, true)[0];
    //     return $products['name'];
    // }
}
