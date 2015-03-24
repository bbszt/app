<?php
/**
 * Created by PhpStorm.
 * User: zhoutian
 * Date: 15/3/3
 * Time: 下午9:16
 */



class Seller extends \Eloquent {

    protected $table = 'seller';

    protected $guarded = [];

    protected $appends = ['detail_pre', 'card_type1', 'card_type2','card_type3', 'card_type4'];

    public function districts() {
        return $this->belongsTo('Weile\OrderedTreeDistrict', 'district', 'id');
    }

    public function detail() {
        return $this->hasOne('SellerDetail', 'seller_id');
    }

    public function imgs() {
        return $this->hasMany('SellerImg', 'seller_id');
    }
    //储值卡
    public function cardstored() {
        return $this->hasMany('CardStored', 'seller_id');
    }
    //会员卡
    public function cardvip() {
        return $this->hasMany('CardVip', 'seller_id');
    }
    //代金券
    public function cardvoucher() {
        return $this->hasMany('CardVoucher', 'seller_id');
    }
    //优惠卡
    public function cardcoupon() {
        return $this->hasMany('CardCoupon', 'seller_id');
    }

    public function getDistrictPathAttribute() {
        return \Weile\OrderedTreeDistrict::getPathById($this->district);
    }

    public function categories() {
        return $this->belongsTo('SellerCategory', 'category', 'id');
    }

    public function getCategoryPathAttribute() {
        return $this->categories->path;
    }

    public function getMidImgUrlAttribute() {
        if ($this->attributes['logo']) {
            return asset('uploads/products/thumbs/mid/' . $this->attributes['logo']);
        }
        return '';
    }
    public function getImgUrlAttribute() {
        if ($this->attributes['logo']) {
            return asset('uploads/products/thumbs/small/' . $this->attributes['logo']);
        }
        return '';
    }
    public function getTypeAttribute($type) {
        $return = '';
        switch($type) {
            case "1":
                $return = "优惠商家";
                break;
            case "2":
                $return = "长期代理";
                break;
        }
        return $return;
    }

    public function setTypeAttribute($value) {
        switch($value) {
            case "优惠商家":
                $this->attributes['type'] = 1;
                break;
            case "长期代理":
                $this->attributes['type'] = 2;
                break;
        }
    }
    public function getDetailPreAttribute() {
        if ($this->detail) {
            return $this->detail->detail;
        }
        return '';
    }

    //优惠卡
    public function getCardType1Attribute() {
        $card_type = $this->card_type;
        return ($card_type&1)>0;
    }
    //会员卡
    public function getCardType2Attribute() {
        $card_type = $this->card_type;
        return ($card_type&2)>0;
    }
    //储值卡
    public function getCardType3Attribute() {
        $card_type = $this->card_type;
        return ($card_type&4)>0;
    }
    //代金券
    public function getCardType4Attribute() {
        $card_type = $this->card_type;
        return ($card_type&8)>0;
    }

    public function save(array $options=[]) {
        /*
        'before_save' => function(&$data) {
            return 'sorry';
            $data['type'] = 2;
            $data['card_type'] = $data['card_type1']&$data['card_type2']&$data['card_type3']&$data['card_type4'];
            unset($data['card_type1'],$data['card_type2'],$data['card_type3'],$data['card_type4']);
        },
        */
        $card_type1 = Input::get('card_type1')=='true'?1:0;
        $card_type2 = Input::get('card_type2')=='true'?2:0;
        $card_type3 = Input::get('card_type3')=='true'?4:0;
        $card_type4 = Input::get('card_type4')=='true'?8:0;
        $card_type = $card_type1|$card_type2|$card_type3|$card_type4;
        array_pull($this->attributes, 'card_type1')&array_pull($this->attributes, 'card_type2')&array_pull($this->attributes, 'card_type3')&array_pull($this->attributes, 'card_type4');

        $this->attributes['card_type'] = $card_type;
#        var_dump(Input::get('card_type1'));
#        echo $card_type1.$card_type2.$card_type3.$card_type4;
#        echo $card_type.'-'.$card_type1.'-'.$card_type2;
#        echo $card_type;
#        exit;
        $x = $this->attributes['latitude'];
        $y = $this->attributes['longitude'];
        $coordToGeohash = \Geotools::coordinate([$x,$y]);

// encoding
        $encoded = \Geotools::geohash()->encode($coordToGeohash, 6); // 12 is the default length / precision
// encoded
//        printf("%s\n", $encoded->getGeohash()); // spey
        $this->attributes['geohash'] = $encoded->getGeohash();
        $value = array_pull($this->attributes, 'detail_pre');
        #      var_dump($value);
        parent::save($options);

        //同步至detail表
        $detail = SellerDetail::firstOrNew(['seller_id'=>$this->id]);
        $detail->detail = $value;

        $this->detail()->save($detail);
        //同步附图到imgs表
        preg_match_all('#<img.*src="(.*)"[^>]*>#Uis', $value, $m);

        if (empty($m)) return false;
        $data = [];
        foreach ($m[1] as $item) {
            $path = htmlspecialchars_decode($item);
            $data[] = new SellerImg(['path'=>$path]);
        }
        $this->imgs()->delete();
        $this->imgs()->saveMany($data);

        return true;
    }

    public function newCollection(array $models = array())
    {
        return new \Weile\SellerCollection($models);
    }

}