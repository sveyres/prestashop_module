<?php

class BlogModule extends Module
{
    public function __construct()
    {
        $this->name = 'blogmodule';
        $this->tab = 'front_office_features';
        $this->version = '1.1u';
        $this->author = 'Moi même aussi';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Blog module');
        $this->description = $this->l('en cours');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        if (!Configuration::get('BLOGMODULE_NAME')) {
            $this->warning = $this->l('No name provided');
        }
    }

    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }

        if (!parent::install()
            || !$this->installTab()
            || !$this->installDb()
            || !$this->registerHook('displayHome')
            || !$this->registerHook('displayLeftColumn'))
            {
                return false;
            }
        return true;
    }


// --------------------------------------------------------- SQL
    public function installDb()
    {
        return Db::getInstance()->Execute('
        CREATE TABLE '._DB_PREFIX_.'blogmodule (
            id_blogmodule INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            title VARCHAR(256) NOT NULL,
            content VARCHAR(500) NOT NULL,
            date DATETIME DEFAULT CURRENT_TIMESTAMP )');
    }

    public function uninstallDb()
    {
        return Db::getInstance()->Execute('DROP TABLE '._DB_PREFIX_.'blogmodule');
    }
// ------------------- END SQL

// --------------------------------------------------------- TAB
    public function installTab()
    {
        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = 'AdminBlogModule';
        $tab->name = array();
        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = 'Blog Module';
        }
        $tab->id_parent = 0;
        $tab->module = $this->name;
        return $tab->add();
    }

    public function uninstallTab()
    {
        $id_tab = (int)Tab::getIdFromClassName('AdminBlogModule');
        if ($id_tab) {
            $tab = new Tab($id_tab);
            return $tab->delete();
        } else {
            return false;
        }
    }
// -------------------END TAB

// --------------------------------------------------------- HOOK
    public function hookDisplayHome($params)
    {
        $productObj = new Product();
        $product = $productObj->getProducts(Context::getContext()->language->id, 0, 0, 'id_product', 'DESC', false, true)[0];


        $this->context->smarty->assign(
            array(
            'my_module_name' => Configuration::get('BLOGMODULE_NAME'),
            'my_module_link' => $this->context->link->getModuleLink('blogmodule', 'display'),
            'my_module_message' => $this->l('This is a simple text message'),
            'last_article' => $product
            )
        );
        return $this->display(_PS_MODULE_DIR_.$this->name, 'blogmodule.tpl');
    }

    public function hookDisplayHeader()
    {
        $this->context->controller->addCSS($this->_path.'css/blogmodule.css', 'all');
    }
// -------------------END HOOK

    public function uninstall()
    {
        if (!parent::uninstall()
            ||!$this->uninstallTab()
            ||!$this->uninstallDb()
        ) {
            return false;
        }
        return true;
    }

}
