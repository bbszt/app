<?php
namespace Controllers;


use Weile\Member;
use Weile\OrderedTreeDistrict;

class ApiController extends BaseController {

    protected $input;

    public function __construct() {
        $this->input = \Input::all();
    }

    //登录
    public function getLogin() {
        $data = array_only($this->input, ['phone', 'password']);

        if (\Auth::attempt($data)) {
            return \Auth::user();
#            return 1;
        }
        return 0;
    }

    //注册验证码
    public function getCode() {
        $phone = array_get($this->input, 'phone');
        $code = app('phonecode')->sendCode($phone);
        if($code) {
            return $code;
        }
        else {
            return 0;
        }
    }

    //获取订单详情
    public function getOrderDetail() {
        $uid = \Input::get('uid');
        $order_id = \Input::get('order_id');

        $order = \ProductOrder::with('products')->where('order_id', $order_id)->first();
        if($order == '') {
            return $this->errorMsg();
        }
        $order->district_path = OrderedTreeDistrict::getPathById($order->district);
#        var_dump($order->toArray());
        return $this->successMsg($order->toArray());
    }

    //获取订单列表
    public function getOrderList() {
        $uid = \Input::get('uid');
        $status = \Input::get('status');
        $member = Member::find($uid);

        $orders = $member->orders()->where('status', $status)->with('products')->get();
        if($orders == '') {
            return $this->errorMsg();
        }

#        var_dump($orders->toArray());
#        var_dump($orders['products']->toArray());
        return $this->successMsg($orders->toArray(), '订单列表返回成功！');
    }

    //删除订单
    public function getDeleteOrder() {
        $order_id = \Input::get('order_id');
        $order = \ProductOrder::where('order_id', $order_id)->first();
        //软删除
#        var_dump($order->toArray());
        if($order == null) {
            return $this->errorMsg();
        }
        $order->delete();
        return $this->successMsg([], '取消订单成功！');
    }

    //获取订单数量
    public function getOrderNum() {
        $uid = \Input::get('uid');
        $member = Member::find($uid);

        $orders = $member->orders;

        $data['nopay'] = 0;
        $data['paying'] = 0;
        $data['noship'] = 0;
        $data['norecv'] = 0;
        $data['refund'] = 0;
        $data['finish'] = 0;

        $orders->each(function($row) use(&$data) {
           switch ($row->status) {
               case 0:
                   $data['nopay']++;
                   break;
               case 1:
                   $data['paying']++;
                   break;
               case 2:
                   $data['noship']++;
                   break;
               case 3:
                   $data['norecv']++;
                   break;
               case 4:
                   $data['refund']++;
                   break;
               case 5:
                   $data['finish']++;
                   break;
               default:

           }

        });

        return $this->successMsg($data);

#        var_dump($orders->toArray());


    }
    //创建订单
    public function getMakeOrder() {
        //订单生成,参数有：收货地址ID，产品IDS，用户ID，订单金额，运费，
        $amount = \Input::get('amount');
        $freight = \Input::get('freight');
        $uid = \Input::get('uid');
        $delivery_id = \Input::get('delivery_id');
        $products = unserialize(\Input::get('product_str'));

        $member = Member::find($uid);
        $data['phone'] = $member->phone;
        $data['username'] = $member->username;

#        $fileds = ['amount', 'freight', 'username', 'phone', 'district', 'district_detail'];

        $data['amount'] = $amount;
        $data['freight'] = $freight;
        $data['member_id'] = $uid;
        $data['order_id'] = build_order_no();
        //处理收货信息
        $delivery = $member->delivery()->where('id', $delivery_id)->first();
        if($delivery == null) {
            return $this->errorMsg('没有收货人的相关数据！');
        }
        $data['district'] = $delivery->district;
        $data['district_detail'] = $delivery->detail;


#        var_dump($products);
        //绑定产品与订单的关联
        if(!empty($products)) {
            $products_id = [];
            foreach ($products as $row) {
#            echo $row->id;
                $products_id[$row['id']] = ['num'=>$row['qty']];
            }
#var_dump($products_id);exit;

            $product_order = new \ProductOrder($data);
            $product_order->save();
            $product_order->products()->sync($products_id);

            return $this->successMsg([], '订单创建成功！');
        }
        return $this->errorMsg('没有产品数据，订单创建失败！');
    }

    //重置密码验证码
    //http://weile.app/api/remind-code?phone=18002590105
    public function getRemindCode() {
        $return = [];
        switch ($response = \Phone::remind(\Input::only('phone')))
        {
            case \Phone::INVALID_USER:
                $return['type'] = 0;
                $return['msg'] = '不存在该用户！';
                break;

            case \Phone::REMINDER_SENT:
                $return['type'] = 1;
                $return['msg'] = '验证码发送成功！';
                break;
            default:
                $return['type'] = 0;
                $return['msg'] = '网络异常，请重试！';
        }
        return $return;
    }

