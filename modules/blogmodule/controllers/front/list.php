<?php
class blogmodulelistModuleFrontController extends ModuleFrontController
{
  public function initContent()
  {
    parent::initContent();
    $this->setTemplate('list.tpl');

  }
}
