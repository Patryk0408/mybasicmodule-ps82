<?php

class Comment extends ObjectModel {
    public $id;
    public $user_id;
    public $comment;

    public static $definition = [
        'table' => 'testcomment',
        'primary' => 'id',
        'multilang' => false,
        'fields' => [
            'user_id' => [
                'type' => self::TYPE_STRING, 
                'size' => 255, 
                'validate' => 'isCleanHtml',
                'required' => true
            ],
            'comment' => [
                'type' => self::TYPE_STRING, 
                'size' => 255, 
                'validate' => 'isCleanHtml',
                'required' => true
            ],
        ]
    ];
}