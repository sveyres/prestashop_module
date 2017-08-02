<?php

class blogmodulepostdetailModuleFrontController extends ModuleFrontController
{
  public function initContent()
  {
    parent::initContent();
    $this->setTemplate('post_detail.tpl');
    $post_id = Tools::getValue('id');
    $sql = "SELECT * FROM `"._DB_PREFIX_."blogmodule` WHERE id_blogmodule=".$post_id;
    if ($result=Db::getInstance()->ExecuteS($sql)) {
      $this->context->smarty->assign(
        array(
            'post' => $result,
        )
    );
    }
    }
  }
