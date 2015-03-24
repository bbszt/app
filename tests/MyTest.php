<?php
/**
 * Created by PhpStorm.
 * User: zhoutian
 * Date: 15/3/16
 * Time: 下午4:55
 */



class MyTest extends TestCase {

    protected $member;

    public function atestCreateBankcard() {
        $bank_id = DB::table('bank_info')->where('id', 1)->pluck('id');
        $data['bank_id'] = $bank_id;
        $data['card_number'] = '888888888888888';
        $data['username'] = '周添';
        $data['district'] = 1;
        $data['district_detail'] = '深圳沙嘴村金沙支行';


        $response = $this->call('POST', 'member/bankcard', $data);

        $view = $response->original;

        $this->assertEquals('1', $view['type']);
    }

    public function atestSetDefaultBankcard() {
        $card = $this->member->bankcard->find(1);
        $id = $card->id;
        $data['id'] = $id;
#        var_dump($data);

        $response = $this->call('GET', 'member/bankcard/default/'.$id);
        $view = $response->original;
        $this->assertEquals('1', $view['type']);
    }

    public function atestUpdateBankcard() {
        $card = $this->member->bankcard->find(1);
        $id = $card->id;

        $data['bank_id'] = 2;
        $data['card_number'] = '888888888888888';
        $data['username'] = '周添';
        $data['district'] = 4;
        $data['district_detail'] = '深圳沙嘴村金沙支行';

        $response = $this->call('PUT', 'member/bankcard/'.$id, $data);
        $view = $response->original;
        $this->assertEquals('1', $view['type']);
    }

    public function atestApiMemberBankcardList() {
        $uid = $this->member->id;
        $data['uid'] = $uid;
        $response = $this->call('GET', 'api/member-bankcard-list', $data);
        $view = $response->original;
        $this->assertEquals('1', $view['type']);
    }

    public function atestApiAddBankcard() {
        $uid = $this->member->id;
        $data['uid'] = $uid;
        $data['bank_id'] = 1;
        $data['card_number'] = '888888888888888';
        $data['username'] = '周添';
        $data['district'] = 1;
        $data['district_detail'] = '深圳沙嘴村金沙支行';
        $response = $this->call('GET', 'api/add-bankcard', $data);
        $view = $response->original;
        $this->assertEquals('1', $view['type']);
    }

    public function atestApiDeleteBankcard() {
        $uid = $this->member->id;
        $data['uid'] = $uid;
        $data['card_ids'] = '8,9';

        $response = $this->call('GET', 'api/delete-bankcard', $data);
        $view = $response->original;
#        var_dump($view);
        $this->assertEquals('1', $view['type']);

    }

    public function atestApiGetSupportBankList() {
        $response = $this->call('GET', 'api/support-bank-list');
        $view = $response->original;
#        var_dump($view);
        $this->assertEquals('1', $view['type']);
    }

    //创建订单
    public function atestMakeOrder() {
        $uid = $this->member->id;
        $data['amount'] = 29.99;
        $data['freight'] = 12.22;
        $data['uid'] = $uid;
        $data['delivery_id'] = 12;
        $products = [['id'=>1, 'qty'=>2], ['id'=>2, 'qty'=>1]];
        $data['product_str'] = serialize($products);

        $response = $this->call('GET', 'api/make-order', $data);
        $view = $response->original;

#        var_dump($view);
        $this->assertEquals('1', $view['type']);


    }

    public function atestOrderNum() {
        $uid = $this->member->id;
        $data['uid'] = $uid;

        $response = $this->call('GET', 'api/order-num', $data);
        $view = $response->original;
#        var_dump($view);

        $this->assertEquals('1', $view['type']);
    }

    public function atestDeleteOrder() {
        $order_id = '2015032301383';
        $data['order_id'] = $order_id;

        $response = $this->call('GET', 'api/delete-order', $data);
        $view = $response->original;
#        var_dump($view);
        $this->assertEquals('1', $view['type']);
    }

    //获取订单详情
    public function testGetOrderDetail() {
        $order_id = '2015022807481';
        $data['order_id'] = $order_id;

        $response = $this->call('GET', 'api/order-detail', $data);
        $view = $response->original;
#        var_dump($view);
        $this->assertEquals('1', $view['type']);

    }

    //获取订单列表
    public function atestGetOrderList() {
        $uid = $this->member->id;
        $status = 3;
        $data['uid'] = $uid;
        $data['status'] = $status;

        $response = $this->call('GET', 'api/order-list', $data);
        $view = $response->original;
#        var_dump($view);
        $this->assertEquals('1', $view['type']);
    }

    public function setUp() {
        parent::setUp();
        $member = \Weile\Member::where('phone','18002590105')->first();
        $this->member = $member;
        $this->be($member);
    }

}