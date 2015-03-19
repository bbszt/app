<?php

return [

    'title' => '产品列表',
    'single' => '产品',
    'model' => 'Product',

    'columns' => [
        'id' => [
            'title' => 'ID',
        ],
        'name' => [
            'title' => '名称'
        ],
        'price' => [
            'title' => '单价',
        ],
        'sales_volume' => [
            'title' => '销量',
        ],

        'category_path' => [
            'title' => '分类'

        ],
        'district_path' => [
            'title' => '原产地'
        ],
        'rank' => [
            'title' => '综合排名'
        ],
        'evaluation' => [
            'title' => '好评分'
        ],
        'created_at' => [
            'title' => '创建时间',
        ],
    ],

    'edit_fields' => [

        'name' => [
            'title' => '名称'
        ],
        'price' => [
            'type' => 'number',
            'decimals' => 2,
            'title' => '单价',
        ],
        'market_price' => [
            'type' => 'number',
            'decimals' => 2,
            'title' => '市场价',
        ],
        'sales_volume' => [
            'title' => '销量',
        ],
        'freight' => [
            'type' => 'number',
            'decimals' => 2,
            'title' => '运费',
        ],
        'categories' => [
            'title' => '分类',
            'type' => 'relationship',

            'name_field' => 'path',
            'options_sort_field' => 'lft',
        ],
        'districts' => [
            'title' => '原产地',
            'type' => 'relationship',
            'autocomplete' => true,
            'num_options' => 15,
#            'name_field' => 'name',
            'search_fields' => array("CONCAT(name, ' ', initials, ' ', pinyin)"),
        ],
        'rank' => [
            'title' => '综合排名'
        ],
        'evaluation' => [
            'title' => '好评分'
        ],

        'image' => [
            'title' => '主图',
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

        'description' => [
            'type' => 'textarea',
            'limit' => '1000',
            'height' => '130',
            'title' => '商家介绍',
        ],
        'activities_introduce' => [
            'type' => 'textarea',
            'limit' => '1000',
            'height' => '130',
            'title' => '优惠活动',
        ],
        'params' => [
            'type' => 'textarea',
            'limit' => '1000',
            'height' => '130',
            'title' => '参数规格',
        ],

        'detail_pre' => [
            'type' => 'wysiwyg',
            'title' => '图文详情',

        ],
        /*`
        'description' => array(
            'title' => 'Image',
            'type' => 'image',
            'location' => public_path() . '/uploads/products/originals/',
            'naming' => 'random',
            'length' => 20,
            'size_limit' => 2,
            'sizes' => array(
                array(65, 57, 'crop', public_path() . '/uploads/products/thumbs/small/', 100),
                array(220, 138, 'landscape', public_path() . '/uploads/products/thumbs/medium/', 100),
                array(383, 276, 'fit', public_path() . '/uploads/products/thumbs/full/', 100)
            )
        ),
        */
    ],


    'filters' => [
        'id' => [
            'title' => 'ID',
        ],
        'name' => [
            'title' => '商品名称',
        ],
    ],

    'permission' => function() {
#        return Sentry::hasAccess('products');
        return true;
    },

    /*
    'rules' => array(
        'name' => 'required|max:255',
        'params' => 'required|max:255',
        'price' => 'required|integer',
        'image' => 'required',
        'market_price' => 'required|integer',
        'freight' => 'integer',
        'category' => 'required',
        'district' => 'required',
        'description' => 'required',
        'activities_introduce' => 'required',
    ),
    */

    'form_width' => 500,

];
