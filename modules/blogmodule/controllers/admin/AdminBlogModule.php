<?php

class AdminBlogModuleController extends ModuleAdminController {

    public function __construct()
    {
        $this->table = 'blogmodule';
		$this->className = 'BlogModule';
		$this->lang = true;
		$this->deleted = false;
		$this->colorOnBackground = false;
		$this->bulk_actions = array('delete' => array('text' => $this->l('Delete selected'), 'confirm' => $this->l('Delete selected items?')));
		$this->context = Context::getContext();

        parent::__construct();
    }
    public function renderForm()
    {

	}
}

?>
