<?php

namespace Api\Validator;

use Main\Validator\BaseValidator;

class Comment extends BaseValidator
{
    /**
     * @var array
     */
    protected $filters = [
        'user_name' => [
            'trimFilter',
            'stripSlashesFilter',
            'stripTags',
        ],
        'content' => [
            'trimFilter',
            'stripSlashesFilter',
            'stripTags',
        ],
    ];

    protected $validators = [
        'user_name' => [
            [
                'name' => 'notEmptyValidator',
                'message' => 'Поле не может быть пустым'
            ],
            [
                'name' => 'stringLengthValidator',
                'min' => 0,
                'max' => 255,
                'message' => 'Длина должна быть от 0 до 255 символов'
            ],
        ],
        'content' => array(
            [
                'name' => 'notEmptyValidator',
                'message' => 'Поле не может быть пустым'
            ],
            [
                'name' => 'stringLengthValidator',
                'min' => 0,
                'max' => 1000,
                'message' => 'Длина должна быть от 0 до 1000 символов'
            ],
        ),
    ];
}