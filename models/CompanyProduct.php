<?php
/**
 * Created by PhpStorm.
 * User: zhoutian
 * Date: 15/2/25
 * Time: 上午11:33
 */

class CompanyProduct extends \Eloquent {

    protected $table = 'company_product';
    protected $guarded = [];

    protected $appends = ['detail_pre'];


    public function imgs() {
        return $this->hasMany('CompanyProductImg', 'product_id');
    }

    public function detail() {
        return $this->hasOne('CompanyProductDetail', 'product_id');
    }

    public function categories() {
        return $this->belongsTo('CompanyCategory', 'category', 'id');
    }
    public function companies() {
        return $this->belongsTo('Company', 'company_id', 'id');
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
#        $recommend = Input::get('recommend')=='true'?1:0;
#        $advertise = Input::get('advertise')=='true'?1:0;
#        $this->attributes['recommend'] = $recommend;
#        $this->attributes['advertise'] = $advertise;
#        var_dump($recommend, $advertise);exit;
        parent::save($options);


        //同步至detail表
        $detail = CompanyProductDetail::firstOrNew(['product_id'=>$this->id]);
        $detail->detail = $value;

        $this->detail()->save($detail);
        //同步附图到imgs表
        preg_match_all('#<img.*src="(.*)"[^>]*>#Uis', $value, $m);

        if (empty($m)) return false;
        $data = [];
        foreach ($m[1] as $item) {
            $path = htmlspecialchars_decode($item);
            $data[] = new CompanyProductImg(['path'=>$path]);
        }
        $this->imgs()->delete();
        $this->imgs()->saveMany($data);

        return true;
    }
}