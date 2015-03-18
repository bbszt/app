<?php

return [

    'title' => '广告列表',
    'single' => '广告',
    'model' => 'Advertise',

    'columns' => [
        'id' => [
            'title' => 'ID',
        ],
        'company_name' => [
            'title' => '所属公司',
            'relationship' => 'company',
            'select' => '(:table).name',
        ],
        'introduce' => [
            'title' => '广告说明'
        ],
    ],

    'edit_fields' => [

        'logo' => [
            'title' => '主图',
            'type' => 'image',
            'location' => public_path() . '/uploads/products/originals/',
            'naming' => 'random',
            'length' => 20,
            'size_limit' => 20,
            'sizes' => array(
                //强制匹配尺寸,图片变形
                array(960, 300, 'exact', public_path() . '/uploads/products/thumbs/small/', 100),
                array(960, 450, 'exact', public_path() . '/uploads/products/thumbs/mid/', 100),
            )
        ],

        'tags' => [
            'title' => '关联标签',
            'type' => 'relationship',
        ],
        'introduce' => [
            'title' => '广告说明',
            'type' => 'textarea',
            'limit' => '1000',
            'height' => '130',
        ],

        'company' => [
            'type' => 'relationship',
            'title' => '所属公司',
        ],
        'detail' => [
            'type' => 'wysiwyg',
            'title' => '图文详情',
        ],
        'recommend' => [
            'type' => 'bool',
            'title' => '是否首页推荐',
        ],
        'url' => [
            'title' => 'WEB链接',
        ]


    ],

    'filters' => [
    ],

    'permission' => function() {
#        return Sentry::hasAccess('product_tags');
        return true;
    },

    'form_width' => 500,
];
