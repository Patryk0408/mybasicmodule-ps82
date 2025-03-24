<?php 

class MyBasicModuleTestModuleFrontController extends ModuleFrontController {
    public function initContent() {
        parent::initContent();
        $this->context->smarty->assign([
            "data" => "Hello from the controller",
        ]);
        $this->setTemplate("module:mybasicmodule/views/templates/front/test.tpl");
    }

    public function postProcess() {
        if(Tools::isSubmit("form")) 
        {
            return Tools::redirect("URL"); 
        }
    }
}