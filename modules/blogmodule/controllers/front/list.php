<?php
class blogmodulelistModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();
        $this->setTemplate('list.tpl');
        $sql = "SELECT * FROM `"._DB_PREFIX_."blogmodule`";
        $posts = [];
        if ($result=Db::getInstance()->ExecuteS($sql)) {
            foreach ($result as $post) {
                $post["link"] = $this->context->link->getModuleLink('blogmodule', 'postdetail', array('id' =>$post['id_blogmodule']));
                $posts[] = $post;
            }
            $this->context->smarty->assign(
                array(
                    'posts' => $posts
                )
            );
        }
    }
}
