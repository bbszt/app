<?php
/**
 * Created by PhpStorm.
 * User: zhoutian
 * Date: 15/3/4
 * Time: 下午12:25
 */
return [

    'title' => '代金券列表',
    'single' => '代金券',
    'model' => 'CardVoucher',

    'columns' => [
        'id' => [
            'title' => 'ID'
        ],
        'name' => [
            'title' => '名称',
        ],
        'sellers' => [
            'title' => '所属商家',
            'relationship' => 'seller',
            'select' => 'GROUP_CONCAT((:table).name)',
        ],

    ],

    'edit_fields' => [

        'name' => [
            'title' => '名称',
        ],
        'logo' => [
            'title' => 'logo图',
            'type' => 'image',
            'location' => public_path() . '/uploads/seller/originals/',
            'naming' => 'random',
            'length' => 20,
            'size_limit' => 20,
            'sizes' => array(
                array(65, 57, 'crop', public_path() . '/uploads/seller/thumbs/small/', 100),
                array(220, 138, 'landscape', public_path() . '/uploads/seller/thumbs/medium/', 100),
                array(383, 276, 'fit', public_path() . '/uploads/seller/thumbs/full/', 100)
            )
        ],
        'price' =>[
            'title'=>'价格',
        ],
        'origin_price' =>[
            'title'=>'原价',
        ],
        'deadline' => [
            'title' => '期限描述',
        ],
        'sales_volume' =>[
            'title'=>'销量',
        ],

        'seller' => [
            'title' => '所属商家',
            'type' => 'relationship',
        ],
        'introduce' => [
            'type' => 'textarea',
            'limit' => '1000',
            'height' => '130',
            'title' => '优惠介绍',
        ],
        'instruction' => [
            'type' => 'textarea',
            'limit' => '1000',
            'height' => '130',
            'title' => '使用说明',
        ],
    ],

    'filters' => [
        'id' => [
            'title' => 'User ID',
        ],
        'name' => [
            'title' => '商家名称',
        ],
    ],


    'permission' => function() {
#        return Sentry::hasAccess('users');
        return true;
    },

#    'form_width' => 500,
];
