<?php
/**
 * Created by PhpStorm.
 * User: zhoutian
 * Date: 15/2/25
 * Time: 上午11:33
 */

class Product extends \Eloquent {

    protected $table = 'products';
    protected $guarded = [];

    protected $appends = ['detail_pre'];

    public function tags() {
        return $this->belongsToMany('ProductTag', 'product_tags', 'product_id', 'product_tag_id');
    }

//    public function params() {
//        return $this->belongsToMany('ProdcutParam', 'product_product_param', 'product_id', 'product_param_id');
//    }

    public function imgs() {
        return $this->hasMany('ProductImg', 'products_id');
    }

    public function detail() {
        return $this->hasOne('ProductDetail', 'products_id');
    }

    public function categories() {
        return $this->belongsTo('Category', 'category', 'id');
    }

    public function districts() {
        return $this->belongsTo('Weile\OrderedTreeDistrict', 'district', 'id');
    }

    public function getDistrictPathAttribute() {
        return $this->districts->path;
    }

    public function getCategoryPathAttribute() {
        return $this->categories->path;
    }


    public function getDetailPreAttribute() {
        if ($this->detail) {
            return $this->detail->detail;
        }
        return '';
    }

    public function getImgUrlAttribute() {
        if ($this->attributes['image']) {
            return asset('uploads/products/thumbs/small/' . $this->attributes['image']);
        }
        return '';
    }


    public function save(array $options=[]) {
        $value = array_pull($this->attributes, 'detail_pre');
  #      var_dump($value);
        parent::save($options);


        //同步至detail表
        $detail = ProductDetail::firstOrNew(['products_id'=>$this->id]);
        $detail->detail = $value;

        $this->detail()->save($detail);
        //同步附图到imgs表
        preg_match_all('#<img.*src="(.*)"[^>]*>#Uis', $value, $m);

        if (empty($m)) return false;
        $data = [];
        foreach ($m[1] as $item) {
            $path = htmlspecialchars_decode($item);
            $data[] = new ProductImg(['path'=>$path]);
        }
        $this->imgs()->delete();
        $this->imgs()->saveMany($data);

        return true;
    }
}