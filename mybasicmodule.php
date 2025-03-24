<?php
/*
* 2007-2016 PrestaShop
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

if (!defined('_PS_VERSION_'))
    exit;

class MyBasicModule extends Module implements WidgetInterface
{

    protected $templateFile;

    public function __construct()
    {
        $this->name = 'mybasicmodule';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Patrick';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => "8.0",
            'max' => _PS_VERSION_
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('My Basic Module');
        $this->description = $this->l('Description of my basic module.');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        $this->templateFile = 'module:mybasicmodule/views/templates/hook/footer.tpl';

    }

    public function install() {
        return $this->sqlInstall()
        && $this->installTab()
        && parent::install() 
        && $this->registerHook('registerGDPRConsent') 
        && $this->registerHook('moduleRoutes');
    }

    public function uninstall() : bool {
        return parent::uninstall() 
        && $this->sqlUninstall() 
        && $this->uninstallTab()
        ;
    }

    protected function sqlInstall() {
        $sql = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "testcomment` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `user_id` varchar(255) DEFAULT NULL,
            `comment` varchar(255) DEFAULT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=" . _MYSQL_ENGINE_ . " DEFAULT CHARSET=utf8;";

        return Db::getInstance()->execute($sql);
    }

    protected function sqlUninstall() {
        $sql = "DROP TABLE `" . _DB_PREFIX_ . "testcomment`";
        return Db::getInstance()->execute($sql);
    }

    public function installTab() {
        $tabId = (int) Tab::getIdFromClassName('AdminTest');
        if (!$tabId) {
            $tabId = null;
        }

        $tab = new Tab($tabId);
        $tab->active = 1;
        $tab->class_name = 'AdminTest';
        $tab->module = $this->name;
        $tab->id_parent = (int) Tab::getIdFromClassName('DEFAULT');
        $tab->icon = 'settings_applications';
        $languages = Language::getLanguages();
        foreach ($languages as $lang) {
            $tab->name[$lang['id_lang']] = $this->trans('My Module Demo', array(), 'Modules.MyModule.Admin', $lang['locale']);
        }

        try {
            return $tab->add();
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function uninstallTab() {
        $idTab = (int)Tab::getIdFromClassName('AdminTest');

        if ($idTab) {
            $tab = new Tab($idTab);
            try {
                $tab->delete();
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
        }

        return true;
    }

    // public function hookdisplayFooter($params) {
    //     $this->context->smarty->assign([
    //         'myparamtest' => 'Patrick',
    //         'idcart' => $this->context->cart->id,
    //     ]);
    //     return $this->display(__FILE__, 'views/templates/hook/footer.tpl');
    // }

    public function renderWidget($hookName, array $configuration) {
        dump($this->context->link->getModuleLink($this->name, "test"));
    
        if ($hookName === 'displayNavFullWidth') {
            return "Hello this is an exception from the displatNavFullWidth hook";
        }

        if (!$this->isCached($this->templateFile, $this->getCacheId($hookName))) {
            $this->context->smarty->assign($this->getWidgetVariables($hookName, $configuration));
        }
        return $this->fetch('module:mybasicmodule/views/templates/hook/footer.tpl');
    }

    public function getWidgetVariables($hookName, array $configuration) {
        return [
            'myparamtest' => 'Patrick v2',
            'idcart' => $this->context->cart->id,
        ];
    }

    // public function getContent() {
    //     $message = null;

    //     if(Tools::getValue("courserating")) {
    //         Configuration::updateValue('COURSE_RATING', Tools::getValue('courserating'));
    //         $message = "Form saved correctly";
    //     }


    //     $courserating = Configuration::get('COURSE_RATING');
    //     $this->context->smarty->assign([
    //         'courserating' => $courserating,
    //         'message' => $message,
    //     ]);

    //     return $this->fetch('module:mybasicmodule/views/templates/admin/configuration.tpl');
    // }

    public function getContent()
    {
        $output = "";
        if (Tools::isSubmit('submit' . $this->name)) 
        {
            $courserating = Tools::getValue('courserating');
            if($courserating && !empty($courserating) && Validate::isGenericName($courserating)) 
            {
                Configuration::updateValue('COURSE_RATING', Tools::getValue("courserating"));
                $output .= $this->displayConfirmation($this->l('Form submited successfully'));
            } else {
                $output .= $this->displayError($this->l('Form has not been submited successfully'));
            }
        }
        return $output . $this->displayForm();
    }
    
    public function displayForm()
    {
        $defaultLang = (int )Configuration::get('PS_LANG_DEFAULT');

        $fields[0]['form'] = [
            'legend' => [
                'title' => $this->l('Rating settings'),
            ],
            'input' => [
                [
                    'type' => 'text',
                    'label' => $this->l('Course rating'),
                    'name' => 'courserating',
                    'size' => 20,
                    'required' => true
                ],
            ],
            'submit' => [
                'title' => $this->l('Save'),
                'class' => 'btn btn-primary pull-right'
            ]
        ];

        $helper = new HelperForm();
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;

        $helper->default_form_language = $defaultLang;
        $helper->allow_employee_form_lang = $defaultLang;

        $helper->title = $this->displayName;
        $helper->show_toolbar = true;
        $helper->toolbar_scroll = true;
        $helper->submit_action = 'submit' . $this->name;
        $helper->toolbar_btn = [
            'save' => [
                'desc' => $this->l('Save'),
                'href' => AdminController::$currentIndex . '&configure=' . $this->name . '&save' . $this->name .
                    '&token=' . Tools::getAdminTokenLite('AdminModules'),
            ],
            'back' => [
                'href' => AdminController::$currentIndex . '&token=' . Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->l('Back to list')
            ]
        ];

        $helper->fields_value['courserating'] = Configuration::get('COURSE_RATING');
        return $helper->generateForm($fields);
    }


    public function hookModuleRoutes($params) {
        return [
            'test' => [
                'controller' => 'test',
                'rule' => "fc-test", //nazwa podstrony
                'keywords' => [],
                'params' => [
                    'module' => $this->name,
                    'fc' => 'mybasic',
                    'controller' => 'test',
                ]
            ]
        ];
    }
}
