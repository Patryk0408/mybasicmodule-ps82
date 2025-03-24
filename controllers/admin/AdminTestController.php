<?php 

require_once _PS_MODULE_DIR_ . 'mybasicmodule/classes/Comment.php';

class AdminTestController extends ModuleAdminController {
    // public function initContent() {
    //     parent::initContent();
    //     $content = "hello world";
    //     $this->context->smarty->assign(
    //         [
    //             'content' => $this->content . $content,
    //         ]
    //         );
    // }

    public function __construct() 
    {
        $this->table = 'testcomment';
        $this->className = 'Comment';
        $this->identifier = Comment::$definition['primary'];
        $this->bootstrap = true;
        
        $this->fields_list = [
            'id' => [
                'title' => 'The id',
                'align' => 'left'
            ],
            'user_id' => [
                'title' => 'The user id',
                'align' => 'left'
            ],
            'comment' => [
                'title' => 'The comment',
                'align' => 'left'
            ],
        ];

        $this->addRowAction('edit');
        $this->addRowAction('delete');
        $this->addRowAction('view');
        parent::__construct();
    }

    public function renderForm() {
        $this->fields_form = [
            'legend' => [
                'title' => 'New comment',
                'icon' => 'icon-comment'
            ],
            'input' => [
                [
                    'type' => 'text',
                    'label' => 'The User',
                    'name' => 'user_id',
                    'class' => 'input',
                    'required' => true,
                    'empty_message' => 'Please enter the ID'
                ],
                [
                    'type' => 'text',
                    'label' => 'The comment',
                    'name' => 'comment',
                    'class' => 'input',
                    'required' => true,
                    'empty_message' => 'Please enter the comment'
                ]
            ],
            'submit' => [
                    'title' => 'Submit the comment',
                    'class' => 'btn btn-primary pull-right'
            ]
        ];

        return parent::renderForm();
    }

    public function renderView()
    {
        $tplFile = dirname(__FILE__) . '/../../views/templates/admin/view.tpl';
        $tpl = $this->context->smarty->createTemplate($tplFile);

        $sql = new DbQuery();
        $sql->select('*')
            ->from($this->table)
            ->where('id = ' . Tools::getValue('id'));

        $data = Db::getInstance()->executeS($sql);
        print_r($data);
        $tpl->assign ([
            'data' => $data[0],
        ]);
        return $tpl -> fetch();
    }
}