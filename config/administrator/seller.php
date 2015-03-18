<?php
/**
 * Created by PhpStorm.
 * User: zhoutian
 * Date: 15/3/3
 * Time: 下午9:13
 */
return [

    'title' => '商家列表',
    'single' => '商家',
    'model' => 'Seller',

    'columns' => [
        'id' => [
            'title' => 'ID'
        ],
        'name' => [
            'title' => '名称',
        ],
        'category_path' => [
            'title' => '分类'
        ],
        'phone' => [
            'title' => '手机号码',
        ],
        'type' => [
            'title' => '商家类型',
        ],
        'district_path' => [
            'title' => '地区',
        ],

    ],

    'edit_fields' => [

        'name' => [
            'title' => '名称',
        ],
        'phone' => [
            'title' => '手机号码',
        ],
        'type' => [
            'title' => '商家类型',
        ],

        'type' => [
            'title' => '商家类型',
            'type' => 'enum',
            'options' => [
                '1' => '优惠商家',
                '2' => '长期代理',
            ]
        ],
        'card_type1' => [
            'type' => 'bool',
            'title' => '优惠卡',
        ],
        'card_type2' => [
            'type' => 'bool',
            'title' => '会员卡',
        ],
        'card_type3' => [
            'type' => 'bool',
            'title' => '储值卡',
        ],
        'card_type4' => [
            'type' => 'bool',
            'title' => '代金券',
        ],
        'categories' => [
            'title' => '分类',
            'type' => 'relationship',

            'name_field' => 'path',
            'options_sort_field' => 'lft',
        ],
        'districts' => [
            'title' => '地区',
            'type' => 'relationship',
            'autocomplete' => true,
            'num_options' => 15,
#            'name_field' => 'name',
            'search_fields' => array("CONCAT(name, ' ', initials, ' ', pinyin)"),
        ],
        'district_detail' => [
            'title' => '详细地址',
        ],
        'logo' => [
            'title' => 'logo图',
            'type' => 'image',
            'location' => public_path() . '/uploads/products/originals/',
            'naming' => 'random',
            'length' => 20,
            'size_limit' => 20,
            'sizes' => array(
                //留白，会压缩图片，不变形
                array(270, 150, 'fit', public_path() . '/uploads/products/thumbs/small/', 100),
                array(960, 450, 'fit', public_path() . '/uploads/products/thumbs/mid/', 100),
            )
        ],

        'detail_pre' => [
            'type' => 'wysiwyg',
            'title' => '图片列表',

        ],
        'privilege' => [
            'type' => 'textarea',
            'limit' => '1000',
            'height' => '130',
            'title' => '会员特权',
        ],
        'introduce' => [
            'type' => 'textarea',
            'limit' => '1000',
            'height' => '130',
            'title' => '商家介绍',
        ],
        'services' => [
            'type' => 'textarea',
            'limit' => '1000',
            'height' => '130',
            'title' => '设施服务',
        ],
        'recommend' => [
            'type' => 'bool',
            'title' => '是否首页推荐',
        ],
        'latitude' => [
            'title' => '经度',
        ],
        'longitude' => [
            'title' => '纬度',
        ],
    ],

    'filters' => [
        'id' => [
            'title' => 'User ID',
        ],
        'name' => [
            'title' => '商家名称',
        ],
        'phone' => [
            'title' => '手机号码',
        ],
    ],


    'permission' => function() {
#        return Sentry::hasAccess('users');
        return true;
    },

    'form_width' => 500,
];