    //重置密码
    //http://weile.app/api/reset-password?phone=18002590105&password=111&password_confirmation&token=111
    public function getResetPassword() {
        $return = [];
        $credentials = \Input::only('password', 'token');
        $member = Member::find(\Input::get('uid'));
        if(empty($member)) {
            $return['type'] = 0;
            $return['msg'] = '不存在该用户，重置失败！';
            return $return;
        }
        $credentials['phone'] = $member->phone;
        $credentials['password_confirmation'] = $credentials['password'];

        $response = \Phone::reset($credentials, function($user, $password)
        {
            $user->password = $password;

            $user->save();
        });

        switch ($response)
        {
            case \Phone::INVALID_PASSWORD:
                $return['type'] = 0;
                $return['msg'] = '密码设置不正确，重置失败！';
                break;
            case \Phone::INVALID_TOKEN:
                $return['type'] = 0;
                $return['msg'] = '验证码错误，重置失败！';
                break;
            case \Phone::INVALID_USER:
                $return['type'] = 0;
                $return['msg'] = '不存在该用户，重置失败！';
                break;
            case \Phone::PASSWORD_RESET:
                $return['type'] = 1;
                $return['msg'] = '重置成功！';
                break;
            default:
                $return['type'] = 0;
                $return['msg'] = '重置失败！';
        }
        return $return;
    }
    //http://weile.app/api/new-password?uid=1&password=111&oldpassword=1111
    public function getNewPassword() {
        $return = [];
        $member = Member::find(\Input::get('uid'));
        if(empty($member)) {
            $return['type'] = 0;
            $return['msg'] = '不存在该用户，重置失败！';
            return $return;
        }

        $oldpwd = \Input::get('oldpassword');

        if(! \Hash::check($oldpwd, $member->password)) {
            $return['type'] = 0;
            $return['msg'] = '用户密码错误，重置失败！';
            return $return;
        }

        $member->password = \Input::get('password');
        $member->save();
        $return['type'] = 1;
        $return['msg'] = '设置新密码成功！';
        return $return;

    }

    //注册
    public function getRegister() {
        $return = [];
        $rules = [
            'invite_phone' => 'required|digits:11|exists:members,phone',
            'phone' => 'required|digits:11|unique:members',
            'username' => 'required|min:4|unique:members',
            'password' => 'required|min:6',
            'token' => 'required|digits:4',
        ];
        $validator = \Validator::make(\Input::all(), $rules);
        if($validator->fails()) {
            $return['type'] = 0;
            $return['msg'] = $validator->messages();
            return $return;
        }

        //手机验证码
        $phonecode = app('phonecode');

        if (!$phonecode->validate(\Input::get('phone'), \Input::get('token'))) {
            $return['type'] = 0;
            $return['msg'] = '验证码错误！';
            return $return;
        }

        $m = app('Weile\Repositories\MemberRepositoryInterface');
        if ($user = $m->create(\Input::all())) {
            $return['type'] = 1;
            $return['msg'] = '注册成功！';
            return $return;
        }
        return $return;
    }

    public function getMemberBankcardList() {
        $uid = \Input::get('uid');
        $member = \Weile\Member::find($uid);
        $cardList = $member->bankcard;
        $cardList = $cardList->each(function($card) {
            $card['bank'] = \BankInfo::find($card['bank_id'], ['id','name'])->toArray();
            $card['district_info'] = OrderedTreeDistrict::find($card['district'], ['id', 'name'])->toArray();
        });

        if($cardList) {
            return ['type'=> 1, 'data'=>$cardList->toArray(), 'msg'=>'数据获取成功'];
        }
        else {
            return ['type' => 0, 'msg' => '没有信用卡数据'];
        }
    }

    public function getAddBankcard() {
        $data = \Input::all();
        $uid = array_pull($data, 'uid');
        $member = \Weile\Member::find($uid);
        if($member == null) {
            return $this->errorMsg('不存在该用户');
        }

        $fields = array_only($data, ['username', 'card_number', 'bank_id', 'district', 'district_detail']);
        $de = new \Weile\MemberBankcard($fields);
        $member->bankcard()->save($de);

        return $this->successMsg([], '添加银行卡成功');
    }

    public function getSupportBankList() {
        $data = \BankInfo::all()->toArray();
        return $this->successMsg($data, '获取成功');
    }

    public function getDeleteBankcard() {
        $data = \Input::all();
        $uid = array_pull($data, 'uid');
        $member = \Weile\Member::find($uid);
        if($member == null) {
            return $this->errorMsg('不存在该用户');
        }

        $card_ida = explode(',', $data['card_ids']);

        $card = $member->bankcard()->whereIn('id', $card_ida);
#        var_dump($card->toArray());
        $card->delete();
        return $this->successMsg([], '解除绑定成功');

    }

    protected function errorMsg($msg='没有数据') {
        return ['type'=>0, 'msg'=>$msg];
    }

    protected function successMsg($data = [], $msg='请求成功') {
        return ['type'=>1, 'msg'=>$msg, 'data'=>$data];
    }


    public function products() {
        $products = app('Weile\Repositories\ProductRepositoryInterface');
        $product_list = $products->findAllPaginated(3);
        return $product_list;


    }

    public function category($id) {
        $id = intval($id);
        if($id <= 0) {
            $data =  \Category::roots()->get();
        }
        else {
            $data = \Category::find($id)->children()->get();
        }

        return $data->toJson();
    }





}
